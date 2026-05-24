build:
	docker-compose up -d --build
up:
	docker-compose up -d
down:
	docker-compose down
remove:
	docker-compose down -v
migrate:
	docker compose exec php artisan migrate
