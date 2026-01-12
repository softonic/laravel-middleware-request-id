FROM composer:2

# Install build dependencies
RUN apk add --no-cache $PHPIZE_DEPS linux-headers

# Install PCOV (for fast code coverage)
RUN pecl install pcov && docker-php-ext-enable pcov

# Install Xdebug (for debugging when needed)
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Clean up
RUN apk del $PHPIZE_DEPS linux-headers

# Configure PCOV (enabled by default for tests)
RUN echo "pcov.enabled=1" >> /usr/local/etc/php/conf.d/docker-php-ext-pcov.ini

# Configure Xdebug (disabled by default, enable when debugging)
RUN echo "xdebug.mode=off" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Disable Xdebug by default to use PCOV for coverage
RUN mv /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini.disabled

WORKDIR /app
