<?php

declare(strict_types=1);

namespace Tests\Support\Data;

final readonly class TestUser
{
    public function __construct(
        public string $email,
        public string $password,
    ) {}
}