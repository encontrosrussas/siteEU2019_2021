FROM php:5.6-apache

RUN apt-get update -y && apt-get install -y libpng-dev zlib1g-dev git && a2enmod rewrite 

RUN docker-php-ext-install pdo pdo_mysql mysqli gd
