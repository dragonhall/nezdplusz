#!/bin/bash

ME="$(readlink -f "$0")"
MYDIR="$(dirname "${ME}")"

APP_ROOT="$(dirname "${MYDIR}")"

cd "${APP_ROOT}" || exit 0

echo " >> Fixing permissions"
chown -R dragonhall:ftpgroup "${APP_ROOT}"
chown -R www-data:www-data cache templates_c
