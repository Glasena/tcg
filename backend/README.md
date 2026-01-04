## Create Database

sudo -u postgres psql

CREATE USER tcg_user WITH PASSWORD 'postgres';

CREATE DATABASE tcg OWNER tcg_user;

## Run Migrations

php artisan migrate
