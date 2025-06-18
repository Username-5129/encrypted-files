cd fec
ddev start
sudo apt install -y composer
ddev composer install

/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.4)"
ddev composer global require laravel/installer
ddev composer require guzzlehttp/guzzle
ddev php artisan key:generate
ddev php artisan migrate