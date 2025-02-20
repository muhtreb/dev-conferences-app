DOCKER_EXEC_PHP_FPM = docker compose exec php-fpm

.PHONY: bash
bash:
	$(DOCKER_EXEC_PHP_FPM) bash

.PHONY: composer-update
composer-update:
	$(DOCKER_EXEC_PHP_FPM) composer update

.PHONY: composer-install
composer-install:
	$(DOCKER_EXEC_PHP_FPM) composer install

.PHONY: tests
tests:
	$(DOCKER_EXEC_PHP_FPM) php vendor/bin/phpunit

.PHONY: phpcsfixer
phpcsfixer:
	docker compose exec -e PHP_CS_FIXER_IGNORE_ENV=1 php-fpm php vendor/bin/php-cs-fixer fix src