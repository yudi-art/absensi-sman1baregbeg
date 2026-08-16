
FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y git zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Enable apache rewrite
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy only app files
COPY . .

# Install PHP deps
RUN composer install --no-dev --optimize-autoloader --no-interaction || true

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache || true
RUN chmod -R 775 storage bootstrap/cache || true

# Laravel setup
RUN php artisan key:generate --force || true

EXPOSE 80
CMD bash -c "php artisan migrate --seed --force || true; php artisan storage:link || true; apache2-foreground"
