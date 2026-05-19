<?php

/**
 * Template Name: Proof Cards Portfolio
 *
 * @package Tim_Fetter_Portfolio
 */

add_action('wp_enqueue_scripts', function () {
    $proof_cards_block_css = get_theme_file_path('/blocks/proof-cards/proof-cards.css');
    $proof_card_block_css  = get_theme_file_path('/blocks/proof-card/proof-card.css');

    wp_enqueue_style(
        'timfetter-proof-cards-block',
        get_theme_file_uri('/blocks/proof-cards/proof-cards.css'),
        array('our-main-styles'),
        file_exists($proof_cards_block_css) ? (string) filemtime($proof_cards_block_css) : null
    );

    wp_enqueue_style(
        'timfetter-proof-card-block',
        get_theme_file_uri('/blocks/proof-card/proof-card.css'),
        array('timfetter-proof-cards-block'),
        file_exists($proof_card_block_css) ? (string) filemtime($proof_card_block_css) : null
    );

    wp_add_inline_style(
        'our-main-styles',
        '
    .fu-proof-cards-portfolio .fu-portfolio-piece__lead-body {
        max-width: 44rem;
    }

    .fu-proof-cards-portfolio .fu-portfolio-piece__lead-figure {
        width: 100%;
    }

    .fu-proof-cards-portfolio .fu-portfolio-piece__lead-caption {
        max-width: 36rem;
    }

    .fu-proof-cards-portfolio .fu-proof-cards-bridge {
        margin-top: clamp(2.5rem, 4vw, 4rem);
        margin-bottom: clamp(2.5rem, 4vw, 4rem);
    }

    .fu-proof-cards-portfolio .fu-proof-cards-bridge .fu-case-section__inner {
        max-width: 48rem;
        margin-inline: auto;
    }

    .fu-proof-cards-portfolio .fu-proof-cards-bridge .fu-case-section__body {
        max-width: 42rem;
    }

    .fu-proof-cards-portfolio .fu-proof-page__spaced-grid {
        margin-top: clamp(1.75rem, 3vw, 2.5rem);
    }

    @media (max-width: 1024px) {
        .fu-proof-cards-portfolio .fu-portfolio-piece__lead-inner {
            grid-template-columns: 1fr;
        }

        .fu-proof-cards-portfolio .fu-portfolio-piece__lead-copy,
        .fu-proof-cards-portfolio .fu-portfolio-piece__lead-body,
        .fu-proof-cards-portfolio .fu-portfolio-piece__lead-caption {
            max-width: none;
        }
    }

    '
    );
}, 20);

if (! function_exists('fu_proof_cards_demo_media_markup')) {
    function fu_proof_cards_demo_media_markup($media, $source_name = '')
    {
        if (! is_array($media)) {
            return '';
        }

        $type = isset($media['type']) ? (string) $media['type'] : 'none';
        if ($type === 'none') {
            return '';
        }

        $src = trim((string) ($media['src'] ?? ''));
        $initials = trim((string) ($media['initials'] ?? ''));
        $alt = trim((string) ($media['alt'] ?? ''));
        $label = trim((string) ($media['label'] ?? $source_name));

        if ($type === 'initials' || ($src === '' && $initials !== '')) {
            if ($initials === '') {
                return '';
            }

            $initials = strtoupper($initials);
            $background = (string) ($media['background'] ?? '#103f67');
            $foreground = (string) ($media['foreground'] ?? '#ffffff');
            $shape = (string) ($media['shape'] ?? 'circle');
            $radius = $shape === 'soft' ? '18' : '24';
            $height = $shape === 'soft' ? 72 : 96;
            $view_box = $shape === 'soft' ? '0 0 72 72' : '0 0 96 96';
            $font_size = $shape === 'soft' ? 22 : 28;
            $text_y = $shape === 'soft' ? 43 : 58;
            $text_x = $shape === 'soft' ? 36 : 48;

            return sprintf(
                '<div class="fu-proof-card__image-wrap"><svg class="fu-proof-card__image fu-proof-card__mark" viewBox="%1$s" role="img" aria-label="%2$s" focusable="false" xmlns="http://www.w3.org/2000/svg"><rect width="100%%" height="100%%" rx="%3$s" fill="%4$s"/><text x="%5$s" y="%6$s" text-anchor="middle" font-family="Raleway, Arial, sans-serif" font-size="%7$d" font-weight="700" fill="%8$s">%9$s</text></svg></div>',
                esc_attr($view_box),
                esc_attr($label !== '' ? $label : $initials),
                esc_attr($radius),
                esc_attr($background),
                esc_attr($text_x),
                esc_attr($text_y),
                (int) $font_size,
                esc_attr($foreground),
                esc_html($initials)
            );
        }

        if ($src === '') {
            return '';
        }

        $decorative_alt = $source_name !== '' ? '' : $alt;

        return sprintf(
            '<div class="fu-proof-card__image-wrap"><img class="fu-proof-card__image" src="%1$s" alt="%2$s" loading="lazy" decoding="async"></div>',
            esc_url($src),
            esc_attr($decorative_alt)
        );
    }
}

