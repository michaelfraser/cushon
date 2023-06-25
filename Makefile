SHELL=/bin/bash

CMD_COMPOSER_INSTALL:=php -d memory_limit=-1 /usr/local/bin/composer install -vvv --prefer-dist --no-interaction
CMD_DOCKER_COMPOSE_UP:=docker compose up --build -d --remove-orphans
CMD_MYSQL_BASH:=docker compose exec database bash
PATH_WEB_PROJECT_ROOT:=/var/www/demo/live
PATH_WEB_SSH:=/root/.ssh/id_rsa

$(shell if ! [[ -e .env ]]; then cp .env.example .env; fi)

include .env
export

ifeq ($(RUNNING_ON_CI), true)
	CMD_WEB_BASH_AS_ROOT:=docker compose exec -T web bash
else
	CMD_WEB_BASH_AS_ROOT:=docker compose exec web bash
endif

help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

up: ## Create the Docker containers
	@if ! [[ -e .env ]]; then \
		cp .env.example .env; \
	fi
	$(CMD_DOCKER_COMPOSE_UP)

down: ## Stop and remove Docker containers
	docker compose down --remove-orphans

clean: ## Build a clean version of the project
	@$(MAKE) down
	@$(MAKE) clean-files
	@$(MAKE) up
	@$(MAKE) build-php
	@$(MAKE) db-check
	@$(MAKE) migrate-db
	@$(MAKE) seed-db

restart: down up ## Remove and recreate the Docker containers

nuke: ## Delete all docker containers and rebuild
	@docker compose down --rmi all -v --remove-orphans
	@$(MAKE) clean

build-php: ## Install dependencies for PHP
	$(CMD_WEB_BASH_AS_ROOT) -c '\
		cd $(PATH_WEB_PROJECT_ROOT) \
		&& $(CMD_COMPOSER_INSTALL) \
		&& rm -rf $(PATH_WEB_SSH) \
	'

bash: ## Open bash within the web container as root
	$(CMD_WEB_BASH_AS_ROOT)

clean-files: ## Remove .env, Symfony-generated files (cache, log, sessions)
	rm -rf .env var/{cache,log,sessions}

mysql: ## Create a bash session within the mysql container
	$(CMD_MYSQL_BASH)

db-check: ## Check that the database is up
	@$(CMD_WEB_BASH_AS_ROOT) -c 'bin/db-check'

migrate-db: ## Run phinx migration script
	@$(CMD_WEB_BASH_AS_ROOT) -c 'vendor/bin/phinx migrate'

rollback-db: ## Rollback phinx db migration
	@$(CMD_WEB_BASH_AS_ROOT) -c 'vendor/bin/phinx rollback'

seed-db: ## Run databse seeds
	@$(CMD_WEB_BASH_AS_ROOT) -c 'vendor/bin/phinx seed:run'

test-phpstan: ## Run PHP Stan
	$(CMD_WEB_BASH_AS_ROOT) -c 'vendor/bin/phpstan analyse --memory-limit=256M --level max src tests --error-format=junit --no-interaction > build/logs/php/phpstan.xml'

test-phpcs: ## Run PHP Code Sniffer
	$(CMD_WEB_BASH_AS_ROOT) -c 'vendor/bin/phpcs --standard=phpcs.xml.dist -p --report=summary --report=junit --report-junit=build/logs/php/phpcs.xml'

test-phpcs-fixer: ## Run PHP Code Sniffer fixer
	$(CMD_WEB_BASH_AS_ROOT) -c 'vendor/bin/php-cs-fixer fix'

test-phpcbf-fixer: ## Run PHP Code Sniffer fixer
	$(CMD_WEB_BASH_AS_ROOT) -c 'vendor/bin/phpcbf --standard=phpcs.xml.dist -p'

test-phpunit:  ensure-phpunit-symlink-is-relative ## Run PHP Unit
	$(CMD_WEB_BASH_AS_ROOT) -c 'vendor/bin/simple-phpunit --log-junit build/logs/php/phpunit.xml'

ensure-phpunit-symlink-is-relative: ## Fix to ensure the phpunit-bridge works in/out of the Docker container
	@if [ -L vendor/bin/.phpunit/phpunit-9.5-0/vendor/symfony/phpunit-bridge ]; then \
  		rm vendor/bin/.phpunit/phpunit-9.5-0/vendor/symfony/phpunit-bridge; \
		ln -s ../../../../../../vendor/symfony/phpunit-bridge vendor/bin/.phpunit/phpunit-9.5-0/vendor/symfony/phpunit-bridge; \
	fi \

security: ## Run security checks
	$(CMD_WEB_BASH_AS_ROOT) -c 'bin/security/security-check.sh'

proxy-on: ## Spin up the web container with the proxy on.
	docker compose build --build-arg proxy=http://192.168.222.6:3128 web
	docker compose up -d web

proxy-off: ## Spin up the web container with the proxy off.
	$(CMD_DOCKER_COMPOSE_UP) web

pre-commit: test-phpunit test-phpstan test-phpcs test-phpcs-fixer test-phpcbf-fixer ## A quick "pre-commit" check for confirming code quality and standards are met.  Also run tests.