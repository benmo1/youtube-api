#!/usr/bin/env sh

echo "Installing vendor libraries..."
#if [ "$(docker images -q local:php 2> /dev/null)" == "" ]; then
    docker build ./slim/ -t local:php
#fi
#if [ "$(docker images -q mycomposer 2> /dev/null)" == "" ]; then
    docker build ./composer -t mycomposer
#fi
docker run --rm --interactive --tty --volume "$PWD/../../":/app -w="/app" mycomposer install --no-plugins --no-scripts

if ! [ -f "../../.env" ] ; then
    echo "Creating .env file..."
    cp "../../.env.example" "../../.env"
    cat <<MSG
------------------------------------------------
-- PLEASE ADD YOUTUBE_API_KEY TO THE ENV FILE --
------------------------------------------------
MSG
else
    echo ".env file exists... skipping creation..."
fi
