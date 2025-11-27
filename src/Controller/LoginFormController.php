<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Controller\Controller;

class LoginFormController implements Controller
{

    public function processaRequisicao(): void
    {
        if (isset($_SESSION['logado'])) {
            header('Location: /');
            return;
        }

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../views');
        $twig = new \Twig\Environment($loader);

        echo $twig->render('login-form.html.twig', []);
    }
}