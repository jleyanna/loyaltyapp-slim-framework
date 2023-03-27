<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class CreateUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $name = $this->resolveArg('name');
        $email = $this->resolveArg('email');
        $user = $this->userRepository->createUser($name, $email, 0);

        $this->logger->info('User of id `' . $userId . '` was created.');

        return $this->respondWithData($user);
    }
}
