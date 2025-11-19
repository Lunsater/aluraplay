<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use PDO;

class JsonVideoListController implements Controller
{
    private readonly VideoRepository $repository;

    public function __construct(private readonly PDO $pdo)
    {
        $this->repository = new VideoRepository($pdo);
    }

    public function processaRequisicao(): void
    {
        $videoList = array_map(function (Video $video): array {
            return [
                'url' => $video->url,
                'title' => $video->title,
                'file_path' => $video->getFilePath()
            ];
        }, $this->repository->all());

        echo json_encode($videoList);
    }
}