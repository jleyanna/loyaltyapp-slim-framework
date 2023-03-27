<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class EarnPointsAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $points_balance = $this->resolveArg('points_balance');
        $user = $this->userRepository->earnPoints($userId, $points_balance);

        $this->logger->info('User of id `' . $userId . '` was updated with `' . $points_balance . '` points.');

        return $this->respondWithData($user);
    }
}
