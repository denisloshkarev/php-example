FROM composer:latest AS composer
FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    xinetd telnetd \
&& docker-php-ext-install pdo pdo_mysql zip

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev

RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && \
    docker-php-ext-install gd

RUN apt-get update && apt-get install -y \
    unzip

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/laravel-docker
