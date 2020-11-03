cd /code
# composer
composer install

php artisan key:generate

# cache clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# database mingrate
php artisan migrate
php artisan db:seed

chmod -R 777 /code/storage bootstrap/cache

echo "starting php-fpm"
exec $@
zZ
