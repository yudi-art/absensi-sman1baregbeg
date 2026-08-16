FROM php:8.2-apache

RUN a2dismod mpm_event || true && a2enmod mpm_prefork rewrite

RUN apt-get update && apt-get install -y git unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
 && docker-php-ext-install pdo_mysql mbstring gd zip \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts --no-audit --ignore-platform-reqs

RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
 && chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

EXPOSE 8080
CMD bash -c 'PORT=${PORT:-8080}; echo "Listen $PORT" > /etc/apache2/ports.conf; sed -i "s/:80/:$PORT/g" /etc/apache2/sites-available/000-default.conf; php artisan config:clear 2>/dev/null || true; apache2-foreground'
