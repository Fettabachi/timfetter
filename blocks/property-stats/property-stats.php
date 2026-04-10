<?php

/**
 * Property Stats Block Template.
 */

$post_id = get_the_ID();

// Pulling data from your ACF Fields (Assumes field names: price, beds, baths, sqft)
$price = get_field('price', $post_id) ?: '0';
$beds  = get_field('beds', $post_id) ?: '0';
$baths = get_field('baths', $post_id) ?: '0';
$sqft  = get_field('sqft', $post_id) ?: '0';

// Format the price with commas
$formatted_price = is_numeric($price) ? '$' . number_format($price) : $price;

$classes = ['fu-property-stats'];
if (!empty($block['className'])) $classes[] = $block['className'];
if (!empty($block['align'])) $classes[] = 'align' . $block['align'];
?>

<div id="<?php echo esc_attr($block['id']); ?>" class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <div class="fu-property-stats__inner container">

        <div class="fu-prop-item fu-prop-item--price">
            <span class="fu-prop-label">Price</span>
            <span class="fu-prop-value"><?php echo esc_html($formatted_price); ?></span>
        </div>

        <div class="fu-prop-item">
            <span class="fu-prop-value"><?php echo esc_html($beds); ?></span>
            <span class="fu-prop-label">Beds</span>
        </div>

        <div class="fu-prop-item">
            <span class="fu-prop-value"><?php echo esc_html($baths); ?></span>
            <span class="fu-prop-label">Baths</span>
        </div>

        <div class="fu-prop-item">
            <span class="fu-prop-value"><?php echo esc_html(number_format($sqft)); ?></span>
            <span class="fu-prop-label">Sq Ft</span>
        </div>

    </div>
</div>