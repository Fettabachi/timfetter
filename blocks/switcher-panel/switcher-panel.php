<?php

/**
 * FU Switcher Panel block template.
 *
 * @param array $block The block settings and attributes.
 */

$panel_label = trim((string) get_field('panel_label'));
$panel_layout = get_field('panel_layout') ?: 'text_media';
$panel_slug = sanitize_title((string) get_field('panel_slug'));
$panel_icon = sanitize_key((string) get_field('panel_icon'));
$panel_eyebrow = trim((string) get_field('panel_eyebrow'));
$panel_heading = trim((string) get_field('panel_heading'));
$panel_body = get_field('panel_body');
$panel_highlights = get_field('panel_highlights');
$panel_image = get_field('panel_image');
$show_primary_button = (bool) get_field('show_primary_button');
$panel_cta_1_link = get_field('panel_cta_1_link');
$panel_cta_1_style = get_field('panel_cta_1_style') ?: 'primary';
$panel_cta_1_size = get_field('panel_cta_1_size') ?: 'medium';
$show_secondary_button = (bool) get_field('show_secondary_button');
$panel_cta_2_link = get_field('panel_cta_2_link');
$panel_cta_2_style = get_field('panel_cta_2_style') ?: 'secondary';
$panel_cta_2_size = get_field('panel_cta_2_size') ?: 'medium';

$panel_heading = $panel_heading !== '' ? $panel_heading : $panel_label;
$panel_slug = $panel_slug !== '' ? $panel_slug : sanitize_title($panel_label);
$panel_layout = in_array($panel_layout, array('text_only', 'text_media', 'media_text'), true) ? $panel_layout : 'text_media';
$panel_highlights = is_array($panel_highlights) ? array_slice($panel_highlights, 0, 4) : array();
$has_media = $panel_layout !== 'text_only' && is_array($panel_image) && (!empty($panel_image['ID']) || !empty($panel_image['url']));
$panel_cta_1_link = is_array($panel_cta_1_link) ? $panel_cta_1_link : array();
$panel_cta_2_link = is_array($panel_cta_2_link) ? $panel_cta_2_link : array();
$panel_cta_1_title = trim((string) ($panel_cta_1_link['title'] ?? ''));
$panel_cta_1_url = trim((string) ($panel_cta_1_link['url'] ?? ''));
$panel_cta_1_target = trim((string) ($panel_cta_1_link['target'] ?? ''));
$panel_cta_2_title = trim((string) ($panel_cta_2_link['title'] ?? ''));
$panel_cta_2_url = trim((string) ($panel_cta_2_link['url'] ?? ''));
$panel_cta_2_target = trim((string) ($panel_cta_2_link['target'] ?? ''));
$has_primary_button = $show_primary_button;
$has_secondary_button = $show_secondary_button;
$has_actions = $has_primary_button || $has_secondary_button;

$classes = array(
    'fu-switcher-panel',
    'fu-switcher-panel--layout-' . $panel_layout,
);

if (!empty($block['className'])) {
    $classes[] = $block['className'];
}

