<?php

$host = 'localhost';
$db = 'shop1';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
} catch (PDOException $e) {
    echo 'Ошибка соединения с БД '.$e->getMessage();
}
