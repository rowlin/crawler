FROM php:8.1-rc-fpm
#ARG USER_ID
#ARG GROUP_ID

RUN apt-get update
RUN apt-get install -y  cron

RUN docker-php-ext-install pdo_mysql mysqli
#RUN docker-php-ext-install intl
RUN docker-php-ext-install exif
#RUN docker-php-ext-configure intl
RUN docker-php-ext-configure exif



#RUN docker-php-ext-enable xdebug
#RUN usermod -u ${USER_ID} && groupmod -g ${GROUP_ID}
ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; \
    then \
      pecl install xdebug && docker-php-ext-enable xdebug; \
    fi;
#COPY ./docker/common/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY ./docker/common/backend/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN touch /var/log/schedule.log
RUN chmod 0777 /var/log/schedule.log

# Add crontab file in the cron directory
RUN echo "* * * * * su -c 'php  /app/bin/console app:run >> /var/log/schedule.log 2>&1'" > /etc/cron.d/scheduler

RUN crontab /etc/cron.d/scheduler
#USER "${USER_ID}:${GROUP_ID}"

WORKDIR /app
