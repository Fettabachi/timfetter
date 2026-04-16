(function () {
	"use strict";

	const isEditor =
		typeof wp !== "undefined" &&
		typeof wp.data !== "undefined" &&
		typeof window.acf !== "undefined";

	if (!isEditor) {
		return;
	}

	const ROOT_SELECTOR = ".fu-feature-section";
	const BLOCK_WRAPPER_SELECTOR = ".wp-block-acf-fu-feature-section";
	const SYNC_FIELD_KEYS = [
		"field_68008a5f1005",
		"field_68008a5f1009",
		"field_68008a5f1027",
		"field_68008a5f1032",
		"field_68008a5f1011",
		"field_68008a5f1028",
		"field_68008a5f1030",
		"field_68008a5f1031",
		"field_68008a5f1029",
		"field_68008a5f1012",
		"field_68008a5f1013",
		"field_68008a5f1015",
		"field_68008a5f1017",
		"field_68008a5f1019",
		"field_68008a5f1020",
		"field_68008a5f1021",
		"field_68008a5f1023",
		"field_68008a5f1024",
		"field_68008a5f1026",
	];
	const RERENDER_FIELD_KEYS = [
		"field_68008a5f1002",
		"field_68008a5f1003",
		"field_68008a5f1004",
		"field_68008a5f1006",
		"field_68008a5f1008",
		"field_68008a5f1018",
		"field_68008a5f1022",
	];
	const DEFAULTS = {
		feature_heading_size: "xl",
		feature_image_fit: "cover",
		feature_content_width: "balanced",
		feature_layout_width: "default",
		feature_media_position: "right",
		feature_media_fill: false,
		feature_image_radius: "default",
		feature_fill_padding_inline: "medium",
		feature_fill_padding_block: "medium",
		feature_vertical_align: "center",
		feature_button_group_alignment: "left",
		feature_background_token: "beige",
		feature_text_scheme: "auto",
		feature_show_cta_1: true,
		feature_cta_1_style: "primary",
		feature_cta_1_size: "large",
		feature_show_cta_2: false,
		feature_cta_2_style: "secondary",
		feature_cta_2_size: "large",
	};
	const MODIFIER_SETS = {
		heading_size: [
			"fu-feature-section--heading-xl",
			"fu-feature-section--heading-lg",
			"fu-feature-section--heading-md",
		],
		image_fit: [
			"fu-feature-section--image-cover",
			"fu-feature-section--image-contain",
		],
		content_width: [
			"fu-feature-section--width-balanced",
			"fu-feature-section--width-content",
			"fu-feature-section--width-media",
		],
		layout_width: [
			"fu-feature-section--layout-feature",
			"fu-feature-section--layout-feature-max",
			"fu-feature-section--layout-full",
		],
		media_position: [
			"fu-feature-section--media-left",
			"fu-feature-section--media-right",
		],
		image_radius: [
			"fu-feature-section--radius-default",
			"fu-feature-section--radius-none",
			"fu-feature-section--radius-large",
		],
		fill_padding_inline: [
			"fu-feature-section--fill-inline-sm",
			"fu-feature-section--fill-inline-md",
			"fu-feature-section--fill-inline-lg",
		],
		fill_padding_block: [
			"fu-feature-section--fill-block-sm",
			"fu-feature-section--fill-block-md",
			"fu-feature-section--fill-block-lg",
		],
		vertical_align: [
			"fu-feature-section--align-top",
			"fu-feature-section--align-center",
		],
		button_group_alignment: [
			"fu-feature-section--actions-left",
			"fu-feature-section--actions-center",
		],
		background_token: [
			"fu-feature-section--bg-beige",
			"fu-feature-section--bg-blue",
			"fu-feature-section--bg-orange",
			"fu-feature-section--bg-charcoal",
		],
		text_scheme: [
			"fu-feature-section--text-auto",
			"fu-feature-section--text-dark",
			"fu-feature-section--text-light",
		],
	};
	const CTA_STYLE_CLASSES = [
		"fu-feature-section__cta--primary",
		"fu-feature-section__cta--secondary",
		"fu-feature-section__cta--ghost",
	];
	const CTA_SIZE_CLASSES = [
		"fu-feature-section__cta--small",
		"fu-feature-section__cta--medium",
		"fu-feature-section__cta--large",
	];
	const LAYOUT_WIDTH_CLASS_MAP = {
		default: "",
		feature: "fu-feature-section--layout-feature",
		"feature-max": "fu-feature-section--layout-feature-max",
		full: "fu-feature-section--layout-full",
	};

	const sanitizeChoice = (value, allowed, fallback) =>
		allowed.includes(value) ? value : fallback;

	const normalizeBooleanValue = (value, fallback = false) => {
		if (value === undefined || value === null || value === "") return fallback;
		if (typeof value === "boolean") return value;
		if (typeof value === "number") return value !== 0;
		if (typeof value === "string") {
			const normalized = value.trim().toLowerCase();
			if (["0", "false", "off", "no"].includes(normalized)) {
				return false;
			}
			if (["1", "true", "on", "yes"].includes(normalized)) {
				return true;
			}
		}
		return Boolean(value);
	};

	const getFieldElement = (field) =>
		field?.$el?.get?.(0) || field?.$el?.[0] || null;

	const getEditorDocuments = () => {
		const docs = [document];
		const iframe = document.querySelector('iframe[name="editor-canvas"]');

		if (iframe?.contentDocument) {
			docs.unshift(iframe.contentDocument);
		}

		return docs;
	};

	const getBlockComponentElement = (fieldOrElement) => {
		const element =
			fieldOrElement?.nodeType === 1
				? fieldOrElement
				: getFieldElement(fieldOrElement);

		if (!element) {
			return null;
		}

		return (
			element.closest(".acf-block-component") ||
			element.closest(BLOCK_WRAPPER_SELECTOR) ||
			element.closest(".block-editor-block-list__block")
		);
	};

	const getSelectedPreviewElement = () => {
		const clientId = wp?.data
			?.select("core/block-editor")
			?.getSelectedBlockClientId?.();
		const docs = getEditorDocuments();

		if (clientId) {
			const selectors = [
				`[data-block="${clientId}"] ${ROOT_SELECTOR}`,
				`[data-block="${clientId}"]${ROOT_SELECTOR}`,
				`#block-${clientId} ${ROOT_SELECTOR}`,
				`#block-${clientId}${ROOT_SELECTOR}`,
			];

			for (const targetDoc of docs) {
				for (const selector of selectors) {
					const preview = targetDoc.querySelector(selector);
					if (preview) {
						return preview;
					}
				}
			}
		}

		for (const targetDoc of docs) {
			const previews = targetDoc.querySelectorAll(ROOT_SELECTOR);
			if (previews.length === 1) {
				return previews[0];
			}
		}

		return null;
	};

	const getPreviewElement = (fieldOrElement) => {
		const component = getBlockComponentElement(fieldOrElement);

		if (component) {
			if (component.classList?.contains("fu-feature-section")) {
				return component;
			}

			const preview = component.querySelector(ROOT_SELECTOR);
			if (preview) {
				return preview;
			}
		}

		return getSelectedPreviewElement();
	};

	const getFieldsContainer = (fieldOrElement) => {
		const fieldElement =
			fieldOrElement?.nodeType === 1
				? fieldOrElement
				: getFieldElement(fieldOrElement);

		if (!fieldElement) {
			return null;
		}

		return (
			fieldElement.closest(".acf-block-fields") ||
			getBlockComponentElement(fieldElement)?.querySelector(
				".acf-block-fields"
			) ||
			null
		);
	};

	const readState = (fieldOrElement) => {
		const container = getFieldsContainer(fieldOrElement);

		if (!container || typeof acf?.getFields !== "function") {
			return null;
		}

		const values = { ...DEFAULTS };
		const fields = acf.getFields({ parent: container }) || [];

		fields.forEach((field) => {
			const name = field?.get?.("name");
			if (!name || !(name in values)) {
				return;
			}

			values[name] = field.val();
		});

		return {
			heading_size: sanitizeChoice(
				values.feature_heading_size,
				["xl", "lg", "md"],
				DEFAULTS.feature_heading_size
			),
			image_fit: sanitizeChoice(
				values.feature_image_fit,
				["cover", "contain"],
				DEFAULTS.feature_image_fit
			),
			content_width: sanitizeChoice(
				values.feature_content_width,
				["balanced", "content", "media"],
				DEFAULTS.feature_content_width
			),
			layout_width: sanitizeChoice(
				values.feature_layout_width,
				["default", "feature", "feature-max", "full"],
				DEFAULTS.feature_layout_width
			),
			media_position: sanitizeChoice(
				values.feature_media_position,
				["left", "right"],
				DEFAULTS.feature_media_position
			),
			media_fill: normalizeBooleanValue(
				values.feature_media_fill,
				DEFAULTS.feature_media_fill
			),
			image_radius: sanitizeChoice(
				values.feature_image_radius,
				["default", "none", "large"],
				DEFAULTS.feature_image_radius
			),
			fill_padding_inline: sanitizeChoice(
				values.feature_fill_padding_inline,
				["small", "medium", "large"],
				DEFAULTS.feature_fill_padding_inline
			),
			fill_padding_block: sanitizeChoice(
				values.feature_fill_padding_block,
				["small", "medium", "large"],
				DEFAULTS.feature_fill_padding_block
			),
			vertical_align: sanitizeChoice(
				values.feature_vertical_align,
				["top", "center"],
				DEFAULTS.feature_vertical_align
			),
			button_group_alignment: sanitizeChoice(
				values.feature_button_group_alignment,
				["left", "center"],
				DEFAULTS.feature_button_group_alignment
			),
			background_token: sanitizeChoice(
				values.feature_background_token,
				["beige", "blue", "orange", "charcoal"],
				DEFAULTS.feature_background_token
			),
			text_scheme: sanitizeChoice(
				values.feature_text_scheme,
				["auto", "dark", "light"],
				DEFAULTS.feature_text_scheme
			),
			show_cta_1: normalizeBooleanValue(
				values.feature_show_cta_1,
				DEFAULTS.feature_show_cta_1
			),
			cta_1_style: sanitizeChoice(
				values.feature_cta_1_style,
				["primary", "secondary", "ghost"],
				DEFAULTS.feature_cta_1_style
			),
			cta_1_size: sanitizeChoice(
				values.feature_cta_1_size,
				["small", "medium", "large"],
				DEFAULTS.feature_cta_1_size
			),
			show_cta_2: normalizeBooleanValue(
				values.feature_show_cta_2,
				DEFAULTS.feature_show_cta_2
			),
			cta_2_style: sanitizeChoice(
				values.feature_cta_2_style,
				["primary", "secondary", "ghost"],
				DEFAULTS.feature_cta_2_style
			),
			cta_2_size: sanitizeChoice(
				values.feature_cta_2_size,
				["small", "medium", "large"],
				DEFAULTS.feature_cta_2_size
			),
		};
	};

	const replaceModifierSet = (preview, classNames, nextClass) => {
		preview.classList.remove(...classNames);
		preview.classList.add(nextClass);
	};

	const updateLayoutWidthClass = (preview, layoutWidth) => {
		if (!preview) {
			return;
		}

		preview.classList.remove(...MODIFIER_SETS.layout_width);

		const nextClass = LAYOUT_WIDTH_CLASS_MAP[layoutWidth] || "";

		if (nextClass) {
			preview.classList.add(nextClass);
		}
	};

	const updateCtaClasses = (preview, selector, styleValue, sizeValue) => {
		const cta = preview.querySelector(selector);
		if (!cta) {
			return;
		}

		cta.classList.remove(...CTA_STYLE_CLASSES, ...CTA_SIZE_CLASSES);
		cta.classList.add(
			`fu-feature-section__cta--${styleValue}`,
			`fu-feature-section__cta--${sizeValue}`
		);
	};

	const applyState = (preview, state) => {
		if (!preview || !state) {
			return false;
		}

		replaceModifierSet(
			preview,
			MODIFIER_SETS.heading_size,
			`fu-feature-section--heading-${state.heading_size}`
		);
		replaceModifierSet(
			preview,
			MODIFIER_SETS.image_fit,
			`fu-feature-section--image-${state.image_fit}`
		);
		replaceModifierSet(
			preview,
			MODIFIER_SETS.content_width,
			`fu-feature-section--width-${state.content_width}`
		);
		updateLayoutWidthClass(preview, state.layout_width);
		replaceModifierSet(
			preview,
			MODIFIER_SETS.media_position,
			`fu-feature-section--media-${state.media_position}`
		);
		const resolvedImageRadius = state.media_fill ? "none" : state.image_radius;
		replaceModifierSet(
			preview,
			MODIFIER_SETS.image_radius,
			`fu-feature-section--radius-${resolvedImageRadius}`
		);
		replaceModifierSet(
			preview,
			MODIFIER_SETS.fill_padding_inline,
			`fu-feature-section--fill-inline-${
				state.fill_padding_inline === "small"
					? "sm"
					: state.fill_padding_inline === "large"
					? "lg"
					: "md"
			}`
		);
		replaceModifierSet(
			preview,
			MODIFIER_SETS.fill_padding_block,
			`fu-feature-section--fill-block-${
				state.fill_padding_block === "small"
					? "sm"
					: state.fill_padding_block === "large"
					? "lg"
					: "md"
			}`
		);
		replaceModifierSet(
			preview,
			MODIFIER_SETS.vertical_align,
			`fu-feature-section--align-${state.vertical_align}`
		);
		replaceModifierSet(
			preview,
			MODIFIER_SETS.button_group_alignment,
			`fu-feature-section--actions-${state.button_group_alignment}`
		);
		replaceModifierSet(
			preview,
			MODIFIER_SETS.background_token,
			`fu-feature-section--bg-${state.background_token}`
		);
		replaceModifierSet(
			preview,
			MODIFIER_SETS.text_scheme,
			`fu-feature-section--text-${state.text_scheme}`
		);
		preview.classList.toggle(
			"fu-feature-section--hide-cta-1",
			!state.show_cta_1
		);
		preview.classList.toggle(
			"fu-feature-section--hide-cta-2",
			!state.show_cta_2
		);
		preview.classList.toggle(
			"fu-feature-section--media-fill",
			state.media_fill
		);

		updateCtaClasses(
			preview,
			".fu-feature-section__cta--1",
			state.cta_1_style,
			state.cta_1_size
		);
		updateCtaClasses(
			preview,
			".fu-feature-section__cta--2",
			state.cta_2_style,
			state.cta_2_size
		);

		return true;
	};

	const syncPreviewState = (field) => {
		const preview = getPreviewElement(field);
		const state = readState(field);

		if (!preview || !state) {
			return false;
		}

		return applyState(preview, state);
	};

	const requestPreviewRerender = () => {
		if (typeof acf?.doAction === "function") {
			acf.doAction("render_block_preview");
		}
	};

	SYNC_FIELD_KEYS.forEach((fieldKey) => {
		acf.addAction(`change_field/key=${fieldKey}`, (field) => {
			requestAnimationFrame(() => {
				if (!syncPreviewState(field)) {
					requestPreviewRerender();
				}
			});
		});
	});

	RERENDER_FIELD_KEYS.forEach((fieldKey) => {
		acf.addAction(`change_field/key=${fieldKey}`, () => {
			requestAnimationFrame(() => {
				requestPreviewRerender();
			});
		});
	});
})();
