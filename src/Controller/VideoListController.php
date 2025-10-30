<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;
use Alura\Mvc\Repository\VideoRepository;
use PDO;
class VideoListController
{
    private readonly VideoRepository $repository;

    public function __construct(private readonly PDO $pdo)
    {
        $this->repository = new VideoRepository($pdo);
    }

    public function processaRequisicao(): void
    {
        $videoList = $this->videoRepository->all();
        require_once __DIR__ . '/../../views/video-list.php';
    }

}