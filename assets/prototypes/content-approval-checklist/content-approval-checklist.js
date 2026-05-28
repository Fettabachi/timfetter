// Content Approval Checklist Prototype JS
(function () {
	document.addEventListener("DOMContentLoaded", function () {
		var root = document.querySelector("[data-content-approval-checklist]");
		if (!root) return;

		var WORKFLOW_CHECKLISTS = {
			"Website launch": [
				{
					group: "Content",
					items: ["Homepage copy", "Service page copy", "Contact details"],
				},
				{ group: "Design", items: ["Hero imagery", "Mobile layout review"] },
				{
					group: "Development",
					items: ["Forms tested", "Navigation links checked"],
				},
				{ group: "SEO", items: ["Page titles", "Meta descriptions"] },
				{
					group: "Accessibility",
					items: ["Keyboard navigation", "Color contrast"],
				},
				{
					group: "Final Approval",
					items: ["Client approval", "Launch confirmation"],
				},
			],
			"Landing page campaign": [
				{
					group: "Content",
					items: ["Campaign headline", "Offer details", "CTA copy"],
				},
				{ group: "Design", items: ["Hero image"] },
				{
					group: "Development",
					items: [
						"Lead form tested",
						"Conversion tracking",
						"Thank-you state",
						"Mobile QA",
					],
				},
				{ group: "SEO", items: ["Page title", "Meta description"] },
				{ group: "Final Approval", items: ["Final stakeholder approval"] },
			],
			"Content migration": [
				{
					group: "Content",
					items: ["Source content reviewed", "Priority pages migrated"],
				},
				{
					group: "Development",
					items: [
						"Redirects mapped",
						"Metadata migrated",
						"Broken links checked",
						"Media/assets verified",
						"Formatting QA",
					],
				},
				{ group: "Final Approval", items: ["Client content approval"] },
			],
			"Resource library": [
				{
					group: "Content",
					items: ["Resource titles", "Resource descriptions"],
				},
				{
					group: "Development",
					items: [
						"Categories/taxonomy",
						"Filter behavior",
						"Empty states",
						"Search behavior",
						"Download links",
					],
				},
				{ group: "Accessibility", items: ["Accessibility checks"] },
				{ group: "Final Approval", items: ["Final approval"] },
			],
		};

		var STATUS_VALUES = ["Not Started", "Needs Review", "Blocked", "Approved"];
		var WORKFLOW_TYPES = Object.keys(WORKFLOW_CHECKLISTS);
		var STATUS_FILTERS = ["All", "Needs Review", "Blocked", "Approved"];

		var workflowTypeSelect = root.querySelector('select[name="workflowType"]');
		var checklistPanel = root.querySelector("[data-checklist-panel]");
		var summaryPanel = root.querySelector("[data-summary-panel]");
		var statusFilterRow = root.querySelector(".fu-checklist__status-filter");

		if (!workflowTypeSelect || !checklistPanel || !summaryPanel) {
			return;
		}

		function escapeHTML(value) {
			return String(value).replace(/[&<>'"]/g, function (char) {
				return {
					"&": "&amp;",
					"<": "&lt;",
					">": "&gt;",
					"'": "&#39;",
					'"': "&quot;",
				}[char];
			});
		}

		function slugify(value) {
			return String(value)
				.toLowerCase()
				.replace(/[^a-z0-9]+/g, "-")
				.replace(/^-|-$/g, "");
		}

		function getInitialChecklist(workflowType) {
			var groups = WORKFLOW_CHECKLISTS[workflowType] || [];

			return groups.map(function (group) {
				return {
					name: group.group,
					items: group.items.map(function (label) {
						return {
							label: label,
							status: "Not Started",
						};
					}),
				};
			});
		}

		function getStatusClass(status) {
			return "fu-checklist__status-pill--" + slugify(status);
		}

		var initialWorkflow = WORKFLOW_CHECKLISTS[workflowTypeSelect.value]
			? workflowTypeSelect.value
			: WORKFLOW_TYPES[0];

		var checklistStateByWorkflow = {};

		WORKFLOW_TYPES.forEach(function (workflowType) {
			checklistStateByWorkflow[workflowType] =
				getInitialChecklist(workflowType);
		});

		var state = {
			workflowType: initialWorkflow,
			statusFilter: STATUS_FILTERS[0],
			checklist: checklistStateByWorkflow[initialWorkflow],
		};

		workflowTypeSelect.value = initialWorkflow;

		function getChecklistStats() {
			var total = 0;
			var approved = 0;
			var blocked = 0;
			var needsReview = 0;
			var groupStats = {};

			state.checklist.forEach(function (group) {
				groupStats[group.name] = {
					blocked: 0,
					needsReview: 0,
					incomplete: 0,
				};

				group.items.forEach(function (item) {
					total++;

					if (item.status === "Approved") {
						approved++;
					}

					if (item.status === "Blocked") {
						blocked++;
						groupStats[group.name].blocked++;
					}

					if (item.status === "Needs Review") {
						needsReview++;
						groupStats[group.name].needsReview++;
					}

					if (item.status !== "Approved") {
						groupStats[group.name].incomplete++;
					}
				});
			});

			return {
				total: total,
				approved: approved,
				blocked: blocked,
				needsReview: needsReview,
				groupStats: groupStats,
			};
		}

		function getGroupStats(stats, groupName) {
			return (
				stats.groupStats[groupName] || {
					blocked: 0,
					needsReview: 0,
					incomplete: 0,
				}
			);
		}

		function getReadiness(stats) {
			if (stats.blocked > 0) return "Blocked";
			if (stats.needsReview > 0) return "Needs Review";
			if (stats.total > 0 && stats.approved === stats.total) return "Ready";
			return "In Progress";
		}

		function getGuidance(stats) {
			var out = [];
			var contentStats = getGroupStats(stats, "Content");
			var seoStats = getGroupStats(stats, "SEO");
			var accessibilityStats = getGroupStats(stats, "Accessibility");
			var finalApprovalStats = getGroupStats(stats, "Final Approval");

			if (stats.total > 0 && stats.approved === stats.total) {
				return [
					"All checklist items are approved. This workflow is ready for launch handoff.",
				];
			}

			if (stats.blocked > 0) {
				out.push("Resolve blocked items before launch handoff.");
			}

			if (contentStats.blocked > 0 || contentStats.needsReview > 0) {
				out.push("Confirm content ownership and final approval before launch.");
			}

			if (seoStats.incomplete > 0) {
				out.push("Complete SEO titles and metadata before publishing.");
			}

			if (accessibilityStats.incomplete > 0) {
				out.push("Finish accessibility checks before final QA.");
			}

			if (finalApprovalStats.incomplete > 0) {
				out.push("Confirm client approval and launch sign-off.");
			}

			return out.slice(0, 3);
		}

		function renderChecklist() {
			var html = "";
			var hasItems = false;

			state.checklist.forEach(function (group, groupIndex) {
				var visibleItems = group.items
					.map(function (item, itemIndex) {
						if (
							state.statusFilter === "All" ||
							item.status === state.statusFilter
						) {
							return {
								item: item,
								itemIndex: itemIndex,
							};
						}

						return null;
					})
					.filter(Boolean);

				if (!visibleItems.length) {
					return;
				}

				hasItems = true;

				html +=
					'<div class="fu-checklist__group">' +
					'<h3 class="fu-checklist__group-title">' +
					escapeHTML(group.name) +
					"</h3>";

				visibleItems.forEach(function (entry, visibleIndex) {
					var item = entry.item;
					var itemIndex = entry.itemIndex;
					var itemId =
						"checklist-" +
						slugify(state.workflowType) +
						"-" +
						groupIndex +
						"-" +
						itemIndex;
					var radioName = itemId + "-status";
					var rowClass =
						visibleIndex % 2 === 1 ? " fu-checklist__item-row--alt" : "";

					html += '<div class="fu-checklist__item-row' + rowClass + '">';
					html +=
						'<span class="fu-checklist__item-label" id="' +
						escapeHTML(itemId) +
						'">' +
						escapeHTML(item.label) +
						"</span>";
					html +=
						'<span class="fu-checklist__item-status" role="radiogroup" aria-labelledby="' +
						escapeHTML(itemId) +
						'">';

					STATUS_VALUES.forEach(function (status) {
						var optionId = itemId + "-" + slugify(status);
						var checked = item.status === status ? " checked" : "";
						var active =
							item.status === status
								? " fu-checklist__status-pill--active"
								: "";

						html +=
							'<label class="fu-checklist__status-pill ' +
							getStatusClass(status) +
							active +
							'" for="' +
							escapeHTML(optionId) +
							'">' +
							'<input type="radio" class="fu-visually-hidden" id="' +
							escapeHTML(optionId) +
							'" name="' +
							escapeHTML(radioName) +
							'" value="' +
							escapeHTML(status) +
							'"' +
							checked +
							' data-group="' +
							groupIndex +
							'" data-item="' +
							itemIndex +
							'">' +
							"<span>" +
							escapeHTML(status) +
							"</span>" +
							"</label>";
					});

					html += "</span></div>";
				});

				html += "</div>";
			});

			if (!hasItems) {
				html =
					'<div class="fu-checklist__empty-state">' +
					"<h3>No items match this filter yet.</h3>" +
					"<p>Change an item status to test this view.</p>" +
					"</div>";
			}

			checklistPanel.innerHTML = html;
		}

		function renderSummary() {
			var stats = getChecklistStats();
			var readiness = getReadiness(stats);
			var percent = stats.total
				? Math.round((stats.approved / stats.total) * 100)
				: 0;
			var guidance = getGuidance(stats);

			var html = "";

			html += '<div class="fu-checklist__summary-header">';
			html += '<div class="fu-checklist__summary-title">Launch readiness</div>';
			html +=
				'<span class="fu-checklist__readiness-badge" data-badge="' +
				escapeHTML(readiness) +
				'">' +
				escapeHTML(readiness) +
				"</span>";
			html += "</div>";

			html += '<div class="fu-checklist__progress-area">';
			html += '<div class="fu-checklist__progress-label">Completion</div>';
			html +=
				'<progress class="fu-checklist__progressbar" value="' +
				percent +
				'" max="100" aria-label="Checklist completion: ' +
				percent +
				'%"></progress>';
			html +=
				'<div class="fu-checklist__progressbar-markers" aria-hidden="true">' +
				"<span>0%</span><span>25%</span><span>50%</span><span>75%</span><span>100%</span>" +
				"</div>";
			html += "</div>";

			html +=
				'<div class="fu-checklist__metrics-row">' +
				'<div class="fu-checklist__metric"><span class="fu-checklist__metric-value">' +
				percent +
				'%</span><span class="fu-checklist__metric-label">Completion</span></div>' +
				'<div class="fu-checklist__metric"><span class="fu-checklist__metric-value">' +
				stats.blocked +
				'</span><span class="fu-checklist__metric-label">Blocked</span></div>' +
				'<div class="fu-checklist__metric"><span class="fu-checklist__metric-value">' +
				stats.needsReview +
				'</span><span class="fu-checklist__metric-label">Needs Review</span></div>' +
				"</div>";

			if (guidance.length) {
				html +=
					'<div class="fu-checklist__guidance-heading">Handoff Guidance</div>';
				html += '<ul class="fu-checklist__summary-list">';

				guidance.forEach(function (item) {
					html += "<li>" + escapeHTML(item) + "</li>";
				});

				html += "</ul>";
			}

			summaryPanel.innerHTML = html;
		}

		function renderFilterButtons() {
			if (!statusFilterRow) return;

			statusFilterRow
				.querySelectorAll(".fu-checklist__filter-btn")
				.forEach(function (button) {
					var isActive =
						button.getAttribute("data-status") === state.statusFilter;

					button.setAttribute("aria-pressed", isActive ? "true" : "false");
					button.classList.toggle("fu-checklist__filter-btn--active", isActive);
				});
		}

		function render() {
			renderFilterButtons();
			renderChecklist();
			renderSummary();
		}

		workflowTypeSelect.addEventListener("change", function () {
			var nextWorkflow = workflowTypeSelect.value;

			if (!WORKFLOW_CHECKLISTS[nextWorkflow]) {
				return;
			}

			checklistStateByWorkflow[state.workflowType] = state.checklist;
			state.workflowType = nextWorkflow;
			state.checklist = checklistStateByWorkflow[nextWorkflow];

			render();
		});

		checklistPanel.addEventListener("change", function (event) {
			var input = event.target.closest('input[type="radio"]');

			if (!input) {
				return;
			}

			var groupIndex = Number(input.getAttribute("data-group"));
			var itemIndex = Number(input.getAttribute("data-item"));

			if (
				!state.checklist[groupIndex] ||
				!state.checklist[groupIndex].items[itemIndex]
			) {
				return;
			}

			state.checklist[groupIndex].items[itemIndex].status = input.value;
			checklistStateByWorkflow[state.workflowType] = state.checklist;

			render();
		});

		if (statusFilterRow) {
			statusFilterRow.addEventListener("click", function (event) {
				var button = event.target.closest(".fu-checklist__filter-btn");

				if (!button) {
					return;
				}

				var nextFilter = button.getAttribute("data-status");

				if (!STATUS_FILTERS.includes(nextFilter)) {
					return;
				}

				state.statusFilter = nextFilter;
				render();
			});
		}

		render();
	});
})();
