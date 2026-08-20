FROM php:7.4-apache

# --- OS packages -----------------------------------------------------------
# Build/runtime libs for the PHP extensions we compile below.
RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        ca-certificates curl gnupg apt-transport-https openssl \
        libicu-dev \
        libpng-dev libjpeg-dev libfreetype6-dev \
        libzip-dev \
        unixodbc-dev; \
    rm -rf /var/lib/apt/lists/*


RUN set -eux; \
    curl -fsSL -o /tmp/msprod.deb https://packages.microsoft.com/config/debian/11/packages-microsoft-prod.deb; \
    dpkg -i /tmp/msprod.deb; \
    rm /tmp/msprod.deb; \
    apt-get update; \
    ACCEPT_EULA=Y apt-get install -y --no-install-recommends msodbcsql17; \
    rm -rf /var/lib/apt/lists/*

# --- PHP extensions --------------------------------------------------------
# Default image already ships: mbstring, openssl, curl, fileinfo, json, pdo.
# We add: gd, intl, zip (build), and sqlsrv/pdo_sqlsrv (PECL).
RUN set -eux; \
    docker-php-ext-configure gd --with-freetype --with-jpeg; \
    docker-php-ext-install -j"$(nproc)" gd intl zip; \
    pecl install sqlsrv-5.10.1 pdo_sqlsrv-5.10.1; \
    docker-php-ext-enable sqlsrv pdo_sqlsrv

# --- Apache ----------------------------------------------------------------
RUN set -eux; \
    a2enmod rewrite ssl headers speling; \
    mkdir -p /etc/apache2/ssl

COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf
COPY docker/php.ini           /usr/local/etc/php/conf.d/zzz-app.ini
COPY docker/entrypoint.sh     /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# --- App source ------------------------------------------------------------
# The app is served straight from DocumentRoot (base_url = https://127.0.0.1:4443/),
# so public_html IS /var/www/html -- no sub-path, no symlink.
# Baked in so the image runs standalone; docker-compose bind-mounts the same
# folders over these for live editing during development.
COPY src/public_html /var/www/html
COPY src/upload      /var/www/upload

EXPOSE 443
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["apache2-foreground"]
