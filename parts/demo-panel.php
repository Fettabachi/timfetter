<?php
if (!defined('FU_BANNER_ACTIVE')) {
    define('FU_BANNER_ACTIVE', true);
}
?>

<!-- Front End Demo Panel -->
<style>
    /* WordPress Blue Theme */
    :root {
        --wp-blue: #2271b1;
        --fu-accent: #007cba;
    }


    /* -------------------------------- */
    /* Demo Panel Slide Animation */
    /* -------------------------------- */

    .fu-demo-ui {
        position: fixed;
        top: 32px;
        right: 0;
        width: 280px;
        transform: translateX(100%);
        transition: transform 0.45s cubic-bezier(.22, 1, .36, 1);
        background: #fff;
        box-shadow: -5px 0 25px rgba(0, 0, 0, 0.15);
        z-index: 99999;
        border-radius: 8px 0 0 8px;
    }

    /* Panel open state */
    .fu-demo-ui.is-open {
        transform: translateX(0);
    }

    .fu-demo-panel-inner {
        padding: 14px 20px 20px;
        max-height: 80vh;
        overflow-y: auto;
        box-sizing: border-box;
    }

    .fu-demo-group {
        margin-bottom: 18px;
    }

    .fu-demo-group label {
        display: block;
        font-size: 10px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 6px;
        color: #666;
    }

    /* 2-Column Grid Layout */
    .fu-demo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
        gap: 12px;
    }

    .fu-demo-btns {
        display: flex;
        gap: 5px;
    }

    .fu-demo-btns button {
        display: flex;
        justify-content: center;
        align-items: center;
        flex: 1;
        padding: 2px;
        cursor: pointer;
        background: #f0f0f1;
        border: 1px solid #dcdcde;
    }

    .fu-demo-btns button.is-active {
        background: var(--fu-accent);
        color: white;
        border-color: #006799;
    }

    .fu-demo-reset {
        width: 100%;
        padding: 12px;
        background: #d63638;
        color: white;
        border: none;
        cursor: pointer;
        font-weight: bold;
        border-radius: 4px;
        margin-top: 5px;
    }

    .fu-swatch-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
    }

    .fu-swatch {
        height: 30px;
        border-radius: 4px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }

    .fu-swatch.is-active {
        border: 2px solid var(--fu-accent) !important;
        box-shadow: 0 0 0 2px #fff inset;
    }

    .fu-demo-group input[type="range"] {
        width: 100%;
    }

    .label-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    output {
        font-family: monospace;
        font-size: 10px;
        background: #eee;
        padding: 2px 5px;
        border-radius: 3px;
        color: var(--fu-accent);
    }

    /* Compact Checkbox Group */
    .fu-demo-toggles {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        background: #f9f9f9;
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #eee;
    }

    .fu-demo-toggles label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 11px !important;
        /* Smaller text for labels */
        text-transform: none !important;
        color: #444 !important;
        cursor: pointer;
        margin-bottom: 0 !important;
    }

    .fu-demo-toggles input[type="checkbox"] {
        margin: 0;
        cursor: pointer;
    }

    /* Range Inputs */
    input[type="range"] {
        accent-color: var(--wp-blue);
    }

    /* Safari-specific range styling */
    input[type="range"]::-webkit-slider-track {
        background: #dcdcde;
        height: 4px;
        border-radius: 2px;
        border: none;
    }

    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        background: var(--wp-blue);
        border: none;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        cursor: pointer;
    }

    input[type="range"]::-webkit-slider-thumb:hover {
        background: #135e96;
    }

    /* Firefox-specific range styling */
    input[type="range"]::-moz-range-track {
        background: #dcdcde;
        height: 4px;
        border-radius: 2px;
        border: none;
    }

    input[type="range"]::-moz-range-thumb {
        background: var(--wp-blue);
        border: none;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        cursor: pointer;
    }

    input[type="range"]::-moz-range-thumb:hover {
        background: #135e96;
    }

    /* Select Elements */
    select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background: white;
        border: 1px solid #dcdcde;
        border-radius: 4px;
        padding: 8px 12px;
        font-size: 14px;
        color: #333;
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 8px center;
        background-repeat: no-repeat;
        background-size: 16px;
        padding-right: 32px;
    }

    select:focus {
        outline: none;
        border-color: #007cba;
        box-shadow: 0 0 0 1px #007cba;
    }

    /* Active Buttons */
    .fu-demo-btns button.is-active {
        background: var(--wp-blue) !important;
        color: white !important;
        border-color: #135e96 !important;
    }

    /* Compact Toggle Grid */
    .fu-demo-toggles {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        background: #f6f7f7;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #dcdcde;
    }

    .fu-demo-toggles label {
        font-size: 11px !important;
        text-transform: none !important;
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }

    .fu-demo-close {
        display: flex;
        position: absolute;
        top: 10px;
        right: 10px;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 18px;
        color: #666;
        padding: 4px;
        border-radius: 4px;
        transition: background 0.2s;
    }

    .fu-demo-close:hover {
        background: #f0f0f1;
        color: #333;
    }
