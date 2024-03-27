FROM php:8.3-cli

# PHP Config
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN apt-get -y update && \
    apt-get install -y \
        # libicu-dev \
        # libzip-dev \
        zip \
        git \
        curl &&  \
    pecl install xdebug && \
    docker-php-ext-enable xdebug

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /usr/src/myapp
