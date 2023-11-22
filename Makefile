build:
	docker compose build
up:
	docker compose up -d
down:
	docker compose down
php-bash:
	docker compose exec php-laravel-crud bash
php-logs:
	docker compose logs php-laravel-crud
nginx-bash:
	docker compose exec nginx-laravel-crud bash
nginx-logs:
	docker compose logs nginx-laravel-crud
vendor:
	docker compose exec php-laravel-crud bash -c "composer install"
