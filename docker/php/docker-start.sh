#!/bin/bash
# composer install --no-scripts

php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear

apache2-foreground

#exec "$@"