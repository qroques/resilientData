help: ## Display this current help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-25s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

##@ General

.PHONY=cs-fixer

cs-fixer: ## Run cs fixer on the current codebase
	docker compose run --volume ./:/usr/src/app --rm php vendor/bin/php-cs-fixer fix

phpstan: ## Run PHPStan analyse
	docker compose run --volume ./:/usr/src/app --rm php vendor/bin/phpstan analyse

phpunit: ## Run PHPUnit analyse
	docker compose run --volume ./:/usr/src/app --rm php vendor/bin/phpunit 