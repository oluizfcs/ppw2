#!/usr/bin/env bash
if [ -f /var/www/html/artisan ]; then
    npm run build

    sleep 10

    php artisan config:clear
    php artisan migrate
    php artisan db:seed
fi

/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf