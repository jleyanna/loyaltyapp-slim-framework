<?php

declare(strict_types=1);

namespace Tests\Domain\User;

use App\Domain\User\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function userProvider(): array
    {
        return [
            [1, 'Bill Gates', 'bill@gates.com', 600],
            [2, 'Elon Musk', 'elon@twitter.com', 700],
        ];
    }

    /**
     * @dataProvider userProvider
     * @param int    $id
     * @param string $name
     * @param string $email
     * @param int $points_balance
     */
    public function testGetters(int $id, string $name, string $email, int $points_balance)
    {
        $user = new User($id, $name, $email, $points_balance);

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($name, $user->getName());
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($points_balance, $user->getPointsBalance());
    }

    /**
     * @dataProvider userProvider
     * @param int    $id
     * @param string $name
     * @param string $email
     * @param int $points_balance
     */
    public function testJsonSerialize(int $id, string $name, string $email, int $points_balance)
    {
        $user = new User($id, $name, $email, $points_balance);

        $expectedPayload = json_encode([
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'points_balance' => $points_balance,
        ]);

        $this->assertEquals($expectedPayload, json_encode($user));
    }
}
