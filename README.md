### encrypted-files
Practical assignment for Web Technologies

### Setup

# Start ddev
ddev start
ddev phpmyadmin
composer install

# Start dev
ddev npm run dev

# Reset database
ddev php artisan migrate:refresh --seed
