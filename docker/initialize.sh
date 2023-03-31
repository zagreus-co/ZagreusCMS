#!/bin/bash

echo '[+] Sleep for 20 seconds to make sure database is booted...'
sleep 20s

CONTAINER_START_PATH="/CONTAINER_START_INFO"
cd /app

if [ -f "$CONTAINER_START_PATH" ]; then
    echo "[+] Starting the PHP-FPM..."
    # php artisan octane:start --host=0.0.0.0 --port=8000

    supervisord -c /etc/supervisor/conf.d/supervisord.conf

    php-fpm -R
else
    echo "Container first initialized at $(date) by $(whoami)" > $CONTAINER_START_PATH
    echo "[+] Initializing container at $(date)"
    
    echo '[+] Start installing migrations...'

    # Load migrations and seed database
    php artisan migrate --seed
    php artisan module:seed
    php artisan zagreus:load-permissions
    # php artisan octane:start --host=0.0.0.0 --port=8000

    supervisord -c /etc/supervisor/conf.d/supervisord.conf

    php-fpm -R
fi