<?php

use App\Domain\Model\User;
use App\Domain\Specification\IsActive;
use App\Domain\Specification\WithGender;
use App\Domain\Specification\WithRole;
use App\Infrastructure\InMemoryUserRepository;
use PHPUnit\Framework\TestCase;
use RulerZ\Spec\AndX;

use function PHPUnit\Framework\assertThat;
use function PHPUnit\Framework\containsEqual as contains;
use function PHPUnit\Framework\countOf;

class UserRespositoryTest extends TestCase
{
    /** @test */
    public function it_can_filter_users_using_a_specification(): void
    {
        # tag::test_active_users[]
        $repository = new InMemoryUserRepository(
            # tag::users[]
            $jane = new User(username:"jane", gender:"female", roles:["admin"]),
            $john = new User(username:"john", gender:"male", deactivatedAt:new \DateTime('-2 days')),
            $paul = new User(username:"paul", gender:"male", roles:["admin"], deactivatedAt:new \DateTime('10 days')),
            $alice = new User(username:"alice", gender:"female", deactivatedAt:new \DateTime('-10 years')),
            $elsa = new User(username:"alice", gender:"female", roles:["admin"], deactivatedAt:new \DateTime('-5 days')),
            # end::users[]
        );

        $activeAdministrators = new AndX([new IsActive(), new WithRole('admin')]);

        $matches = $repository->match($activeAdministrators);

        assertThat($matches, countOf(2));
        assertThat($matches, contains($jane), 'jane is an active admin');
        assertThat($matches, contains($paul), 'paul is an active admin that will be deactivated in 10 days');
        # end::test_active_users[]
    }
}
