#!/usr/bin/env sh

echo 'Defining convenience aliases...'

set -x

alias build='. ./build.sh'
alias start='docker-compose up -d'
alias stop='docker-compose down'
alias test='docker-compose exec slim ./vendor/bin/phpunit'

{ set +x; } 2>/dev/null
