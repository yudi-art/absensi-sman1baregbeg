FROM php:8.2-apache

# HAPUS MPM EVENT & WORKER TOTAL
RUN rm -rf /etc/apache2/mods-enabled/mpm_event* /etc/apache2/mods-enabled/mpm_worker* \
 && a2enmod mpm_prefork rewrite \
 && a2dismod mpm_event 2>/dev/null || true \
 && a2dismod mpm_worker 2>/dev/null || true

RUN apt-get update && apt-get install -y git unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
 && docker-php-ext-install pdo_mysql mbstring gd zip \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

COPY . .

RUN composer config --no-interaction policy.advisories.block false || true \
 && composer install --no-dev --optimize-autoloader --no-interaction --no-scripts --ignore-platform-reqs

RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
 && chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

# START.SH TANPA ARTISAN - ANTI CRASHED
RUN echo '#!/bin/bash\nset -e\nPORT=${PORT:-8080}\necho "Listen $PORT" > /etc/apache2/ports.conf\ncat > /etc/apache2/sites-available/000-default.conf <<EOF\n<VirtualHost *:$PORT>\n    DocumentRoot /var/www/html/public\n    <Directory /var/www/html/public>\n        AllowOverride All\n        Require all granted\n    </Directory>\n    ErrorLog /proc/self/fd/2\n    CustomLog /proc/self/fd/1 combined\n</VirtualHost>\nEOF\napache2-foreground\n' > /start.sh && chmod +x /start.sh

EXPOSE 8080
CMD ["/start.sh"]
