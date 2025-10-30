<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Controller\Controller;

class LoginFormController implements Controller
{

    public function processaRequisicao(): void
    {
        require_once __DIR__ . '/../../views/login-form.php';
    }
}