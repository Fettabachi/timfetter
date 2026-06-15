(function () {
	const ROOT_SELECTOR = "[data-fu-portfolio-audit]";
	const STATUS_LABELS = {
		available: "Available",
		pass: "Ready",
		notice: "Review",
	};

	const setStatus = (root, message) => {
		const status = root.querySelector("[data-audit-status]");

		if (status) {
			status.textContent = message;
		}
	};

	const createCheckRow = (check, canShowDiagnosticStatus) => {
		const row = document.createElement("article");
		const status = typeof check.status === "string" ? check.status : "notice";
		const label = typeof check.label === "string" ? check.label : "Audit check";
		const result = typeof check.result === "string" ? check.result : "";
		const whyItMatters =
			typeof check.why_it_matters === "string" ? check.why_it_matters : "";
		const recommendedFix =
			typeof check.recommended_fix === "string" ? check.recommended_fix : "";
		const adminDetails = Array.isArray(check.admin_details)
			? check.admin_details
			: [];
		const isPublicDemo = !canShowDiagnosticStatus || status === "available";

		row.className = `fu-portfolio-audit__check fu-portfolio-audit__check--${status}`;
		row.classList.toggle("fu-portfolio-audit__check--public", isPublicDemo);

		if (!isPublicDemo) {
			const badge = document.createElement("span");
			badge.className = "fu-portfolio-audit__check-status";
			badge.textContent = STATUS_LABELS[status] || STATUS_LABELS.notice;
			row.append(badge);
		}

		const body = document.createElement("span");
		body.className = "fu-portfolio-audit__check-body";

		const heading = document.createElement("strong");
		heading.className = "fu-portfolio-audit__check-label";
		heading.textContent = label;

		body.append(heading);

		const publicAdminView =
			"Authorized site editors can see live results, issue counts, recommended fixes, and edit links.";
		const checkDetails = isPublicDemo
			? [
					["What this checks", result],
					["Why it matters", whyItMatters],
					["Admin view", publicAdminView],
			  ]
			: [
					["Current result", result],
					["Why it matters", whyItMatters],
					["Recommended fix", recommendedFix],
			  ];

		checkDetails.forEach(([term, description]) => {
			if (!description) {
				return;
			}

			const rowItem = document.createElement("span");
			rowItem.className = "fu-portfolio-audit__check-copy";

			const rowTerm = document.createElement("span");
			rowTerm.className = "fu-portfolio-audit__check-term";
			rowTerm.textContent = term;

			const rowDescription = document.createElement("span");
			rowDescription.textContent = description;

			rowItem.append(rowTerm, rowDescription);
			body.append(rowItem);
		});

		if (adminDetails.length) {
			const details = document.createElement("div");
			details.className = "fu-portfolio-audit__admin-details";

			const detailsHeading = document.createElement("span");
			detailsHeading.className = "fu-portfolio-audit__admin-heading";
			detailsHeading.textContent = "Admin details";

			const list = document.createElement("ul");
			list.className = "fu-portfolio-audit__admin-list";

			adminDetails.forEach((detail) => {
				const item = document.createElement("li");
				const title =
					typeof detail.title === "string" ? detail.title : "Untitled item";
				const editUrl =
					typeof detail.edit_url === "string" ? detail.edit_url : "";

				if (editUrl) {
					const link = document.createElement("a");
					link.href = editUrl;
					link.textContent = title;
					item.append(link);
				} else {
					item.textContent = title;
				}

				list.append(item);
			});

			details.append(detailsHeading, list);
			body.append(details);
		}

		row.append(body);

		return row;
	};

	const renderResults = (root, data) => {
		const results = root.querySelector("[data-audit-results]");
		const fallback = root.querySelector("[data-audit-fallback]");
		const checks = Array.isArray(data?.checks) ? data.checks : [];
		const canShowDiagnosticStatus = data?.adminDetailsAvailable === true;

		if (!results) {
			return;
		}

		results.replaceChildren();

		if (fallback) {
			fallback.hidden = data?.abilitiesAvailable !== false;
		}

		if (!checks.length) {
			const empty = document.createElement("p");
			empty.className = "fu-portfolio-audit__empty";
			empty.textContent = "The endpoint responded, but no public audit checks were returned.";
			results.append(empty);
			return;
		}

		checks.forEach((check) => {
			results.append(createCheckRow(check, canShowDiagnosticStatus));
		});
	};

	const setLoading = (root, isLoading) => {
		const button = root.querySelector("[data-audit-run]");
		const results = root.querySelector("[data-audit-results]");

		if (button) {
			button.disabled = isLoading;
			button.textContent = isLoading ? "Running audit..." : "Run system audit";
		}

		if (results) {
			results.setAttribute("aria-busy", isLoading ? "true" : "false");
		}
	};

	const runAudit = async (root) => {
		const endpoint = root.getAttribute("data-endpoint");
		const nonce = root.getAttribute("data-nonce");

		if (!endpoint) {
			setStatus(root, "The audit endpoint is unavailable.");
			return;
		}

		setLoading(root, true);
		setStatus(root, "Running a read-only audit...");

		try {
			const headers = {
				Accept: "application/json",
			};

			if (nonce) {
				headers["X-WP-Nonce"] = nonce;
			}

			const response = await window.fetch(endpoint, {
				credentials: "same-origin",
				headers,
			});

			if (!response.ok) {
				throw new Error(`Audit request failed with status ${response.status}`);
			}

			const data = await response.json();
			renderResults(root, data);
			setStatus(root, "Audit complete. Results are summarized below.");
		} catch (error) {
			const results = root.querySelector("[data-audit-results]");

			if (results) {
				const message = document.createElement("p");
				message.className = "fu-portfolio-audit__error";
				message.textContent = "The audit could not run right now. Please try again later.";
				results.replaceChildren(message);
			}

			setStatus(root, "The audit could not run right now.");
		} finally {
			setLoading(root, false);
		}
	};

	const bindRoot = (root) => {
		const button = root.querySelector("[data-audit-run]");

		if (!button) {
			return;
		}

		button.addEventListener("click", () => {
			runAudit(root);
		});
	};

	document.querySelectorAll(ROOT_SELECTOR).forEach(bindRoot);
})();