if (! function_exists('fu_proof_cards_demo_card_markup')) {
    function fu_proof_cards_demo_card_markup(array $card)
    {
        $classes = array('fu-proof-card');
        if (! empty($card['featured'])) {
            $classes[] = 'fu-proof-card--featured';
        }
        if (! empty($card['is_quote'])) {
            $classes[] = 'fu-proof-card--is-quote';
        }

        $label = trim((string) ($card['label'] ?? ''));
        $metric_value = trim((string) ($card['metric_value'] ?? ''));
        $metric_label = trim((string) ($card['metric_label'] ?? ''));
        $statement = trim((string) ($card['statement'] ?? ''));
        $source_name = trim((string) ($card['source_name'] ?? ''));
        $source_detail = trim((string) ($card['source_detail'] ?? ''));
        $link = is_array($card['link'] ?? null) ? $card['link'] : array();
        $link_url = trim((string) ($link['url'] ?? ''));
        $link_text = trim((string) ($link['title'] ?? ''));
        $link_target = ! empty($link['target']) ? (string) $link['target'] : '_self';
        $media_markup = fu_proof_cards_demo_media_markup($card['media'] ?? array(), $source_name);

        if ($link_url !== '' && $link_text === '') {
            $link_text = 'Read more';
        }

        ob_start();
?>
        <article class="<?php echo esc_attr(implode(' ', $classes)); ?>" role="listitem">
            <?php if ($label !== '') : ?>
                <p class="fu-proof-card__label"><?php echo esc_html($label); ?></p>
            <?php endif; ?>

            <?php if ($metric_value !== '' && $metric_label !== '') : ?>
                <div class="fu-proof-card__metric">
                    <p class="fu-proof-card__metric-value"><?php echo esc_html($metric_value); ?></p>
                    <p class="fu-proof-card__metric-label"><?php echo esc_html($metric_label); ?></p>
                </div>
            <?php endif; ?>

            <?php if ($statement !== '') : ?>
                <blockquote class="fu-proof-card__statement">
                    <div class="fu-proof-card__statement-inner">
                        <p><?php echo esc_html($statement); ?></p>
                    </div>
                </blockquote>
            <?php endif; ?>

            <?php if ($source_name !== '' || $source_detail !== '' || $media_markup !== '') : ?>
                <footer class="fu-proof-card__source">
                    <?php echo $media_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                    ?>
                    <?php if ($source_name !== '' || $source_detail !== '') : ?>
                        <div class="fu-proof-card__source-text">
                            <?php if ($source_name !== '') : ?>
                                <p class="fu-proof-card__source-name"><?php echo esc_html($source_name); ?></p>
                            <?php endif; ?>
                            <?php if ($source_detail !== '') : ?>
                                <p class="fu-proof-card__source-detail"><?php echo esc_html($source_detail); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </footer>
            <?php endif; ?>

            <?php if ($link_url !== '') : ?>
                <a class="fu-proof-card__link" href="<?php echo esc_url($link_url); ?>" <?php echo $link_target === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html($link_text); ?></a>
            <?php endif; ?>
        </article>
    <?php
        return trim(ob_get_clean());
    }
}

