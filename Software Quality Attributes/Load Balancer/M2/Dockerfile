FROM php:7.2-apache

RUN apt-get update && apt-get install -y

RUN docker-php-ext-install mysqli pdo_mysql

RUN mkdir /app \
 && mkdir /app/sa \
 && mkdir /app/sa/www

COPY www/ /app/sa/www/

RUN cp -r /app/sa/www/* /var/www/html/.
