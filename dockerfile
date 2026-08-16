FROM php:8.2-cli

RUN apt-get update && apt-get install -y git unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
 && docker-php-ext-install pdo_mysql mbstring gd zip \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html

COPY..

RUN composer config --no-interaction policy.advisories.block false || true \
 && composer install --no-dev --optimize-autoloader --no-interaction --no-scripts --ignore-platform-reqs

RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

EXPOSE 8080

# INI FIX 500 ERROR - AUTO GENERATE KEY + CLEAR CACHE
CMD bash -c 'PORT=${PORT:-8080}; if [! -f.env ]; then cp.env.example.env 2>/dev/null || echo "APP_NAME=Absensi\nAPP_ENV=production\nAPP_DEBUG=true\nLOG_CHANNEL=stderr\nAPP_KEY=\n" >.env; fi; php artisan key:generate --force 2>/dev/null || true; php artisan config:clear 2>/dev/null || true; php -S 0.0.0.0:$PORT -t public'