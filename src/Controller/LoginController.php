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

        $correctPassword = false;
        if (!empty($user)) {
            $correctPassword = password_verify($password, $user->password);
        }
        if ($correctPassword) {
            header('Location: /');
        } else {
            header('Location: /login?sucesso=0');
        }
    }
}