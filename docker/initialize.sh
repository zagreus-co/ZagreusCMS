#!/usr/bin/bash

CONTAINER_START_PATH="/CONTAINER_START_INFO"
if [ -f "$CONTAINER_START_PATH" ]; then
    echo "[+] Starting the swoole server..."
    php artisan octane:start --host=0.0.0.0 --port=80
else
    echo "Container first initialized at $(date) by $(whoami)" > $CONTAINER_START_PATH
    echo "[+] Initializing container at $(date)"
    
    cp .env.example .env

    # Installing PHP Dependencies
    composer install
    
    # Generate application key
    php artisan key:generate

    # Load migrations and seed database
    php artisan migrate --seed
    php artisan module:seed
    php artisan zagreus:load-permissions
    php artisan octane:start --host=0.0.0.0 --port=80
fi