<?php

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $dbPath);

$url = $_POST['url'];
if (!filter_var($url, FILTER_VALIDATE_URL)) {
    header('Location: /?sucesso=0');
    exit();
}
$title = $_POST['titulo'];
if (!filter_var($title)) {
    header('Location: /?sucesso=0');
    exit();
}
$repository = new VideoRepository($pdo);
if ($repository->add(new Video($url, $title))) {
    header('Location: /?sucesso=1');
} else {
    header('Location: /?sucesso=0');
}
