FROM php:8-alpine

# Install MySQL extensions
RUN docker-php-ext-install mysqli pdo_mysql

