# Tim Fetter WordPress Portfolio Theme

## Overview

This is a custom WordPress portfolio theme for Tim Fetter. It showcases WordPress and front-end implementation work, with an emphasis on reusable ACF block systems, editor-friendly handoff, front-end UI prototypes, selected contract work, and resource content.

The theme includes:

- A portfolio home page and Work archive
- Single portfolio item templates
- ACF-powered block case-study pages
- Resource CPT templates
- Self-contained front-end prototype demos
- A safe Live Portfolio System Audit demo
- Tracked source for a small supporting plugin
- Shared design tokens, layout utilities, and compiled theme assets

## Current Workflow

This repository is maintained as a theme-focused repo. Supporting plugin source is tracked under `tracked-plugins/` and manually copied/deployed to the active WordPress plugins directory when needed.

## Requirements

- WordPress
- Node.js and npm
- ACF Pro for ACF Blocks, field groups, and ACF JSON sync
- Forminator if using the current contact page form shortcode
- The Portfolio Abilities plugin for the Live Portfolio System Audit demo

Install Node.js and npm from the official npm documentation if needed:
[Download and install Node.js and npm](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm)

## Installation

Install theme dependencies from the theme directory:

```sh
npm install
```

## Development

Run the WordPress scripts development watcher:

```sh
npm run devFast
```

`devFast` currently maps to `wp-scripts start`.

## Build

Build the compiled front-end assets before deployment:

```sh
npm run build
```

The main compiled assets are written to `build/`, including:

- `build/index.js`
- `build/index.asset.php`
- `build/style-index.css`

The theme enqueues these built assets from `functions.php`. Some focused demo scripts are loaded directly from `src/` or `assets/prototypes/` when their page requires them.

## Project Structure

- `page-*.php`: custom page templates for the home page, block case studies, contact page, and portfolio feature pages.
- `archive-portfolio-items.php`: Work archive.
- `single-portfolio-items.php`: single Work/portfolio item template, including prototype case-study rendering.
- `single-resource.php`: single Resource template.
- `archive-fu_lab.php`, `single-fu_lab.php`: Component Lab templates.
- `single-fu_property.php`: Property CPT template.
- `parts/`: reusable template parts, contextual navigation, demo panels, and the Live Portfolio System Audit section.
- `parts/prototypes/`: PHP partials for embedded front-end prototype demos.
- `blocks/`: ACF block folders. Each block is registered from its own `block.json`.
- `acf-json/`: ACF JSON field group sync files.
- `inc/`: theme setup helpers, ACF block loading, CPT registration, and template helpers.
- `css/`: SCSS/CSS source, including base tokens, layout utilities, page styles, and block/demo styles.
- `src/`: main JS entry, shared modules, and focused demo scripts.
- `assets/prototypes/`: self-contained prototype CSS/JS assets.
- `build/`: compiled assets used by WordPress.
- `docs/`: project notes and standards, including block and QA guidance.
- `tracked-plugins/`: source-controlled plugin source that is deployed to WordPress' active plugins directory.

## Portfolio Page Architecture

The main portfolio surfaces are:

- `page-home.php`: home page sections, featured WordPress systems, recent work, and front-end prototype links.
- `archive-portfolio-items.php`: Work archive with featured systems, ACF block case studies, prototypes, and other portfolio work.
- `single-portfolio-items.php`: single Work item template, including ACF-driven portfolio content and embedded prototype demos.
- `page-acf-block-system.php`: ACF Block System Overview, including the Live Portfolio System Audit demo.
- `page-editor-experience.php`: Editor Experience & Handoff companion page.
- Individual block case-study templates:
  - `page-page-banner.php`
  - `page-flexible-feature-section.php`
  - `page-filtered-content-grid.php`
  - `page-content-switcher.php`
  - `page-comparison-cards.php`
  - `page-proof-cards.php`
- `single-resource.php`: Resource CPT article template with section navigation, further reading, and related resources.
- `page-contact.php`: contact page using a Forminator shortcode.

