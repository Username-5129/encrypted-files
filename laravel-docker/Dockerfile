FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    libxml2-dev \
    && docker-php-ext-install xml pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html