<?php

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
$sql = 'UPDATE videos SET url = :url, title = :title WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':url', $url, PDO::PARAM_STR);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);

if ($stmt->execute()) {
    header('Location: /?sucesso=1');
} else {
    header('Location: /?sucesso=0');
}
