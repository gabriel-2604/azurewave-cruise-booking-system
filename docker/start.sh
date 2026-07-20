#!/bin/bash
set -e

php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan storage:link || true

php artisan migrate --force
php artisan db:seed --force

php artisan config:cache
php artisan route:cache
php artisan view:cache

apache2-foreground