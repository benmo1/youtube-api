#!/usr/bin/env sh

echo 'Defining convenience aliases...'

set -x

alias start='(. .env && cd ./build/dev && docker-compose up -d)'
alias stop='(cd ./build/dev && docker-compose down)'
alias test='(cd ./build/dev && docker-compose exec slim ./vendor/bin/phpunit)'

{ set +x; } 2>/dev/null
