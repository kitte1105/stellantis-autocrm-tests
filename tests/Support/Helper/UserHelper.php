<?php

declare(strict_types=1);

namespace Tests\Support\Helper;

use Tests\Support\Data\TestUser;
use Tests\Support\Data\TestUserData;

final class UserHelper
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
    ) {
    }

    public function createTestUser(): TestUser
    {
        $user = new TestUser(
            email: $this->generateEmail(),
            password: TestUserData::PASSWORD,
        );

        return $this->repository->create($user);
    }

    /**
     * @return list<TestUser>
     */
    public function createTestUsers(int $count): array
    {
        $users = [];

        for ($i = 0; $i < $count; $i++) {
            $users[] = $this->createTestUser();
        }

        return $users;
    }

    public function deleteTestUser(TestUser $user): void
    {
        $this->repository->delete($user);
    }

    /**
     * @param list<TestUser> $users
     */
    public function deleteTestUsers(array $users): void
    {
        foreach ($users as $user) {
            $this->deleteTestUser($user);
        }
    }

    private function generateEmail(): string
    {
        return sprintf(
            'test_%s@%s',
            uniqid(),
            TestUserData::EMAIL_DOMAIN,
        );
    }
}