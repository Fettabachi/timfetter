<?php

/**
 * Feature Section block template.
 *
 * Guided premium feature block with strong editor/frontend parity.
 *
 * @param array $block The block settings and attributes.
 */

$is_editor = is_admin();

$sanitize_choice = static function ($value, array $allowed, $fallback) {
    return in_array($value, $allowed, true) ? $value : $fallback;
};

$default_heading = 'A standout portfolio project with a clear outcome';

$eyebrow = trim((string) get_field('feature_eyebrow'));

$heading = trim((string) get_field('feature_heading'));
if ($heading === '') {
    $heading = $default_heading;
}

$heading_level = $sanitize_choice(
    get_field('feature_heading_level') ?: 'h2',
    array('h2', 'h3', 'h4'),
    'h2'
);

$heading_size = $sanitize_choice(
    get_field('feature_heading_size') ?: 'xl',
    array('xl', 'lg', 'md'),
    'xl'
);

$body = trim((string) get_field('feature_body'));

$image_id = (int) get_field('feature_image');
$has_image = $image_id > 0;

$image_fit = $sanitize_choice(
    get_field('feature_image_fit') ?: 'cover',
    array('cover', 'contain'),
    'cover'
);

$content_width = $sanitize_choice(
    get_field('feature_content_width') ?: 'balanced',
    array('balanced', 'content', 'media'),
    'balanced'
);

$media_position = $sanitize_choice(
    get_field('feature_media_position') ?: 'right',
    array('left', 'right'),
    'right'
);

$mobile_media_mode = $sanitize_choice(
    get_field('feature_mobile_media_mode') ?: 'stack',
    array('stack', 'overlay'),
    'stack'
);

$mobile_overlay_intensity = $sanitize_choice(
    get_field('feature_mobile_overlay_intensity') ?: 'medium',
    array('light', 'medium', 'strong'),
    'medium'
);

$media_fill_value = get_field('feature_media_fill');
$media_fill = $media_fill_value === null ? false : (bool) $media_fill_value;

if (!$has_image || $image_fit !== 'cover') {
    $media_fill = false;
}

$image_radius = $sanitize_choice(
    get_field('feature_image_radius') ?: 'default',
    array('default', 'none', 'large'),
    'default'
);

$fill_padding_inline = $sanitize_choice(
    get_field('feature_fill_padding_inline') ?: 'medium',
    array('small', 'medium', 'large'),
    'medium'
);

$fill_padding_block = $sanitize_choice(
    get_field('feature_fill_padding_block') ?: 'medium',
    array('small', 'medium', 'large'),
    'medium'
);

$fill_padding_tokens = array(
    'small' => 'sm',
    'medium' => 'md',
    'large' => 'lg',
);

if ($media_fill) {
    $image_radius = 'none';
}

$use_image_border_radius = ($has_image && $image_fit === 'cover' && !$media_fill);

$vertical_align = $sanitize_choice(
    get_field('feature_vertical_align') ?: 'center',
    array('top', 'center'),
    'center'
);

$tablet_vertical_align = $sanitize_choice(
    get_field('feature_tablet_vertical_align') ?: 'default',
    array('default', 'top', 'center'),
    'default'
);

$actions_alignment = $sanitize_choice(
    get_field('feature_button_group_alignment') ?: 'left',
    array('left', 'center'),
    'left'
);

$background_token = $sanitize_choice(
    get_field('feature_background_token') ?: 'beige',
    array('white', 'beige', 'blue', 'orange', 'charcoal'),
    'beige'
);

$text_scheme = $sanitize_choice(
    get_field('feature_text_scheme') ?: 'auto',
    array('auto', 'dark', 'light'),
    'auto'
);

$show_cta_1_value = get_field('feature_show_cta_1');
$show_cta_2_value = get_field('feature_show_cta_2');

$show_cta_1 = $show_cta_1_value === null ? true : (bool) $show_cta_1_value;
$show_cta_2 = $show_cta_2_value === null ? false : (bool) $show_cta_2_value;

