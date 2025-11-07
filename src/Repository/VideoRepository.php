<?php

namespace Alura\Mvc\Repository;

use Alura\Mvc\Entity\Video;
use PDO;

class VideoRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function add(Video $video): bool
    {
        $sql = 'INSERT INTO videos (url, title, image_path) VALUES (:url, :title, :image_path)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':url', $video->url, PDO::PARAM_STR);
        $stmt->bindValue(':title', $video->title, PDO::PARAM_STR);
        $stmt-> bindValue(":image_path", $video->getFilePath(), PDO::PARAM_STR);

        if ($stmt->execute()) {
            $video->setId($this->pdo->lastInsertId());
            return true;
        }
        return false;
    }

    public function remove(int $id): bool
    {
        $sql = 'DELETE FROM videos WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function update(Video $video): bool
    {
        $updateImageSql = '';
        if ($video->getFilePath() !== null) {
            $updateImageSql = ', image_path = :image_path';
        }
        $sql = 'UPDATE videos SET 
                  url = :url, 
                  title = :title
                  $updateImageSql
              WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $video->id, PDO::PARAM_INT);
        $stmt->bindValue(':url', $video->url, PDO::PARAM_STR);
        $stmt->bindValue(':title', $video->title, PDO::PARAM_STR);
        if ($video->getFilePath() !== null) {
            $stmt->bindValue(':image_path', $video->getFilePath(), PDO::PARAM_STR);
        }

        return $stmt->execute();
    }

    /**
     * @return Video[]
     */
    public function all(): array
    {
        $videoList = $this->pdo->query('SELECT * FROM videos')->fetchAll(PDO::FETCH_ASSOC);
        return array_map($this->hydrateVideo(...), $videoList);
    }

    public function find(int $id): ?Video
    {
        $statement = $this->pdo->prepare('SELECT * FROM videos WHERE id = :id');
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $this->hydrateVideo($statement->fetch(PDO::FETCH_ASSOC));
    }

    private function hydrateVideo(array $videoData): Video
    {
        $video = new Video($videoData['url'], $videoData['title']);
        $video->setId($videoData['id']);
        if (isset($videoData['image_path'])) {
            $video->setFilePath($videoData['image_path']);
        } else {
            $video->setFilePath(null);
        }

        return $video;
    }
}