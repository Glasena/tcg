## Create Database

sudo -u postgres psql

CREATE USER tcg_user WITH PASSWORD 'postgres';

CREATE DATABASE tcg OWNER tcg_user;

## Run Migrations

php artisan migrate

## Criar Models

php artisan make:model TcgType

## Criar Controller

php artisan make:controller TcgTypeController --resource
