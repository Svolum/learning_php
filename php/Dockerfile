FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY ../site/composer.json ../site/composer.lock ./

RUN composer install --no-dev --optimize-autoloader

COPY ../site .

RUN chown -R www-data:www-data /var/www/html
