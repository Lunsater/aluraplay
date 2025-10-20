<?php

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $dbPath);

$sql = 'DELETE FROM videos WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $_GET['id']);

if ($stmt->execute()) {
    header('Location: index.php');
}