FROM php:8.1-rc-fpm
#ARG USER_ID
#ARG GROUP_ID

RUN apt-get update && apt-get install -y librabbitmq-dev

RUN docker-php-ext-install pdo_mysql mysqli exif
RUN pecl install redis amqp  && docker-php-ext-enable redis amqp
RUN docker-php-ext-configure exif


#RUN docker-php-ext-enable xdebug
#RUN usermod -u ${USER_ID} && groupmod -g ${GROUP_ID}
ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; \
    then \
      pecl install xdebug && docker-php-ext-enable xdebug; \
    fi;
COPY ./docker/common/backend/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

USER "${USER_ID}:${GROUP_ID}"
RUN echo '#!/bin/bash \n\n service cron start \n\n exec $@ ' > /app-entrypoint.sh
RUN cat /app-entrypoint.sh
RUN chmod a+x /app-entrypoint.sh

ENTRYPOINT ["/app-entrypoint.sh"]
CMD ["php-fpm"]
WORKDIR /app

