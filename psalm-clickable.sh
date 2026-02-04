#!/bin/bash
PSALM_OUTPUT=$(vendor/bin/psalm --config=psalm.xml --show-info=true --threads=6 "$@")

# Read OS_APP_DIRECTORY value from .env
ENV_FILE=".env"
OS_APP_DIRECTORY=$(grep '^OS_APP_DIRECTORY=' "$ENV_FILE" | cut -d '=' -f2)

# Base path to replace
BASE_PATH="file://$OS_APP_DIRECTORY/"

# Don't handle routes, starting from app\...
CLICKABLE_OUTPUT=$(echo "$PSALM_OUTPUT" | perl -pe "s#(?<!app\\\\)(app|tests|views)#${BASE_PATH}\1#g")

# Output the result
echo "$CLICKABLE_OUTPUT"
