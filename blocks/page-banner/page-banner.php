<?php

/**
 * Page Banner Block - Optimized & Secure Version
 */

// 1. Setup Fields (Using null coalescing for cleaner defaults)
$bg_type      = get_field('background_type') ?: 'image';
$video_field  = get_field('video_file');
$video_url    = '';

if (is_array($video_field)) {
    $video_url = $video_field['url'] ?? '';
} elseif (is_string($video_field)) {
    $candidate = trim($video_field);
    if ($candidate !== '' && $candidate !== 'undefined' && $candidate !== 'null') {
        $video_url = $candidate;
    }
}

$image        = get_field('page_banner_image');
$focal_point  = get_field('bg_focal_point') ?: 'center center';
$focal_point  = is_string($focal_point) ? trim($focal_point) : 'center center';
$focal_point  = $focal_point === 'center' || $focal_point === '' ? 'center center' : $focal_point;
$alignment    = get_field('alignment_buttons') ?: 'center';
$padding_top = get_field('padding_top') ?: 'medium';
$padding_bottom = get_field('padding_bottom') ?: 'medium';

// Visual Filters & Overlays
$contrast     = get_field('banner_contrast') ?? '100';
$grayscale    = get_field('banner_grayscale') ? '100%' : '0%';
$saturate     = get_field('banner_saturation') ?: '100';
$blur         = get_field('pause_blur_intensity') ?: '0';
$brand_hex    = get_field('banner_overlay_brand_color') ?: '#000000';
$opacity_raw  = get_field('banner_overlay_opacity') ?: '50';
$opacity      = $opacity_raw / 100;
$blend_mode   = get_field('banner_overlay_blend_mode') ?: 'normal';

// Visibility Toggles
$show_subhead_value = get_field('show_subhead');
$show_body_value    = get_field('show_body');
$show_btn_1_value = get_field('show_btn_1');
$show_btn_2_value = get_field('show_btn_2');

$show_subhead = $show_subhead_value === null ? true : (bool) $show_subhead_value;
$show_body    = $show_body_value === null ? true : (bool) $show_body_value;
$show_btn_1 = $show_btn_1_value === null ? true : (bool) $show_btn_1_value;
$show_btn_2 = $show_btn_2_value === null ? true : (bool) $show_btn_2_value;

// 2. Logic & Classes
$fallback_img = get_theme_file_uri('/images/library-hero.jpg');
$bg_url       = ($image) ? $image['url'] : $fallback_img;
$block_id     = 'fu-banner-' . $block['id'];

$classes = ['fu-page-banner', 'alignfull'];
if (!empty($block['className'])) $classes[] = $block['className'];
if ($alignment) $classes[] = 'fu-page-banner--align-' . $alignment;
if ($padding_top) $classes[] = 'fu-page-banner--pt-' . sanitize_html_class($padding_top);
if ($padding_bottom) $classes[] = 'fu-page-banner--pb-' . sanitize_html_class($padding_bottom);

// Video-specific logic
$banner_args = '';
if ($bg_type === 'video' && $video_url) {
    $classes[] = 'has-video';
    $banner_args = 'data-pause-on-scroll="true"';
}

// Map Visibility to CSS classes
if (!$show_subhead) $classes[] = 'hide-subhead';
if (!$show_body)    $classes[] = 'hide-body';
if (!$show_btn_1) $classes[] = 'hide-btn-1';
if (!$show_btn_2) $classes[] = 'hide-btn-2';

// 3. Style Variable String (Sanitized)
$style_vars = array(
    '--banner-contrast'            => $contrast . '%',
    '--banner-grayscale'           => $grayscale,
    '--banner-saturate'            => $saturate . '%',
    '--banner-blur'                => $blur . 'px',
    '--banner-overlay-color'       => $brand_hex,
    '--banner-overlay-opacity'     => $opacity,
    '--banner-video-focal-point'   => $focal_point,
    '--banner-blend-mode'          => $blend_mode,
);

