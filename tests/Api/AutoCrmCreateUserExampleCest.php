<?php

declare(strict_types=1);

namespace Tests\Api;

use Tests\Support\ApiTester;
use Codeception\Attribute\Skip;

final class AutoCrmCreateUserExampleCest
{
    /**
     * Пример API-запроса на создание пользователя.
     *
     * Реальный endpoint, поля запроса, авторизация и ожидаемый
     * HTTP-код должны быть заменены согласно документации AutoCRM.
     */
    #[Skip('API-контракт AutoCRM не предоставлен в задании')]
    function createUser(ApiTester $I): void
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader(
            'Authorization',
            'Bearer {{access_token}}',
        );

        $I->sendPost('{{api_base_url}}/users', [
            'email'    => '{{user_email}}',
            'password' => '{{user_password}}',
            'name'     => '{{user_name}}',
        ]);

        // Например, API может возвращать 201 Created.
        // $I->seeResponseCodeIs(201);
        // $I->seeResponseIsJson();
    }
}