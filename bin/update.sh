#!/bin/bash

ME="$(readlink -f "$0")"
MYDIR="$(dirname "${ME}")"

APP_ROOT="$(dirname "${MYDIR}")"

cd "${APP_ROOT}" || exit 0

if [ composer.json -nt composer.lock ]; then
  composer install
fi

if [ package.json -nt yarn.lock ]; then
  yarn install
fi
