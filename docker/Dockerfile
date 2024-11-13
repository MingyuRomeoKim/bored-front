FROM php:8.3-fpm

# 필요한 패키지 설치
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    vim

# PHP 확장 모듈 설치
RUN docker-php-ext-install pdo_mysql zip

# Composer 설치
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 권한 설정
RUN chown -R www-data:www-data /var/www/html

