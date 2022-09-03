FROM php:8.1-rc-cli
RUN apt-get update && apt-get install -y unzip zlib1g-dev libicu-dev g++ librabbitmq-dev

ARG USER_ID=1000
#RUN mv /common/backend/php/php.ini $PHP_INI_DIR/php.ini
#COPY ./common/php/conf.d /usr/local/etc/php/conf.d
RUN pecl install redis amqp && docker-php-ext-enable redis amqp
RUN docker-php-ext-install pdo_mysql mysqli exif
RUN docker-php-ext-configure exif

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --quiet \
    && rm -rf /root/.composer/cache

RUN groupmod -o -g ${USER_ID} www-data && \
    usermod -o -u ${USER_ID} -g www-data www-data

RUN chown www-data:www-data ./ /var/www/
COPY --chown=www-data:www-data ./ /app
USER www-data

WORKDIR /app
