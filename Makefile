DOCKER_EXEC_PHP_FPM = docker compose exec php-fpm

.PHONY: bash
bash:
	$(DOCKER_EXEC_PHP_FPM) bash

.PHONY: composer-update
composer-update:
	$(DOCKER_EXEC_PHP_FPM) composer update

.PHONY: tests
tests:
	$(DOCKER_EXEC_PHP_FPM) php vendor/bin/phpunit