#!/bin/sh
set -e

mkdir -p /var/www/html/cache
chown -R www-data:www-data /var/www/html/cache

exec apache2-foreground
