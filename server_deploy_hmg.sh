#!/bin/bash

set -e

APP_NAME='avisapp_app_1'

echo "Deploying application..."


# Enter maintenance mode
(docker exec ${APP_NAME} php artisan down --render="deploy") || true

#Update codebase
git fetch origin hmg
git reset --hard origin/hmg

# Install dependencies based on lock file
docker exec ${APP_NAME} composer install --no-interaction --prefer-dist --optimize-autoloader

# Migrate database
docker exec ${APP_NAME} php artisan migrate --force

# Note: If you're using queue workers, this is the place to restart them.
docker exec ${APP_NAME} php artisan queue:restart

# Register Permissions
docker exec ${APP_NAME} php artisan db:seed --class=PermissionsTableSeeder

# Clear cache config
docker exec ${APP_NAME} php artisan config:clear
docker exec ${APP_NAME} php artisan cache:clear
docker exec ${APP_NAME} php artisan route:clear
docker exec ${APP_NAME} php artisan view:clear

docker exec ${APP_NAME} php artisan config:cache
docker exec ${APP_NAME} php artisan route:cache
docker exec ${APP_NAME} php artisan view:cache

# Clear cache
docker exec ${APP_NAME} php artisan optimize:clear

# Build frontend
docker exec ${APP_NAME} npm install

docker exec ${APP_NAME} npm run build

# Exit maintenance mode
docker exec ${APP_NAME} php artisan up

echo "Application deployed!"