if (! function_exists('fu_proof_cards_demo_section_markup')) {
    function fu_proof_cards_demo_section_markup(array $demo)
    {
        $layout = (string) ($demo['layout'] ?? 'grid');
        $style = (string) ($demo['card_style'] ?? 'default');
        $bg = (string) ($demo['bg_style'] ?? 'none');
        $eyebrow = trim((string) ($demo['eyebrow'] ?? ''));
        $heading = trim((string) ($demo['heading'] ?? ''));
        $intro = trim((string) ($demo['intro'] ?? ''));
        $cards = is_array($demo['cards'] ?? null) ? $demo['cards'] : array();
        $section_id = trim((string) ($demo['id'] ?? ''));
        $classes = array(
            'fu-proof-cards',
            'fu-proof-cards--layout-' . $layout,
            'fu-proof-cards--style-' . $style,
            'fu-proof-cards--bg-' . $bg,
        );

        if (! empty($demo['class'])) {
            $classes[] = (string) $demo['class'];
        }

        ob_start();
    ?>
        <section<?php echo $section_id !== '' ? ' id="' . esc_attr($section_id) . '"' : ''; ?> class="<?php echo esc_attr(implode(' ', array_filter($classes))); ?>">
            <div class="fu-proof-cards__container">
                <?php if ($eyebrow !== '' || $heading !== '' || $intro !== '') : ?>
                    <header class="fu-proof-cards__header">
                        <?php if ($eyebrow !== '') : ?>
                            <p class="fu-proof-cards__eyebrow"><?php echo esc_html($eyebrow); ?></p>
                        <?php endif; ?>
                        <?php if ($heading !== '') : ?>
                            <h2 class="fu-proof-cards__heading"><?php echo esc_html($heading); ?></h2>
                        <?php endif; ?>
                        <?php if ($intro !== '') : ?>
                            <p class="fu-proof-cards__intro"><?php echo esc_html($intro); ?></p>
                        <?php endif; ?>
                    </header>
                <?php endif; ?>

                <div class="fu-proof-cards__grid" role="list">
                    <?php foreach ($cards as $card) : ?>
                        <?php echo fu_proof_cards_demo_card_markup((array) $card); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                        ?>
                    <?php endforeach; ?>
                </div>
            </div>
            </section>
    <?php
        return trim(ob_get_clean());
    }
}

$proof_cards_hero_media_uri = '/wp-content/uploads/2026/05/page-proof-cards-hero.webp';

