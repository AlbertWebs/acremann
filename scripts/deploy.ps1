# Safe production deploy — applies code updates and NEW migrations only.
# Does NOT run migrate:fresh, db:wipe, or db:seed (preserves live data).

$ErrorActionPreference = "Stop"
Set-Location (Join-Path $PSScriptRoot "..")

Write-Host "==> Acremann deploy (database-safe)"

if ($args -contains "--with-seed") {
    Write-Error "Refusing to seed on deploy. Seeding can overwrite CMS content."
}

Write-Host "==> Pull latest code"
git pull --ff-only origin main

Write-Host "==> Install PHP dependencies"
composer install --no-dev --optimize-autoloader --no-interaction

Write-Host "==> Build frontend assets"
if (Get-Command npm -ErrorAction SilentlyContinue) {
    npm ci --no-audit --no-fund 2>$null
    if ($LASTEXITCODE -ne 0) { npm install --no-audit --no-fund }
    npm run build
}

Write-Host "==> Run pending migrations only (no fresh / no wipe)"
php artisan migrate --force

Write-Host "==> Ensure public storage link exists"
php artisan storage:link 2>$null

Write-Host "==> Optimize Laravel"
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:optimize 2>$null

Write-Host "==> Regenerate sitemap"
php artisan sitemap:generate 2>$null

Write-Host "==> Done. Database was not reset or re-seeded."
