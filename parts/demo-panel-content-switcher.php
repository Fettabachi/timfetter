<!--
    Front-end demo harness for the content-switcher portfolio page.
    This panel is for portfolio presentation only and does not affect block rendering.
-->
<div class="fu-demo-ui fu-demo-ui--content-switcher" id="fuContentSwitcherDemoPanel" data-demo-type="content-switcher" data-fu-content-switcher-demo role="dialog" aria-labelledby="fuContentSwitcherDemoTitle" hidden>
    <div class="fu-demo-panel-inner">
        <div class="fu-demo-header">
            <h3 class="fu-demo-title" id="fuContentSwitcherDemoTitle">Content Switcher Live Controls</h3>
            <button type="button" class="fu-demo-close" data-fu-demo-close aria-label="Close Controls">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" focusable="false">
                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                </svg>
            </button>
        </div>

        <p class="fu-demo-note">These controls are for the portfolio demo only. The production block is configured in the WordPress editor.</p>

        <div class="fu-demo-group">
            <p class="fu-demo-group-label" id="fu-cs-demo-display-style-label">Display Style</p>
            <div class="fu-demo-btns fu-demo-btns--text fu-demo-btns--wrap" role="group" aria-labelledby="fu-cs-demo-display-style-label">
                <button type="button" class="is-active" aria-pressed="true" data-demo-control="display-style" data-demo-value="tabs">Tabs</button>
                <button type="button" aria-pressed="false" data-demo-control="display-style" data-demo-value="pills">Pills</button>
                <button type="button" aria-pressed="false" data-demo-control="display-style" data-demo-value="minimal">Minimal</button>
                <button type="button" class="fu-demo-option--vertical" aria-pressed="false" data-demo-control="display-style" data-demo-value="vertical">Vertical</button>
            </div>
        </div>

        <div class="fu-demo-group">
            <p class="fu-demo-group-label" id="fu-cs-demo-switcher-bg-label">Switcher Background</p>
            <div class="fu-demo-btns fu-demo-btns--text" role="group" aria-labelledby="fu-cs-demo-switcher-bg-label">
                <button type="button" class="is-active" aria-pressed="true" data-demo-control="switcher-background" data-demo-value="none">None</button>
                <button type="button" aria-pressed="false" data-demo-control="switcher-background" data-demo-value="light">Light</button>
                <button type="button" aria-pressed="false" data-demo-control="switcher-background" data-demo-value="dark">Dark</button>
            </div>
        </div>

        <div class="fu-demo-group">
            <p class="fu-demo-group-label" id="fu-cs-demo-panel-bg-label">Panel Background</p>
            <div class="fu-demo-btns fu-demo-btns--text" role="group" aria-labelledby="fu-cs-demo-panel-bg-label">
                <button type="button" class="is-active" aria-pressed="true" data-demo-control="panel-background" data-demo-value="none">None</button>
                <button type="button" aria-pressed="false" data-demo-control="panel-background" data-demo-value="light">Light</button>
                <button type="button" aria-pressed="false" data-demo-control="panel-background" data-demo-value="dark">Dark</button>
            </div>
        </div>

        <div class="fu-demo-group">
            <p class="fu-demo-group-label" id="fu-cs-demo-panel-radius-label">Panel Radius</p>
            <div class="fu-demo-btns fu-demo-btns--text fu-demo-btns--wrap" role="group" aria-labelledby="fu-cs-demo-panel-radius-label">
                <button type="button" class="is-active" aria-pressed="true" data-demo-control="panel-radius" data-demo-value="none">None</button>
                <button type="button" aria-pressed="false" data-demo-control="panel-radius" data-demo-value="small">Small</button>
                <button type="button" aria-pressed="false" data-demo-control="panel-radius" data-demo-value="medium">Medium</button>
                <button type="button" aria-pressed="false" data-demo-control="panel-radius" data-demo-value="large">Large</button>
            </div>
        </div>

        <div class="fu-demo-group fu-demo-group--panel-height" data-demo-group="panel-height">
            <label for="fu-cs-demo-panel-height">Panel Height</label>
            <select id="fu-cs-demo-panel-height" class="fu-demo-select" data-demo-control="panel-height">
                <option value="natural">Natural</option>
                <option value="match" selected>Match Tallest</option>
            </select>
        </div>

        <button type="button" class="fu-demo-reset">Reset View</button>
    </div>
</div>