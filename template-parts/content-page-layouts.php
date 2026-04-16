<?php

/**
 * Template part for displaying the layouts reference page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Tim_Fetter_Portfolio
 */

$block_demo_markup = <<<'HTML'
<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
	<!-- wp:heading {"level":3} -->
	<h3 class="wp-block-heading">Actual Block Output Inside A Layout Wrapper</h3>
	<!-- /wp:heading -->

	<!-- wp:paragraph -->
	<p>This example is rendered through <code>do_blocks()</code>, so the content below is real WordPress block output rather than hand-written static HTML.</p>
	<!-- /wp:paragraph -->

	<!-- wp:list -->
	<ul>
		<li>The layout utility still controls the outer width and spacing.</li>
		<li>The block renderer still controls the inner block markup.</li>
		<li>This is the pattern to use when blocks should sit inside a shared layout wrapper.</li>
	</ul>
	<!-- /wp:list -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"vivid-cyan-blue","textColor":"white"} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-white-color has-vivid-cyan-blue-background-color has-text-color has-background wp-element-button">Primary Action</a></div>
		<!-- /wp:button -->

		<!-- wp:button {"className":"is-style-outline"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button">Secondary Action</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
HTML;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="layout-examples">
        <header class="entry-header container container--l">
            <p class="layout-examples__eyebrow">Global Layout Reference</p>
            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
            <p class="layout-examples__intro">This page shows how the shared container, content-grid, auto-grid, and split-layout utilities behave in a real theme template.</p>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <section class="container container--m layout-examples__lede">
                <div class="layout-examples__intro-card">
                    <?php the_content(); ?>

                    <nav class="layout-examples__nav" aria-label="Layouts section navigation">
                        <ul class="layout-examples__nav-list">
                            <li><a class="layout-examples__nav-link" href="#containers">Containers</a></li>
                            <li><a class="layout-examples__nav-link" href="#content-grid">Content Grid</a></li>
                            <li><a class="layout-examples__nav-link" href="#auto-grids">Auto Grids</a></li>
                            <li><a class="layout-examples__nav-link" href="#split-layouts">Split Layouts</a></li>
                            <li><a class="layout-examples__nav-link" href="#block-output">Block Output</a></li>
                        </ul>
                    </nav>
                </div>
            </section>

            <section id="containers" class="container container--xl layout-examples__section">
                <div class="layout-examples__section-head">
                    <span class="layout-examples__chip">Containers</span>
                    <h2>Centered wrappers with predictable page width</h2>
                    <p>The base <code>.container</code> handles centering and gutters. Size modifiers only change the max width.</p>
                </div>

                <div class="grid grid--gap-lg layout-examples__container-stack">
                    <div class="layout-examples__container-stage">
                        <div class="container container--s">
                            <section class="layout-examples__swatch" data-label="container--s">
                                <h3>Small Container</h3>
                                <p>Best for compact prose or narrow UI sections.</p>
                            </section>
                        </div>
                    </div>

                    <div class="layout-examples__container-stage">
                        <div class="container container--m">
                            <section class="layout-examples__swatch" data-label="container--m">
                                <h3>Medium Container</h3>
                                <p>A strong default for ordinary page sections.</p>
                            </section>
                        </div>
                    </div>

                    <div class="layout-examples__container-stage">
                        <div class="container container--l">
                            <section class="layout-examples__swatch" data-label="container--l">
                                <h3>Large Container</h3>
                                <p>Useful when content needs a bit more breadth without going edge to edge.</p>
                            </section>
                        </div>
                    </div>
                </div>
            </section>

            <section id="content-grid" class="content-grid layout-examples__section layout-examples__content-grid">
                <header class="layout-examples__section-head content--feature-max">
                    <span class="layout-examples__chip">Content Grid</span>
                    <h2>Readable by default, wider only when needed</h2>
                    <p>Every direct child lands in the content column first. Breakout classes opt specific elements into wider tracks.</p>
                </header>

                <div class="layout-examples__panel">
                    <h3>Default Content Column</h3>
                    <p>This block uses no breakout class, so it stays inside the standard readable content width defined by <code>.content-grid &gt; *</code>.</p>
                </div>

                <aside class="content--feature layout-examples__callout">
                    <h3>Feature Breakout</h3>
                    <p><code>.content--feature</code> gives a little more room for supporting callouts, side notes, or smaller media.</p>
                </aside>

                <figure class="content--feature-max layout-examples__panel">
                    <blockquote class="layout-examples__quote">
                        “Use <code>.content--feature-max</code> when a visual, pull quote, or editorial insert needs more presence without going fully edge to edge.”
                    </blockquote>
                </figure>

                <div class="content--full-safe">
                    <div class="layout-examples__strip">
                        <h3>Full Safe Breakout</h3>
                        <p><code>.content--full-safe</code> spans the full grid while preserving safe outer gutter padding.</p>
                        <div class="grid grid--gap-md grid--auto-cards">
                            <div>Edge-safe module one</div>
                            <div>Edge-safe module two</div>
                            <div>Edge-safe module three</div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="auto-grids" class="container container--xl layout-examples__section">
                <div class="layout-examples__section-head">
                    <span class="layout-examples__chip">Auto Grids</span>
                    <h2>Intrinsic repeated layouts with minimal setup</h2>
                    <p>These utilities use <code>repeat(auto-fit, minmax(...))</code> so the grid responds to available space instead of a stack of breakpoint rules.</p>
                </div>

                <div class="layout-examples__auto-group">
                    <div>
                        <h3>Auto Cards</h3>
                        <div class="grid grid--gap-md grid--auto-cards">
                            <article class="layout-examples__tile"><strong>Card One</strong>
                                <p>Balanced card grid with moderate minimum width.</p>
                            </article>
                            <article class="layout-examples__tile"><strong>Card Two</strong>
                                <p>Good default for repeated content modules.</p>
                            </article>
                            <article class="layout-examples__tile"><strong>Card Three</strong>
                                <p>Lets the layout adapt naturally to the available width.</p>
                            </article>
                            <article class="layout-examples__tile"><strong>Card Four</strong>
                                <p>Useful for index cards, summaries, or service blocks.</p>
                            </article>
                        </div>
                    </div>

                    <div>
                        <h3>Auto Wide</h3>
                        <div class="grid grid--gap-md grid--auto-wide">
                            <div class="layout-examples__tile"><strong>Wide One</strong>
                                <p>Fewer columns appear sooner because each item asks for more room.</p>
                            </div>
                            <div class="layout-examples__tile"><strong>Wide Two</strong>
                                <p>A better fit when the content inside each repeated item is denser.</p>
                            </div>
                            <div class="layout-examples__tile"><strong>Wide Three</strong>
                                <p>Still intrinsic, still breakpoint-light, just with a wider minimum.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3>Auto Tight</h3>
                        <div class="grid grid--gap-sm grid--auto-tight">
                            <div class="layout-examples__tile">Tight One</div>
                            <div class="layout-examples__tile">Tight Two</div>
                            <div class="layout-examples__tile">Tight Three</div>
                            <div class="layout-examples__tile">Tight Four</div>
                            <div class="layout-examples__tile">Tight Five</div>
                            <div class="layout-examples__tile">Tight Six</div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="split-layouts" class="container container--xl layout-examples__section">
                <div class="layout-examples__section-head">
                    <span class="layout-examples__chip">Split Layouts</span>
                    <h2>Deterministic two-column ratios without extra template logic</h2>
                    <p>Each split utility starts as a single column and steps up to a predefined ratio at larger widths.</p>
                </div>

                <div class="layout-examples__split-group">
                    <div class="grid grid--gap-lg grid--split-balanced">
                        <div class="layout-examples__split-card">
                            <h3>Balanced Split</h3>
                            <p><code>.grid--split-balanced</code> gives both sides equal weight and is ideal for simple side-by-side layouts.</p>
                        </div>
                        <div class="layout-examples__visual"></div>
                    </div>

                    <div class="grid grid--gap-lg grid--split-content">
                        <div class="layout-examples__split-card">
                            <h3>Content Split</h3>
                            <p><code>.grid--split-content</code> gives the left side more space when copy should lead and the supporting region can stay compact.</p>
                        </div>
                        <div class="layout-examples__visual"></div>
                    </div>

                    <div class="grid grid--gap-lg grid--split-media">
                        <div class="layout-examples__split-card">
                            <h3>Media Split</h3>
                            <p><code>.grid--split-media</code> gives the right side more room when the visual component is the priority.</p>
                        </div>
                        <div class="layout-examples__visual"></div>
                    </div>
                </div>
            </section>

            <section id="block-output" class="container container--xl layout-examples__section">
                <div class="layout-examples__section-head">
                    <span class="layout-examples__chip">Block Output</span>
                    <h2>Real blocks inside the layout system</h2>
                    <p>This section renders actual WordPress block markup through <code>do_blocks()</code> while the surrounding wrapper still comes from the shared layout utilities.</p>
                </div>

                <div class="layout-examples__block-stage">
                    <div class="content-grid">
                        <div class="layout-examples__block-surface">
                            <?php
                            if (function_exists('do_blocks')) {
                                echo do_blocks($block_demo_markup);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </section>

            <?php
            wp_link_pages(
                array(
                    'before' => '<div class="page-links container container--m layout-examples__page-links">' . esc_html__('Pages:', 'tim-fetter-portfolio'),
                    'after'  => '</div>',
                )
            );
            ?>
        </div><!-- .entry-content -->
    </div>
</article><!-- #post-<?php the_ID(); ?> -->