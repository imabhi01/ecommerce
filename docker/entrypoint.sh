#!/bin/bash
set -e

echo "Starting Laravel application..."

# Wait for database
echo "Waiting for database..."
while ! mysqladmin ping -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" --silent; do
    echo "Database is unavailable - sleeping"
    sleep 2
done

echo "Database is up!"

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Run migrations
php artisan migrate --force

# Cache for production-like performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache
exec apache2-foreground