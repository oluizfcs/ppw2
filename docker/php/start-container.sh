#!/usr/bin/env bash
if [ -f /var/www/html/artisan ]; then
    php artisan config:clear
    php artisan migrate
fi

/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf