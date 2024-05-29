<?php

include 'db.php';

$sql = $pdo->prepare("SELECT * FROM sizes");
$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_OBJ);
$result = json_encode($result);
print_r($result);

