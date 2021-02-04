<?php

declare(strict_types=1);

namespace App\Domain\Specification;

use RulerZ\Spec\Specification;

# tag::class[]
class WithRole implements Specification
{
    public function __construct(
        private string $roleName
    ){}

    public function getRule(): string
    {
        return ':role in roles';
    }

    public function getParameters(): array
    {
        return [
            'role' => $this->roleName
        ];
    }
}
# end::class[]
