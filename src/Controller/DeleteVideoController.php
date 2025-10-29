<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Controller\Controller;
use Alura\Mvc\Repository\VideoRepository;

class DeleteVideoController implements Controller
{

    public function __construct(private VideoRepository $repository)
    {
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /?sucesso=0');
            return;
        }

        if ($this->repository->remove($id)) {
            header('Location: /?sucesso=1');
        } else {
            header('Location: /?sucesso=0');
        }
    }
}