<?php

/**
 * FU Switcher Panel block template.
 *
 * @param array $block The block settings and attributes.
 */

$panel_label = trim((string) get_field('panel_label'));
$panel_slug = sanitize_title((string) get_field('panel_slug'));
$panel_icon = sanitize_key((string) get_field('panel_icon'));
$panel_eyebrow = trim((string) get_field('panel_eyebrow'));
$panel_heading = trim((string) get_field('panel_heading'));
$panel_body = get_field('panel_body');
$panel_highlights = get_field('panel_highlights');
$panel_image = get_field('panel_image');
$panel_cta_1_text = trim((string) get_field('panel_cta_1_text'));
$panel_cta_1_url = trim((string) get_field('panel_cta_1_url'));
$panel_cta_2_text = trim((string) get_field('panel_cta_2_text'));
$panel_cta_2_url = trim((string) get_field('panel_cta_2_url'));

$panel_heading = $panel_heading !== '' ? $panel_heading : $panel_label;
$panel_slug = $panel_slug !== '' ? $panel_slug : sanitize_title($panel_label);
$panel_highlights = is_array($panel_highlights) ? array_slice($panel_highlights, 0, 4) : array();
$has_media = is_array($panel_image) && (!empty($panel_image['ID']) || !empty($panel_image['url']));
$has_actions = ($panel_cta_1_text !== '' && $panel_cta_1_url !== '') || ($panel_cta_2_text !== '' && $panel_cta_2_url !== '');

$classes = array('fu-switcher-panel');

if (!empty($block['className'])) {
    $classes[] = $block['className'];
}

$body_markup = is_string($panel_body) && $panel_body !== '' ? wp_kses_post($panel_body) : '';
?>
<article
    class="<?php echo esc_attr(implode(' ', $classes)); ?>"
    data-panel-label="<?php echo esc_attr($panel_label !== '' ? $panel_label : 'Panel'); ?>"
    data-panel-slug="<?php echo esc_attr($panel_slug); ?>"
    data-panel-icon="<?php echo esc_attr($panel_icon); ?>">
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
                    <?php if ($panel_cta_1_text !== '' && $panel_cta_1_url !== '') : ?>
                        <a class="fu-switcher-panel__action fu-switcher-panel__action--primary" href="<?php echo esc_url($panel_cta_1_url); ?>"><?php echo esc_html($panel_cta_1_text); ?></a>
                    <?php endif; ?>

                    <?php if ($panel_cta_2_text !== '' && $panel_cta_2_url !== '') : ?>
                        <a class="fu-switcher-panel__action fu-switcher-panel__action--secondary" href="<?php echo esc_url($panel_cta_2_url); ?>"><?php echo esc_html($panel_cta_2_text); ?></a>
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