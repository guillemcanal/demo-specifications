<?php

declare(strict_types=1);

use App\Application\Query\ListUsersHandler;
use App\Domain\Model\User;
use App\Infrastructure\InMemoryUserRepository;
use App\Application\Query\ListUsers;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertThat;
use function PHPUnit\Framework\countOf;

class ListUsersQueryTest extends TestCase
{
    /** 
     * @test 
     * @dataProvider listUsersUseCases
     * 
     * @param callable(User ...$users)
     **/
    public function it_can_list_users_given_a_query(ListUsers $query, callable $assert): void
    {
        $aListOfUsers = [
            new User(username:"john.doe", gender:"male", roles:["client"]),
            new User(username:"jane.doe", gender:"female", roles:["admin", "api"]),
            new User(username:"paul.dupond", gender:"male", roles:["admin"]),
            new User(username:"alice.dupont", gender:"female", deactivatedAt: new \DateTime('-2 days')),
        ];

        $handler = new ListUsersHandler(
            new InMemoryUserRepository(...$aListOfUsers)
        );

        $assert(...$handler->handle($query));
    }

    public function listUsersUseCases(): array
    {
        return [
            'a role' => [
                new ListUsers(role:"admin"),
                fn(User ...$users) => assertThat($users, countOf(2))
            ],
            'a gender' => [
                new ListUsers(gender:"female"),
                fn(User ...$users) => assertThat($users, countOf(1))
            ],
            'a role and gender' => [
                new ListUsers(role: "admin", gender:"female"),
                fn(User ...$users) => assertThat($users, countOf(1))
            ],
            'inactive' => [
                new ListUsers(inactive: true),
                fn(User ...$users) => assertThat($users, countOf(1))
            ]
        ];
    }
}
