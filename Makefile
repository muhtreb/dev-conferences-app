DOCKER_EXEC = docker compose exec
DOCKER_EXEC_PHP_FPM = $(DOCKER_EXEC) php-fpm

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

.PHONY: phpstan
phpstan:
	$(DOCKER_EXEC_PHP_FPM) php vendor/bin/phpstan analyse src

.PHONY: phpcsfixer
phpcsfixer:
	$(DOCKER_EXEC) -e PHP_CS_FIXER_IGNORE_ENV=1 php-fpm php vendor/bin/php-cs-fixer fix src