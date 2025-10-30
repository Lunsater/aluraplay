<?php

namespace Alura\Mvc\Repository;

use Alura\Mvc\Entity\User;
use PDO;

class UserRepository
{

    public function __construct(private PDO $pdo)
    {
    }

    public function find(string $email): ?User
    {
        $sql = 'SELECT * FROM users WHERE email = :email';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $this->hydrateUser($stmt->fetch(PDO::FETCH_ASSOC));
    }

    private function hydrateUser(mixed $userData): ?User
    {
        if (!empty($userData)) {
            $user = new User($userData['email'], $userData['password']);
            $user->setId($userData['id']);

            return $user;
        }
        return null;
    }
}