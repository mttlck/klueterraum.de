#!/usr/bin/env sh

cd /var/www/html || exit

runuser -u web -- php artisan optimize
runuser -u web -- php artisan event:cache
runuser -u web -- php artisan view:cache
runuser -u web -- php please stache:warm
