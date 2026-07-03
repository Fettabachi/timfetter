<?php

/**
 * Project Scope Estimator Prototype Partial
 *
 * Isolated front-end prototype for portfolio demo purposes only.
 * Not a production block or plugin.
 */
?>
<div class="fu-project-scope-estimator-demo" data-project-scope-estimator>
    <div class="fu-demo-shell">
        <div class="fu-demo-shell__framing">
            <p class="fu-eyebrow fu-demo-shell__eyebrow">Live Component Preview</p>
            <h2 class="fu-demo-shell__heading">Test project scope scenarios</h2>
            <p class="fu-demo-shell__instruction">Try it: Choose a project type, select feature needs, and adjust content/design readiness to see how the project summary responds.</p>
        </div>
        <div class="fu-scope-estimator__workspace fu-scope-estimator__panels">
            <form class="fu-scope-estimator__input-panel" autocomplete="off" aria-labelledby="scope-estimator-heading">
                <fieldset class="fu-scope-estimator__fieldset">
                    <legend>Project Type</legend>
                    <label><select name="projectType" required>
                            <option value="" disabled>Select type…</option>
                            <option value="Marketing website" selected>Marketing website</option>
                            <option value="Landing page">Landing page</option>
                            <option value="WordPress support">WordPress support</option>
                            <option value="Interactive prototype">Interactive prototype</option>
                            <option value="CMS/template build">CMS/template build</option>
                        </select></label>
                </fieldset>
                <fieldset class="fu-scope-estimator__fieldset">
                    <legend>Feature Needs</legend>
                    <label><input type="checkbox" name="features" value="Responsive layouts" checked> Responsive layouts</label>
                    <label><input type="checkbox" name="features" value="CMS-editable content" checked> CMS-editable content</label>
                    <label><input type="checkbox" name="features" value="Form integration"> Form integration</label>
                    <label><input type="checkbox" name="features" value="Filtering/search"> Filtering/search</label>
                    <label><input type="checkbox" name="features" value="Animation/interactions"> Animation/interactions</label>
                    <label><input type="checkbox" name="features" value="API/data connection"> API/data connection</label>
                    <label><input type="checkbox" name="features" value="Accessibility review"> Accessibility review</label>
                    <label><input type="checkbox" name="features" value="Page builder cleanup"> Page builder cleanup</label>
                </fieldset>
                <fieldset class="fu-scope-estimator__fieldset">
                    <legend>Content Readiness</legend>
                    <label><select name="contentReadiness" required>
                            <option value="" disabled>Select…</option>
                            <option value="Ready to build">Ready to build</option>
                            <option value="Needs light editing" selected>Needs light editing</option>
                            <option value="Needs writing or migration">Needs writing or migration</option>
                            <option value="Not started">Not started</option>
                        </select></label>
                </fieldset>
                <fieldset class="fu-scope-estimator__fieldset">
                    <legend>Design Readiness</legend>
                    <label><select name="designReadiness" required>
                            <option value="" disabled>Select…</option>
                            <option value="Final design ready">Final design ready</option>
                            <option value="Partial design direction" selected>Partial design direction</option>
                            <option value="Needs UI direction">Needs UI direction</option>
                            <option value="Existing site/style only">Existing site/style only</option>
                        </select></label>
                </fieldset>
            </form>
            <section class="fu-scope-estimator__output-panel">
                <div class="fu-scope-estimator__output-content">
                    <div class="fu-scope-estimator__complexity">
                        <span class="fu-scope-estimator__complexity-label">Complexity level:</span>
                        <span class="fu-scope-estimator__complexity-value" data-complexity-level>—</span>
                    </div>
                    <div class="fu-scope-estimator__suggested-approach">
                        <h3 class="scope-estimator__section-title">Suggested approach</h3>
                        <span data-suggested-approach>—</span>
                    </div>
                    <div class="fu-scope-estimator__handoff-summary">
                        <h3 class="scope-estimator__section-title">Handoff summary</h3>
                        <span data-handoff-summary>—</span>
                    </div>
                    <div class="fu-scope-estimator__next-steps">
                        <h3 class="scope-estimator__section-title">Handoff guidance</h3>
                        <ul data-next-steps>
                            <li>—</li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>
        <div class="fu-prototype-note">
            <p><strong>Note:</strong> This live demo is presented inside my WordPress portfolio, but the estimator itself is an isolated HTML, CSS, and JavaScript prototype — not a production WordPress block or plugin.</p>
        </div>
    </div>
</div>