$body_markup = is_string($panel_body) && $panel_body !== '' ? wp_kses_post($panel_body) : '';
$editor_panel_label = $panel_label !== '' ? $panel_label . ' Panel' : 'Panel';
$primary_button_has_link = $panel_cta_1_url !== '';
$secondary_button_has_link = $panel_cta_2_url !== '';
?>
<article
    class="<?php echo esc_attr(implode(' ', $classes)); ?>"
    data-panel-label="<?php echo esc_attr($panel_label !== '' ? $panel_label : 'Panel'); ?>"
    data-panel-slug="<?php echo esc_attr($panel_slug); ?>"
    data-panel-icon="<?php echo esc_attr($panel_icon); ?>">
    <?php if (!empty($is_preview)) : ?>
        <p class="fu-switcher-panel__editor-label"><?php echo esc_html($editor_panel_label); ?></p>
    <?php endif; ?>
    <div class="fu-switcher-panel__inner">
        <div class="fu-switcher-panel__content">
            <?php if ($panel_eyebrow !== '') : ?>
                <p class="fu-switcher-panel__eyebrow"><?php echo esc_html($panel_eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($panel_heading !== '') : ?>
                <h3 class="fu-switcher-panel__heading"><?php echo esc_html($panel_heading); ?></h3>
            <?php endif; ?>

            <?php if ($body_markup !== '') : ?>
                <div class="fu-switcher-panel__body"><?php echo $body_markup; ?></div>
            <?php endif; ?>

            <?php if (!empty($panel_highlights)) : ?>
                <ul class="fu-switcher-panel__highlights">
                    <?php foreach ($panel_highlights as $highlight_row) : ?>
                        <?php $highlight_text = trim((string) ($highlight_row['highlight_text'] ?? '')); ?>
                        <?php if ($highlight_text === '') : ?>
                            <?php continue; ?>
                        <?php endif; ?>
                        <li><?php echo esc_html($highlight_text); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php if ($has_actions) : ?>
                <div class="fu-switcher-panel__actions">
                    <?php if ($has_primary_button) : ?>
                        <?php $primary_label = $panel_cta_1_title !== '' ? $panel_cta_1_title : 'Add primary button link'; ?>
                        <?php $primary_classes = 'fu-switcher-panel__action fu-switcher-panel__action--' . sanitize_html_class($panel_cta_1_style) . ' fu-switcher-panel__action--size-' . sanitize_html_class($panel_cta_1_size); ?>
                        <?php if ($primary_button_has_link) : ?>
                            <a class="<?php echo esc_attr($primary_classes); ?>" href="<?php echo esc_url($panel_cta_1_url); ?>" <?php echo $panel_cta_1_target !== '' ? ' target="' . esc_attr($panel_cta_1_target) . '" rel="noopener"' : ''; ?>><?php echo esc_html($primary_label); ?></a>
                        <?php elseif (!empty($is_preview)) : ?>
                            <span class="<?php echo esc_attr($primary_classes . ' is-placeholder'); ?>" aria-disabled="true"><?php echo esc_html($primary_label); ?></span>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($has_secondary_button) : ?>
                        <?php $secondary_label = $panel_cta_2_title !== '' ? $panel_cta_2_title : 'Add secondary button link'; ?>
                        <?php $secondary_classes = 'fu-switcher-panel__action fu-switcher-panel__action--' . sanitize_html_class($panel_cta_2_style) . ' fu-switcher-panel__action--size-' . sanitize_html_class($panel_cta_2_size); ?>
                        <?php if ($secondary_button_has_link) : ?>
                            <a class="<?php echo esc_attr($secondary_classes); ?>" href="<?php echo esc_url($panel_cta_2_url); ?>" <?php echo $panel_cta_2_target !== '' ? ' target="' . esc_attr($panel_cta_2_target) . '" rel="noopener"' : ''; ?>><?php echo esc_html($secondary_label); ?></a>
                        <?php elseif (!empty($is_preview)) : ?>
                            <span class="<?php echo esc_attr($secondary_classes . ' is-placeholder'); ?>" aria-disabled="true"><?php echo esc_html($secondary_label); ?></span>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($has_media) : ?>
            <div class="fu-switcher-panel__media">
                <?php if (!empty($panel_image['ID'])) : ?>
                    <?php
                    echo wp_get_attachment_image(
                        (int) $panel_image['ID'],
                        'large',
                        false,
                        array(
                            'class' => 'fu-switcher-panel__image',
                            'loading' => 'lazy',
                            'decoding' => 'async',
                        )
                    );
                    ?>
                <?php elseif (!empty($panel_image['url'])) : ?>
                    <img
                        class="fu-switcher-panel__image"
                        src="<?php echo esc_url($panel_image['url']); ?>"
                        alt="<?php echo esc_attr($panel_image['alt'] ?? ''); ?>"
                        loading="lazy"
                        decoding="async">
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</article>