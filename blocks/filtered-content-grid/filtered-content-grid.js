(function () {
	"use strict";

	const ROOT_SELECTOR = "[data-fu-filtered-content-grid]";
	const LOADING_UI_DELAY = 140;
	const TRANSITION_CLEANUP_DELAY = 850;
	const observedDocuments = new WeakSet();
	let alpineReadyListenerBound = false;
	const acfApi =
		typeof window !== "undefined" && typeof window.acf !== "undefined"
			? window.acf
			: null;
	const DEFAULTS = {
		endpoint: "",
		taxonomy: "",
		itemCount: 12,
		showExcerpt: true,
		ctaLabel: "View Item",
		emptyMessage: "No items found.",
		transitionScope: "fu-filtered-content-grid",
		allLabel: "All",
	};

	const parseConfig = (root) => {
		const raw = root.getAttribute("data-fu-filtered-config");

		if (!raw) {
			return { ...DEFAULTS };
		}

		try {
			return { ...DEFAULTS, ...JSON.parse(raw) };
		} catch (error) {
			console.error("Filtered Content Grid config could not be parsed.", error);
			return { ...DEFAULTS };
		}
	};

	const getEditorDocuments = () => {
		const docs = [document];
		const iframe = document.querySelector('iframe[name="editor-canvas"]');

		if (iframe?.contentDocument && !docs.includes(iframe.contentDocument)) {
			docs.unshift(iframe.contentDocument);
		}

		return docs;
	};

	const isEditorDocument = (targetDocument) => {
		if (!targetDocument) {
			return false;
		}

		if (targetDocument.body?.classList?.contains("block-editor-iframe__body")) {
			return true;
		}

		return acfApi !== null || typeof wp !== "undefined";
	};

	const escapeHtml = (value) =>
		String(value ?? "")
			.replace(/&/g, "&amp;")
			.replace(/</g, "&lt;")
			.replace(/>/g, "&gt;")
			.replace(/\"/g, "&quot;")
			.replace(/'/g, "&#039;");

	const stripHtml = (value) => {
		const template = document.createElement("template");
		template.innerHTML = String(value ?? "");
		return (template.content.textContent || "").trim();
	};

	const normalizeBoolean = (value, fallback = true) => {
		if (value === undefined || value === null || value === "") {
			return fallback;
		}

		if (typeof value === "boolean") {
			return value;
		}

		if (typeof value === "number") {
			return value !== 0;
		}

		if (typeof value === "string") {
			const normalized = value.trim().toLowerCase();

			if (["0", "false", "off", "no"].includes(normalized)) {
				return false;
			}

			if (["1", "true", "on", "yes"].includes(normalized)) {
				return true;
			}
		}

		return Boolean(value);
	};

	const normalizeCount = (value) => {
		const parsed = Number.parseInt(value, 10);

		if (!Number.isFinite(parsed) || parsed < 1) {
			return DEFAULTS.itemCount;
		}

		return Math.min(parsed, 50);
	};

	const getImageData = (post) => {
		const media = post?._embedded?.["wp:featuredmedia"]?.[0];

		if (!media) {
			return {
				src: "",
				alt: "",
			};
		}

		const src =
			media?.media_details?.sizes?.large?.source_url ||
			media?.media_details?.sizes?.medium_large?.source_url ||
			media?.source_url ||
			"";

		return {
			src,
			alt: media?.alt_text || stripHtml(post?.title?.rendered || ""),
		};
	};

	const mapPost = (post) => {
		const image = getImageData(post);

		return {
			id: post?.id,
			title: stripHtml(post?.title?.rendered || ""),
			excerpt: stripHtml(post?.excerpt?.rendered || ""),
			link: post?.link || "#",
			image,
		};
	};

	const renderCard = (item, index, config) => {
		const imageMarkup = item.image.src
			? `<img class="fu-filtered-content-grid__image-media" src="${escapeHtml(
					item.image.src
			  )}" alt="${escapeHtml(item.image.alt)}" loading="lazy">`
			: '<div class="fu-filtered-content-grid__image-placeholder" aria-hidden="true"></div>';

		const excerptMarkup =
			config.showExcerpt && item.excerpt
				? `<div class="fu-filtered-content-grid__excerpt"><p>${escapeHtml(
						item.excerpt
				  )}</p></div>`
				: "";

		return `
			<article class="fu-filtered-content-grid__card" style="--fu-filtered-index: ${index}; view-transition-name: ${escapeHtml(
			`${config.transitionScope}-card-${item.id}`
		)};">
				<a class="fu-filtered-content-grid__image-link" href="${escapeHtml(item.link)}">
					<div class="fu-filtered-content-grid__image-wrap">
						${imageMarkup}
					</div>
				</a>
				<div class="fu-filtered-content-grid__content">
					<h3 class="fu-filtered-content-grid__title">
						<a href="${escapeHtml(item.link)}">${escapeHtml(item.title)}</a>
					</h3>
					${excerptMarkup}
					<a class="fu-filtered-content-grid__cta" href="${escapeHtml(
						item.link
					)}">${escapeHtml(config.ctaLabel)}</a>
				</div>
			</article>
		`;
	};

	const renderEmptyState = (message) => `
		<div class="fu-filtered-content-grid__empty-state">
			<p>${escapeHtml(message)}</p>
		</div>
	`;

	const runDomUpdate = (root, callback) => {
		if (!root?.isConnected) {
			return;
		}

		const targetDocument = root.ownerDocument || document;
		const canUseViewTransitions =
			typeof targetDocument.startViewTransition === "function" &&
			!isEditorDocument(targetDocument);

		if (canUseViewTransitions) {
			targetDocument.startViewTransition(callback);
			return;
		}

		callback();
	};

	const getInitialStatusMessage = (root, config) => {
		if (!root) {
			return "";
		}

		return root.querySelector(".fu-filtered-content-grid__empty-state")
			? config.emptyMessage
			: "";
	};

	const initAlpineTree = (root) => {
		if (!root || root._x_dataStack || !window.Alpine) {
			return;
		}

		if (typeof window.Alpine.initTree === "function") {
			window.Alpine.initTree(root);
		}
	};

	const bindAlpineReadyListener = () => {
		if (alpineReadyListenerBound || typeof document === "undefined") {
			return;
		}

		alpineReadyListenerBound = true;
		document.addEventListener(
			"alpine:initialized",
			() => {
				requestAnimationFrame(setupDocuments);
			},
			{ once: true }
		);
	};

	window.fuFilteredContentGridFactory = function () {
		return {
			activeTerm: 0,
			loading: false,
			loadingVisible: false,
			isSwapping: false,
			requestId: 0,
			rootEl: null,
			loadingUiTimer: null,
			transitionCleanupTimer: null,
			config: { ...DEFAULTS },

			init() {
				this.rootEl = this.$root || this.$el;
				const parsedConfig = parseConfig(this.rootEl);
				const activeButton = this.rootEl.querySelector(
					"[data-filter-term].is-active"
				);
				const activeTerm = Number.parseInt(
					activeButton?.getAttribute("data-filter-term") || "0",
					10
				);

				this.config = {
					...this.config,
					...parsedConfig,
					itemCount: normalizeCount(parsedConfig.itemCount),
					showExcerpt: normalizeBoolean(parsedConfig.showExcerpt, true),
				};
				this.activeTerm = Number.isFinite(activeTerm) ? activeTerm : 0;
				this.loading = false;
				this.loadingVisible = false;
				this.isSwapping = false;

				this.syncStatus(getInitialStatusMessage(this.rootEl, this.config));
				this.syncLoadingState();
			},

			clearLoadingUiDelay() {
				if (this.loadingUiTimer) {
					window.clearTimeout(this.loadingUiTimer);
					this.loadingUiTimer = null;
				}
			},

			scheduleLoadingUi() {
				this.clearLoadingUiDelay();
				this.loadingVisible = false;
				this.loadingUiTimer = window.setTimeout(() => {
					this.loadingUiTimer = null;
					if (!this.loading) {
						return;
					}

					this.loadingVisible = true;
					this.syncLoadingState();
				}, LOADING_UI_DELAY);
			},

			finishLoadingState() {
				this.clearLoadingUiDelay();
				this.loading = false;
				this.loadingVisible = false;
				this.syncLoadingState();
			},

			clearTransitionCleanup() {
				if (this.transitionCleanupTimer) {
					window.clearTimeout(this.transitionCleanupTimer);
					this.transitionCleanupTimer = null;
				}
			},

			setTransitioningState(isActive) {
				if (!this.rootEl) {
					return;
				}

				this.rootEl.classList.toggle("is-transitioning", isActive);
			},

			scheduleTransitionCleanup() {
				this.clearTransitionCleanup();
				this.transitionCleanupTimer = window.setTimeout(() => {
					this.transitionCleanupTimer = null;
					this.setTransitioningState(false);
				}, TRANSITION_CLEANUP_DELAY);
			},

			syncStatus(message) {
				const status = this.rootEl?.querySelector("[data-grid-status]");

				if (status) {
					status.textContent = message;
				}
			},

			syncLoadingState() {
				const results = this.rootEl?.querySelector("[data-grid-results]");
				const buttons =
					this.rootEl?.querySelectorAll("[data-filter-term]") || [];

				if (results) {
					results.classList.toggle("is-loading", this.loadingVisible);
					results.classList.toggle("is-swapping", this.isSwapping);
					results.setAttribute("aria-busy", this.loading ? "true" : "false");
				}

				buttons.forEach((button) => {
					const termId = Number.parseInt(
						button.getAttribute("data-filter-term") || "0",
						10
					);
					const isActive = this.activeTerm === termId;

					button.classList.toggle("is-active", isActive);
					button.disabled = this.loading;
					button.setAttribute("aria-pressed", isActive ? "true" : "false");
				});
			},

			buildUrl(termId) {
				const url = new URL(this.config.endpoint, window.location.origin);
				url.searchParams.set("per_page", String(this.config.itemCount));
				url.searchParams.set("_embed", "wp:featuredmedia");

				if (termId > 0 && this.config.taxonomy) {
					url.searchParams.set(this.config.taxonomy, String(termId));
				}

				return url.toString();
			},

			async filter(termId) {
				if (
					this.loading ||
					termId === this.activeTerm ||
					!this.config.endpoint
				) {
					return;
				}

				const isEditorPreview = isEditorDocument(this.rootEl?.ownerDocument);
				this.activeTerm = termId;

				if (isEditorPreview) {
					this.finishLoadingState();
					this.syncStatus("");
					return;
				}

				this.loading = true;
				this.isSwapping = true;
				this.requestId += 1;
				const requestId = this.requestId;
				this.scheduleLoadingUi();
				this.syncLoadingState();

				try {
					const response = await window.fetch(this.buildUrl(termId), {
						credentials: "same-origin",
						headers: {
							Accept: "application/json",
						},
					});

					if (!response.ok) {
						throw new Error(`Request failed with status ${response.status}`);
					}

					const items = (await response.json()).map(mapPost);

					console.log("[Filtered Content Grid] REST result", {
						termId,
						url: this.buildUrl(termId),
						itemCount: items.length,
						titles: items.map((item) => item.title),
					});

					if (requestId !== this.requestId || !this.rootEl?.isConnected) {
						this.clearLoadingUiDelay();
						return;
					}

					const markup = items.length
						? items
								.map((item, index) => renderCard(item, index, this.config))
								.join("")
						: renderEmptyState(this.config.emptyMessage);

					const updateMarkup = () => {
						const results = this.rootEl?.querySelector("[data-grid-results]");

						console.log("[Filtered Content Grid] DOM update", {
							termId,
							count: items.length,
							hasResultsEl: !!results,
						});

						if (results) {
							results.innerHTML = markup;
						}

						this.clearLoadingUiDelay();
						this.loadingVisible = false;
						this.loading = false;
						this.syncStatus(items.length ? "" : this.config.emptyMessage);
						this.syncLoadingState();
						this.scheduleTransitionCleanup();
					};

					this.setTransitioningState(true);
					runDomUpdate(this.rootEl, updateMarkup);
				} catch (error) {
					if (requestId !== this.requestId || !this.rootEl?.isConnected) {
						this.clearLoadingUiDelay();
						this.clearTransitionCleanup();
						this.setTransitioningState(false);
						return;
					}

					console.error("Filtered Content Grid request failed.", error);
					this.finishLoadingState();
					this.isSwapping = false;
					this.clearTransitionCleanup();
					this.setTransitioningState(false);
					this.syncStatus("Unable to update the grid right now.");
				}
			},
		};
	};

	const wireRoot = (root) => {
		if (!root) {
			return;
		}

		initAlpineTree(root);
	};

	const wireAllRoots = (container = document) => {
		if (!container?.querySelectorAll) {
			return;
		}

		container.querySelectorAll(ROOT_SELECTOR).forEach(wireRoot);
	};

	const observeDocument = (targetDocument) => {
		if (!targetDocument?.body || observedDocuments.has(targetDocument)) {
			return;
		}

		const observer = new MutationObserver((mutations) => {
			mutations.forEach((mutation) => {
				mutation.addedNodes.forEach((node) => {
					if (!(node instanceof HTMLElement)) {
						return;
					}

					if (node.matches?.(ROOT_SELECTOR)) {
						wireRoot(node);
						return;
					}

					wireAllRoots(node);
				});
			});
		});

		observer.observe(targetDocument.body, {
			childList: true,
			subtree: true,
		});

		observedDocuments.add(targetDocument);
	};

	const setupDocuments = () => {
		if (!window.Alpine) {
			bindAlpineReadyListener();
			return;
		}

		getEditorDocuments().forEach((targetDocument) => {
			wireAllRoots(targetDocument);
			observeDocument(targetDocument);
		});
	};

	if (document.readyState === "loading") {
		document.addEventListener("DOMContentLoaded", setupDocuments);
	} else {
		setupDocuments();
	}

	if (typeof acfApi?.addAction === "function") {
		acfApi.addAction("render_block_preview", () => {
			requestAnimationFrame(setupDocuments);
		});
	}
})();
