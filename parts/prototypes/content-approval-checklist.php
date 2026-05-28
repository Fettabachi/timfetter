<?php

/**
 * Content Approval Checklist Prototype Partial
 * Isolated front-end prototype for portfolio demo purposes only.
 * Not a production block or plugin.
 */
?>
<div class="fu-content-approval-checklist-demo" data-content-approval-checklist>
    <div class="fu-demo-shell">
        <div class="fu-demo-shell__framing">
            <p class="fu-demo-shell__eyebrow">Live Component Preview</p>
            <h2 class="fu-demo-shell__heading">Test content approval states</h2>
            <p class="fu-demo-shell__instruction">Try it: Change item statuses and filter the checklist to see how launch readiness responds.</p>
        </div>
        <div class="fu-checklist__workspace">
            <div class="fu-checklist__main-panel">
                <div class="fu-checklist__checklist-card">
                    <div class="fu-checklist__controls-row">
                        <div style="display: flex; flex-direction: column; gap: 0.1rem; min-width: 200px; max-width: 340px;">
                            <div class="fu-checklist__workflow-type">
                                <label for="fu-workflow-type">Workflow Type</label>
                                <select id="fu-workflow-type" name="workflowType">
                                    <option value="Website launch">Website launch</option>
                                    <option value="Landing page campaign">Landing page campaign</option>
                                    <option value="Content migration">Content migration</option>
                                    <option value="Resource library">Resource library</option>
                                </select>
                            </div>
                            <div class="fu-checklist__workflow-helper">Choose a workflow to see a relevant approval checklist.</div>
                        </div>
                        <div style="width: 2.5rem;"></div>
                        <div class="fu-checklist__status-filter-group">
                            <div class="fu-checklist__status-filter-label">View status</div>
                            <div class="fu-checklist__status-filter" role="group" aria-label="Status Filter">
                                <button type="button" class="fu-checklist__filter-btn" data-status="All" aria-pressed="true">All</button>
                                <button type="button" class="fu-checklist__filter-btn" data-status="Needs Review">Needs Review</button>
                                <button type="button" class="fu-checklist__filter-btn" data-status="Blocked">Blocked</button>
                                <button type="button" class="fu-checklist__filter-btn" data-status="Approved">Approved</button>
                            </div>
                        </div>
                    </div>
                    <div data-checklist-panel></div>
                </div>
                <div class="fu-checklist__summary-card" data-summary-panel></div>
            </div>
        </div>
        <div class="fu-prototype-note">
            <p><strong>Note:</strong> This live demo is presented inside my WordPress portfolio, but the checklist itself is an isolated HTML, CSS, and JavaScript prototype — not a production WordPress block or plugin.</p>
        </div>
    </div>
</div>