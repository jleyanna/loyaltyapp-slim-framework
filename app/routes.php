<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        // GET /users: Retrieve a list of all users and their current points balance.
        $group->get('', ListUsersAction::class);
        // GET user by Id.
        $group->get('/{id}', ViewUserAction::class);
        // POST /users: Create a new user with an initial points balance of 0.
        $group->post('', CreateUserAction::class);
        // POST /users/{id}/earn: Earn points for a user. The request should include the number of points to
        // earn and a description of the transaction.
        $group->post('/{id}/earn', EarnPointsAction::class);
        // POST /users/{id}/redeem: Redeem points for a user. The request should include the number of
        $group->post('/{id}/redeem', RedeemPointsAction::class);
        // DELETE /users/{id}: Delete a user by their ID.
        $group->delete('/{id}', DeleteUserAction::class);
    });
};
