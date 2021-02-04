<?php

declare(strict_types=1);

namespace App\Domain\Specification;

use RulerZ\Spec\Specification;

# tag::class[]
class IsActive implements Specification
{
    public function getRule(): string
    {
        return 'deactivatedAt is null OR deactivatedAt > :nowDate';
    }

    public function getParameters(): array
    {
        return [
            'nowDate' => new \DateTime('now')
        ];
    }
}
# end::class[]
