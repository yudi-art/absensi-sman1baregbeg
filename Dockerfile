FROM php:8.2-apache
RUN apt-get update && apt-get install -y libpng-dev libonig-dev libxml2-dev libzip-dev \
 && docker-php-ext-install pdo_mysql mbstring gd zip \
 && a2enmod rewrite && apt-get clean && rm -rf /var/lib/apt/lists/*
WORKDIR /var/www/html
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
COPY . .
RUN mkdir -p storage bootstrap/cache && chown -R www-data:www-data storage bootstrap/cache || true
RUN echo '#!/bin/bash\nPORT=${PORT:-80}\necho "Listen $PORT" > /etc/apache2/ports.conf\nsed -i "s/:80/:$PORT/g" /etc/apache2/sites-available/000-default.conf || true\nexec apache2-foreground' > /start.sh && chmod +x /start.sh
EXPOSE 80
CMD ["/start.sh"]
