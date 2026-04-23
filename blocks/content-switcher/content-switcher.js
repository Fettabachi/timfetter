(function () {
	"use strict";

	const ROOT_SELECTOR = ".fu-content-switcher[data-fu-content-switcher]";
	const PANELS_SELECTOR = ".fu-content-switcher__panels";
	const TAB_SELECTOR = ".fu-content-switcher__tab[data-fu-switcher-tab]";
	const FRONTEND_PANEL_SELECTOR =
		".fu-content-switcher__panel[data-fu-switcher-panel]";
	const FRONTEND_PANEL_INNER_SELECTOR = ".fu-content-switcher__panel-inner";
	const ACCORDION_SELECTOR =
		".fu-content-switcher__accordion-trigger[data-fu-switcher-accordion]";
	const CHILD_PANEL_SELECTOR = ".fu-switcher-panel";
	const EDITOR_PANEL_SELECTORS = [
		".wp-block-acf-fu-switcher-panel",
		'.block-editor-block-list__block[data-type="acf/fu-switcher-panel"]',
	].join(", ");
	const MOBILE_BREAKPOINT = window.matchMedia("(max-width: 48rem)");
	const instances = new WeakMap();
	let observer = null;
	let rafId = 0;

	const isEditorEnvironment =
		typeof window.wp !== "undefined" && typeof window.wp.data !== "undefined";

	const decodeHash = () => {
		const rawHash = window.location.hash.replace(/^#/, "").trim();
		if (!rawHash) {
			return "";
		}

		try {
			return decodeURIComponent(rawHash);
		} catch (error) {
			return rawHash;
		}
	};

	const ICON_SVGS = {
		strategy:
			'<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4 5.75A1.75 1.75 0 0 1 5.75 4h8.19a1.75 1.75 0 0 1 1.24.51l3.31 3.31c.33.33.51.78.51 1.24v9.19A1.75 1.75 0 0 1 17.25 20h-11.5A1.75 1.75 0 0 1 4 18.25Zm2 1.25v10h10v-6h-3.5A1.5 1.5 0 0 1 11 9.5V6Zm7 .41V9h1.59Z"></path></svg>',
		design:
			'<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M11.1 3.39a1.5 1.5 0 0 1 1.8 0l6.26 4.69a1.5 1.5 0 0 1 .6 1.2v7.44a1.5 1.5 0 0 1-.6 1.2l-6.26 4.69a1.5 1.5 0 0 1-1.8 0l-6.26-4.69a1.5 1.5 0 0 1-.6-1.2V9.28a1.5 1.5 0 0 1 .6-1.2ZM12 6.18 7.2 9.77V15L12 18.59 16.8 15V9.77Z"></path></svg>',
		development:
			'<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M8.47 7.22a1 1 0 0 1 0 1.41L5.12 12l3.35 3.37a1 1 0 1 1-1.42 1.4l-4.05-4.08a1 1 0 0 1 0-1.4l4.05-4.07a1 1 0 0 1 1.42 0Zm7.06 0a1 1 0 0 1 1.42 0L21 11.29a1 1 0 0 1 0 1.4l-4.05 4.08a1 1 0 0 1-1.42-1.4L18.88 12l-3.35-3.37a1 1 0 0 1 0-1.41ZM13.9 4.36a1 1 0 0 1 .74 1.21l-3 12a1 1 0 1 1-1.94-.48l3-12a1 1 0 0 1 1.2-.73Z"></path></svg>',
		audience:
			'<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 12a3.5 3.5 0 1 0-3.5-3.5A3.5 3.5 0 0 0 12 12Zm-6.75 7a5.75 5.75 0 0 1 11.5 0 1 1 0 0 1-2 0 3.75 3.75 0 1 0-7.5 0 1 1 0 0 1-2 0Zm12.5-5.59A3 3 0 1 0 14.76 8a3 3 0 0 0 2.99 5.41ZM18.25 19a4.7 4.7 0 0 0-.63-2.35 3.75 3.75 0 0 1 3.13 2.35 1 1 0 0 1-1.88.7Z"></path></svg>',
		check:
			'<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M9.55 16.2 5.3 11.95a1 1 0 1 1 1.4-1.42l2.85 2.86 7.75-7.76a1 1 0 1 1 1.4 1.42l-9.15 9.15a1 1 0 0 1-1.4 0Z"></path></svg>',
	};

	const getElementNode = (value) =>
		value?.get?.(0) || value?.[0] || value || null;
	const getClosestRoot = (element) => element?.closest?.(ROOT_SELECTOR) || null;
	const slugify = (value) =>
		String(value || "")
			.toLowerCase()
			.trim()
			.replace(/[^a-z0-9]+/g, "-")
			.replace(/^-+|-+$/g, "") || "panel";
	const buildHashSlug = (instancePrefix, panelSlug) =>
		`${instancePrefix || "switcher-instance"}-${slugify(panelSlug)}`;

	class ContentSwitcher {
		constructor(root) {
			this.root = root;
			this.handleTabClick = this.handleTabClick.bind(this);
			this.handleTabKeydown = this.handleTabKeydown.bind(this);
			this.handleAccordionClick = this.handleAccordionClick.bind(this);
			this.handleViewportChange = this.handleViewportChange.bind(this);
			this.activeIndex = Number.NaN;
			this.refresh();
			this.bindEvents();
		}

		refresh() {
			this.nav = this.root.querySelector(".fu-content-switcher__nav");
			this.panelsContainer = this.root.querySelector(PANELS_SELECTOR);
			this.tabs = Array.from(this.root.querySelectorAll(TAB_SELECTOR));
			this.frontendPanels = Array.from(
				this.root.querySelectorAll(FRONTEND_PANEL_SELECTOR)
			);
			this.frontendMode = this.frontendPanels.length > 0;
			this.displayStyle = this.root.dataset.displayStyle || "tabs";
			this.mobileBehavior = this.root.dataset.mobileBehavior || "accordion";
			this.deepLinkEnabled = this.root.dataset.deepLinkEnabled !== "false";
			this.instancePrefix =
				this.root.dataset.instancePrefix || this.root.id || "switcher-instance";
			this.controlIdPrefix = this.instancePrefix;
			this.initialIndex = Number.parseInt(
				this.root.dataset.initialIndex || "0",
				10
			);
			this.panels = this.frontendMode
				? this.collectFrontendPanels()
				: this.collectEditorPanels();
			this.syncEditorControls();
			this.activeIndex = this.getValidIndex(this.resolveStartingIndex());
			this.applyState({ updateHash: false, force: true });
		}

		bindEvents() {
			this.root.addEventListener("click", this.handleTabClick);
			this.root.addEventListener("keydown", this.handleTabKeydown);
			this.root.addEventListener("click", this.handleAccordionClick);

			if (typeof MOBILE_BREAKPOINT.addEventListener === "function") {
				MOBILE_BREAKPOINT.addEventListener("change", this.handleViewportChange);
			} else if (typeof MOBILE_BREAKPOINT.addListener === "function") {
				MOBILE_BREAKPOINT.addListener(this.handleViewportChange);
			}
		}

		handleViewportChange() {
			this.applyState({ updateHash: false, force: true });
		}

		collectFrontendPanels() {
			return this.frontendPanels.map((panel, index) => {
				const content = panel.querySelector(FRONTEND_PANEL_INNER_SELECTOR);
				const accordion = panel.querySelector(ACCORDION_SELECTOR);
				const dataNode = panel.querySelector(".fu-switcher-panel");
				return {
					index,
					wrapper: panel,
					content,
					accordion,
					dataNode,
					slug:
						panel.dataset.panelSlug ||
						dataNode?.dataset.panelSlug ||
						String(index + 1),
					hashSlug:
						panel.dataset.panelHash ||
						buildHashSlug(
							this.instancePrefix,
							panel.dataset.panelSlug ||
								dataNode?.dataset.panelSlug ||
								String(index + 1)
						),
					label:
						dataNode?.dataset.panelLabel ||
						panel.dataset.panelLabel ||
						accordion?.querySelector(".fu-content-switcher__tab-label")
							?.textContent ||
						`Panel ${index + 1}`,
					icon: dataNode?.dataset.panelIcon || "",
				};
			});
		}

		collectEditorPanels() {
			if (!this.panelsContainer) {
				return [];
			}

			const dataNodes = Array.from(
				this.panelsContainer.querySelectorAll(CHILD_PANEL_SELECTOR)
			).filter((dataNode) => dataNode.closest(ROOT_SELECTOR) === this.root);

			return dataNodes.map((dataNode, index) => {
				const wrapper =
					dataNode.closest(EDITOR_PANEL_SELECTORS) ||
					dataNode.closest("[data-block]") ||
					dataNode;
				const blockEdit =
					Array.from(wrapper.children || []).find((child) =>
						child.classList?.contains("block-editor-block-list__block-edit")
					) || wrapper;
				wrapper.classList.add("fu-content-switcher__panel");
				blockEdit.classList.add("fu-content-switcher__panel-inner");
				wrapper.dataset.fuSwitcherEditorPanel = "true";
				return {
					index,
					wrapper,
					content: blockEdit,
					accordion: null,
					dataNode,
					slug:
						dataNode?.dataset.panelSlug ||
						wrapper.dataset.panelSlug ||
						String(index + 1),
					hashSlug: buildHashSlug(
						this.instancePrefix,
						dataNode?.dataset.panelSlug ||
							wrapper.dataset.panelSlug ||
							String(index + 1)
					),
					label:
						dataNode?.dataset.panelLabel ||
						wrapper.dataset.title ||
						`Panel ${index + 1}`,
					icon: dataNode?.dataset.panelIcon || "",
				};
			});
		}

		syncTabIcon(tab, panel) {
			const showIcons = this.root.classList.contains(
				"fu-content-switcher--show-icons"
			);
			const labelNode = tab.querySelector(".fu-content-switcher__tab-label");
			let iconNode = tab.querySelector(".fu-content-switcher__tab-icon");
			const iconMarkup = showIcons ? ICON_SVGS[panel?.icon || ""] || "" : "";

			if (!iconMarkup) {
				if (iconNode) {
					if (iconNode.innerHTML !== "") {
						iconNode.innerHTML = "";
					}
					iconNode.hidden = true;
				}
				return;
			}

			if (!iconNode) {
				iconNode = document.createElement("span");
				iconNode.className = "fu-content-switcher__tab-icon";
				iconNode.setAttribute("aria-hidden", "true");
				if (labelNode) {
					tab.insertBefore(iconNode, labelNode);
				} else {
					tab.appendChild(iconNode);
				}
			}

			if (iconNode.innerHTML !== iconMarkup) {
				iconNode.innerHTML = iconMarkup;
			}

			iconNode.hidden = false;
		}

		syncEditorSelection() {
			if (this.frontendMode) {
				return;
			}

			const selectedIndex = this.getSelectedEditorPanelIndex();
			if (selectedIndex !== -1 && selectedIndex !== this.activeIndex) {
				this.activate(selectedIndex, { updateHash: false });
			}
		}

		syncEditorControls() {
			if (this.frontendMode || !this.nav || this.panels.length === 0) {
				return;
			}

			const templateButton = this.tabs[0] || null;
			const tablist = this.nav;

			if (!templateButton) {
				return;
			}

			while (this.tabs.length < this.panels.length) {
				const clone = templateButton.cloneNode(true);
				clone.classList.remove("is-active");
				clone.setAttribute("aria-selected", "false");
				clone.setAttribute("tabindex", "-1");
				tablist.appendChild(clone);
				this.tabs.push(clone);
			}

			while (this.tabs.length > this.panels.length) {
				const removed = this.tabs.pop();
				removed?.remove();
			}

			this.tabs.forEach((tab, index) => {
				const panel = this.panels[index];
				const label = panel?.label || `Panel ${index + 1}`;
				tab.dataset.panelIndex = String(index);
				tab.dataset.panelSlug = panel?.slug || String(index + 1);
				tab.dataset.panelHash = panel?.hashSlug || "";
				tab.dataset.panelLabel = panel?.label || `Panel ${index + 1}`;
				tab.id = `${this.controlIdPrefix}-tab-preview-${index + 1}`;
				tab.setAttribute(
					"aria-controls",
					`${this.controlIdPrefix}-panel-preview-${index + 1}`
				);

				const labelNode = tab.querySelector(".fu-content-switcher__tab-label");
				if (labelNode && labelNode.textContent !== label) {
					labelNode.textContent = label;
				}

				this.syncTabIcon(tab, panel);
			});
		}

		resolveStartingIndex() {
			if (isEditorEnvironment && !this.frontendMode) {
				const selectedIndex = this.getSelectedEditorPanelIndex();
				if (selectedIndex !== -1) {
					return selectedIndex;
				}
			}

			const hash = decodeHash();
			if (this.deepLinkEnabled && hash) {
				const matchedIndex = this.panels.findIndex(
					(panel) => panel.hashSlug === hash
				);
				if (matchedIndex !== -1) {
					return matchedIndex;
				}
			}

			return Number.isFinite(this.activeIndex)
				? this.activeIndex
				: this.initialIndex;
		}

		getSelectedEditorPanelIndex() {
			const selectedBlockId = window.wp?.data
				?.select("core/block-editor")
				?.getSelectedBlockClientId?.();

			if (!selectedBlockId) {
				return -1;
			}

			const selectedElement = document.querySelector(
				`[data-block="${selectedBlockId}"]`
			);
			if (!selectedElement) {
				return -1;
			}

			const matchedPanel = this.panels.findIndex(
				(panel) =>
					panel.wrapper.contains(selectedElement) ||
					panel.wrapper === selectedElement
			);

			return matchedPanel;
		}

		getValidIndex(index) {
			if (!this.panels.length) {
				return 0;
			}

			if (!Number.isFinite(index) || index < 0) {
				return 0;
			}

			if (index >= this.panels.length) {
				return this.panels.length - 1;
			}

			return index;
		}

		isMobile() {
			return MOBILE_BREAKPOINT.matches;
		}

		isAccordionMode() {
			return this.isMobile() && this.mobileBehavior === "accordion";
		}

		isStackedMode() {
			return this.isMobile() && this.mobileBehavior === "stacked";
		}

		currentOrientation() {
			return this.displayStyle === "vertical" && !this.isMobile()
				? "vertical"
				: "horizontal";
		}

		handleTabClick(event) {
			const button = event.target.closest(TAB_SELECTOR);
			if (!button || button.closest(ROOT_SELECTOR) !== this.root) {
				return;
			}

			event.preventDefault();
			const index = Number.parseInt(button.dataset.panelIndex || "0", 10);
			this.activate(index, { focusControl: true, updateHash: true });
		}

		handleAccordionClick(event) {
			const button = event.target.closest(ACCORDION_SELECTOR);
			if (!button || button.closest(ROOT_SELECTOR) !== this.root) {
				return;
			}

			event.preventDefault();
			const index = Number.parseInt(button.dataset.panelIndex || "0", 10);
			this.activate(index, { updateHash: true, focusControl: true });
		}

		handleTabKeydown(event) {
			const tab = event.target.closest(TAB_SELECTOR);
			if (!tab || tab.closest(ROOT_SELECTOR) !== this.root) {
				return;
			}

			const currentIndex = Number.parseInt(tab.dataset.panelIndex || "0", 10);
			const lastIndex = this.tabs.length - 1;
			let nextIndex = null;
			const orientation = this.currentOrientation();

			switch (event.key) {
				case "ArrowLeft":
					if (orientation === "horizontal") {
						nextIndex = currentIndex <= 0 ? lastIndex : currentIndex - 1;
					}
					break;
				case "ArrowRight":
					if (orientation === "horizontal") {
						nextIndex = currentIndex >= lastIndex ? 0 : currentIndex + 1;
					}
					break;
				case "ArrowUp":
					if (orientation === "vertical") {
						nextIndex = currentIndex <= 0 ? lastIndex : currentIndex - 1;
					}
					break;
				case "ArrowDown":
					if (orientation === "vertical") {
						nextIndex = currentIndex >= lastIndex ? 0 : currentIndex + 1;
					}
					break;
				case "Home":
					nextIndex = 0;
					break;
				case "End":
					nextIndex = lastIndex;
					break;
				case "Enter":
				case " ":
					event.preventDefault();
					this.activate(currentIndex, { focusControl: true, updateHash: true });
					return;
				default:
					return;
			}

			if (nextIndex === null) {
				return;
			}

			event.preventDefault();
			this.activate(nextIndex, { focusControl: true, updateHash: true });
		}

		activate(index, options = {}) {
			this.activeIndex = this.getValidIndex(index);
			this.applyState(options);
		}

		applyState({
			updateHash = false,
			focusControl = false,
			force = false,
		} = {}) {
			if (!this.panels.length) {
				return;
			}

			const accordionMode = this.isAccordionMode();
			const stackedMode = this.isStackedMode();
			const orientation = this.currentOrientation();

			if (this.nav) {
				this.nav.hidden = accordionMode || stackedMode;
				this.nav.setAttribute("role", "tablist");
				this.nav.setAttribute("aria-orientation", orientation);
			}

			this.tabs.forEach((tab, index) => {
				const isActive = index === this.activeIndex;
				tab.classList.toggle("is-active", isActive);
				tab.setAttribute("aria-selected", isActive ? "true" : "false");
				tab.setAttribute("tabindex", isActive ? "0" : "-1");
				tab.hidden = accordionMode || stackedMode;
			});

			this.panels.forEach((panel, index) => {
				const isActive = index === this.activeIndex;
				panel.wrapper.classList.toggle("is-active", isActive);
				panel.wrapper.dataset.panelSlug = panel.slug;
				panel.wrapper.dataset.panelHash = panel.hashSlug;
				panel.wrapper.dataset.panelLabel = panel.label;

				if (panel.accordion) {
					panel.accordion.hidden = !accordionMode;
					panel.accordion.classList.toggle("is-active", isActive);
					panel.accordion.dataset.panelHash = panel.hashSlug;
					panel.accordion.dataset.panelLabel = panel.label;
					panel.accordion.setAttribute(
						"aria-expanded",
						isActive ? "true" : "false"
					);
				}

				if (stackedMode) {
					panel.content.hidden = false;
					panel.content.removeAttribute("role");
					panel.content.removeAttribute("aria-labelledby");
					if (panel.content.id) {
						panel.content.setAttribute("data-panel-id", panel.content.id);
					}
				} else if (accordionMode) {
					panel.content.hidden = !isActive;
					panel.content.setAttribute("role", "region");
					if (panel.accordion?.id) {
						panel.content.setAttribute("aria-labelledby", panel.accordion.id);
					}
				} else {
					panel.content.hidden = !isActive;
					panel.content.setAttribute("role", "tabpanel");
					const relatedTab = this.tabs[index];
					if (relatedTab?.id) {
						panel.content.setAttribute("aria-labelledby", relatedTab.id);
					}
				}

				if (!this.frontendMode) {
					panel.wrapper.hidden = stackedMode ? false : !isActive;
				}
			});

			if (updateHash && this.deepLinkEnabled && !isEditorEnvironment) {
				this.updateHash();
			}

			if (focusControl) {
				const target = accordionMode
					? this.panels[this.activeIndex]?.accordion
					: this.tabs[this.activeIndex];
				target?.focus();
			}
		}

		updateHash() {
			const hashSlug = this.panels[this.activeIndex]?.hashSlug;
			if (!hashSlug) {
				return;
			}

			const nextUrl = `${window.location.pathname}${
				window.location.search
			}#${encodeURIComponent(hashSlug)}`;
			window.history.replaceState({}, "", nextUrl);
		}

		activateFromHash(hash) {
			if (!hash || !this.deepLinkEnabled) {
				return false;
			}

			const matchedIndex = this.panels.findIndex(
				(panel) => panel.hashSlug === hash
			);
			if (matchedIndex === -1) {
				return false;
			}

			this.activate(matchedIndex, { updateHash: false });
			return true;
		}
	}

	const initSwitchers = (target = document) => {
		if (!target?.querySelectorAll) {
			return;
		}

		const roots = target.matches?.(ROOT_SELECTOR)
			? [target, ...target.querySelectorAll(ROOT_SELECTOR)]
			: Array.from(target.querySelectorAll(ROOT_SELECTOR));

		roots.forEach((root) => {
			const instance = instances.get(root);
			if (instance) {
				instance.refresh();
				return;
			}

			instances.set(root, new ContentSwitcher(root));
		});
	};

	const scheduleInit = (target = document) => {
		if (rafId) {
			window.cancelAnimationFrame(rafId);
		}

		rafId = window.requestAnimationFrame(() => {
			initSwitchers(target);
			rafId = 0;
		});
	};

	const bindObservers = () => {
		if (observer || typeof MutationObserver === "undefined") {
			return;
		}

		observer = new MutationObserver(() => {
			scheduleInit(document);
		});

		observer.observe(document.body, {
			childList: true,
			subtree: true,
			characterData: true,
			attributes: true,
			attributeFilter: [
				"data-panel-label",
				"data-panel-slug",
				"data-panel-icon",
			],
		});
	};

	const bindEditorSelectionSync = () => {
		if (
			!isEditorEnvironment ||
			typeof window.wp?.data?.subscribe !== "function"
		) {
			return;
		}

		let lastSelectedBlockId = null;

		window.wp.data.subscribe(() => {
			const selectedBlockId =
				window.wp.data
					.select("core/block-editor")
					?.getSelectedBlockClientId?.() || null;

			if (selectedBlockId === lastSelectedBlockId) {
				return;
			}

			lastSelectedBlockId = selectedBlockId;
			document.querySelectorAll(ROOT_SELECTOR).forEach((root) => {
				instances.get(root)?.syncEditorSelection();
			});
		});
	};

	const handleHashChange = () => {
		const hash = decodeHash();
		document.querySelectorAll(ROOT_SELECTOR).forEach((root) => {
			instances.get(root)?.activateFromHash(hash);
		});
	};

	document.addEventListener("DOMContentLoaded", () => {
		initSwitchers(document);
		bindObservers();
		bindEditorSelectionSync();
		handleHashChange();
	});

	if (document.readyState !== "loading") {
		initSwitchers(document);
		bindObservers();
		bindEditorSelectionSync();
		handleHashChange();
	}

	window.addEventListener("hashchange", handleHashChange);

	if (window.acf?.addAction) {
		window.acf.addAction(
			"render_block_preview/type=fu-content-switcher",
			($el) => {
				scheduleInit($el?.get?.(0) || document);
			}
		);
		window.acf.addAction(
			"render_block_preview/type=fu-switcher-panel",
			($el) => {
				const element = getElementNode($el);
				const root = getClosestRoot(element);
				scheduleInit(root || document);
			}
		);
		window.acf.addAction("append", ($el) => {
			const element = getElementNode($el);
			const root = getClosestRoot(element);
			scheduleInit(root || document);
		});
	}
})();