</style>

<div class="fu-demo-ui" id="fuDemoPanel">

    <div class="fu-demo-panel-inner">
        <button class="fu-demo-close" onclick="document.getElementById('fuDemoPanel').classList.remove('is-open'); document.querySelectorAll('.fu-banner-config-toggle.is-active').forEach(b => b.classList.remove('is-active'));" aria-label="Close Panel">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
            </svg>
        </button>
        <h3 style="margin-top: 0; font-size: 16px">Banner Block Live Controls</h3>

        <div class="fu-demo-group">
            <label>Content Alignment</label>
            <div class="fu-demo-btns" id="alignGroup">
                <button onclick="updateBannerAlign('left', this)" title="Align Left">
                    <svg width="30" height="30" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M4 5h12v1.5H4V5zm0 4h8v1.5H4V9zm0 4h12v1.5H4V13z" />
                    </svg>
                </button>
                <button class="is-active" onclick="updateBannerAlign('center', this)" title="Align Center">
                    <svg width="30" height="30" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M4 5h12v1.5H4V5zm2 4h8v1.5H6V9zm-2 4h12v1.5H4V13z" />
                    </svg>
                </button>
                <button onclick="updateBannerAlign('right', this)" title="Align Right">
                    <svg width="30" height="30" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M4 5h12v1.5H4V5zm4 4h8v1.5H8V9zm-4 4h12v1.5H4V13z" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="fu-demo-group">
            <label>Visibility</label>
            <div class="fu-demo-toggles">
                <label><input type="checkbox" id="check-h2" onchange="updateVisibility('hide-h2', this.checked)" /> Subhead</label>
                <label><input type="checkbox" id="check-p" onchange="updateVisibility('hide-p', this.checked)" /> Text</label>
                <label><input type="checkbox" id="check-btn1" onchange="updateVisibility('hide-btn-1', this.checked)" /> Button 1</label>
                <label><input type="checkbox" id="check-btn2" onchange="updateVisibility('hide-btn-2', this.checked)" /> Button 2</label>
            </div>
        </div>

        <div class="fu-demo-group">
            <label>Overlay: Brand Color</label>
            <div class="fu-swatch-grid" id="colorGroup">
                <button class="fu-swatch" style="background: #f95738" onclick="updateColor('#f95738', this)"></button>
                <button class="fu-swatch" style="background: #0d3b66" onclick="updateColor('#0d3b66', this)"></button>
                <button class="fu-swatch" style="background: #f4d35e" onclick="updateColor('#f4d35e', this)"></button>
                <button class="fu-swatch is-active" style="background: #000000" onclick="updateColor('#000000', this)"></button>
            </div>
        </div>

        <div class="fu-demo-grid">
            <div class="fu-demo-group">
                <div class="label-row"><label>Opacity</label><output id="opacVal">0.5</output></div>
                <input type="range" min="0" max="100" value="50" oninput="updateRange('--banner-overlay-opacity', this.value / 100, 'opacVal')" />
            </div>

            <div class="fu-demo-group">
                <div class="label-row"><label>Blur On Pause</label><output id="blurVal">10px</output></div>
                <input type="range" min="0" max="40" value="10" oninput="updatePauseBlur(this.value, 'blurVal')" />
            </div>
        </div>

        <div class="fu-demo-grid">
            <div class="fu-demo-group">
                <div class="label-row"><label>Contrast</label><output id="contVal">100%</output></div>
                <input type="range" min="50" max="150" value="100" oninput="updateRange('--banner-contrast', this.value + '%', 'contVal')" />
            </div>

            <div class="fu-demo-group">
                <div class="label-row"><label>Grayscale</label><output id="grayVal">0%</output></div>
                <input type="range" min="0" max="100" value="0" oninput="updateRange('--banner-grayscale', this.value + '%', 'grayVal')" />
            </div>
        </div>

        <div class="fu-demo-group">
            <label>Overlay: Blend Mode</label>
            <select onchange="updateBannerVar('--banner-blend-mode', this.value)" style="width: 100%; padding: 8px; border: 1px solid #dcdcde">
                <option value="normal">Normal</option>
                <option value="multiply">Multiply</option>
                <option value="screen">Screen</option>
                <option value="overlay">Overlay</option>
            </select>
        </div>

        <button class="fu-demo-reset" onclick="resetThisPanel()">Reset View</button>
    </div>
