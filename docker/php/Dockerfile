FROM php:8.1-fpm

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    IPE_GD_WITHOUTAVIF=1 install-php-extensions gd apcu opcache pdo_pgsql zip intl