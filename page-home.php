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
        'title' => 'Interactive Front-End Prototypes',
        'summary' => 'HTML/CSS/JS prototypes, clickable proof-of-concepts, UI flows clients can review before full development, and handoff-ready front-end thinking.',
        'points' => array(
            'HTML/CSS/JS prototypes',
            'Clickable proof-of-concepts',
            'UI flows clients can review before full development',
            'Fast front-end demos before .NET or backend implementation',
            'Responsive prototype polish',
            'Handoff-ready front-end thinking',
        ),
    ),
);

$good_fit_points = array(
    array(
        'title' => 'Agency overflow support',
        'summary' => 'Front-end implementation backup when your internal team is at capacity.',
    ),
    array(
        'title' => 'Small business WordPress support',
        'summary' => 'Theme and template help, content structure updates, and practical improvements.',
    ),
    array(
        'title' => 'Prototype-first projects',
        'summary' => 'Clickable front-end flows before full production development.',
    ),
    array(
        'title' => 'Cleanup and ongoing polish',
        'summary' => 'Responsive fixes, component cleanup, and steady iteration on existing sites.',
    ),
    array(
        'title' => 'Design-ready implementation',
        'summary' => 'When design direction exists and the team needs reliable front-end execution.',
    ),
);

$recent_systems = array(
    array(
        'title' => 'Editor Experience & Handoff',
        'slug' => 'editor-experience',
        'summary' => 'How I structure blocks so editors can make real updates without breaking layout, accessibility, or the front end.',
        'image' => '/uploads/2026/05/page-editor-experience-handoff-hero-600x450.webp',
    ),
    array(
        'title' => 'ACF Block System Overview',
        'slug' => 'acf-block-system',
        'summary' => 'A broader look at the block system approach, including reusable patterns, structured content, and safer handoff.',
        'image' => '/uploads/2026/05/page-block-system-hero-600x450.webp',
    ),
    array(
        'title' => 'Filtered Content Grid',
        'slug' => 'filtered-content-grid',
        'summary' => 'A structured content system with instant filtering that stays stable on load and responsive in use.',
        'image' => '/uploads/2026/05/page-filtered-content-grid-hero-600x450.webp',
    ),
    array(
        'title' => 'Content Switcher',
        'slug' => 'content-switcher',
        'summary' => 'A parent/child block system for tabs, panels, and accessible switching with mobile fallback.',
        'image' => '/uploads/2026/05/page-switcher-hero-600x450.webp',
    ),
    array(
        'title' => 'Comparison Cards',
        'slug' => 'comparison-cards',
        'summary' => 'Structured comparison cards for plans, services, and options without relying on a dense repeater interface.',
        'image' => '/uploads/2026/05/page-comparison-cards-hero-600x450.webp',
    ),
    array(
        'title' => 'Proof Cards',
        'slug' => 'proof-cards',
        'summary' => 'A social-proof system for outcomes, metrics, and credibility signals that still feels maintainable.',
        'image' => '/uploads/2026/05/page-proof-cards-hero-600x450.webp',
    ),
    array(
        'title' => 'Page Banner',
        'slug' => 'page-banner',
        'summary' => 'A flexible hero/header component with media controls, readability settings, and consistent responsive output.',
        'image' => '/uploads/2026/05/page-banner-hero-600x450.webp',
    ),
    array(
        'title' => 'Flexible Feature Section',
        'slug' => 'flexible-feature-section',
        'summary' => 'A reusable content-and-media section designed to stay balanced with real-world copy and layouts.',
        'image' => '/uploads/2026/05/page-flexible-feature-hero-600x450.webp',
    ),
);

