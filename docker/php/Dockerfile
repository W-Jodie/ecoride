FROM php:8.2-fpm

RUN apt-get update && apt-get install -y     git unzip libicu-dev libzip-dev libpng-dev libjpeg-dev libfreetype6-dev  && docker-php-ext-configure gd --with-freetype --with-jpeg  && docker-php-ext-install pdo pdo_mysql intl zip gd  && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# (optionnel) désactiver l'opcache en dev
RUN echo "opcache.enable=0" > /usr/local/etc/php/conf.d/opcache-dev.ini
