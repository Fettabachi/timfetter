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

$editor_experience_url = $resolve_portfolio_page_url('editor-experience');

if ($editor_experience_url === '') {
    $editor_experience_url = home_url('/editor-experience/');
}

$block_collection = array(
    array(
        'title' => 'Page Banner',
        'slug' => 'page-banner',
        'image' => '/uploads/2026/05/page-banner-hero-600x450.webp',
        'alt'   => 'Portfolio hero showing a flexible page banner with media and readability controls.',
        'description' => 'Media-driven page banners with image and video backgrounds, overlay controls, and editor-friendly readability settings.',
    ),
    array(
        'title' => 'Flexible Feature Section',
        'slug' => 'flexible-feature-section',
        'image' => '/uploads/2026/05/page-flexible-feature-hero-600x450.webp',
        'alt'   => 'Portfolio hero showing a flexible feature section with balanced content and media.',
        'description' => 'A reusable media and text layout for service sections, feature callouts, and content-led landing page sections.',
    ),
    array(
        'title' => 'Filtered Content Grid',
        'slug' => 'filtered-content-grid',
        'image' => '/uploads/2026/05/page-filtered-content-grid-hero-600x450.webp',
        'alt'   => 'Portfolio hero showing a filterable content grid with category and taxonomy controls.',
        'description' => 'A CPT and taxonomy-powered resource grid with smooth no-reload filtering and a structured content model.',
    ),
    array(
        'title' => 'Content Switcher',
        'slug' => 'content-switcher',
        'image' => '/uploads/2026/05/page-switcher-hero-600x450.webp',
        'alt'   => 'Portfolio hero showing a content switcher block with tabs and accessible panel navigation.',
        'description' => 'A parent/child panel system with tabs, pills, vertical layouts, mobile fallback, deep links, and keyboard support.',
    ),
    array(
        'title' => 'Comparison Cards',
        'slug' => 'comparison-cards',
        'image' => '/uploads/2026/05/page-comparison-cards-hero-600x450.webp',
        'alt'   => 'Portfolio hero showing comparison cards for plans, services, and product options.',
        'description' => 'Editor-friendly comparison cards for pricing, memberships, service tiers, and product options.',
    ),
    array(
        'title' => 'Proof Cards',
        'slug' => 'proof-cards',
        'image' => '/uploads/2026/05/page-proof-cards-hero-600x450.webp',
        'alt'   => 'Portfolio hero showing proof cards with testimonials, metrics, and credibility signals.',
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
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('fu-portfolio-piece fu-portfolio-piece--hero-media fu-acf-block-system-portfolio'); ?>>
    <div class="container">
        <div class="entry-content">

            <section class="fu-portfolio-piece__lead">
                <div class="fu-portfolio-piece__lead-inner">
                    <div class="fu-portfolio-piece__lead-copy">
                        <p class="fu-eyebrow">WordPress / ACF Block Portfolio</p>
                        <h1 class="fu-portfolio-piece__lead-heading"><?php the_title(); ?></h1>

                        <div class="fu-portfolio-piece__lead-body">
                            <p>A collection of reusable WordPress blocks built around structured content, guided editor controls, responsive layouts, accessible markup, and portable styling.</p>
                            <p>These blocks are designed to help clients and agencies build flexible pages without relying on fragile one-off templates or overwhelming editors with freeform layout decisions.</p>
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

                    <div class="fu-portfolio-piece__meta fu-portfolio-piece__meta--hero-row" aria-label="System pillars">
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
            </section>

            <section class="fu-case-section fu-system-workflow" id="system-workflow" aria-labelledby="system-workflow-heading">
                <div class="fu-case-section__inner">
                    <div class="fu-system-workflow__header">
                        <p class="fu-eyebrow">System workflow</p>
                        <h2 class="fu-section-heading fu-section-heading--compact" id="system-workflow-heading">How the system works</h2>
                        <p class="fu-section-lede">Each block connects four decisions that are often handled separately: the content model, the editor controls, the front-end output, and the way the pattern can be reused.</p>
                    </div>

                    <ol class="fu-system-workflow__panel" aria-label="Block system workflow">
                        <li class="fu-system-workflow__item">
                            <h3>Content Model</h3>
                            <p>Start with the real content shape, not just the layout.</p>
                        </li>
                        <li class="fu-system-workflow__item">
                            <h3>Editor Controls</h3>
                            <p>Map safe editing options to that content structure.</p>
                        </li>
                        <li class="fu-system-workflow__item">
                            <h3>Front-End Output</h3>
                            <p>Render the content as accessible, responsive markup.</p>
                        </li>
                        <li class="fu-system-workflow__item">
                            <h3>Reusable System</h3>
                            <p>Repeat the pattern across pages, brands, or content types.</p>
                        </li>
                    </ol>
                </div>
            </section>

            <section class="fu-system-purpose" id="why-this-system" aria-labelledby="system-purpose-heading">
                <div class="fu-system-purpose__inner">
                    <div class="fu-system-purpose__content">
                        <p class="fu-eyebrow">Why this system exists</p>
                        <h2 class="fu-section-heading fu-section-heading--feature" id="system-purpose-heading">Reusable blocks should solve editing problems, not just layout problems.</h2>
                        <p class="fu-section-lede">Clients often need flexible page sections, but the real problem is usually maintaining structure after launch. This block system gives editors safe controls for real content needs while keeping design, accessibility, and responsive behavior consistent.</p>
                        <p class="fu-section-lede">It avoids handing editors unlimited layout freedom while still giving them enough control to publish useful, on-brand pages without developer help.</p>
                    </div>

                    <div class="fu-system-purpose__principles" aria-label="System purpose principles">
                        <div class="fu-system-purpose__principle">
                            <span class="fu-system-purpose__principle-label">Content first</span>
                            <span class="fu-system-purpose__principle-text">Fields and blocks are modeled around real content decisions.</span>
                        </div>
                        <div class="fu-system-purpose__principle">
                            <span class="fu-system-purpose__principle-label">Guardrails over guesswork</span>
                            <span class="fu-system-purpose__principle-text">Editors get useful choices without being asked to rebuild layouts.</span>
                        </div>
                        <div class="fu-system-purpose__principle">
                            <span class="fu-system-purpose__principle-label">Maintainable after handoff</span>
                            <span class="fu-system-purpose__principle-text">The system is designed to stay consistent as new content is added.</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="fu-content-section" id="block-collection">
                <div class="fu-content-section__inner container container--page">
                    <div class="fu-section-head">
                        <p class="fu-eyebrow">Block Collection</p>
                        <h2 class="fu-case-section__heading fu-section-heading">The block collection</h2>
                        <div class="fu-case-section__body fu-section-body">
                            <p>Each portfolio piece focuses on a different use case, but they all share the same underlying goal: give editors a controlled system that still feels flexible in the canvas.</p>
                        </div>
                    </div>

                    <div class="fu-system-block-grid fu-work-grid" aria-label="Portfolio block examples">
                        <?php foreach ($block_collection as $block) : ?>
                            <?php $block_url = $resolve_portfolio_page_url($block['slug']); ?>
                            <?php if ($block_url !== '') : ?>
                                <a class="fu-system-block-card fu-work-card fu-work-card--linked" href="<?php echo esc_url($block_url); ?>" aria-label="View the <?php echo esc_attr($block['title']); ?> portfolio page">
                                    <div class="fu-system-block-card__media fu-work-card__media">
                                        <img
                                            src="<?php echo esc_url(wp_make_link_relative(content_url($block['image']))); ?>"
                                            alt="<?php echo esc_attr($block['alt'] ?? ''); ?>"
                                            loading="lazy"
                                            width="600"
                                            height="450">
                                    </div>
                                    <div class="fu-system-block-card__body fu-work-card__body">
                                        <p class="fu-system-block-card__kicker fu-work-card__kicker">Portfolio Piece</p>
                                        <h3 class="fu-system-block-card__title fu-work-card__title"><?php echo esc_html($block['title']); ?></h3>
                                        <p class="fu-work-card__text"><?php echo esc_html($block['description']); ?></p>
                                        <span class="fu-system-block-card__action fu-work-card__link">View case study</span>
                                    </div>
                                </a>
                            <?php else : ?>
                                <div class="fu-system-block-card fu-work-card fu-system-block-card--disabled">
                                    <div class="fu-system-block-card__media fu-work-card__media">
                                        <img
                                            src="<?php echo esc_url(content_url($block['image'])); ?>"
                                            alt="<?php echo esc_attr($block['alt'] ?? ''); ?>"
                                            loading="lazy"
                                            width="600"
                                            height="450">
                                    </div>
                                    <div class="fu-system-block-card__body fu-work-card__body">
                                        <p class="fu-system-block-card__kicker fu-work-card__kicker">Portfolio Piece</p>
                                        <h3 class="fu-system-block-card__title fu-work-card__title"><?php echo esc_html($block['title']); ?></h3>
                                        <p class="fu-work-card__text"><?php echo esc_html($block['description']); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="shared-principles">
                <div class="fu-case-section__inner">
                    <p class="fu-eyebrow">Shared Principles</p>
                    <h2 class="fu-case-section__heading fu-section-heading">Shared principles behind the system</h2>
                    <div class="fu-case-section__body fu-section-body">
                        <p>The details change from block to block, but the architecture stays consistent. These principles guide how the system is structured, edited, and maintained.</p>
                    </div>

                    <div class="fu-system-principle-groups" aria-label="Shared principles">
                        <article class="fu-system-principle-group">
                            <div class="fu-system-principle-group__header">
                                <span class="fu-system-principle-group__eyebrow">Principle group</span>
                                <h3>Content structure</h3>
                            </div>
                            <p>Blocks are modeled around real content decisions so the same pattern can be reused without becoming a loose layout builder.</p>
                            <ul>
                                <li>Structured content</li>
                                <li>Scoped, reusable data</li>
                            </ul>
                        </article>
                        <article class="fu-system-principle-group">
                            <div class="fu-system-principle-group__header">
                                <span class="fu-system-principle-group__eyebrow">Principle group</span>
                                <h3>Editor experience</h3>
                            </div>
                            <p>Controls are grouped around safe editing decisions, with previews and defaults that reduce guesswork after launch.</p>
                            <ul>
                                <li>Editor-first controls</li>
                                <li>Canvas-aware editing</li>
                                <li>Front-end/editor parity</li>
                            </ul>
                        </article>
                        <article class="fu-system-principle-group">
                            <div class="fu-system-principle-group__header">
                                <span class="fu-system-principle-group__eyebrow">Principle group</span>
                                <h3>Production quality</h3>
                            </div>
                            <p>The front-end output remains responsive, accessible, and consistent even as editors add new content.</p>
                            <ul>
                                <li>Accessible markup</li>
                                <li>Responsive by default</li>
                            </ul>
                        </article>
                    </div>
                </div>
            </section>

            <section class="fu-case-section" id="editor-experience">
                <div class="fu-case-section__inner">
                    <p class="fu-eyebrow">Editor Experience</p>
                    <h2 class="fu-case-section__heading fu-section-heading">Designed for the person editing the page after launch</h2>
                    <div class="fu-case-section__body fu-section-body">
                        <p>The system is not just about front-end polish. It is built around a manageable workflow for the editor who will keep using it after the handoff.</p>
                        <p>Parent and child blocks handle card and panel systems more cleanly than dense repeaters, guided controls replace unlimited layout freedom, canvas previews reduce guesswork, and the whole approach makes agency handoff easier.</p>
                        <p>Proof Cards is a good example: it started as a repeater because the content model looked simple, but testing showed that multiple items were painful to manage in the sidebar. The final version uses one child block per proof item.</p>
                    </div>
                </div>
            </section>

            <section class="fu-system-editor-callout" id="editor-handoff-companion" aria-labelledby="editor-callout-heading">
                <div class="fu-system-editor-callout__inner">
                    <a class="fu-system-editor-callout__card" href="<?php echo esc_url($editor_experience_url); ?>">
                        <span class="fu-system-editor-callout__card-heading">
                            <span class="fu-eyebrow fu-eyebrow--inverse">Companion piece</span>
                            <h2 id="editor-callout-heading">Built for the people who maintain the site</h2>
                        </span>
                        <span class="fu-system-editor-callout__card-body">
                            <p>The block system is designed around more than front-end output. Each block includes editing boundaries, guided controls, and reusable content patterns so clients and agencies can keep pages consistent after launch.</p>
                            <span class="fu-system-editor-callout__link">View the editor experience <span aria-hidden="true">&rarr;</span></span>
                        </span>
                    </a>
                </div>
            </section>

            <section class="fu-case-section" id="technical-approach">
                <div class="fu-case-section__inner">
                    <p class="fu-eyebrow">Technical Approach</p>
                    <h2 class="fu-case-section__heading fu-section-heading">Technical approach</h2>
                    <div class="fu-case-section__body fu-section-body">
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


            <section class="fu-case-section fu-system-value" id="client-value" aria-labelledby="system-value-heading">
                <div class="fu-case-section__inner">
                    <div class="fu-system-value__header">
                        <p class="fu-eyebrow">Client value</p>
                        <h2 class="fu-section-heading fu-section-heading--feature" id="system-value-heading">Why this matters for clients and agencies</h2>
                        <p class="fu-section-lede">Reusable blocks help clients maintain pages without losing design quality, while giving agencies a cleaner system to document, extend, and hand off.</p>
                    </div>

                    <div class="fu-system-value__grid" aria-label="Client and agency value">
                        <article class="fu-system-value__panel">
                            <h3>For clients</h3>
                            <p>Editors get useful controls without being asked to make layout decisions that should belong to the system.</p>
                            <ul>
                                <li>Update pages without rebuilding layouts</li>
                                <li>Keep content on-brand after launch</li>
                                <li>Reduce dependency on developer support</li>
                            </ul>
                        </article>

                        <article class="fu-system-value__panel">
                            <h3>For agencies</h3>
                            <p>The system creates repeatable implementation patterns that are easier to explain, maintain, and extend.</p>
                            <ul>
                                <li>Hand off clearer editing patterns</li>
                                <li>Reuse proven components across pages</li>
                                <li>Reduce long-term support friction</li>
                            </ul>
                        </article>
                    </div>
                </div>
            </section>

            <section class="fu-content-section fu-system-fit" id="use-cases" aria-labelledby="system-fit-heading">
                <div class="fu-content-section__inner container container--page">
                    <div class="fu-section-head">
                        <p class="fu-eyebrow">Common question</p>
                        <h2 class="fu-section-heading" id="system-fit-heading">Where this system fits</h2>
                        <p class="fu-section-lede">Different WordPress projects need different editing models. I work across page builders, ACF Blocks, and custom block approaches depending on how much freedom, structure, and editor engineering the project actually needs.</p>
                    </div>

                    <div class="fu-system-fit__grid" aria-label="Decision comparison for editing models">
                        <article class="fu-system-fit__card">
                            <h3>Page builders are useful when</h3>
                            <ul>
                                <li>Teams need broad visual composition tools</li>
                                <li>Designers or editors need to assemble many layout variations</li>
                                <li>Global builder components are already part of the workflow</li>
                                <li>The project accepts the platform tradeoffs</li>
                            </ul>
                        </article>

                        <article class="fu-system-fit__card">
                            <h3>ACF Blocks are useful when</h3>
                            <ul>
                                <li>The site needs reusable components without a full builder layer</li>
                                <li>Editors need guided fields and a block preview that stays close to the final page</li>
                                <li>The front-end pattern is the important part</li>
                                <li>Markup, performance, and theme control matter</li>
                                <li>The client wants fewer dependencies and less long-term lock-in</li>
                            </ul>
                        </article>

                        <article class="fu-system-fit__card">
                            <h3>Custom Gutenberg blocks are useful when</h3>
                            <ul>
                                <li>The editor UI needs custom React behavior</li>
                                <li>The block has complex state, interactions, or nested editing logic</li>
                                <li>The block belongs in a reusable plugin or product</li>
                                <li>The editing experience needs to differ significantly from standard field controls</li>
                                <li>Long-term JavaScript maintenance is part of the plan</li>
                            </ul>
                        </article>
                    </div>

                    <div class="fu-card--is-quote fu-card--is-quote-light fu-card--breakout fu-system-fit__quote">
                        <p class="fu-system-fit__quote-statement">The choice is not ACF Blocks versus Gutenberg. The choice is how much custom editor engineering the project actually needs.</p>
                    </div>
                </div>
            </section>

            <section class="fu-portfolio-piece__closing">
                <div class="fu-cta-panel--dark fu-cta-panel--dark--x fu-portfolio-piece__closing-inner fu-cta-panel">
                    <p class="fu-eyebrow">Closing Thought</p>
                    <h2 class="fu-portfolio-piece__closing-heading">Need reusable WordPress blocks built around your content model?</h2>
                    <p class="fu-portfolio-piece__closing-body">I build structured, editor-friendly WordPress components that help clients manage real content without sacrificing design quality, accessibility, or maintainability.</p>

                    <div class="fu-portfolio-piece__actions fu-cta-panel__actions">
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
