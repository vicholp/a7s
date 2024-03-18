FROM php:8.3.3-apache AS php

RUN a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
ENV PHP_EXTENSIONS "redis pdo_mysql pdo_pgsql gd zip exif"

COPY deploy/prod/php.ini-production "$PHP_INI_DIR/php.ini"

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions $PHP_EXTENSIONS

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# Composer

USER www-data

RUN mkdir -p \
    bootstrap/cache \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/app/public \
    storage/logs

COPY --from=composer:2.7.2 /usr/bin/composer /usr/bin/composer

COPY composer.json /var/www/html/composer.json
COPY composer.lock /var/www/html/composer.lock

RUN composer install --no-dev --no-scripts --no-autoloader \
    --no-interaction --no-progress

# Copy

COPY . /var/www/html/

# up

RUN composer dump-autoload -o
RUN php artisan config:cache & \
    php artisan route:cache & \
    php artisan view:cache
