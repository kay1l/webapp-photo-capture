#!/bin/bash

echo "🔁 Running migrations and seeders..."
php artisan migrate --seed --force

echo "🚀 Starting Apache..."
apache2-foreground
