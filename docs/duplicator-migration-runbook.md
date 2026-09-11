# Duplicator Migration Runbook

This guide covers full-site migrations between the Local installation and SiteGround production using Duplicator Lite. It also distinguishes full migrations from the theme-only `deploy.sh` workflow.

## Environment Overview

| Environment | Site URL | Expected WordPress environment |
| --- | --- | --- |
| Local | `http://tim-fetter.local` | `local` |
| Production | `https://timfetter.com` | `production` |

Google Site Kit only emits Analytics tags in an allowed production environment. An incorrect `WP_ENVIRONMENT_TYPE` can therefore prevent GA4 collection even when Site Kit is connected and code placement is enabled.

## Portable Environment Detection

Duplicator replaces and modifies `wp-config.php` during a full migration. Avoid a fixed environment value that can travel to the wrong destination.

Replace a hard-coded definition such as:

```php
define( 'WP_ENVIRONMENT_TYPE', 'local' );
```

with this destination-aware definition in the `wp-config.php` that Duplicator packages:

```php
$tf_host = strtolower( $_SERVER['HTTP_HOST'] ?? '' );
$tf_host = preg_replace( '/:\d+$/', '', $tf_host );
$tf_path = str_replace( '\\', '/', __DIR__ );

$tf_is_local =
	$tf_host === 'tim-fetter.local'
	|| $tf_host === 'localhost'
	|| ( defined( 'DB_NAME' ) && DB_NAME === 'local' )
	|| strpos( $tf_path, '/Local Sites/' ) !== false;

define( 'WP_ENVIRONMENT_TYPE', $tf_is_local ? 'local' : 'production' );

unset( $tf_host, $tf_path, $tf_is_local );
```

Place the definition before this line:

```php
/* That's all, stop editing! Happy publishing. */
```

This supports browser requests and WP-CLI. An unknown destination defaults to `production`, so review this logic before adding a staging environment.

## Files That Must Remain Private

The following must never be committed, shared, or left publicly accessible:

- `.deploy-config`
- Duplicator archives (`.zip` or `.daf`)
- `installer.php` and installer log files
- SQL exports
- Database, SSH, API, or service credentials

The theme's `.gitignore` prevents Git from committing `.deploy-config`, but Git ignore rules do not control Duplicator archives. Before building a Duplicator package, exclude:

```text
wp-content/themes/timfetter/.deploy-config
```

Confirm the package scan does not list that file. Keep `.deploy-config.example` in the theme; it contains placeholders only and is safe to commit.

## Before Either Migration Direction

1. Confirm the source and destination sites.
2. Make a fresh recoverable backup of the destination.
3. Check whether production has received new forms, users, uploads, comments, or content edits.
4. Confirm the portable environment detection is present in the source `wp-config.php`.
5. Exclude `.deploy-config` from the Duplicator archive.
6. Build and download the Duplicator installer and archive.

A full overwrite replaces the destination files and database. Do not push a stale local database to production when production has newer information that must be preserved.

## Production to Local

1. Build a fresh Duplicator package on production.
2. Download the installer and archive.
3. Back up the current Local site if it contains work not present on production.
4. Run the Duplicator overwrite installation against the Local site.
5. In the installer's advanced configuration-file options, use **Modify original** for `wp-config.php`. Do not create a new file from `wp-config-sample.php`, because that can remove custom environment detection.
6. Confirm Duplicator replaced production URLs with `http://tim-fetter.local`.
7. Open **Local**, select the site, and click **Open Site Shell**.
8. Verify the environment:

   ```bash
   wp eval 'echo wp_get_environment_type();'
   ```

   Expected result:

   ```text
   local
   ```

9. Open the local site and WordPress admin, then verify important pages and editor screens.
10. Remove the installer, archive, and installer logs from the Local public directory.

## Local to Production

1. Confirm production has no newer content, submissions, uploads, users, or other database changes that would be lost.
2. Build and test the theme locally:

   ```bash
   npm run build
   ```

3. Commit the intended theme changes before creating the Duplicator package.
4. Build a fresh Duplicator package locally, excluding `.deploy-config`.
5. Make a fresh recoverable production backup.
6. Upload only the Duplicator installer and archive required for the migration.
7. Run the overwrite installation against production.
8. In the advanced configuration-file options, use **Modify original** for `wp-config.php`.
9. Confirm the final site URL is `https://timfetter.com`.
10. Verify the production environment using the command in the next section.
11. Clear SiteGround dynamic cache/CDN cache when appropriate.
12. Test the home page, Work archive, contact form, important case studies, and WordPress admin.
13. Remove the installer, archive, and installer logs from `public_html` immediately.

## Verify the Production Environment

From the theme directory on the local machine, load the private deployment configuration and run a read-only command over SSH:

```bash
source .deploy-config

TF_REMOTE_ROOT="${SG_REMOTE_PATH%/wp-content/themes/timfetter/}"

ssh -p "$SG_PORT" "$SG_USER@$SG_HOST" \
  "cd '$TF_REMOTE_ROOT' && wp eval 'echo wp_get_environment_type();'"
```

Expected result:

```text
production
```

Do not print or paste the contents of `.deploy-config` into documentation, tickets, chat, or screenshots.

## Verify Google Analytics After Production Migration

1. Confirm production returns `production` from `wp_get_environment_type()`.
2. In WordPress, open **Site Kit → Settings → Connected Services → Analytics**.
3. Confirm **Place Google Analytics code** is enabled.
4. Confirm the measurement ID is `G-HKFVCPJGEY`.
5. Test in a logged-out or private browser window. Site Kit is configured to exclude logged-in users.
6. Check **Google Analytics → Reports → Realtime**. New collection can take several minutes to appear, and standard reports can take longer.

Do not add a second manual `gtag.js` snippet while Site Kit code placement is enabled.

## Theme-Only Deployment

Use `deploy.sh` when only tracked theme files changed and no database, uploads, plugins, WordPress core, or root configuration must move.

Preview:

```bash
./deploy.sh
```

Apply after reviewing the preview:

```bash
./deploy.sh --apply
```

The deployment helper requires a clean `master` branch that matches GitHub. It does not migrate `wp-config.php` or the WordPress database, so it cannot change `WP_ENVIRONMENT_TYPE`.

## Post-Migration Checklist

- The destination URL is correct.
- Local reports `local`; production reports `production`.
- The home page and Work archive render correctly.
- Important case studies and reusable blocks render correctly.
- WordPress admin and ACF editing screens work.
- The contact form can be submitted and delivered.
- Site Kit emits GA4 only on production for logged-out visitors.
- SiteGround caches are cleared when needed.
- Duplicator installer, archive, and log files are removed.
- `.deploy-config` was not included in the archive or destination files.

