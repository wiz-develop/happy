# Production deployment and rollback

## Approval gate

Do not deploy the `test` branch directly to production. It represents the designated staging source, while production has different content and a different child-theme revision.

After staging approval, create a production release from `main` and port only the verified compatibility changes that production actually needs. Take fresh production file and database backups immediately before deployment.

## Production procedure

1. Confirm the production PHP version and free disk space.
2. Export the production database and download the production WordPress files with hashes.
3. Create a release branch from `main` and commit the fresh production baseline if it changed.
4. Apply WordPress core, official plugin, CFS, carousel, and child-theme compatibility changes one at a time.
5. Keep production-only theme templates, assets, content, URLs, and mail recipients unchanged.
6. Confirm that no staging-only mail guard or staging sender override is included in the production release.
7. Run database upgrade, clear caches, and verify public pages, REST, loopback, Cron, and the admin screens.
8. Test contact delivery only with an approved recipient and verify both the configured administrative notification and any intentionally enabled autoresponder.
9. Inspect PHP, WordPress, and server logs for Fatal, Warning, Deprecated, and Notice entries.
10. Merge the approved release to `main`, tag it, and retain the backup paths and hashes in the release record.

## Rollback

1. Put the site into maintenance mode if public errors are present.
2. Restore the pre-deployment production files, excluding runtime caches.
3. Restore the matching pre-deployment database dump.
4. Restore the previous PHP version only if it was part of the deployment and is still supported by the restored WordPress version.
5. Clear opcode, page, object, and CDN caches.
6. Verify the home page, representative pages, admin login, REST, Cron, and contact form.
7. Remove any temporary maintenance or recovery scripts and record the incident.
