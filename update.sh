#!/bin/bash

if [ composer.json -nt composer.lock ]; then
  composer install
fi

if [ package.json -nt yarn.lock ]; then
  yarn install
fi