$cta_1_link = get_field('feature_cta_1_link');
$cta_1_link = is_array($cta_1_link) ? $cta_1_link : array();
$cta_1_has_link = !empty($cta_1_link['url']);
$cta_1_text = trim((string) ($cta_1_link['title'] ?? ''));
if ($cta_1_text === '') {
    $cta_1_text = 'View Project';
}

$cta_1_target = !empty($cta_1_link['target']) ? $cta_1_link['target'] : '_self';
$cta_1_style = $sanitize_choice(
    get_field('feature_cta_1_style') ?: 'primary',
    array('primary', 'secondary', 'ghost', 'dark'),
    'primary'
);
$cta_1_size = $sanitize_choice(
    get_field('feature_cta_1_size') ?: 'large',
    array('small', 'medium', 'large'),
    'large'
);

$cta_2_link = get_field('feature_cta_2_link');
$cta_2_link = is_array($cta_2_link) ? $cta_2_link : array();
$cta_2_has_link = !empty($cta_2_link['url']);
$cta_2_text = trim((string) ($cta_2_link['title'] ?? ''));
if ($cta_2_text === '') {
    $cta_2_text = 'Read More';
}

$cta_2_target = !empty($cta_2_link['target']) ? $cta_2_link['target'] : '_self';
$cta_2_style = $sanitize_choice(
    get_field('feature_cta_2_style') ?: 'secondary',
    array('primary', 'secondary', 'ghost', 'dark'),
    'secondary'
);
$cta_2_size = $sanitize_choice(
    get_field('feature_cta_2_size') ?: 'large',
    array('small', 'medium', 'large'),
    'large'
);

$should_render_cta_1 = $show_cta_1 && ($cta_1_has_link || $is_editor);
$should_render_cta_2 = $show_cta_2 && $cta_2_has_link;
$should_render_actions = $should_render_cta_1 || $should_render_cta_2;
$should_render_media = $has_image;

$block_anchor = !empty($block['anchor']) ? $block['anchor'] : 'fu-feature-section-' . $block['id'];

$classes = array(
    'fu-feature-section',
    'fu-feature-section--actions-' . $actions_alignment,
    'fu-feature-section--bg-' . $background_token,
    'fu-feature-section--text-' . $text_scheme,
    'fu-feature-section--heading-' . $heading_size,
    $has_image ? 'fu-feature-section--has-image' : 'fu-feature-section--no-image',
);

if ($has_image) {
    $classes[] = 'fu-feature-section--media-' . $media_position;
    $classes[] = 'fu-feature-section--mobile-' . $mobile_media_mode;
    $classes[] = 'fu-feature-section--overlay-' . $mobile_overlay_intensity;
    $classes[] = 'fu-feature-section--width-' . $content_width;
    $classes[] = 'fu-feature-section--align-' . $vertical_align;
    $classes[] = 'fu-feature-section--image-' . $image_fit;
}

if ($use_image_border_radius) {
    $classes[] = 'fu-feature-section--radius-' . $image_radius;
}

if ($has_image && $tablet_vertical_align !== 'default') {
    $classes[] = 'fu-feature-section--tablet-align-' . $tablet_vertical_align;
}

if ($media_fill) {
    $classes[] = 'fu-feature-section--media-fill';
    $classes[] = 'fu-feature-section--fill-inline-' . $fill_padding_tokens[$fill_padding_inline];
    $classes[] = 'fu-feature-section--fill-block-' . $fill_padding_tokens[$fill_padding_block];
}

if (!$should_render_cta_1) {
    $classes[] = 'fu-feature-section--hide-cta-1';
}

if (!$should_render_cta_2) {
    $classes[] = 'fu-feature-section--hide-cta-2';
}

if (!empty($block['align'])) {
    $classes[] = 'align' . $block['align'];
}

if (!empty($block['className'])) {
    $classes[] = $block['className'];
}

