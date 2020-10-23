FROM php:7.4-fpm-alpine

ARG TIMEZONE

RUN set -ex && apk add coreutils make openssl git unzip postgresql-dev

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
&& composer --version

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
&& printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
&& "date"

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install ctype iconv json pdo_pgsql


# install xdebug
RUN apk add --no-cache $PHPIZE_DEPS && pecl install xdebug && docker-php-ext-enable xdebug

COPY symfony.ini /usr/local/etc/php/conf.d/
COPY symfony.ini /usr/local/etc/php/cli/conf.d/
COPY xdebug.ini  /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY symfony.pool.conf /usr/local/etc/php/php-fpm.d/

CMD ["php-fpm", "-F"]

WORKDIR /deve/inova/skeleton/api
EXPOSE 9000
