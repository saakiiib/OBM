# V4.4 upgrade

Read [V4.4-HANDOVER.md](V4.4-HANDOVER.md) first. The older notes below are historical. Never reseed or regenerate APP_KEY on an existing deployment.

# Online Bangla Media V4 — Developer handover

**Release status:** Laravel 12 source package / staging candidate. PHP syntax checked; Composer installation, Blade compilation, MySQL migrations, SMTP and real feed imports have not been executed in the build environment. Do not replace production V3 until staging acceptance is complete.

## 1. Install on staging

Requirements: PHP 8.2+ (prefer 8.3/8.4), Composer 2, MySQL/MariaDB supported by Laravel, HTTPS, cron, PHP extensions ctype, curl, dom, fileinfo, mbstring, openssl, PDO, pdo_mysql, tokenizer, XML and SimpleXML. Use the latest patched Laravel 12 release allowed by composer.json. No Node build is required. Create a fresh staging database and database user with restricted permissions. Back up current V3 files and any existing data. Extract the ZIP outside public_html. Point the staging vhost/document root to the package's `public/` directory. Never expose project root, `.env`, storage, vendor or database files. If hosting cannot change document root, configure a separate application directory and a public-only front controller with corrected absolute paths; do not copy the entire project into public_html.

```bash
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
# Edit .env: correct APP_URL, database credentials and SMTP details first.
php artisan migrate --seed --force
php artisan obm:admin admin@example.com
php artisan optimize:clear
php artisan route:list
php artisan view:cache
php artisan config:cache
```

Replace admin@example.com with the authorised administrator's actual email. The command prompts for a password; no default admin password exists. Ensure web/cron users can write to storage and bootstrap/cache, not the entire project. On staging keep APP_DEBUG=false and protect the site from search indexing (prefer HTTP authentication). SESSION_SECURE_COOKIE=true requires HTTPS. Confirm `APP_URL` is the actual canonical domain before production. The assumed production domain is https://www.onlinebanglamedia.com.

## 2. Admin and submissions

Visit `/admin/login`. Create an entry or edit one of the 53 seeded directory records; set status to published only after review. Imported entries initially remain pending. Public forms at `/submit` save requests in MySQL and attempt email delivery to `OBM_SUBMISSION_EMAIL=info@mentosoftware.co.uk`. Set MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD and MAIL_FROM_ADDRESS to an authenticated sender; verify SPF/DKIM/DMARC as applicable. A success message confirms database receipt, not delivery; dashboard shows emailed_at when the transport accepts the message. If sending fails, the submission remains in the admin dashboard; manually follow up. Review privacy notice and set a retention/deletion policy before launch.

## 3. Automatic imports

Create sources through Admin > Import sources. All sources must be configured by an administrator and enabled only after confirming permission to collect and republish data.

* RSS/Atom: add exact HTTPS host(s) to `OBM_RSS_HOSTS` (comma separated), enter actual permitted feed URL, choose job/scholarship/event/news, and interval (minimum 60 minutes). Do not allow hosts controlled by untrusted parties or internal addresses. Redirects are not followed. Configure outbound network controls against private/internal networks. RSS imports title, link and limited plain-text summary only; deadline/event date extraction requires source-specific mapping or manual review.
* Adzuna: obtain app ID/key from provider, add to .env, choose driver adzuna, type job, country code (e.g. gb, subject to coverage), URL https://api.adzuna.com, interval 180 minutes. Adapter requests first 50 results only; salary/company stored as source metadata, not displayed on public page yet. Follow attribution, retention and usage terms. Imported jobs get a provisional 14-day expiry; admin should enter actual closing date when known. No expired or unapproved entry appears publicly.
* No working Indeed, LinkedIn, Bdjobs, Bayt, Chevening-specific or event-specific API adapters are claimed. Use permitted feeds where available, otherwise create manually or develop provider-specific connectors. No generic unrestricted scraper is included.

After changing .env, run `php artisan config:clear` then `php artisan config:cache`. Test with `php artisan obm:import`. Inspect admin import history. Schedule on the host (replace paths with real ones):

```cron
* * * * * cd /absolute/path/to/obm && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
```

The scheduled command checks due sources every five minutes; each source's own interval governs fetching. Exact URL fingerprints prevent repeated imports of identical links, but cross-provider duplicates are not resolved. Existing records are not overwritten on refresh; review stale entries and implement source-specific update/expiry rules next. No live feeds are pre-enabled and no API credentials are bundled. No queue worker is required for this synchronous initial release. Monitor cron, duration, memory and source failures; add queue workers for high-volume production imports.

## 4. Public and SEO

Existing V3 HTML content is served through Laravel routes; original branding, Bengali landing page and legacy links are preserved. New database-backed pages: `/opportunities/job`, `/opportunities/scholarship`, `/opportunities/event`, `/opportunities/news`, `/opportunities/directory`, `/entry/{slug}`. Search and country filters are available. Dynamic metadata, sitemap and robots are generated by Laravel. Legacy directory pages remain static snapshots, while dynamic directory detail pages are noindex to avoid duplicate indexing. Next phase: migrate category navigation and profile URLs to a single database-backed canonical route while preserving 301 redirects. Do not assume all existing static content is verified. No JobPosting/Event schema is emitted for imported entries lacking required verified fields. Submit the sitemap only after production launch, check Search Console and measure Lighthouse/Core Web Vitals.

## 5. Staging acceptance checklist (mandatory)

- Composer install, migrations and seeding succeed on fresh MySQL; confirm 53 legacy records (valid URLs only), no migration errors.
- Test login with correct/wrong password, throttling, logout, unauthenticated and non-admin access rejection; verify no credentials appear in source/logs.
- Test entry creation, editing, pending/public visibility, deadline and expiry filtering, Bangla rendering and pagination.
- Test legitimate form, missing consent, invalid email, CSRF failure, honeypot, throttling, database persistence and actual email arrival. Disable SMTP and confirm record remains saved.
- Test authorised RSS and Adzuna with real credentials; verify duplicate import, provider failure, redirect rejection, source disabling and cron execution. Manually verify dates and source attribution before publishing.
- Verify all V3 pages, assets, mobile navigation, dynamic pages, HTTP statuses, canonical hostname, sitemap and robots. Review unverified directory contacts. Confirm sensitive files not accessible via HTTP.
- Review code/security, install dependency lockfile, run `composer audit`, create automated feature tests and back up database. Keep a rollback plan to V3.

## 6. Next improvements (not implemented in this package)

Full database-driven CMS for legacy pages/categories; verified country/district and diaspora pages; international Bengali newspapers; full bilingual localisation and hreflang; specific scholarship/event API adapters, event timezone/end dates, cross-provider duplicate detection, robust import refresh and retries; users/favourites/alerts; editor roles, audit trails, retention automation; ads and paid listings; dashboard charts and analytics; robust RSS validation and network egress controls, background queue and automated monitoring; segmented sitemaps at scale and eligible JobPosting/Event structured data. Preserve the existing design and original URLs when migrating. Prioritise working provider integrations over feature count.
