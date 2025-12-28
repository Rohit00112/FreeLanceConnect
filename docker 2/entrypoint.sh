#!/bin/sh
set -e

echo "🚀 Starting FreelanceConnect Laravel Application..."

# Wait for MySQL to be ready using PHP
echo "⏳ Waiting for database connection..."
until php -r "try { new PDO('mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD')); exit(0); } catch(Exception \$e) { exit(1); }" 2>/dev/null; do
    echo "Database not ready yet, waiting..."
    sleep 2
done
echo "✅ Database is ready!"

# Run migrations
echo "📦 Running database migrations..."
php artisan migrate --force

# Clear and cache configuration for production
echo "🔧 Optimizing application..."
php artisan config:cache
php artisan route:cache || echo "⚠️ Route caching skipped (may have duplicate route names)"
php artisan view:cache || echo "⚠️ View caching skipped"

# Create storage symlink
echo "🔗 Creating storage link..."
php artisan storage:link || true

echo "✨ Application is ready!"

# Start supervisor
exec "$@"
