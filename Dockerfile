FROM php:7.2-apache

COPY ./PilotSystem /var/www/html/

## Change the document root to the public folder:
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

## Install and enable pdo_mysql driver:
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install calendar

## Install dependencies for later use
RUN apt-get update && \
    apt-get install -y --no-install-recommends git zip unzip wget sqlite3 dos2unix vim

## Install composer to image
COPY ./composer-install.sh /var/www/html
RUN dos2unix ./composer-install.sh
WORKDIR /var/www/html
RUN bash ./composer-install.sh
RUN rm ./composer-install.sh

## Get the vendor directory for the app root
RUN composer install

## Gabs the phpunit from image vendor folder so the Unit tests can run
## You still need to run the actual unit tests in the image BASH enviroment
RUN cp vendor/bin/phpunit ./phpunit
