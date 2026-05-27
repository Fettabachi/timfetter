document.addEventListener("DOMContentLoaded", () => {
	const root = document.querySelector("[data-client-project-timeline]");
	if (!root) return;

	const hardStopLabelsContainer = root.querySelector("[data-hard-stop-labels]");
	const markersContainer = root.querySelector("[data-progress-markers]");
	const intermediateLabelContainer = root.querySelector(
		"[data-intermediate-label-container]"
	);
	const progressBarWrapper = root.querySelector("[data-progress-bar-wrapper]");
	const progressIndicator = root.querySelector("[data-progress-indicator]");
	const verticalTimeline = root.querySelector("[data-vertical-timeline]");
	const timelinePreview = root.querySelector("[data-timeline-preview]");
	// No timelineLayoutInput in this prototype, but keep for future-proofing
	const timelineLayoutInput = root.querySelector("[data-timeline-layout]");

	const totalStepsInput = root.querySelector("[data-total-steps]");
	const currentStepInput = root.querySelector("[data-current-step]");
	const progressModeInput = root.querySelector("[data-progress-mode]");
	const currentStepLabel = root.querySelector("#current-step-label");

	const defaultLabels = [
		"BRIEF RECEIVED",
		"SCOPE CONFIRMED",
		"CONCEPTS IN PROGRESS",
		"CLIENT REVIEW",
		"REVISION ROUND",
		"FINAL APPROVAL",
		"ASSETS DELIVERED",
		"LAUNCH SUPPORT",
		"WRAP-UP",
		"HANDOFF COMPLETE",
	];

	const continuousStepDetails = {
		1.5: { message: "Discovery checkpoint" },
		2.5: { message: "Production in progress" },
		3.5: { message: "Review in progress" },
		4.5: { message: "Approval checkpoint" },
		5.5: { message: "Revision checkpoint" },
		6.5: { message: "Delivery preparation" },
		7.5: { message: "Launch support in progress" },
		8.5: { message: "Wrap-up review" },
		9.5: { message: "Final handoff check" },
	};

	const milestoneLabelsByCount = {
		4: [
			"BRIEF RECEIVED",
			"PROJECT IN PROGRESS",
			"CLIENT REVIEW",
			"HANDOFF COMPLETE",
		],
		5: [
			"BRIEF RECEIVED",
			"SCOPE CONFIRMED",
			"PROJECT IN PROGRESS",
			"CLIENT REVIEW",
			"HANDOFF COMPLETE",
		],
		6: [
			"BRIEF RECEIVED",
			"SCOPE CONFIRMED",
			"CONCEPTS IN PROGRESS",
			"CLIENT REVIEW",
			"FINAL APPROVAL",
			"HANDOFF COMPLETE",
		],
		7: [
			"BRIEF RECEIVED",
			"SCOPE CONFIRMED",
			"CONCEPTS IN PROGRESS",
			"CLIENT REVIEW",
			"REVISION ROUND",
			"FINAL APPROVAL",
			"HANDOFF COMPLETE",
		],
		8: [
			"BRIEF RECEIVED",
			"SCOPE CONFIRMED",
			"CONCEPTS IN PROGRESS",
			"CLIENT REVIEW",
			"REVISION ROUND",
			"FINAL APPROVAL",
			"ASSETS DELIVERED",
			"HANDOFF COMPLETE",
		],
		9: [
			"BRIEF RECEIVED",
			"SCOPE CONFIRMED",
			"CONCEPTS IN PROGRESS",
			"CLIENT REVIEW",
			"REVISION ROUND",
			"FINAL APPROVAL",
			"ASSETS DELIVERED",
			"LAUNCH SUPPORT",
			"HANDOFF COMPLETE",
		],
		10: [
			"BRIEF RECEIVED",
			"SCOPE CONFIRMED",
			"CONCEPTS IN PROGRESS",
			"CLIENT REVIEW",
			"REVISION ROUND",
			"FINAL APPROVAL",
			"ASSETS DELIVERED",
			"LAUNCH SUPPORT",
			"WRAP-UP",
			"HANDOFF COMPLETE",
		],
	};

	const wrapperStyle = getComputedStyle(progressBarWrapper);
	const animationDurationMs =
		parseFloat(wrapperStyle.getPropertyValue("--progress-animation-duration")) *
			1000 || 1200;

	function clearProgressBarElements() {
		hardStopLabelsContainer.innerHTML = "";
		markersContainer.innerHTML = "";
		intermediateLabelContainer.innerHTML = "";
		progressIndicator.innerHTML = "";
		progressIndicator.style.width = "0%";
	}

	function formatStepValue(value) {
		return Number.isInteger(value) ? String(value) : value.toFixed(1);
	}

	function populateCurrentStepOptions(totalSteps, isContinuousMode) {
		const currentValue = parseFloat(currentStepInput.value) || 1;
		const options = [];

		currentStepInput.innerHTML = "";

		for (
			let value = 1;
			value <= totalSteps;
			value += isContinuousMode ? 0.5 : 1
		) {
			const option = document.createElement("option");
			option.value = String(value);
			option.textContent = formatStepValue(value);
			options.push(option.value);
			currentStepInput.appendChild(option);
		}

		const normalizedValue = isContinuousMode
			? Math.round(currentValue * 2) / 2
			: Math.round(currentValue);
		const selectedValue = options.includes(String(normalizedValue))
			? String(normalizedValue)
			: options[0];
		currentStepInput.value = selectedValue;
	}

	function syncModeControls() {
		const isContinuousMode = progressModeInput.value === "continuous";
		const totalSteps = Math.min(
			10,
			Math.max(4, parseInt(totalStepsInput.value, 10) || 4)
		);

		currentStepLabel.textContent = "Current Progress";

		populateCurrentStepOptions(totalSteps, isContinuousMode);
	}

	function syncTimelineLayout() {
		if (!timelinePreview || !timelineLayoutInput) {
			return;
		}

		timelinePreview.dataset.layout = timelineLayoutInput.value;
	}

	function getApiData() {
		const isContinuousMode = progressModeInput.value === "continuous";
		const totalSteps = Math.min(
			10,
			Math.max(4, parseInt(totalStepsInput.value, 10) || 4)
		);
		const parsedCurrentStep = parseFloat(currentStepInput.value) || 1;
		const normalizedCurrentStep = isContinuousMode
			? Math.round(parsedCurrentStep * 2) / 2
			: Math.round(parsedCurrentStep);
		const currentStep = Math.min(
			totalSteps,
			Math.max(1, normalizedCurrentStep)
		);
		const isIntermediate =
			isContinuousMode && currentStep % 1 !== 0 && currentStep < totalSteps;
		const stepKey = Number(currentStep.toFixed(1));
		const stepDetail = isContinuousMode ? continuousStepDetails[stepKey] : null;

		totalStepsInput.value = String(totalSteps);
		populateCurrentStepOptions(totalSteps, isContinuousMode);
		currentStepInput.value = String(currentStep);

		return {
			mode: isContinuousMode ? "continuous" : "milestone",
			totalSteps,
			currentStep,
			isIntermediate,
			labels: milestoneLabelsByCount[totalSteps] || milestoneLabelsByCount[7],
			stepDetail,
			ariaValueText:
				isIntermediate && stepDetail
					? `Step ${Math.floor(currentStep)} of ${totalSteps}, ${
							stepDetail.message
					  }`
					: `Milestone ${currentStep} of ${totalSteps}`,
		};
	}

	function getLabelWidthPercent(totalSteps) {
		if (totalSteps >= 10) {
			return 8.6;
		}
		if (totalSteps === 9) {
			return 9.25;
		}
		if (totalSteps === 8) {
			return 10.25;
		}
		return 12;
	}

	function getLabelPosition(positionPercent, index, totalSteps) {
		const firstLabelOffset = totalSteps >= 9 ? 2.5 : 3;
		const lastLabelOffset = totalSteps >= 9 ? 97.5 : 97;
		if (index === 0) {
			return firstLabelOffset;
		}
		if (index === totalSteps - 1) {
			return lastLabelOffset;
		}
		return positionPercent;
	}

	function getStepPositions(totalSteps) {
		const availableWidthPercent = 100;
		const gaps = totalSteps - 1;
		const gapPercent = gaps > 0 ? availableWidthPercent / gaps : 0;

		return Array.from({ length: totalSteps }, (_, index) => {
			return index * gapPercent;
		});
	}

	function getResponsiveLabelFontSize(totalSteps) {
		if (totalSteps <= 7) {
			return 13;
		}

		const minStepsForScaling = 8;
		const maxSteps = 10;
		const maxFontSize = 13;
		const minFontSize = 11;
		const progressInRange =
			(totalSteps - minStepsForScaling) / (maxSteps - minStepsForScaling);

		return maxFontSize - (maxFontSize - minFontSize) * progressInRange;
	}

	function renderVerticalTimeline(data) {
		if (!verticalTimeline) {
			return;
		}

		verticalTimeline.innerHTML = "";

		const list = document.createElement("ol");
		list.className = "vertical-timeline__list";

		const activeStep = Math.floor(data.currentStep);

		data.labels.forEach((labelText, index) => {
			const stepNumber = index + 1;
			const isCompleted = stepNumber <= activeStep;
			const isActive = stepNumber === activeStep;
			const isUpcoming = stepNumber > activeStep;

			const item = document.createElement("li");
			item.className = "vertical-timeline__item";

			if (isCompleted) {
				item.classList.add("vertical-timeline__item--completed");
			}

			if (isActive) {
				item.classList.add("vertical-timeline__item--active");
			}

			if (isUpcoming) {
				item.classList.add("vertical-timeline__item--upcoming");
			}

			const marker = document.createElement("span");
			marker.className = "vertical-timeline__marker";
			marker.setAttribute("aria-hidden", "true");

			const content = document.createElement("div");
			content.className = "vertical-timeline__content";

			const label = document.createElement("span");
			label.className = "vertical-timeline__label";
			label.textContent = labelText;

			content.appendChild(label);

			if (data.isIntermediate && stepNumber === activeStep) {
				const status = document.createElement("span");
				status.className = "vertical-timeline__status";
				status.textContent = data.stepDetail
					? data.stepDetail.message
					: "Status in progress";
				content.appendChild(status);
			}

			item.appendChild(marker);
			item.appendChild(content);
			list.appendChild(item);
		});

		verticalTimeline.appendChild(list);
	}

	function updateProgressBar(data) {
		clearProgressBarElements();

		progressBarWrapper.setAttribute("role", "progressbar");
		progressBarWrapper.setAttribute("aria-valuemin", "1");
		progressBarWrapper.setAttribute("aria-valuemax", String(data.totalSteps));
		progressBarWrapper.setAttribute("aria-valuenow", String(data.currentStep));
		progressBarWrapper.setAttribute("aria-valuetext", data.ariaValueText);
		renderVerticalTimeline(data);

		const stepPositions = getStepPositions(data.totalSteps);
		const labelWidthPercent = getLabelWidthPercent(data.totalSteps);
		const fontSize = getResponsiveLabelFontSize(data.totalSteps);
		const currentStepIndex = data.currentStep - 1;

		let labelToActivate = null;

		data.labels.forEach((labelText, index) => {
			const positionPercent = stepPositions[index];
			const labelPositionPercent = getLabelPosition(
				positionPercent,
				index,
				data.labels.length
			);

			const labelEl = document.createElement("div");
			labelEl.className = "hard-stop-label";
			labelEl.textContent = labelText;
			labelEl.style.left = `${labelPositionPercent}%`;
			labelEl.style.width = `${labelWidthPercent}%`;
			labelEl.style.fontSize = `${fontSize}px`;
			labelEl.style.whiteSpace = "normal";
			labelEl.style.overflowWrap = "normal";
			labelEl.style.wordBreak = "normal";
			labelEl.style.hyphens = "none";

			if (index === Math.floor(data.currentStep) - 1 && data.currentStep >= 1) {
				labelToActivate = labelEl;
			}

			hardStopLabelsContainer.appendChild(labelEl);

			const markerEl = document.createElement("span");
			markerEl.className =
				index === 0 ? "marker marker--completed" : "marker marker--upcoming";
			markerEl.dataset.markerIndex = String(index);
			markerEl.setAttribute("aria-hidden", "true");
			markerEl.style.left = `${positionPercent}%`;

			markersContainer.appendChild(markerEl);
		});

		let targetPercent = 0;

		if (currentStepIndex >= 0) {
			if (!data.isIntermediate) {
				targetPercent = stepPositions[currentStepIndex];
			} else {
				const floorStep = Math.floor(currentStepIndex);
				const ceilStep = Math.ceil(currentStepIndex);
				const startPercent = stepPositions[floorStep] || 0;
				const endPercent = stepPositions[ceilStep] || 100;
				const fraction = currentStepIndex - floorStep;

				targetPercent = startPercent + (endPercent - startPercent) * fraction;

				const intermediateLabelWrapper = document.createElement("div");
				intermediateLabelWrapper.className = "intermediate-label";
				intermediateLabelWrapper.setAttribute("aria-live", "polite");
				intermediateLabelWrapper.style.left = `${targetPercent}%`;
				intermediateLabelWrapper.textContent = data.stepDetail
					? data.stepDetail.message
					: "Status in progress";

				intermediateLabelContainer.appendChild(intermediateLabelWrapper);

				setTimeout(() => {
					intermediateLabelWrapper.classList.add("is-visible");
				}, animationDurationMs);
			}
		}

		const markersToAnimate = [];

		for (let index = 1; index <= Math.floor(currentStepIndex); index++) {
			const markerPosition = stepPositions[index];
			const markerElement = markersContainer.querySelector(
				`[data-marker-index="${index}"]`
			);

			if (markerElement && targetPercent > 0) {
				markersToAnimate.push({
					element: markerElement,
					activationTime:
						(markerPosition / targetPercent) * animationDurationMs,
					activated: false,
				});
			}
		}

		let animationStartTime = null;
		let labelActivated = false;
		const labelActivationPercent =
			stepPositions[Math.floor(data.currentStep) - 1] || 0;

		function animateTimeline(timestamp) {
			if (!animationStartTime) {
				animationStartTime = timestamp;
			}

			const elapsed = timestamp - animationStartTime;
			const progress = Math.min(elapsed / animationDurationMs, 1);
			const currentWidth = targetPercent * progress;

			progressIndicator.style.width = `${currentWidth}%`;

			markersToAnimate.forEach((marker) => {
				if (!marker.activated && elapsed >= marker.activationTime) {
					marker.element.classList.remove("marker--upcoming");
					marker.element.classList.add("marker--completed");
					marker.activated = true;
				}
			});

			if (
				!labelActivated &&
				labelToActivate &&
				currentWidth >= labelActivationPercent
			) {
				labelToActivate.classList.add("active-step-label");
				labelActivated = true;
			}

			if (progress < 1) {
				requestAnimationFrame(animateTimeline);
			}
		}

		requestAnimationFrame(animateTimeline);
	}

	function refreshTimeline() {
		const data = getApiData();
		updateProgressBar(data);
	}

	progressModeInput.addEventListener("change", () => {
		syncModeControls();
		refreshTimeline();
	});

	totalStepsInput.addEventListener("change", () => {
		syncModeControls();
		refreshTimeline();
	});

	currentStepInput.addEventListener("change", refreshTimeline);

	if (timelineLayoutInput) {
		timelineLayoutInput.addEventListener("change", syncTimelineLayout);
	}

	// updateButton.addEventListener("click", refreshTimeline);

	syncModeControls();
	refreshTimeline();
	syncTimelineLayout();
});
