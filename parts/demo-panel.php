<!--
    Front-end demo harness for the page-banner block.
    This panel is meant to showcase banner states in the browser and is not part
    of the block's core rendering logic.
-->
<div class="fu-demo-ui" id="fuDemoPanel">

    <div class="fu-demo-panel-inner">
        <button type="button" class="fu-demo-close" aria-label="Close Panel">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
            </svg>
        </button>
        <h3 class="fu-demo-title">Banner Block Live Controls</h3>

        <div class="fu-demo-group fu-demo-group--alignment">
            <label>Content Alignment</label>
            <div class="fu-demo-btns" id="alignGroup">
                <button type="button" data-align="left" title="Align Left">
                    <svg width="30" height="30" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M4 5h12v1.5H4V5zm0 4h8v1.5H4V9zm0 4h12v1.5H4V13z" />
                    </svg>
                </button>
                <button type="button" class="is-active" data-align="center" title="Align Center">
                    <svg width="30" height="30" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M4 5h12v1.5H4V5zm2 4h8v1.5H6V9zm-2 4h12v1.5H4V13z" />
                    </svg>
                </button>
                <button type="button" data-align="right" title="Align Right">
                    <svg width="30" height="30" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M4 5h12v1.5H4V5zm4 4h8v1.5H8V9zm-4 4h12v1.5H4V13z" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="fu-demo-group">
            <label>Visibility</label>
            <div class="fu-demo-toggles">
                <label><input type="checkbox" id="check-h2" data-visibility-class="hide-h2" /> Subhead</label>
                <label><input type="checkbox" id="check-p" data-visibility-class="hide-p" /> Text</label>
                <label><input type="checkbox" id="check-btn1" data-visibility-class="hide-btn-1" /> Button 1</label>
                <label><input type="checkbox" id="check-btn2" data-visibility-class="hide-btn-2" /> Button 2</label>
            </div>
        </div>

        <div class="fu-demo-group">
            <label>Overlay: Brand Color</label>
            <div class="fu-swatch-grid" id="colorGroup">
                <button type="button" class="fu-swatch fu-swatch--orange" data-color="#f95738"></button>
                <button type="button" class="fu-swatch fu-swatch--blue" data-color="#0d3b66"></button>
                <button type="button" class="fu-swatch fu-swatch--yellow" data-color="#f4d35e"></button>
                <button type="button" class="fu-swatch fu-swatch--black is-active" data-color="#000000"></button>
            </div>
        </div>

        <div class="fu-demo-grid">
            <div class="fu-demo-group">
                <div class="label-row"><label>Opacity</label><output id="opacVal">0.5</output></div>
                <input type="range" id="opacRange" min="0" max="100" value="50" data-banner-var="--banner-overlay-opacity" data-output-id="opacVal" />
            </div>

            <div class="fu-demo-group">
                <div class="label-row"><label>Blur On Pause</label><output id="blurVal">10px</output></div>
                <input type="range" id="blurRange" min="0" max="40" value="10" />
            </div>
        </div>

        <div class="fu-demo-grid">
            <div class="fu-demo-group">
                <div class="label-row"><label>Contrast</label><output id="contVal">100%</output></div>
                <input type="range" id="contRange" min="50" max="150" value="100" data-banner-var="--banner-contrast" data-output-id="contVal" />
            </div>

            <div class="fu-demo-group">
                <div class="label-row"><label>Grayscale</label><output id="grayVal">0%</output></div>
                <input type="range" id="grayRange" min="0" max="100" value="0" data-banner-var="--banner-grayscale" data-output-id="grayVal" />
            </div>
        </div>

        <div class="fu-demo-group">
            <label>Overlay: Blend Mode</label>
            <select id="blendModeSelect" class="fu-demo-select" data-banner-var="--banner-blend-mode">
                <option value="normal">Normal</option>
                <option value="multiply">Multiply</option>
                <option value="screen">Screen</option>
                <option value="overlay">Overlay</option>
            </select>
        </div>

        <button type="button" class="fu-demo-reset">Reset View</button>
    </div>
</div>