# Тесты для Stellantis AutoCRM

Репозиторий с UI- и API-проверками для [stellantis.autocrm.ru](https://stellantis.autocrm.ru/). Основной фокус — форма входа; API-сьюит пока с примерами на JSONPlaceholder, пока нет контракта AutoCRM.

Стек: PHP 8.3, Codeception 5, WebDriver + Selenium, для маски пароля подключён VisualCeption.

## Как запустить

**Через Docker (так проще всего для UI):**

```bash
make up          # Selenium + контейнер с PHP
make test        # Acceptance, env docker
make test-api    # примеры REST
make down
```

Перед первым локальным запуском в IDE: `composer install`. Если меняли модули Codeception — `vendor/bin/codecept build`.

**Без Docker:** нужны PHP 8.3+, Composer и Selenium на `127.0.0.1:4444`, затем `make test-local` или:

```bash
./vendor/bin/codecept run Acceptance --steps --env local
```

URL приложения и браузер — в `tests/Acceptance.suite.yml`, хост WebDriver для Docker — в `tests/_envs/docker.yml`.

## Что где лежит

- `tests/Acceptance/LoginCest.php` — сценарии формы входа  
- `tests/Page/` — page objects  
- `tests/Api/` — REST-примеры; `AutoCrmCreateUserExampleCest.php` помечен `@Skip`  
- `cases.md` — расшифровка сценариев AUTH-01 … AUTH-18, баг по кнопке login, идеи без автотестов  
- `tests/Support/Data/VisualCeption/` — эталоны для visual-теста пароля  
- `tests/_output/` — артефакты падений (в git не коммитим)

## Сценарии login

Краткая карта (подробности и шаги — в [cases.md](cases.md)):

| ID | Суть | В коде |
| --- | --- | --- |
| AUTH-01 … AUTH-05 | Ошибки, маска, email, восстановление пароля | да |
| AUTH-04 | | ~90%: не проверяем разблокировку Submit после fix email |
| AUTH-06 | Успешный вход | черновик, без нормального пользователя CRM |
| AUTH-07 … AUTH-18 | Что ещё стоит проверить | **нет**, только описание в cases.md |

Перед тестами AUTH-01 … AUTH-05 в `_before` выставляется локаль **ru** (тексты ошибок — в [cases.md](cases.md)).

## Visual и API

Эталоны скринов могут отличаться для local и docker (разный user-agent в env) — смотри имена файлов в `VisualCeption/`. Если вёрстка поля пароля изменилась, эталон обновляют по [инструкции модуля](https://github.com/Codeception/VisualCeption).

API-тесты ходят на [jsonplaceholder.typicode.com](https://jsonplaceholder.typicode.com) — это шаблон запросов, не интеграция с CRM.

## На что обратить внимание

- На AUTH-04 есть баг UI: кнопка login может остаться disabled после исправления email — в тесте финальные assert-ы закомментированы, подробнее в cases.md.  
- Unicode-email в data provider сознательно skip.  
- `validLoginTest` использует in-memory `FakeUserRepository`, для настоящего E2E нужен API создания пользователя на стенде.

## Автор

Ekaterina Davydova — kitte1105@gmail.com
