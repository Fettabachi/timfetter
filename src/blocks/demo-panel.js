// Front-end demo harness for the page-banner block.
// This script only drives the showcase panel and does not power banner rendering.
(function () {
	"use strict";

	const initDemoPanel = () => {
		const panel = document.getElementById("fuDemoPanel");
		if (!panel || panel.dataset.demoPanelInitialized === "true") {
			return Boolean(panel);
		}

		panel.dataset.demoPanelInitialized = "true";

		const panelSelector = (selector) => panel.querySelector(selector);
		const panelSelectorAll = (selector) => panel.querySelectorAll(selector);
		const mobileAlignmentQuery = window.matchMedia("(max-width: 47.99rem)");

		let activeBanner = null;
		let activeVideo = null;
		let state = null;
		let storageKey = "";
		const resetBaselines = new Map();

		const DEFAULTS = {
			vars: {
				"--banner-overlay-opacity": "0.5",
				"--banner-contrast": "100%",
				"--banner-grayscale": "0%",
				"--banner-overlay-color": "#000000",
				"--banner-blend-mode": "normal",
				"--banner-saturate": "100%",
				"--banner-video-focal-point": "center center",
			},
			pauseBlur: "10px",
			align: "center",
			visibility: {
				"hide-subhead": true,
				"hide-body": true,
				"hide-btn-1": true,
				"hide-btn-2": true,
			},
		};

		const cloneState = (value) => JSON.parse(JSON.stringify(value));

		const getBannerStateKey = (banner) => banner.id || "generic";

		const getSavedVar = (banner, variable) => {
			const dataValues = {
				"--banner-overlay-opacity": banner.dataset.overlayOpacity
					? String(Number(banner.dataset.overlayOpacity) / 100)
					: "",
				"--banner-contrast": banner.dataset.overlayContrast
					? `${banner.dataset.overlayContrast}%`
					: "",
				"--banner-grayscale": banner.dataset.overlayGrayscale
					? `${Number(banner.dataset.overlayGrayscale) * 100}%`
					: "",
				"--banner-overlay-color": banner.dataset.overlayColor || "",
				"--banner-blend-mode": banner.dataset.overlayBlendMode || "",
				"--banner-saturate": banner.dataset.bannerSaturation
					? `${banner.dataset.bannerSaturation}%`
					: "",
				"--banner-video-focal-point": banner.dataset.bgFocalPoint || "",
			};

			const dataValue = dataValues[variable];
			if (dataValue) return dataValue;

			const styleValue = banner.style.getPropertyValue(variable);
			return styleValue ? styleValue.trim() : DEFAULTS.vars[variable];
		};

		const closePanel = () => {
			panel.classList.remove("is-open");
			document
				.querySelectorAll(".fu-banner-config-toggle.is-active")
				.forEach((button) => button.classList.remove("is-active"));
		};

		const bindVideoStateListeners = (video) => {
			if (!video || video.dataset.demoPanelBound === "true") return;

			video.addEventListener("pause", () => {
				if (activeVideo !== video || !activeBanner || !state) return;
				activeBanner.style.setProperty("--banner-blur", state.pauseBlur);
			});

			video.addEventListener("play", () => {
				if (activeVideo !== video || !activeBanner) return;
				activeBanner.style.setProperty("--banner-blur", "0px");
			});

			video.dataset.demoPanelBound = "true";
		};

		const readFromDOM = (banner) => {
			const vars = {};

			Object.keys(DEFAULTS.vars).forEach((key) => {
				vars[key] = getSavedVar(banner, key);
			});

			let pauseBlur =
				(banner.dataset.blurOnPause
					? `${banner.dataset.blurOnPause}px`
					: banner.style.getPropertyValue("--banner-blur")) ||
				DEFAULTS.pauseBlur;
			pauseBlur = pauseBlur.trim() || DEFAULTS.pauseBlur;

			let align = banner.dataset.contentAlignment || DEFAULTS.align;
			if (banner.classList.contains("fu-page-banner--align-left"))
				align = "left";
			else if (banner.classList.contains("fu-page-banner--align-right")) {
				align = "right";
			} else if (banner.classList.contains("fu-page-banner--align-center")) {
				align = "center";
			}

			const visibility = {};
			visibility["hide-subhead"] =
				banner.dataset.showSubhead !== undefined
					? banner.dataset.showSubhead !== "0"
					: !banner.classList.contains("hide-subhead");
			visibility["hide-body"] =
				banner.dataset.showBody !== undefined
					? banner.dataset.showBody !== "0"
					: !banner.classList.contains("hide-body");
			visibility["hide-btn-1"] =
				banner.dataset.showBtn1 !== undefined
					? banner.dataset.showBtn1 !== "0"
					: !banner.classList.contains("hide-btn-1");
			visibility["hide-btn-2"] =
				banner.dataset.showBtn2 !== undefined
					? banner.dataset.showBtn2 !== "0"
					: !banner.classList.contains("hide-btn-2");

			return {
				vars,
				pauseBlur,
				align,
				visibility,
			};
		};

		const captureResetBaseline = (banner) => {
			const key = getBannerStateKey(banner);
			if (!resetBaselines.has(key)) {
				resetBaselines.set(key, readFromDOM(banner));
			}

			return resetBaselines.get(key);
		};

		const loadState = (banner) => {
			storageKey = `fuBannerState-${getBannerStateKey(banner)}`;
			const resetBaseline = captureResetBaseline(banner);
			let nextState = null;
			const stored = sessionStorage.getItem(storageKey);

			if (stored) {
				try {
					nextState = JSON.parse(stored);
				} catch (error) {
					nextState = null;
				}

				if (nextState && !nextState.__userModified) {
					nextState = null;
				}
			}

			if (!nextState) {
				nextState = cloneState(resetBaseline);
			}

			return nextState;
		};

		const syncUI = () => {
			if (!activeBanner || !state) return;

			Object.entries(state.vars).forEach(([key, value]) => {
				activeBanner.style.setProperty(key, value);
			});

			activeBanner.classList.remove(
				"fu-page-banner--align-left",
				"fu-page-banner--align-center",
				"fu-page-banner--align-right"
			);
			activeBanner.classList.add(`fu-page-banner--align-${state.align}`);

			Object.entries(state.visibility).forEach(([className, isVisible]) => {
				activeBanner.classList.toggle(className, !isVisible);
			});

			if (activeVideo && activeVideo.paused) {
				activeBanner.style.setProperty("--banner-blur", state.pauseBlur);
			}

			panelSelectorAll("input[data-banner-var]").forEach((input) => {
				const variable = input.dataset.bannerVar;
				const value = state.vars[variable];
				if (typeof value !== "string") return;

				input.value =
					variable === "--banner-overlay-opacity"
						? String(Math.round(Number.parseFloat(value) * 100))
						: value.replace("%", "");

				const output = panelSelector(`#${input.dataset.outputId}`);
				if (output) {
					output.textContent = value;
				}
			});

			panelSelectorAll("input[data-visibility-class]").forEach((input) => {
				input.checked = Boolean(
					state.visibility[input.dataset.visibilityClass]
				);
			});

			panelSelectorAll("#alignGroup button[data-align]").forEach((button) => {
				button.classList.toggle(
					"is-active",
					button.dataset.align === state.align
				);
			});

			panelSelectorAll("#colorGroup .fu-swatch[data-color]").forEach(
				(swatch) => {
					swatch.classList.toggle(
						"is-active",
						swatch.dataset.color === state.vars["--banner-overlay-color"]
					);
				}
			);

			const blurOutput = panelSelector("#blurVal");
			if (blurOutput) {
				blurOutput.textContent = state.pauseBlur;
			}

			const blurSlider = panelSelector("#blurRange");
			if (blurSlider) {
				blurSlider.value = String(Number.parseInt(state.pauseBlur, 10) || 0);
			}

			const blendSelect = panelSelector("#blendModeSelect");
			if (blendSelect) {
				blendSelect.value = state.vars["--banner-blend-mode"];
			}

			const blurGroup = panelSelector("#blurRange")?.closest(".fu-demo-group");
			if (blurGroup) {
				blurGroup.style.display = activeVideo ? "block" : "none";
			}

			const alignmentGroup = panelSelector(".fu-demo-group--alignment");
			if (alignmentGroup) {
				alignmentGroup.style.display = mobileAlignmentQuery.matches
					? "none"
					: "block";
			}

			sessionStorage.setItem(storageKey, JSON.stringify(state));
		};

		const setActiveBanner = (banner) => {
			activeBanner = banner;
			activeVideo = banner.querySelector("video");
			state = loadState(banner);
			bindVideoStateListeners(activeVideo);
			syncUI();
		};

		panel.addEventListener("click", (event) => {
			const closeButton = event.target.closest(".fu-demo-close");
			if (closeButton) {
				event.preventDefault();
				closePanel();
				return;
			}

			const alignButton = event.target.closest(
				"#alignGroup button[data-align]"
			);
			if (alignButton) {
				event.preventDefault();
				if (!activeBanner || !state || mobileAlignmentQuery.matches) return;
				state.align = alignButton.dataset.align;
				state.__userModified = true;
				syncUI();
				return;
			}

			const swatch = event.target.closest("#colorGroup .fu-swatch[data-color]");
			if (swatch) {
				event.preventDefault();
				if (!activeBanner || !state) return;
				state.vars["--banner-overlay-color"] = swatch.dataset.color;
				state.__userModified = true;
				syncUI();
				return;
			}

			const resetButton = event.target.closest(".fu-demo-reset");
			if (resetButton) {
				event.preventDefault();
				if (!activeBanner) return;
				sessionStorage.removeItem(storageKey);
				state = cloneState(captureResetBaseline(activeBanner));
				syncUI();
			}
		});

		panel.addEventListener("input", (event) => {
			if (!activeBanner || !state) return;

			const rangeInput = event.target.closest("input[data-banner-var]");
			if (rangeInput) {
				const variable = rangeInput.dataset.bannerVar;
				state.vars[variable] =
					variable === "--banner-overlay-opacity"
						? String(Number(rangeInput.value) / 100)
						: `${rangeInput.value}%`;
				state.__userModified = true;
				syncUI();
				return;
			}

			const blurInput = event.target.closest("#blurRange");
			if (blurInput) {
				state.pauseBlur = `${blurInput.value}px`;
				state.__userModified = true;
				syncUI();
				return;
			}

			const visibilityInput = event.target.closest(
				"input[data-visibility-class]"
			);
			if (visibilityInput) {
				state.visibility[visibilityInput.dataset.visibilityClass] =
					visibilityInput.checked;
				state.__userModified = true;
				syncUI();
				return;
			}

			const selectInput = event.target.closest("select[data-banner-var]");
			if (selectInput) {
				state.vars[selectInput.dataset.bannerVar] = selectInput.value;
				state.__userModified = true;
				syncUI();
			}
		});

		document.addEventListener("click", (event) => {
			const toggle = event.target.closest(".fu-banner-config-toggle");
			if (toggle) {
				const bannerId = toggle.dataset.bannerId;
				const banner = document.getElementById(bannerId);
				if (!banner) return;

				if (
					panel.classList.contains("is-open") &&
					activeBanner &&
					activeBanner.id === bannerId
				) {
					closePanel();
					return;
				}

				document
					.querySelectorAll(".fu-banner-config-toggle.is-active")
					.forEach((button) => button.classList.remove("is-active"));
				toggle.classList.add("is-active");

				setActiveBanner(banner);
				panel.classList.add("is-open");
				return;
			}

			if (!panel.contains(event.target)) {
				closePanel();
			}
		});

		document.addEventListener("keydown", (event) => {
			if (event.key === "Escape") {
				closePanel();
			}
		});

		const initFirstBanner = () => {
			const firstToggle = document.querySelector(".fu-banner-config-toggle");
			if (!firstToggle || activeBanner) return;

			const bannerId = firstToggle.dataset.bannerId;
			const banner = document.getElementById(bannerId);
			if (!banner) return;

			setActiveBanner(banner);
		};

		initFirstBanner();

		if (typeof mobileAlignmentQuery.addEventListener === "function") {
			mobileAlignmentQuery.addEventListener("change", syncUI);
		} else if (typeof mobileAlignmentQuery.addListener === "function") {
			mobileAlignmentQuery.addListener(syncUI);
		}

		return true;
	};

	if (!initDemoPanel()) {
		if (document.readyState === "loading") {
			document.addEventListener("DOMContentLoaded", initDemoPanel, {
				once: true,
			});
		} else {
			window.addEventListener("load", initDemoPanel, { once: true });
		}
	}
})();
