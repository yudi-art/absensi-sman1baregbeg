FROM php:8.2-cli
RUN apt-get update && apt-get install -y git unzip libpng-dev libonig-dev libxml2-dev libzip-dev && docker-php-ext-install pdo_mysql mbstring gd zip && apt-get clean && rm -rf /var/lib/apt/lists/*
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache && chmod -R 775 storage bootstrap/cache
EXPOSE 8080
CMD bash -c 'PORT=${PORT:-8080}; php artisan config:clear; php artisan key:generate --force; php artisan migrate --force; php -S 0.0.0.0:$PORT -t public'
