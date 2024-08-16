<?php

include 'db.php';

$price1 = $_GET['price1'];      // цена от
$price2 = $_GET['price2'];      // цена до
$size = $_GET['size'];          // массив значений
$color = $_GET['color'];        // массив значений
$category = $_GET['category'];
$limit = 9;                     // количество товаров на странице
$selectString = "SELECT * FROM product";
$whereString = '';
if ($price1 != NULL) {
    $whereString = $whereString . 'price >= ' . $price1 . ' and ';
}
if ($price2 != NULL) {
    $whereString = $whereString . 'price <= ' . $price2 . ' and ';
}
if ($size != NULL) {
    $size = substr(trim($size), 1, -1);
    // все значения размеров записываем в массив - разбивка строки в массив (по разделителю ",")
    $sizes = explode(',', $size);
    $whereString = $whereString . '(';
    for ($i = 0; $i < count($sizes); $i++) {
        $whereString = $whereString . 'id_size = ' . $sizes[$i] . ' or ';
    }
    $whereString = substr($whereString, 0, -3);
    $whereString = $whereString . ') and ';
}
if ($color != NULL) {
    $color = substr(trim($color), 1, -1);
    $colors = explode(',', $color);

    $whereString = $whereString . '(';
    for ($i = 0; $i < count($colors); $i++) {
        $whereString = $whereString . 'id_color = ' . $colors[$i] . ' or ';
    }
    $whereString = substr($whereString, 0, -3);
    $whereString = $whereString . ') and ';
}
if ($category != NULL) {
    $whereString = $whereString . 'id_category = ' . $category . ' and ';
}
$whereString = substr($whereString, 0, -5);
if (strlen($whereString) > 0)
    $selectString = $selectString . " WHERE " . $whereString;
$selectString = $selectString . " ORDER BY add_date DESC";

$sql = $pdo->prepare($selectString);
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