# Base PHP image with Apache
FROM php:8.2-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git zip unzip curl libzip-dev libpng-dev libonig-dev libxml2-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip gd

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy only composer files first for caching layer
COPY composer.json composer.lock ./

# Copy Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install dependencies first to leverage Docker layer cache
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy the rest of the application
COPY . .

# Set ownership and permissions for Laravel
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# OPTIONAL: Run Laravel optimization (only works if .env exists)
# You can comment this out if your .env isn't yet copied by this point
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache || true

# Use custom Apache virtual host
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Copy custom startup script
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Expose port
EXPOSE 80

# Start container
CMD ["/start.sh"]
