#!/bin/bash

echo "========================================="
echo "ModernShop E-commerce Setup"
echo "========================================="
echo ""

# Install dependencies
echo "Installing Composer dependencies..."
composer install

echo "Installing NPM dependencies..."
npm install

# Environment setup
if [ ! -f .env ]; then
    echo "Creating .env file..."
    cp .env.example .env
    php artisan key:generate
fi

# Database setup
echo ""
echo "Setting up database..."
read -p "Enter database name [ecommerce_mvp]: " db_name
db_name=${db_name:-ecommerce_mvp}

read -p "Enter database user [root]: " db_user
db_user=${db_user:-root}

read -sp "Enter database password: " db_pass
echo ""

# Update .env file
sed -i "s/DB_DATABASE=.*/DB_DATABASE=$db_name/" .env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=$db_user/" .env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$db_pass/" .env

# Run migrations and seeders
echo ""
echo "Running migrations and seeders..."
php artisan migrate:fresh --seed

# Create storage link
echo "Creating storage link..."
php artisan storage:link

# Build assets
echo "Building frontend assets..."
npm run build

echo ""
echo "========================================="
echo "Setup completed successfully!"
echo "========================================="
echo ""
echo "Login Credentials:"
echo "Admin: admin@modernshop.com | password"
echo "User: john@example.com | password"
echo ""
echo "Run 'php artisan serve' to start the application"
echo ""
