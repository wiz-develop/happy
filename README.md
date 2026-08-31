# Happy Family WordPress source

This repository tracks custom source and migration records for the Happy Family website.

- `main`: production custom source captured before upgrade work
- `test`: staging source, compatibility fixes, and upgrade records

WordPress core, unmodified third-party plugins, database dumps, uploads, caches, credentials, and server logs are not committed. Patched maintenance builds that must survive future upgrades are tracked under `wp-content/plugins`.

See `docs/` for environment, QA, deployment, and rollback notes.

The `test` branch represents the designated staging source after upgrade. It is not a production deployment bundle because the current production theme and content differ from the designated staging source.

