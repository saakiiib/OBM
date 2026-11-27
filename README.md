# Online Bangla Media (OBM)

Laravel 12 application — Bengali resources, jobs, scholarships, events, news, and a community directory. MySQL database: `ms_obm`.

## Requirements

- PHP 8.2+ (8.3/8.4 recommended) with `pdo_mysql`, `mbstring`, `openssl`, `curl`, `dom`, `fileinfo`, `tokenizer`, `xml`, `simplexml`
- Composer 2
- MySQL 8 / MariaDB

## Local setup

```bash
# 1. Install PHP dependencies
composer install

# 2. Configure environment
cp .env.example .env
php artisan key:generate

# 3. Create the database (once), then migrate + seed
php artisan migrate --seed

# 4. Create an admin user (you are prompted for a password)
php artisan obm:admin admin@example.com

# 5. Serve locally
php artisan serve
```

Open http://127.0.0.1:8000 — the site is live immediately. Admin area: http://127.0.0.1:8000/admin/login

## Useful commands

| Command | Purpose |
| --- | --- |
| `php artisan migrate --seed` | (Re)create tables and seed the directory from `database/directory.json` |
| `php artisan obm:admin <email>` | Create or reset the admin password |
| `php artisan obm:import` | Fetch any enabled import sources (RSS / Adzuna) |
| `php artisan obm:check-links` | Re-check directory link health |
| `php artisan route:list` | List all routes |

## Project structure

- `app/` — Controllers, Models, Services (Importer, LinkChecker), Console commands
- `database/` — Migrations, Seeder, `directory.json` seed data
- `resources/views/` — Blade views + `legacy/` static HTML snapshots
- `routes/web.php` — public + admin routes
- `public/` — web root (assets, favicon, styles)
- `config/obm.php`, `config/advertising.php` — app-specific config