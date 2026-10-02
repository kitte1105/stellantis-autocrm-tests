<?php

declare(strict_types=1);

namespace Tests\Api;

use Tests\Support\ApiTester;

final class PublicApiCest
{
    public function getUser(ApiTester $I): void
    {
        $I->sendGet('/users/1');

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'id' => 1,
        ]);
    }
}