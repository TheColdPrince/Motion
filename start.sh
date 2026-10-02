#!/usr/bin/env sh
set -e
command -v php >/dev/null 2>&1 || { echo "PHP is required. Install PHP first."; exit 1; }
echo "Motion Studio: http://127.0.0.1:8080/"
echo "Press Ctrl+C to stop."
php -S 127.0.0.1:8080 -t "$(CDPATH= cd -- "$(dirname -- "$0")" && pwd)"
