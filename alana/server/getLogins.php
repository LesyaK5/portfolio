<?php

include 'db.php';

$sql = "SELECT userName FROM customer";
$query = $pdo->prepare($sql);
$query->execute();
$query = $query->fetchAll(PDO::FETCH_COLUMN);
$query = json_encode($query);
print_r($query);