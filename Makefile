# Executables
DOCKER := docker
DOCKER_COMPOSE := $(DOCKER) compose

PHP = php
VENDORBIN = vendor/bin/
COMPOSER = composer

SYMFONY := symfony
SYMFONY_CONSOLE := $(SYMFONY) console

## —— Help 🆘 ————————————————————————————————————————————--————————————————————
help: ## Outputs this help screen
	@echo "🎵 🐳 The Symfony Docker Makefile 🐳 🎵"
	@echo "--------------------------------------"
	@echo "Usage: make [target]"
	@echo ""
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
up: ## Start the docker hub in detached mode (no logs)
	@$(DOCKER_COMPOSE) up --detach
.PHONY: up

down: ## Stop the docker hub
	@$(DOCKER_COMPOSE) down --remove-orphans
.PHONY: down

## —— Composer 🧙 ——————————————————————————————————————————————————————————————
install: ## Install composer dependencies.
	$(COMPOSER) install --prefer-dist --no-interaction --no-progress
.PHONY: install

update: ## Update composer dependencies.
	$(COMPOSER) update
.PHONY: update

## —— NPM 📦 ——————————————————————————————————————————————————————————————
# npm run watch

# npm run dev-server

# npm run dev

# npm run build

## —— Symfony 🎼 ———————————————————————————————————————————————————————————————
sf: ## List all Symfony commands or pass the parameter "c=" to run a given command, example: make sf c=about
	@$(eval c ?=)
	@$(SYMFONY) $(c)

sf-start: ## Start symfony server.
	$(SYMFONY) serve -d
.PHONY: sf-start

sf-stop: ## Stop symfony server.
	$(SYMFONY) server:stop
.PHONY: sf-stop

dbc: ## Create symfony database.
	$(SYMFONY_CONSOLE) doctrine:database:create --if-not-exists
.PHONY: dbc

dbd: ## Drop symfony database.
	$(SYMFONY_CONSOLE) doctrine:database:drop --if-exists --force
.PHONY: dbd

dsu: ## Update symfony schema database.
	$(SYMFONY_CONSOLE) doctrine:schema:update --force
.PHONY: dsu

mm: ## Make migrations.
	$(SYMFONY_CONSOLE) make:migration
.PHONY: mm

dmm: ## Migrate.
	$(SYMFONY_CONSOLE) doctrine:migrations:migrate --no-interaction
.PHONY: dmm

fixtures: ## Load fixtures.
	$(SYMFONY_CONSOLE) doctrine:fixtures:load --no-interaction
.PHONY: fixtures

me: ## Make symfony entity
	$(SYMFONY_CONSOLE) make:entity
.PHONY: me

mc: ## Make symfony controller
	$(SYMFONY_CONSOLE) make:controller
.PHONY: mc

mf: ## Make symfony Form
	$(SYMFONY_CONSOLE) make:form
.PHONY: mf

browser: ## Open project in a browser.
	$(SYMFONY) open:local
.PHONY: browser

cc: ## Clear the cache
	$(SYMFONY_CONSOLE) cache:clear
.PHONY: cc

## —— QA 🧰 ——————————————————————————————————————————————————————————————————
fix: ## Run PHP-CS-Fixer.
	$(VENDORBIN)php-cs-fixer fix ./src --rules=@Symfony --verbose
.PHONY: fix

analyse: ## Run PHPStan.
	$(VENDORBIN)phpstan analyse src tests --level=3
.PHONY: analyse

lint-twig: ## Lint twig files.
	$(SYMFONY_CONSOLE) lint:twig ./templates
.PHONY: lint-twig

lint-yaml: ## Lint yaml files.
	$(SYMFONY_CONSOLE) lint:yaml ./config
.PHONY: lint-yaml

lint-schema: ## Lint Doctrine schema.
	$(SYMFONY_CONSOLE) doctrine:schema:validate --skip-sync -vvv --no-interaction
.PHONY: lint-schema

lint: lint-twig lint-yaml lint-schema ## Lint twig et yaml files.
.PHONY: lint

audit: ## Run composer audit.
	$(COMPOSER) audit
.PHONY: audit

## —— Tests 🚦 ——————————————————————————————————————————————————————————————————
test: ## Run PHPUnit.
	APP_ENV=test $(SYMFONY) php bin/phpunit 
.PHONY: test

## —— Misc ⭐ ——————————————————————————————————————————————————————————————————
launch: up install dbc dmm sf-start browser ## First launch.
.PHONY: launch

start: up sf-start browser ## Start project.
.PHONY: start

stop: sf-stop down ## Stop project.
.PHONY: stop

reset: ## Reset database.
	$(eval CONFIRM := $(shell read -p "Are you sure you want to reset the database? [y/N] " CONFIRM && echo $${CONFIRM:-N}))
	@if [ "$(CONFIRM)" = "y" ]; then \
		$(MAKE) dbd; \
		$(MAKE) dbc; \
		$(MAKE) dmm; \
	fi
.PHONY: reset
