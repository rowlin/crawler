FROM php:8.1-rc-cli

RUN apt-get update
RUN apt-get install -y vim cron librabbitmq-dev

RUN docker-php-ext-install pdo_mysql mysqli exif
RUN pecl install redis amqp && docker-php-ext-enable redis amqp
RUN docker-php-ext-configure exif
#
RUN touch /var/log/schedule.log
RUN chmod 0777 /var/log/schedule.log
#
## Add crontab file in the cron directory
RUN  echo "*/5 * * * * /usr/local/bin/php /app/bin/console app:run >> /var/log/schedule.log 2>&1" >  /etc/cron.d/scheduler
RUN chmod 0644 /etc/cron.d/scheduler
#
RUN crontab /etc/cron.d/scheduler

#CMD bash -c "cron"
WORKDIR /app
# ENTRYPOINT ["bash"]
