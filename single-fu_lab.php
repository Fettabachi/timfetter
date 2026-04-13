<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Tim_Fetter_Portfolio
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('fu-lab-single'); ?>>

            <header class="entry-header">
                <nav class="lab-navigation">
                    <a href="<?php echo get_post_type_archive_link('fu_lab'); ?>">&larr; Back to Component Lab</a>
                </nav>

                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>

                <div class="lab-meta">
                    <?php echo get_the_term_list(get_the_ID(), 'lab_category', '<span class="lab-badge">', '</span><span class="lab-badge">', '</span>'); ?>
                </div>
            </header>

            <div class="entry-content">
                <?php
                // This will render whatever blocks or content 
                // you've added to the specific Lab component
                the_content();
                ?>
            </div>

            <footer class="entry-footer">
                <?php
                the_post_navigation(array(
                    'prev_text' => '<span class="nav-subtitle">Previous Component:</span> <span class="nav-title">%title</span>',
                    'next_text' => '<span class="nav-subtitle">Next Component:</span> <span class="nav-title">%title</span>',
                ));
                ?>
            </footer>

        </article>

    <?php endwhile; ?>

</main><!-- #main -->

<?php
get_footer();
