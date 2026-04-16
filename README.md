## Tim Fetter WordPress Portfolio Theme

## Installation

### Requirements

Requires the following dependencies:

- [Download and install Node.js and npm](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm)

### Setup

```sh
$ npm install
```

### To Develop

```sh
$ npm run devFast
```

### To Build(Deploy)

```sh
$ npm run build
```

### Page Banner Demo Panel

The page-banner block is the main front-end feature in this theme. A separate
demo panel is included to showcase the banner's visual states and controls in
the browser without requiring a WordPress admin walkthrough.

- Core banner rendering lives in `blocks/page-banner/`.
- The demo harness lives in `parts/demo-panel.php`, `css/demo-panel.css`, and `src/demo-panel.js`.
- The demo panel is only loaded on front-end requests where the banner is relevant.

## Global Layout System

The shared layout foundation lives in `css/base/layout.css`. It is intentionally
small and provides reusable page-width, editorial-grid, and generic grid
utilities without introducing a framework.

A live reference page template is also available in `page-layouts.php` and
rendered through `template-parts/content-page-layouts.php`. Assign the
`Layouts` template to a page in WordPress when you want a front-end reference
for the layout system.

### What It Provides

- `.container` and container size modifiers for centered wrappers
- `.content-grid` for readable default content with controlled breakout zones
- `.grid` with shared gap utilities
- intrinsic auto-grid utilities for repeated items
- split-layout utilities for simple two-column compositions

### Containers

Use `.container` for a centered wrapper with consistent side gutters. Add one
size modifier to change the maximum width.

Available classes:

- `.container`
- `.container--s`
- `.container--m`
- `.container--l`
- `.container--xl`

Example:

```html
<section class="container container--m">
	<h2>Section heading</h2>
	<p>This section is centered and capped at the medium container width.</p>
</section>
```

How it works:

- `.container` applies the shared gutter and centering behavior
- the size modifier swaps the container max-width token
- if no modifier is provided, the layout defaults to the large container width

### Content Grid And Breakouts

Use `.content-grid` when normal content should stay readable by default, but
selected children need to break wider.

Available classes:

- `.content-grid`
- `.content--feature`
- `.content--feature-max`
- `.content--full`
- `.content--full-safe`

How it works:

- every direct child defaults to the `content` column
- `.content--feature` breaks slightly wider than normal content
- `.content--feature-max` breaks wider again
- `.content--full` spans the full layout width
- `.content--full-safe` spans full width and adds gutter padding for safer edge alignment

Example:

```html
<section class="content-grid">
	<header>
		<h1>Article title</h1>
		<p>This header stays in the default readable content column.</p>
	</header>

	<figure class="content--feature">
		<img src="/path/to/image.jpg" alt="Feature image" />
	</figure>

	<div class="content--full-safe">
		<p>This spans full width while preserving outer gutter padding.</p>
	</div>
</section>
```

### Base Grid Utilities

Use `.grid` for a generic grid container, then pick a gap utility to control spacing.

Available classes:

- `.grid`
- `.grid--gap-sm`
- `.grid--gap-md`
- `.grid--gap-lg`

Example:

```html
<div class="grid grid--gap-lg">
	<div>Item one</div>
	<div>Item two</div>
	<div>Item three</div>
</div>
```

### Auto-Grid Utilities

Use the auto-grid helpers when rendering repeated items without writing explicit
breakpoint-based column rules.

Available classes:

- `.grid--auto-cards`
- `.grid--auto-wide`
- `.grid--auto-tight`

What each one means:

- `.grid--auto-cards`: balanced card grid with a moderate minimum item width
- `.grid--auto-wide`: wider minimum width so fewer columns appear sooner
- `.grid--auto-tight`: tighter minimum width so more columns can fit sooner

Examples:

```html
<div class="grid grid--gap-md grid--auto-cards">
	<article>Card one</article>
	<article>Card two</article>
	<article>Card three</article>
	<article>Card four</article>
</div>
```

```html
<div class="grid grid--gap-md grid--auto-wide">
	<div>Wider item</div>
	<div>Wider item</div>
	<div>Wider item</div>
</div>
```

```html
<div class="grid grid--gap-sm grid--auto-tight">
	<div>Tight item</div>
	<div>Tight item</div>
	<div>Tight item</div>
	<div>Tight item</div>
	<div>Tight item</div>
</div>
```

### Split Layout Utilities

Use the split utilities for deterministic two-column layouts that collapse to
one column on smaller screens.

Available classes:

- `.grid--split-balanced`
- `.grid--split-content`
- `.grid--split-media`

What each one means:

- `.grid--split-balanced`: equal columns
- `.grid--split-content`: left column gets more width
- `.grid--split-media`: right column gets more width

Example:

```html
<section class="container container--xl">
	<div class="grid grid--gap-lg grid--split-content">
		<div>
			<h2>Content-led split</h2>
			<p>The text column gets more room than the media column.</p>
		</div>
		<div>
			<img src="/path/to/image.jpg" alt="Example image" />
		</div>
	</div>
</section>
```

### Suggested Usage Pattern

In most cases:

- use `.container` for page-width wrappers
- use `.content-grid` for editorial layouts with breakout children
- use `.grid` plus an auto-grid or split-grid utility for internal layout composition

Avoid stacking layout classes with overlapping responsibilities on the same
element unless the role is clear.
