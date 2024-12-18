FROM php:8.3-fpm-alpine3.19

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS
RUN apk add --no-cache libzip-dev jpeg-dev libpng libpng-dev libjpeg-turbo-dev freetype-dev libwebp-dev zlib-dev libxpm-dev icu-dev unzip imagemagick-dev tiff-dev

RUN docker-php-ext-configure gd --with-webp --with-jpeg --with-freetype \
    && docker-php-ext-install -j$(nproc) gd mysqli pdo pdo_mysql zip opcache exif;

# RUN pecl install imagick && docker-php-ext-enable imagick
RUN pecl install pcov && docker-php-ext-enable pcov

RUN set -ex && apk --no-cache add libxml2-dev
RUN docker-php-ext-install soap && docker-php-ext-enable soap
RUN docker-php-ext-install bcmath

RUN pecl install excimer && docker-php-ext-enable excimer
RUN docker-php-ext-install calendar && docker-php-ext-configure calendar

# COMPOSER INSTALLATION
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apk del -f .build-deps

COPY ./php.ini /usr/local/etc/php/php.ini
COPY ./entrypoint.sh /entrypoint.sh

EXPOSE 9000

ENTRYPOINT /entrypoint.sh

