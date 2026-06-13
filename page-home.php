<?php
//Template Name: Home
?>
<?php
$resolve_page_url = static function ($slug) {
    $page = get_page_by_path($slug);

    return $page ? get_permalink($page) : home_url('/' . trim($slug, '/') . '/');
};

$resolve_portfolio_item = static function ($title, $slug) {
    $post = get_page_by_path($slug, OBJECT, 'portfolio-items');

    if ($post) {
        return $post;
    }

    $matches = get_posts(array(
        'post_type'      => 'portfolio-items',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        's'              => $title,
    ));

    foreach ($matches as $match) {
        if (strcasecmp(trim(wp_strip_all_tags($match->post_title)), $title) === 0) {
            return $match;
        }
    }

    return !empty($matches) ? $matches[0] : null;
};

$portfolio_archive_url = get_post_type_archive_link('portfolio-items');

if (!$portfolio_archive_url) {
    $portfolio_archive_url = home_url('/work/');
}

$service_lanes = array(
    array(
        'title' => 'WordPress Development Support',
        'summary' => 'Theme and template work, ACF Blocks, structured content, page-builder cleanup, responsive fixes, reusable components, editor-friendly implementation, and ongoing site improvements.',
        'points' => array(
            'WordPress theme and template work',
            'ACF Blocks and structured content',
            'Page-builder support or cleanup',
            'Responsive fixes and reusable components',
            'Editor-friendly implementation',
            'Ongoing site improvements',
        ),
    ),
    array(
        'title' => 'Front-End Design & UI Implementation',
        'summary' => 'Responsive HTML, CSS, and JavaScript implementation for custom layouts, interface states, workflow screens, and front-end polish that may live inside WordPress or another production system.',
        'points' => array(
            'Responsive HTML/CSS/JS implementation',
            'Custom UI layouts and content sections',
            'Interactive states and workflow screens',
            'Front-end polish for existing designs',
            'Clickable demos when behavior needs review',
            'Handoff-ready markup and styling',
        ),
    ),
);

$good_fit_points = array(
    array(
        'title' => 'Agency overflow support',
        'summary' => 'Front-end implementation backup when your internal team is at capacity.',
    ),
    array(
        'title' => 'Design-ready implementation',
        'summary' => 'When design direction exists and the team needs reliable front-end execution.',
    ),
    array(
        'title' => 'Small business WordPress support',
        'summary' => 'Theme and template help, content structure updates, and practical improvements.',
    ),
    array(
        'title' => 'Cleanup and ongoing polish',
        'summary' => 'Responsive fixes, component cleanup, and steady iteration on existing sites.',
    ),
    array(
        'title' => 'UI flows and interaction states',
        'summary' => 'Front-end screens that help teams clarify behavior before production.',
    ),
);

