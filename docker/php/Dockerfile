FROM php:7.4-fpm
COPY php.ini /usr/local/etc/php/

RUN apt-get update \
  && apt-get install -y libzip-dev mariadb-client curl git zip unzip libicu-dev \
  && docker-php-ext-install zip intl pdo_mysql

RUN apt-get install -y \
    curl \
    gnupg libpq-dev
RUN curl -sL https://deb.nodesource.com/setup_11.x | bash -
RUN apt-get install -y nodejs
RUN npm install npm@latest -g

#Composer install
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1

ENV COMPOSER_HOME /composer

ENV PATH $PATH:/composer/vendor/bin

WORKDIR /var/www/html