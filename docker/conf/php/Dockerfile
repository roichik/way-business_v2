FROM php:8.4-fpm

# Установка системных зависимостей
RUN apt-get update && apt-get install -y \
        curl \
        git \
        zip \
        unzip \
        libfreetype6-dev \
        libzip-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        libpq-dev \
        libonig-dev \
        libmagickwand-dev \
        libmagickcore-dev \
        libgmp-dev


# Очистка Кеша установки
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure \
        # ref: https://github.com/docker-library/php/issues/920#issuecomment-562864296
        gd --enable-gd --with-freetype --with-jpeg --with-webp

# PHP розширения
RUN apt-get update  \
        && docker-php-ext-install pdo pdo_mysql mysqli mbstring exif pcntl bcmath gd zip xml dom gmp \
        && rm -rf /tmp/pear \
        && pecl install imagick \
        && docker-php-ext-enable imagick \
        && docker-php-ext-enable mysqli

#xDebug
RUN pecl install xdebug-3.4.5 && docker-php-ext-enable xdebug;

# Сразу ставим лимит загрузки на 64 метра
RUN echo "post_max_size = 64M" >> /usr/local/etc/php/conf.d/uploads.ini; \
    echo "upload_max_filesize = 64M" >> /usr/local/etc/php/conf.d/uploads.ini;

# Установка композитора
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Вешаем fpm на прослушивания порта
EXPOSE 9000
CMD ["php-fpm"]

