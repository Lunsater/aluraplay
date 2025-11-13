<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\UserRepository;
use PDO;

class LoginController implements Controller
{

    private readonly UserRepository $repository;

    public function __construct(private readonly PDO $pdo)
    {
        $this->repository = new UserRepository($pdo);
    }

    public function processaRequisicao(): void
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        $user = $this->repository->find($email);

        $correctPassword = $correctPassword = password_verify($password, $user->password);

        if (password_needs_rehash($user->password, PASSWORD_ARGON2ID)) {
            $stmt = $this->pdo->prepare("UPDATE users set password = :password WHERE id = :id");
            $stmt->bindValue(":password", password_hash($password, PASSWORD_ARGON2ID), PDO::PARAM_STR);
            $stmt->bindValue(":id", $user->id, PDO::PARAM_INT);
            $stmt->execute();
        }
        if ($correctPassword) {
            $_SESSION['logado'] = true;
            header('Location: /');
        } else {
            header('Location: /login?sucesso=0');
        }
    }
}