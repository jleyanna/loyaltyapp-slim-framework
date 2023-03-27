<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\User\LoyaltyUserRepository;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        'pdo' => require __DIR__ . '/database.php',
    ]);

    $containerBuilder->addDefinitions([
        UserRepository::class => function (ContainerInterface $c) {
            return new LoyaltyUserRepository($c);
        },
    ]);

    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
    ]);

};
