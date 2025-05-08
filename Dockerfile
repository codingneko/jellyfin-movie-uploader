FROM php:8.4-apache

WORKDIR /var/www/html

COPY src .
COPY .htpasswd /etc/apache2/.htpasswd
COPY php.ini /usr/local/etc/php/conf.d/user_settings.ini

EXPOSE 80