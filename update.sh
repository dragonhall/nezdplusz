#!/bin/bash

if [ composer.json -nt composer.lock ]; then
  composer install
fi

if [ package.json -nt package.lock ]; then
  npm install
fi
