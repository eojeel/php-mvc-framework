# PHP MVC framework
Minimal customer framework.

## Installation steps (native)
2. Create database schema
3. Create `.env` file from `.env.example` fill in the required vars.
4. Run `composer install`
5. Run migrations by executing `php migrations.php`
6. Go to the `public` folder
7. Start php server by running command `php -S localhost:8080`
8. Open in browser http://127.0.0.1:8080


## Installation steps (Docker)
1. Copy `.env.example` into `.env` set the required vars
1. Navigate to the project root directory and run `docker-compose up -d`
1. Install dependencies - `docker-compose exec app composer install`
1. Run migrations - `docker-compose exec app php migrations.php`
8. Open in browser http://127.0.0.1:8080

## composer
optimise autoload files
`composer dump-autoload -o`

## db (issues)
if fresh DB is generated run:
`docker-compose exec chown www-data:www-data /var/www/phpmvc.db`
