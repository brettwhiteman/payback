FROM php:8-fpm-alpine

WORKDIR /app

RUN docker-php-ext-install -j$(nproc) bcmath pdo_mysql \
    && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && sed -i 's/\;zend_extension=opcache/zend_extension=opcache/' "$PHP_INI_DIR/php.ini" \
    && sed -i 's/#!\/bin\/sh/#!\/bin\/sh\n\nchown -R www-data:www-data \/app\/storage\n/' /usr/local/bin/docker-php-entrypoint
