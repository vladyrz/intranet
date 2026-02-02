FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git unzip libzip-dev libpng-dev libonig-dev libxml2-dev libpq-dev curl \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath gd \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY package.json package-lock.json* yarn.lock* pnpm-lock.yaml* ./
RUN if [ -f package.json ]; then \
        curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
        && apt-get update \
        && apt-get install -y --no-install-recommends nodejs \
        && npm ci \
        && npm run build \
        && npm cache clean --force \
        && apt-get purge -y --auto-remove nodejs \
        && rm -rf /var/lib/apt/lists/*; \
    fi

COPY composer.json composer.lock* ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

COPY . .

RUN chown -R www-data:www-data /var/www/html \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
