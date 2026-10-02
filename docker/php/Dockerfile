FROM php:8.3-cli

RUN apt-get update \
    && apt-get install -y \
        git \
        unzip \
        libzip-dev \
        imagemagick \
        libmagickwand-dev \
    && docker-php-ext-install zip \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN composer install \
    --no-interaction \
    --prefer-dist

COPY . .

CMD ["vendor/bin/codecept", "run"]