# Production deployment and rollback: 2026-09-01

## Scope

- Production: `https://www.happyfamily.co.jp/`
- WordPress path: `/www/wordpress`
- Git branch: `main`
- PHP remains 7.4.33 to match the production server.
- WordPress core, the parent theme, and plugins were updated after staging QA.
- The production child theme was changed only where required for current Lightning, VK ExUnit, and Contact Form 7 compatibility.
- No contact form submission or email delivery test was performed in production. The customer will run that test.

## Backups

- Database: `work/happy-migration/backups/20260901/production-pre-upgrade/production-pre-upgrade.sql.gz`
- Database SHA-256: `c27f90ee7d242cbee81956a008278c6439c81b5b7e8bc4418947723b18234aff`
- Files: `work/happy-migration/backups/20260901/production-pre-upgrade/files/wordpress`
- File manifest: `work/happy-migration/records/production-pre-upgrade-wordpress-manifest-20260901.json`
- Manifest SHA-256: `3439cabd55eedb1d3254b4482cee0456474f759d0052a8788c3bf2bd37ea1bc5`
- WordPress `.htaccess` SHA-256: `1b5bec28c2316a7dfb4ef28581c9e06a14a29081ddb7e52b92182413e2b0a45b`

## Versions

| Component | Before | After |
| --- | ---: | ---: |
| PHP | 7.4.33 | 7.4.33 |
| WordPress | 4.9.26 | 7.1 |
| Lightning | 5.1.2 | 15.39.1 |
| Classic Editor | 0.4 | 1.7.0 |
| Contact Form 7 | 5.0.3 | 6.1.7 |
| Custom Field Suite | 2.6 | 2.6.8-wiz.2 |
| Duplicate Post | 3.2.2 | 4.7 |
| Responsive Posts Carousel | 4.1 | 4.1-wiz.1 |
| Search Regex | 1.4.16 | 3.4.4 |
| SiteGuard WP Plugin | 1.4.3 inactive | 1.8.9 active |
| Advanced Editor Tools | 4.8.0 | 5.10.1 |
| VK All in One Expansion Unit | 6.6.4 | 9.123.0 |
| WP Multibyte Patch | 2.8.1 | 2.9.3 |
| zipaddr-jp | 1.22 | 1.45 |

Unused Akismet, All-in-One WP Migration, Hello Dolly, Lightning Advanced Unit, and Limit Login Attempts were removed. Twenty Twenty-Five 1.5 was installed as the fallback theme.

## Compatibility source

- `wp-content/plugins/custom-field-suite`: maintained CFS build that preserves the existing CFS schema and API.
- `wp-content/plugins/responsive-posts-carousel`: hardened maintenance build for the published `[wcp-carousel]` shortcodes.
- `wp-content/themes/happyfamily/extends-lightning/widget-3pr-area.php`: preserves the legacy 3PR widget ID and saved content.
- `wp-content/themes/happyfamily/functions.php`: selects Lightning Origin, preserves the legacy mobile navigation, migrates VK post-list options, and fixes asset versioning.
- `wp-content/themes/happyfamily/front-page.php`: uses the current Lightning layout API with a legacy fallback.
- `wp-content/themes/happyfamily/style.css`: stabilizes desktop submenus and centers the Contact Form 7 submit control.

## QA

- Top page, company profile, supplement index, four representative product pages, news list/detail, and contact display: HTTP 200.
- All 26 submenu destinations: HTTP 200.
- All 49 CSS, JavaScript, and image assets collected from the home/contact pages: HTTP 200.
- REST API: HTTP 200 and Site Health `good`.
- WordPress.org communication: HTTP 200 and Site Health `good`.
- Loopback home/REST: HTTP 200 and Site Health `good`.
- WP-Cron: enabled; a temporary scheduled event was created and removed successfully.
- Core/plugin/theme update checks: no pending updates.
- CFS data check: 5 groups, 157 fields, and 90 field names with stored values before and after.
- Contact Form 7 configuration is present. No POST or email was sent.
- After clearing the previous log and repeating GET-only QA, no `debug.log` or `error_log` was created. No Fatal, Warning, Deprecated, or Notice text appeared on public pages.
- The standard WordPress login URL remains available. SiteGuard login URL renaming and login alerts are disabled; login lock is enabled. The SiteGuard tables exist and `.htaccess` is unchanged.
- Temporary maintenance scripts, archives, and `.maintenance` were removed from the server.

Chrome visual automation could not be run because the ChatGPT browser extension was not installed in the available Chrome profiles. HTTP, DOM, asset, and server-log checks were completed instead.

## Residual risk

PHP 7.4 is end-of-life and no longer receives security fixes. It is also the only critical Site Health result. Plan a staging cycle for PHP 8.2 or later, then upgrade production after theme/plugin compatibility and form delivery tests pass.

## Rollback

1. Put the site into maintenance mode at the server level.
2. Restore `/www/wordpress` from `work/happy-migration/backups/20260901/production-pre-upgrade/files/wordpress`.
3. Restore the compressed database dump to the production database after verifying its SHA-256 value above.
4. Restore `/www/wordpress/.htaccess` and verify its SHA-256 value is `1b5bec28c2316a7dfb4ef28581c9e06a14a29081ddb7e52b92182413e2b0a45b`.
5. Clear server and browser caches, then verify the home page, login page, REST API, WP-Cron, and contact form display.
6. Remove maintenance mode only after the rollback QA succeeds.
