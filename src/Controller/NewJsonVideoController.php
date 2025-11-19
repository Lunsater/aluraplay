<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use PDO;

class NewJsonVideoController implements Controller
{
    private readonly VideoRepository $repository;

    public function __construct(private readonly PDO $pdo)
    {
        $this->repository = new VideoRepository($pdo);
    }
    public function processaRequisicao(): void
    {
        $request = file_get_contents('php://input');
        $videoData = json_decode($request, true);
        $video = new Video($videoData['url'], $videoData['title']);
        $video->setFilePath(null);
        $this->repository->add($video);

        http_response_code(201);
    }
}