tinker:
	php artisan tinker

start:
	php artisan serve --host localhost:8080

setup:
	composer install
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	touch database/database.sqlite
	php artisan migrate
	php artisan db:seed
	npm install

watch:
	npm run watch

migrate:
	php artisan migrate

console:
	php artisan tinker

log:
	tail -f storage/logs/laravel.log

test:
	php artisan test

deploy:
	git push heroku

coverage:
	composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml

lint:
	composer exec --verbose phpcs -- --standard=PSR12 routes

lint-fix:
	composer phpcbf

compose:
	docker-compose up

compose-test:
	docker-compose run web make test

compose-bash:
	docker-compose run web bash

compose-setup: compose-build
	docker-compose run web make setup

compose-build:
	docker-compose build

compose-db:
	docker-compose exec db psql -U postgres

compose-down:
	docker-compose down -v
