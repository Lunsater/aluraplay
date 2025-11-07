<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use PDO;

class NewVideoController implements Controller
{

    private readonly VideoRepository $repository;

    public function __construct(private readonly PDO $pdo)
    {
        $this->repository = new VideoRepository($pdo);
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

        $video = new Video($url, $title);
        if ($_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $moveu = move_uploaded_file($_FILES['imagem']['tmp_name'],
            __DIR__ . '/../../public/uploads/' . $_FILES['imagem']['name']);
            $video->setFilePath('uploads/' . $_FILES['imagem']['name']);
        }

        if ($this->repository->add($video)) {
            header('Location: /?sucesso=1');
        } else {
            header('Location: /?sucesso=0');
        }
    }
}