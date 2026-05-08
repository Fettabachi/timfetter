<!--
    Front-end demo harness for the Comparison Cards portfolio page.
    This panel is for portfolio presentation only and does not affect block rendering.
-->
<div class="fu-demo-ui fu-demo-ui--comparison-cards" id="fuComparisonCardsDemoPanel" data-demo-type="comparison-cards" data-fu-comparison-cards-demo role="dialog" aria-labelledby="fuComparisonCardsDemoTitle" hidden>
    <div class="fu-demo-panel-inner">
        <div class="fu-demo-header">
            <h3 class="fu-demo-title" id="fuComparisonCardsDemoTitle">Comparison Cards Live Controls</h3>
            <button type="button" class="fu-demo-close" data-fu-demo-close aria-label="Close Comparison Cards demo controls">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" focusable="false">
                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                </svg>
            </button>
        </div>

        <p class="fu-demo-note">These live controls are for demo purposes only. The production block is configured in the WordPress editor.</p>

        <div class="fu-demo-group fu-demo-group--desktop-only">
            <p class="fu-demo-group-label" id="fu-cc-demo-layout-label">Layout</p>
            <div class="fu-demo-btns fu-demo-btns--text fu-demo-btns--wrap" role="group" aria-labelledby="fu-cc-demo-layout-label">
                <button type="button" aria-pressed="false" data-demo-control="layout" data-demo-value="auto">Auto</button>
                <button type="button" aria-pressed="false" data-demo-control="layout" data-demo-value="2-col">2 Columns</button>
                <button type="button" class="is-active" aria-pressed="true" data-demo-control="layout" data-demo-value="3-col">3 Columns</button>
            </div>
        </div>

        <div class="fu-demo-group">
            <p class="fu-demo-group-label" id="fu-cc-demo-style-label">Card Style</p>
            <div class="fu-demo-btns fu-demo-btns--text fu-demo-btns--wrap" role="group" aria-labelledby="fu-cc-demo-style-label">
                <button type="button" aria-pressed="false" data-demo-control="card-style" data-demo-value="clean">Clean</button>
                <button type="button" class="is-active" aria-pressed="true" data-demo-control="card-style" data-demo-value="elevated">Elevated</button>
                <button type="button" aria-pressed="false" data-demo-control="card-style" data-demo-value="bordered">Bordered</button>
            </div>
        </div>

        <div class="fu-demo-group">
            <p class="fu-demo-group-label" id="fu-cc-demo-background-label">Background Style</p>
            <div class="fu-demo-btns fu-demo-btns--text fu-demo-btns--wrap" role="group" aria-labelledby="fu-cc-demo-background-label">
                <button type="button" aria-pressed="false" data-demo-control="background-style" data-demo-value="none">None</button>
                <button type="button" aria-pressed="false" data-demo-control="background-style" data-demo-value="light">Light</button>
                <button type="button" class="is-active" aria-pressed="true" data-demo-control="background-style" data-demo-value="dark">Dark</button>
                <button type="button" aria-pressed="false" data-demo-control="background-style" data-demo-value="brand-tinted">Brand Tinted</button>
            </div>
        </div>

        <button type="button" class="fu-demo-reset">Reset View</button>
    </div>
</div>