#!/bin/bash

cd /opt/learngrowdigital

echo "🔧 Fixing permissions..."
sudo chown -R $USER:$USER public/build 2>/dev/null || sudo mkdir -p public/build && sudo chown -R $USER:$USER public/build

echo "📦 Installing npm dependencies..."
npm install

echo "🏗️ Building Vite assets..."
npm run build

echo "✅ Build complete! Files:"
ls -la public/build/

echo "📋 Copying to container..."
docker cp public/build/. laravel_app:/var/www/html/public/build/

echo "🔐 Setting container permissions..."
docker-compose exec app chown -R www-data:www-data /var/www/html/public/build
docker-compose exec app chmod -R 755 /var/www/html/public/build

echo "🧹 Clearing Laravel caches..."
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear
docker-compose exec app php artisan cache:clear

echo "🔄 Restarting app container..."
docker-compose restart app

echo "⏳ Waiting for restart..."
sleep 8

echo "🧪 Testing site..."
curl -I https://learngrowdigital.co.uk

echo ""
echo "✅ Deployment complete!"
echo "🌐 Visit: https://learngrowdigital.co.uk"