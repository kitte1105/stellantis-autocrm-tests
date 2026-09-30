up:
	docker compose up -d

down:
	docker compose down

test:
	docker compose exec tests vendor/bin/codecept run Acceptance --env docker

test_local:
	./vendor/bin/codecept run Acceptance --steps --env local