$recent_systems = array(
    array(
        'title' => 'Page Banner',
        'label' => 'Hero System',
        'slug' => 'page-banner',
        'image' => '/uploads/2026/05/page-banner-hero.webp',
        'alt'   => 'Portfolio hero showing a flexible page banner with media and readability controls.',
        'summary' => 'Media-driven page banners with image and video backgrounds, overlay controls, and editor-friendly readability settings.',
    ),
    array(
        'title' => 'Flexible Feature Section',
        'label' => 'Layout System',
        'slug' => 'flexible-feature-section',
        'image' => '/uploads/2026/05/page-flexible-feature-hero-600x450.webp',
        'alt'   => 'Portfolio hero showing a flexible feature section with balanced content and media.',
        'summary' => 'A reusable media and text layout for service sections, feature callouts, and content-led landing page sections.',
    ),
    array(
        'title' => 'Filtered Content Grid',
        'label' => 'Content Library',
        'slug' => 'filtered-content-grid',
        'summary' => 'A structured content system with instant filtering that stays stable on load and responsive in use.',
        'image' => '/uploads/2026/05/page-filtered-content-grid-hero-600x450.webp',
        'alt' => 'Filtered Content Grid portfolio hero showing planning, filtering, and structured content organization.',
    ),
    array(
        'title' => 'Content Switcher',
        'label' => 'Interactive UI',
        'slug' => 'content-switcher',
        'summary' => 'A parent/child block system for tabs, panels, and accessible switching with mobile fallback.',
        'image' => '/uploads/2026/05/page-switcher-hero-600x450.webp',
        'alt' => 'Content Switcher portfolio hero showing tabbed content panels and responsive editor controls.',
    ),
    array(
        'title' => 'Comparison Cards',
        'label' => 'Comparison Content',
        'slug' => 'comparison-cards',
        'summary' => 'Structured comparison cards for plans, services, and options without relying on a dense repeater interface.',
        'image' => '/uploads/2026/05/page-comparison-cards-hero-600x450.webp',
        'alt' => 'Comparison Cards portfolio hero showing structured service comparison cards and editor-friendly options.',
    ),
    array(
        'title' => 'Proof Cards',
        'label' => 'Social Proof',
        'slug' => 'proof-cards',
        'summary' => 'A social-proof system for outcomes, metrics, and credibility signals that still feels maintainable.',
        'image' => '/uploads/2026/05/page-proof-cards-hero-600x450.webp',
        'alt' => 'Proof Cards portfolio hero showing testimonials, metrics, and social proof card patterns.',
    ),
    array(
        'title' => 'Page Banner',
        'label' => 'Hero System',
        'slug' => 'page-banner',
        'summary' => 'A flexible hero/header component with media controls, readability settings, and consistent responsive output.',
        'image' => '/uploads/2026/05/page-banner-hero-600x450.webp',
        'alt' => 'Page Banner portfolio hero showing a flexible WordPress hero component with media and readability controls.',
    ),
    array(
        'title' => 'Flexible Feature Section',
        'label' => 'Layout System',
        'slug' => 'flexible-feature-section',
        'summary' => 'A reusable content-and-media section designed to stay balanced with real-world copy and layouts.',
        'image' => '/uploads/2026/05/page-flexible-feature-hero-600x450.webp',
        'alt' => 'Flexible Feature Section portfolio hero showing balanced content and media layout options.',
    ),
);

$earlier_work = array(
    array(
        'title' => 'Omni Hotels & Resorts',
        'slug' => 'omni-hotels-resorts',
        'summary' => 'Front-end implementation, CMS updates, reusable templates, and production support for hospitality site work inside an established team workflow.',
    ),
    array(
        'title' => 'National University',
        'slug' => 'national-university',
        'summary' => 'Responsive front-end implementation, CMS/page-builder updates, and reusable page support across a large higher-education content surface.',
    ),
    array(
        'title' => 'Fibroid Foundation',
        'slug' => 'fibroid-foundation',
        'summary' => 'WordPress support, content updates, front-end refinements, and requested implementation work for an active nonprofit site.',
    ),
    array(
        'title' => 'Blackberry Farm & Blackberry Mountain',
        'slug' => 'blackberry-farm-blackberry-mountain',
        'summary' => 'Front-end implementation, responsive UI refinements, reusable component updates, and ongoing production support for hospitality web properties.',
    ),
);
?>
<?php get_header(); ?>

