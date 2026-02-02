FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git unzip libzip-dev libpng-dev libonig-dev libxml2-dev libpq-dev libicu-dev curl \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath gd intl \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock* ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

COPY . .

RUN mkdir -p \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

RUN composer dump-autoload --optimize \
    && php artisan package:discover --ansi

RUN if [ -f package.json ]; then \
        curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
        && apt-get update \
        && apt-get install -y --no-install-recommends nodejs \
        && if [ -f package-lock.json ]; then npm ci; \
           elif [ -f yarn.lock ]; then npm install -g yarn && yarn install --frozen-lockfile; \
           elif [ -f pnpm-lock.yaml ]; then npm install -g pnpm && pnpm install --frozen-lockfile; \
           else npm install; fi \
        && npm run build \
        && npm cache clean --force \
        && apt-get purge -y --auto-remove nodejs \
        && rm -rf /var/lib/apt/lists/*; \
    fi

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
