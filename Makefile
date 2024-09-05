# Use bash as the shell
SHELL := /bin/bash

# Default target
.DEFAULT_GOAL := help

# ANSI color codes
BLUE := \033[0;34m
NC := \033[0m # No Color

# Help target
.PHONY: help
help: ## Display this help message
	@echo "Usage: make [target]"
	@echo ""
	@echo "Targets:"
	@awk '/^[a-zA-Z\-\_0-9]+:/ { \
		helpMessage = match(lastLine, /^## (.*)/); \
		if (helpMessage) { \
			helpCommand = substr($$1, 0, index($$1, ":")-1); \
			helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
			printf "  ${BLUE}%-15s${NC} %s\n", helpCommand, helpMessage; \
		} \
	} \
	{ lastLine = $$0 }' $(MAKEFILE_LIST)

.PHONY: install
install: ## Install project dependencies
	@echo "Installing Composer dependencies..."
	composer install
	@echo "Installing NPM dependencies..."
	npm install

.PHONY: run
run: ## Run Laravel server and Vite development server concurrently
	@echo "Starting Laravel and Vite servers..."
	@if command -v concurrently &> /dev/null; then \
		concurrently --kill-others \
			"php artisan serve" \
			"npm run dev"; \
	else \
		echo "concurrently is not installed. Running servers in separate terminals."; \
		osascript -e 'tell application "Terminal" to do script "cd $(PWD) && php artisan serve"' ; \
		osascript -e 'tell application "Terminal" to do script "cd $(PWD) && npm run dev"' ; \
	fi

.PHONY: migrate
migrate: ## Run database migrations
	php artisan migrate

.PHONY: seed
seed: ## Seed the database
	php artisan db:seed

.PHONY: test
test: ## Run PHP tests
	php artisan test

.PHONY: lint
lint: ## Run PHP linter
	./vendor/bin/phpcs

.PHONY: fix-lint
fix-lint: ## Fix PHP linting errors
	./vendor/bin/phpcbf

.PHONY: clear-cache
clear-cache: ## Clear Laravel cache
	php artisan cache:clear
	php artisan config:clear
	php artisan route:clear
	php artisan view:clear
