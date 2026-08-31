# WIZ compatibility notes

This site intentionally keeps Custom Field Suite. Do not replace it with ACF or another field plugin during routine WordPress upgrades.

The `2.6.8-wiz.2` build is the maintained CFS fork used across the migration projects. It keeps the original CFS database schema, field-group behavior, API, templates, and saved values while applying current PHP, SQL, AJAX, nonce, and escaping fixes.

Before a future upgrade:

1. Back up the database and this plugin directory.
2. Confirm the five field groups and 157 field definitions before and after the change.
3. Confirm that all 90 field names with stored values remain readable.
4. Exercise CFS field editing on an approved staging page and verify frontend output.
5. Review the maintained fork diff before accepting any upstream replacement or WordPress auto-update.

`Update URI` intentionally points at the site repository so WordPress.org does not overwrite this maintenance build.

