// Front-end demo harness for the Comparison Cards portfolio page only.
// This script updates root modifier classes for visual demos and does not persist data.
(function () {
	"use strict";

	const PANEL_SELECTOR = "[data-fu-comparison-cards-demo]";
	const TOGGLE_SELECTOR = "[data-fu-comparison-cards-demo-toggle]";
	const CLOSE_SELECTOR = "[data-fu-demo-close]";
	const TARGET_SELECTOR =
		"[data-fu-comparison-cards-demo-target] .fu-comparison-cards";
	const FALLBACK_TARGET_SELECTOR = ".fu-comparison-cards";
	const TARGET_SCOPE_SELECTOR = "[data-fu-comparison-cards-demo-target]";
	const PANEL_TRANSITION_MS = 450;
	const DEFAULT_VALUES = {
		layout: "3-col",
		"card-style": "elevated",
		"background-style": "dark",
	};
	const CONTROL_CLASS_SETS = {
		layout: [
			"fu-comparison-cards--layout-auto",
			"fu-comparison-cards--layout-2-col",
			"fu-comparison-cards--layout-3-col",
		],
		"card-style": [
			"fu-comparison-cards--style-clean",
			"fu-comparison-cards--style-elevated",
			"fu-comparison-cards--style-bordered",
		],
		"background-style": [
			"fu-comparison-cards--bg-none",
			"fu-comparison-cards--bg-light",
			"fu-comparison-cards--bg-dark",
			"fu-comparison-cards--bg-brand-tinted",
		],
	};

	const CONTROL_VALUE_MAP = {
		layout: {
			auto: ["fu-comparison-cards--layout-auto"],
			"2-col": ["fu-comparison-cards--layout-2-col"],
			"3-col": ["fu-comparison-cards--layout-3-col"],
		},
		"card-style": {
			clean: ["fu-comparison-cards--style-clean"],
			elevated: ["fu-comparison-cards--style-elevated"],
			bordered: ["fu-comparison-cards--style-bordered"],
		},
		"background-style": {
			none: ["fu-comparison-cards--bg-none"],
			light: ["fu-comparison-cards--bg-light"],
			dark: ["fu-comparison-cards--bg-dark"],
			"brand-tinted": ["fu-comparison-cards--bg-brand-tinted"],
		},
	};

	const detectFirstMatch = (block, entries, fallback) => {
		for (const [value, classList] of Object.entries(entries)) {
			if (classList.some((className) => block.classList.contains(className))) {
				return value;
			}
		}
		return fallback;
	};

	const readValuesFromClassList = (block) => ({
		layout: detectFirstMatch(block, CONTROL_VALUE_MAP.layout, "3-col"),
		cardStyle: detectFirstMatch(
			block,
			CONTROL_VALUE_MAP["card-style"],
			"elevated"
		),
		backgroundStyle: detectFirstMatch(
			block,
			CONTROL_VALUE_MAP["background-style"],
			"dark"
		),
	});

	const syncButtonState = (panel, controlName, value) => {
		panel
			.querySelectorAll(`button[data-demo-control="${controlName}"]`)
			.forEach((button) => {
				const isActive = button.dataset.demoValue === value;
				button.classList.toggle("is-active", isActive);
				button.setAttribute("aria-pressed", isActive ? "true" : "false");
			});
	};

	const syncUI = (panel, values) => {
		syncButtonState(panel, "layout", values.layout);
		syncButtonState(panel, "card-style", values.cardStyle);
		syncButtonState(panel, "background-style", values.backgroundStyle);
	};

	const applyDefaults = (block, panel) => {
		applyClassControl(block, "layout", DEFAULT_VALUES.layout);
		applyClassControl(block, "card-style", DEFAULT_VALUES["card-style"]);
		applyClassControl(
			block,
			"background-style",
			DEFAULT_VALUES["background-style"]
		);

		syncButtonState(panel, "layout", DEFAULT_VALUES.layout);
		syncButtonState(panel, "card-style", DEFAULT_VALUES["card-style"]);
		syncButtonState(
			panel,
			"background-style",
			DEFAULT_VALUES["background-style"]
		);
	};

	const applyClassControl = (block, controlName, value) => {
		const classSet = CONTROL_CLASS_SETS[controlName] || [];
		const nextClasses = CONTROL_VALUE_MAP[controlName]?.[value] || [];
		if (!classSet.length) {
			return;
		}

		block.classList.remove(...classSet);
		if (nextClasses.length) {
			block.classList.add(...nextClasses);
		}
	};

	const initComparisonCardsDemoPanel = () => {
		const panel = document.querySelector(PANEL_SELECTOR);
		const toggle = document.querySelector(TOGGLE_SELECTOR);
		if (!panel || !toggle || panel.dataset.demoPanelInitialized === "true") {
			return Boolean(panel);
		}

		panel.dataset.demoPanelInitialized = "true";

		const closeButton = panel.querySelector(CLOSE_SELECTOR);
		const prefersReducedMotion = window.matchMedia(
			"(prefers-reduced-motion: reduce)"
		);
		let closeTimerId = 0;

		const clearCloseTimer = () => {
			if (!closeTimerId) {
				return;
			}

			window.clearTimeout(closeTimerId);
			closeTimerId = 0;
		};

		const finalizeClose = ({ returnFocus = false } = {}) => {
			clearCloseTimer();
			panel.hidden = true;
			panel.classList.remove("is-closing");

			if (returnFocus) {
				toggle.focus();
			}
		};

		const openPanel = () => {
			clearCloseTimer();
			panel.hidden = false;
			panel.classList.remove("is-closing");
			void panel.offsetWidth;
			panel.classList.add("is-open");
			toggle.classList.add("is-active");
			toggle.setAttribute("aria-expanded", "true");
		};

		const closePanel = ({ returnFocus = false } = {}) => {
			if (!panel.classList.contains("is-open") && panel.hidden) {
				return;
			}

			panel.classList.remove("is-open");
			panel.classList.add("is-closing");
			toggle.classList.remove("is-active");
			toggle.setAttribute("aria-expanded", "false");

			if (prefersReducedMotion.matches) {
				finalizeClose({ returnFocus });
				return;
			}

			clearCloseTimer();
			closeTimerId = window.setTimeout(() => {
				finalizeClose({ returnFocus });
			}, PANEL_TRANSITION_MS + 40);
		};

		closePanel();

		panel.addEventListener("transitionend", (event) => {
			if (event.target !== panel || event.propertyName !== "transform") {
				return;
			}

			if (!panel.classList.contains("is-open")) {
				finalizeClose();
			}
		});

		const targetScope = document.querySelector(TARGET_SCOPE_SELECTOR) || null;
		const block =
			targetScope?.querySelector(".fu-comparison-cards") ||
			document.querySelector(TARGET_SELECTOR) ||
			document.querySelector(FALLBACK_TARGET_SELECTOR) ||
			null;

		if (!block) {
			panel
				.querySelectorAll("button[data-demo-control], .fu-demo-reset")
				.forEach((control) => {
					control.disabled = true;
				});
			return true;
		}

		syncUI(panel, readValuesFromClassList(block));

		panel.addEventListener("click", (event) => {
			const closeTrigger = event.target.closest(CLOSE_SELECTOR);
			if (closeTrigger) {
				event.preventDefault();
				closePanel({ returnFocus: true });
				return;
			}

			const controlButton = event.target.closest(
				"button[data-demo-control][data-demo-value]"
			);
			if (controlButton) {
				event.preventDefault();

				const controlName = controlButton.dataset.demoControl;
				const value = controlButton.dataset.demoValue;
				if (!controlName || !value) {
					return;
				}

				applyClassControl(block, controlName, value);
				syncButtonState(panel, controlName, value);
				return;
			}

			const resetButton = event.target.closest(".fu-demo-reset");
			if (resetButton) {
				event.preventDefault();
				applyDefaults(block, panel);
			}
		});

		toggle.addEventListener("click", (event) => {
			event.preventDefault();

			if (panel.classList.contains("is-open")) {
				closePanel();
				return;
			}

			openPanel();
			closeButton?.focus();
		});

		document.addEventListener("keydown", (event) => {
			if (event.key === "Escape" && panel.classList.contains("is-open")) {
				closePanel({ returnFocus: true });
			}
		});

		return true;
	};

	if (!initComparisonCardsDemoPanel()) {
		if (document.readyState === "loading") {
			document.addEventListener(
				"DOMContentLoaded",
				initComparisonCardsDemoPanel,
				{
					once: true,
				}
			);
		} else {
			window.addEventListener("load", initComparisonCardsDemoPanel, {
				once: true,
			});
		}
	}
})();
