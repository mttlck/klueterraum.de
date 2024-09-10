FROM unit:php8.3 AS base

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN apt update \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt install nodejs p7zip-full -y \
    && apt purge -y --auto-remove

COPY --from=mlocati/php-extension-installer:latest /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions opcache intl zip bcmath exif pcntl sockets Imagick/imagick@master

COPY ./docker/docker.php.ini $PHP_INI_DIR/conf.d/
COPY ./docker/config.json /docker-entrypoint.d/
COPY ./docker/00-setup.sh /docker-entrypoint.d/

WORKDIR /var/www/html


ARG RUN_UID=1033
ARG RUN_GID=1033
RUN addgroup --system --gid $RUN_GID web && adduser web --system --uid $RUN_UID --ingroup web

USER web

COPY --chown=web:web . .

RUN composer install --no-interaction --no-dev --classmap-authoritative \
    && php artisan storage:link \
    && php artisan event:clear \
    && php artisan view:clear \
    && php artisan route:clear \
    && php artisan config:clear \
    && php artisan clear-compiled \
    && php artisan package:discover \
    && composer clear-cache

RUN npm ci --no-cache && npm run build && rm -rf node_modules

USER root
