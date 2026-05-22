#!/usr/bin/env bash
# Safe production deploy — applies code updates and NEW migrations only.
# Does NOT run migrate:fresh, db:wipe, or db:seed (preserves live data).

set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT"

echo "==> Acremann deploy (database-safe)"

if [[ "${1:-}" == "--with-seed" ]]; then
    echo "ERROR: Refusing to seed on deploy. Seeding can overwrite CMS content."
    echo "       Run seeders manually only on empty/dev databases."
    exit 1
fi

if [[ "${APP_ENV:-production}" != "production" ]]; then
    echo "    APP_ENV=${APP_ENV:-production}"
fi

echo "==> Pull latest code"
git pull --ff-only origin main

echo "==> Install PHP dependencies"
composer install --no-dev --optimize-autoloader --no-interaction

echo "==> Build frontend assets"
if command -v npm >/dev/null 2>&1; then
    npm ci --no-audit --no-fund 2>/dev/null || npm install --no-audit --no-fund
    npm run build
fi

echo "==> Run pending migrations only (no fresh / no wipe)"
php artisan migrate --force

echo "==> Ensure public storage link exists"
php artisan storage:link 2>/dev/null || true

echo "==> Optimize Laravel"
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:optimize 2>/dev/null || true

echo "==> Regenerate sitemap"
php artisan sitemap:generate 2>/dev/null || true

echo "==> Done. Database was not reset or re-seeded."
