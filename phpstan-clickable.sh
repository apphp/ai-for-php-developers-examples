#!/bin/bash
PSALM_OUTPUT=$(vendor/bin/phpstan analyse --configuration phpstan.neon "$@")

# Read OS_APP_DIRECTORY value from .env
ENV_FILE="../.env"
OS_APP_DIRECTORY=$(grep '^OS_APP_DIRECTORY=' "$ENV_FILE" | cut -d '=' -f2)

# Base path to replace
BASE_PATH="file://$OS_APP_DIRECTORY/protected/"

# Convert the paths to the specified base path in file:/// URL format
#CLICKABLE_OUTPUT=$(echo "$PSALM_OUTPUT" | sed -E "s#(?<!app\\\\)(modules|helpers|components|jobs)#$BASE_PATH\1#g")
# Don't handle routes, starting from app\...
CLICKABLE_OUTPUT=$(echo "$PSALM_OUTPUT" | perl -pe "s#(?<!app\\\\)(commands|extensions|controllers|forms|migrations|models|modules|helpers|components|jobs)#${BASE_PATH}\1#g")

# Output the result
echo "$CLICKABLE_OUTPUT"
