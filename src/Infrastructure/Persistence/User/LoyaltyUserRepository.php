<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use Psr\Container\ContainerInterface;

class LoyaltyUserRepository implements UserRepository
{
    /**
     * @var User[]
     */
    private array $users;

    private PDO $pdo;

    private ContainerInterface $container;

    /**
     * @param User[]|null $users
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->users = [];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        try {
            $pdo = $this->container->get('pdo');
            // Get all Users
            $stmt = $pdo->prepare('SELECT * FROM users');
            $stmt->execute();
            $usersData = $stmt->fetchAll();

            foreach ($usersData as $userData) {
                $this->users[] = new User(
                    $userData['id'],
                    $userData['username'],
                    $userData['email'],
                    $userData['password']
                );
            }            
        
            return $this->users;
        } catch (\Exception $e) {
            echo 'Error fetching users: ' . $e->getMessage();
            exit;
        }
        
    }
    

    /**
     * {@inheritdoc}
     */
    public function findUserOfId(int $id): User
    {
        try {
            $pdo = $this->container->get('pdo');
            // Get User by provided User Id
            $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id LIMIT 1;');
            $stmt->execute(['id' => strval($id)]);
            $userData = $stmt->fetch();

            if (!$userData) {
                throw new UserNotFoundException();
            }

            return new User(
                $userData['id'],
                $userData['username'],
                $userData['email'],
                $userData['password']
            );

        } catch (\Exception $e) {
            echo 'Error fetching user: ' . $e->getMessage();
            exit;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function createUser($name, $email, $points = 0): User
    {
        try {
            $pdo = $this->container->get('pdo');
            // Create a New User with Points set to 0 by Default
            $stmt = $pdo->prepare('INSERT INTO users (name, email, points_balance) VALUES (:name, :email, :points)');
            $stmt->execute(['name' => $name, 'email' => $email, 'points' => $points]);
            $userId = $pdo->lastInsertId();
            return new User($userId, $name, $email, $points);
        } catch (\Exception $e) {
            echo 'Error creating user: ' . $e->getMessage();
            exit;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function deleteUser($userId): bool
    {
        try {
            $pdo = $this->container->get('pdo');
            // Delete the User based on User Id
            $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
            $stmt->execute(['id' => $userId]);
            return true;
        } catch (\Exception $e) {
            echo 'Error deleting user: ' . $e->getMessage();
            exit;
        }
        
    }

    /**
     * {@inheritdoc}
     */
    public function earnPoints($userId, $points_balance): bool
    {
        try {
            $pdo = $this->container->get('pdo');
            // Update user points balance based on User Id
            $stmt = $pdo->prepare('UPDATE users SET points_balance = :points_balance WHERE id = :id');
            $stmt->execute(['points_balance' => $points_balance, 'id' => $userId]);
            return true;
        } catch (\Exception $e) {
            echo 'Error deleting user: ' . $e->getMessage();
            exit;
        }
        
    }

    /**
     * {@inheritdoc}
     */
    public function redeemPoints($userId, $pointsToRedeem): bool
    {
        try {
            $pdo = $this->container->get('pdo');
            
            // Get the current points balance for the user
            $stmt = $pdo->prepare('SELECT points_balance FROM users WHERE id = :id');
            $stmt->execute(['id' => $userId]);
            $currentPointsBalance = (int) $stmt->fetchColumn();
            
            // Calculate the new points balance
            $newPointsBalance = max($currentPointsBalance - $pointsToRedeem, 0);
            
            // Update the point balance
            $stmt = $pdo->prepare('UPDATE users SET points_balance = :points_balance WHERE id = :id');
            $stmt->execute(['points_balance' => $newPointsBalance, 'id' => $userId]);
            
            return true;
        } catch (\Exception $e) {
            echo 'Error redeeming points: ' . $e->getMessage();
            exit;
        }
    }

}
