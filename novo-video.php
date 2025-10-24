<?php

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $dbPath);

$sql = 'INSERT INTO videos (url, title) VALUES (:url, :title)';
$stmt = $pdo->prepare($sql);
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
$stmt->bindParam(':url', $url);
$stmt->bindParam(':title', $title);

if ($stmt->execute()) {
    header('Location: /?sucesso=1');
} else {
    header('Location: /?sucesso=0');
}