<main id="main" class="site-main" role="main">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php
            $resume_link = '';

            if (have_rows('page_content')) {
                while (have_rows('page_content')) : the_row();
                    $resume_link = get_sub_field('resume_link');

                    if (!empty($resume_link)) {
                        break;
                    }
                endwhile;
            }
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('fu-home'); ?>>
                <div class="entry-content">
                    <section class="fu-home__hero" id="home-hero">
                        <div class="fu-home__section-inner fu-home__hero-panel container">
                            <div class="fu-home__hero-copy">
                                <p class="fu-eyebrow">WordPress development, front-end design, and UI implementation</p>
                                <h1 class="fu-home__title">Front-end development for WordPress sites and custom web interfaces.</h1>
                                <p class="fu-home__lede">I help agencies and small businesses turn designs, content needs, and UI ideas into clean, responsive web experiences — from maintainable WordPress builds and ACF-powered components to custom front-end layouts, interaction states, and workflow screens.</p>

                                <div class="fu-home__actions">
                                    <a class="fu-portfolio-piece__button fu-portfolio-piece__button--primary" href="<?php echo esc_url(home_url('/contact/')); ?>">Let's Talk About Your Project</a>
                                    <a class="fu-portfolio-piece__button fu-portfolio-piece__button--secondary" href="#recent-wordpress-systems">View Recent Work</a>
                                </div>

                                <?php if (!empty($resume_link)) : ?>
                                    <p class="fu-home__resume-link">
                                        <a href="<?php echo esc_url($resume_link); ?>" target="_blank" rel="noopener">Resume available on request</a>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </section>

                    <section class="fu-home__section fu-home__services" aria-labelledby="home-services-heading">
                        <div class="fu-home__section-inner container container--page">
                            <div class="fu-home__section-head">
                                <p class="fu-eyebrow fu-eyebrow--inverse">How I can help</p>
                                <h2 class="fu-section-heading" id="home-services-heading">Service lanes</h2>
                            </div>

                            <div class="fu-home__service-grid">
                                <?php foreach ($service_lanes as $lane) : ?>
                                    <article class="fu-home__service-card">
                                        <h3><?php echo esc_html($lane['title']); ?></h3>
                                        <p class="fu-home__service-summary"><?php echo esc_html($lane['summary']); ?></p>
                                        <ul class="fu-home__service-list">
                                            <?php foreach ($lane['points'] as $point) : ?>
                                                <li><?php echo esc_html($point); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </section>

                    <section class="fu-home__section fu-home__fit" aria-labelledby="home-fit-heading">
                        <div class="fu-home__section-inner fu-home__section-inner--narrow container container--readable">
                            <div class="fu-home__section-head fu-home__section-head--compact">
                                <p class="fu-eyebrow">A good fit for</p>
                                <h2 class="fu-section-heading" id="home-fit-heading">Reliable front-end help when you need an extra hand</h2>
                            </div>

                            <ul class="fu-home__fit-list" aria-label="Who this work is a good fit for">
                                <?php foreach ($good_fit_points as $point) : ?>
                                    <li>
                                        <span class="fu-home__fit-icon" aria-hidden="true"></span>
                                        <div>
                                            <strong><?php echo esc_html($point['title']); ?></strong>
                                            <p><?php echo esc_html($point['summary']); ?></p>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </section>

                    <section class="fu-content-section fu-home__recent-work" id="recent-wordpress-systems" aria-labelledby="recent-wordpress-systems-heading">
                        <div class="fu-content-section__inner container container--page">
                            <div class="fu-section-head">
                                <p class="fu-eyebrow">Recent WordPress Work</p>
                                <h2 class="fu-section-heading" id="recent-wordpress-systems-heading">WordPress blocks built to be easy to update</h2>
                                <p class="fu-section-lede">These examples show how I build flexible blocks that look polished on the front end and stay manageable for the people editing them behind the scenes.</p>
                            </div>

                            <div class="fu-home__systems-showcase">
                                <div class="fu-home__systems-grid fu-work-grid">
                                    <?php foreach (array_slice($recent_systems, 0, 4) as $system) : ?>
                                        <?php $system_url = $resolve_page_url($system['slug']); ?>
                                        <a class="fu-home__system-card fu-work-card fu-work-card--linked" href="<?php echo esc_url($system_url); ?>">
                                            <?php if (!empty($system['image'])) : ?>
                                                <div class="fu-home__system-media fu-work-card__media">
                                                    <img class="fu-home__system-thumb"
                                                        src="<?php echo esc_url(wp_make_link_relative(content_url($system['image']))); ?>"
                                                        alt="<?php echo esc_attr($system['alt'] ?? ''); ?>"
                                                        loading="lazy"
                                                        width="600"
                                                        height="450">
                                                </div>
                                            <?php endif; ?>
                                            <div class="fu-home__system-body fu-work-card__body">
                                                <p class="fu-home__system-kicker fu-work-card__kicker"><?php echo esc_html($system['label'] ?? 'Case Study'); ?></p>
                                                <h3 class="fu-work-card__title"><?php echo esc_html($system['title']); ?></h3>
                                                <p class="fu-work-card__text"><?php echo esc_html($system['summary']); ?></p>
                                                <span class="fu-home__system-link fu-work-card__link">View case study</span>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                </div>

                                <div class="fu-home__section-footer">
                                    <a class="fu-home__systems-collection-link fu-portfolio-piece__button fu-portfolio-piece__button--primary" href="<?php echo esc_url($resolve_page_url('acf-block-system')); ?>">View More WordPress Blocks</a>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="fu-home__section fu-home__earlier-work" id="earlier-client-work" aria-labelledby="earlier-client-work-heading">
                        <div class="fu-home__section-inner container container--page">
                            <div class="fu-section-head">
                                <p class="fu-eyebrow">Earlier work</p>
                                <h2 class="fu-section-heading" id="earlier-client-work-heading">Selected Client Work</h2>
                                <p class="fu-section-lede">Selected projects where I supported larger teams with front-end implementation, CMS updates, reusable templates, scripted UI components, page-builder work, static site updates, and ongoing production improvements.</p>
                            </div>

                            <div class="fu-home__legacy-grid fu-work-grid">
                                <?php foreach ($earlier_work as $index => $item) : ?>
                                    <?php
                                    $portfolio_post = $resolve_portfolio_item($item['title'], $item['slug']);
                                    ?>
                                    <?php if ($portfolio_post) : ?>
                                        <a class="fu-home__legacy-card fu-work-card fu-work-card--linked" href="<?php echo esc_url(get_permalink($portfolio_post)); ?>">
                                            <div class="fu-home__legacy-card-media fu-work-card__media">
                                                <?php if (has_post_thumbnail($portfolio_post)) : ?>
                                                    <?php
                                                    $thumbnail_id = get_post_thumbnail_id($portfolio_post);
                                                    $thumbnail_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);

                                                    if (!$thumbnail_alt) {
                                                        $thumbnail_alt = sprintf(
                                                            '%s project thumbnail.',
                                                            get_the_title($portfolio_post)
                                                        );
                                                    }

                                                    echo get_the_post_thumbnail(
                                                        $portfolio_post,
                                                        'medium_large',
                                                        array(
                                                            'loading'  => 'lazy',
                                                            'decoding' => 'async',
                                                            'alt'      => $thumbnail_alt,
                                                        )
                                                    );
                                                    ?>
                                                <?php endif; ?>
                                            </div>

                                            <div class="fu-home__legacy-card-body fu-work-card__body">
                                                <p class="fu-home__legacy-card-kicker fu-work-card__kicker">Contract support</p>
                                                <h3 class="fu-work-card__title"><?php echo esc_html($portfolio_post->post_title); ?></h3>
                                                <p class="fu-work-card__text"><?php echo esc_html($item['summary']); ?></p>
                                                <span class="fu-work-card__link">View case study</span>
                                            </div>
                                        </a>
                                    <?php else : ?>
                                        <article class="fu-home__legacy-card fu-work-card fu-work-card--legacy">
                                            <div class="fu-home__legacy-card-media fu-work-card__media"></div>
                                            <div class="fu-home__legacy-card-body fu-work-card__body">
                                                <p class="fu-home__legacy-card-kicker fu-work-card__kicker">Contract support</p>
                                                <h3 class="fu-work-card__title"><?php echo esc_html($item['title']); ?></h3>
                                                <p class="fu-work-card__text"><?php echo esc_html($item['summary']); ?></p>
                                            </div>
                                        </article>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <div class="fu-home-contract-work__footer">
                                <a class="fu-home-contract-work__section-cta fu-portfolio-piece__button fu-portfolio-piece__button--primary" href="/work/#contract-work">View More Contract Work</a>
                            </div>
                            <!-- <div class="fu-home__section-footer fu-home__section-footer--compact">
                                <a class="fu-portfolio-piece__button fu-portfolio-piece__button--secondary" href="<?php echo esc_url($portfolio_archive_url); ?>">View all work</a>
                            </div> -->
                        </div>
                    </section>


                    <!-- Front-End Prototypes Section -->
                    <section class="fu-home-prototypes fu-content-section" aria-labelledby="home-prototypes-heading">
                        <div class="fu-content-section__inner container container--page">
                            <div class="fu-section-head fu-home-prototypes__header">
                                <p class="fu-eyebrow">UI Implementation</p>
                                <h2 class="fu-section-heading" id="home-prototypes-heading">Front-End UI Examples</h2>
                                <p class="fu-section-lede">HTML, CSS, and JavaScript examples showing responsive interfaces, interaction states, workflow screens, and front-end polish before production work begins.</p>
                                <p class="fu-section-lede fu-home-prototypes__support">These examples are not meant to replace production systems. They show how focused front-end work can help teams test ideas, clarify requirements, and make better decisions before production development begins.</p>
                            </div>
                            <div class="fu-home-prototypes__grid grid grid--gap-md grid--auto-cards">
                                <a class="fu-home-prototypes__card fu-work-card fu-work-card--linked" href="/work/client-project-timeline/">
                                    <div class="fu-home-prototypes__media fu-work-card__media">
                                        <img src="<?php echo esc_url(wp_make_link_relative(content_url('/uploads/2026/05/client-project-timeline-cover.webp'))); ?>" alt="Project timeline interface showing phases, milestones, and delivery status." loading="lazy" width="600" height="450">
                                    </div>
                                    <div class="fu-home-prototypes__content fu-work-card__body">
                                        <h3 class="fu-work-card__title">Client Project Timeline</h3>
                                        <p class="fu-work-card__text">A configurable milestone tracker for testing workflow states, responsive timeline layouts, and handoff-ready UI behavior.</p>
                                        <span class="fu-home-prototypes__cta fu-work-card__link">View Prototype</span>
                                    </div>
                                </a>
                                <a class="fu-home-prototypes__card fu-work-card fu-work-card--linked" href="/work/project-scope-estimator/">
                                    <div class="fu-home-prototypes__media fu-work-card__media">
                                        <img src="<?php echo esc_url(wp_make_link_relative(content_url('/uploads/2026/05/client-project-scope-cover.webp'))); ?>" alt="Project scope interface showing grouped deliverables, priorities, and project details." loading="lazy" width="600" height="450">
                                    </div>
                                    <div class="fu-home-prototypes__content fu-work-card__body">
                                        <h3 class="fu-work-card__title">Project Scope Estimator</h3>
                                        <p class="fu-work-card__text">A guided estimator that turns early project details into a clearer scope summary before production planning.</p>
                                        <span class="fu-home-prototypes__cta fu-work-card__link">View Prototype</span>
                                    </div>
                                </a>
                                <a class="fu-home-prototypes__card fu-work-card fu-work-card--linked" href="/work/content-approval-checklist/">
                                    <div class="fu-home-prototypes__media fu-work-card__media">
                                        <img src="<?php echo esc_url(wp_make_link_relative(content_url('/uploads/2026/06/client-project-content-approval-cover.webp'))); ?>" alt="Content approval checklist interface showing content readiness, blockers, approvals, and launch-readiness states." loading="lazy" width="600" height="450">
                                    </div>
                                    <div class="fu-home-prototypes__content fu-work-card__body">
                                        <h3 class="fu-work-card__title">Content Approval Checklist</h3>
                                        <p class="fu-work-card__text">A responsive checklist for reviewing content readiness, blockers, approvals, and launch-readiness states.</p>
                                        <span class="fu-home-prototypes__cta fu-work-card__link">View Prototype</span>
                                    </div>
                                </a>
                            </div>
                            <div class="fu-home-prototypes__footer">
                                <a class="fu-home-prototypes__section-cta fu-portfolio-piece__button fu-portfolio-piece__button--primary" href="/work/#front-end-prototypes">View UI Examples</a>
                            </div>
                        </div>
                    </section>

                    <section class="fu-home__section fu-home__cta" aria-labelledby="final-cta-heading">
                        <div class="fu-cta-panel--dark fu-home__section-inner fu-home__section-inner--narrow fu-home__cta-panel fu-cta-panel container container--page">
                            <div class="fu-home__cta-copy">
                                <p class="fu-eyebrow">Need reliable front-end help?</p>
                                <h2 id="final-cta-heading">Reliable front-end help for scoped projects, overflow work, and ongoing site updates.</h2>
                                <p>I’m available for scoped front-end work, agency overflow support, WordPress improvements, custom UI implementation, and ongoing site updates.</p>
                            </div>

                            <div class="fu-home__cta-actions fu-cta-panel__actions">
                                <a class="fu-portfolio-piece__button fu-portfolio-piece__button--primary" href="<?php echo esc_url(home_url('/contact/')); ?>">Start a Conversation</a>
                                <a class="fu-portfolio-piece__button fu-portfolio-piece__button--secondary" href="#recent-wordpress-systems">View Recent Work</a>
                            </div>
                        </div>
                    </section>
                </div>
            </article>
        <?php endwhile; ?>
    <?php endif; ?>

</main><!-- #main -->

<?php get_footer(); ?>

<?php
// Enqueue homepage prototypes CSS only for the homepage
add_action('wp_enqueue_scripts', function () {
    if (is_front_page() || is_page_template('page-home.php')) {
        wp_enqueue_style('fu-home-prototypes', get_template_directory_uri() . '/css/pages/home-prototypes.css', array(), null);
    }
});
