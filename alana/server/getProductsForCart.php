<?php

include 'db.php';

$productsID = $_GET['id'];  
// убираем первый и последний символы - []
$productsID = substr(trim($productsID), 1, -1);
$sql = "SELECT product.*, colors.color_name, sizes.size_name, product_category.category_name FROM `product` \n"
    . "INNER JOIN `colors` ON product.id_color = colors.id_color\n"
    . "INNER JOIN `sizes` ON product.id_size = sizes.id_size\n"
    . "INNER JOIN `product_category` ON product.id_category = product_category.id_category\n"
    . "WHERE product.id_product IN ($productsID);";

$query = $pdo->prepare($sql);
$query->execute();
$query = $query->fetchAll(PDO::FETCH_OBJ);

// переводим stdClass Object в array
$array = json_decode(json_encode($query), true);


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
print_r($newArray);
