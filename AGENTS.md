# AGENTS.md — AI Coding Agent Instructions for Tim Fetter WordPress Portfolio Theme

This project is a WordPress theme focused on portable, client-ready ACF Blocks for a developer portfolio. Follow these conventions and rules to ensure consistency, maintainability, and editor/front-end parity.

## Project Structure & Conventions

- **Blocks:** Each block lives in its own folder under `blocks/`, registered via `block.json`.
- **Block Logic:** All PHP, JS, and CSS for a block must be scoped to its block folder. Do not share logic or styles between blocks unless via global utilities.
- **ACF Field Groups:** Managed with ACF JSON in `acf-json/`. Never alter field group location rules or remove field choices unless explicitly instructed. See [ACF JSON rules](#acf-json-rules).
- **Global Design Tokens:** Shared tokens and layout utilities live outside block CSS (see `css/base/`).
- **Editor/Front-End Parity:** Always keep block appearance and behavior consistent between editor and front end.

## Build & Development

- Install dependencies: `npm install`
- Develop: `npm run devFast`
- Build: `npm run build`
- See [README.md](README.md) for layout utilities and usage patterns.

## ACF JSON Rules

- Never remove or alter field group location rules unless explicitly asked.
- The parent FU Content Switcher field group must remain assigned to block `acf/fu-content-switcher`.
- The child FU Switcher Panel field group must remain assigned to block `acf/fu-switcher-panel`.
- Do not remove field choices unless explicitly asked.
- Preserve display style choices: tabs, pills, minimal, vertical.
- Preserve mobile behavior choices: accordion, stacked.
- Do not reintroduce Scroll Tabs, Short Nav Label, or use_short_nav_labels.

## CSS & Theming

- Block CSS must be scoped to the block root class (BEM-style naming).
- Use variables/tokens for theming; avoid hard-coded exceptions.
- Theme/variant classes set variables; component selectors consume them.
- Avoid `!important` and fragile selectors unless explicitly approved.
- Do not stack tab-state fixes at the bottom of the stylesheet.
- Keep editor and front end visually aligned.
- For FU Content Switcher, `content-switcher.css` is the structural baseline and `content-switcher-clean.css` is the clean visual layer loaded after it.
- Do not add or restore `content-switcher-admin.css` unless explicitly requested.
- When possible, use the same block styles for both `style` and `editorStyle` to reduce editor/front-end drift.

## FU Content Switcher Block

- Parent controls switcher-level behavior and shared presentation.
- Child panels control their own content, layout, media, and buttons.
- Panel layout belongs to each child panel, not the parent.
- Panel background is a parent-level shared control, not per-panel.
- Switcher Background and Panel Background are separate controls.
- Switcher Border Radius and Panel Border Radius are separate controls.
- Rounded Tabs only applies to Tabs display style when Panel Border Radius is not None.
- Buttons use ACF Link fields, style selects, size selects, and show/hide toggles.
- Duplicate switchers must not collide; instance IDs/hashes must be scoped per rendered switcher instance.
- Current block.json loads both `content-switcher.css` and `content-switcher-clean.css` for front end and editor.
- Do not reintroduce panel-level background controls.
- Do not reintroduce global parent `panel_layout`; panel layout belongs to child panels.

## General Guidelines

- Make small, focused edits only. Do not rewrite unrelated files.
- Do not output full files in chat unless explicitly requested.
- Link to [README.md](README.md) and docs/ for layout, grid, and block standards.
- For new blocks, follow [docs/block-standard](docs/block-standard).
- For layout utilities, see [README.md](README.md) and [docs/automatic-css-implementation](docs/automatic-css-implementation).
- For QA and review, see [docs/qc](docs/qc).
- Apply edits directly to files when requested; chat response should be a concise summary only.
- If a request involves ACF JSON, inspect the current JSON before editing and preserve existing keys unless a field is intentionally removed.
- Prefer one focused change per commit-sized task.

---

This file is for AI coding agents. Update as project conventions evolve. For questions, consult the project owner.
