<?php

/**
 * Template for single Resource posts
 *
 * @package Tim_Fetter_Portfolio
 */

get_header();

$terms = get_the_terms(get_the_ID(), 'resource_category');
$primary_term = ($terms && ! is_wp_error($terms)) ? $terms[0] : null;

$related_args = [
    'post_type'      => 'resource',
    'posts_per_page' => 3,
    'post__not_in'   => [get_the_ID()],
];

if ($primary_term) {
    $related_args['tax_query'] = [
        [
            'taxonomy' => 'resource_category',
            'field'    => 'term_id',
            'terms'    => $primary_term->term_id,
        ],
    ];
}

$related_resources = new WP_Query($related_args);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('fu-resource-single'); ?>>
    <div class="container">
        <div class="fu-resource-single__inner">

            <nav class="fu-resource-single__back" aria-label="Back navigation">
                <a href="<?php echo esc_url(home_url('/filtered-content-grid/')); ?>">← Back to Resource Library</a>
            </nav>

            <header class="fu-resource-single__hero">
                <?php if ($terms && ! is_wp_error($terms)) : ?>
                    <div class="fu-resource-single__terms">
                        <?php foreach ($terms as $term) : ?>
                            <span class="fu-resource-single__term"><?php echo esc_html($term->name); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <h1 class="fu-resource-single__title"><?php the_title(); ?></h1>

                <?php if (has_excerpt()) : ?>
                    <div class="fu-resource-single__excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                <?php endif; ?>

                <?php if (has_post_thumbnail()) : ?>
                    <figure class="fu-resource-single__media">
                        <?php the_post_thumbnail('large'); ?>
                    </figure>
                <?php endif; ?>
            </header>

            <div class="fu-resource-single__content-wrap">
                <div class="fu-resource-single__content">
                    <?php
                    the_content();

                    wp_link_pages(
                        [
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'tim-fetter-portfolio'),
                            'after'  => '</div>',
                        ]
                    );
                    ?>
                </div>
            </div>

            <?php if ($related_resources->have_posts()) : ?>
                <section class="fu-resource-single__related">
                    <div class="fu-resource-single__related-head">
                        <p class="fu-eyebrow">Related Resources</p>
                        <h2>You might also find these useful</h2>
                    </div>

                    <div class="fu-resource-single__related-grid">
                        <?php while ($related_resources->have_posts()) : $related_resources->the_post(); ?>
                            <article class="fu-resource-single__related-card">
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <?php if (has_excerpt()) : ?>
                                    <div class="fu-resource-single__related-excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                <?php endif; ?>
                            </article>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    </div>
                </section>
            <?php endif; ?>

        </div>
    </div>
</article>

<?php
get_footer();
