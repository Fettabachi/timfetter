<?php
// Template Name: Layouts
?>
<?php

/**
 * Template for displaying the layout system reference page.
 *
 * @package Tim_Fetter_Portfolio
 */

$layout_examples_css_path = get_template_directory() . '/css/layout-examples.css';

wp_enqueue_style(
    'timfetter-layout-examples',
    get_template_directory_uri() . '/css/layout-examples.css',
    array(),
    file_exists($layout_examples_css_path) ? (string) filemtime($layout_examples_css_path) : null
);

get_header();
?>

<main id="primary" class="site-main">
    <?php
    while (have_posts()) :
        the_post();

        get_template_part('template-parts/content', 'page-layouts');
    endwhile;
    ?>
</main><!-- #main -->

<?php
get_footer();