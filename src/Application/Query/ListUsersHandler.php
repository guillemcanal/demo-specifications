<?php

namespace App\Application\Query;

use App\Domain\Model\User;
use App\Domain\Repository\UserRepository;

class ListUsersHandler
{
    public function __construct(
        private UserRepository $userRepository
    ){}

    /**
     * @return iterable<User>
     */
    public function handle(ListUsers $query): iterable
    {
        return $this->userRepository->match($query->specification());
    }
}
