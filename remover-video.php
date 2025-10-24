<?php

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $dbPath);

$sql = 'DELETE FROM videos WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $_GET['id']);

if ($stmt->execute()) {
    header('Location: /?sucesso=1');
} else {
    header('Location: /?sucesso=0');
}