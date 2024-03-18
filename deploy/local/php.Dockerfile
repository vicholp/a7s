FROM php:8.3.3-apache AS php

RUN a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
ENV PHP_EXTENSIONS "redis xdebug pdo_mysql pdo_pgsql gd zip exif"

COPY deploy/local/php.ini-development "$PHP_INI_DIR/php.ini"
COPY deploy/local/99-xdebug.ini /usr/local/etc/php/conf.d/99-xdebug.ini

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions $PHP_EXTENSIONS

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

COPY --from=composer:2.7.2 /usr/bin/composer /usr/bin/composer

COPY . .