$style_string = '';
foreach ($style_vars as $key => $val) {
    $style_string .= "{$key}: {$val}; ";
}

// 4. InnerBlocks Template
$template = [
    ['acf/fu-heading', [
        'data' => [
            'heading_level' => 'h1',
            '_heading_level' => 'field_69a1886babed3',
        ],
        'heading_level' => 'h1',
        'className' => 'fu-page-banner__primary-heading',
    ]],
    ['acf/fu-heading', [
        'data' => [
            'heading_level' => 'h2',
            '_heading_level' => 'field_69a1886babed3',
        ],
        'heading_level' => 'h2',
        'className' => 'fu-page-banner__subhead',
    ]],
    ['acf/fu-page-banner-text', [
        'data' => [
            'banner_role' => 'body',
            '_banner_role' => 'field_69df0002abed2',
            'body_text' => 'Descriptive text goes here.',
            '_body_text' => 'field_69df0002abed1',
        ],
        'banner_role' => 'body',
    ]],
    ['core/group', ['className' => 'fu-banner-button-wrapper'], [
        ['acf/fu-button', ['btn_text' => 'Primary Action', 'btn_color' => 'orange', 'btn_size' => 'large']],
        ['acf/fu-button', ['btn_text' => 'Secondary Action', 'btn_color' => 'blue', 'btn_size' => 'large']]
    ]]
];

// Editor Note
if (is_admin()) : ?>
    <div class="fu-editor-note" style="background: #d9efff; border-left: 4px solid #2271b1; padding: 12px; font-family: sans-serif; font-size: 13px;">
        <strong>Page Banner Config:</strong> Using <?php echo esc_html($bg_type); ?> background. Use block settings to adjust element visibility, content alignment, and Accessibility & Visual Styles.
    </div>
<?php endif; ?>

<section id="<?php echo esc_attr($block['anchor'] ?? $block_id); ?>"
    class="<?php echo esc_attr(implode(' ', $classes)); ?>"
    style="<?php echo esc_attr($style_string); ?>"
    <?php echo $banner_args; // No escaping needed for hardcoded data-args 
    ?>>
    <?php if (!is_admin()) : ?>
        <button type="button" class="fu-banner-config-toggle" data-banner-id="<?php echo esc_attr($block['anchor'] ?? $block_id); ?>" aria-label="Banner Controls" title="Banner Controls">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width: 24px; height: 24px">
                <path
                    fill-rule="evenodd"
                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>
    <?php endif; ?>

    <div class="fu-page-banner__media">
        <?php if ($bg_type === 'video' && $video_url) : ?>
            <video
                id="<?php echo esc_attr($block_id); ?>-video"
                class="fu-page-banner__video"
                muted loop playsinline autoplay preload="auto" aria-hidden="true"
                style="object-position: <?php echo esc_attr($focal_point); ?>;"
                <?php if (is_admin()) : ?>
                src="<?php echo esc_url($video_url); ?>"
                data-editor-video="<?php echo esc_url($video_url); ?>"
                data-editor-focal-point="<?php echo esc_attr($focal_point); ?>"
                <?php else : ?>
                data-lazy-video="<?php echo esc_url($video_url); ?>"
                <?php endif; ?>>
            </video>
        <?php else : ?>
            <div class="fu-page-banner__bg-image"
                style="background-image: url('<?php echo esc_url($bg_url); ?>'); background-position: <?php echo esc_attr($focal_point); ?>;">
            </div>
        <?php endif; ?>
    </div>

    <?php if ($bg_type === 'video' && $video_url) : ?>
        <button type="button" class="fu-banner-mute-toggle"
            aria-label="Toggle Video Playback"
            aria-pressed="false">
            <span class="video-icon" aria-hidden="true"></span>
            <span class="visibly-hidden">Pause/Play Background</span>
        </button>
    <?php endif; ?>

    <div class="fu-page-banner__content container">
        <?php echo '<InnerBlocks template="' . esc_attr(wp_json_encode($template)) . '" templateLock="all" />'; ?>
    </div>
</section>