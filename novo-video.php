<?php

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $dbPath);

$sql = 'INSERT INTO videos (url, title) VALUES (:url, :title)';
$stmt = $pdo->prepare($sql);
$url = filter_input(INPUT_POST, $_POST['url'], FILTER_VALIDATE_URL);
if (!$url) {
  header('Location: index.php');
  //exit();
}
$title = filter_input(INPUT_POST, $_POST['title']);
if (!$title) {
    header('Location: index.php');
    //exit();
}
$stmt->bindParam(':url', $url);
$stmt->bindParam(':title', $title);

if ($stmt->execute()) {
    header('Location: index.php?sucesso=1');
} else {
    header('Location: index.php?sucesso=0');
}
