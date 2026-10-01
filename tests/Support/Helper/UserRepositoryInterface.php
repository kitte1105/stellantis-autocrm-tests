<?php

declare(strict_types=1);

namespace Tests\Support\Helper;

use Tests\Support\Data\TestUser;

interface UserRepositoryInterface
{
    public function create(TestUser $user): TestUser;

    public function delete(TestUser $user): void;
}