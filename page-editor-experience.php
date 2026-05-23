<?php

/**
 * Template Name: Editor Experience & Handoff Portfolio
 *
 * @package Tim_Fetter_Portfolio
 */

get_header();

$resolve_portfolio_page_url = static function ($slug) {
    $page = get_page_by_path($slug);

    return $page ? get_permalink($page) : '';
};

$acf_block_system_url = $resolve_portfolio_page_url('acf-block-system');
$page_banner_url = $resolve_portfolio_page_url('page-banner');
$content_switcher_url = $resolve_portfolio_page_url('content-switcher');
$comparison_cards_url = $resolve_portfolio_page_url('comparison-cards');
$proof_cards_url = $resolve_portfolio_page_url('proof-cards');
$portfolio_url = $resolve_portfolio_page_url('portfolio');

if ($portfolio_url === '') {
    $portfolio_url = home_url('/portfolio/');
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('fu-portfolio-piece fu-portfolio-piece--hero-media fu-editor-experience'); ?>>
    <div class="container">
        <div class="entry-content">

            <section class="fu-portfolio-piece__lead">
                <div class="fu-portfolio-piece__lead-inner">
                    <div class="fu-portfolio-piece__lead-copy">
                        <p class="fu-eyebrow">ACF Block System</p>
                        <h1 class="fu-portfolio-piece__lead-heading">Editor Experience &amp; Handoff</h1>

                        <div class="fu-portfolio-piece__lead-body">
                            <p>Reusable WordPress blocks are only successful if the next person can update them confidently. This showcase explains how each block is structured to give editors useful control while protecting layout, accessibility, and design consistency.</p>
                        </div>

                    </div>

                    <div class="fu-portfolio-piece__lead-media" aria-label="Editor Experience &amp; Handoff visual">
                        <figure class="fu-portfolio-piece__lead-figure">
                            <img
                                src="<?php echo esc_url(content_url('/uploads/2026/05/page-editor-experience-handoff-hero.webp')); ?>"
                                alt="Polished editor-to-front-end montage showing structured block controls, reusable content, protected layout settings, and a matching front-end preview."
                                loading="eager"
                                decoding="async" />
                        </figure>

                        <p class="fu-portfolio-piece__lead-caption">A visual overview of the block editing experience: guided controls, structured content, protected layout decisions, and the front-end result they support.</p>
                    </div>

                    <div class="fu-portfolio-piece__meta fu-portfolio-piece__meta--hero-row" aria-label="Editor experience summary">
                        <div class="fu-portfolio-piece__meta-item">
                            <span class="fu-portfolio-piece__meta-label">Guided Controls</span>
                            <span class="fu-portfolio-piece__meta-value">Editors get meaningful choices without needing to understand the code behind the layout.</span>
                        </div>
                        <div class="fu-portfolio-piece__meta-item">
                            <span class="fu-portfolio-piece__meta-label">Structured Content</span>
                            <span class="fu-portfolio-piece__meta-value">Blocks are modeled around real content patterns, not just visual sections on a page.</span>
                        </div>
                        <div class="fu-portfolio-piece__meta-item">
                            <span class="fu-portfolio-piece__meta-label">Safer Handoff</span>
                            <span class="fu-portfolio-piece__meta-value">Design, accessibility, and responsive behavior stay protected as content changes over time.</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="handoff-test">
                <div class="fu-case-section__inner">
                    <h2 class="fu-case-section__heading fu-section-heading">The real test starts after launch</h2>

                    <div class="fu-case-section__body fu-section-body">
                        <p>Many WordPress projects look polished on launch day, but become difficult to maintain once editors start adding new content, swapping media, or building new pages. The editing experience matters because it determines whether the site can keep its structure and design quality after handoff.</p>

                        <p>These blocks are designed so editors can update meaningful content without being handed enough control to accidentally break the system.</p>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="safe-change-boundaries">
                <div class="fu-case-section__inner">
                    <h2 class="fu-case-section__heading fu-section-heading">What editors can safely change</h2>

                    <div class="fu-editor-experience__handoff-grid">
                        <div class="fu-editor-experience__handoff-card">
                            <h3>What editors can safely change</h3>
                            <ul class="fu-case-section__list">
                                <li>Headings, body copy, and calls to action</li>
                                <li>Images, video, and supporting media</li>
                                <li>Card order and repeated content</li>
                                <li>Background style options</li>
                                <li>Visibility toggles</li>
                                <li>Links, labels, and source details</li>
                            </ul>
                        </div>

                        <div class="fu-editor-experience__handoff-card fu-editor-experience__handoff-card--protects">
                            <h3>What the system protects</h3>
                            <ul class="fu-case-section__list">
                                <li>Responsive layout behavior</li>
                                <li>Spacing and visual rhythm</li>
                                <li>Accessibility states and keyboard behavior</li>
                                <li>Grid structure</li>
                                <li>Design tokens and brand consistency</li>
                                <li>Markup patterns and reusable component structure</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="editing-model">
                <div class="fu-case-section__inner">
                    <h2 class="fu-case-section__heading fu-section-heading">The editing model depends on the content</h2>

                    <div class="fu-case-section__body fu-section-body">
                        <p>Some blocks only need a focused set of fields. Others work better when each item becomes its own child block. The goal is to choose the editing model that makes future updates clearer, safer, and easier to maintain.</p>
                    </div>

                    <div class="fu-card--is-quote">
                        <p class="fu-editor-experience__model-statement">I choose the editing model based on how someone will maintain the content later, not just how the front end looks.</p>
                    </div>

                    <div class="fu-editor-experience__model-grid" aria-label="Editing model options">
                        <article class="fu-editor-experience__model-card">
                            <span class="fu-editor-experience__model-kicker">Focused control</span>
                            <h3>Focused field controls</h3>
                            <dl class="fu-editor-experience__model-list">
                                <div class="fu-editor-experience__model-row">
                                    <dt>Best for</dt>
                                    <dd>One clear section with predictable content.</dd>
                                </div>
                                <div class="fu-editor-experience__model-row">
                                    <dt>Example blocks</dt>
                                    <dd>Page Banner, Flexible Feature Section.</dd>
                                </div>
                                <div class="fu-editor-experience__model-row">
                                    <dt>Why it works</dt>
                                    <dd>Editors can adjust meaningful options without rebuilding the layout.</dd>
                                </div>
                            </dl>
                        </article>

                        <article class="fu-editor-experience__model-card">
                            <span class="fu-editor-experience__model-kicker">Simple lists</span>
                            <h3>Simple repeatable content</h3>
                            <dl class="fu-editor-experience__model-list">
                                <div class="fu-editor-experience__model-row">
                                    <dt>Best for</dt>
                                    <dd>Small sets of similar items.</dd>
                                </div>
                                <div class="fu-editor-experience__model-row">
                                    <dt>Example use</dt>
                                    <dd>Short lists, logos, or compact supporting details.</dd>
                                </div>
                                <div class="fu-editor-experience__model-row">
                                    <dt>Why it works</dt>
                                    <dd>Repeated content stays grouped when each item does not need its own complex editing surface.</dd>
                                </div>
                            </dl>
                        </article>

                        <article class="fu-editor-experience__model-card">
                            <span class="fu-editor-experience__model-kicker">Structured items</span>
                            <h3>Parent and child blocks</h3>
                            <dl class="fu-editor-experience__model-list">
                                <div class="fu-editor-experience__model-row">
                                    <dt>Best for</dt>
                                    <dd>Complex repeatable content where each item has its own structure.</dd>
                                </div>
                                <div class="fu-editor-experience__model-row">
                                    <dt>Example blocks</dt>
                                    <dd>Content Switcher, Comparison Cards, Proof Cards.</dd>
                                </div>
                                <div class="fu-editor-experience__model-row">
                                    <dt>Why it works</dt>
                                    <dd>Each panel or card becomes a real editable unit that can be reordered, previewed, and maintained more clearly.</dd>
                                </div>
                            </dl>
                        </article>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="example-blocks">
                <div class="fu-case-section__inner">
                    <h2 class="fu-case-section__heading fu-section-heading">Examples from the block system</h2>

                    <div class="fu-editor-experience__examples-grid" aria-label="Example block cards">
                        <a class="fu-editor-experience__example-card" href="<?php echo esc_url($page_banner_url !== '' ? $page_banner_url : home_url('/page-banner/')); ?>" aria-label="View case study: Page Banner">
                            <span class="fu-editor-experience__example-kicker">Guided field controls</span>
                            <h3 class="fu-editor-experience__example-title">Page Banner</h3>
                            <p>Editors can adjust media, overlay, alignment, and visibility options while the block protects readability and responsive behavior.</p>
                            <span class="fu-editor-experience__example-link">View case study <span class="fu-editor-experience__example-arrow" aria-hidden="true">&rarr;</span></span>
                        </a>

                        <a class="fu-editor-experience__example-card" href="<?php echo esc_url($content_switcher_url !== '' ? $content_switcher_url : home_url('/content-switcher/')); ?>" aria-label="View case study: Content Switcher">
                            <span class="fu-editor-experience__example-kicker">Parent/child blocks</span>
                            <h3 class="fu-editor-experience__example-title">Content Switcher</h3>
                            <p>Editors manage structured panels while the block handles tab behavior, deep links, keyboard support, and mobile fallback.</p>
                            <span class="fu-editor-experience__example-link">View case study <span class="fu-editor-experience__example-arrow" aria-hidden="true">&rarr;</span></span>
                        </a>

                        <a class="fu-editor-experience__example-card" href="<?php echo esc_url($comparison_cards_url !== '' ? $comparison_cards_url : home_url('/comparison-cards/')); ?>" aria-label="View case study: Comparison Cards">
                            <span class="fu-editor-experience__example-kicker">Parent/child blocks</span>
                            <h3 class="fu-editor-experience__example-title">Comparison Cards</h3>
                            <p>Editors manage individual comparison cards, optional pricing, and grouped features while the layout remains consistent.</p>
                            <span class="fu-editor-experience__example-link">View case study <span class="fu-editor-experience__example-arrow" aria-hidden="true">&rarr;</span></span>
                        </a>

                        <a class="fu-editor-experience__example-card" href="<?php echo esc_url($proof_cards_url !== '' ? $proof_cards_url : home_url('/proof-cards/')); ?>" aria-label="View case study: Proof Cards">
                            <span class="fu-editor-experience__example-kicker">Parent/child blocks</span>
                            <h3 class="fu-editor-experience__example-title">Proof Cards</h3>
                            <p>Editors manage testimonials, results, metrics, source details, and optional media without inventing a new layout each time.</p>
                            <span class="fu-editor-experience__example-link">View case study <span class="fu-editor-experience__example-arrow" aria-hidden="true">&rarr;</span></span>
                        </a>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="handoff-value">
                <div class="fu-case-section__inner">
                    <h2 class="fu-case-section__heading fu-section-heading">Built for the next person who edits the page</h2>

                    <div class="fu-case-section__body fu-section-body">
                        <p>A clean front end is only one part of the job. These blocks are designed so agencies and clients can hand off pages with clear editing boundaries, reusable content patterns, and fewer opportunities for accidental layout damage.</p>
                    </div>

                    <div class="fu-editor-experience__value-grid" aria-label="Handoff value points">
                        <article class="fu-editor-experience__value-card">
                            <span class="fu-editor-experience__value-badge" aria-hidden="true">
                                <svg class="fu-editor-experience__value-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10" />
                                    <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76" />
                                </svg>
                            </span>
                            <h3>Less guesswork</h3>
                            <p>Editors can make changes confidently because controls are organized around real content decisions.</p>
                        </article>
                        <article class="fu-editor-experience__value-card">
                            <span class="fu-editor-experience__value-badge" aria-hidden="true">
                                <svg class="fu-editor-experience__value-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                </svg>
                            </span>
                            <h3>Fewer broken layouts</h3>
                            <p>Spacing, responsive behavior, and component structure stay protected as pages evolve.</p>
                        </article>
                        <article class="fu-editor-experience__value-card">
                            <span class="fu-editor-experience__value-badge" aria-hidden="true">
                                <svg class="fu-editor-experience__value-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
                                </svg>
                            </span>
                            <h3>Faster content updates</h3>
                            <p>Reusable blocks reduce the effort needed to launch new sections or refresh existing content.</p>
                        </article>
                        <article class="fu-editor-experience__value-card">
                            <span class="fu-editor-experience__value-badge" aria-hidden="true">
                                <svg class="fu-editor-experience__value-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <polyline points="17 1 21 5 17 9" />
                                    <path d="M3 11V9a4 4 0 0 1 4-4h14" />
                                    <polyline points="7 23 3 19 7 15" />
                                    <path d="M21 13v2a4 4 0 0 1-4 4H3" />
                                </svg>
                            </span>
                            <h3>Cleaner agency handoff</h3>
                            <p>The editing experience is easier to explain because the system guides what can and cannot change.</p>
                        </article>
                        <article class="fu-editor-experience__value-card">
                            <span class="fu-editor-experience__value-badge" aria-hidden="true">
                                <svg class="fu-editor-experience__value-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <polygon points="12 2 2 7 12 12 22 7 12 2" />
                                    <polyline points="2 17 12 22 22 17" />
                                    <polyline points="2 12 12 17 22 12" />
                                </svg>
                            </span>
                            <h3>Reusable patterns</h3>
                            <p>Content teams can build new pages from proven block patterns instead of reinventing layouts each time.</p>
                        </article>
                        <article class="fu-editor-experience__value-card">
                            <span class="fu-editor-experience__value-badge" aria-hidden="true">
                                <svg class="fu-editor-experience__value-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                    <polyline points="22 4 12 14.01 9 11.01" />
                                </svg>
                            </span>
                            <h3>Design consistency over time</h3>
                            <p>The system helps teams preserve branding and visual quality long after the initial launch.</p>
                        </article>
                    </div>
                </div>
            </section>

            <section class="fu-portfolio-piece__closing" id="editor-experience-cta">
                <div class="fu-cta-panel--dark fu-portfolio-piece__closing-inner fu-cta-panel">
                    <h2 class="fu-portfolio-piece__closing-heading">A block system that lasts beyond launch</h2>
                    <p class="fu-portfolio-piece__closing-body">The same structure that makes these blocks reusable also makes them easier to hand off, document, and extend.</p>

                    <div class="fu-portfolio-piece__actions fu-cta-panel__actions">
                        <?php if ($acf_block_system_url !== '') : ?>
                            <a class="fu-portfolio-piece__button fu-portfolio-piece__button--primary" href="<?php echo esc_url($acf_block_system_url); ?>">View the ACF Block System</a>
                        <?php endif; ?>
                        <a class="fu-portfolio-piece__button fu-portfolio-piece__button--secondary" href="<?php echo esc_url($portfolio_url); ?>">Explore the block case studies</a>
                    </div>
                </div>
            </section>

        </div>
    </div>
</article>

<?php
get_footer();
