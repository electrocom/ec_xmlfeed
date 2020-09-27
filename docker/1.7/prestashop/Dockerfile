FROM prestashop/prestashop

# Use development php.ini
RUN cp "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# XDebug extension
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Enable XDebug
RUN echo '[XDebug] \n\
xdebug.remote_enable=1 \n\
xdebug.remote_host=host.docker.internal' >> /usr/local/etc/php/php.ini


COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
