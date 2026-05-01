<?php

/**
 * FU Switcher Panel block template.
 *
 * @param array $block The block settings and attributes.
 */

$panel_label = trim((string) get_field('panel_label'));
$panel_icon  = sanitize_key((string) get_field('panel_icon'));

$enable_panel_deeplink = (bool) get_field('enable_panel_deeplink');
$raw_panel_slug        = trim((string) get_field('panel_slug'));
$panel_slug            = $enable_panel_deeplink && $raw_panel_slug !== ''
    ? sanitize_title($raw_panel_slug)
    : sanitize_title($panel_label);

$panel_layout = get_field('panel_layout') ?: 'text_media';
$panel_layout = in_array($panel_layout, array('text_only', 'text_media', 'media_text'), true)
    ? $panel_layout
    : 'text_media';

$panel_eyebrow    = trim((string) get_field('panel_eyebrow'));
$panel_heading    = trim((string) get_field('panel_heading'));
$panel_body       = get_field('panel_body');
$panel_highlights = get_field('panel_highlights');
$panel_image      = get_field('panel_image');

$show_primary_button = (bool) get_field('show_primary_button');
$panel_cta_1_link    = get_field('panel_cta_1_link');
$panel_cta_1_style   = get_field('panel_cta_1_style') ?: 'primary';
$panel_cta_1_size    = get_field('panel_cta_1_size') ?: 'medium';

$show_secondary_button = (bool) get_field('show_secondary_button');
$panel_cta_2_link      = get_field('panel_cta_2_link');
$panel_cta_2_style     = get_field('panel_cta_2_style') ?: 'secondary';
$panel_cta_2_size      = get_field('panel_cta_2_size') ?: 'medium';

$style_options = array('primary', 'secondary', 'outline', 'text');
$size_options  = array('small', 'medium', 'large');

$panel_cta_1_style = in_array($panel_cta_1_style, $style_options, true) ? $panel_cta_1_style : 'primary';
$panel_cta_2_style = in_array($panel_cta_2_style, $style_options, true) ? $panel_cta_2_style : 'secondary';
$panel_cta_1_size  = in_array($panel_cta_1_size, $size_options, true) ? $panel_cta_1_size : 'medium';
$panel_cta_2_size  = in_array($panel_cta_2_size, $size_options, true) ? $panel_cta_2_size : 'medium';

$panel_heading    = $panel_heading !== '' ? $panel_heading : $panel_label;
$panel_slug       = $panel_slug !== '' ? $panel_slug : 'panel';
$panel_highlights = is_array($panel_highlights) ? array_slice($panel_highlights, 0, 4) : array();
$panel_image      = is_array($panel_image) ? $panel_image : array();
$has_media        = $panel_layout !== 'text_only' && (!empty($panel_image['ID']) || !empty($panel_image['url']));

$panel_cta_1_link = is_array($panel_cta_1_link) ? $panel_cta_1_link : array();
$panel_cta_2_link = is_array($panel_cta_2_link) ? $panel_cta_2_link : array();

$panel_cta_1_title  = trim((string) ($panel_cta_1_link['title'] ?? ''));
$panel_cta_1_url    = trim((string) ($panel_cta_1_link['url'] ?? ''));
$panel_cta_1_target = trim((string) ($panel_cta_1_link['target'] ?? ''));

$panel_cta_2_title  = trim((string) ($panel_cta_2_link['title'] ?? ''));
$panel_cta_2_url    = trim((string) ($panel_cta_2_link['url'] ?? ''));
$panel_cta_2_target = trim((string) ($panel_cta_2_link['target'] ?? ''));

$has_primary_button   = $show_primary_button;
$has_secondary_button = $show_secondary_button;
$has_actions          = $has_primary_button || $has_secondary_button;

$classes = array(
    'fu-switcher-panel',
    'fu-switcher-panel--layout-' . $panel_layout,
);

if (!empty($block['className']) && is_string($block['className'])) {
    $classes[] = $block['className'];
}

$body_markup        = is_string($panel_body) && trim($panel_body) !== '' ? wp_kses_post($panel_body) : '';
$editor_panel_label = $panel_label !== '' ? $panel_label . ' Panel' : 'Switcher Panel';

$render_panel_action = static function ($link, $style, $size, $fallback_label, $is_preview) {
    $link   = is_array($link) ? $link : array();
    $title  = trim((string) ($link['title'] ?? ''));
    $url    = trim((string) ($link['url'] ?? ''));
    $target = trim((string) ($link['target'] ?? ''));
    $label  = $title !== '' ? $title : $fallback_label;

    $classes = array(
        'fu-switcher-panel__action',
        'fu-switcher-panel__action--' . sanitize_html_class($style),
        'fu-switcher-panel__action--' . sanitize_html_class($size),
        'fu-switcher-panel__action--size-' . sanitize_html_class($size),
    );

    if ($url !== '') {
        $target_attr = $target !== '' ? ' target="' . esc_attr($target) . '"' : '';
        $rel_attr    = $target === '_blank' ? ' rel="noopener"' : '';

        printf(
            '<a class="%1$s" href="%2$s"%3$s%4$s>%5$s</a>',
            esc_attr(implode(' ', $classes)),
            esc_url($url),
            $target_attr, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            $rel_attr, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            esc_html($label)
        );

        return;
    }

    if (!empty($is_preview)) {
        $classes[] = 'is-placeholder';

        printf(
            '<span class="%1$s" aria-disabled="true">%2$s</span>',
            esc_attr(implode(' ', $classes)),
            esc_html($label)
        );
    }
};
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
                <div class="fu-switcher-panel__body"><?php echo $body_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                                                        ?></div>
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
                    <?php
                    if ($has_primary_button) {
                        $render_panel_action(
                            $panel_cta_1_link,
                            $panel_cta_1_style,
                            $panel_cta_1_size,
                            'Add primary button link',
                            !empty($is_preview)
                        );
                    }

                    if ($has_secondary_button) {
                        $render_panel_action(
                            $panel_cta_2_link,
                            $panel_cta_2_style,
                            $panel_cta_2_size,
                            'Add secondary button link',
                            !empty($is_preview)
                        );
                    }
                    ?>
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
                            'class'    => 'fu-switcher-panel__image',
                            'loading'  => 'lazy',
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