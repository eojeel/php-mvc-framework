# PHP MVC
php -S localhost:8080
docker run -v ${PWD}/public/:/var/www/html/ -p 80:80 --name php  php:8.1-apache

## composer update
