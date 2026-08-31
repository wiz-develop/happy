# Happy Family WordPress source

This repository tracks custom source and migration records for the Happy Family website.

- `main`: production custom source, compatibility patches, and deployment records
- `test`: staging source, compatibility fixes, and upgrade records

WordPress core, unmodified third-party plugins, database dumps, uploads, caches, credentials, and server logs are not committed. Patched maintenance builds that must survive future upgrades are tracked under `wp-content/plugins`.

See `docs/` for environment, QA, deployment, and rollback notes.
