<?php

/**
 * Template Name: Content Switcher Portfolio
 *
 * @package Tim_Fetter_Portfolio
 */

get_header();

$resolve_portfolio_page_url = static function ($slug) {
    $page = get_page_by_path($slug);

    return $page ? get_permalink($page) : '';
};

$editor_experience_url = $resolve_portfolio_page_url('editor-experience');

if ($editor_experience_url === '') {
    $editor_experience_url = home_url('/editor-experience/');
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('fu-portfolio-piece fu-portfolio-piece--hero-media fu-content-switcher-portfolio'); ?>>
    <div class="entry-content">

        <section id="content-switcher-overview" class="fu-portfolio-piece__lead">
            <div class="container">
                <div class="fu-portfolio-piece__lead-inner">
                    <div class="fu-portfolio-piece__lead-copy">
                        <p class="fu-eyebrow">Reusable WordPress Section</p>
                        <h1 class="fu-portfolio-piece__lead-heading"><?php the_title(); ?></h1>

                        <div class="fu-portfolio-piece__lead-body">
                            <p>
                                Some pages need to serve different audiences, services, or decision paths without turning into
                                a long stack of repeated sections. The Content Switcher gives teams a structured way to organize
                                that content while keeping the page easy to scan.
                            </p>

                            <p>
                                Editors can update each panel independently while the component protects the layout, interaction,
                                and responsive behavior that make the pattern dependable in production.
                            </p>
                        </div>
                    </div>
                    <div class="fu-portfolio-piece__lead-media">
                        <figure class="fu-portfolio-piece__lead-figure">
                            <img
                                src="/wp-content/uploads/2026/05/page-switcher-hero.webp"
                                alt="Content Switcher block process collage showing planning, editor controls, and front-end interaction.">
                        </figure>
                        <p class="fu-portfolio-piece__lead-caption">
                            A reusable content system designed to help teams organize structured information while keeping
                            editing predictable.
                        </p>
                    </div>

                    <div class="fu-portfolio-piece__meta fu-portfolio-piece__meta--hero-row">
                        <div class="fu-portfolio-piece__meta-item">
                            <span class="fu-portfolio-piece__meta-label">Use Case</span>
                            <span class="fu-portfolio-piece__meta-value">Tabs, section switchers, audience-based content</span>
                        </div>
                        <div class="fu-portfolio-piece__meta-item">
                            <span class="fu-portfolio-piece__meta-label">Content Model</span>
                            <span class="fu-portfolio-piece__meta-value">Structured child panels with guided controls</span>
                        </div>
                        <div class="fu-portfolio-piece__meta-item">
                            <span class="fu-portfolio-piece__meta-label">Key Strength</span>
                            <span class="fu-portfolio-piece__meta-value">Structured panels with accessible interaction and reusable display styles</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="fu-case-section" id="overview">
            <div class="fu-case-section__inner container container--readable">
                <p class="fu-eyebrow">Overview</p>
                <h2 class="fu-case-section__heading fu-section-heading">When One Page Needs to Serve More Than One Path</h2>

                <div class="fu-case-section__body fu-section-body">
                    <p>
                        Some pages need to compare options, speak to multiple audiences, or group related information without
                        making every visitor read every section. Left unchecked, those pages become long, repetitive, and hard
                        to scan.
                    </p>

                    <p>
                        A switcher pattern works when the content belongs together but each path needs its own focused space.
                        Visitors can move directly to what matters, and editors get a repeatable publishing pattern instead
                        of rebuilding the layout for every new page.
                    </p>
                </div>
            </div>
        </section>

        <section class="fu-portfolio-piece__demo-panel" id="live-demo">
            <div class="fu-portfolio-piece__demo-panel-inner container">
                <p class="fu-eyebrow">Live Component Preview</p>

                <p class="fu-portfolio-piece__demo-caption">
                    <strong>Try it:</strong> Click the settings button to explore curated front-end controls for display
                    style, backgrounds, and border radius. These controls mirror a small subset of the options
                    available to editors inside WordPress.
                </p>

                <p class="fu-portfolio-piece__demo-caption">
                    Switch between panels to see how each section can manage its own layout, media, highlights, and
                    buttons while staying inside the same reusable component.
                </p>

                <div class="fu-content-switcher-demo-shell" data-fu-content-switcher-demo-target>
                    <button
                        type="button"
                        class="fu-content-switcher-config-toggle"
                        data-fu-content-switcher-demo-toggle
                        aria-label="Content Switcher Controls"
                        title="Content Switcher Controls"
                        aria-controls="fuContentSwitcherDemoPanel"
                        aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width: 24px; height: 24px">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <?php the_content(); ?>
                </div>
            </div>
        </section>

        <?php get_template_part('parts/demo-panel-content-switcher'); ?>

        <section class="fu-principles" id="design-principles">
            <div class="container container--page">
                <div class="fu-principles__inner">
                    <p class="fu-eyebrow">Design Principles</p>

                    <p class="fu-principles__heading fu-case-section__heading">
                        Each decision in this block was made to reduce the gap between what an editor can do and what the front end
                        actually needs to support.
                    </p>

                    <div class="fu-principles__grid">
                        <div class="fu-principles__item">
                            <h3>Controlled Flexibility</h3>
                            <p>
                                The block exposes display style, spacing, border radius, and nav behavior as discrete options—not
                                open-ended fields. Editors get meaningful variation without the risk of breaking the layout.
                            </p>
                        </div>

                        <div class="fu-principles__item">
                            <h3>Editor-First Structure</h3>
                            <p>
                                Panels are structured content items, not freeform containers. Each one has a defined set of fields:
                                label, icon, media, content, highlights, and buttons. That structure makes editing faster and
                                publishing more consistent.
                            </p>
                        </div>

                        <div class="fu-principles__item">
                            <h3>Accessible by Default</h3>
                            <p>
                                Tab and tabpanel semantics, keyboard navigation, and mobile accordion fallback are built into the
                                component—not added as an afterthought. The interaction model works correctly whether or not
                                JavaScript has loaded.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="fu-case-section" id="editor-experience">
            <div class="fu-case-section__inner container container--readable">
                <p class="fu-eyebrow">Editor Experience</p>
                <h2 class="fu-case-section__heading fu-section-heading">Clear Editing Boundaries Without Custom Layout Work</h2>

                <div class="fu-case-section__body fu-section-body">
                    <p>
                        Editors should not have to decide where the layout begins and ends every time they update a page.
                        The switcher keeps the shared presentation in one place, so spacing, backgrounds, navigation, and
                        responsive behavior stay consistent across every panel.
                    </p>

                    <p>
                        Each panel gives editors a clear place to manage the content that belongs to that path: label, icon,
                        media, body copy, highlights, buttons, and a deep link. Panels can be updated or reordered without
                        rebuilding the surrounding component.
                    </p>

                    <p>
                        Editor-only utilities, including panel labels and one-click deep link copying, support the publishing
                        workflow without leaking those controls onto the public front end.
                    </p>
                </div>
            </div>
        </section>

        <section class="fu-case-section" id="implementation">
            <div class="fu-case-section__inner container container--readable">
                <p class="fu-eyebrow">Implementation</p>
                <h2 class="fu-case-section__heading fu-section-heading">Built to Stay Reusable, Accessible, and Predictable</h2>

                <div class="fu-case-section__body fu-section-body">
                    <p class="fu-content-switcher-portfolio__implementation-intro">
                        The block separates shared presentation from panel content so editors get flexibility without
                        one-off layout work. The front end handles accessible interaction, scoped instance data, responsive
                        fallbacks, and reusable display variants in one dependable system.
                    </p>
                </div>

                <div class="fu-principles__grid fu-principles__grid--compact" aria-label="Implementation capabilities">
                    <div class="fu-principles__item fu-principles__item--compact">
                        <h3>Structured Editor Model</h3>
                        <p>Parent settings control the switcher while each panel manages its own content.</p>
                    </div>

                    <div class="fu-principles__item fu-principles__item--compact">
                        <h3>Accessible Interaction Built In</h3>
                        <p>Server-rendered tab and tabpanel markup supports assistive technology.</p>
                    </div>

                    <div class="fu-principles__item fu-principles__item--compact">
                        <h3>Keyboard Navigation</h3>
                        <p>Arrow-key interaction follows the selected horizontal or vertical orientation.</p>
                    </div>

                    <div class="fu-principles__item fu-principles__item--compact">
                        <h3>Safe Deep Linking</h3>
                        <p>Panel hashes are scoped so multiple switchers can coexist on one page.</p>
                    </div>

                    <div class="fu-principles__item fu-principles__item--compact">
                        <h3>Responsive Accordion Fallback</h3>
                        <p>Small screens use a mobile-friendly panel pattern without a separate block.</p>
                    </div>

                    <div class="fu-principles__item fu-principles__item--compact">
                        <h3>Portable Visual System</h3>
                        <p>Display variants share one system instead of duplicated stylesheets.</p>
                    </div>

                    <div class="fu-principles__item fu-principles__item--compact">
                        <h3>Matched Panel Height</h3>
                        <p>Editors can reduce layout shift when panel content varies.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="fu-case-section" id="outcome">
            <div class="fu-case-section__inner container container--readable">
                <p class="fu-eyebrow">Outcome</p>
                <h2 class="fu-case-section__heading fu-section-heading">Less One-Off Work, More Consistent Publishing</h2>

                <div class="fu-case-section__body fu-section-body">
                    <p>
                        Teams using this block spend less time building custom layout sections for structured content and more
                        time publishing. The same component handles service comparisons, audience-based messaging, feature
                        groups, and tabbed reference content without requiring a new block for each use case.
                    </p>

                    <p>
                        Accessibility is built in rather than retrofitted, so there's no additional QA burden when the block
                        is reused. Editorial control stays with the team—display style, panel content, and deep link behavior
                        are all managed within the block editor, with no theme customization required.
                    </p>
                </div>
            </div>
        </section>

        <?php
        get_template_part(
            'parts/editor-handoff-callout',
            null,
            array(
                'url' => $editor_experience_url,
            )
        );
        ?>

        <?php
        get_template_part(
            'parts/block-navigation',
            null,
            array(
                'current' => 'content-switcher',
            )
        );
        ?>

        <section class="fu-portfolio-piece__closing">
            <div class="container container--page">
                <div class="fu-cta-panel--dark fu-portfolio-piece__closing-inner fu-cta-panel">
                    <p class="fu-eyebrow">Closing Thought</p>
                    <h2 class="fu-portfolio-piece__closing-heading">Need WordPress components that are easier to launch, reuse, and maintain?</h2>
                    <p class="fu-portfolio-piece__closing-body">
                        I help agencies turn complex content needs into dependable WordPress features, with thoughtful front-end implementation, guided editor controls, and production-ready behavior.
                    </p>

                    <div class="fu-portfolio-piece__actions fu-cta-panel__actions">
                        <a class="fu-portfolio-piece__button fu-portfolio-piece__button--primary" href="<?php echo esc_url(home_url('/contact/')); ?>">Start a Conversation</a>
                        <a class="fu-portfolio-piece__button fu-portfolio-piece__button--secondary" href="<?php echo esc_url(home_url('/work/')); ?>">Back to Work</a>
                    </div>
                </div>
            </div>
        </section>

    </div>
</article>

<?php
get_footer();
