# TODO - Fix client dashboard headers button links

## Problem
On `/client/dashboard`, the sidebar header links (nav items) do not navigate/show the expected sections.

## Current Root Cause (likely)
In `resources/views/client/dashboard.blade.php` the sidebar nav items use `href="#"` with a click handler that depends on the `data-section` attribute and the JS that toggles sections.

Common failure modes:
- JS not running (missing section scripts / stack rendering)
- JS selector mismatch (nav items not present / different class)
- Another script calling `e.stopImmediatePropagation()`
- Layout not rendering the `@push('scripts')` stack

## Steps
1. Confirm `@push('scripts')` stack is rendered in `resources/views/layouts/app.blade.php`.
2. If not rendered, add `@stack('scripts')` to the layout (near `</body>`).
3. Ensure sidebar nav items have correct `data-section` values matching the section div ids.
4. If still broken, change nav links from `href="#"` to real routes (jobs/messages/profile) OR ensure `e.preventDefault()` + toggling works.
5. Run a quick browser check: open devtools console for JS errors.

