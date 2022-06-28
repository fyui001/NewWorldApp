## composer
FROM composer:2.2.7 AS composer-cache
WORKDIR /code
# copy only composer files for caching
COPY composer.json composer.lock /code/

# install deps(without generating autoloader)
RUN composer install --no-scripts --no-autoloader --ignore-platform-reqs

FROM php:8.1

COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer

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
    unzip \
    zlib1g-dev \
    libonig-dev

RUN docker-php-ext-install bcmath intl pdo_mysql opcache bcmath

CMD ["php", "artisan", "discord-bot:run"]
