cd /code
# composer
composer install

# cache clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# start discord bot
php artisan discord-bot:run &

chmod -R 777 /code/storage bootstrap/cache

echo "starting php-fpm"
php-fpm -F
