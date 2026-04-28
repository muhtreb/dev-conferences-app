DOCKER_COMPOSE = docker compose
DOCKER_EXEC = $(DOCKER_COMPOSE) exec
DOCKER_EXEC_PHP_FPM = $(DOCKER_EXEC) php-fpm

.PHONE: up
up:
	$(DOCKER_COMPOSE) up -d

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
	$(DOCKER_EXEC_PHP_FPM) php -d memory_limit=-1 vendor/bin/phpstan analyse src

.PHONY: phpcsfixer
phpcsfixer:
	$(DOCKER_EXEC) -e PHP_CS_FIXER_IGNORE_ENV=1 php-fpm php vendor/bin/php-cs-fixer fix src

.PHONY: rector
rector:
	$(DOCKER_EXEC) -e RECTOR=1 php-fpm php vendor/bin/rector process src