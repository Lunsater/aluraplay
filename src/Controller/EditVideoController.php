<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use PDO;

class EditVideoController implements Controller
{

    private readonly VideoRepository $repository;

    public function __construct(private readonly PDO $pdo)
    {
        $this->repository = new VideoRepository($pdo);
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

        if ($_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            move_uploaded_file($_FILES['imagem']['tmp_name'],
                __DIR__ . '/../../public/uploads/' . $_FILES['image']['name']);
            $video->setFilePath('uploads/' . $_FILES['image']['name']);
        }

        if ($this->repository->update($video)) {
            header('Location: /?sucesso=1');
        } else {
            header('Location: /?sucesso=0');
        }
    }
}