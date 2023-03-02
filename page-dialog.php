<?php
//Template Name: Dialog
?>
<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <article>
            <div class="entry-content">
                <?php
                if (have_rows('page_content')) :
                    while (have_rows('page_content')) : the_row(); ?>
                        <div class="container home-wrap" id="hello">
                            <div class="grid-row">
                                <div class="col-md-8 col-md-8-center text-center">
                                    <div class="landing-pname">
                                        <h1>Hello, I'm Tim Fetter.</h1>
                                    </div>
                                    <div class="landing-intro"><?php the_sub_field('intro_blurb'); ?></div>
                                </div>
                            </div>
                            <div class="align-center">
                                <a class="btn--gold btn--resume" target="_blank" href="<?php the_sub_field('resume_link'); ?>">View My Resum&Eacute;</a>
                                <a href="https://docs.google.com/document/d/1016yIe2QJWI_O3mbFLBrGbGDlgMm812BrdqN6uaw8ew/edit?usp=sharing"></a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
                <!-- end page_content -->
            </div><!-- .entry-content -->
        </article>

        <div id="portfolio" class="content-wrap-in portfolio-wrap">
            <div class="container">
                <h2 class="text-center">Portfolio</h2>
            </div>
            <div class="container">

                <?php

                // Portfolio Items
                $posts = get_posts(array(
                    'post_type'         => 'portfolio-items',
                    'posts_per_page'    => -1
                ));

                if ($posts) :
                    $dialog_counter = 1; ?>

                    <?php foreach ($posts as $post) :

                        setup_postdata($post)

                    ?>
                        <div class="portfolio-item">
                            <div class="grid-row">
                                <div class="col-md-4 portfolio-image"><?php the_post_thumbnail(); ?></div>
                                <div class="col-md-8 portfolio-details">
                                    <div class="portfolio-detail-content">
                                        <h3><?php the_title(); ?></h3>
                                        <?php
                                        $portfolioContent = get_field('portfolio_content');
                                        if (have_rows('portfolio_content')) :
                                            $subTitle = $portfolioContent['website_sub_title'];
                                            $skills = $portfolioContent['skills'];
                                            $images = $portfolioContent['images'];
                                            while (have_rows('portfolio_content')) : the_row();
                                                if ($subTitle) : { ?>
                                                        <h4><?php echo $subTitle; ?></h4>
                                        <?php }
                                                endif;
                                            endwhile;
                                        endif;
                                        ?>
                                        <div class="info-text">
                                            <p>
                                                <?php if (has_excerpt()) {
                                                    echo get_the_excerpt();
                                                } else {
                                                    echo wp_trim_words(get_the_content(), 20);
                                                } ?>
                                            </p>
                                        </div>
                                        <button class="btn--gold btn--view-more" data-a11y-dialog-show="dialog_<?php echo $dialog_counter; ?>"><span>See More</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $dialog_counter++; ?>
                    <?php endforeach; ?>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </div><!-- portfolio-items -->
        </div><!-- #portfolio -->

        <?php
        // Portfolio Items
        $posts = get_posts(array(
            'post_type'         => 'portfolio-items',
            'posts_per_page'    => -1
        ));

        if ($posts) :
            $dialog_counter = 1; ?>

            <?php foreach ($posts as $post) :
                setup_postdata($post)
            ?>
                <!-- a11y-dialog -->
                <div class="dialog-container" data-a11y-dialog="dialog_<?php echo $dialog_counter; ?>" id="modal_<?php echo $dialog_counter; ?>" role="dialog" aria-hidden="true" aria-labelledby="dialog-title-<?php echo $dialog_counter; ?>" aria-describedby="dialog-description-<?php echo $dialog_counter; ?>">
                    <div class="dialog-overlay" data-a11y-dialog-hide></div>

                    <!-- dialog-content -->
                    <div class="dialog-content" role="document">
                        <div class="dialog-body">
                            <div class="container">
                                <?php
                                $portfolioContent = get_field('portfolio_content');
                                if (have_rows('portfolio_content')) :
                                    $subTitle = $portfolioContent['website_sub_title'];
                                    $skills = $portfolioContent['skills'];
                                    $links = $portfolioContent['website_links'];
                                    if ($links) {
                                        $linksCount = count($links);
                                    }
                                    $images = $portfolioContent['images'];
                                    while (have_rows('portfolio_content')) : the_row();
                                ?>
                                        <div class="dialog-info-wrap">
                                            <button type="button" data-a11y-dialog-hide aria-label="Close this dialog window" class="dialog-close black-close ui-btn ui-shadow ui-corner-all">
                                                <svg class="icon icon-close">
                                                    <use xlink:href="#icon-close"></use>
                                                </svg>
                                            </button>
                                            <div class="dialog-info-item">
                                                <h3 id="dialog-title-<?php echo $dialog_counter; ?>"><?php the_title(); ?></h3>

                                                <?php if ($subTitle) : ?>
                                                    <h4><?php echo $subTitle; ?></h4>
                                                <?php endif; ?>

                                                <div id="dialog-description-<?php echo $dialog_counter; ?>" class="info-text"><?php the_content(); ?></div>

                                                <?php if ($skills) : ?>
                                                    <h5 class="dialog-info-meta-title">Skills</h5>
                                                    <div class="tags">
                                                        <?php foreach ($skills as $skill) : ?>
                                                            <span class="label <?php echo $skill['value']; ?>"><?php echo $skill['label']; ?></span>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if (have_rows('website_links')) :
                                                    if ($linksCount > 1) {
                                                        $metaTitle = "Project Links";
                                                    } else {
                                                        $metaTitle = "Project Link";
                                                    } ?>
                                                    <h5 class="dialog-info-meta-title"><?php echo $metaTitle; ?></h5>
                                                    <div class="dialog-site-links">
                                                        <?php
                                                        while (have_rows('website_links')) : the_row();
                                                            $link = get_sub_field('link');
                                                            if ($link) :
                                                                $link_url = $link['url'];
                                                                $link_title = $link['title'];
                                                                $link_target = $link['target'] ? $link['target'] : '_blank';
                                                        ?>
                                                                <div><a class="btn--gold btn--link" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">Visit <?php echo esc_html($link_title); ?></a></div>
                                                            <?php endif; ?>
                                                        <?php endwhile; ?>
                                                    </div>
                                                <?php endif; ?>

                                            </div>
                                        </div>
                                        <div class="dialog-image-wrap">
                                            <?php
                                            if (have_rows('images')) :
                                                while (have_rows('images')) : the_row();
                                                    $image = get_sub_field('image');
                                                    if (!empty($image)) :
                                                        $url = $image['url'];
                                                        $alt = $image['alt'];
                                                        $size = 'small-image';
                                                        $small_image = $image['sizes'][$size];
                                                        $width = $image['sizes'][$size . '-width'];
                                                        $height = $image['sizes'][$size . '-height'];
                                            ?>
                                                        <img src="<?php echo $small_image; ?>" alt="<?php echo $alt; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
                                                    <?php endif; ?>
                                                <?php endwhile; ?>
                                            <?php endif; ?>
                                            <div class="embed-container">
                                                <?php the_sub_field('video'); ?>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </div>
                            <!-- container -->
                        </div>
                    </div>
                    <!-- /dialog-content -->
                </div>
                <!-- /modal -->
                <?php $dialog_counter++; ?>
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>
        <?php endif; ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>