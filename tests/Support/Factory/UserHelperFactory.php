<?php

declare(strict_types=1);

namespace Tests\Support\Factory;

use Tests\Support\Helper\FakeUserRepository;
use Tests\Support\Helper\UserHelper;

final class UserHelperFactory
{
    public function create(): UserHelper
    {
        return new UserHelper(
            new FakeUserRepository(),
        );
    }
}