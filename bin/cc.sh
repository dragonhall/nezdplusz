#!/bin/bash

ME="$(readlink -f "$0")"
MYDIR="$(dirname "${ME}")"

APP_ROOT="$(dirname "${MYDIR}")"

cd "${APP_ROOT}" || exit 0

echo " >> Clearing cache"
find cache templates_c -type f -delete
