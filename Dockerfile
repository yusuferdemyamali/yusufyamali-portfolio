# ----- 1. Aşama: Bağımlılıkları Kurma ve Uygulamayı Hazırlama -----
# Daha geniş paket desteği için Debian tabanlı bir PHP CLI imajı kullanıyoruz.
FROM php:8.3-cli AS build

# Sistemin paket listesini güncelliyoruz.
RUN apt-get update && apt-get install -y \
    git \
    libzip-dev \
    libjpeg-dev \
    libpng-dev \
    libicu-dev \
    libonig-dev \
    unzip

# Gerekli PHP uzantılarını yüklüyoruz.
RUN docker-php-ext-install pdo_mysql gd zip intl mbstring

WORKDIR /app

# Composer'ı bu aşamada kuruyoruz.
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Projenin bağımlılıklarını kurmak için `composer.json` ve `composer.lock` dosyalarını kopyala.
COPY composer.json composer.lock ./

# Bağımlılıkları kur.
RUN composer install --no-dev --no-autoloader --optimize-autoloader

# Gerekli tüm dosyaları imaja kopyala.
COPY . .

# Laravel'in autoloader'ını optimize et.
RUN composer dump-autoload --optimize

# ----- 2. Aşama: Üretim (Production) İçin Hafif Bir Nginx İmajı Oluşturma -----
FROM php:8.3-fpm

# Gerekli Debian paketlerini yüklüyoruz.
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    libzip-dev \
    libjpeg-dev \
    libpng-dev \
    libicu-dev \
    libonig-dev \
    unzip \
    mysql-client

# PHP uzantılarını tekrar yüklüyoruz.
RUN docker-php-ext-install pdo_mysql gd zip intl mbstring

# Laravel'in çalışacağı kullanıcıyı ve grubu oluştur.
RUN useradd -ms /bin/bash laravel

# Uygulamanın dizinini ayarla ve gerekli izinleri ver.
WORKDIR /var/www/html
COPY --from=build --chown=laravel:laravel /app .

# Depolama (storage) ve cache klasörlerine yazma izinlerini ver.
RUN chown -R laravel:laravel /var/www/html/storage \
    && chown -R laravel:laravel /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# PHP-FPM, Nginx ve Supervisor yapılandırma dosyalarını kopyala.
COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/php.ini /etc/php/8.3/fpm/php.ini

# Varsayılan Nginx ayarlarını sil ve kendi ayarlarımızı etkinleştir.
RUN rm /etc/nginx/sites-enabled/default \
    && ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Portu dışarıya aç.
EXPOSE 80

# Supervisor'ı başlatarak PHP-FPM ve Nginx servislerini çalıştır.
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
