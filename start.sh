#!/bin/bash

echo "Running optimize..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "🔁 Running migrations and seeders..."
php artisan migrate --seed --force

echo "🚀 Starting Apache..."
apache2-foreground
