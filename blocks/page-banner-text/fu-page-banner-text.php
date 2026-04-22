<?php

/**
 * FU Page Banner Text Child Block
 */

$body_text = get_field('body_text');

if (empty($body_text) && is_admin()) {
    $body_text = 'Enter body text...';
}

if (!empty($body_text) || is_admin()) : ?>

    <div class="fu-page-banner__body">
        <?php echo wpautop(wp_kses_post($body_text)); ?>
    </div>

<?php endif; ?>