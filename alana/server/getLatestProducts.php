<?php

include 'db.php';

// Read
$sql = $pdo->prepare("SELECT * FROM product ORDER BY update_date DESC LIMIT 6");
$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_OBJ);
// переводим stdClass Object в array
$array = json_decode(json_encode($result), true);

// получаем массив картинок (список имен файлов)
foreach ($array as $key => $value) {
    $newArray[$key] = $value;
    // получаем путь к каталогу с картинками для текущего продукта
    $dir = "../img/catalog/" . strval($value['id_product'] . "/");
    if (file_exists($dir)) {
        $files = scandir($dir);
        // $files содержит ссылки на текущую директорию и родительскую, список файлов с картинками. Оставляем только список картинок, для этого вырезаем со второго по последний элементы массива:
        $files = array_splice($files, 2);
        if ($files) {
            $newArray[$key]['img'] = $files;
        } else {
            $newArray[$key]['img'] = [];
        }
    } else {
        $newArray[$key]['img'] = [];
    }
}
$newArray = json_encode($newArray);
print_r($newArray);       // вывод в консоль браузера