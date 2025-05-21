FROM dunglas/frankenphp:php8.3

ARG NODE_VERSION=22

RUN cp $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN \
    apt-get -yq update && apt-get install -yq \
        zip

RUN install-php-extensions \
        apcu \
        bcmath \
        exif \
        gd \
        igbinary \
        imagick \
        imap \
        intl \
        mysqli \
        pdo \
        pdo_mysql \
        pgsql \
        soap \
        sockets \
        ssh2 \
        zip

RUN curl -sLS https://deb.nodesource.com/setup_$NODE_VERSION.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm

ENV SERVER_NAME=:80

COPY . /app
