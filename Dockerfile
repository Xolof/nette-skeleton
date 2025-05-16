FROM php:8-alpine

RUN docker-php-ext-install mysqli pdo_mysql

# Update the package lists and install git
RUN apk update && apk add --no-cache git

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add Composer to the PATH
ENV PATH="$PATH:/usr/local/bin"

# Create a group and user
RUN addgroup -S mumingroup
RUN adduser -S -u 1000 mumin -G mumingroup

WORKDIR /var/www
COPY . /var/www

RUN chown -R mumin:mumingroup ./log
RUN chown -R mumin:mumingroup ./temp/cache

USER mumin

