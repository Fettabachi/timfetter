<?php

/**
 * Template for single Portfolio Items posts.
 *
 * @package Tim_Fetter_Portfolio
 */

get_header();

$get_portfolio_subtitle = static function ($post_id) {
    $direct_subtitle_fields = array(
        'website_sub_title',
        'subtitle',
        'card_kicker',
        'kicker',
    );

    foreach ($direct_subtitle_fields as $field_key) {
        $value = get_field($field_key, $post_id);

        if (is_string($value) && trim($value) !== '') {
            return trim($value);
        }
    }

    $portfolio_content = get_field('portfolio_content', $post_id);

    if (is_array($portfolio_content) && !empty($portfolio_content['website_sub_title']) && is_string($portfolio_content['website_sub_title'])) {
        return trim($portfolio_content['website_sub_title']);
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

$get_portfolio_external_links = static function ($post_id) {
    $links = array();

    $append_link = static function (&$collection, $url, $title = '', $target = '') {
        if (!is_string($url) || trim($url) === '') {
            return;
        }

        $normalized_url = trim($url);

        if (!filter_var($normalized_url, FILTER_VALIDATE_URL)) {
            return;
        }

        $collection[] = array(
            'url' => $normalized_url,
            'title' => is_string($title) && trim($title) !== '' ? trim($title) : 'Visit project',
            'target' => is_string($target) && trim($target) !== '' ? trim($target) : '',
        );
    };

    $normalize_link_value = static function ($value) use (&$append_link, &$links) {
        if (is_string($value)) {
            $append_link($links, $value);
            return;
        }

        if (is_array($value)) {
            if (isset($value['url'])) {
                $append_link(
                    $links,
                    (string) $value['url'],
                    isset($value['title']) ? (string) $value['title'] : '',
                    isset($value['target']) ? (string) $value['target'] : ''
                );
                return;
            }

            if (isset($value['link']) && is_array($value['link']) && isset($value['link']['url'])) {
                $append_link(
                    $links,
                    (string) $value['link']['url'],
                    isset($value['link']['title']) ? (string) $value['link']['title'] : '',
                    isset($value['link']['target']) ? (string) $value['link']['target'] : ''
                );
            }
        }
    };

    $direct_link_fields = array(
        'website_url',
        'project_url',
        'external_url',
        'case_study_url',
        'related_url',
        'link',
    );

    foreach ($direct_link_fields as $field_key) {
        $normalize_link_value(get_field($field_key, $post_id));
    }

    $website_links = get_field('website_links', $post_id);

    if (is_array($website_links)) {
        foreach ($website_links as $website_link_item) {
            $normalize_link_value($website_link_item);
        }
    }

    $portfolio_content = get_field('portfolio_content', $post_id);

    if (is_array($portfolio_content)) {
        $portfolio_content_direct_link_fields = array(
            'website_url',
            'project_url',
            'external_url',
            'case_study_url',
            'related_url',
            'link',
        );

        foreach ($portfolio_content_direct_link_fields as $field_key) {
            if (!empty($portfolio_content[$field_key])) {
                $normalize_link_value($portfolio_content[$field_key]);
            }
        }

        if (!empty($portfolio_content['website_links']) && is_array($portfolio_content['website_links'])) {
            foreach ($portfolio_content['website_links'] as $portfolio_content_link_item) {
                $normalize_link_value($portfolio_content_link_item);
            }
        }
    }

    if (empty($links)) {
        return array();
    }

    $seen_urls = array();
    $unique_links = array();

    foreach ($links as $link) {
        if (isset($seen_urls[$link['url']])) {
            continue;
        }

        $seen_urls[$link['url']] = true;
        $unique_links[] = $link;
    }

    return $unique_links;
};

$get_portfolio_supporting_images = static function ($post_id) {
    $portfolio_content = get_field('portfolio_content', $post_id);

    if (!is_array($portfolio_content) || empty($portfolio_content['images']) || !is_array($portfolio_content['images'])) {
        return array();
    }

    $images = array();

    foreach ($portfolio_content['images'] as $image_row) {
        if (!is_array($image_row) || empty($image_row['image'])) {
            continue;
        }

        $raw_image = $image_row['image'];
        $acf_image_caption = '';
        $attachment_caption = '';
        $normalized_image = array(
            'id' => 0,
            'url' => '',
            'alt' => '',
            'caption' => '',
            'title' => '',
            'description' => '',
        );

        if (!empty($image_row['contribution_title']) && is_string($image_row['contribution_title'])) {
            $normalized_image['title'] = trim($image_row['contribution_title']);
        }

        if (!empty($image_row['contribution_description']) && is_string($image_row['contribution_description'])) {
            $normalized_image['description'] = trim($image_row['contribution_description']);
        }

        if (is_numeric($raw_image)) {
            $normalized_image['id'] = (int) $raw_image;
        } elseif (is_array($raw_image)) {
            if (!empty($raw_image['ID']) && is_numeric($raw_image['ID'])) {
                $normalized_image['id'] = (int) $raw_image['ID'];
            } elseif (!empty($raw_image['id']) && is_numeric($raw_image['id'])) {
                $normalized_image['id'] = (int) $raw_image['id'];
            }

            if (!empty($raw_image['url']) && is_string($raw_image['url'])) {
                $normalized_image['url'] = trim($raw_image['url']);
            }

            if (!empty($raw_image['alt']) && is_string($raw_image['alt'])) {
                $normalized_image['alt'] = trim($raw_image['alt']);
            }

            if (!empty($raw_image['caption']) && is_string($raw_image['caption'])) {
                $acf_image_caption = trim($raw_image['caption']);
            }
        } elseif (is_string($raw_image) && trim($raw_image) !== '') {
            $normalized_image['url'] = trim($raw_image);
        }

        if ($normalized_image['id'] > 0) {
            $attachment_url = wp_get_attachment_url($normalized_image['id']);
            if (is_string($attachment_url) && $attachment_url !== '') {
                $normalized_image['url'] = $attachment_url;
            }

            if ($normalized_image['alt'] === '') {
                $attachment_alt = get_post_meta($normalized_image['id'], '_wp_attachment_image_alt', true);
                if (is_string($attachment_alt) && trim($attachment_alt) !== '') {
                    $normalized_image['alt'] = trim($attachment_alt);
                }
            }

            $attachment_caption_value = wp_get_attachment_caption($normalized_image['id']);
            if (is_string($attachment_caption_value) && trim($attachment_caption_value) !== '') {
                $attachment_caption = trim($attachment_caption_value);
            }
        }

        if ($normalized_image['caption'] === '') {
            if ($attachment_caption !== '') {
                $normalized_image['caption'] = $attachment_caption;
            } elseif ($acf_image_caption !== '') {
                $normalized_image['caption'] = $acf_image_caption;
            } elseif ($normalized_image['alt'] !== '') {
                $normalized_image['caption'] = $normalized_image['alt'];
            }
        }

        if ($normalized_image['title'] === '') {
            if ($normalized_image['caption'] !== '') {
                $normalized_image['title'] = $normalized_image['caption'];
            } elseif ($normalized_image['alt'] !== '') {
                $normalized_image['title'] = $normalized_image['alt'];
            }
        }

        if ($normalized_image['id'] <= 0 && $normalized_image['url'] === '') {
            continue;
        }

        $images[] = $normalized_image;
    }

    return $images;
};

$portfolio_archive_url = get_post_type_archive_link('portfolio-items');

if (!$portfolio_archive_url) {
    $portfolio_archive_url = home_url('/work/');
}
?>

<main id="primary" class="site-main">
    <?php while (have_posts()) : the_post(); ?>
        <?php
        $portfolio_subtitle = $get_portfolio_subtitle(get_the_ID());
        $portfolio_focus_labels = $get_portfolio_focus_labels(get_the_ID());
        $portfolio_external_links = $get_portfolio_external_links(get_the_ID());
        $portfolio_supporting_images = $get_portfolio_supporting_images(get_the_ID());
        $portfolio_has_content = trim(wp_strip_all_tags(get_the_content())) !== '';
        ?>

        <section class="fu-content-section fu-portfolio-single" aria-labelledby="portfolio-single-heading">
            <div class="fu-content-section__inner container container--readable">
                <div class="fu-section-head">
                    <p class="fu-eyebrow">Portfolio</p>
                    <h1 class="fu-section-heading" id="portfolio-single-heading"><?php the_title(); ?></h1>
                    <?php if ($portfolio_subtitle !== '') : ?>
                        <p class="fu-section-lede"><?php echo esc_html($portfolio_subtitle); ?></p>
                    <?php endif; ?>
                    <?php if (get_post_field('post_name', get_queried_object_id()) === 'client-project-timeline') : ?>
                        <p class="fu-section-lede fu-section-lede--prototype">A self-contained HTML, CSS, and JavaScript prototype for testing project milestone states, responsive timeline layouts, and client-facing workflow language before production development.</p>
                    <?php elseif (get_post_field('post_name', get_queried_object_id()) === 'project-scope-estimator') : ?>
                        <p class="fu-section-lede fu-section-lede--prototype">A guided front-end prototype for turning early project requirements into a clearer scope summary before production planning or developer handoff.</p>
                    <?php endif; ?>
                </div>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="fu-portfolio-single__media-frame">
                        <figure class="fu-work-card__media fu-portfolio-single__media">
                            <?php the_post_thumbnail('large', array('loading' => 'eager', 'decoding' => 'async')); ?>
                        </figure>
                    </div>
                <?php endif; ?>

                <?php if ($portfolio_has_content) : ?>
                    <div class="fu-section-body fu-prose">
                        <h2 class="fu-section-heading fu-section-heading--compact">Overview</h2>
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>


                <?php // Conditionally render the demo outside the readable container. 
                ?>
            </div> <!-- End .fu-content-section__inner.container.container--readable -->

            <?php if (get_post_field('post_name', get_queried_object_id()) === 'client-project-timeline') : ?>
                <div class="fu-content-section__inner container container--l">
                    <?php get_template_part('parts/prototypes/client-project-timeline'); ?>
                </div>
                <div class="fu-content-section__inner container container--readable fu-portfolio-prototype-summary">
                    <div class="fu-portfolio-prototype-summary__item">
                        <h2 class="fu-section-heading fu-section-heading--compact">Prototype Purpose</h2>
                        <p>This prototype makes workflow states testable before production implementation, including milestone counts, in-between progress states, responsive layout behavior, and client-facing status details.</p>
                    </div>
                    <div class="fu-portfolio-prototype-summary__item">
                        <h2 class="fu-section-heading fu-section-heading--compact">What This Demonstrates</h2>
                        <p>The component supports milestone and continuous progress modes, configurable workflow lengths, automatic progress updates, horizontal and vertical layouts, and responsive behavior that switches to a vertical timeline when horizontal labels become too cramped.</p>
                    </div>
                    <div class="fu-portfolio-prototype-summary__item">
                        <h2 class="fu-section-heading fu-section-heading--compact">How This Could Work on Your Website</h2>
                        <p>This type of timeline could be managed manually through editable CMS fields, connected to structured project data, or updated from an internal system or API. For WordPress, it could become an ACF-powered block or template component. For larger applications, the same front-end pattern could consume project status data from an API.</p>
                    </div>
                </div>
            <?php elseif (get_post_field('post_name', get_queried_object_id()) === 'project-scope-estimator') : ?>
                <div class="fu-content-section__inner container container--l">
                    <?php get_template_part('parts/prototypes/project-scope-estimator'); ?>
                </div>
                <div class="fu-content-section__inner container container--readable fu-portfolio-prototype-summary">
                    <div class="fu-portfolio-prototype-summary__item">
                        <h2 class="fu-section-heading fu-section-heading--compact">Prototype Purpose</h2>
                        <p>This prototype turns early project details into a testable scope summary, helping teams identify complexity, readiness gaps, and next steps before production begins.</p>
                    </div>
                    <div class="fu-portfolio-prototype-summary__item">
                        <h2 class="fu-section-heading fu-section-heading--compact">What This Demonstrates</h2>
                        <p>The interface combines conditional form logic, feature selection, readiness states, dynamic scoring, and responsive summary output in a lightweight front-end prototype.</p>
                    </div>
                    <div class="fu-portfolio-prototype-summary__item">
                        <h2 class="fu-section-heading fu-section-heading--compact">How This Could Work on Your Website</h2>
                        <p>In production, this pattern could be connected to a CMS, lead form, project intake workflow, or internal planning tool. The generated summary could be copied, printed, emailed, or submitted into an intake system, giving teams a clearer handoff record before deeper implementation.</p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="fu-content-section__inner container container--readable">

                <?php if (!empty($portfolio_supporting_images)) : ?>
                    <div class="fu-section-body fu-portfolio-single__contributions">
                        <h2 class="fu-section-heading fu-section-heading--compact">Selected Contributions</h2>
                        <p class="fu-section-lede">A closer look at specific interface pieces, reusable sections, and content modules I supported.</p>

                        <div class="fu-portfolio-single__contribution-list" aria-label="Selected contribution images">
                            <?php foreach ($portfolio_supporting_images as $supporting_image) : ?>
                                <article class="fu-portfolio-single__contribution">
                                    <div class="fu-portfolio-single__contribution-content">
                                        <?php if ($supporting_image['title'] !== '') : ?>
                                            <h3 class="fu-portfolio-single__contribution-title"><?php echo esc_html($supporting_image['title']); ?></h3>
                                        <?php endif; ?>

                                        <?php if ($supporting_image['description'] !== '') : ?>
                                            <p class="fu-portfolio-single__contribution-description"><?php echo esc_html($supporting_image['description']); ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <figure class="fu-portfolio-single__contribution-media">
                                        <?php if ($supporting_image['id'] > 0) : ?>
                                            <?php echo wp_get_attachment_image($supporting_image['id'], 'large', false, array('loading' => 'lazy', 'decoding' => 'async')); ?>
                                        <?php else : ?>
                                            <img
                                                src="<?php echo esc_url($supporting_image['url']); ?>"
                                                alt="<?php echo esc_attr($supporting_image['alt']); ?>"
                                                loading="lazy"
                                                decoding="async">
                                        <?php endif; ?>
                                    </figure>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($portfolio_focus_labels)) : ?>
                    <div class="fu-section-body">
                        <p class="fu-work-card__text"><strong>Focus:</strong> <?php echo esc_html(implode(', ', $portfolio_focus_labels)); ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($portfolio_external_links)) : ?>
                    <div class="fu-section-body">
                        <p class="fu-eyebrow">Project Links</p>
                        <div class="fu-portfolio-piece__actions">
                            <?php foreach ($portfolio_external_links as $external_link) : ?>
                                <?php
                                $external_link_target = $external_link['target'];
                                $external_link_rel = $external_link_target === '_blank' ? 'noopener noreferrer' : '';
                                ?>
                                <a
                                    class="fu-portfolio-piece__button fu-portfolio-piece__button--secondary"
                                    href="<?php echo esc_url($external_link['url']); ?>"
                                    <?php echo $external_link_target !== '' ? ' target="' . esc_attr($external_link_target) . '"' : ''; ?>
                                    <?php echo $external_link_rel !== '' ? ' rel="' . esc_attr($external_link_rel) . '"' : ''; ?>><?php echo esc_html($external_link['title']); ?><span class="screen-reader-text"> opens external site</span></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="fu-section-body fu-portfolio-single__back">
                    <p><a class="fu-work-card__link fu-portfolio-single__back-link" href="<?php echo esc_url($portfolio_archive_url); ?>">Back to Work</a></p>
                </div>
            </div>
        </section>
    <?php endwhile; ?>
</main>

<?php
get_footer();
