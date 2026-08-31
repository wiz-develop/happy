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
- Database: `work/happy-migration/backups/20260831/source/source.sql.gz`

The existing `_bk` directory was excluded from the active source copy and retained as an existing-backup entry in the manifest.

### Production

- Files: local verified copy under `work/happy-migration/backups/20260831/production/files`
- Manifest: `work/happy-migration/records/production-file-manifest-20260831.json`
- Database: `work/happy-migration/backups/20260831/production/production.sql.gz`

The production tree contains multiple separate WordPress and landing-page installations. They are retained in the filesystem backup but are outside this site's deployment scope. Existing backup directories and the 8.8 GB runtime `wordpress/wp-content/debug.log` are excluded from the active-source manifest; their path, size, and modification time are recorded separately.

## Git scope

The initial `main` commit contains the production root routing files, the production WordPress routing files, the production `happyfamily` child theme, and non-secret inventory records. Complete server files and databases remain in the verified local backup.

No production deployment was performed during staging construction.

