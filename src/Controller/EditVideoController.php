<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

class EditVideoController implements Controller
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
        $url = $_POST['url'];
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            header('Location: /?sucesso=/0');
            return;
        }
        $title = $_POST['titulo'];
        if (!filter_var($title)) {
            header('Location: /?sucesso=0');
            return;
        }
        $video = new Video($url, $title);
        $video->setId($id);

        if ($this->repository->update($video)) {
            header('Location: /?sucesso=1');
        } else {
            header('Location: /?sucesso=0');
        }
    }
}