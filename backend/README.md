## Create Database

sudo -u postgres psql

CREATE USER tcg_user WITH PASSWORD 'postgres';

CREATE DATABASE tcg OWNER tcg_user;

## Run Migrations

php artisan make:migration add_is_admin_to_users_table

php artisan migrate

## Criar Models

php artisan make:model TcgType

## Criar Controller

php artisan make:controller TcgTypeController --resource

# Seeder

php artisan make:seeder AdminSeeder

php artisan db:seed --class=AdminSeeder
