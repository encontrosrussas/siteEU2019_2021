FROM php:5.6-apache
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN a2enmod rewrite 