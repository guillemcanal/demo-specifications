<?php

declare(strict_types=1);

namespace App\Domain\Model;

# tag::class[]
class User
{
    public function __construct(
        public string $username,
        public string $gender,
        public array $roles = [],
        public ?\DateTime $deactivatedAt = null
    ){}
}
# end::class[]