#!/usr/bin/env bash

# Root directory
cd $( dirname "${BASH_SOURCE[0]}" )
cd ..

# Stop and remove all services
docker compose down -v
