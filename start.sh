#!/bin/bash

echo "Running optimize..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "🔗 Linking storage folder..."
php artisan storage:link || echo "Storage link already exists."


echo "🔁 Running migrations individually in correct order..."

MIGRATIONS_PATH="database/migrations"

for file in $(ls "$MIGRATIONS_PATH"/*.php | sort); do
    class=$(grep -oP 'class\s+\K\S+' "$file" | head -1)
    echo "🔹 Migrating: $class"
    php artisan migrate --path="$file" --force
done

echo "🌱 Seeding in proper order..."

php artisan db:seed --class=VenueSeeder --force
php artisan db:seed --class=RemoteSeeder --force
php artisan db:seed --class=PhotoboothSeeder --force
php artisan db:seed --class=AlbumSeeder --force
php artisan db:seed --class=UserSeeder --force
php artisan db:seed --class=CaptureSeeder --force

echo "✅ Done."


echo "🚀 Starting Apache..."
apache2-foreground

