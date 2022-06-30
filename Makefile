init: docker-down-clear docker-pull docker-build docker-up docker-composer-install
up: docker-up
down: docker-down
restart: down up
cc:
	docker-compose run --rm php-cli php ./bin/console cache:clear
ps:
	docker-compose ps
logs:
	docker-compose logs -f
sh:
	docker-compose run --rm php-cli bash
docker-composer-install:
	docker-compose run --rm php-cli composer update
	#docker-compose run --rm php-cli composer install  --ignore-platform-req=ext-exif
docker-up:
	docker-compose up -d
docker-down:
	docker-compose down --remove-orphans
docker-down-clear:
	docker-compose down -v --remove-orphans
docker-pull:
	docker-compose pull
docker-build:
	docker-compose build --pull
redis-cli:
	docker-compose exec redis redis-cli
tests:
	docker-compose run --rm php-cli ./vendor/bin/phpunit
