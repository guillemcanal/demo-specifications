<?php

declare(strict_types=1);

namespace App\Domain\Specification;

use RulerZ\Spec\Specification;

class WithGender implements Specification
{
    public function __construct(
        private string $gender
    ){}

    public function getRule(): string
    {
        return 'gender = :gender';
    }

    public function getParameters(): array
    {
        return [
            'gender' => $this->gender
        ];
    }
}
