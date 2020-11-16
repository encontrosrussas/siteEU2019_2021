FROM php:5.6-apache

RUN apt-get update -y && apt-get install -y libpng-dev zlib1g-dev git zip unzip && a2enmod rewrite

RUN docker-php-ext-install pdo pdo_mysql mysqli gd zip

RUN apt-get install -y curl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer