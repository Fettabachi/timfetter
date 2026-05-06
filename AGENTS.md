# AGENTS.md — AI Coding Agent Instructions for Tim Fetter WordPress Portfolio Theme

This project is a WordPress theme focused on portable, client-ready ACF Blocks for a developer portfolio. Follow these conventions and rules to ensure consistency, maintainability, accessibility, and editor/front-end parity.

## Project Structure & Conventions

- **Blocks:** Each block lives in its own folder under `blocks/`, registered via `block.json`.
- **Block Logic:** All PHP, JS, and CSS for a block must be scoped to its block folder. Do not share logic or styles between blocks unless via global utilities.
- **ACF Field Groups:** Managed with ACF JSON in `acf-json/`. Never alter field group location rules or remove field choices unless explicitly instructed. See [ACF JSON rules](#acf-json-rules).
- **Global Design Tokens:** Shared tokens and layout utilities live outside block CSS (see `css/base/`).
- **Editor/Front-End Parity:** Always keep block appearance and behavior consistent between editor and front end.
- **Portability:** Blocks should be reusable across client projects and should avoid unnecessary dependencies on portfolio-only templates, styles, or demo content.

## Build & Development

- Install dependencies: `npm install`
- Develop: `npm run devFast`
- Build: `npm run build`
- See [README.md](README.md) for layout utilities and usage patterns.

## Required Working Process for AI Agents

Before editing files, inspect the relevant existing code and conventions first.

For ACF block work, review nearby or related examples, including:

- existing `blocks/*/block.json` files
- existing render templates
- block-specific CSS files
- block-specific JS files, if relevant
- shared enqueue/block registration logic
- ACF JSON field group patterns
- naming conventions
- accessibility patterns
- responsive behavior patterns

After inspecting, summarize:

1. The relevant conventions found.
2. The files that appear related to the requested task.
3. A short implementation plan.

Do not edit files until after providing the plan, unless the user explicitly asks for an immediate direct edit.

## Scope Control

- Limit changes to the requested phase or task only.
- Make small, focused, commit-sized edits.
- Do not modify unrelated blocks, shared styles, registration logic, templates, utilities, build files, or documentation unless the task explicitly requires it.
- Do not perform broad refactors unless specifically requested.
- Do not “clean up” nearby code unless it is directly necessary for the requested change.
- Do not rename files, functions, fields, handles, classes, or CSS variables unless requested or clearly necessary.
- When uncertain, prefer a smaller change and explain the uncertainty.
- Stop after completing the requested phase and summarize exactly what changed.

## ACF JSON Rules

- Never remove or alter field group location rules unless explicitly asked.
- The parent FU Content Switcher field group must remain assigned to block `acf/fu-content-switcher`.
- The child FU Switcher Panel field group must remain assigned to block `acf/fu-switcher-panel`.
- Do not remove field choices unless explicitly asked.
- Preserve display style choices: tabs, pills, minimal, vertical.
- Preserve mobile behavior choices: accordion, stacked.
- Do not reintroduce Scroll Tabs, Short Nav Label, or use_short_nav_labels.
- If a request involves ACF JSON, inspect the current JSON before editing and preserve existing keys unless a field is intentionally removed.
- Prefer adding new fields carefully with clear names, instructions, defaults, and conditional logic where useful.
- Do not regenerate entire ACF JSON files unless explicitly asked.

## ACF Block Standards

When building or modifying ACF blocks:

- Prefer structured fields over freeform markup.
- Keep editor controls guided, purposeful, and conditional where useful.
- Prioritize editor/front-end parity.
- Use semantic HTML where appropriate.
- Preserve accessibility, including keyboard behavior, screen reader text, contrast, focus states, and reduced-motion considerations.
- Use block-scoped classes and styles.
- Prefer CSS custom properties/design tokens for brand adaptability.
- Avoid hard-coding portfolio-specific colors when the block should be reusable.
- Avoid fragile JavaScript when CSS or semantic markup can solve the problem.
- Keep blocks portable and avoid unnecessary theme-context dependencies.
- Ensure multiple instances of the same block can appear on one page without ID, JS, or style collisions.
- Normalize field values in PHP where useful instead of spreading fallback logic throughout templates.
- Escape output appropriately with WordPress escaping functions.

## CSS & Theming

- Block CSS must be scoped to the block root class (BEM-style naming).
- Use variables/tokens for theming; avoid hard-coded exceptions.
- Theme/variant classes set variables; component selectors consume them.
- Prefer CSS custom properties for values a client or agency may need to rebrand.
- Avoid arbitrary editor-facing color pickers when theme tokens or controlled style variants are safer.
- Avoid `!important` and fragile selectors unless explicitly approved.
- Do not stack tab-state fixes at the bottom of the stylesheet.
- Keep editor and front end visually aligned.
- Responsive behavior should be intentional and tested at mobile, tablet, and desktop widths.
- When possible, use the same block styles for both `style` and `editorStyle` to reduce editor/front-end drift.
- For FU Content Switcher, `content-switcher.css` is the structural baseline and `content-switcher-clean.css` is the clean visual layer loaded after it.
- Do not add or restore `content-switcher-admin.css` unless explicitly requested.

## JavaScript Standards

Avoid JavaScript unless it adds necessary behavior.

If JavaScript is needed:

- Keep it scoped to the block.
- Avoid global side effects.
- Support multiple instances on one page.
- Avoid fragile DOM measurement where possible.
- Prefer CSS layout/inert/semantic behavior when it can replace measurement-heavy JS.
- Preserve keyboard and accessibility behavior.
- Account for editor and front-end contexts separately if needed.
- Do not introduce dependencies unless explicitly approved.
- Keep progressive enhancement in mind: core content should remain understandable without JavaScript where possible.

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

## New Block Development Process

For new blocks, work in phases. Do not build everything in one pass unless explicitly asked.

Recommended phases:

1. Inspect existing block architecture and summarize conventions.
2. Create the block scaffold only.
3. Add or update ACF fields.
4. Add PHP render logic.
5. Add base CSS.
6. Add responsive behavior.
7. Add optional JavaScript only if needed.
8. Review accessibility, editor parity, and portability.
9. Summarize exact changes and remaining follow-up work.

For new blocks, follow [docs/block-standard](docs/block-standard).

## Comparison Matrix Block Notes

For the planned Comparison Matrix block:

- Treat it as a general comparison block, not only a pricing table.
- It should support comparing plans, services, products, memberships, education programs, or packages.
- V1 should focus on structured content and avoid over-engineering.
- V1 may include optional static pricing per column.
- Monthly/yearly pricing toggle should be treated as a future enhancement unless explicitly requested.
- Desktop should use semantic table markup where appropriate.
- Mobile may render structured cards from the same normalized data.
- Use accessible labels for included/not included/partial/custom states.
- Do not rely on icons or color alone to communicate state.
- Use CSS variables and theme tokens so the block can adapt to client branding.
- Avoid per-cell images in V1; if images are added, prefer column-level image/icon support.
- Sticky column headers are useful but should be optional/future unless explicitly requested.

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
- After making changes, summarize exactly what changed and list files modified.
- Mention any files intentionally not modified when relevant.
- Mention follow-up work that remains.
- Do not claim tests/builds passed unless they were actually run.

## Porting Notes

- Global ACF admin UI fixes belong in a shared theme-level helper, not inside individual block folders.
- When porting ACF blocks, verify Dashicons/ACF admin icon controls render correctly.

---

This file is for AI coding agents. Update as project conventions evolve. For questions, consult the project owner.
