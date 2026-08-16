FROM php:8.2-apache

# FIX MPM: matikan event, pastikan cuma prefork
RUN a2dismod mpm_event 2>/dev/null || true && a2dismod mpm_worker 2>/dev/null || true && a2enmod mpm_prefork rewrite

RUN apt-get update && apt-get install -y git unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
 && docker-php-ext-install pdo_mysql mbstring gd zip \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

COPY . .
RUN composer config --no-interaction policy.advisories.block false 2>/dev/null || true
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts --ignore-platform-reqs

RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
 && chown -R www-data:www-data storage bootstrap/cache && chmod -R 775 storage bootstrap/cache

RUN printf '#!/bin/bash\nset -e\nPORT=${PORT:-8080}\necho "Listen $PORT" > /etc/apache2/ports.conf\nsed -i "s/:80/:$PORT/g" /etc/apache2/sites-available/000-default.conf || true\nif [ ! -f .env ]; then [ -f .env.example ] && cp .env.example .env || echo "APP_NAME=Absensi\nAPP_ENV=production\nAPP_DEBUG=false\nAPP_KEY=\nLOG_CHANNEL=stderr" > .env; fi\nphp artisan key:generate --force 2>/dev/null || true\nphp artisan config:clear 2>/dev/null || true\nphp artisan storage:link 2>/dev/null || true\nphp artisan migrate --force 2>/dev/null || echo "migrate skip"\nchown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true\nexec apache2-foreground\n' > /start.sh && chmod +x /start.sh

EXPOSE 8080
CMD ["/start.sh"]
