<?php

declare(strict_types=1);

use Tests\Support\AcceptanceTester;

final class LoginCest
{
    public function smokeTest(AcceptanceTester $I): void
    {
        $I->amOnPage('/');
        $I->seeInCurrentUrl('/login');

    }
}