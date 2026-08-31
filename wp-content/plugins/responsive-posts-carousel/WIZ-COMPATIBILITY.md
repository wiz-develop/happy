# WIZ compatibility notes

Responsive Posts Carousel 4.1 is retained because `[wcp-carousel]` is used by published product pages. Version `4.1-wiz.1` preserves the existing shortcode, custom post type, post meta, templates, CSS classes, and frontend assets.

The maintenance patch adds:

- administrator/editor capability checks for management AJAX actions;
- AJAX nonces for both the legacy and current management screens;
- recursive input sanitization before option and post-meta writes;
- escaping for AJAX-generated option markup;
- safe handling for missing carousel metadata;
- correction of the undefined `$words` variable in custom-field output;
- an `Update URI` header so an unrelated package cannot overwrite the build.

Before a future upgrade, compare the upstream AJAX handlers and shortcode rendering with this build, then verify at least one page from `records/staging-carousel-pages-20260831.tsv` at desktop and mobile widths.
