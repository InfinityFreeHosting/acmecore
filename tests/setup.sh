#!/usr/bin/env bash

# Root directory
cd $( dirname "${BASH_SOURCE[0]}" )
cd ..

# Set PEBBLE_MODE if not already set
export PEBBLE_MODE=${PEBBLE_MODE:-default}

# Start services using docker-compose
docker compose up -d

# Wait for services to be ready
docker compose run --rm wait
