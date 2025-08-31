# 1️⃣ Base image
FROM php:8.3-fpm-alpine

# 2️⃣ Sistem paketleri ve PHP eklentileri
RUN apk add --no-cache \
        bash \
        git \
        unzip \
        libzip-dev \
        oniguruma-dev \
        curl \
        curl-dev \
        icu-dev \
        npm \
        nodejs \
    && docker-php-ext-install pdo pdo_mysql mbstring zip intl bcmath

# 3️⃣ Composer kurulumu
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 4️⃣ Çalışma dizini
WORKDIR /var/www/html

# 5️⃣ Proje dosyalarını kopyala
COPY . .

# 6️⃣ Composer ile bağımlılıkları yükle
RUN composer install --no-dev --optimize-autoloader

# 7️⃣ Storage ve cache izinleri
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# 8️⃣ Laravel key generate (opsiyonel, dev için)
# RUN php artisan key:generate

# 9️⃣ Port (container port)
EXPOSE 9000

# 10️⃣ PHP-FPM başlat
CMD ["php-fpm"]
