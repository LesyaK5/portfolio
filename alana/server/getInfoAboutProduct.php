<?php

include 'db.php';

$productID = $_GET['id'];

$sql = "SELECT 
    product.id_product, 
    product.product_name, 
    gender_types.gender_name, 
    product.price, 
    product.blocked, 
    product.product_description
    FROM `product`, `gender_types`
    WHERE product.id_gender = gender_types.id_gender 
        AND product.id_product=$productID";
$sql = $pdo->prepare($sql);
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
print_r($newArray);   // возвращаем результат в js-файл (в клиентскую часть)
