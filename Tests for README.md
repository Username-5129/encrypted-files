# Tests for README.md

## 1. DDEV Setup

- [ ] README.md contains `ddev start`
- [ ] README.md contains `ddev phpmyadmin`
- [ ] README.md contains `composer install` after ddev commands

## 2. Laravel Installation

- [ ] README.md contains Laravel installation command via composer or installer
- [ ] README.md contains `/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.4)"` for PHP setup
- [ ] README.md contains `composer global require laravel/installer`
- [ ] README.md contains `php artisan key:generate`
- [ ] README.md contains `php artisan migrate`

## 3. .env Configuration

- [ ] README.md documents all required `.env` variables:
    - [ ] `DB_CONNECTION`
    - [ ] `DB_HOST`
    - [ ] `DB_PORT`
    - [ ] `DB_DATABASE`
    - [ ] `DB_USERNAME`
    - [ ] `DB_PASSWORD`

## 4. MySQL Setup

- [ ] README.md contains `sudo apt install mysql-server`
- [ ] README.md contains `sudo service mysql status`
- [ ] README.md contains `sudo mysql`
- [ ] README.md contains SQL commands to create database and user

## 5. Composer and NPM

- [ ] README.md contains `composer install`
- [ ] README.md contains `npm install && npm run build`

## 6. Docker Setup

- [ ] README.md contains `docker compose -f compose.dev.yaml up --build -d`
- [ ] README.md contains `docker compose -f compose.dev.yaml exec workspace composer install`
- [ ] README.md contains `docker compose -f compose.dev.yaml exec workspace php artisan key:generate`

## 7. FEC-old Setup

- [ ] README.md contains `docker-compose up -d --build`
- [ ] README.md contains `docker-compose exec app php artisan migrate`
- [ ] README.md contains `composer install --no-dev --optimize-autoloader`
- [ ] README.md contains `php artisan key:generate`
- [ ] README.md contains `php artisan migrate`

## 8. Manual Verification

- [ ] After following the setup, running `php artisan key:generate` resolves the `MissingAppKeyException`
- [ ] Application starts without internal server errors

---

**Instructions:**  
Check each item as you verify it in the README.md or by running the commands.