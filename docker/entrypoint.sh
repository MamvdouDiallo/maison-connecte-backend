#!/bin/sh
set -e

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "  Maison Connectée — Démarrage production"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

cd /var/www/html

# ── 1. Permissions storage ────────────────────────────────────
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# ── 2. Lien symbolique storage ────────────────────────────────
echo "→ Création du lien storage..."
php artisan storage:link --force 2>/dev/null || true

# ── 3. Migrations ─────────────────────────────────────────────
echo "→ Migrations en cours..."
php artisan migrate --force --no-interaction

# ── 4. Seeder admin (idempotent) ──────────────────────────────
echo "→ Vérification du super admin..."
php artisan db:seed --class=AdminSeeder --force --no-interaction 2>/dev/null || true

# ── 5. Cache production ───────────────────────────────────────
echo "→ Mise en cache de la configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo "✓ Application prête — démarrage des services"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# ── 6. Supervisor (nginx + php-fpm + queue) ───────────────────
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
