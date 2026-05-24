<?php

/**
 * Portfolio Items archive template.
 *
 * @package Tim_Fetter_Portfolio
 */

get_header();

$get_portfolio_card_kicker = static function ($post_id) {
    $kicker_fields = array(
        'work_type',
        'portfolio_type',
        'card_kicker',
        'kicker',
        'website_sub_title',
    );

    foreach ($kicker_fields as $kicker_field_key) {
        $value = get_field($kicker_field_key, $post_id);

        if (is_string($value) && trim($value) !== '') {
            return trim($value);
        }
    }

    $portfolio_content = get_field('portfolio_content', $post_id);

    if (is_array($portfolio_content) && !empty($portfolio_content['website_sub_title']) && is_string($portfolio_content['website_sub_title'])) {
        return trim($portfolio_content['website_sub_title']);
    }

    $taxonomies = get_object_taxonomies(get_post_type($post_id));

    if (!empty($taxonomies)) {
        foreach ($taxonomies as $taxonomy) {
            $terms = get_the_terms($post_id, $taxonomy);
            if (is_array($terms) && !empty($terms[0]->name)) {
                return $terms[0]->name;
            }
        }
    }

    return '';
};

$get_portfolio_focus_labels = static function ($post_id) {
    $labels = array();

    $focus_fields = array(
        'focus_tags',
        'focus_areas',
        'skills',
    );

    foreach ($focus_fields as $focus_field_key) {
        $value = get_field($focus_field_key, $post_id);

        if (is_array($value)) {
            foreach ($value as $item) {
                if (is_array($item) && !empty($item['label'])) {
                    $labels[] = (string) $item['label'];
                } elseif (is_string($item) && trim($item) !== '') {
                    $labels[] = trim($item);
                }
            }
        } elseif (is_string($value) && trim($value) !== '') {
            $labels[] = trim($value);
        }
    }

    $portfolio_content = get_field('portfolio_content', $post_id);

    if (is_array($portfolio_content) && !empty($portfolio_content['skills']) && is_array($portfolio_content['skills'])) {
        foreach ($portfolio_content['skills'] as $skill_item) {
            if (is_array($skill_item) && !empty($skill_item['label'])) {
                $labels[] = (string) $skill_item['label'];
            } elseif (is_string($skill_item) && trim($skill_item) !== '') {
                $labels[] = trim($skill_item);
            }
        }
    }

    if (empty($labels)) {
        return array();
    }

    $labels = array_map('trim', $labels);
    $labels = array_filter($labels, static function ($item) {
        return $item !== '';
    });

    return array_values(array_unique($labels));
};
?>

<main id="primary" class="site-main">
    <section class="fu-content-section" aria-labelledby="portfolio-archive-heading">
        <div class="fu-content-section__inner container container--page">
            <div class="fu-section-head">
                <p class="fu-eyebrow">Selected Work</p>
                <h1 class="fu-section-heading" id="portfolio-archive-heading">Portfolio</h1>
                <p class="fu-section-lede">A curated look at WordPress, front-end, and prototype work focused on structured content, editor-friendly systems, responsive implementation, and maintainable handoff.</p>
            </div>

            <?php if (have_posts()) : ?>
                <div class="fu-work-grid fu-work-grid--archive" aria-label="Portfolio case studies">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php
                        $portfolio_card_link = get_permalink();
                        $portfolio_card_kicker = $get_portfolio_card_kicker(get_the_ID());
                        $portfolio_focus_labels = $get_portfolio_focus_labels(get_the_ID());
                        $portfolio_excerpt = has_excerpt() ? get_the_excerpt() : wp_trim_words(wp_strip_all_tags(get_the_content()), 26);
                        ?>

                        <a class="fu-work-card fu-work-card--linked" href="<?php echo esc_url($portfolio_card_link); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="fu-work-card__media">
                                    <?php the_post_thumbnail('medium_large', array('loading' => 'lazy', 'decoding' => 'async')); ?>
                                </div>
                            <?php endif; ?>

                            <div class="fu-work-card__body">
                                <?php if ($portfolio_card_kicker !== '') : ?>
                                    <p class="fu-work-card__kicker"><?php echo esc_html($portfolio_card_kicker); ?></p>
                                <?php endif; ?>

                                <h2 class="fu-work-card__title"><?php the_title(); ?></h2>

                                <?php if ($portfolio_excerpt !== '') : ?>
                                    <p class="fu-work-card__text"><?php echo esc_html($portfolio_excerpt); ?></p>
                                <?php endif; ?>

                                <?php if (!empty($portfolio_focus_labels)) : ?>
                                    <p class="fu-work-card__text"><strong>Focus:</strong> <?php echo esc_html(implode(', ', array_slice($portfolio_focus_labels, 0, 4))); ?></p>
                                <?php endif; ?>

                                <span class="fu-work-card__link">View case study</span>
                            </div>
                        </a>
                    <?php endwhile; ?>
                </div>

                <?php the_posts_navigation(); ?>
            <?php else : ?>
                <div class="fu-section-body fu-prose">
                    <p>No portfolio items are published yet. New case studies will appear here soon.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
get_footer();
