<?php

declare(strict_types=1);

namespace Tests\Api;

use Tests\Support\ApiTester;

final class CreateUserExampleCest
{
    public function createUser(ApiTester $I): void
    {
        $I->sendPost('/users', [
            'name' => 'Test User',
            'email' => 'test_user@example.com',
        ]);

        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'name' => 'Test User',
            'email' => 'test_user@example.com',
        ]);
        $I->seeResponseJsonMatchesJsonPath('$.id');
    }
}