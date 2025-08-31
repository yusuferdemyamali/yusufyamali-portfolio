# ----- 1. Aşama: Bağımlılıkları Kurma ve Uygulamayı Hazırlama -----
FROM composer:2 AS build
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-autoloader --optimize-autoloader
COPY . .
RUN composer dump-autoload --optimize

# ----- 2. Aşama: Üretim (Production) İçin Hafif Bir Nginx İmajı Oluşturma -----
FROM php:8.1-fpm-alpine

# Gerekli PHP uzantılarını ve sistem bağımlılıklarını kur
# "intl-dev" paketini ekleyerek eksik olan "intl" uzantısını yüklüyoruz.
RUN apk add --no-cache \
    libzip-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    mysql-client \
    oniguruma-dev \
    intl-dev \
    && docker-php-ext-install pdo_mysql exif gd zip intl

# Nginx'i ve ilgili araçları kur
RUN apk add --no-cache nginx supervisor

# Laravel'in çalışacağı kullanıcıyı ve grubu oluştur
RUN addgroup -S laravel && adduser -S laravel -G laravel

# Uygulamanın dizinini ayarla ve gerekli izinleri ver
WORKDIR /var/www/html
COPY --from=build --chown=laravel:laravel /app .
RUN chmod -R 775 storage bootstrap/cache

# PHP-FPM, Nginx ve Supervisor yapılandırma dosyalarını kopyala
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/php.ini /usr/local/etc/php/php.ini

# Portu dışarıya aç
EXPOSE 80

# Supervisor'ı başlatarak PHP-FPM ve Nginx servislerini çalıştır
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
