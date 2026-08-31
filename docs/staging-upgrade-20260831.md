# Staging upgrade: 2026-08-31

## Result

`http://happyfamily.3d-showcase.net/` was copied to `https://happy.wiz-services.com/` as an independent staging environment. Production was not modified.

| Component | Before | After |
| --- | ---: | ---: |
| PHP | 7.0.32 | 7.4.33 |
| WordPress | 5.2.21 | 7.1 |
| MySQL-compatible server | 5.6.42 | 8.4.8 |
| Lightning parent theme | 5.1.2 | 15.39.0 |
| Happy Family child theme | 1.0.0 | 1.0.0 plus compatibility fix |

## Active plugins

| Plugin | Before | After | Treatment |
| --- | ---: | ---: | --- |
| Classic Editor | 1.5 | 1.7.0 | Official update |
| Contact Form 7 | 5.0.3 | 6.1.7 | Official PHP 7.4-compatible update |
| Custom Field Suite | 2.6 | 2.6.8-wiz.2 | Maintained CFS fork; not replaced |
| Yoast Duplicate Post | 3.2.2 | 4.7 | Official update |
| Responsive Posts Carousel | 4.1 | 4.1-wiz.1 | Retained and security-patched |
| SiteGuard WP Plugin | 1.5.0 | 1.8.9 | Official update |
| Advanced Editor Tools | 4.8.0 | 5.10.1 | Official update |
| VK All in One Expansion Unit | 6.6.4 | 9.123.0 | Official update |
| WP Multibyte Patch | 2.8.1 | 2.9.3 | Official update |
| zipaddr-jp | 1.22 | 1.45 | Official update |

## Compatibility and security work

- Kept Custom Field Suite and deployed the maintained `2.6.8-wiz.2` build. All 5 field groups, 157 fields, and 90 field names with stored values remain readable.
- Reworked the child theme's legacy 3PR widget so it no longer extends a removed VK ExUnit class at file-load time. Existing widget ID, saved options, and frontend output are retained.
- Registered the child 3PR widget before WordPress builds frontend widget callbacks, restoring the production image/title/summary order and removing the update-added `Read more` links.
- Added a one-time-compatible VK ExUnit post-list option migration so the legacy `label` and scalar `post_type` values continue to render `新着情報` under current plugin releases.
- Kept Lightning 15.39.0 on its bundled legacy `Origin` skin because the Happy Family child theme uses Bootstrap 3 markup. The child theme now preserves the saved right-side menu button, uses Lightning's current one-column layout API, and suppresses Lightning's duplicate modern mobile navigation.
- Stabilized the desktop submenu hit area by anchoring it directly below each parent item and using the same visible state for hover and keyboard focus.
- Aligned the staging top-page contact/link row and visible navigation labels/order with production. The one missing top-page member banner was restored from the production file backup and is served locally by staging.
- Patched Responsive Posts Carousel with capability checks, AJAX nonces, input sanitization, output escaping, and a PHP Notice fix. Existing `[wcp-carousel]` content remains in use on 24 published pages.
- Removed unused or redundant code from staging: All-in-One WP Migration and its extension, MailPoet, Lightning Advanced Unit, Limit Login Attempts, Akismet, and Hello Dolly. Their original files and the complete source database remain in the local pre-change backup.
- MailPoet was not used by published content and is absent from production. Its old tables remain in the staging database for rollback, but executable plugin code was removed to prevent accidental newsletter delivery.
- Removed six obsolete inactive default themes and installed Twenty Twenty-Five 1.5 as the current official fallback. The active child and Lightning parent themes were preserved.
- Added a staging-only MU plugin that reports `wp_mail()` success while blocking all external delivery. It logged one blocked recipient during the Contact Form 7 API test.
- Restored normal WP-Cron operation after MailPoet was retired.

## QA

- Public HTTP 200: top, profile, supplement list, carousel product detail, contact, post detail, REST root, and `wp-cron.php`.
- Layout structure was compared with the designated source on nine routes: top, product lists, product details, profile, contact, and news. One-column and two-column assignments now match the source, and the duplicate mobile navigation is absent.
- The final top-page headings and section order match production: two 3PR headings, `新着情報`, `お問い合わせ`, and `リンク`. The contact/link separator row is restored, and no `Recent Posts` or 3PR `Read more` output remains.
- All 26 staging submenu destinations returned 200. The tested public asset set contained 128 same-domain URLs, all returning 200.
- No visible PHP Fatal, Warning, Deprecated, or Notice output on tested pages.
- Contact Form 7 form 103 returned `mail_sent`; no external message left staging because the mail guard intercepted it.
- Server-side loopback to the home page and REST API returned 200.
- Server-side request to `api.wordpress.org` returned 200.
- WP-Cron accepted, stored, and removed a temporary scheduled event; Cron is enabled.
- Standard SiteGuard-protected WordPress login page returned 200 and displayed its CAPTCHA.
- WordPress's own authenticated Site Health callbacks returned `good` for REST, loopback, scheduled events, outbound HTTP, and WordPress.org communication.
- Core update status is `latest`; plugin and theme update candidate lists are empty.
- After the final probes, WordPress did not create a debug log, meaning no new PHP error entry was emitted.
- Public search-engine indexing is disabled on staging.

Machine-readable evidence is stored in `records/`.

## Remaining manual check

Chrome automation was unavailable because the Chrome browser extension was not connected. A final visual comparison at desktop and mobile widths, an authenticated admin edit/save check, and a mailbox delivery test to an approved QA address remain manual approval items.

PHP 7.4.33 matches production as requested, but PHP 7.4 is end-of-life. WordPress Site Health therefore reports the PHP-version test as `critical` even though WordPress 7.1 and all active plugins can run on it. This platform risk remains until both production and staging can move to a supported PHP release.
