#!/bin/bash

echo "Clearing Laravel cache..."
cd "$(dirname "$0")"
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
echo ""
echo "Cache cleared successfully!"

