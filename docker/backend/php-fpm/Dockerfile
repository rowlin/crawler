FROM php:7.4-rc-fpm
#ARG USER_ID
#ARG GROUP_ID
RUN docker-php-ext-install pdo_mysql mysqli
#RUN docker-php-ext-enable xdebug
#RUN usermod -u ${USER_ID} && groupmod -g ${GROUP_ID}
ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; \
    then \
      pecl install xdebug && docker-php-ext-enable xdebug; \
    fi;
#COPY ./docker/common/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY ./docker/common/backend/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

#USER "${USER_ID}:${GROUP_ID}"

WORKDIR /app
