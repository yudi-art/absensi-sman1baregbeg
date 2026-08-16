FROM php:8.2-apache

RUN apt-get update && apt-get install -y git zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
 && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
 && a2enmod rewrite \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts || true \
 && mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
 && chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

RUN printf '#!/bin/bash\nset -e\nPORT=${PORT:-80}\necho "Starting on $PORT"\necho "Listen $PORT" > /etc/apache2/ports.conf\nsed -i "s/:80/:$PORT/g" /etc/apache2/sites-available/000-default.conf || true\nchown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true\nexec apache2-foreground\n' > /start.sh && chmod +x /start.sh

EXPOSE 80
CMD ["/start.sh"]
