(function () {
	"use strict";

	const isEditor = typeof wp !== "undefined" && typeof wp.data !== "undefined";
	const CONTROL_FIELD_KEYS = [
		"field_69a0cbde5e878",
		"field_69a0cc145e879",
		"field_69aac0016e7d6",
		"field_69aac03641f86",
		"field_69a8568dfc05a",
		"field_69a0aff91d95d",
		"field_69a314b5e679e",
	];
	const ALIGNMENT_CLASSES = [
		"fu-page-banner--align-left",
		"fu-page-banner--align-center",
		"fu-page-banner--align-right",
	];
	const EDITOR_CONTROL_DEFAULTS = {
		show_subhead: true,
		show_body: true,
		show_btn_1: true,
		show_btn_2: true,
		alignment_buttons: "center",
		pause_blur_intensity: 7,
		bg_focal_point: "center center",
	};
	const BANNER_HEADING_ROLE_CLASSES = [
		"fu-page-banner__primary-heading",
		"fu-page-banner__subhead",
	];
	const HEADING_TEXT_FIELD_SELECTOR =
		'.acf-field[data-key="field_69a187ceabed1"]';

	const normalizeMediaSrc = (value) => {
		if (typeof value !== "string") return "";
		const trimmed = value.trim();
		if (!trimmed || trimmed === "undefined" || trimmed === "null") {
			return "";
		}
		return trimmed;
	};

	const normalizeBooleanValue = (value, fallback = true) => {
		if (value === undefined || value === null || value === "") return fallback;
		if (typeof value === "boolean") return value;
		if (typeof value === "number") return value !== 0;
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

	const getFieldElement = (field) =>
		field?.$el?.get?.(0) || field?.$el?.[0] || null;

	const getClosestBlockElement = (fieldOrElement) => {
		const fieldElement =
			fieldOrElement?.nodeType === 1
				? fieldOrElement
				: getFieldElement(fieldOrElement);

		if (!fieldElement) return null;

		return fieldElement.closest(".block-editor-block-list__block[data-block]");
	};

	const getBlockEditorStore = () => wp?.data?.select?.("core/block-editor");
	const getBlockEditorDispatch = () =>
		wp?.data?.dispatch?.("core/block-editor");

	const getBlockRecord = (clientId) => {
		if (!clientId) return null;

		return getBlockEditorStore()?.getBlock?.(clientId) || null;
	};

	const getBlockParentChain = (clientId) => {
		const store = getBlockEditorStore();
		if (!store?.getBlockParents || !clientId) return [];

		return store.getBlockParents(clientId) || [];
	};

	const isPageBannerHeadingBlock = (clientId) => {
		const blockRecord = getBlockRecord(clientId);
		if (blockRecord?.name !== "acf/fu-heading") return false;

		return getBlockParentChain(clientId).some((parentClientId) => {
			const parentBlock = getBlockRecord(parentClientId);
			return parentBlock?.name === "acf/fu-page-banner";
		});
	};

	const getHeadingRole = (fieldOrElement) => {
		const blockElement = getClosestBlockElement(fieldOrElement);
		const selectedClientId =
			getBlockEditorStore()?.getSelectedBlockClientId?.();
		const clientId = blockElement?.dataset?.block || selectedClientId;

		if (!isPageBannerHeadingBlock(clientId)) {
			return null;
		}

		if (clientId) {
			const blockRecord = getBlockRecord(clientId);
			const className = String(blockRecord?.attributes?.className || "");

			if (className.includes("fu-page-banner__subhead")) {
				return "subhead";
			}

			if (className.includes("fu-page-banner__primary-heading")) {
				return "primary";
			}
		}

		return "primary";
	};

	const normalizeClassName = (className) =>
		String(className || "")
			.split(/\s+/)
			.map((token) => token.trim())
			.filter(Boolean);

	const getMigratedHeadingClassName = (className, expectedClassName) => {
		const tokens = normalizeClassName(className).filter(
			(token) => !BANNER_HEADING_ROLE_CLASSES.includes(token)
		);

		if (!tokens.includes(expectedClassName)) {
			tokens.push(expectedClassName);
		}

		return tokens.join(" ");
	};

	const getAllBlocks = (blocks) => {
		const flatBlocks = [];

		(blocks || []).forEach((block) => {
			flatBlocks.push(block);
			if (Array.isArray(block?.innerBlocks) && block.innerBlocks.length > 0) {
				flatBlocks.push(...getAllBlocks(block.innerBlocks));
			}
		});

		return flatBlocks;
	};

	const migratePageBannerHeadingClasses = () => {
		const select = getBlockEditorStore();
		const dispatch = getBlockEditorDispatch();

		if (!select || !dispatch) return;

		const pageBanners = getAllBlocks(select.getBlocks()).filter(
			(block) => block?.name === "acf/fu-page-banner"
		);

		pageBanners.forEach((pageBanner) => {
			const headingBlocks = (pageBanner.innerBlocks || []).filter(
				(innerBlock) => innerBlock?.name === "acf/fu-heading"
			);

			const expectedClasses = [
				"fu-page-banner__primary-heading",
				"fu-page-banner__subhead",
			];
			let bannerWasMigrated = false;

			headingBlocks
				.slice(0, expectedClasses.length)
				.forEach((headingBlock, index) => {
					const expectedClassName = expectedClasses[index];
					const nextClassName = getMigratedHeadingClassName(
						headingBlock?.attributes?.className,
						expectedClassName
					);
					const currentClassName = String(
						headingBlock?.attributes?.className || ""
					).trim();

					if (currentClassName !== nextClassName) {
						dispatch.updateBlockAttributes(headingBlock.clientId, {
							className: nextClassName,
						});
						bannerWasMigrated = true;
					}
				});

			if (bannerWasMigrated) {
				console.log(
					"[Page Banner] Migrated heading role classes for an existing banner. Save the post to persist the update.",
					pageBanner.clientId
				);
			}
		});
	};

	const syncHeadingFieldLabels = () => {
		if (typeof acf?.getFields !== "function") return;

		const headingTextFields = acf.getFields({
			key: "field_69a187ceabed1",
		});

		(headingTextFields || []).forEach((field) => {
			updateHeadingFieldLabel(field);
		});
	};

	const updateHeadingFieldLabel = (fieldOrElement) => {
		const fieldElement = getFieldElement(fieldOrElement) || fieldOrElement;
		if (!fieldElement?.matches?.(HEADING_TEXT_FIELD_SELECTOR)) {
			return;
		}

		const labelNode = fieldElement.querySelector(".acf-label label");
		if (!labelNode) return;

		const role = getHeadingRole(fieldElement);
		if (!role) return;

		labelNode.textContent =
			role === "subhead" ? "Subheading Text" : "Heading Text";
	};

	const getEditorDocuments = () => {
		const docs = [document];
		const iframe = document.querySelector('iframe[name="editor-canvas"]');

		if (iframe?.contentDocument) {
			docs.unshift(iframe.contentDocument);
		}

		return docs;
	};

	const getSelectedBannerPreviewElement = () => {
		const clientId = wp?.data
			?.select("core/block-editor")
			?.getSelectedBlockClientId?.();

		const docs = getEditorDocuments();

		if (clientId) {
			const selectors = [
				`[data-block="${clientId}"] .fu-page-banner`,
				`[data-block="${clientId}"].fu-page-banner`,
				`#block-${clientId} .fu-page-banner`,
				`#block-${clientId}.fu-page-banner`,
			];

			for (const targetDoc of docs) {
				for (const selector of selectors) {
					const banner = targetDoc.querySelector(selector);
					if (banner) return banner;
				}
			}
		}

		for (const targetDoc of docs) {
			const banners = targetDoc.querySelectorAll(".fu-page-banner");
			if (banners.length === 1) {
				return banners[0];
			}
		}

		return null;
	};

	const getBannerComponentElement = (fieldOrElement) => {
		const fieldElement =
			fieldOrElement?.nodeType === 1
				? fieldOrElement
				: getFieldElement(fieldOrElement);

		if (!fieldElement) return null;

		return (
			fieldElement.closest(".acf-block-component") ||
			fieldElement.closest(".wp-block-acf-fu-page-banner") ||
			fieldElement.closest(".block-editor-block-list__block")
		);
	};

	const getBannerPreviewElement = (fieldOrElement) => {
		if (fieldOrElement?.nodeType === 1) {
			if (fieldOrElement.classList?.contains("fu-page-banner")) {
				return fieldOrElement;
			}
		}

		const component = getBannerComponentElement(fieldOrElement);
		if (!component) return null;

		if (component.classList?.contains("fu-page-banner")) {
			return component;
		}

		return (
			component.querySelector(".fu-page-banner") ||
			getSelectedBannerPreviewElement()
		);
	};

	const getBannerFieldsContainer = (fieldOrElement) => {
		const fieldElement =
			fieldOrElement?.nodeType === 1
				? fieldOrElement
				: getFieldElement(fieldOrElement);

		if (!fieldElement) return null;

		return (
			fieldElement.closest(".acf-block-fields") ||
			getBannerComponentElement(fieldElement)?.querySelector(
				".acf-block-fields"
			) ||
			null
		);
	};

	const readEditorControlValues = (fieldOrElement) => {
		const fieldsContainer = getBannerFieldsContainer(fieldOrElement);
		if (!fieldsContainer || typeof acf?.getFields !== "function") {
			return null;
		}

		const values = { ...EDITOR_CONTROL_DEFAULTS };
		const fields = acf.getFields({ parent: fieldsContainer }) || [];

		fields.forEach((field) => {
			const name = field?.get?.("name");
			if (!name || !(name in values)) return;

			values[name] = field.val();
		});

		return {
			show_subhead: normalizeBooleanValue(values.show_subhead, true),
			show_body: normalizeBooleanValue(values.show_body, true),
			show_btn_1: normalizeBooleanValue(values.show_btn_1, true),
			show_btn_2: normalizeBooleanValue(values.show_btn_2, true),
			alignment_buttons:
				typeof values.alignment_buttons === "string" && values.alignment_buttons
					? values.alignment_buttons
					: EDITOR_CONTROL_DEFAULTS.alignment_buttons,
			pause_blur_intensity:
				values.pause_blur_intensity ??
				EDITOR_CONTROL_DEFAULTS.pause_blur_intensity,
			bg_focal_point:
				typeof values.bg_focal_point === "string" && values.bg_focal_point
					? values.bg_focal_point
					: EDITOR_CONTROL_DEFAULTS.bg_focal_point,
		};
	};

	const applyEditorBannerState = (banner, values) => {
		if (!banner || !values) return;

		banner.classList.toggle("hide-subhead", !values.show_subhead);
		banner.classList.toggle("hide-body", !values.show_body);
		banner.classList.toggle("hide-btn-1", !values.show_btn_1);
		banner.classList.toggle("hide-btn-2", !values.show_btn_2);

		banner.classList.remove(...ALIGNMENT_CLASSES);
		banner.classList.add(
			`fu-page-banner--align-${values.alignment_buttons || "center"}`
		);

		const blurValue = String(values.pause_blur_intensity || 0).trim();
		const focalPoint = String(
			values.bg_focal_point || EDITOR_CONTROL_DEFAULTS.bg_focal_point
		).trim();

		banner.style.setProperty("--banner-blur", `${blurValue || 0}px`);
		banner.style.setProperty(
			"--banner-video-focal-point",
			focalPoint || EDITOR_CONTROL_DEFAULTS.bg_focal_point
		);

		const video = banner.querySelector(".fu-page-banner__video");
		if (video) {
			video.style.objectPosition =
				focalPoint || EDITOR_CONTROL_DEFAULTS.bg_focal_point;
		}

		const backgroundImage = banner.querySelector(".fu-page-banner__bg-image");
		if (backgroundImage) {
			backgroundImage.style.backgroundPosition =
				focalPoint || EDITOR_CONTROL_DEFAULTS.bg_focal_point;
		}
	};

	const applyEditorFieldChange = (banner, field) => {
		if (!banner || !field?.get) return false;

		const name = field.get("name");
		if (!name) return false;

		const value = field.val();

		switch (name) {
			case "show_subhead":
				banner.classList.toggle(
					"hide-subhead",
					!normalizeBooleanValue(value, true)
				);
				return true;
			case "show_body":
				banner.classList.toggle(
					"hide-body",
					!normalizeBooleanValue(value, true)
				);
				return true;
			case "show_btn_1":
				banner.classList.toggle(
					"hide-btn-1",
					!normalizeBooleanValue(value, true)
				);
				return true;
			case "show_btn_2":
				banner.classList.toggle(
					"hide-btn-2",
					!normalizeBooleanValue(value, true)
				);
				return true;
			case "alignment_buttons": {
				const alignment =
					typeof value === "string" && value
						? value
						: EDITOR_CONTROL_DEFAULTS.alignment_buttons;
				banner.classList.remove(...ALIGNMENT_CLASSES);
				banner.classList.add(`fu-page-banner--align-${alignment}`);
				return true;
			}
			case "pause_blur_intensity": {
				const blurValue = String(value ?? 0).trim() || "0";
				banner.style.setProperty("--banner-blur", `${blurValue}px`);
				return true;
			}
			case "bg_focal_point": {
				const focalPoint =
					typeof value === "string" && value.trim()
						? value.trim()
						: EDITOR_CONTROL_DEFAULTS.bg_focal_point;

				banner.style.setProperty("--banner-video-focal-point", focalPoint);

				const video = banner.querySelector(".fu-page-banner__video");
				if (video) {
					video.style.objectPosition = focalPoint;
				}

				const backgroundImage = banner.querySelector(
					".fu-page-banner__bg-image"
				);
				if (backgroundImage) {
					backgroundImage.style.backgroundPosition = focalPoint;
				}

				return true;
			}
			default:
				return false;
		}
	};

	const syncEditorBannerFromField = (fieldOrElement) => {
		const banner = getBannerPreviewElement(fieldOrElement);
		if (!banner) return false;

		const values = readEditorControlValues(fieldOrElement);
		if (!values) {
			return applyEditorFieldChange(banner, fieldOrElement);
		}

		applyEditorBannerState(banner, values);
		return true;
	};

	const getBannerControls = (banner) => {
		const video = banner.querySelector("video");
		const button = banner.querySelector(".fu-banner-mute-toggle");
		if (!video || !button) return null;

		button.type = "button";
		return { video, button };
	};

	const setBannerPausedState = (banner, button, isPaused) => {
		banner.classList.toggle("is-paused", isPaused);
		button.classList.toggle("is-paused", isPaused);
		button.setAttribute("aria-pressed", isPaused ? "true" : "false");
	};

	const syncBannerPlaybackState = (video, banner, button) => {
		setBannerPausedState(banner, button, video.paused);
	};

	const applyVideoAttributes = (video) => {
		video.muted = true;
		video.defaultMuted = true;
		video.setAttribute("muted", "");
		video.autoplay = true;
		video.setAttribute("autoplay", "");
		video.loop = true;
		video.setAttribute("loop", "");
		video.playsInline = true;
		video.setAttribute("playsinline", "");
	};

	/**
	 * 1. THE TOGGLE ENGINE (Shared)
	 */
	const toggleVideo = (video, banner, button) => {
		if (!video || !banner || !button) return;

		if (video.paused) {
			video
				.play()
				.then(() => {
					setBannerPausedState(banner, button, false);
					// Remove the manual flag so scroll logic can take over again
					banner.removeAttribute("data-manual-pause");
				})
				.catch((err) => console.warn("Playback blocked:", err));
		} else {
			video.pause();
			setBannerPausedState(banner, button, true);
			// Set the manual flag so scroll logic ignores this banner
			banner.setAttribute("data-manual-pause", "true");
		}
	};

	/**
	 * 2. FRONT-END LOGIC
	 */
	const initFrontEnd = () => {
		const banners = document.querySelectorAll(
			".fu-page-banner[data-pause-on-scroll='true']"
		);

		banners.forEach((banner) => {
			const controls = getBannerControls(banner);
			if (!controls) return;
			const { video, button } = controls;

			// Start in "Paused" UI state to match the video being paused initially
			setBannerPausedState(banner, button, true);

			// Listen for when video actually starts playing (either via autoplay or user interaction)
			const onPlay = () => {
				setBannerPausedState(banner, button, false);
				banner.removeAttribute("data-manual-pause");
			};

			const onPause = () => {
				setBannerPausedState(banner, button, true);
			};

			video.addEventListener("play", onPlay);
			video.addEventListener("pause", onPause);

			// Lazy Load Observer
			const loadObserver = new IntersectionObserver(
				(entries, observer) => {
					entries.forEach((entry) => {
						if (entry.isIntersecting && !video.dataset.loaded) {
							video.src = video.dataset.lazyVideo;
							video.load();
							video.dataset.loaded = "true";
							// After setting src, if visible, start playback (autoplay may not trigger in all browsers)
							if (!banner.hasAttribute("data-manual-pause")) {
								video.play().catch(() => {});
							}
							observer.unobserve(entry.target);
						}
					});
				},
				{ rootMargin: "0px 0px 300px 0px" }
			);

			// Playback Observer
			const controlObserver = new IntersectionObserver(
				(entries) => {
					entries.forEach((entry) => {
						if (!video.dataset.loaded) return;

						// Only auto-play if the user HAS NOT clicked pause manually
						const hasManualPause = banner.hasAttribute("data-manual-pause");

						if (entry.isIntersecting && !hasManualPause) {
							video
								.play()
								.then(() => {
									setBannerPausedState(banner, button, false);
								})
								.catch(() => {});
						} else {
							video.pause();
							setBannerPausedState(banner, button, true);
						}
					});
				},
				{ threshold: 0.1 }
			);

			loadObserver.observe(banner);
			controlObserver.observe(banner);

			button.addEventListener("click", (e) => {
				e.preventDefault();
				toggleVideo(video, banner, button);
			});
		});
	};

	/**
	 * 3. EDITOR LOGIC (Iframe Bridge)
	 */
	const initEditor = () => {
		if (typeof window.acf === "undefined") return;

		migratePageBannerHeadingClasses();
		requestAnimationFrame(syncHeadingFieldLabels);

		acf.addAction(
			"ready_field/key=field_69a187ceabed1",
			updateHeadingFieldLabel
		);
		acf.addAction(
			"append_field/key=field_69a187ceabed1",
			updateHeadingFieldLabel
		);
		acf.addAction("render_block_preview", () => {
			requestAnimationFrame(() => {
				migratePageBannerHeadingClasses();
				syncHeadingFieldLabels();
			});
		});

		const requestEditorPlayback = (video, banner, button) => {
			if (banner.hasAttribute("data-manual-pause")) return;
			if (video.dataset.editorPlayPending === "true") return;

			const startPlayback = () => {
				if (!video.isConnected) return;
				video.dataset.editorPlayPending = "true";
				const playPromise = video.play();

				if (!playPromise || typeof playPromise.then !== "function") {
					delete video.dataset.editorPlayPending;
					syncBannerPlaybackState(video, banner, button);
					return;
				}

				playPromise
					.catch((err) => {
						if (err?.name !== "AbortError") {
							console.warn("Editor banner playback blocked:", err);
						}
					})
					.finally(() => {
						delete video.dataset.editorPlayPending;
						syncBannerPlaybackState(video, banner, button);
					});
			};

			if (video.readyState >= 2) {
				requestAnimationFrame(() => startPlayback());
				return;
			}

			if (video.dataset.editorPlaybackWaiting !== "true") {
				video.dataset.editorPlaybackWaiting = "true";
				const handlePlaybackReady = () => {
					delete video.dataset.editorPlaybackWaiting;
					requestAnimationFrame(() => startPlayback());
				};

				video.addEventListener("loadeddata", handlePlaybackReady, {
					once: true,
				});
				video.addEventListener("canplay", handlePlaybackReady, {
					once: true,
				});
			}
		};

		// Create custom reset confirmation modal
		const modal = document.createElement("div");
		modal.id = "fu-reset-modal";
		modal.innerHTML = `
            <style>
                #fu-reset-modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; display: none; }
                .fu-modal-content { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); max-width: 400px; width: 90%; }
                .fu-modal-content p { margin: 0 0 20px 0; font-size: 16px; color: #333; }
                .fu-modal-buttons { display: flex; gap: 10px; justify-content: flex-end; }
                .fu-modal-buttons button { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
                .fu-modal-buttons button:first-child { background: #d63638; color: white; }
                .fu-modal-buttons button:last-child { background: #f0f0f1; color: #333; }
            </style>
            <div class="fu-modal-content">
                <p>Reset all banner settings to default values?</p>
                <div class="fu-modal-buttons">
                    <button id="fu-confirm-reset">Reset</button>
                    <button id="fu-cancel-reset">Cancel</button>
                </div>
            </div>
        `;
		document.body.appendChild(modal);

		// Watch for control-field changes and re-render the preview with updated
		// classes and inline CSS variables.
		CONTROL_FIELD_KEYS.forEach((fieldKey) => {
			acf.addAction(`change_field/key=${fieldKey}`, (field) => {
				requestAnimationFrame(() => {
					const applied = syncEditorBannerFromField(field);
					if (!applied) {
						acf.doAction("render_block_preview");
					}
				});
			});
		});

		const observedDocs = new WeakSet();

		const setupEditorObserver = () => {
			const iframe = document.querySelector('iframe[name="editor-canvas"]');
			const targetDoc = iframe
				? iframe.contentDocument || iframe.contentWindow.document
				: document;

			if (!targetDoc || !targetDoc.body) return;
			if (observedDocs.has(targetDoc)) {
				targetDoc.querySelectorAll(".fu-page-banner").forEach(fixBanner);
				return;
			}

			const observer = new MutationObserver(() => {
				targetDoc.querySelectorAll(".fu-page-banner").forEach(fixBanner);
			});

			observer.observe(targetDoc.body, { childList: true, subtree: true });
			observedDocs.add(targetDoc);
			targetDoc.querySelectorAll(".fu-page-banner").forEach(fixBanner);
		};

		const fixBanner = (banner) => {
			const controls = getBannerControls(banner);
			if (!controls) return;
			const { video, button } = controls;

			const currentSrc = normalizeMediaSrc(video.getAttribute("src"));
			const desiredSrc =
				normalizeMediaSrc(video.dataset.editorVideo) ||
				normalizeMediaSrc(video.dataset.lazyVideo) ||
				currentSrc;

			if (!desiredSrc) {
				video.removeAttribute("src");
				syncBannerPlaybackState(video, banner, button);
				return;
			}

			if (
				video.dataset.editorSource !== desiredSrc ||
				currentSrc !== desiredSrc
			) {
				video.dataset.editorSource = desiredSrc;
				video.setAttribute("src", desiredSrc);
				video.src = desiredSrc;
				delete video.dataset.editorPlaybackWaiting;
				delete video.dataset.editorPlayPending;
				video.load();
			}

			applyVideoAttributes(video);

			if (banner.dataset.editorVideoBound !== "true") {
				const handleEditorToggle = (e) => {
					e.preventDefault();
					e.stopPropagation();
					if (typeof e.stopImmediatePropagation === "function") {
						e.stopImmediatePropagation();
					}
					toggleVideo(video, banner, button);
				};

				const repairEditorSrc = () => {
					const expectedSrc = normalizeMediaSrc(
						video.dataset.editorVideo || video.dataset.editorSource
					);
					const actualSrc = normalizeMediaSrc(video.getAttribute("src"));

					if (!expectedSrc) return;
					if (actualSrc === expectedSrc) return;

					video.setAttribute("src", expectedSrc);
					video.src = expectedSrc;
					delete video.dataset.editorPlaybackWaiting;
					delete video.dataset.editorPlayPending;
					video.load();
					requestEditorPlayback(video, banner, button);
				};

				video.addEventListener("play", () =>
					syncBannerPlaybackState(video, banner, button)
				);
				video.addEventListener("pause", () =>
					syncBannerPlaybackState(video, banner, button)
				);
				video.addEventListener("loadeddata", () =>
					requestEditorPlayback(video, banner, button)
				);
				video.addEventListener("canplay", () =>
					requestEditorPlayback(video, banner, button)
				);
				button.addEventListener("click", handleEditorToggle);

				const srcObserver = new MutationObserver((mutations) => {
					for (const mutation of mutations) {
						if (
							mutation.type === "attributes" &&
							mutation.attributeName === "src"
						) {
							repairEditorSrc();
						}
					}
				});

				srcObserver.observe(video, {
					attributes: true,
					attributeFilter: ["src"],
				});

				banner.dataset.editorVideoBound = "true";
			}

			syncBannerPlaybackState(video, banner, button);
			requestEditorPlayback(video, banner, button);
		};

		acf.addAction("render_block_preview", setupEditorObserver);
		setupEditorObserver();

		document.addEventListener("click", (e) => {
			const resetBtn = e.target.closest(".fu-banner-reset");
			if (!resetBtn) return;
			e.preventDefault();
			const blockEl = resetBtn.closest(".acf-block-fields");
			if (blockEl) {
				// Show custom modal instead of ugly confirm
				modal.style.display = "block";
				// Store blockEl for later use
				modal._blockEl = blockEl;
			}
		});

		// Handle modal buttons
		document
			.getElementById("fu-confirm-reset")
			.addEventListener("click", () => {
				const blockEl = modal._blockEl;
				if (blockEl) {
					resetBannerFields(blockEl);
				}
				modal.style.display = "none";
			});

		document.getElementById("fu-cancel-reset").addEventListener("click", () => {
			modal.style.display = "none";
		});
	};

	function resetBannerFields(blockEl) {
		const defaults = {
			banner_contrast: 100,
			banner_grayscale: 0,
			banner_saturation: 100,
			pause_blur_intensity: 7,
			banner_overlay_brand_color: "#000000",
			banner_overlay_opacity: 50,
			bg_focal_point: "center center",
			banner_overlay_blend_mode: "normal",
			// alignment_buttons is a button_group field (treated like a radio)
			alignment_buttons: "center",
			// visibility controls - true means show (don't apply hide class)
			show_subhead: 1,
			show_body: 1,
			show_btn_1: 1,
			show_btn_2: 1,
		};
		const fields = acf.getFields({ parent: blockEl });
		if (!fields.length) return;
		fields.forEach((field) => {
			const name = field.get("name");
			if (!(name in defaults)) return;
			const value = defaults[name];
			const type = field.get("type");
			// button_group fields behave similarly to radios, so we can handle
			// them in the "default" branch above. No need for special case.
			if (type !== "radio" && type !== "true_false") {
				field.val(value);
				field.$input().trigger("change");
			} else if (type === "radio") {
				const $inputs = field.$el.find('input[type="radio"]');
				$inputs.prop("checked", false);
				$inputs
					.filter(`[value="${value}"]`)
					.prop("checked", true)
					.trigger("change");
				field.$el.find("label").removeClass("selected");
				$inputs
					.filter(`[value="${value}"]`)
					.closest("label")
					.addClass("selected");
			} else if (type === "true_false") {
				const isChecked = Number(value) === 1;
				field.$el
					.find('input[type="checkbox"]')
					.prop("checked", isChecked)
					.trigger("change");
				field.$el.find('input[type="hidden"]').val(isChecked ? 1 : 0);
				field.$el.toggleClass("is-checked", isChecked);
			}
		});
		// Force block preview to re-render with new values
		if (typeof acf !== "undefined") {
			acf.doAction("render_block_preview");
		}
		requestAnimationFrame(() => {
			syncEditorBannerFromField(blockEl);
		});
	}

	if (isEditor) initEditor();
	else {
		if (document.readyState !== "loading") initFrontEnd();
		else document.addEventListener("DOMContentLoaded", initFrontEnd);
	}
})();
