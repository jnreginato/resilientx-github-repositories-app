FROM php:8.4.16-fpm-alpine AS base

# Configuration of the working direction
WORKDIR /var/www/

# It exposes the PHP-FPM and Supervisor ports.
EXPOSE 9000 9001

# Install PHP extensions
RUN apk add --no-cache --virtual .build-deps \
    autoconf \
    g++ \
    gcc \
    linux-headers \
    make \
    && pecl install igbinary xdebug \
    && docker-php-ext-enable igbinary xdebug \
    && pecl install --configureoptions 'enable-apcu-igbinary="yes"' apcu \
    && pecl install --configureoptions 'enable-redis-igbinary="yes"' redis \
    && docker-php-ext-enable apcu redis \
    && pecl clear-cache \
    && rm -rf /tmp/*

FROM composer:2.9.3 AS build

FROM base AS final

# Copy the composer file into the final image.
COPY --from=build /usr/bin/composer /usr/bin/composer

# Copies configuration files and startup scripts.
COPY docker/php/rootfilesystem/ /

# Install dependencies
RUN apk add --no-cache bash coreutils supervisor

# Sets stop signal
STOPSIGNAL SIGINT

RUN chown -R www-data:www-data \
    storage \
    bootstrap/cache \
    database

# Set execute permission for entrypoint script and create log directories
RUN chmod +x /entrypoint.sh && \
    mkdir -p /var/log/php /var/log/supervisor && chmod -R 777 /var/log

# Define input script
ENTRYPOINT ["/entrypoint.sh"]