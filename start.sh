#!/bin/bash

echo "Running migrations..."
php artisan migrate --force --seed || echo "⚠️ Migrations failed! (Check your DB credentials in Railway Variables)"

echo "Linking storage..."
php artisan storage:link || echo "⚠️ Storage link failed or already exists."

echo "Starting server on port ${PORT:-8080}..."
php artisan serve --host=0.0.0.0 --port="${PORT:-8080}"
