<?php

declare(strict_types=1);

namespace Tests\Support\Helper;

use Tests\Support\Data\TestUser;

final class FakeUserRepository implements UserRepositoryInterface
{
    /**
     * @var array<string, TestUser>
     */
    private array $users = [];

    public function create(TestUser $user): TestUser
    {
        $this->users[$user->email] = $user;

        return $user;
    }

    public function delete(TestUser $user): void
    {
        unset($this->users[$user->email]);
    }
}