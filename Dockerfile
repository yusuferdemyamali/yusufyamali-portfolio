FROM php:8.3-cli AS base

# -------------------------
# System packages and PHP extensions
# -------------------------
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev \
    libzip-dev libpq-dev libcurl4-openssl-dev libssl-dev \
    zlib1g-dev libicu-dev g++ libevent-dev procps \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip exif pcntl bcmath sockets intl

# -------------------------
# Swoole installation
# -------------------------
RUN curl -L -o swoole.tar.gz https://github.com/swoole/swoole-src/archive/refs/tags/v5.1.0.tar.gz \
    && tar -xf swoole.tar.gz \
    && cd swoole-src-5.1.0 \
    && phpize \
    && ./configure \
    && make -j$(nproc) \
    && make install \
    && docker-php-ext-enable swoole

# -------------------------
# Composer installation
# -------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# -------------------------
# Copy all project files
COPY . .

# Create storage & cache directories
RUN mkdir -p bootstrap/cache storage/app storage/framework/cache/data \
    storage/framework/sessions storage/framework/views storage/logs

# Install composer dependencies (vendor oluşacak)
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts

# Clear Laravel cache (artık vendor var)
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear


# -------------------------
# Install composer dependencies (post-scripts çalışacak)
# -------------------------
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts

# -------------------------
# File permissions
# -------------------------
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# -------------------------
# Expose port
# -------------------------
EXPOSE 9000

# -------------------------
# Startup script
# -------------------------
RUN echo '#!/bin/bash\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
exec php artisan octane:start --server=swoole --host=0.0.0.0 --port=9000\n\
' > /start.sh && chmod +x /start.sh

CMD ["sh", "/start.sh"]