</div>

<script>
    (function() {
        "use strict";

        const panel = document.getElementById('fuDemoPanel');
        if (!panel) return;

        const panelSelectors = sel => panel.querySelector(sel);
        const panelSelectorsAll = sel => panel.querySelectorAll(sel);

        let activeBanner = null;
        let activeVideo = null;
        let state = null;
        let storageKey = '';

        // 1. Single Source of Truth: Defaults
        const DEFAULTS = {
            vars: {
                "--banner-overlay-opacity": "0.5",
                "--banner-contrast": "100%",
                "--banner-grayscale": "0%",
                "--banner-overlay-color": "#000000",
                "--banner-blend-mode": "normal"
            },
            pauseBlur: "10px",
            align: "center",
            visibility: {
                "hide-h2": true, // true = visible
                "hide-p": true,
                "hide-btn-1": true,
                "hide-btn-2": true
            }
        };

        // helper to read current banner values from the DOM
        const readFromDOM = (banner) => {
            const vars = {};
            Object.keys(DEFAULTS.vars).forEach(key => {
                const val = banner.style.getPropertyValue(key);
                vars[key] = val ? val.trim() : DEFAULTS.vars[key];
            });

            let pauseBlur = banner.style.getPropertyValue("--banner-blur") || DEFAULTS.pauseBlur;
            pauseBlur = pauseBlur.trim() || DEFAULTS.pauseBlur;

            let align = DEFAULTS.align;
            if (banner.classList.contains("fu-page-banner--align-left")) align = "left";
            else if (banner.classList.contains("fu-page-banner--align-right")) align = "right";
            else if (banner.classList.contains("fu-page-banner--align-center")) align = "center";

            const visibility = {};
            Object.keys(DEFAULTS.visibility).forEach(className => {
                visibility[className] = !banner.classList.contains(className);
            });

            return {
                vars,
                pauseBlur,
                align,
                visibility
            };
        };

        // 2. Panel helpers -------------------------------------------------
        const loadState = (banner) => {
            storageKey = `fuBannerState-${banner.id || 'generic'}`;
            let s = null;
            const stored = sessionStorage.getItem(storageKey);
            if (stored) {
                try {
                    s = JSON.parse(stored);
                } catch (e) {
                    s = null;
                }
                if (s && !s.__userModified) {
                    s = null;
                }
            }
            if (!s) {
                s = readFromDOM(banner);
            }
            return s;
        };

        /**
         * CORE SYNC ENGINE
         * Reflect current `state` on both the banner and the panel UI.
         */
        const syncUI = () => {
            if (!activeBanner) return;

            // Banner updates
            Object.entries(state.vars).forEach(([key, val]) => {
                activeBanner.style.setProperty(key, val);
            });
            activeBanner.classList.remove("fu-page-banner--align-left", "fu-page-banner--align-center", "fu-page-banner--align-right");
            activeBanner.classList.add(`fu-page-banner--align-${state.align}`);
            Object.entries(state.visibility).forEach(([className, isVisible]) => {
                activeBanner.classList.toggle(className, !isVisible);
            });
            if (activeVideo && activeVideo.paused) {
                activeBanner.style.setProperty("--banner-blur", state.pauseBlur);
            }

            // Panel UI updates
            Object.entries(state.vars).forEach(([key, val]) => {
                const input = panelSelectors(`input[oninput*="${key}"]`);
                if (input) input.value = key.includes("opacity") ? val * 100 : val.replace("%", "");

                const outputMap = {
                    "--banner-overlay-opacity": "opacVal",
                    "--banner-contrast": "contVal",
                    "--banner-grayscale": "grayVal"
                };
                if (outputMap[key]) {
                    const out = panelSelectors(`#${outputMap[key]}`);
                    if (out) out.textContent = val;
                }
            });

            Object.entries(state.visibility).forEach(([className, isVisible]) => {
                const checkbox = panelSelectors(`input[onchange*="${className}"]`);
                if (checkbox) checkbox.checked = isVisible;
            });

            panelSelectorsAll("#alignGroup button").forEach(btn => {
                btn.classList.toggle("is-active", btn.getAttribute("onclick").includes(`'${state.align}'`));
            });

            panelSelectorsAll("#colorGroup .fu-swatch").forEach(swatch => {
                const hexColor = swatch.getAttribute("onclick")?.match(/'([^']+)'/)?.[1] || "";
                swatch.classList.toggle("is-active", hexColor === state.vars["--banner-overlay-color"]);
            });

            const blurVal = panelSelectors("#blurVal");
            if (blurVal) blurVal.textContent = state.pauseBlur;

            const blurSlider = panelSelectors('input[oninput*="updatePauseBlur"]');
            if (blurSlider) blurSlider.value = parseInt(state.pauseBlur);

            const blendSelect = panelSelectors('select[onchange*="updateBannerVar"]');
            if (blendSelect) blendSelect.value = state.vars["--banner-blend-mode"];

            // Hide blur control if no video
            const blurGroup = panelSelectors('[oninput*="updatePauseBlur"]').closest('.fu-demo-group');
            if (blurGroup) {
                blurGroup.style.display = activeVideo ? 'block' : 'none';
            }

            sessionStorage.setItem(storageKey, JSON.stringify(state));
        };

        // 3. EXPOSED ACTIONS (Attached to Window for HTML button access)
        window.updateRange = (variable, value, outputId) => {
            if (!activeBanner || !state) return;
            state.vars[variable] = variable.includes('opacity') ? value : value;
            state.__userModified = true;
            syncUI();
        };

        window.updateVisibility = (className, isChecked) => {
            if (!activeBanner || !state) return;
            state.visibility[className] = isChecked;
            state.__userModified = true;
            syncUI();
        };

        window.updatePauseBlur = (val) => {
            if (!activeBanner || !state) return;
            state.pauseBlur = val + "px";
            state.__userModified = true;
            syncUI();
        };

        window.updateBannerAlign = (align) => {
            if (!activeBanner || !state) return;
            state.align = align;
            state.__userModified = true;
            syncUI();
        };

        window.updateColor = (color) => {
            if (!activeBanner || !state) return;
            state.vars["--banner-overlay-color"] = color;
            state.__userModified = true;
            syncUI();
        };

        window.updateBannerVar = (variable, value) => {
            if (!activeBanner || !state) return;
            state.vars[variable] = value;
            state.__userModified = true;
            syncUI();
        };

        // exposed reset helper; scoped per-banner during initialization
        window.resetThisPanel = () => {
            if (!activeBanner) return;
            sessionStorage.removeItem(storageKey);
            state = JSON.parse(JSON.stringify(DEFAULTS));
            syncUI();
        };

        // when a banner toggle is clicked, prepare panel for that banner (event delegation)
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('.fu-banner-config-toggle');
            if (!btn) return;
            const id = btn.dataset.bannerId;
            const banner = document.getElementById(id);
            if (!banner) return;

            // Check if panel is open and this is the same banner - if so, close it
            if (panel.classList.contains('is-open') && activeBanner && activeBanner.id === id) {
                panel.classList.remove('is-open');
                document.querySelectorAll('.fu-banner-config-toggle.is-active').forEach(b => b.classList.remove('is-active'));
                return;
            }

            // remove active class from any other toggle
            document.querySelectorAll('.fu-banner-config-toggle.is-active').forEach(b => b.classList.remove('is-active'));
            btn.classList.add('is-active');

            activeBanner = banner;
            activeVideo = banner.querySelector('video');
            state = loadState(banner);
            // wire up blur update if a video exists (use current state)
            if (activeVideo) {
                activeVideo.addEventListener('pause', () => activeBanner.style.setProperty('--banner-blur', state.pauseBlur));
                activeVideo.addEventListener('play', () => activeBanner.style.setProperty('--banner-blur', '0px'));
            }
            syncUI();
            panel.classList.add('is-open');
        });

        // Click outside to close panel
        document.addEventListener('click', (e) => {
            if (!panel.contains(e.target) && !e.target.closest('.fu-banner-config-toggle')) {
                panel.classList.remove('is-open');
                document.querySelectorAll('.fu-banner-config-toggle.is-active').forEach(b => b.classList.remove('is-active'));
            }
        });

        // Escape key to close panel
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                panel.classList.remove('is-open');
                document.querySelectorAll('.fu-banner-config-toggle.is-active').forEach(b => b.classList.remove('is-active'));
            }
        });

        // initialize panel for first banner on page load if the banner is visible
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initFirstBanner);
        } else {
            initFirstBanner();
        }

        function initFirstBanner() {
            const firstToggle = document.querySelector('.fu-banner-config-toggle');
            if (firstToggle && !activeBanner) {
                const bannerId = firstToggle.dataset.bannerId;
                const banner = document.getElementById(bannerId);
                if (banner) {
                    activeBanner = banner;
                    activeVideo = banner.querySelector('video');
                    state = loadState(banner);
                    if (activeVideo) {
                        activeVideo.addEventListener('pause', () => activeBanner.style.setProperty('--banner-blur', state.pauseBlur));
                        activeVideo.addEventListener('play', () => activeBanner.style.setProperty('--banner-blur', '0px'));
                    }
                    syncUI();
                }
            }
        }
        // no initial sync; panel opens when a banner is targeted
    })();
</script>