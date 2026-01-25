#!/bin/bash

cd /opt/learngrowdigital

echo "🔧 Fixing Vite manifest issue..."

# Build assets
echo "📦 Building Vite assets..."
npm install
npm run build

# Verify build directory
echo "✅ Checking build directory..."
ls -la public/build/

# Stop containers
echo "🛑 Stopping containers..."
docker-compose down

# Start containers (this will mount public/build if configured)
echo "🚀 Starting containers..."
docker-compose up -d

# Wait for containers
echo "⏳ Waiting for containers..."
sleep 15

# Copy build to container (backup method)
echo "📋 Copying build files to container..."
docker cp public/build/. laravel_app:/var/www/html/public/build/

# Set permissions
echo "🔐 Setting permissions..."
docker-compose exec -T app chown -R www-data:www-data /var/www/html/public/build
docker-compose exec -T app chmod -R 755 /var/www/html/public/build

# Verify manifest in container
echo "🔍 Verifying manifest in container..."
docker-compose exec -T app ls -la /var/www/html/public/build/

# Clear caches
echo "🧹 Clearing Laravel caches..."
docker-compose exec -T app php artisan config:clear
docker-compose exec -T app php artisan view:clear
docker-compose exec -T app php artisan cache:clear

# Restart app
echo "🔄 Restarting app container..."
docker-compose restart app

echo "✅ Done! Testing..."
sleep 5

# Test
curl -I https://learngrowdigital.co.uk

echo "🌐 Visit: https://learngrowdigital.co.uk"