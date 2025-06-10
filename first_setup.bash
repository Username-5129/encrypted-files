cd fec
ddev start
sudo apt install -y composer
ddev composer install

/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.4)"
composer global require laravel/installer
ddev php artisan key:generate
ddev php artisan migrate