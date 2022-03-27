APP_CONTAINER_ID = `docker-compose ps -q app`

init:
	@cp .env.example .env
	@cp docker-compose.example.yml docker-compose.yml

build:
	@docker-compose build

composer_install:
	@docker-compose exec app composer install --ignore-platform-reqs

cache_clear:
	@docker-compose exec app php artisan cache:clear
	@docker-compose exec app php artisan view:clear
	@docker-compose exec app php artisan route:clear
	@docker-compose exec app php artisan config:clear

permission:
	@docker-compose exec app chmod -R 777 /code/storage bootstrap/cache

migrate:
	@docker-compose exec app php artisan migrate

migrate_seed:
	@docker-compose exec app php artisan migrate:fresh --seed --drop-views

test_seed:
	@docker-compose exec app php artisan migrate:fresh --seed --drop-views --env=testing

test:
	@docker-compose exec app ./vendor/bin/phpunit

ssh:
	@docker-compose exec app bash

ide_halper:
	@docker-compose exec app php artisan ide-helper:generate

up:
	@docker-compose up -d

down:
	@docker-compose down

setup:
	@docker-compose exec app php artisan key:generate
	@make cache_clear
	@make migrate_seed
	@make test_seed
	@make permission
	@docker-compose exec app php artisan storage:link

cp_vendor:
	@rm -rf ./vendor
	@docker cp $(APP_CONTAINER_ID):/code/vendor ./vendor
	@echo '"one sync vendor!'

start_discord_bot:
	@php artisan discord-bot:run &
