<?php

include 'db.php';

$dbFieldProduct =  [
    'id_product',
    'product_name',
    'product_category',
    'gender_name',
    'price',
    'sale',
    'color_name',
    'size_name',
    'material_name',
    'store_count',
    'blocked',
    'product_description'
];

$product_name = $_POST['product_name'];
$blocked = intval($_POST['blocked']);

$add_date = $_POST['add_date'];
$id_gender = intval($_POST['id_gender']);
$id_category = intval($_POST['id_category']);
$id_material = intval($_POST['id_material']);
$id_color = intval($_POST['id_color']);
$id_size = intval($_POST['id_size']);
$elements_count = intval($_POST['elements_count']);
$store_count = ($_POST['store_count']);
$price = $_POST['price'];
$sale = intval($_POST['sale']);
$new = ($_POST['new']);
$product_description = $_POST['product_description'];
$artikul_store = $_POST['artikul_store'];
$artikul_manufacture = $_POST['artikul_manufacture'];
$id_manufacture = intval($_POST['id_manufacture']);
$make_date = $_POST['make_date'];
$exp_date = $_POST['exp_date'];

$get_id = $_GET['id'];  // id c формы редактирования <form action="?id=<?php echo $res->id_product; ? >" method="post">

if (isset($_POST['add'])) {  // если была нажата кнопка "add"
    // $sql
    $insertProduct = ("INSERT INTO product (
                                product_name, 
                                blocked, 
                                add_date, 
                                update_date, 
                                id_gender, 
                                id_category, 
                                id_material, 
                                id_color, 
                                id_size, 
                                elements_count, 
                                store_count, 
                                price, 
                                sale, 
                                new, 
                                product_description, 
                                artikul_store, 
                                artikul_manufacture, 
                                id_manufacture, 
                                make_date, 
                                exp_date) 
            VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, 
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");    // для безопасности ставим знаки ?, чтобы переменные напрямую не ставить
    $addProduct = $pdo->prepare($insertProduct);   // подготавливаем запрос к исполнению
    try {
        $pdo->beginTransaction();
        $addProduct->execute([   // исполняем запрос с параметрами, полученными с формы id=create на catalog.php 
            $product_name,
            $blocked,
            date("Y-m-d H:i:s"),
            date("Y-m-d H:i:s"),
            $id_gender,
            $id_category,
            $id_material,
            $id_color,
            $id_size,
            $elements_count,
            $store_count,
            $price,
            $sale,
            $new,
            $product_description,
            $artikul_store,
            $artikul_manufacture,
            $id_manufacture,
            $make_date,
            $exp_date
        ]);

        // ЗАПРАШИВАЕМ ID ЭТОГО ТОВАРА 
        $id_product = $pdo->lastInsertId();
        
        $pdo->commit();

        // если удалось добавить новый товар в БД
        if ($id_product) {
            $catalog_dir = '../img/catalog/' . strval($id_product) . '/';

            // если имя пустое, значит файл не выбран 
            if ($_FILES["userfile"]["name"][0] == "") {
                die('Вы не выбрали папку или папка пустая.');
            } else {
                $images = $_FILES["userfile"];

                $maxFileSize = 2097152; // 2Mb = 2*1024*1024b
                $fileTypes = ["image/jpeg", "image/jpg", "image/png", "image/gif", "image/webp", "image/svg", "image/tiff"];

                // проверяем на наличие каталога. В случае отсутствия создаем его.
                if (!is_dir($catalog_dir)) {
                    mkdir($catalog_dir, 0777, true);
                }

                // перепишем массив изображений в нормальный вид
                $imagesNormalize = [];
                foreach ($images as $keyOuter => $value) {
                    foreach ($value as $keyInner => $item) {
                        $imagesNormalize[$keyInner][$keyOuter] = $item;
                    }
                }

                foreach ($imagesNormalize as $image) {

                    // валидация по типу файла
                    if (!in_array($image["type"], $fileTypes)) {
                        // die($image["name"] . "Неверный формат файла"); // завершит цикл
                        print_r($image["name"] . "Неверный формат файла.\n"); // завершит цикл
                    } else
                        // валидация на размер файла
                        if ($image["size"] > $maxFileSize || $image["size"] == 0) {
                            // die($image["name"] . "Размер файла превышает максимальный!"); // завершит цикл
                            print_r($image["name"] . "Размер файла превышает максимальный!\n"); // завершит цикл
                        } else {
                            // переносим файл изображения из временной папки в наш каталог, создав уникальное имя файла
                            $extension = pathinfo($image["name"], PATHINFO_EXTENSION); // получаем расширение файла
                            $fileName = time() . $image["name"];
                            move_uploaded_file($image["tmp_name"], $catalog_dir . $fileName);
                        }
                }
            }
        }
    } catch (PDOException $e) {

        print "Error!: " . $e->getMessage() . "</br>";

    }

    if ($addProduct) {       // если запрос выполнен, то перегружаем страницу
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}

//************************************************************************************ */
// Read from DB
// при открытии страницы catalog.php загружаются все товары
$selectProduct = "SELECT 
    product.id_product, 
    product.product_name, 
    product.id_category,
    product_category.category_name, 
    product.id_gender,
    gender_types.gender_name, 
    product.price, 
    product.sale, 
    product.id_color,
    colors.color_name, 
    product.id_size,
    sizes.size_name, 
    product.id_material,
    material_types.material_name, 
    product.store_count, 
    product.blocked, 
    product.product_description,
    product.elements_count,
    product.new,
    product.artikul_store,
    product.artikul_manufacture,
    product.id_manufacture,
    product.make_date,
    product.exp_date,
    product.add_date
    FROM `product`, `gender_types`, `material_types`, `product_category`, `colors`, `sizes` 
    WHERE product.id_gender = gender_types.id_gender 
        AND product.id_category = product_category.id_category 
        AND product.id_material = material_types.id_material 
        AND product.id_color = colors.id_color 
        AND product.id_size = sizes.id_size 
        -- AND product.blocked = 0 
        -- AND product.store_count > 1 
    ORDER BY add_date;";
$allProducts = $pdo->prepare($selectProduct);
$allProducts->execute();
$result = $allProducts->fetchAll(PDO::FETCH_OBJ);

// список категорий товаров
$selectCategory = "SELECT * from product_category;";
$category_query = $pdo->prepare($selectCategory);
$category_query->execute();
$categories = $category_query->fetchAll(PDO::FETCH_OBJ);

// список цветов
$selectColors = "SELECT * FROM `colors`;";
$color_query = $pdo->prepare($selectColors);
$color_query->execute();
$colors = $color_query->fetchAll(PDO::FETCH_OBJ);

// категория товаров по полу
$selectGender = "SELECT * FROM `gender_types`;";
$gender_query = $pdo->prepare($selectGender);
$gender_query->execute();
$gender = $gender_query->fetchAll(PDO::FETCH_OBJ);

// состав ткани
$selectMaterial = "SELECT * FROM `material_types`;";
$material_query = $pdo->prepare($selectMaterial);
$material_query->execute();
$material = $material_query->fetchAll(PDO::FETCH_OBJ);

// список размеров
$selectSizes = "SELECT * FROM `sizes`;";
$sizes_query = $pdo->prepare($selectSizes);
$sizes_query -> execute();
$sizes = $sizes_query->fetchAll(PDO::FETCH_OBJ);

// Выборка всех товаров с категорией товаров, полом, типом материала, цветом и размером
function selectFromProduct($table1, $table2, $table3, $table4, $table5, $table6, $limitOnPage, $offset) {
    global $pdo;
    $selectProduct = "SELECT 
    p.*,
    g.gender_name, 
    m.material_name, 
    pc.category_name, 
    c.color_name, 
    s.size_name
    FROM  $table1 AS p, $table2 AS g, $table3 AS m, $table4 AS pc, $table5 AS c, $table6 AS s
    WHERE p.id_gender = g.id_gender 
        AND p.id_category = pc.id_category 
        AND p.id_material = m.id_material 
        AND p.id_color = c.id_color 
        AND p.id_size = s.id_size 
        -- AND p.blocked = 0 
        -- AND p.store_count > 1 
    ORDER BY add_date
    LIMIT $limitOnPage
    OFFSET $offset;";
    
    $allProducts = $pdo->prepare($selectProduct);
    $allProducts->execute();
    return $allProducts->fetchAll(PDO::FETCH_OBJ);
}


//****************************************************************************************** */
// edit 
if (isset($_POST['edit'])) {  // если была нажата кнопка "edit"

    $editProduct = "UPDATE product SET
                    product_name = ?,
                    blocked = ?,
                    update_date = ?,
                    id_gender = ?,
                    id_category = ?,
                    id_material = ?,
                    id_color = ?,
                    id_size = ?,
                    elements_count = ?,
                    store_count = ?,
                    price = ?,
                    sale = ?,
                    new = ?,
                    product_description = ?,
                    artikul_store = ?,
                    artikul_manufacture = ?,
                    id_manufacture = ?,
                    make_date = ?,
                    exp_date = ?
                    WHERE id_product = ?
                    ";
    $editProduct_query = $pdo->prepare($editProduct);
    try {
        $pdo->beginTransaction();
        $editProduct_query->execute([
            $product_name,
            $blocked,
            date("Y-m-d H:i:s"),
            $id_gender,
            $id_category,
            $id_material,
            $id_color,
            $id_size,
            $elements_count,
            $store_count,
            $price,
            $sale,
            $new,
            $product_description,
            $artikul_store,
            $artikul_manufacture,
            $id_manufacture,
            $make_date,
            $exp_date,
            $get_id
        ]);
        $pdo->commit();
    } catch (PDOException $e) {

        print "Error!: " . $e->getMessage() . "</br>";

    }
    if ($editProduct_query) {       // если запрос выполнен, то перегружаем страницу
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}


//************************************************************************************** */
//  delete
// $deleteProduct = "DELETE FROM product 
//                     WHERE id_product = ?
//                     ";
if (isset($_POST['delete'])) {  // если была нажата кнопка "delete"
    // $sql
    $deleteProduct = "UPDATE product SET
                    blocked = ?
                    WHERE id_product = ?
                    ";
    $deleteProduct_query = $pdo->prepare($deleteProduct);
    try {
        $pdo->beginTransaction();
        $deleteProduct_query->execute([
            1,
            $get_id
        ]);
        $pdo->commit();
    } catch (PDOException $e) {

        print "Error!: " . $e->getMessage() . "</br>";

    }
    if ($deleteProduct_query) {       // если запрос выполнен, то перегружаем страницу
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}


//********************************************************************************************** */
// pagination
function countRow($table) {
    global $pdo;        // получаем извне
    $sql = "SELECT COUNT(*) FROM $table ";
    $query = $pdo->prepare($sql);
    $query->execute();
    return $query->fetchColumn();
}