$cta_1_classes = array(
    'fu-feature-section__cta',
    'fu-feature-section__cta--1',
    'fu-feature-section__cta--' . $cta_1_style,
    'fu-feature-section__cta--' . $cta_1_size,
);

$cta_2_classes = array(
    'fu-feature-section__cta',
    'fu-feature-section__cta--2',
    'fu-feature-section__cta--' . $cta_2_style,
    'fu-feature-section__cta--' . $cta_2_size,
);

$image_markup = '';
if ($image_id > 0) {
    $image_markup = wp_get_attachment_image(
        $image_id,
        'full',
        false,
        array(
            'class' => 'fu-feature-section__image',
            'loading' => 'lazy',
            'decoding' => 'async',
        )
    );
}

$body_markup = $body !== '' ? wp_kses_post(wpautop(esc_html($body))) : '';

$render_content = static function () use (
    $eyebrow,
    $heading_level,
    $heading,
    $body_markup,
    $should_render_actions,
    $should_render_cta_1,
    $cta_1_has_link,
    $cta_1_classes,
    $cta_1_link,
    $cta_1_target,
    $cta_1_text,
    $is_editor,
    $should_render_cta_2,
    $cta_2_classes,
    $cta_2_link,
    $cta_2_target,
    $cta_2_text
) {
?>
    <div class="fu-feature-section__content">
        <?php if ($eyebrow !== '') : ?>
            <p class="fu-feature-section__eyebrow"><?php echo esc_html($eyebrow); ?></p>
        <?php endif; ?>

        <<?php echo esc_attr($heading_level); ?> class="fu-feature-section__heading">
            <?php echo esc_html($heading); ?>
        </<?php echo esc_attr($heading_level); ?>>

        <?php if ($body_markup !== '') : ?>
            <div class="fu-feature-section__body">
                <?php echo $body_markup; ?>
            </div>
        <?php endif; ?>

        <?php if ($should_render_actions) : ?>
            <div class="fu-feature-section__actions">
                <?php if ($should_render_cta_1) : ?>
                    <?php if ($cta_1_has_link) : ?>
                        <a
                            class="<?php echo esc_attr(implode(' ', $cta_1_classes)); ?>"
                            href="<?php echo esc_url($cta_1_link['url']); ?>"
                            target="<?php echo esc_attr($cta_1_target); ?>"
                            <?php echo $cta_1_target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>><?php echo esc_html($cta_1_text); ?></a>
                    <?php elseif ($is_editor) : ?>
                        <span class="<?php echo esc_attr(implode(' ', $cta_1_classes)); ?> is-placeholder" aria-disabled="true">
                            <?php echo esc_html($cta_1_text); ?>
                        </span>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ($should_render_cta_2) : ?>
                    <a
                        class="<?php echo esc_attr(implode(' ', $cta_2_classes)); ?>"
                        href="<?php echo esc_url($cta_2_link['url']); ?>"
                        target="<?php echo esc_attr($cta_2_target); ?>"
                        <?php echo $cta_2_target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>><?php echo esc_html($cta_2_text); ?></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
<?php
};

$render_media = static function () use ($should_render_media, $image_id, $image_markup, $is_editor) {
    if (!$should_render_media) {
        return;
    }
?>
    <div class="fu-feature-section__media<?php echo $image_id > 0 ? '' : ' is-placeholder'; ?>">
        <div class="fu-feature-section__image-wrap">
            <?php if ($image_markup !== '') : ?>
                <?php echo $image_markup; ?>
            <?php elseif ($is_editor) : ?>
                <div class="fu-feature-section__image-placeholder" aria-hidden="true">
                    <span>Add a feature image</span>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php
};
?>

<section
    id="<?php echo esc_attr($block_anchor); ?>"
    class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <div class="fu-feature-section__inner">
        <?php if ($media_position === 'left' && $should_render_media) : ?>
            <?php $render_media(); ?>
        <?php endif; ?>

        <?php $render_content(); ?>

        <?php if ($media_position === 'right' && $should_render_media) : ?>
            <?php $render_media(); ?>
        <?php endif; ?>
    </div>
</section>