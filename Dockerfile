FROM php:5.6-apache

RUN docker-php-ext-install pdo pdo_mysql

RUN a2enmod rewrite

COPY apache2.conf /etc/apache2/sites-available/000-default.conf
