// Front-end demo harness for the Content Switcher portfolio page only.
// This script updates root modifier classes for visual demos and does not persist data.
(function () {
	"use strict";

	const PANEL_SELECTOR = "[data-fu-content-switcher-demo]";
	const TOGGLE_SELECTOR = "[data-fu-content-switcher-demo-toggle]";
	const CLOSE_SELECTOR = "[data-fu-demo-close]";
	const TARGET_SELECTOR =
		"[data-fu-content-switcher-demo-target] .fu-content-switcher";
	const FALLBACK_TARGET_SELECTOR = ".fu-content-switcher";
	const PANEL_TRANSITION_MS = 450;
	const CONTROL_CLASS_SETS = {
		"display-style": [
			"fu-content-switcher--tabs",
			"fu-content-switcher--pills",
			"fu-content-switcher--minimal",
			"fu-content-switcher--vertical",
			"fu-content-switcher--style-tabs",
			"fu-content-switcher--style-pills",
			"fu-content-switcher--style-minimal",
			"fu-content-switcher--style-vertical",
		],
		"switcher-background": [
			"fu-content-switcher--bg-none",
			"fu-content-switcher--bg-light",
			"fu-content-switcher--bg-dark",
		],
		"panel-background": [
			"fu-content-switcher--panel-bg-none",
			"fu-content-switcher--panel-bg-light",
			"fu-content-switcher--panel-bg-dark",
		],
		"panel-radius": [
			"fu-content-switcher--panel-radius-none",
			"fu-content-switcher--panel-radius-small",
			"fu-content-switcher--panel-radius-medium",
			"fu-content-switcher--panel-radius-large",
		],
	};

	const CONTROL_VALUE_MAP = {
		"display-style": {
			tabs: ["fu-content-switcher--tabs"],
			pills: ["fu-content-switcher--pills"],
			minimal: ["fu-content-switcher--minimal"],
			vertical: ["fu-content-switcher--vertical"],
		},
		"switcher-background": {
			none: ["fu-content-switcher--bg-none"],
			light: ["fu-content-switcher--bg-light"],
			dark: ["fu-content-switcher--bg-dark"],
		},
		"panel-background": {
			none: ["fu-content-switcher--panel-bg-none"],
			light: ["fu-content-switcher--panel-bg-light"],
			dark: ["fu-content-switcher--panel-bg-dark"],
		},
		"panel-radius": {
			none: ["fu-content-switcher--panel-radius-none"],
			small: ["fu-content-switcher--panel-radius-small"],
			medium: ["fu-content-switcher--panel-radius-medium"],
			large: ["fu-content-switcher--panel-radius-large"],
		},
	};

	const triggerSwitcherRefresh = () => {
		window.dispatchEvent(new CustomEvent("fuContentSwitcherDemoChange"));
	};

	const detectFirstMatch = (switcher, entries, fallback) => {
		for (const [value, classList] of Object.entries(entries)) {
			if (
				classList.some((className) => switcher.classList.contains(className))
			) {
				return value;
			}
		}
		return fallback;
	};

	const readValuesFromClassList = (switcher) => ({
		displayStyle: detectFirstMatch(
			switcher,
			CONTROL_VALUE_MAP["display-style"],
			"tabs"
		),
		switcherBackground: detectFirstMatch(
			switcher,
			CONTROL_VALUE_MAP["switcher-background"],
			"none"
		),
		panelBackground: detectFirstMatch(
			switcher,
			CONTROL_VALUE_MAP["panel-background"],
			"none"
		),
		panelRadius: detectFirstMatch(
			switcher,
			CONTROL_VALUE_MAP["panel-radius"],
			"none"
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
		syncButtonState(panel, "display-style", values.displayStyle);
		syncButtonState(panel, "switcher-background", values.switcherBackground);
		syncButtonState(panel, "panel-background", values.panelBackground);
		syncButtonState(panel, "panel-radius", values.panelRadius);
	};

	const applyClassControl = (switcher, controlName, value) => {
		const classSet = CONTROL_CLASS_SETS[controlName] || [];
		const nextClasses = CONTROL_VALUE_MAP[controlName]?.[value] || [];
		if (!classSet.length) {
			return;
		}

		switcher.classList.remove(...classSet);
		if (nextClasses.length) {
			switcher.classList.add(...nextClasses);
		}
	};

	const initContentSwitcherDemoPanel = () => {
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

		const switcher =
			document.querySelector(TARGET_SELECTOR) ||
			document.querySelector(FALLBACK_TARGET_SELECTOR) ||
			null;

		if (!switcher) {
			panel
				.querySelectorAll(
					"button[data-demo-control], select[data-demo-control], .fu-demo-reset"
				)
				.forEach((control) => {
					control.disabled = true;
				});
			return true;
		}

		const originalClassName = switcher.className;

		syncUI(panel, readValuesFromClassList(switcher));
		triggerSwitcherRefresh();

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

				applyClassControl(switcher, controlName, value);
				syncButtonState(panel, controlName, value);
				triggerSwitcherRefresh();
				return;
			}

			const resetButton = event.target.closest(".fu-demo-reset");
			if (resetButton) {
				event.preventDefault();
				switcher.className = originalClassName;
				syncUI(panel, readValuesFromClassList(switcher));
				triggerSwitcherRefresh();
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

	if (!initContentSwitcherDemoPanel()) {
		if (document.readyState === "loading") {
			document.addEventListener(
				"DOMContentLoaded",
				initContentSwitcherDemoPanel,
				{
					once: true,
				}
			);
		} else {
			window.addEventListener("load", initContentSwitcherDemoPanel, {
				once: true,
			});
		}
	}
})();
