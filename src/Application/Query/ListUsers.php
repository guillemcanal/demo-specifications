<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Domain\Specification\IsActive;
use App\Domain\Specification\WithGender;
use App\Domain\Specification\WithRole;
use RulerZ\Spec\AndX;
use RulerZ\Spec\Not;
use RulerZ\Spec\Specification;

class ListUsers
{
    public function __construct(
        public ?string $role = null,
        public ?string $gender = null,
        public ?bool $inactive = false
    ){}

    public function specification(): Specification
    {
        $andX = static fn(?Specification ...$specs) => new AndX(array_filter($specs));

        return $andX(
            $this->inactive ? new Not(new IsActive()): new IsActive(),
            $this->role ? new WithRole($this->role) : null,
            $this->gender ? new WithGender($this->gender) : null,
        );
    }
}