Contextual navigation for related portfolio groups lives in `parts/block-navigation.php`, `parts/wordpress-system-navigation.php`, `parts/prototype-navigation.php`, and `parts/contract-work-navigation.php`.

## ACF Block And Case-Study System

The theme showcases reusable ACF-powered WordPress block concepts and related case-study pages. Blocks are registered automatically from `blocks/*/block.json` by `inc/acf-block-loader.php`, and field groups are synced through `acf-json/`.

Current block and case-study concepts include:

- Page Banner
- Flexible Feature Section
- Filtered Content Grid
- Content Switcher
- Comparison Cards
- Proof Cards

Block folders should remain portable: keep block PHP, JS, CSS, and configuration scoped to the relevant `blocks/` folder unless a shared global utility is intentionally needed.

## Demo Panels

Several case-study pages include front-end demo panels so behavior can be shown without requiring a WordPress admin walkthrough.

- Page Banner demo partial: `parts/demo-panel.php`
- Content Switcher demo partial: `parts/demo-panel-content-switcher.php`
- Comparison Cards demo partial: `parts/demo-panel-comparison-cards.php`
- Shared demo CSS: `css/blocks/demo-panel.css`
- Demo scripts: `src/blocks/`

These demos are one part of the broader portfolio, not the main feature of the entire theme.

## Front-End Prototypes

The theme includes isolated front-end UI prototype demos presented inside portfolio items. They are intentionally lightweight HTML, CSS, and JavaScript prototypes, not production WordPress blocks or plugins.

Current prototypes include:

- Client Project Timeline
- Project Scope Estimator
- Content Approval Checklist

Prototype partials live in `parts/prototypes/`. Prototype CSS and JS assets live in `assets/prototypes/` and are conditionally enqueued in `functions.php` for matching `portfolio-items` slugs.

## Live Portfolio System Audit

The Live Portfolio System Audit is a safe, read-only public demo on the ACF Block System Overview page.

This demo shows how a WordPress site can safely explain maintenance checks without exposing private site details. Public visitors see what the checks are designed to evaluate; authorized editors can see live results and fix guidance.

The front end lives in:

- `parts/portfolio-system-audit-demo.php`
- `src/portfolio-system-audit.js`
- `.fu-portfolio-audit` styles in `css/pages/portfolio-pages.scss`

The audit data comes from a controlled REST endpoint:

- `/wp-json/timfetter/v1/portfolio-system-audit`

The supporting plugin is designed to register a WordPress Abilities API ability when the current WordPress install supports it, while still using a controlled REST endpoint as the front-end contract.

Public visitors must not see live issue counts, failing counts, item titles, media filenames, raw URLs, admin links, user data, draft/private content, or file paths. Authorized editors can see live results, issue counts, recommended fixes, and edit links.

## Tracked Plugins

The Portfolio Abilities plugin source is tracked in this theme repo at:

```text
tracked-plugins/timfetter-portfolio-abilities/
```

The active WordPress plugin must be copied or deployed to:

```text
wp-content/plugins/timfetter-portfolio-abilities/
```

This workflow intentionally keeps the theme repository root as-is. Treat `tracked-plugins/timfetter-portfolio-abilities/` as the source-controlled copy, and deploy/copy it to the active plugins directory whenever the plugin changes. When editing the Portfolio Abilities plugin, make changes in `tracked-plugins/timfetter-portfolio-abilities/` first, then copy those changes to the active WordPress plugin directory for local testing.

## Global Layout System

The shared layout foundation lives in `css/base/layout.css`. It provides reusable page-width, editorial-grid, and generic grid utilities without introducing a layout framework.

A live layout reference template is available in `page-layouts.php` and rendered through `template-parts/content-page-layouts.php`. Assign the `Layouts` template to a page in WordPress when you want a front-end reference for the layout system.

### What It Provides

- `.container` and container size modifiers for centered wrappers
- `.content-grid` for readable default content with controlled breakout zones
- `.grid` with shared gap utilities
- intrinsic auto-grid utilities for repeated items
- split-layout utilities for simple two-column compositions

