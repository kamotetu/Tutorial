FROM php:7.3-apache-stretch AS base

RUN apt-get update && \
    apt-get install -y sudo libzip-dev zlib1g-dev vim nano graphviz libfreetype6-dev libjpeg62-turbo-dev libpng-dev libmcrypt-dev && \
    docker-php-ext-install mysqli pdo_mysql zip && \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && \
    docker-php-ext-install -j$(nproc) gd exif && \
    a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer \
    |  php -- \
        --filename=composer \
        --install-dir=/usr/local/bin \
    && chown www-data /var/www \
    && chmod g+s /var/www/html

RUN curl -SL https://deb.nodesource.com/setup_14.x | bash
RUN apt-get install -y nodejs && \
  npm install -g npm@latest && \
  npm install -g @vue/cli

ARG XDEBUG_INSTALL
ARG BOOL=true

RUN if [ ${XDEBUG_INSTALL} = ${BOOL} ]; then \
    pecl install xdebug \
      && docker-php-ext-enable xdebug; \
    fi

COPY ./php.ini /usr/local/etc/php/conf.d/php.ini
CMD ["apache2-foreground"]
