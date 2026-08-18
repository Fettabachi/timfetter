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

$get_portfolio_primary_link = static function ($post_id) {
    $portfolio_content = get_field('portfolio_content', $post_id);

    if (!is_array($portfolio_content) || empty($portfolio_content['website_links']) || !is_array($portfolio_content['website_links'])) {
        return array();
    }

    foreach ($portfolio_content['website_links'] as $link_row) {
        if (!is_array($link_row) || empty($link_row['link']) || !is_array($link_row['link'])) {
            continue;
        }

        $link = $link_row['link'];
        $url = isset($link['url']) && is_string($link['url']) ? trim($link['url']) : '';

        if ($url === '') {
            continue;
        }

        return array(
            'url'    => $url,
            'target' => isset($link['target']) && is_string($link['target']) ? trim($link['target']) : '',
        );
    }

    return array();
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
        $portfolio_project_type = fu_get_portfolio_project_type_label(get_the_ID());
        $portfolio_supporting_images = $get_portfolio_supporting_images(get_the_ID());
        $portfolio_primary_link = $get_portfolio_primary_link(get_the_ID());
        $portfolio_has_content = trim(wp_strip_all_tags(get_the_content())) !== '';
        $portfolio_slug = get_post_field('post_name', get_the_ID());
        $is_mission_control = $portfolio_slug === 'mission-control';
        $frontend_ui_example_slugs = array(
            'client-project-timeline',
            'project-scope-estimator',
            'content-approval-checklist',
            'mission-control',
        );
        $portfolio_eyebrow = in_array($portfolio_slug, $frontend_ui_example_slugs, true) ? 'Front-End UI Example' : 'Selected Client Work';
        ?>

        <section class="fu-content-section fu-portfolio-single" aria-labelledby="portfolio-single-heading">
            <div class="fu-content-section__inner container container--readable">
                <div class="fu-section-head">
                    <p class="fu-eyebrow"><?php echo esc_html($portfolio_eyebrow); ?></p>
                    <h1 class="fu-section-heading" id="portfolio-single-heading"><?php the_title(); ?></h1>
                    <?php if ($portfolio_subtitle !== '') : ?>
                        <p class="fu-section-lede"><?php echo esc_html($portfolio_subtitle); ?></p>
                    <?php endif; ?>
                    <?php if ($is_mission_control && !empty($portfolio_primary_link['url'])) : ?>
                        <div class="fu-portfolio__actions">
                            <a
                                class="fu-portfolio__button fu-portfolio__button--primary"
                                href="<?php echo esc_url($portfolio_primary_link['url']); ?>"
                                <?php if (!empty($portfolio_primary_link['target'])) : ?>target="<?php echo esc_attr($portfolio_primary_link['target']); ?>"<?php endif; ?>
                                <?php if (!empty($portfolio_primary_link['target']) && $portfolio_primary_link['target'] === '_blank') : ?>rel="noopener noreferrer"<?php endif; ?>>View Live Prototype</a>
                        </div>
                    <?php endif; ?>
                    <?php if ($portfolio_project_type !== '' && !$is_mission_control) : ?>
                        <p class="fu-work-card__meta"><?php echo esc_html($portfolio_project_type); ?></p>
                    <?php endif; ?>
                    <?php if ($portfolio_slug === 'client-project-timeline') : ?>
                        <p class="fu-section-lede fu-section-lede--prototype">A self-contained front-end UI example for testing milestone states, responsive timeline behavior, and client-facing workflow language before production development begins.</p>
                    <?php elseif ($portfolio_slug === 'project-scope-estimator') : ?>
                        <p class="fu-section-lede fu-section-lede--prototype">A focused front-end UI example for testing scope logic, readiness states, and handoff language before a production estimate or planning workflow is finalized.</p>
                    <?php elseif ($portfolio_slug === 'content-approval-checklist') : ?>
                        <p class="fu-section-lede fu-section-lede--prototype">A focused front-end UI example for testing review states, approval gaps, blockers, and launch-readiness behavior before final production handoff.</p>
                    <?php endif; ?>
                </div>

                <?php if (has_post_thumbnail() && !$is_mission_control) : ?>
                    <div class="fu-portfolio-single__media-frame">
                        <figure class="fu-work-card__media fu-portfolio-single__media">
                            <?php
                            $thumbnail_id  = get_post_thumbnail_id();
                            $alt           = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
                            $fallback_alt  = $alt ? $alt : get_the_title();

                            the_post_thumbnail('large', array(
                                'loading'  => 'eager',
                                'decoding' => 'async',
                                'alt'      => esc_attr($fallback_alt),
                            ));
                            ?>
                        </figure>
                    </div>
                <?php endif; ?>

                <?php if ($is_mission_control) : ?>
                    <?php
                    get_template_part(
                        'parts/prototypes/mission-control',
                        null,
                        array(
                            'live_link' => $portfolio_primary_link,
                        )
                    );
                    ?>
                <?php elseif ($portfolio_has_content) : ?>
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
                        <h2 class="fu-section-heading fu-section-heading--compact">UI Example Purpose</h2>
                        <p>This prototype makes workflow states testable before production implementation, including milestone counts, in-between progress states, responsive layout behavior, and client-facing status details.</p>
                    </div>
                    <div class="fu-portfolio-prototype-summary__item">
                        <h2 class="fu-section-heading fu-section-heading--compact">What This Demonstrates</h2>
                        <p>The component supports milestone and continuous progress modes, configurable workflow lengths, automatic progress updates, horizontal and vertical layouts, and responsive behavior that switches to a vertical timeline when horizontal labels become too cramped.</p>
                    </div>
                    <div class="fu-portfolio-prototype-summary__item">
                        <h2 class="fu-section-heading fu-section-heading--compact">How This Helps Before Production</h2>
                        <p>A prototype like this can help teams test project-status language, milestone behavior, responsive layout limits, and stakeholder expectations before those ideas are rebuilt in a production system.</p>
                    </div>
                </div>
            <?php elseif (get_post_field('post_name', get_queried_object_id()) === 'project-scope-estimator') : ?>
                <div class="fu-content-section__inner container container--l">
                    <?php get_template_part('parts/prototypes/project-scope-estimator'); ?>
                </div>
                <div class="fu-content-section__inner container container--readable fu-portfolio-prototype-summary">
                    <div class="fu-portfolio-prototype-summary__item">
                        <h2 class="fu-section-heading fu-section-heading--compact">UI Example Purpose</h2>
                        <p>This prototype turns early project details into a testable scope summary, helping teams identify complexity, readiness gaps, and next steps before production begins.</p>
                    </div>
                    <div class="fu-portfolio-prototype-summary__item">
                        <h2 class="fu-section-heading fu-section-heading--compact">What This Demonstrates</h2>
                        <p>The interface combines conditional form logic, feature selection, readiness states, dynamic scoring, and responsive summary output in a lightweight front-end prototype.</p>
                    </div>
                    <div class="fu-portfolio-prototype-summary__item">
                        <h2 class="fu-section-heading fu-section-heading--compact">How This Helps Before Production</h2>
                        <p>A prototype like this can help teams test intake questions, scoring logic, summary language, and handoff expectations before connecting the workflow to a CMS, form system, CRM, or internal planning tool.</p>
                    </div>
                </div>
            <?php elseif (get_post_field('post_name', get_queried_object_id()) === 'content-approval-checklist') : ?>
                <div class="fu-content-section__inner container container--l">
                    <?php get_template_part('parts/prototypes/content-approval-checklist'); ?>
                </div>
                <div class="fu-content-section__inner container container--readable fu-portfolio-prototype-summary">
                    <div class="fu-portfolio-prototype-summary__item">
                        <h2 class="fu-section-heading fu-section-heading--compact">UI Example Purpose</h2>
                        <p>This prototype makes review status, approval gaps, and launch blockers visible before a site or campaign moves into final production handoff.</p>
                    </div>
                    <div class="fu-portfolio-prototype-summary__item">
                        <h2 class="fu-section-heading fu-section-heading--compact">What This Demonstrates</h2>
                        <p>The interface combines grouped checklist items, status filtering, progress calculation, blocker counts, and conditional launch-readiness messaging in a responsive front-end prototype.</p>
                    </div>
                    <div class="fu-portfolio-prototype-summary__item">
                        <h2 class="fu-section-heading fu-section-heading--compact">How This Helps Before Production</h2>
                        <p>A prototype like this can help teams test approval language, review states, blocker visibility, and launch-readiness expectations before those ideas are committed to a CMS, project management system, or internal workflow.</p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="fu-content-section__inner container container--readable">

                <?php if (!empty($portfolio_supporting_images)) : ?>
                    <div class="fu-section-body fu-portfolio-single__contributions">
                        <h2 class="fu-section-heading fu-section-heading--compact">Selected Contributions</h2>
                        <p class="fu-section-lede">A closer look at reusable interface components and content patterns built for the project.</p>

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

            </div>

            <?php
            get_template_part(
                'parts/contract-work-navigation',
                null,
                array(
                    'current' => get_post_field('post_name', get_the_ID()),
                )
            );
            ?>

            <?php
            get_template_part(
                'parts/prototype-navigation',
                null,
                array(
                    'current' => get_post_field('post_name', get_the_ID()),
                )
            );
            ?>

            <div class="fu-content-section__inner container container--page">
                <div class="fu-section-body fu-portfolio-single__back">
                    <p><a class="fu-work-card__link fu-portfolio-single__back-link" href="<?php echo esc_url($portfolio_archive_url); ?>">Back to Work</a></p>
                </div>
            </div>
        </section>
    <?php endwhile; ?>
</main>

<?php
get_footer();
