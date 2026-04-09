(function () {
    "use strict";

    const isEditor = typeof wp !== "undefined" && typeof wp.data !== "undefined";

    /**
     * 1. THE TOGGLE ENGINE (Shared)
     */
    const toggleVideo = (video, banner, button) => {
        if (!video || !banner || !button) return;

        if (video.paused) {
            video
                .play()
                .then(() => {
                    banner.classList.remove("is-paused");
                    button.classList.remove("is-paused");
                    button.setAttribute("aria-pressed", "false");
                    // Remove the manual flag so scroll logic can take over again
                    banner.removeAttribute("data-manual-pause");
                })
                .catch(err => console.warn("Playback blocked:", err));
        } else {
            video.pause();
            banner.classList.add("is-paused");
            button.classList.add("is-paused");
            button.setAttribute("aria-pressed", "true");
            // Set the manual flag so scroll logic ignores this banner
            banner.setAttribute("data-manual-pause", "true");
        }
    };

    /**
     * 2. FRONT-END LOGIC
     */
    const initFrontEnd = () => {
        const banners = document.querySelectorAll(".fu-page-banner[data-pause-on-scroll='true']");

        banners.forEach(banner => {
            const video = banner.querySelector("video");
            const button = banner.querySelector(".fu-banner-mute-toggle");
            if (!video || !button) return;

            // Start in "Paused" UI state to match the video being paused initially
            banner.classList.add("is-paused");
            button.classList.add("is-paused");
            button.setAttribute("aria-pressed", "true");

            // Listen for when video actually starts playing (either via autoplay or user interaction)
            const onPlay = () => {
                banner.classList.remove("is-paused");
                button.classList.remove("is-paused");
                button.setAttribute("aria-pressed", "false");
                banner.removeAttribute("data-manual-pause");
            };

            const onPause = () => {
                banner.classList.add("is-paused");
                button.classList.add("is-paused");
                button.setAttribute("aria-pressed", "true");
            };

            video.addEventListener("play", onPlay);
            video.addEventListener("pause", onPause);

            // Lazy Load Observer
            const loadObserver = new IntersectionObserver(
                (entries, observer) => {
                    entries.forEach(entry => {
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
                entries => {
                    entries.forEach(entry => {
                        if (!video.dataset.loaded) return;

                        // Only auto-play if the user HAS NOT clicked pause manually
                        const hasManualPause = banner.hasAttribute("data-manual-pause");

                        if (entry.isIntersecting && !hasManualPause) {
                            video
                                .play()
                                .then(() => {
                                    banner.classList.remove("is-paused");
                                    button.classList.remove("is-paused");
                                    button.setAttribute("aria-pressed", "false");
                                })
                                .catch(() => {});
                        } else {
                            video.pause();
                            banner.classList.add("is-paused");
                            button.classList.add("is-paused");
                            button.setAttribute("aria-pressed", "true");
                        }
                    });
                },
                { threshold: 0.1 }
            );

            loadObserver.observe(banner);
            controlObserver.observe(banner);

            button.addEventListener("click", e => {
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

        // Watch for changes to visibility fields and trigger preview update
        const visibilityFields = ["show_h2", "show_p", "show_btn_1", "show_btn_2"];
        visibilityFields.forEach(fieldName => {
            acf.addAction(`update_field/key=${fieldName}`, () => {
                acf.doAction("render_block_preview");
            });
        });

        const setupIframeObserver = () => {
            const iframe = document.querySelector('iframe[name="editor-canvas"]');
            if (!iframe) return;
            const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
            if (!iframeDoc) return;

            const fixBanner = banner => {
                const video = banner.querySelector("video");
                const button = banner.querySelector(".fu-banner-mute-toggle");
                if (!video || !button) return;

                if (video.dataset.lazyVideo && !video.src) video.src = video.dataset.lazyVideo;

                video.muted = true;
                // In the editor, autoplay is set, so video will start automatically.
                // Don't force pause; just reflect the current playback state.
                if (video.paused) {
                    banner.classList.add("is-paused");
                    button.classList.add("is-paused");
                } else {
                    banner.classList.remove("is-paused");
                    button.classList.remove("is-paused");
                    button.setAttribute("aria-pressed", "false");
                }

                button.onclick = e => {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleVideo(video, banner, button);
                };
            };

            const observer = new MutationObserver(() => {
                iframeDoc.querySelectorAll(".fu-page-banner").forEach(fixBanner);
            });

            observer.observe(iframeDoc.body, { childList: true, subtree: true });
            iframeDoc.querySelectorAll(".fu-page-banner").forEach(fixBanner);
        };

        acf.addAction("render_block_preview", setupIframeObserver);

        document.addEventListener("click", e => {
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
        document.getElementById("fu-confirm-reset").addEventListener("click", () => {
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
            show_h2: 1,
            show_p: 1,
            show_btn_1: 1,
            show_btn_2: 1
        };
        const fields = acf.getFields({ parent: blockEl });
        if (!fields.length) return;
        fields.forEach(field => {
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
                $inputs.filter(`[value="${value}"]`).prop("checked", true).trigger("change");
                field.$el.find("label").removeClass("selected");
                $inputs.filter(`[value="${value}"]`).closest("label").addClass("selected");
            } else if (type === "true_false") {
                const isChecked = Number(value) === 1;
                field.$el.find('input[type="checkbox"]').prop("checked", isChecked).trigger("change");
                field.$el.find('input[type="hidden"]').val(isChecked ? 1 : 0);
                field.$el.toggleClass("is-checked", isChecked);
            }
        });
        // Force block preview to re-render with new values
        if (typeof acf !== "undefined") {
            acf.doAction("render_block_preview");
        }
    }

    if (isEditor) initEditor();
    else {
        if (document.readyState !== "loading") initFrontEnd();
        else document.addEventListener("DOMContentLoaded", initFrontEnd);
    }
})();
