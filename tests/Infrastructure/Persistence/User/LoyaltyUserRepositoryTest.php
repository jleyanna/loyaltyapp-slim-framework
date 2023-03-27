<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Infrastructure\Persistence\User\LoyaltyUserRepository;
use Tests\TestCase;

class LoyaltyUserRepositoryTest extends TestCase
{
    public function testFindAll()
    {
        $user = new User(1, 'Bill Gates', 'bill@gates.com', 323);

        $userRepository = new LoyaltyUserRepository([1 => $user]);

        $this->assertEquals([$user], $userRepository->findAll());
    }

    public function testFindAllUsersByDefault()
    {
        $users = [
            1 => new User(1, 'Bill Gates', 'bill@gates.com', 323),
            2 => new User(2, 'Elon Musk', 'elon@twitter.com', 532),
        ];

        $userRepository = new LoyaltyUserRepository();

        $this->assertEquals(array_values($users), $userRepository->findAll());
    }

    public function testFindUserOfId()
    {
        $user = new User(1, 'Bill Gates', 'bill@gates.com', 323);

        $userRepository = new LoyaltyUserRepository([1 => $user]);

        $this->assertEquals($user, $userRepository->findUserOfId(1));
    }

    public function testFindUserOfIdThrowsNotFoundException()
    {
        $userRepository = new LoyaltyUserRepository([]);
        $this->expectException(UserNotFoundException::class);
        $userRepository->findUserOfId(1);
    }
}
