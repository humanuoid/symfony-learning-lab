FROM dunglas/frankenphp:php8.4-alpine

RUN install-php-extensions \
    pdo_pgsql \
    apcu \
    opcache \
    intl \
    gd \
    zip \
    xdebug

ARG USER=appuser
RUN adduser -D $USER && \
    setcap CAP_NET_BIND_SERVICE=+eip /usr/local/bin/frankenphp && \
    chown -R $USER:$USER /config/caddy /data/caddy /app
USER $USER
