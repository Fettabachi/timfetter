<?php

/**
 * Template Name: ACF Block System Portfolio
 *
 * @package Tim_Fetter_Portfolio
 */

get_header();

$resolve_portfolio_page_url = static function ($slug) {
    $page = get_page_by_path($slug);

    return $page ? get_permalink($page) : '';
};

$block_collection = array(
    array(
        'title' => 'Page Banner',
        'slug' => 'page-banner',
        'description' => 'Media-driven page banners with image and video backgrounds, overlay controls, and editor-friendly readability settings.',
    ),
    array(
        'title' => 'Flexible Feature Section',
        'slug' => 'flexible-feature-section',
        'description' => 'A reusable media and text layout for service sections, feature callouts, and content-led landing page sections.',
    ),
    array(
        'title' => 'Filtered Content Grid',
        'slug' => 'filtered-content-grid',
        'description' => 'A CPT and taxonomy-powered resource grid with smooth no-reload filtering and a structured content model.',
    ),
    array(
        'title' => 'Content Switcher',
        'slug' => 'content-switcher',
        'description' => 'A parent/child panel system with tabs, pills, vertical layouts, mobile fallback, deep links, and keyboard support.',
    ),
    array(
        'title' => 'Comparison Cards',
        'slug' => 'comparison-cards',
        'description' => 'Editor-friendly comparison cards for pricing, memberships, service tiers, and product options.',
    ),
    array(
        'title' => 'Proof Cards',
        'slug' => 'proof-cards',
        'description' => 'Structured social proof cards for testimonials, outcomes, metrics, source details, and credibility signals.',
    ),
);

$shared_principles = array(
    array(
        'title' => 'Structured content',
        'description' => 'Fields reflect real content needs instead of turning every section into a freeform builder.',
    ),
    array(
        'title' => 'Editor-first controls',
        'description' => 'Controls are limited to choices editors can safely make without breaking the design.',
    ),
    array(
        'title' => 'Canvas-level editing',
        'description' => 'Repeatable visual items use child blocks when sidebar repeaters become cramped or confusing.',
    ),
    array(
        'title' => 'Front-end/editor parity',
        'description' => 'The editor preview should resemble the front-end result closely enough to support confident editing.',
    ),
    array(
        'title' => 'Accessible markup',
        'description' => 'Quotes, tabs, feature states, metrics, source details, and links are rendered with meaningful structure.',
    ),
    array(
        'title' => 'Responsive by default',
        'description' => 'Layouts are built with responsive CSS Grid and Flexbox patterns before adding JavaScript.',
    ),
    array(
        'title' => 'Scoped, rebrandable styles',
        'description' => 'Block-level CSS variables and global design tokens make blocks easier to move between sites.',
    ),
);

$value_cards = array(
    array(
        'title' => 'Faster page assembly',
        'description' => 'Reusable sections help teams build new pages without starting from a blank canvas each time.',
    ),
    array(
        'title' => 'Cleaner handoff',
        'description' => 'Structured blocks make it easier for agencies to hand projects off without long custom training.',
    ),
    array(
        'title' => 'Safer client editing',
        'description' => 'Guided controls reduce the chance that a content update will break layout or responsiveness.',
    ),
    array(
        'title' => 'More consistent branding',
        'description' => 'Shared spacing, type, and color tokens keep repeated sections aligned with the visual system.',
    ),
    array(
        'title' => 'Better responsive behavior',
        'description' => 'Each block is designed to hold up across desktop, tablet, and mobile without a separate rebuild.',
    ),
    array(
        'title' => 'Easier future reuse',
        'description' => 'Once a block is defined well, it can be applied to new page types with minimal rework.',
    ),
);

$acf_block_system_hero_image_url = home_url('/wp-content/uploads/2026/05/page-block-system-hero.webp');

