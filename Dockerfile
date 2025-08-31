# 1️⃣ Base image
FROM php:8.2-fpm-alpine

# 2️⃣ Sistem paketleri ve PHP eklentileri
RUN apk add --no-cache \
        bash \
        git \
        unzip \
        libzip-dev \
        oniguruma-dev \
        curl \
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

# 5.5️⃣ .env dosyası ve database klasörü
# Eğer local .env dosyan yoksa .env.example kullanabilirsin
COPY .env.example .env
RUN mkdir -p database \
    && chown -R www-data:www-data database

# 6️⃣ Composer ile bağımlılıkları yükle
# --no-scripts kullanırsak package:discover sırasında DB hatası çıkmaz
RUN composer install --no-dev --optimize-autoloader --no-scripts

# 7️⃣ Storage ve cache izinleri
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# 8️⃣ Artisan optimize komutları (opsiyonel ama önerilir)
# RUN php artisan config:cache \
#     && php artisan route:cache \
#     && php artisan view:cache


# 9️⃣ Container port
EXPOSE 9000

# 🔟 PHP-FPM başlat
CMD ["php-fpm"]
