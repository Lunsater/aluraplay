<?php

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $dbPath);
$pdo->exec("CREATE TABLE IF NOT EXISTS videos (id Integer PRIMARY KEY, url TEXT, title TEXT)");
