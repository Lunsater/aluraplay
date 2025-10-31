<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Controller\Controller;

class LoginFormController implements Controller
{

    public function processaRequisicao(): void
    {
        if (!isset($_SESSION['logado'])) {
            header('Location: /');
            return;
        }
        require_once __DIR__ . '/../../views/login-form.php';
    }
}