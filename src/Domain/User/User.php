<?php

declare(strict_types=1);

namespace App\Domain\User;

use JsonSerializable;

class User implements JsonSerializable
{
    private ?int $id;

    private string $name;

    private string $email;

    private int $points_balance;

    public function __construct(?int $id, string $name, string $email, int $points_balance)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->points_balance = $points_balance;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPointsBalance(): int
    {
        return $this->points_balance;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'points_balance' => $this->points_balance,
        ];
    }
}
