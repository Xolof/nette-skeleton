FROM php:8-alpine

RUN docker-php-ext-install mysqli pdo_mysql

RUN useradd -u 1000 -ms /bin/bash mumin

WORKDIR /var/www
COPY . /var/www

RUN chown -R mumin:mumin log
RUN chown -R mumin:mumin cache

USER mumin

