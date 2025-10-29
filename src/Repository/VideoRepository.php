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
        $sql = 'INSERT INTO videos (url, title) VALUES (:url, :title)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':url', $video->url, PDO::PARAM_STR);
        $stmt->bindValue(':title', $video->title, PDO::PARAM_STR);

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
        $sql = 'UPDATE videos SET url = :url, title = :title WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $video->id, PDO::PARAM_INT);
        $stmt->bindValue(':url', $video->url, PDO::PARAM_STR);
        $stmt->bindValue(':title', $video->title, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * @return Video[]
     */
    public function all(): array
    {
        $videoList = $this->pdo->query('SELECT * FROM videos')->fetchAll(PDO::FETCH_ASSOC);
        return array_map(function (array $videoData) {
            $video = new Video($videoData['url'], $videoData['title']);
            $video->setId($videoData['id']);
            return $video;
        }, $videoList);
    }

}