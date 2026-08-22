# Tim Fetter WordPress Portfolio Theme

## Overview

This is a custom WordPress portfolio theme for Tim Fetter. It showcases WordPress and front-end implementation work, with an emphasis on reusable ACF block systems, editor-friendly handoff, front-end UI prototypes, selected contract work, and resource content.

The theme includes:

- A portfolio home page and Work archive
- Single portfolio item templates
- ACF-powered block case-study pages
- Resource CPT templates
- Self-contained front-end prototype demos
- Shared design tokens, layout utilities, and compiled theme assets

## Current Workflow

This repository is maintained as a theme-focused repo. Most work happens in theme templates, ACF block folders, ACF JSON field groups, page-specific styles, and focused front-end demo assets.

## Requirements

- WordPress
- Node.js and npm
- ACF Pro for ACF Blocks, field groups, and ACF JSON sync
- Forminator if using the current contact page form shortcode

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
npm run start
```

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

## Link Checking

Run the local link checker when the Local site is running at `http://tim-fetter.local`:

```sh
npm run check:links
```

The command skips common WordPress admin, feed, oEmbed, phone, mail, and placeholder URLs.

## Project Structure

- `page-*.php`: custom page templates for the home page, block case studies, contact page, and portfolio feature pages.
- `archive-portfolio-items.php`: Work archive.
- `single-portfolio-items.php`: single Work/portfolio item template, including prototype case-study rendering.
- `single-resource.php`: single Resource template.
- `archive-fu_lab.php`, `single-fu_lab.php`: Component Lab templates.
- `single-fu_property.php`: Property CPT template.
- `parts/`: reusable template parts, contextual navigation, and demo panels.
- `parts/prototypes/`: PHP partials for embedded front-end prototype demos.
- `blocks/`: ACF block folders. Each block is registered from its own `block.json`.
- `acf-json/`: ACF JSON field group sync files.
- `inc/`: theme setup helpers, ACF block loading, CPT registration, and template helpers.
- `css/`: SCSS/CSS source, including base tokens, layout utilities, page styles, and block/demo styles.
- `src/`: main JS entry, shared modules, and focused demo scripts.
- `assets/prototypes/`: self-contained prototype CSS/JS assets.
- `build/`: compiled assets used by WordPress.
- `docs/`: project notes and standards, including block and QA guidance.

## Portfolio Page Architecture

The main portfolio surfaces are:

- `page-home.php`: home page sections, featured WordPress systems, recent work, and front-end prototype links.
- `archive-portfolio-items.php`: Work archive with featured systems, ACF block case studies, prototypes, and other portfolio work.
- `single-portfolio-items.php`: single Work item template, including ACF-driven portfolio content and embedded prototype demos.
- `page-acf-block-system.php`: ACF Block System Overview.
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

## Layout Utilities

Theme templates use shared layout utilities for consistent page width and readable content measures. The active container scale lives in `css/base/layout.css`.

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

## Design Tokens

Theme-level design tokens are used for brand color, spacing, container widths, surfaces, focus rings, button states, and gradients. Core token sources live in `css/base/variables-fu.scss`, `css/base/variables.scss`, and `css/base/layout.css`.

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
- Confirm ACF JSON changes in `acf-json/` are intentional before committing.
- Avoid committing local-only files, database exports, uploads, or environment-specific configuration unless that is already part of the project workflow.

The guarded SiteGround deployment helper previews changes by default:

```text
./deploy.sh
```

Copy `.deploy-config.example` to `.deploy-config` and enter the SiteGround SSH details. The local configuration is ignored by Git. After running the build and reviewing the preview, deploy the same theme files with:

```text
./deploy.sh --apply
```

The script deploys only from a clean `master` branch that matches GitHub. It never deploys the WordPress database, uploads, plugins, or WordPress core.

## Validation Checklist

Before shipping meaningful changes:

- Run `npm run build`.
- Run `npm run check:links` when the local site is running.
- Check the home page, Work archive, key portfolio pages, and resource pages.
- Check front-end prototype pages at desktop and mobile widths.
- Confirm there are no hard-coded local URLs in public content.
- Confirm responsive layouts hold up across mobile, tablet, and desktop.
