<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Model\User;
use RulerZ\Spec\Specification;

# tag::class[]
interface UserRepository
{
    /**
     * @return iterable<User>
     */
    public function match(Specification $spec): iterable;
}
# end::class[]