wp_add_inline_style(
    'our-main-styles',
    <<<CSS
.fu-acf-block-system-portfolio .fu-portfolio-piece__lead-inner {
    align-items: center;
    gap: clamp(1.5rem, 3vw, 2.75rem);
}

.fu-acf-block-system-portfolio .fu-portfolio-piece__lead-copy,
.fu-acf-block-system-portfolio .fu-portfolio-piece__lead-media {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.fu-acf-block-system-portfolio .fu-portfolio-piece__lead-copy {
    max-width: 40rem;
}

.fu-acf-block-system-portfolio .fu-portfolio-piece__lead-body {
    max-width: 38rem;
}

.fu-system-hero__visual {
    width: 100%;
    display: grid;
}

.fu-system-hero__visual-caption {
    margin: 0.9rem 0 0;
    color: rgba(13, 59, 102, 0.72);
    font-size: 0.92rem;
    line-height: 1.55;
}

.fu-system-workflow {
    margin-top: clamp(2.25rem, 1.5rem + 2vw, 3.5rem);
    padding-block: clamp(2.5rem, 2rem + 2vw, 4rem);
}

.fu-system-workflow__inner {
    margin: 0 auto;
    max-width: min(100% - 2rem, 64rem);
}

.fu-system-workflow__intro {
    max-width: 52rem;
    color: rgba(13, 59, 102, 0.82);
    font-size: clamp(1rem, 0.97rem + 0.2vw, 1.08rem);
    line-height: 1.7;
}

.fu-system-workflow__grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 1rem;
    margin-top: 1.25rem;
}

.fu-system-workflow__card {
    padding: 1.15rem 1.1rem 1.2rem;
    border: 1px solid rgba(13, 59, 102, 0.1);
    border-radius: 18px;
    background: rgba(255, 255, 255, 0.9);
    box-shadow: 0 10px 22px rgba(13, 59, 102, 0.04);
}

.fu-system-workflow__number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 2.15rem;
    height: 2.15rem;
    margin-bottom: 0.8rem;
    border-radius: 999px;
    background: rgba(13, 59, 102, 0.08);
    color: var(--fu-blue, #0d3b66);
    font-size: 0.78rem;
    font-weight: 800;
    letter-spacing: 0.08em;
}

.fu-system-workflow__card h3 {
    margin: 0 0 0.35rem;
    color: var(--fu-blue, #0d3b66);
    font-size: 1.02rem;
    line-height: 1.25;
}

.fu-system-workflow__card p {
    margin: 0;
    color: rgba(13, 59, 102, 0.78);
    font-size: 0.94rem;
    line-height: 1.55;
}

.fu-acf-block-system-portfolio .fu-system-block-card {
    display: flex;
    flex-direction: column;
    color: inherit;
    text-decoration: none;
    transition: transform 0.22s ease, border-color 0.22s ease, box-shadow 0.22s ease;
}

.fu-acf-block-system-portfolio .fu-system-block-card h3 {
    color: var(--fu-blue, #0d3b66);
}

.fu-acf-block-system-portfolio .fu-system-block-card__action {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    margin-top: auto;
    padding-top: 1rem;
    color: var(--fu-blue, #0d3b66);
    font-size: 0.82rem;
    font-weight: 800;
    letter-spacing: 0.06em;
    line-height: 1.2;
    text-transform: uppercase;
}

.fu-acf-block-system-portfolio .fu-system-block-card__arrow {
    transition: transform 180ms ease;
}

.fu-acf-block-system-portfolio .fu-system-block-card:hover .fu-system-block-card__arrow,
.fu-acf-block-system-portfolio .fu-system-block-card:focus-visible .fu-system-block-card__arrow {
    transform: translateX(0.2rem);
}

.fu-acf-block-system-portfolio .fu-system-block-card:hover,
.fu-acf-block-system-portfolio .fu-system-block-card:focus-visible {
    border-color: rgba(13, 59, 102, 0.24);
    box-shadow: 0 18px 44px rgba(13, 59, 102, 0.1);
    transform: translateY(-2px);
}

.fu-acf-block-system-portfolio .fu-system-block-card:focus-visible {
    outline: 3px solid rgba(13, 59, 102, 0.3);
    outline-offset: 4px;
}

.fu-acf-block-system-portfolio .fu-system-block-card--disabled {
    cursor: default;
}

@media (max-width: 1024px) {
    .fu-acf-block-system-portfolio .fu-portfolio-piece__lead-copy,
    .fu-acf-block-system-portfolio .fu-portfolio-piece__lead-body {
        max-width: none;
    }

    .fu-system-workflow__grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 760px) {
    .fu-system-workflow__grid {
        grid-template-columns: 1fr;
    }
}
CSS
);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('fu-portfolio-piece fu-acf-block-system-portfolio'); ?>>
    <div class="container">
        <div class="entry-content">

            <section class="fu-portfolio-piece__lead">
                <div class="fu-portfolio-piece__lead-inner">
                    <div class="fu-portfolio-piece__lead-copy">
                        <p class="fu-case-section__eyebrow">WordPress / ACF Block Portfolio</p>
                        <h1 class="fu-portfolio-piece__lead-heading"><?php the_title(); ?></h1>

                        <div class="fu-portfolio-piece__lead-body">
                            <p>A collection of reusable WordPress blocks built around structured content, guided editor controls, responsive layouts, accessible markup, and portable styling.</p>
                            <p>These blocks are designed to help clients and agencies build flexible pages without relying on fragile one-off templates or overwhelming editors with freeform layout decisions.</p>
                        </div>

                        <div class="fu-portfolio-piece__meta" aria-label="System pillars">
                            <div class="fu-portfolio-piece__meta-item">
                                <span class="fu-portfolio-piece__meta-label">Content Model</span>
                                <span class="fu-portfolio-piece__meta-value">Structured ACF fields and parent/child blocks</span>
                            </div>
                            <div class="fu-portfolio-piece__meta-item">
                                <span class="fu-portfolio-piece__meta-label">Editor Experience</span>
                                <span class="fu-portfolio-piece__meta-value">Guided controls and canvas editing</span>
                            </div>
                            <div class="fu-portfolio-piece__meta-item">
                                <span class="fu-portfolio-piece__meta-label">Front-End Approach</span>
                                <span class="fu-portfolio-piece__meta-value">Responsive CSS, accessible markup, scoped styles</span>
                            </div>
                        </div>
                    </div>

                    <div class="fu-portfolio-piece__lead-media" aria-label="ACF Block System Hero Visual">
                        <div class="fu-system-hero__visual">
                            <figure class="fu-portfolio-piece__lead-figure">
                                <img src="<?php echo esc_url($acf_block_system_hero_image_url); ?>" alt="ACF block system planning notebook, WordPress implementation code, and reusable block previews.">
                            </figure>

                            <p class="fu-portfolio-piece__lead-caption">A reusable WordPress block system built around structured content, editor-safe controls, and portable front-end patterns.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="system-workflow">
                <div class="fu-case-section__inner">
                    <p class="fu-case-section__eyebrow">System Workflow</p>
                    <h2 class="fu-case-section__heading">How the system works</h2>
                    <p class="fu-case-section__body">Each block follows the same basic path: define the content model, expose safe editor controls, render accessible front-end output, and keep the pattern reusable across pages.</p>

                    <div class="fu-principles__grid fu-principles__grid--2col" aria-label="System Workflow principles">
                        <div class="fu-principles__item fu-principles__item--compact">

                            <h3><span class="fu-principles__number">1. </span>Content Model</h3>
                            <p>Structured fields define the content the page actually needs.</p>
                        </div>
                        <div class="fu-principles__item fu-principles__item--compact">

                            <h3><span class="fu-principles__number">2. </span>Editor Controls</h3>
                            <p>Guided settings give editors safe layout and style choices.</p>
                        </div>
                        <div class="fu-principles__item fu-principles__item--compact">
                            <h3><span class="fu-principles__number">3. </span>Front-End Output</h3>
                            <p>Semantic markup and responsive CSS turn those choices into stable interfaces.</p>
                        </div>
                        <div class="fu-principles__item fu-principles__item--compact">
                            <h3><span class="fu-principles__number">4. </span>Reusable System</h3>
                            <p>The same patterns can be reused across pages, brands, and site types.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="why-this-system">
                <div class="fu-case-section__inner">
                    <p class="fu-case-section__eyebrow">Why This System Exists</p>
                    <h2 class="fu-case-section__heading">Reusable blocks should solve editing problems, not just layout problems</h2>
                    <div class="fu-case-section__body">
                        <p>Clients often need flexible page sections, but too much freedom can create inconsistent layouts and difficult handoffs. This block system gives editors safe controls for real content needs while keeping design, accessibility, and responsive behavior consistent.</p>
                        <p>It avoids fragile one-off sections, avoids overly broad page-builder freedom, gives editors meaningful controls, and keeps layouts predictable after handoff.</p>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="block-collection">
                <div class="fu-case-section__inner">
                    <p class="fu-case-section__eyebrow">Block Collection</p>
                    <h2 class="fu-case-section__heading">The block collection</h2>
                    <div class="fu-case-section__body">
                        <p>Each portfolio piece focuses on a different use case, but they all share the same underlying goal: give editors a controlled system that still feels flexible in the canvas.</p>
                    </div>

                    <div class="fu-principles__grid" aria-label="Portfolio block examples">
                        <?php foreach ($block_collection as $block) : ?>
                            <?php $block_url = $resolve_portfolio_page_url($block['slug']); ?>
                            <?php if ($block_url !== '') : ?>
                                <a class="fu-principles__item fu-system-block-card" href="<?php echo esc_url($block_url); ?>" aria-label="View the <?php echo esc_attr($block['title']); ?> portfolio page">
                                    <p class="fu-case-section__eyebrow">Portfolio Piece</p>
                                    <h3><?php echo esc_html($block['title']); ?></h3>
                                    <p><?php echo esc_html($block['description']); ?></p>
                                    <span class="fu-system-block-card__action">View case study <span class="fu-system-block-card__arrow" aria-hidden="true">&rarr;</span></span>
                                </a>
                            <?php else : ?>
                                <div class="fu-principles__item fu-system-block-card fu-system-block-card--disabled">
                                    <p class="fu-case-section__eyebrow">Portfolio Piece</p>
                                    <h3><?php echo esc_html($block['title']); ?></h3>
                                    <p><?php echo esc_html($block['description']); ?></p>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="shared-principles">
                <div class="fu-case-section__inner">
                    <p class="fu-case-section__eyebrow">Shared Principles</p>
                    <h2 class="fu-case-section__heading">Shared principles behind the system</h2>
                    <div class="fu-case-section__body">
                        <p>The details change from block to block, but the architecture stays consistent. These principles guide how the system is structured, edited, and maintained.</p>
                    </div>

                    <div class="fu-principles__grid" aria-label="Shared principles">
                        <?php foreach ($shared_principles as $principle) : ?>
                            <div class="fu-principles__item">
                                <h3><?php echo esc_html($principle['title']); ?></h3>
                                <p><?php echo esc_html($principle['description']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="editor-experience">
                <div class="fu-case-section__inner">
                    <p class="fu-case-section__eyebrow">Editor Experience</p>
                    <h2 class="fu-case-section__heading">Designed for the person editing the page after launch</h2>
                    <div class="fu-case-section__body">
                        <p>The system is not just about front-end polish. It is built around a manageable workflow for the editor who will keep using it after the handoff.</p>
                        <p>Parent and child blocks handle card and panel systems more cleanly than dense repeaters, guided controls replace unlimited layout freedom, canvas previews reduce guesswork, and the whole approach makes agency handoff easier.</p>
                        <p>Proof Cards is a good example: it started as a repeater because the content model looked simple, but testing showed that multiple items were painful to manage in the sidebar. The final version uses one child block per proof item.</p>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="technical-approach">
                <div class="fu-case-section__inner">
                    <p class="fu-case-section__eyebrow">Technical Approach</p>
                    <h2 class="fu-case-section__heading">Technical approach</h2>
                    <div class="fu-case-section__body">
                        <p>The implementation stays readable for clients and agencies while still using the right WordPress primitives under the hood.</p>

                        <ul class="fu-case-section__list">
                            <li>ACF Blocks and block.json registration for reusable components.</li>
                            <li>ACF JSON field groups for structured, portable content models.</li>
                            <li>InnerBlocks for parent and child block systems where canvas editing makes sense.</li>
                            <li>Scoped block CSS and shared design tokens for maintainable styling.</li>
                            <li>Semantic markup and responsive CSS Grid for stable, accessible layouts.</li>
                            <li>JavaScript only where behavior requires it.</li>
                            <li>CPT and taxonomy integration where structured content browsing is needed.</li>
                        </ul>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="client-value">
                <div class="fu-case-section__inner">
                    <p class="fu-case-section__eyebrow">Client Value</p>
                    <h2 class="fu-case-section__heading">Why this matters for clients and agencies</h2>
                    <div class="fu-case-section__body">
                        <p>Reusable blocks help clients build and maintain pages faster while reducing design drift and developer dependency. The same patterns also give agencies a clearer foundation for future work.</p>
                    </div>

                    <div class="fu-principles__grid" aria-label="Client and agency value">
                        <?php foreach ($value_cards as $card) : ?>
                            <div class="fu-principles__item">
                                <h3><?php echo esc_html($card['title']); ?></h3>
                                <p><?php echo esc_html($card['description']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="use-cases">
                <div class="fu-case-section__inner">
                    <p class="fu-case-section__eyebrow">Use Cases</p>
                    <h2 class="fu-case-section__heading">Where this system fits</h2>
                    <div class="fu-case-section__body">
                        <ul class="fu-case-section__list">
                            <li>Service business websites</li>
                            <li>Agency-built marketing sites</li>
                            <li>Resource libraries</li>
                            <li>Landing pages</li>
                            <li>Membership and pricing pages</li>
                            <li>Case-study and testimonial sections</li>
                            <li>Content-heavy WordPress builds</li>
                        </ul>
                    </div>
                </div>
            </section>

            <section class="fu-portfolio-piece__closing">
                <div class="fu-portfolio-piece__closing-inner">
                    <p class="fu-case-section__eyebrow">Closing Thought</p>
                    <h2 class="fu-portfolio-piece__closing-heading">Need reusable WordPress blocks built around your content model?</h2>
                    <p class="fu-portfolio-piece__closing-body">I build structured, editor-friendly WordPress components that help clients manage real content without sacrificing design quality, accessibility, or maintainability.</p>

                    <div class="fu-portfolio-piece__actions">
                        <a class="fu-portfolio-piece__button fu-portfolio-piece__button--primary" href="<?php echo esc_url(home_url('/contact/')); ?>">Start a conversation</a>
                        <a class="fu-portfolio-piece__button fu-portfolio-piece__button--secondary" href="#block-collection">View individual block examples</a>
                    </div>
                </div>
            </section>

        </div>
    </div>
</article>

<?php
get_footer();
