#!/bin/bash

echo '[+] Sleep for 10 seconds to make sure database is booted...'
sleep 10s

CONTAINER_START_PATH="/CONTAINER_START_INFO"
cd /app

if [ -f "$CONTAINER_START_PATH" ]; then
    echo "[+] Starting the Octane..."

    supervisord -c /etc/supervisor/conf.d/supervisord.conf

    php artisan octane:start --server=swoole --host=0.0.0.0 --port=8000
else
    echo "Container first initialized at $(date) by $(whoami)" > $CONTAINER_START_PATH
    echo "[+] Initializing container at $(date)"

    supervisord -c /etc/supervisor/conf.d/supervisord.conf

    if [ -d "./vendor/" ]  
    then
        php artisan octane:start --server=swoole --host=0.0.0.0 --port=8000
    else
        composer install

        echo "[+] Generating application key"
        php artisan key:generate

        echo '[+] Start installing migrations...'

        # Load migrations and seed database
        php artisan migrate --seed
        php artisan module:seed
        php artisan zagreus:load-permissions
    fi
fi