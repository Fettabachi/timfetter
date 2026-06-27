<?php

/**
 * Template Name: Page Banner Portfolio
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

<article id="post-<?php the_ID(); ?>" <?php post_class('fu-portfolio-piece fu-portfolio-piece--hero-media fu-page-banner-portfolio'); ?>>
    <div class="entry-content">

        <section class="fu-portfolio-piece__lead">
            <div class="container">
                <div class="fu-portfolio-piece__lead-inner">
                    <div class="fu-portfolio-piece__lead-copy">
                        <p class="fu-eyebrow">Reusable WordPress Section</p>
                        <h1 class="fu-portfolio-piece__lead-heading"><?php the_title(); ?></h1>

                        <div class="fu-portfolio-piece__lead-body">
                            <p>
                                A reusable page banner built to help editors create flexible, high-impact page headers without sacrificing consistency or maintainability.
                            </p>

                            <p>
                                It supports image and video backgrounds, overlay and readability controls, and flexible content layouts within an editor experience that closely reflects the final front-end result.
                            </p>
                            <ul class="fu-portfolio-piece__lead-points">
                                <li>Image and video backgrounds with readability controls</li>
                                <li>Editor-safe alignment, overlay, and focal-point options</li>
                            </ul>
                        </div>
                    </div>

                    <div class="fu-portfolio-piece__lead-media">
                        <figure class="fu-portfolio-piece__lead-figure">
                            <img
                                src="<?php echo esc_url(home_url('/wp-content/uploads/2026/05/page-banner-hero.webp')); ?>"
                                alt="Page Banner block process collage showing planning, front-end implementation, and editor controls.">
                        </figure>
                        <p class="fu-portfolio-piece__lead-caption">
                            Built as a reusable WordPress component with a polished front end, thoughtful defaults,
                            and a stronger editor experience behind the scenes.
                        </p>
                    </div>

                    <div class="fu-portfolio-piece__meta fu-portfolio-piece__meta--hero-row">
                        <div class="fu-portfolio-piece__meta-item">
                            <span class="fu-portfolio-piece__meta-label">Use Case</span>
                            <span class="fu-portfolio-piece__meta-value">Hero banners, page intros, campaign headers</span>
                        </div>
                        <div class="fu-portfolio-piece__meta-item">
                            <span class="fu-portfolio-piece__meta-label">Content Model</span>
                            <span class="fu-portfolio-piece__meta-value">Media-driven layout + guided editor controls</span>
                        </div>
                        <div class="fu-portfolio-piece__meta-item">
                            <span class="fu-portfolio-piece__meta-label">Key Strength</span>
                            <span class="fu-portfolio-piece__meta-value">Editor parity with flexible presentation</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="fu-case-section">
            <div class="fu-case-section__inner container container--readable">
                <p class="fu-eyebrow">Overview</p>
                <h2 class="fu-case-section__heading fu-section-heading">A More Flexible Banner Without a Messy Editing Experience</h2>

                <div class="fu-case-section__body fu-section-body">
                    <p>
                        Hero banners often become one-off layouts that are difficult to reuse and frustrating to maintain as content needs evolve.
                    </p>

                    <p>
                        This component was designed to give editors meaningful flexibility while keeping the underlying structure consistent across different pages. The result is a banner that supports different content needs without becoming harder to maintain over time.
                    </p>
                </div>
            </div>
        </section>

        <section class="fu-portfolio-piece__demo-panel fu-page-banner-portfolio__demo-panel" id="live-demo">
            <div class="fu-portfolio-piece__demo-panel-inner container">
                <div class="fu-portfolio__hint">
                    <span>Try the live controls</span>
                </div>

                <div class="fu-page-banner-portfolio__demo-head">
                    <p class="fu-eyebrow">Live Component Preview</p>
                    <h2 class="fu-page-banner-portfolio__demo-heading">One Component. Different Content Needs.</h2>
                </div>

                <div class="fu-page-banner-portfolio__demo-note" role="note" aria-label="Demo instructions">
                    <p>
                        <strong>Try it:</strong> Open the settings button on each banner to explore the front-end
                        demo controls. These expose only a curated subset of the options available to editors
                        inside WordPress.
                    </p>
                </div>

                <div class="fu-page-banner-portfolio__demo-stage">
                    <?php the_content(); ?>
                </div>

                <p class="fu-portfolio-piece__demo-caption">
                    The same component adapts to different content needs while providing a consistent editing experience in WordPress.
                </p>
            </div>

        </section>

        <section id="design-principles" class="fu-principles">
            <div class="container container--page">
                <div class="fu-principles__inner">
                    <p class="fu-eyebrow">Design Principles</p>
                    <p class="fu-principles__lede">Every decision in this component balances editor flexibility with predictable implementation and long-term maintainability.</p>

                    <div class="fu-principles__grid">
                        <div class="fu-principles__item">
                            <h3>Controlled Flexibility</h3>
                            <p>
                                Editors can adjust layout, media, and alignment without breaking the design. Options are intentionally limited to maintain consistency across pages.
                            </p>
                        </div>

                        <div class="fu-principles__item">
                            <h3>Built-In Branding</h3>
                            <p>
                                Colors, overlays, and spacing are driven by predefined design tokens, allowing teams to match their brand without custom development.
                            </p>
                        </div>

                        <div class="fu-principles__item">
                            <h3>Reusable by Design</h3>
                            <p>
                                The same component supports multiple use cases—from high-impact video banners to simple image headers—without rebuilding layouts.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="editor-experience" class="fu-case-section">
            <div class="fu-case-section__inner container container--readable">
                <p class="fu-eyebrow">Editor Experience</p>
                <h2 class="fu-case-section__heading fu-section-heading">A Better Demo on the Front End, a Broader Toolset in the Editor</h2>

                <div class="fu-case-section__body fu-section-body">
                    <p>
                        The front-end controls on this page are included to help reviewers interact with the component, but the real value lives in the editor experience.
                    </p>
                    <p>
                        Inside Gutenberg, editors have access to a broader set of controls for media, overlays, layout, visibility, and presentation. The block is designed so the editor preview closely reflects the final front-end result, reducing guesswork and iteration.
                    </p>
                </div>
            </div>
        </section>

        <section id="implementation" class="fu-case-section">
            <div class="fu-case-section__inner container container--readable">
                <p class="fu-eyebrow">Implementation</p>
                <h2 class="fu-case-section__heading fu-section-heading">Flexible Media, Predictable Output</h2>

                <div class="fu-case-section__body fu-section-body">
                    <p>
                        The block was built with ACF Pro inside a custom WordPress theme structure that keeps markup, styles, and behavior scoped and maintainable.
                    </p>

                    <p>
                        PHP handles rendering, CSS shapes the presentation, and JavaScript supports preview parity and richer media behavior. The result is a flexible component that remains predictable across different use cases.
                    </p>
                </div>
            </div>
        </section>

        <section id="outcome" class="fu-case-section">
            <div class="fu-case-section__inner container container--readable">
                <p class="fu-eyebrow">Outcome</p>
                <h2 class="fu-case-section__heading fu-section-heading">A Reusable Hero Component for Real WordPress Builds</h2>

                <div class="fu-case-section__body fu-section-body">
                    <p>
                        This component makes it easier to reuse high-impact page headers across different types of content without rebuilding layouts each time.
                    </p>

                    <p>
                        It reduces one-off development requests while giving content teams more control over presentation, making it a practical solution for real-world WordPress builds.
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
                'current' => 'page-banner',
            )
        );
        ?>

        <section class="fu-portfolio-piece__closing">
            <div class="container container--page">
                <div class="fu-cta-panel--dark fu-portfolio-piece__closing-inner fu-cta-panel">
                    <p class="fu-eyebrow">Closing Thought</p>
                    <h2 class="fu-portfolio-piece__closing-heading">Need help implementing maintainable WordPress features?</h2>
                    <p class="fu-portfolio-piece__closing-body">
                        I help agencies and businesses build responsive, maintainable WordPress features—from reusable components and front-end implementation to ongoing improvements for existing sites.
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
