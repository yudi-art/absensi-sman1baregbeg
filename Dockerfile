FROM php:8.4-cli
RUN apt-get update && apt-get install -y git unzip libpng-dev libonig-dev libxml2-dev libzip-dev curl && docker-php-ext-install pdo_mysql mbstring gd zip && apt-get clean && rm -rf /var/lib/apt/lists/*
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /var/www/html
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs
RUN composer dump-autoload --optimize --no-check-platform
RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache && chmod -R 775 storage bootstrap/cache
EXPOSE 8080
CMD bash -c 'php artisan config:clear && php artisan view:clear && php artisan migrate --force && php -S 0.0.0.0:${PORT:-8080} -t public'
