<?php

/**
 * Shared ACF admin UI adjustments.
 */

add_action('admin_enqueue_scripts', function () {
    wp_enqueue_style('dashicons');
});

add_action('acf/input/admin_head', function () {
?>
    <style>
        .acf-icon::before {
            font-family: dashicons !important;
            font-style: normal;
            font-weight: 400;
            line-height: 1;
            text-transform: none;
        }

        .acf-icon.-pencil::before {
            content: "\f464" !important;
        }

        .acf-icon.-cancel::before {
            content: "\f335" !important;
        }
    </style>
<?php
});
