#!/usr/bin/env sh

cd /var/www/html || exit

echo "ensuring folders exist"
runuser -u web -- mkdir -p storage/logs/
runuser -u web -- mkdir -p storage/app/public
runuser -u web -- mkdir -p storage/framework/cache/data
runuser -u web -- mkdir -p storage/framework/sessions
runuser -u web -- mkdir -p storage/framework/views
runuser -u web -- mkdir -p storage/framework/statamic

runuser -u web -- php artisan optimize
runuser -u web -- php artisan event:cache
runuser -u web -- php artisan view:cache
runuser -u web -- php please stache:warm
