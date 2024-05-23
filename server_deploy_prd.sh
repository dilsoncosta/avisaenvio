#!/bin/bash

set -e

echo "Deploying application..."

# Enter maintenance mode
(docker exec avisapp_app_1 php artisan down) || true

#Update codebase
git fetch origin main
git reset --hard origin/main

# Install dependencies based on lock file
docker exec avisapp_app_1 composer install

