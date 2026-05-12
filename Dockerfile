# ─────────────────────────────────────────────────────────────
# Stage 1 — Dépendances Composer
# ─────────────────────────────────────────────────────────────
FROM composer:2.7 AS vendor

WORKDIR /app
COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader

# ─────────────────────────────────────────────────────────────
# Stage 2 — Image de production
# ─────────────────────────────────────────────────────────────
FROM php:8.2-fpm-alpine

LABEL maintainer="Maison Connectée <dev@maison-connectee.sn>"

# Dépendances système
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    libxml2-dev \
    icu-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        gd \
        zip \
        fileinfo \
        xml \
        bcmath \
        exif \
        intl \
        opcache \
    && rm -rf /var/cache/apk/*

# PHP config production
COPY docker/php/php.ini /usr/local/etc/php/conf.d/app.ini
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Nginx config
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf

# Supervisor config
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

WORKDIR /var/www/html

# Copier le code source
COPY . .

# Copier les vendor depuis le stage 1
COPY --from=vendor /app/vendor ./vendor

# Permissions storage & bootstrap/cache
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions \
               storage/framework/views storage/app/public bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Entrypoint
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
