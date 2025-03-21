.PHONY: docker-build build build-dev start stop test phpcs phpstan

docker-build:
	docker-compose build

build: docker-build
	docker-compose run --rm app composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction

build-dev: docker-build
	docker-compose run --rm app composer install --prefer-dist --no-scripts --no-progress --no-interaction

start:
	docker-compose up -d

stop:
	docker-compose down

test:
	docker-compose run --rm -e XDEBUG_MODE=coverage app vendor/bin/phpunit

phpcs:
	docker-compose run --rm app vendor/bin/phpcs --standard=ruleset.xml

phpcbf:
	docker-compose run --rm app vendor/bin/phpcbf --standard=ruleset.xml

phpstan:
	docker-compose run --rm app vendor/bin/phpstan analyse
