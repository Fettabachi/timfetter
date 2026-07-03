<?php

/**
 * Client Project Timeline Prototype Partial
 *
 * Isolated front-end prototype for portfolio demo purposes only.
 * Not a production block or plugin.
 */
?>
<div class="fu-client-timeline-demo" data-client-project-timeline>
    <div class="fu-demo-shell">
        <div class="fu-demo-shell__framing">
            <p class="fu-eyebrow fu-demo-shell__eyebrow">Live Component Preview</p>
            <h2 class="fu-demo-shell__heading">Test project timeline states</h2>
            <p class="fu-demo-shell__instruction">Try it: Change the tracking mode, milestone count, and current progress to test different workflow states. On wider screens, you can also switch the timeline layout.</p>
        </div>
        <!-- Begin Prototype Demo Markup -->
        <div class="progress-bar">
            <section class="timeline-preview" aria-labelledby="timeline-preview-title" data-layout="auto" data-timeline-preview>
                <header class="timeline-preview__header">
                    <p class="timeline-preview__eyebrow">Live workflow status</p>
                    <h2 id="timeline-preview-title">Website Redesign Timeline</h2>
                    <p class="timeline-preview__description">Track project movement from brief intake through approval, production, and final handoff.</p>
                </header>
                <div class="progress-bar-wrapper" data-progress-bar-wrapper>
                    <div class="hard-stop-labels" data-hard-stop-labels></div>
                    <div class="progress-bar-container">
                        <div class="progress-markers" data-progress-markers></div>
                        <div class="progress-bar-background">
                            <div class="progress-indicator" data-progress-indicator></div>
                        </div>
                    </div>
                    <div class="intermediate-label-container" data-intermediate-label-container></div>
                </div>
                <div class="vertical-timeline" data-vertical-timeline></div>
            </section>
            <div class="controls">
                <h2>Test States</h2>
                <div>
                    <div class="control-label-row">
                        <label for="client-timeline-progress-mode">Tracking Mode:</label>
                        <span class="control-tooltip">
                            <button type="button" class="control-tooltip__trigger info-button" aria-describedby="mode-description" tabindex="0" aria-label="Show tracking mode help">
                                <span aria-hidden="true">&#9432;</span>
                            </button>
                            <span id="mode-description" class="control-tooltip__content" role="tooltip">
                                <strong>Milestone mode</strong> shows completed project stages only. <strong>Continuous mode</strong> adds half-step states for in-between moments, such as reviews, checkpoints, or approvals in progress.
                            </span>
                        </span>
                    </div>
                    <select id="client-timeline-progress-mode" data-progress-mode>
                        <option value="milestone" selected>Milestone</option>
                        <option value="continuous">Continuous</option>
                    </select>
                </div>
                <div>
                    <div class="control-label-row">
                        <label for="client-timeline-total-steps">Milestones:</label>
                        <span class="control-tooltip">
                            <button type="button" class="control-tooltip__trigger info-button" aria-describedby="milestones-description" aria-label="Show milestone count help">
                                <span aria-hidden="true">&#9432;</span>
                            </button>
                            <span id="milestones-description" class="control-tooltip__content" role="tooltip"> Choose how many major stages the workflow should include. Each count uses a complete start-to-finish milestone set. </span>
                        </span>
                    </div>
                    <select id="client-timeline-total-steps" data-total-steps>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7" selected>7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
                <div>
                    <div class="control-label-row">
                        <label for="client-timeline-current-step" id="current-step-label">Current Progress</label>
                        <span class="control-tooltip">
                            <button type="button" class="control-tooltip__trigger info-button" aria-describedby="progress-description" aria-label="Show progress help">
                                <span aria-hidden="true">&#9432;</span>
                            </button>
                            <span id="progress-description" class="control-tooltip__content" role="tooltip"> Set the current milestone or in-progress step. </span>
                        </span>
                    </div>
                    <select id="client-timeline-current-step" data-current-step></select>
                </div>
                <div class="timeline-layout-control">
                    <div class="control-label-row">
                        <label for="client-timeline-layout">Timeline Layout:</label>
                    </div>
                    <select id="client-timeline-layout" data-timeline-layout>
                        <option value="auto" selected>Auto</option>
                        <option value="horizontal">Horizontal</option>
                        <option value="vertical">Vertical</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- End Prototype Demo Markup -->
        <div class="fu-prototype-note">
            <p><strong>Note:</strong> This live demo is presented inside my WordPress portfolio, but the timeline itself is an isolated HTML, CSS, and JavaScript prototype — not a production WordPress block or plugin.</p>
        </div>
    </div>
</div>
