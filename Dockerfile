# syntax=docker/dockerfile:1

################################################################################
# Stage 1: Build stage for installing Node.js & compiling Vite/Tailwind assets
################################################################################
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package*.json vite.config.js ./
COPY resources/ ./resources/
COPY public/ ./public/
RUN npm install && npm run build

################################################################################
# Stage 2: Build stage for installing PHP/Composer dependencies
################################################################################
FROM php:8.2-cli AS deps

RUN apt-get update && apt-get install -y unzip git && rm -rf /var/lib/apt/lists/*
COPY --from=composer:lts /usr/bin/composer /usr/bin/composer

WORKDIR /app

RUN --mount=type=bind,source=composer.json,target=composer.json \
    --mount=type=bind,source=composer.lock,target=composer.lock \
    --mount=type=cache,target=/tmp/cache \
    composer install --optimize-autoloader --no-interaction --no-scripts

################################################################################
# Stage 3: Minimal runtime stage for running the application on Render
################################################################################
FROM php:8.2-apache AS final

# Install PostgreSQL/MySQL drivers and system dependencies
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Set up the production php.ini
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Set Apache DocumentRoot to Laravel's public directory and set global ServerName to suppress warnings
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy application files first and assign to www-data
COPY --chown=www-data:www-data . /var/www/html

# Copy PHP dependencies from deps stage (overwriting any local/stale vendor directory)
COPY --from=deps --chown=www-data:www-data /app/vendor/ /var/www/html/vendor

# Copy Vite built assets (manifest + CSS/JS) from frontend stage (overwriting any local/stale public/build)
COPY --from=frontend --chown=www-data:www-data /app/public/build /var/www/html/public/build

# Fix permissions for Laravel storage and cache directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

EXPOSE 80

# Start Apache with dynamic $PORT support, run database migrations/seeders, and clear stale package cache before boot
CMD chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true \
    && chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true \
    && rm -f /var/www/html/bootstrap/cache/*.php /var/www/html/public/hot \
    && sed -i "s/Listen 80/Listen ${PORT:-80}/g" /etc/apache2/ports.conf \
    && sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT:-80}>/g" /etc/apache2/sites-available/000-default.conf \
    && php artisan config:clear 2>/dev/null || true \
    && php artisan migrate --force --seed 2>/dev/null || true \
    && apache2-foreground
