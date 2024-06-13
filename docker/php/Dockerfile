FROM composer:2.7.6 as composer

##################################

FROM php:8.3-fpm as php

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN apt-get update \
    && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    libicu-dev \
    zip \
    unzip

WORKDIR /usr/src/app

COPY ./ /usr/src/app

RUN mkdir /.composer && chown 1000 /.composer
RUN composer install && composer clear-cache
RUN composer dump-autoload --optimize --classmap-authoritative --no-dev

RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin

USER 1000:1000
