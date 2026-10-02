up:
	docker compose up -d

down:
	docker compose down

test:
	docker compose run --rm tests vendor/bin/codecept run Acceptance --env docker

test-local:
	./vendor/bin/codecept run Acceptance --steps --env local

test-api:
	docker compose run --rm tests vendor/bin/codecept run Api --env docker

test-api-local:
	./vendor/bin/codecept run Api --steps --env local