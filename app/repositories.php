<?php

declare(strict_types=1);

use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\User\LoyaltyUserRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        LoyaltyUserRepository::class => \DI\autowire(LoyaltyUserRepository::class),
        'pdo' => require __DIR__ . '/database.php',
    ]);
};