$proof_cards_demos = array(
    'main_showcase' => array(
        'eyebrow' => 'Client Proof & Project Outcomes',
        'heading' => 'Proof that connects feedback to outcomes',
        'intro' => 'Most testimonial sections stop at kind words. Proof Cards gives editors a structured way to combine quotes, metrics, project context, logos, and source details so credibility is easier to scan and trust.',
        'layout' => 'grid',
        'card_style' => 'bordered',
        'bg_style' => 'dark',
        'cards' => array(
            array(
                'label' => 'Client Result',
                'metric_value' => '42%',
                'metric_label' => 'increase in qualified inquiries',
                'statement' => 'Restructuring the service page around visitor intent helped users understand the offer faster and take the next step with less friction.',
                'source_name' => 'BrightPath Dental',
                'source_detail' => 'Service landing page redesign',
                'media' => array(
                    'type' => 'logo',
                    'src' => get_theme_file_uri('/assets/images/portfolio/proof-cards/brightpath-dental.svg'),
                    'alt' => '',
                ),
            ),
            array(
                'label' => 'Agency Feedback',
                'is_quote' => true,
                'statement' => 'The block gave our client enough flexibility to manage the section themselves without breaking the design.',
                'source_name' => 'Northstar Studio',
                'source_detail' => 'WordPress implementation partner',
                'media' => array(
                    'type' => 'logo',
                    'src' => get_theme_file_uri('/assets/images/portfolio/proof-cards/northstar-studio.svg'),
                    'alt' => '',
                ),
            ),
            array(
                'label' => 'Editor Experience',
                'metric_value' => '5 min',
                'metric_label' => 'average time to add a new proof card',
                'statement' => 'Editors can add a new result, quote, logo, and source link without touching layout settings or asking a developer for help.',
                'source_name' => 'Internal publishing team',
                'source_detail' => 'Structured content workflow',
                'media' => array(
                    'type' => 'initials',
                    'initials' => 'IP',
                    'label' => 'Internal publishing team',
                    'background' => '#0d3b66',
                    'foreground' => '#ffffff',
                    'shape' => 'circle',
                ),
                'link' => array(
                    'url' => '#editor-experience',
                    'title' => 'Read the editor workflow note',
                ),
            ),
            array(
                'label' => 'Case Study Highlight',
                'statement' => 'A reusable proof system made it easier to surface relevant outcomes across service pages, campaign pages, and the home page.',
                'source_name' => 'Fieldstone Services',
                'source_detail' => 'Multi-page WordPress rollout',
                'media' => array(
                    'type' => 'logo',
                    'src' => get_theme_file_uri('/assets/images/portfolio/proof-cards/fieldstone-services.svg'),
                    'alt' => '',
                ),
            ),
            array(
                'label' => 'Trust Signal',
                'metric_value' => '3x',
                'metric_label' => 'more proof points reused across service pages',
                'statement' => 'The same structured card model can support testimonials, review excerpts, project outcomes, and lightweight case-study teasers.',
                'source_name' => 'Content Strategy Review',
                'source_detail' => 'Reusable proof framework',
                'media' => array(
                    'type' => 'none',
                ),
            ),
            array(
                'label' => 'Operational Result',
                'metric_value' => '1 block',
                'metric_label' => 'reused across multiple proof sections',
                'statement' => 'Instead of designing one-off testimonial layouts, the team can reuse the same proof pattern wherever credibility matters.',
                'source_name' => 'Marketing Operations',
                'source_detail' => 'WordPress publishing workflow',
                'media' => array(
                    'type' => 'initials',
                    'initials' => 'MO',
                    'label' => 'Marketing Operations',
                    'background' => '#f4d35e',
                    'foreground' => '#0d3b66',
                    'shape' => 'soft',
                ),
            ),
        ),
    ),
    'campaign_results' => array(
        'id' => 'campaign-results',
        'eyebrow' => 'Campaign Results',
        'heading' => 'A quick snapshot of measurable wins',
        'intro' => 'When a team has numbers but not a full case study, Proof Cards can turn individual metrics into a clear credibility section.',
        'layout' => 'grid',
        'card_style' => 'bordered',
        'bg_style' => 'none',
        'cards' => array(
            array(
                'label' => 'Conversion Lift',
                'metric_value' => '38%',
                'metric_label' => 'increase in form completions',
                'statement' => 'Simplifying the page structure and clarifying the calls to action helped visitors move from interest to inquiry faster.',
                'source_name' => 'Lead Generation Campaign',
                'source_detail' => 'Service page optimization',
                'media' => array('type' => 'none'),
            ),
            array(
                'label' => 'Resource Engagement',
                'metric_value' => '2.4x',
                'metric_label' => 'more resource downloads',
                'statement' => 'Grouping educational content by audience need made the resource library easier to browse and more useful to visitors.',
                'source_name' => 'Resource Hub Launch',
                'source_detail' => 'Filtered content strategy',
                'media' => array(
                    'type' => 'initials',
                    'initials' => 'RH',
                    'label' => 'Resource Hub Launch',
                    'background' => '#103f67',
                    'foreground' => '#ffffff',
                    'shape' => 'circle',
                ),
            ),
            array(
                'label' => 'Content Reuse',
                'metric_value' => '6',
                'metric_label' => 'reusable landing sections',
                'statement' => 'The content team reused the same structured sections across multiple pages without needing new templates for every campaign.',
                'source_name' => 'Marketing Site Rollout',
                'source_detail' => 'Modular WordPress build',
                'media' => array('type' => 'none'),
            ),
        ),
    ),
    'testimonial_grid' => array(
        'id' => 'testimonial-grid',
        'eyebrow' => 'Client Feedback',
        'heading' => 'Clean testimonial cards without extra noise',
        'intro' => 'Proof Cards can also work as a simple testimonial grid when metrics are not available.',
        'layout' => 'grid',
        'card_style' => 'default',
        'bg_style' => 'warm',
        'cards' => array(
            array(
                'is_quote' => true,
                'statement' => 'The finished page felt polished, responsive, and easy for our team to update after launch.',
                'source_name' => 'Elevate Fitness',
                'source_detail' => 'Service website refresh',
                'media' => array(
                    'type' => 'logo',
                    'src' => get_theme_file_uri('/assets/images/portfolio/proof-cards/elevate-fitness.svg'),
                    'alt' => '',
                ),
            ),
            array(
                'is_quote' => true,
                'statement' => 'The implementation matched the design closely and handled the responsive details we usually have to clean up later.',
                'source_name' => 'Creative Director',
                'source_detail' => 'Agency handoff',
                'media' => array(
                    'type' => 'initials',
                    'initials' => 'CD',
                    'label' => 'Creative Director',
                    'background' => '#0d3b66',
                    'foreground' => '#ffffff',
                    'shape' => 'circle',
                ),
            ),
            array(
                'is_quote' => true,
                'statement' => 'We finally had a section that made our customer feedback feel organized instead of scattered across the page.',
                'source_name' => 'Marketing Coordinator',
                'source_detail' => 'Content cleanup project',
                'media' => array(
                    'type' => 'initials',
                    'initials' => 'MC',
                    'label' => 'Marketing Coordinator',
                    'background' => '#f95738',
                    'foreground' => '#ffffff',
                    'shape' => 'soft',
                ),
            ),
        ),
    ),
    'dark_credibility' => array(
        'id' => 'dark-credibility',
        'eyebrow' => 'Implementation Proof',
        'heading' => 'Built for reuse, handoff, and long-term editing',
        'intro' => 'This example shifts the same proof model toward implementation details, editor handoff, and long-term maintainability.',
        'layout' => 'grid',
        'card_style' => 'elevated',
        'bg_style' => 'cool',
        'cards' => array(
            array(
                'label' => 'Structured Editing',
                'metric_value' => '1 card',
                'metric_label' => 'one focused editing surface',
                'statement' => 'Each proof item is its own child block, so editors can add, duplicate, reorder, or remove cards without digging through a cramped repeater.',
                'source_name' => 'Editor Experience',
                'source_detail' => 'Parent/child ACF architecture',
                'media' => array(
                    'type' => 'initials',
                    'initials' => 'UX',
                    'label' => 'Editor Experience',
                    'background' => '#0b1320',
                    'foreground' => '#ffffff',
                    'shape' => 'circle',
                ),
            ),
            array(
                'label' => 'No JavaScript',
                'metric_value' => '0kb',
                'metric_label' => 'JavaScript required for v1 layout',
                'statement' => 'The v1 grid relies on semantic markup and responsive CSS Grid instead of carousel behavior or layout scripts.',
                'source_name' => 'Front-end Performance',
                'source_detail' => 'Static responsive layout',
                'media' => array('type' => 'none'),
            ),
            array(
                'label' => 'Brand-Aware Styling',
                'statement' => 'Local CSS variables keep the block portable while allowing the colors, surfaces, and accents to follow the site’s brand system.',
                'source_name' => 'Design System Fit',
                'source_detail' => 'Scoped block styling',
                'media' => array(
                    'type' => 'initials',
                    'initials' => 'DS',
                    'label' => 'Design System Fit',
                    'background' => '#103f67',
                    'foreground' => '#ffffff',
                    'shape' => 'soft',
                ),
            ),
            array(
                'label' => 'Accessible Structure',
                'statement' => 'Metrics, source attribution, links, and statements are rendered with meaningful structure instead of decorative card markup alone.',
                'source_name' => 'Markup Review',
                'source_detail' => 'Production-minded front end implementation',
                'media' => array('type' => 'none'),
            ),
            array(
                'label' => 'Editor Decision',
                'statement' => 'The block started as a repeater, but testing showed that multiple proof cards were painful to manage in the sidebar. The final version uses child blocks instead.',
                'source_name' => 'Build Process',
                'source_detail' => 'Editor experience refinement',
                'media' => array(
                    'type' => 'initials',
                    'initials' => 'BP',
                    'label' => 'Build Process',
                    'background' => '#f2ede6',
                    'foreground' => '#8a6d4f',
                    'shape' => 'soft',
                ),
            ),
        ),
    ),
);
    ?>
    <?php get_header(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class('fu-portfolio-piece fu-proof-cards-portfolio'); ?>>
        <div class="container">
            <div class="entry-content">

                <section class="fu-portfolio-piece__lead" id="proof-cards-lead">
                    <div class="fu-portfolio-piece__lead-inner">
                        <div class="fu-portfolio-piece__lead-copy">
                            <p class="fu-case-section__eyebrow">ACF Block Portfolio</p>
                            <h1 class="fu-portfolio-piece__lead-heading"><?php the_title(); ?></h1>
                            <div class="fu-portfolio-piece__lead-body">
                                <p>Proof Cards is a structured social proof block for WordPress that helps editors combine testimonials, metrics, client outcomes, logos, and source attribution in one reusable system.</p>
                                <p>Instead of building one-off testimonial sections, teams can reuse the same pattern wherever proof needs to feel credible and easy to manage.</p>
                            </div>

                            <div class="fu-portfolio-piece__meta">
                                <div class="fu-portfolio-piece__meta-item">
                                    <span class="fu-portfolio-piece__meta-label">Use Case</span>
                                    <span class="fu-portfolio-piece__meta-value">Testimonials, outcomes, client proof</span>
                                </div>
                                <div class="fu-portfolio-piece__meta-item">
                                    <span class="fu-portfolio-piece__meta-label">Content Model</span>
                                    <span class="fu-portfolio-piece__meta-value">Parent/child block architecture</span>
                                </div>
                                <div class="fu-portfolio-piece__meta-item">
                                    <span class="fu-portfolio-piece__meta-label">Key Strength</span>
                                    <span class="fu-portfolio-piece__meta-value">Structured proof, canvas editing</span>
                                </div>
                            </div>
                        </div>

                        <div class="fu-portfolio-piece__lead-media">
                            <figure class="fu-portfolio-piece__lead-figure">
                                <img src="<?php echo esc_url($proof_cards_hero_media_uri); ?>" alt="Proof Cards ACF block planning notebook, implementation code, and WordPress editor preview.">
                            </figure>
                            <p class="fu-portfolio-piece__lead-caption">A parent/child block system for turning quotes, outcomes, metrics, and source details into reusable proof sections.</p>
                        </div>
                    </div>
                </section>

                <section class="fu-case-section" id="problem-purpose">
                    <div class="fu-case-section__inner">
                        <p class="fu-case-section__eyebrow">Overview</p>
                        <h2 class="fu-case-section__heading">From generic testimonials to structured proof</h2>
                        <div class="fu-case-section__body">
                            <p>Most testimonial sections stop at a quote, name, and title. Proof Cards gives editors a more useful structure: outcome metrics, proof statements, source details, optional images or logos, and links to deeper case studies or reviews.</p>
                            <p>The point is not just attractive cards. It’s a better content model for trust signals, so editors can reuse the same pattern wherever credibility matters.</p>
                        </div>
                    </div>
                </section>

                <?php echo fu_proof_cards_demo_section_markup($proof_cards_demos['main_showcase']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                ?>

                <section class="fu-case-section" id="use-cases">
                    <div class="fu-case-section__inner">
                        <p class="fu-case-section__eyebrow">Use Cases</p>
                        <h2 class="fu-case-section__heading">One proof system, multiple use cases</h2>
                        <div class="fu-case-section__body">
                            <p>The same block can support metric-heavy proof, quote-first testimonials, agency handoff notes, and lighter case-study snippets without changing the underlying pattern.</p>
                        </div>
                    </div>
                </section>

                <?php echo fu_proof_cards_demo_section_markup($proof_cards_demos['campaign_results']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                ?>
                <?php echo fu_proof_cards_demo_section_markup($proof_cards_demos['testimonial_grid']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                ?>

                <section class="fu-case-section fu-proof-cards-bridge" id="use-case-shift">
                    <div class="fu-case-section__inner">
                        <p class="fu-case-section__eyebrow">Use Case Shift</p>
                        <h2 class="fu-case-section__heading">From client feedback to implementation proof</h2>
                        <div class="fu-case-section__body">
                            <p>Proof Cards is not limited to customer quotes. The same structure can highlight measurable outcomes, technical decisions, editor experience, and reusable WordPress architecture.</p>
                        </div>
                    </div>
                </section>

                <?php echo fu_proof_cards_demo_section_markup($proof_cards_demos['dark_credibility']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                ?>

                <section class="fu-case-section" id="editor-experience">
                    <div class="fu-case-section__inner">
                        <p class="fu-case-section__eyebrow">Editor Experience</p>
                        <h2 class="fu-case-section__heading">Designed around the editor, not just the front end</h2>
                        <div class="fu-case-section__body">
                            <p>The first version used a repeater, which made sense for the data model but failed the real editor test: multiple cards became difficult to manage in the Gutenberg sidebar. The final version uses one child block per proof card, giving editors a clearer canvas-level workflow for selecting, editing, duplicating, and reordering proof items.</p>
                            <p>Parent controls handle the section heading, background, layout, and card style. Child blocks hold the proof content itself, including the statement, metrics, source details, links, and optional media or logo support.</p>
                        </div>

                        <div class="fu-principles__grid fu-principles__grid--compact fu-proof-page__spaced-grid" aria-label="Proof Cards editor principles">
                            <div class="fu-principles__item fu-principles__item--compact">
                                <h3>Parent block controls the frame</h3>
                                <p>Section heading, background, layout, and card style stay at the parent level.</p>
                            </div>
                            <div class="fu-principles__item fu-principles__item--compact">
                                <h3>Child blocks hold proof content</h3>
                                <p>Each proof card is its own unit, so editors can duplicate and reorder freely.</p>
                            </div>
                            <div class="fu-principles__item fu-principles__item--compact">
                                <h3>Statement stays guided</h3>
                                <p>The proof statement uses a limited WYSIWYG editor instead of a full content sandbox.</p>
                            </div>
                            <div class="fu-principles__item fu-principles__item--compact">
                                <h3>Media stays optional</h3>
                                <p>Logos, initials, or images can support the source without dominating the card.</p>
                            </div>
                            <div class="fu-principles__item fu-principles__item--compact">
                                <h3>Responsive Grid stays stable</h3>
                                <p>Layout relies on semantic markup and CSS Grid instead of JavaScript-driven behavior.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="fu-case-section" id="technical-approach">
                    <div class="fu-case-section__inner">
                        <p class="fu-case-section__eyebrow">Technical Notes</p>
                        <h2 class="fu-case-section__heading">Technical approach</h2>
                        <div class="fu-case-section__body">
                            <p>The implementation uses ACF parent/child blocks, InnerBlocks, structured fields, a limited WYSIWYG statement field, scoped CSS variables, and responsive CSS Grid. It supports optional logos and images, accessible source attribution, and rebrandable styling without requiring JavaScript in v1.</p>
                        </div>

                        <div class="fu-principles__grid fu-principles__grid--compact fu-proof-page__spaced-grid" aria-label="Technical approach highlights">
                            <div class="fu-principles__item fu-principles__item--compact">
                                <h3>Structured ACF Fields</h3>
                                <p>Each card maps to a clear content model instead of a freeform repeater.</p>
                            </div>
                            <div class="fu-principles__item fu-principles__item--compact">
                                <h3>Scoped CSS Variables</h3>
                                <p>Colors, surfaces, and accents can follow the site brand without global overrides.</p>
                            </div>
                            <div class="fu-principles__item fu-principles__item--compact">
                                <h3>Accessible Source Structure</h3>
                                <p>Metrics, statements, source details, and optional media are kept semantically distinct.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="fu-case-section" id="portfolio-value">
                    <div class="fu-case-section__inner">
                        <p class="fu-case-section__eyebrow">Portfolio Value</p>
                        <h2 class="fu-case-section__heading">Why this matters for clients</h2>
                        <div class="fu-case-section__body">
                            <p>Proof Cards helps clients present testimonials, outcomes, metrics, logos, and source details in a consistent system. Instead of scattering proof across several one-off sections, the same block can adapt to service pages, landing pages, home pages, resource hubs, and case-study previews.</p>
                            <p>That makes the content easier to maintain and the trust signals easier to scan. For teams that need editorial flexibility without layout chaos, the block creates a better publishing pattern from the start.</p>
                        </div>
                    </div>
                </section>

                <section class="fu-portfolio-piece__closing">
                    <div class="fu-portfolio-piece__closing-inner">
                        <p class="fu-case-section__eyebrow">Closing Thought</p>
                        <h2 class="fu-portfolio-piece__closing-heading">Need a better way to structure proof content?</h2>
                        <p class="fu-portfolio-piece__closing-body">I build WordPress components that help editors present credibility clearly, reuse content intelligently, and keep the front end consistent.</p>

                        <div class="fu-portfolio-piece__actions">
                            <a class="fu-portfolio-piece__button fu-portfolio-piece__button--primary" href="<?php echo esc_url(home_url('/contact/')); ?>">Start a Conversation</a>
                            <a class="fu-portfolio-piece__button fu-portfolio-piece__button--secondary" href="<?php echo esc_url(home_url('/portfolio/')); ?>">Back to Portfolio</a>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </article>

    <?php get_footer();
