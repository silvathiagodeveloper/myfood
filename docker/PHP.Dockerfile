FROM php:fpm

RUN docker-php-ext-install pdo pdo_mysql

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    wget \
    libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev

RUN docker-php-ext-install gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./docker/xdebug.ini /usr/local/etc/php/conf.d/
