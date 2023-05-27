FROM php:8.1-fpm

RUN apt-get update

RUN apt-get install -y libzip-dev libpng-dev libicu-dev libpq-dev libxml2-dev

RUN docker-php-ext-install intl gd pdo zip sockets pcntl xml

RUN pecl install apcu
RUN docker-php-ext-enable apcu

RUN docker-php-ext-install pdo_mysql mysqli

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Moscow /etc/localtime
RUN "date"

WORKDIR /var/www/sveak/