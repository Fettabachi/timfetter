// Project Scope Estimator Prototype JS
(function () {
	document.addEventListener("DOMContentLoaded", function () {
		var root = document.querySelector("[data-project-scope-estimator]");
		if (!root) return;

		var state = {
			projectType: "",
			features: [],
			contentReadiness: "",
			designReadiness: "",
		};

		var projectTypeSelect = root.querySelector('select[name="projectType"]');
		var featureCheckboxes = Array.from(
			root.querySelectorAll('input[name="features"]')
		);
		var contentReadinessSelect = root.querySelector(
			'select[name="contentReadiness"]'
		);
		var designReadinessSelect = root.querySelector(
			'select[name="designReadiness"]'
		);

		var complexityEl = root.querySelector("[data-complexity-level]");
		var suggestedEl = root.querySelector("[data-suggested-approach]");
		var handoffEl = root.querySelector("[data-handoff-summary]");
		var nextStepsEl = root.querySelector("[data-next-steps]");

		if (
			!projectTypeSelect ||
			!contentReadinessSelect ||
			!designReadinessSelect ||
			!complexityEl ||
			!suggestedEl ||
			!handoffEl
		) {
			return;
		}

		var baseScores = {
			"Landing page": 1,
			"WordPress support": 2,
			"Marketing website": 2,
			"Interactive prototype": 3,
			"CMS/template build": 3,
		};

		var contentScores = {
			"Ready to build": 1,
			"Needs light editing": 2,
			"Needs writing or migration": 3,
			"Not started": 3,
		};

		var designScores = {
			"Final design ready": 1,
			"Partial design direction": 2,
			"Needs UI direction": 3,
			"Existing site/style only": 3,
		};

		function escapeHTML(value) {
			return String(value)
				.replace(/&/g, "&amp;")
				.replace(/</g, "&lt;")
				.replace(/>/g, "&gt;")
				.replace(/"/g, "&quot;")
				.replace(/'/g, "&#039;");
		}

		function updateState() {
			state.projectType = projectTypeSelect.value;
			state.features = featureCheckboxes
				.filter(function (checkbox) {
					return checkbox.checked;
				})
				.map(function (checkbox) {
					return checkbox.value;
				});
			state.contentReadiness = contentReadinessSelect.value;
			state.designReadiness = designReadinessSelect.value;
		}

		function calculateScore() {
			var score = 0;

			if (baseScores[state.projectType]) {
				score += baseScores[state.projectType];
			}

			score += state.features.length;

			if (contentScores[state.contentReadiness]) {
				score += contentScores[state.contentReadiness];
			}

			if (designScores[state.designReadiness]) {
				score += designScores[state.designReadiness];
			}

			return score;
		}

		function getComplexity(score) {
			if (score >= 9) return "High";
			if (score >= 5) return "Moderate";
			if (score >= 1) return "Low";
			return "—";
		}

		function getSuggestedApproach() {
			if (state.projectType === "WordPress support") {
				return "Start with a focused support brief and clarify the most urgent needs.";
			}

			if (state.projectType === "Landing page") {
				return "Keep scope tight, prioritize launch, and iterate after go-live.";
			}

			if (state.projectType === "Marketing website") {
				return "Define key pages, content sources, and CMS structure early.";
			}

			if (state.projectType === "Interactive prototype") {
				return "Map out user flows and test interactions before production.";
			}

			if (state.projectType === "CMS/template build") {
				return "Clarify template requirements and editor experience goals.";
			}

			return "Select a project type to generate a suggested approach.";
		}

		function getHandoffSummary(complexity) {
			var selectedNeeds = state.features.length
				? state.features
				: ["No feature needs selected"];

			return [
				'<dl class="fu-scope-estimator__summary-list">',
				"<div>",
				"<dt>Project type:</dt>",
				"<dd>" + escapeHTML(state.projectType || "Not selected") + "</dd>",
				"</div>",
				"<div>",
				"<dt>Selected needs:</dt>",
				"<dd>",
				'<ul class="fu-scope-estimator__selected-needs">',
				selectedNeeds
					.map(function (feature) {
						return "<li>" + escapeHTML(feature) + "</li>";
					})
					.join(""),
				"</ul>",
				"</dd>",
				"</div>",
				"<div>",
				"<dt>Readiness:</dt>",
				"<dd>",
				"Content: " + escapeHTML(state.contentReadiness || "Not selected"),
				"<br>",
				"Design: " + escapeHTML(state.designReadiness || "Not selected"),
				"</dd>",
				"</div>",
				"<div>",
				"<dt>Complexity:</dt>",
				"<dd>" + escapeHTML(complexity) + "</dd>",
				"</div>",
				"</dl>",
			].join("");
		}

		function getHandoffGuidance(complexity) {
			var guidance = [];

			if (state.contentReadiness === "Not started") {
				guidance.push(
					"Confirm who owns content creation before production begins."
				);
			} else if (state.contentReadiness === "Needs writing or migration") {
				guidance.push(
					"Identify which pages need new copy, migration, or editorial review."
				);
			} else if (state.contentReadiness === "Needs light editing") {
				guidance.push("Schedule a content review before production handoff.");
			}

			if (state.designReadiness === "Needs UI direction") {
				guidance.push(
					"Define the visual direction and key component patterns before estimating production."
				);
			} else if (state.designReadiness === "Partial design direction") {
				guidance.push(
					"Confirm which templates, interactions, or responsive states still need design decisions."
				);
			}

			if (
				state.projectType === "Marketing website" &&
				state.features.includes("CMS-editable content")
			) {
				guidance.push(
					"Define which pages, templates, and content areas need editor control."
				);
			}

			if (state.projectType === "Landing page") {
				guidance.push(
					"Confirm campaign goals, conversion actions, and required tracking before production."
				);
			}

			if (state.projectType === "WordPress support") {
				guidance.push(
					"Identify the highest-priority fixes and separate quick updates from larger rebuild work."
				);
			}

			if (state.projectType === "Interactive prototype") {
				guidance.push(
					"Confirm which interactions need to be tested before production implementation."
				);
			}

			if (state.projectType === "CMS/template build") {
				guidance.push(
					"Clarify template requirements and editor experience goals."
				);
			}

			if (state.features.includes("API/data connection")) {
				guidance.push(
					"Document the data source, required fields, loading states, empty states, and error states."
				);
			}

			if (state.features.includes("Filtering/search")) {
				guidance.push(
					"Confirm the content model, taxonomy, and expected filter behavior."
				);
			}

			if (state.features.includes("CMS-editable content")) {
				guidance.push(
					"Define which content areas should be editable and which should remain fixed."
				);
			}

			if (state.features.includes("Page builder cleanup")) {
				guidance.push(
					"Audit existing page-builder patterns before rebuilding or extending templates."
				);
			}

			if (state.features.includes("Accessibility review")) {
				guidance.push(
					"Include keyboard, focus, contrast, and screen-reader checks in QA."
				);
			}

			if (state.features.includes("Animation/interactions")) {
				guidance.push(
					"Identify which interactions are decorative, functional, or required for user feedback."
				);
			}

			if (state.features.includes("Form integration")) {
				guidance.push(
					"Confirm required fields, validation rules, notifications, and submission handling."
				);
			}

			if (state.features.includes("Responsive layouts")) {
				guidance.push(
					"Review priority layouts across desktop, tablet, and mobile breakpoints."
				);
			}

			if (guidance.length < 3 && complexity === "High") {
				guidance.push(
					"Break the work into discovery, prototype, and production phases before final implementation."
				);
			} else if (guidance.length < 3 && complexity === "Moderate") {
				guidance.push("Confirm remaining unknowns before production handoff.");
			}

			return guidance.slice(0, 3);
		}

		function render() {
			updateState();

			var score = calculateScore();
			var complexity = getComplexity(score);
			var guidance = getHandoffGuidance(complexity);

			complexityEl.textContent = complexity;
			complexityEl.setAttribute("data-complexity-value", complexity);

			suggestedEl.textContent = getSuggestedApproach();
			handoffEl.innerHTML = getHandoffSummary(complexity);

			if (!nextStepsEl) {
				return;
			}

			if (guidance.length) {
				nextStepsEl.parentElement.hidden = false;
				nextStepsEl.innerHTML = guidance
					.map(function (item) {
						return "<li>" + escapeHTML(item) + "</li>";
					})
					.join("");
			} else {
				nextStepsEl.innerHTML = "";
				nextStepsEl.parentElement.hidden = true;
			}
		}

		function bindEvents() {
			projectTypeSelect.addEventListener("change", render);
			contentReadinessSelect.addEventListener("change", render);
			designReadinessSelect.addEventListener("change", render);

			featureCheckboxes.forEach(function (checkbox) {
				checkbox.addEventListener("change", render);
			});
		}

		if (
			!featureCheckboxes.some(function (checkbox) {
				return checkbox.checked;
			})
		) {
			featureCheckboxes.forEach(function (checkbox) {
				if (
					["Responsive layouts", "CMS-editable content"].includes(
						checkbox.value
					)
				) {
					checkbox.checked = true;
				}
			});
		}

		bindEvents();
		render();
	});
})();
