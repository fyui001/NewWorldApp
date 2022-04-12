APP_CONTAINER_ID = `docker compose ps -q app`

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

init:
	@cp .env.example .env

build:
	@docker compose build

composer_install:
	@docker compose exec app composer install

cache_clear:
	@docker compose exec app php artisan cache:clear
	@docker compose exec app php artisan view:clear
	@docker compose exec app php artisan route:clear
	@docker compose exec app php artisan config:clear

permission:
	@docker compose exec app chmod -R 777 /code/storage bootstrap/cache

migrate:
	@docker compose exec app php artisan migrate

migrate_seed:
	@docker compose exec app php artisan migrate:fresh --seed --drop-views

test_seed:
	@docker compose exec app php artisan migrate:fresh --seed --drop-views --env=testing

test:
	@docker compose exec app ./vendor/bin/phpunit

ssh:
	@docker compose exec app bash

node-ssh:
	@docker compose exec js bash

ide_helper:
	@docker compose exec app php artisan ide-helper:generate

up:
	@docker compose up -d

down:
	@docker compose down

setup:
	@make composer_install
	@docker compose exec app php artisan key:generate
	@docker compose exec app php artisan jwt:secret
	@make cache_clear
	@make migrate_seed
	@make test_seed
	@make permission
	@docker compose exec app php artisan storage:link

cp_vendor:
	@echo '"vendor removing...'
	@rm -rf ./vendor
	@docker cp $(APP_CONTAINER_ID):/code/vendor ./vendor
	@echo '"one sync vendor!'

start_discord_bot:
	@docker compose app php artisan discord-bot:run &
