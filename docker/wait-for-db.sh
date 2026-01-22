#!/bin/bash

echo "Waiting for MySQL to be ready..."

# Wait for MySQL
until mysql -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" -e "SELECT 1" >/dev/null 2>&1; do
  echo "MySQL is unavailable - sleeping"
  sleep 2
done

echo "MySQL is up - executing commands"

# Run migrations
php artisan migrate --force

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache
apache2-foreground