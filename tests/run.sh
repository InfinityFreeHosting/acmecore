#!/usr/bin/env bash

# Root directory
cd $( dirname "${BASH_SOURCE[0]}" )
cd ..

# Run PHPUnit inside the Docker container
docker compose exec -T phpunit php -d curl.cainfo=/app/tests/cacert.pem ./vendor/bin/phpunit "$@"
