# ----- 1. Aşama: Bağımlılıkları Kurma ve Uygulamayı Hazırlama -----
# PHP CLI imajını kullanıyoruz, çünkü Composer'ın çalışması için gerekli.
FROM php:8.3-cli-alpine AS build

# Gerekli PHP uzantılarını ve sistem bağımlılıklarını kur
# "intl" uzantısını yüklemek için "libicu-dev" paketini kullanıyoruz.
RUN apk add --no-cache \
    libzip-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    mysql-client \
    libicu-dev \
    && docker-php-ext-install pdo_mysql exif gd zip intl

WORKDIR /app

# Composer'ı bu aşamada kuruyoruz
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Projenin bağımlılıklarını kurmak için `composer.lock` ve `composer.json` dosyalarını kopyala
COPY composer.json composer.lock ./

# Bağımlılıkları kur
RUN composer install --no-dev --no-autoloader --optimize-autoloader

# Gerekli tüm dosyaları imaja kopyala
COPY . .

# Laravel'in autoloader'ını optimize et
RUN composer dump-autoload --optimize

# ----- 2. Aşama: Üretim (Production) İçin Hafif Bir Nginx İmajı Oluşturma -----
FROM php:8.3-fpm-alpine

# Gerekli PHP uzantılarını ve sistem bağımlılıklarını kur
# "libicu-dev" paketini tekrar ekliyoruz.
RUN apk add --no-cache \
    libzip-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    mysql-client \
    oniguruma-dev \
    libicu-dev \
    && docker-php-ext-install pdo_mysql exif gd zip intl

# Nginx'i ve ilgili araçları kur
RUN apk add --no-cache nginx supervisor

# Laravel'in çalışacağı kullanıcıyı ve grubu oluştur
RUN addgroup -S laravel && adduser -S laravel -G laravel

# Uygulamanın dizinini ayarla ve gerekli izinleri ver
WORKDIR /var/www/html
COPY --from=build --chown=laravel:laravel /app .

# Depolama (storage) ve cache klasörlerine yazma izinlerini ver
RUN chmod -R 775 storage bootstrap/cache

# PHP-FPM, Nginx ve Supervisor yapılandırma dosyalarını kopyala
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/php.ini /usr/local/etc/php/php.ini

# Portu dışarıya aç
EXPOSE 80

# Supervisor'ı başlatarak PHP-FPM ve Nginx servislerini çalıştır
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
