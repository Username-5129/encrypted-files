### encrypted-files
Practical assignment for Web Technologies

### setup

# install laravel, composer and php:

/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.4)"


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
