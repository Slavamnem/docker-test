FROM php:7.4.1-apache

RUN apt update && apt install libpq-dev -y && docker-php-ext-install pdo_pgsql

#xdebug
RUN pecl install xdebug \ && docker-php-ext-enable xdebug

COPY ./docker/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
#######