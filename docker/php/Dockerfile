FROM php:8.3-fpm-bookworm

# EasyCMS(ThinkPHP 3.1.3) 所需扩展：mysqli/pdo_mysql 数据库连接，gd 验证码与缩略图，zip 备份压缩
RUN apt-get update && apt-get install -y --no-install-recommends \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" gd mysqli pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*
