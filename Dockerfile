FROM php:8.2-apache

# Fix MPM error: disable event, enable prefork only
RUN a2dismod mpm_event && a2enmod mpm_prefork rewrite && a2enmod php

RUN apt-get update && apt-get install -y libpng-dev libonig-dev libxml2-dev libzip-dev \
 && docker-php-ext-install pdo_mysql mbstring gd zip \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

COPY . .

RUN mkdir -p storage bootstrap/cache && chown -R www-data:www-data storage bootstrap/cache || true

RUN printf '#!/bin/bash\nset -e\nPORT=${PORT:-80}\necho "Starting Apache on PORT $PORT"\n# Fix ports.conf properly\necho "Listen $PORT" > /etc/apache2/ports.conf\nsed -i "s/:80/:$PORT/g" /etc/apache2/sites-available/000-default.conf || true\n# Ensure only prefork\n a2dismod mpm_event 2>/dev/null || true\n a2enmod mpm_prefork 2>/dev/null || true\napache2-foreground\n' > /start.sh && chmod +x /start.sh

EXPOSE 80
CMD ["/start.sh"]
