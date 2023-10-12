## composer
FROM composer:2.4.1 AS composer-cache
WORKDIR /code
# copy only composer files for caching
COPY composer.json composer.lock /code/

# install deps(without generating autoloader)
RUN composer install --no-scripts --no-autoloader --ignore-platform-reqs

## appliation
FROM php:8.2-fpm

COPY --from=composer-cache /usr/bin/composer /usr/bin/composer

WORKDIR /code

RUN apt update && \
    apt full-upgrade -y && \
    apt full-upgrade -y && \
    apt autoremove -y && \
    apt autoclean -y && \
    apt install -y \
    g++ \
    zip \
    unzip \
    locales \
    libicu-dev \
    libmemcached-dev \
    unzip \
    zlib1g-dev \
    libonig-dev \
    default-mysql-client

RUN docker-php-ext-install bcmath intl pdo_mysql opcache bcmath

RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/*

## NOTE: 使いたいときに入れるように
#RUN pecl install xdebug && \
#    docker-php-ext-enable xdebug && \
#    pecl clear-cache
