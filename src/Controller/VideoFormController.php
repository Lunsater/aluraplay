<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use PDO;

class VideoFormController implements Controller
{
    private readonly VideoRepository $repository;

    public function __construct(private readonly PDO $pdo)
    {
        $this->repository = new VideoRepository($pdo);
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        /** @var ?Video $video */
        $video = null;
        if ($id) {
            $video = $this->repository->find($id);
        }

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../views');
        $twig = new \Twig\Environment($loader);

        echo $twig->render('video-form.html.twig', ['video' => $video]);
    }
}