### Containers

Use `.container` for a centered wrapper with consistent side gutters. Add one size modifier to change the maximum width.

Available classes:

- `.container`
- `.container--s`
- `.container--readable`
- `.container--m`
- `.container--page`
- `.container--l`
- `.container--xl`

How it works:

- `.container` applies the shared gutter and centering behavior.
- Size modifiers swap the `--fu-container-max` token.
- If no modifier is provided, the layout defaults to the large container width.
- Use `.container--readable` for narrower reading surfaces.
- Use `.container--page` for wider portfolio and page-level sections.

Example:

```html
<section class="container container--page">
	<h2>Section heading</h2>
	<p>This section is centered and capped at the page container width.</p>
</section>
```

### Content Grid And Breakouts

Use `.content-grid` when normal content should stay readable by default, but selected children need to break wider.

Available classes:

- `.content-grid`
- `.content--feature`
- `.content--feature-max`
- `.content--full`
- `.content--full-safe`

How it works:

- Every direct child defaults to the `content` column.
- `.content--feature` breaks slightly wider than normal content.
- `.content--feature-max` breaks wider again.
- `.content--full` spans the full layout width.
- `.content--full-safe` spans full width and adds gutter padding for safer edge alignment.

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

Use the auto-grid helpers when rendering repeated items without writing explicit breakpoint-based column rules.

Available classes:

- `.grid--auto-cards`
- `.grid--auto-wide`
- `.grid--auto-tight`

What each one means:

- `.grid--auto-cards`: balanced card grid with a moderate minimum item width
- `.grid--auto-wide`: wider minimum width so fewer columns appear sooner
- `.grid--auto-tight`: tighter minimum width so more columns can fit sooner

Example:

```html
<div class="grid grid--gap-md grid--auto-cards">
	<article>Card one</article>
	<article>Card two</article>
	<article>Card three</article>
	<article>Card four</article>
</div>
```

### Split Layout Utilities

Use the split utilities for deterministic two-column layouts that collapse to one column on smaller screens.

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

- Use `.container` for page-width wrappers.
- Use `.content-grid` for editorial layouts with breakout children.
- Use `.grid` plus an auto-grid or split-grid utility for internal layout composition.

Avoid stacking layout classes with overlapping responsibilities on the same element unless the role is clear.

## Design Tokens

Theme-level design tokens are used for brand color, spacing, container widths, inverse surfaces, focus rings, button states, and gradients. Core token sources live in `css/base/variables-fu.scss`, `css/base/variables.scss`, and `css/base/layout.css`.

Important tokens include:

- `--fu-blue`
- `--fu-orange`
- `--fu-yellow`
- `--fu-beige`
- `--fu-white`
- `--fu-black`
- `--fu-gradient-lux`
- `--fu-container-page`
- `--fu-container-readable`

Prefer existing tokens and utilities before introducing one-off values.

## Deployment Notes

- Run `npm run build` before deployment.
- Confirm compiled assets in `build/` are committed when asset changes are part of the work.
- Deploy or copy `tracked-plugins/timfetter-portfolio-abilities/` to `wp-content/plugins/timfetter-portfolio-abilities/` if the Portfolio Abilities plugin changed.
- Confirm ACF JSON changes in `acf-json/` are intentional before committing.
- Avoid committing local-only files, database exports, uploads, or environment-specific configuration unless that is already part of the project workflow.

## Validation Checklist

Before shipping meaningful changes:

- Run `npm run build`.
- Check the home page, Work archive, key portfolio pages, and resource pages.
- Check front-end prototype pages at desktop and mobile widths.
- Check the logged-out Live Portfolio System Audit demo.
- Check the logged-in audit demo as an admin/editor.
- Confirm public audit responses do not expose live issue details.
- Confirm there are no hard-coded local URLs in public content.
- Confirm responsive layouts hold up across mobile, tablet, and desktop.
