#!/bin/bash

set -e

echo "Deploying application..."

# Update codebase outside the container
git stash
git pull origin main

# Executar comandos dentro do contêiner Docker
docker exec -it  avisapp_app_1 bash -c '
  # Enter maintenance mode with a custom message 
  php artisan down --render="deploy"

  # Install dependencies based on lock file
  composer install --no-interaction --prefer-dist --optimize-autoloader

  # Migrate database
  php artisan migrate --force

  # Note: If you're using queue workers, this is the place to restart them.
  php artisan queue:restart

  # Register Permissions
  php artisan db:seed --class=PermissionsTableSeeder

  # Clear cache config
  php artisan config:clear
  php artisan cache:clear
  php artisan route:clear
  php artisan view:clear

  php artisan config:cache
  php artisan route:cache
  php artisan view:cache

  # Clear cache
  php artisan optimize:clear

  # Build frontend
  npm install
  npm run build

  # Exit maintenance mode 
  php artisan up
'


echo "Application deployed!"
