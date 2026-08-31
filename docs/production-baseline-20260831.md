# Production baseline: 2026-08-31

## Environments

| Role | URL | PHP | WordPress | Database tables | Public pages |
| --- | --- | ---: | ---: | ---: | ---: |
| Production baseline | `https://www.happyfamily.co.jp/` | 7.4.33 | 4.9.26 | 14 | 54 |
| Designated staging source | `http://happyfamily.3d-showcase.net/` | 7.0.32 | 5.2.21 | 46 | 53 |
| Staging destination | `https://happy.wiz-services.com/` | 7.4.33 | 7.1 after upgrade | 46 | 53 |

Production remains unchanged. The designated source was copied to the staging destination; production was used only as the baseline for `main` and as a visual/content reference.

## Backups

### Designated source

- Files: 7,655 files, 249,355,572 bytes
- Local path: `work/happy-migration/backups/20260831/source/files`
- Manifest: `work/happy-migration/records/source-file-manifest-20260831.json`
- Manifest SHA-256: `646a2caff054bacd0b17e5f8d8774c01d0c02184dbc9cc9881e64aabe3afcbb8`
- Database: `work/happy-migration/backups/20260831/source/source.sql.gz`
- Database gzip SHA-256: `019d656be930110c7e511ac27c5865f596b72d57b585c1778f658813de1cf858`

The existing `_bk` directory was excluded from the active source copy and retained as an existing-backup entry in the manifest.

### Production

- Files: 49,559 files, 6,990,728,907 bytes
- Local path: `work/happy-migration/backups/20260831/production/files`
- Manifest: `work/happy-migration/records/production-file-manifest-20260831.json`
- Manifest SHA-256: `26b57db265b4cae28d9eec2eaa2cfcda5e684b841e5f4b76c80468549eda5472`
- Database: `work/happy-migration/backups/20260831/production/production.sql.gz`
- Database gzip SHA-256: `cbcaf69044cfc50a6a5e1e9dc39e507b959af87ee1852baaadd2ba5a8cd515bb`

The production tree contains multiple separate WordPress and landing-page installations. They are retained in the filesystem backup but are outside this site's deployment scope. A total of 5,444 runtime/existing-backup files (8,972,088,441 bytes) are listed as excluded entries. This includes the 8.8 GB runtime `wordpress/wp-content/debug.log`; its path, size, and raw server modification timestamp are recorded separately.

One 14-byte upload-protection `.htaccess` disappeared from the remote tree between the first and final inventory. The first downloaded copy is preserved under `production/orphaned-during-backup`; it is not counted in the verified 49,559-file final manifest.

### Updated staging rollback point

- Database: `work/happy-migration/backups/20260831/staging-final/staging-final.sql.gz`
- Database gzip SHA-256: `73eb4177b1541100afcd2ca80f18f6ee9db148d5dd5e2113ca4162ef3271c913`

## Git scope

The initial `main` commit contains the production root routing files, the production WordPress routing files, the production `happyfamily` child theme, and non-secret inventory records. Complete server files and databases remain in the verified local backup.

No production deployment was performed during staging construction.

