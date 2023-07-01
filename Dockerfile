FROM php:7.4-apache

ARG BUILD_ENV=production
ARG PHP_INI_ENV=development # to see conn errors in browser

#RUN mv "$PHP_INI_DIR/php.ini-$BUILD_ENV" "$PHP_INI_DIR/php.ini"
RUN mv "$PHP_INI_DIR/php.ini-$PHP_INI_ENV" "$PHP_INI_DIR/php.ini"

RUN apt-get update
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
  install-php-extensions redis

RUN if [ "$BUILD_ENV" = "development" ] ; then install-php-extensions xdebug-^2 ; fi

WORKDIR /var/www/html

COPY --chown=www-data:www-data . .
