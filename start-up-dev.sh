#!/bin/bash

BASE_PATH=$(dirname "$(readlink -f "$0")")

if [ ! -d "${BASE_PATH}/vendor" ]; then
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php82-composer:latest \
        composer install --ignore-platform-reqs
else
    if [ -f ${BASE_PATH}/vendor/laravel/sail/bin/sail ]; then
        ${BASE_PATH}/vendor/laravel/sail/bin/sail up
    fi
fi
