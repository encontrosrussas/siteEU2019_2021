FROM php:5.6-apache

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN apt-get update -y && apt-get install -y libpng-dev zlib1g-dev 

RUN docker-php-ext-install gd

RUN a2enmod rewrite 