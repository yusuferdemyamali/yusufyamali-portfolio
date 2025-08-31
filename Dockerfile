# --- 1. Aşama: Bağımlılıkları Kur (Builder) ---
# PHP 8.2 ve Composer için temel bir imaj kullanıyoruz. Projenize göre PHP sürümünü (8.1, 8.3 vb.) değiştirebilirsiniz.
FROM composer:2 as builder

# Sistem bağımlılıklarını ve Laravel için gerekli PHP eklentilerini kur
# Alpine Linux tabanlı olduğu için 'apk' kullanıyoruz.
RUN apk add --no-cache \
    libpng-dev \
    libzip-dev \
    libjpeg-turbo-dev \
    oniguruma-dev \
    libxml2-dev \
    freetype-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    gd \
    intl \
    bcmath \
    opcache \
    pdo \
    pdo_mysql \
    zip \
    exif \
    pcntl

# Çalışma dizinini ayarla
WORKDIR /app

# Önce sadece bağımlılık dosyalarını kopyala. Bu sayede, kod değişse bile
# bağımlılıklar değişmediği sürece bu katman önbellekten kullanılır ve build hızlanır.
COPY composer.json composer.lock ./

# Composer bağımlılıklarını kur (production için optimize edilmiş şekilde)
RUN composer install --prefer-dist --no-scripts --no-dev --no-autoloader --no-progress

# Tüm uygulama kodunu kopyala
COPY . .

# Autoloader'ı oluştur ve scriptleri çalıştır
RUN composer dump-autoload --optimize && \
    composer run-script post-install-cmd --no-dev

# Laravel'i production için optimize et
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache


# --- 2. Aşama: Production Imajı (Final) ---
# Daha küçük ve güvenli bir temel imaj kullanıyoruz.
FROM php:8.2-fpm-alpine as final

# Builder aşamasında kurulan PHP eklentilerini burada da kuruyoruz.
# Sadece çalışma zamanında (runtime) gerekli olanları ekliyoruz.
RUN apk add --no-cache \
    libzip \
    libpng \
    libjpeg-turbo \
    freetype \
    libxml2 \
    oniguruma \
    && docker-php-ext-install \
    gd \
    intl \
    bcmath \
    opcache \
    pdo \
    pdo_mysql \
    zip \
    exif \
    pcntl

# Uygulama için www-data kullanıcısını ve grubunu ayarla
RUN addgroup -g 1000 -S www-data && \
    adduser -u 1000 -S www-data -G www-data

# Güvenlik için PHP-FPM'in root olarak çalışmasını engelle
COPY --from=builder /usr/local/etc/php-fpm.d/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

# Builder aşamasında derlenen uygulama dosyalarını kopyala
WORKDIR /var/www/html
COPY --from=builder --chown=www-data:www-data /app .

# Gerekli dizinlerin yazma izinlerini ayarla
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# PHP-FPM portunu dışarıya aç
EXPOSE 9000

# Container çalıştığında PHP-FPM servisini başlat
CMD ["php-fpm"]


# --- 3. Aşama: Web Sunucusu (Nginx) ---
# Nginx için küçük bir imaj kullanıyoruz.
FROM nginx:stable-alpine

# Nginx konfigurasyon dosyasını kopyala
# Bu dosyayı bir sonraki adımda oluşturacağız.
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Uygulamanın public dizinindeki dosyaları Nginx'in sunacağı dizine kopyala
COPY --from=final /var/www/html/public /var/www/html/public

# Nginx portunu dışarıya aç
EXPOSE 80

# Container çalıştığında Nginx'i başlat
CMD ["nginx", "-g", "daemon off;"]
