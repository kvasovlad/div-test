# Тестовое задание
### PHP - 8.4
### Laravel Framework 12.25.0

## Install
* composer install
* cp .env.example .env
* php artisan key:generate
* add params for database at .env
* php artisan migrate
* sail up -d

## API EndPoints
### Requests
* All Requests GET  `/api/requests`
* Request Create POST  `api/requests`
* Request  Update PUT  `api/requests`

## Swagger API Documentation

This project also includes Swagger (Yaml) documentation for the API endpoints. You can view the API documentation by navigating to the `/swagger/docs` URI in your web browser with the application running.
