### encrypted-files
Practical assignment for Web Technologies

### setup

# install laravel, composer and php:

/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.4)"

# .env:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fec
DB_USERNAME=fec_user
DB_PASSWORD=fec_database_password


# using MySql
installing server:
sudo apt install mysql-server

check if mysql is running:
sudo service mysql status

log in as root mysql:
sudo mysql

create database and user with privileges:
CREATE DATABASE fec;
CREATE USER 'fec_user'@'localhost' IDENTIFIED BY 'fec_database_password';
GRANT ALL PRIVILEGES ON fec.* TO 'fec_user'@'localhost';
FLUSH PRIVILEGES;


composer install
composer global require laravel/installer

php artisan key:generate

php artisan migrate


npm install && npm run build


php artisan serve

composer run dev

















# docker attempt

# start docker
docker compose -f compose.dev.yaml up --build -d

# setup
docker compose -f compose.dev.yaml exec workspace composer install
docker compose -f compose.dev.yaml exec workspace php artisan key:generate






# to server
https://www.youtube.com/watch?v=G5Nk4VykcUw





### setup (FEC-old)

cd FEC

# Build and Start the Containers

docker-compose up -d --build

# Run Laravel Migrations

docker-compose exec app php artisan migrate


# install Composer Dependecies

docker exec -it laravel-app /bin/bash

# if not already in /var/www

cd /var/www

# install packages

composer install --no-dev --optimize-autoloader

# php artisan (enter docker exec)

docker exec -it laravel-app /bin/bash


php artisan key:generate

php artisan migrate




