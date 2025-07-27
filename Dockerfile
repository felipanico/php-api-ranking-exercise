FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    unzip \
    git \
    zip \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/html
