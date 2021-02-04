<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Model\User;
use App\Domain\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use RulerZ\Compiler\Compiler;
use RulerZ\RulerZ;
use RulerZ\Target;
use RulerZ\Spec\Specification;

class InMemoryUserRepository implements UserRepository
{
    /** @var User[] */
    private $elements;

    /** @var RulerZ  */
    private $rulerZ;

    public function __construct(User ...$users)
    {
        $this->rulerZ = new RulerZ(
            Compiler::create(),
            [ new Target\Native\Native()]
        );

        $this->elements = $users;    
    }

    /** {@inheritdoc} */
    public function match(Specification $spec): iterable
    {
        return iterator_to_array(
            $this->rulerZ->filterSpec($this->elements, $spec)
        );
    }
}
