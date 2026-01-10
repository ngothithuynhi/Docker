#!/bin/bash

# Install dependencies if not already installed (useful for first run)
if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction
fi

# Generate key if not set
if [ -f ".env" ]; then
    if ! grep -q "APP_KEY=base64" .env; then
        php artisan key:generate
    fi
else
    cp .env.example .env
    php artisan key:generate
fi

# Run migrations (wait for DB to be ready ideally, but retry logic or sleep can handle it)
# For simplicity, we just try to run it. If DB isn't ready, it might fail, 
# but subsequent restarts will fix it or we can add a 'wait-for-it' script later.
php artisan migrate --force

# Link storage
php artisan storage:link

# Start Laravel server
php artisan serve --host=0.0.0.0 --port=8000
