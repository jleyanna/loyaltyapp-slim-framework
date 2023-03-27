<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class RedeemPointsAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $points_balance = (int) $this->resolveArg('points_balance');
        $user = $this->userRepository->redeemPoints($userId, $points_balance);

        $this->logger->info('User of id `' . $userId . '` redeemed `' . $points_balance . '` points.');

        return $this->respondWithData($user);
    }
}
