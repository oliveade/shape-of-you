# Executables
DOCKER := docker
DOCKER_COMPOSE := $(DOCKER) compose

SYMFONY := symfony
SYMFONY_CONSOLE := $(SYMFONY) console

## —— Help 🆘 ————————————————————————————————————————————--————————————————————
.PHONY: help
help: ## Outputs this help screen
	@echo "🎵 🐳 The Symfony Docker Makefile 🐳 🎵"
	@echo "--------------------------------------"
	@echo "Usage: make [target]"
	@echo ""
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
.PHONY: up
up: ## Start the docker hub in detached mode (no logs)
	$(DOCKER_COMPOSE) up --detach

.PHONY: down
down: ## Stop the docker hub
	$(DOCKER_COMPOSE) down --remove-orphans

## —— Symfony 🎼 ———————————————————————————————————————————————————————————————
.PHONY: sf-start
sf-start: ## Start symfony server.
	$(SYMFONY) serve -d

.PHONY: sf-stop
sf-stop: ## Stop symfony server.
	$(SYMFONY) server:stop

.PHONY: ddc
ddc: ## Create the database.
	$(SYMFONY_CONSOLE) doctrine:database:create --if-not-exists

.PHONY: ddd
ddd: ## Drop the database.
	$(SYMFONY_CONSOLE) doctrine:database:drop --if-exists --force

.PHONY: dsu
dsu: ## Update symfony schema database.
	$(SYMFONY_CONSOLE) doctrine:schema:update --force

.PHONY: mm
mm: ## Make migrations.
	$(SYMFONY_CONSOLE) make:migration

.PHONY: dmm
dmm: ## Migrate.
	$(SYMFONY_CONSOLE) doctrine:migrations:migrate --no-interaction

.PHONY: query
query: ## Query the database.
	$(SYMFONY_CONSOLE) dbal:run-sql

.PHONY: fac
fac: ## Add fixture.
	$(SYMFONY_CONSOLE) make:factory

.PHONY: fx
fx: ## Add fixture.
	$(SYMFONY_CONSOLE) make:fixture

.PHONY: fxl
fxl: ## Load fixtures.
	$(SYMFONY_CONSOLE) doctrine:fixtures:load --no-interaction

.PHONY: me
me: ## Make symfony entity
	$(SYMFONY_CONSOLE) make:entity

.PHONY: mc
mc: ## Make symfony controller
	$(SYMFONY_CONSOLE) make:controller

.PHONY: mf
mf: ## Make symfony Form
	$(SYMFONY_CONSOLE) make:form

.PHONY: mv
mv: ## Make symfony Voter
	$(SYMFONY_CONSOLE) make:voter

.PHONY: browser
browser: ## Open project in browser.
	$(SYMFONY) open:local

.PHONY: cc
cc: ## Clear cache.
	$(SYMFONY_CONSOLE) cache:clear

## —— QA 🧰 ————————————————————————————————————————————————————————————————————
.PHONY: phpstan
phpstan:
	vendor/bin/phpstan analyse -l 6 -c phpstan.dist.neon src tests

.PHONY: cs-check
cs-check:
	vendor/bin/php-cs-fixer check src tests --config=.php-cs-fixer.dist.php --verbose

.PHONY: cs-fix
cs-fix:
	vendor/bin/php-cs-fixer fix src tests --config=.php-cs-fixer.dist.php --verbose

.PHONY: lint
lint: ## Lint twig and yaml files.
	$(SYMFONY_CONSOLE) lint:yaml ./config
	$(SYMFONY_CONSOLE) doctrine:schema:validate --skip-sync -vvv --no-interaction
	$(SYMFONY_CONSOLE) lint:twig templates/
	$(SYMFONY_CONSOLE) lint:twig templates/

## —— Tests 🚦 ——————————————————————————————————————————————————————————————————
.PHONY: tests
tests: ## Run PHPUnit.
	php bin/phpunit

.PHONY: testdox
testdox: ## Run PHPUnit testdox.
	php bin/phpunit --testdox

.PHONY: tddc
tddc: ## Create the test database.
	$(SYMFONY_CONSOLE) --env=test doctrine:database:create

.PHONY: tdsc
tdsc: ## Create the tables/columns in the test database.
	$(SYMFONY_CONSOLE) --env=test doctrine:schema:create

.PHONY: tfixtures
tfixtures: ## Load test fixtures.
	$(SYMFONY_CONSOLE) --env=test doctrine:fixtures:load

## —— ⭐ ————————————————————————————————————————————————————————————————————————
.PHONY: launch
launch: ## First launch.
	up
	composer install --prefer-dist --no-interaction --no-progress
	ddc
	dmm
	sf-start
	browser

.PHONY: start
start: ## Start project.
	up sf-start browser

.PHONY: stop
stop: ## Stop project.
	sf-stop down

.PHONY: reset
reset: ## Reset database.
	php bin/console doctrine:database:drop --force
	php bin/console doctrine:database:create
	php bin/console doctrine:migrations:migrate --no-interaction
	php bin/console doctrine:fixtures:load --no-interaction