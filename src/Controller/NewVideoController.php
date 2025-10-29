<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

class NewVideoController implements Controller
{

    public function __construct(private VideoRepository $repository)
    {
    }

    public function processaRequisicao(): void
    {
        $url = $_POST['url'];
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            header('Location: /?sucesso=0');
            return;
        }
        $title = $_POST['titulo'];
        if (!filter_var($title)) {
            header('Location: /?sucesso=0');
            return;
        }
        if ($this->repository->add(new Video($url, $title))) {
            header('Location: /?sucesso=1');
        } else {
            header('Location: /?sucesso=0');
        }
    }
}