<?php

/**
 * Template part for displaying Properties with a Dynamic Hero
 */

// 1. Dynamic Data for the Banner
$post_id      = get_the_ID();
$image_id     = get_post_thumbnail_id($post_id);
$image_url    = get_the_post_thumbnail_url($post_id, 'extra-wide-image');
$fallback_img = get_theme_file_uri('/images/library-hero.jpg');
$bg_url       = $image_url ?: $fallback_img;

// 2. Visual Overlays (Pulling from Property ACF or using Defaults)
// This allows you to set specific looks for properties if you add these fields to the CPT
$brand_hex   = get_field('banner_overlay_brand_color', $post_id) ?: '#000000';
$opacity_raw = get_field('banner_overlay_opacity', $post_id) ?: '40';
$opacity     = $opacity_raw / 100;

// 3. Status for the Badge
$status = get_field('property_status', $post_id) ?: 'available';

// 4. Style Variables
$style_vars = [
    '--banner-overlay-color'   => $brand_hex,
    '--banner-overlay-opacity' => $opacity,
    '--banner-blur'            => '0px',
];

$style_string = '';
foreach ($style_vars as $key => $val) {
    $style_string .= "{$key}: {$val}; ";
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <section class="fu-page-banner property-hero" style="<?php echo esc_attr($style_string); ?>">

        <div class="fu-page-banner__media">
            <div class="fu-page-banner__bg-image"
                style="background-image: url('<?php echo esc_url($bg_url); ?>'); background-position: center center;">
            </div>
            <div class="fu-page-banner__overlay"
                style="background-color: var(--banner-overlay-color); opacity: var(--banner-overlay-opacity); position: absolute; top:0; left:0; width:100%; height:100%; mix-blend-mode: var(--banner-blend-mode);">
            </div>
        </div>

        <div class="fu-page-banner__content container">
            <div class="property-hero-text">
                <span class="fu-status-badge"><?php echo esc_html(ucfirst(str_replace('-', ' ', $status))); ?></span>
                <h1 class="entry-title" style="color: #fff; margin: 10px 0;"><?php the_title(); ?></h1>
                <?php if ($address = get_field('address')): ?>
                    <p class="property-address" style="color: rgba(255,255,255,0.9);">
                        <span class="dashicons dashicons-location"></span> <?php echo esc_html($address); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <div class="entry-content container">
        <?php the_content(); ?>
    </div>
</article>