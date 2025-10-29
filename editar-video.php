<?php

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $dbPath);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: /?sucesso=0');
}
$url = $_POST['url'];
if (!filter_var($url, FILTER_VALIDATE_URL)) {
    header('Location: /?sucesso=/0');
    exit();
}
$title = $_POST['titulo'];
if (!filter_var($title)) {
    header('Location: /?sucesso=0');
    exit();
}
$video = new Video($url, $title);
$video->setId($id);

$repository = new VideoRepository($pdo);
if ($repository->update($video)) {
    header('Location: /?sucesso=1');
} else {
    header('Location: /?sucesso=0');
}