$earlier_work = array(
    array(
        'title' => 'Omni Hotels & Resorts',
        'slug' => 'omni-hotels-resorts',
        'summary' => 'WordPress builds, custom templates, responsive implementation, and front-end support for hospitality work.',
    ),
    array(
        'title' => 'National University',
        'slug' => 'national-university',
        'summary' => 'Structured page builds and responsive implementation for a higher-education client with a large content surface.',
    ),
    array(
        'title' => 'Fibroid Foundation',
        'slug' => 'fibroid-foundation',
        'summary' => 'Content updates, WordPress implementation, and front-end support for nonprofit communication needs.',
    ),
    array(
        'title' => 'Blackberry Farm & Blackberry Mountain',
        'slug' => 'blackberry-farm-blackberry-mountain',
        'summary' => 'Polished responsive implementation and supporting front-end work for hospitality and destination branding.',
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
                                <p class="fu-eyebrow">WordPress support, front-end implementation, and interactive prototypes</p>
                                <h1 class="fu-home__title">Front-end development for WordPress sites and interactive prototypes.</h1>
                                <p class="fu-home__lede">I help agencies and small businesses turn designs, content needs, and early product ideas into clean, responsive web experiences - from maintainable WordPress builds to HTML/CSS/JS prototypes clients can review before full development.</p>

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
                                <p class="fu-eyebrow">Recent WordPress systems</p>
                                <h2 class="fu-section-heading" id="recent-wordpress-systems-heading">Recent WordPress systems and implementation examples</h2>
                                <p class="fu-section-lede">These recent case-study pages show how I think about structured content, editor-friendly components, and front-end implementation that holds up over time.</p>
                            </div>

                            <div class="fu-home__systems-grid fu-work-grid">
                                <?php foreach ($recent_systems as $system) : ?>
                                    <?php $system_url = $resolve_page_url($system['slug']); ?>
                                    <a class="fu-home__system-card fu-work-card fu-work-card--linked" href="<?php echo esc_url($system_url); ?>">
                                        <?php if (!empty($system['image'])) : ?>
                                            <div class="fu-home__system-media fu-work-card__media">
                                                <img class="fu-home__system-thumb"
                                                    src="<?php echo esc_url(content_url($system['image'])); ?>"
                                                    alt=""
                                                    loading="lazy"
                                                    width="600"
                                                    height="450">
                                            </div>
                                        <?php endif; ?>
                                        <div class="fu-home__system-body fu-work-card__body">
                                            <p class="fu-home__system-kicker fu-work-card__kicker">Case Study</p>
                                            <h3 class="fu-work-card__title"><?php echo esc_html($system['title']); ?></h3>
                                            <p class="fu-work-card__text"><?php echo esc_html($system['summary']); ?></p>
                                            <span class="fu-home__system-link fu-work-card__link">View case study</span>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>

                            <div class="fu-home__section-footer">
                                <a class="fu-home__text-link" href="<?php echo esc_url($resolve_page_url('acf-block-system')); ?>">View the WordPress system case studies</a>
                            </div>
                        </div>
                    </section>

                    <section class="fu-home__section fu-home__prototype" aria-labelledby="prototype-heading">
                        <div class="fu-home__section-inner fu-home__section-inner--narrow fu-home__prototype-panel container container--readable">
                            <div class="fu-home__prototype-copy">
                                <p class="fu-eyebrow">Interactive prototypes before full development</p>
                                <h2 id="prototype-heading">Prototype support that helps teams validate the idea first</h2>
                                <p>I can build HTML/CSS/JS prototypes, clickable flows, and front-end proof-of-concepts that agencies or teams can review, test, and show to clients before senior developers rebuild the product in .NET or another backend stack.</p>
                                <div class="fu-home__prototype-actions">
                                    <a class="fu-portfolio-piece__button fu-portfolio-piece__button--primary" href="<?php echo esc_url(home_url('/contact/')); ?>">Discuss a Prototype</a>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="fu-home__section fu-home__earlier-work" id="earlier-client-work" aria-labelledby="earlier-client-work-heading">
                        <div class="fu-home__section-inner container container--page">
                            <div class="fu-section-head">
                                <p class="fu-eyebrow">Earlier client work</p>
                                <h2 class="fu-section-heading" id="earlier-client-work-heading">Selected previous client work</h2>
                                <p class="fu-section-lede">Earlier projects include WordPress builds, custom templates, responsive implementation, content updates, and support for hospitality, education, healthcare, nonprofit, real estate, and technology clients.</p>
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
                                                    <?php echo get_the_post_thumbnail($portfolio_post, 'medium_large', array('loading' => 'lazy', 'decoding' => 'async')); ?>
                                                <?php endif; ?>
                                            </div>

                                            <div class="fu-home__legacy-card-body fu-work-card__body">
                                                <p class="fu-home__legacy-card-kicker fu-work-card__kicker">Earlier client work</p>
                                                <h3 class="fu-work-card__title"><?php echo esc_html($portfolio_post->post_title); ?></h3>
                                                <p class="fu-work-card__text"><?php echo esc_html($item['summary']); ?></p>
                                                <span class="fu-work-card__link">View case study</span>
                                            </div>
                                        </a>
                                    <?php else : ?>
                                        <article class="fu-home__legacy-card fu-work-card fu-work-card--legacy">
                                            <div class="fu-home__legacy-card-media fu-work-card__media"></div>
                                            <div class="fu-home__legacy-card-body fu-work-card__body">
                                                <p class="fu-home__legacy-card-kicker fu-work-card__kicker">Earlier client work</p>
                                                <h3 class="fu-work-card__title"><?php echo esc_html($item['title']); ?></h3>
                                                <p class="fu-work-card__text"><?php echo esc_html($item['summary']); ?></p>
                                            </div>
                                        </article>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>

                            <div class="fu-home__section-footer fu-home__section-footer--compact">
                                <a class="fu-portfolio-piece__button fu-portfolio-piece__button--secondary" href="<?php echo esc_url($portfolio_archive_url); ?>">View all work</a>
                            </div>
                        </div>
                    </section>

                    <section class="fu-home__section fu-home__cta" aria-labelledby="final-cta-heading">
                        <div class="fu-cta-panel--dark fu-home__section-inner fu-home__section-inner--narrow fu-home__cta-panel fu-cta-panel container">
                            <div class="fu-home__cta-copy">
                                <p class="fu-eyebrow">Need reliable front-end help?</p>
                                <h2 id="final-cta-heading">Smaller projects, overflow support, prototype builds, and ongoing site updates.</h2>
                                <p>I’m available for smaller projects, agency overflow support, WordPress improvements, prototype builds, and ongoing site updates.</p>
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