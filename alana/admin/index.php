<?php
    session_start();
    // if (!$_SESSION['user']) {    // если клиент не авторизован, то переадресуем на страницу авторизации
    //     header('Location: index.php');
    // }
    include 'vender/workingWithProducts.php'; 

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1; // если GET-запрос содержит параметр page, то мы его получим. если нет, то назначим 1
    $limitOnPage = 5;                        // количество товаров на странице
    $offset = $limitOnPage * ($page - 1);    // сколько товаров нужно пропустить
    $totalPages = ceil(countRow('product') / $limitOnPage);     // количество страниц //общее число товаров - получаем с помощью метода countRow из таблицы product
    $products = selectFromProduct('product', 'gender_types', 'material_types', 'product_category', 'colors', 'sizes', $limitOnPage, $offset);
?>
<!doctype html>
<html lang="ru">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Каталог</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/249c288045.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="box_flex">
                    <button class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#create"><i
                        class="fa fa-plus"></i></button>
                    <a href="vender/regAndAuth/logout.php" class="btn btn-danger logout"><i
                        class="fa fa-sign-out"></i></a>
                </div>                

                <table class="table table-striped table-hover mt-2">
                    <thead class="table-dark thead-fixed" style="position: sticky;top: 0">
                        <th>Действия</th>
                        <th>Изображение</th>
                        <th>ID товара</th>
                        <th>Название товара</th>
                        <th>Категория товара</th>
                        <th>Пол</th>
                        <th>Цена, в руб.</th>
                        <th>Скидка, в %</th>
                        <th>Цена с учетом скидки, в руб.</th>
                        <th>Цвет</th>
                        <th>Размер</th>
                        <th>Состав</th>
                        <th>Количество на складе</th> <!-- store_count -->
                        <th>Заблокирован</th>
                        <th>Описание</th>
                    </thead>
                    <tbody class="tbody_padding">
                        <?php foreach ($products as $res) { ?>
                            <tr>
                                <td>
                                    <a href="?id=<?php echo $res->id_product; ?>" class="btn btn-success"
                                        data-bs-toggle="modal" data-bs-target="#edit<?php echo $res->id_product; ?>"><i
                                            class="fa fa-edit"></i></a>
                                    <a href="" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#delete<?php echo $res->id_product; ?>"><i
                                            class="fa fa-trash-alt"></i></a>
                                </td>
                                
                                <td>
                                    <?php
                                    $directory = '../img/catalog/' . $res->id_product . '/';
                                    $files = scandir($directory);
                                    $firstFile = $directory . $files[2];// because [0] = "." [1] = ".." 
                                    ?>
                                    <img src="<?php echo $firstFile; ?>" alt="изображение товара">
                                </td>

                                <td>
                                    <?php echo $res->id_product; ?>
                                </td>
                                <td>
                                    <?php echo $res->product_name; ?>
                                </td>
                                <td>
                                    <?php echo $res->category_name; ?>
                                </td>
                                <td>
                                    <?php echo $res->gender_name; ?>
                                </td>
                                <td>
                                    <?php echo $res->price; ?>
                                </td>
                                <td>
                                    <?php echo $res->sale; ?>
                                </td>
                                <td>
                                    <?php echo $res->price - ceil($res->price * $res->sale / 100); ?>
                                </td>
                                <td>
                                    <?php echo $res->color_name; ?>
                                </td>
                                <td>
                                    <?php echo $res->size_name; ?>
                                </td>
                                <td>
                                    <?php echo $res->material_name; ?>
                                </td>
                                <td>
                                    <?php echo $res->store_count; ?>
                                </td>
                                <td>
                                    <?php if ($res->blocked) {
                                            echo 'да';
                                        } else {
                                            echo 'нет';
                                        } ?>
                                </td>
                                <td>
                                    <?php echo $res->product_description; ?>
                                </td>
                            </tr>
                            <!-- Модальное окно Modal edit-->
                            <div class="modal fade" id="edit<?php echo $res->id_product; ?>" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Изменить запись</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Закрыть"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Добавим форму -->
                                            <form action="?id=<?php echo $res->id_product; ?>" method="post">
                                                <div class="form-group">
                                                    <small>Название товара</small>
                                                    <input type="text" class="form-control" name="product_name"
                                                        value="<?php echo $res->product_name; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <small>Доступен для заказа</small><br>
                                                    <input type="radio" class="radio" name="blocked" value="0" <?php if (!$res->blocked) {
                                                        echo "checked";
                                                    } ?>><small>
                                                        разблокировать</small>
                                                    <input type="radio" class="radio" name="blocked" value="1" <?php if (+$res->blocked) {
                                                        echo "checked";
                                                    } ?>><small>
                                                        заблокировать</small>
                                                </div>
                                                <div class="form-group">
                                                    <small>Выберите пол</small><br>
                                                    <?php foreach ($gender as $gen) { ?>
                                                        <input type="radio" class="radio" name="id_gender"
                                                            id="gender<?php echo $gen->id_gender ?>"
                                                            value="<?php echo $gen->id_gender ?>" <?php if ($gen->id_gender == $res->id_gender) {
                                                                   echo "checked";
                                                               } ?>>
                                                        <label for="gender<?php echo $gen->id_gender ?>"><small>
                                                                <?php echo $gen->gender_name ?>
                                                            </small></label><br>
                                                    <?php } ?>
                                                </div>
                                                <div class="form-group">
                                                    <small>Категория товара</small>
                                                    <select name="id_category" class="form-control">
                                                        <?php foreach ($categories as $cat): ?>
                                                            <option value="<?php echo $cat->id_category; ?>" <?php if ($cat->id_category == $res->id_category) {
                                                                   echo "selected";
                                                               } ?>>
                                                                <?php echo $cat->category_name; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <small>Состав</small>
                                                    <select name="id_material" class="form-control">
                                                        <?php foreach ($material as $cloth) { ?>
                                                            <option value="<?php echo $cloth->id_material ?>" <?php if ($cloth->id_material == $res->id_material) {
                                                                   echo "selected";
                                                               } ?>>
                                                                <?php echo $cloth->material_name ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <small>Выберите цвет</small>
                                                    <select name="id_color" class="form-control">
                                                        <?php foreach ($colors as $color) { ?>
                                                            <option value="<?php echo $color->id_color ?>" <?php if ($color->id_color == $res->id_color) {
                                                                   echo "selected";
                                                               } ?>>
                                                                <?php echo $color->color_name ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <small>Размер</small>
                                                    <select name="id_size" class="form-control">
                                                        <?php foreach ($sizes as $size) { ?>
                                                            <option value="<?php echo $size->id_size ?>" <?php if ($size->id_size == $res->id_size) {
                                                                   echo "selected";
                                                               } ?>>
                                                                <?php echo $size->size_name ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <small>Количество элементов</small>
                                                    <input type="text" class="form-control" name="elements_count"
                                                        value="<?php echo $res->elements_count; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <small>Количество на складе</small>
                                                    <input type="text" class="form-control" name="store_count"
                                                        value="<?php echo $res->store_count; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <small>Цена</small>
                                                    <input type="text" class="form-control" name="price"
                                                        value="<?php echo $res->price; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <small>Скидка, в %</small>
                                                    <input type="text" class="form-control" name="sale"
                                                        value="<?php echo $res->sale; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <small>Новинка (1-новинка, 0-нет)</small>
                                                    <input type="text" class="form-control" name="new"
                                                        value="<?php echo $res->new; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <small>Описание</small>
                                                    <input type="text" class="form-control" name="product_description"
                                                        value="<?php echo $res->product_description; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <small>Артикул магазина, если есть</small>
                                                    <input type="text" class="form-control" name="artikul_store"
                                                        value="<?php echo $res->artikul_store; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <small>Артикул производителя</small>
                                                    <input type="text" class="form-control" name="artikul_manufacture"
                                                        value="<?php echo $res->artikul_manufacture; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <small>Номер производителя (можно будет выбрать из таблицы!!!)</small>
                                                    <input type="text" class="form-control" name="id_manufacture"
                                                        value="<?php echo $res->id_manufacture; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <small>Дата изготовления</small>
                                                    <input type="text" class="form-control" name="make_date"
                                                        value="<?php echo $res->make_date; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <small>Срок годности</small>
                                                    <input type="text" class="form-control" name="exp_date"
                                                        value="<?php echo $res->exp_date; ?>">
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Закрыть</button>
                                                    <button type="submit" class="btn btn-primary"
                                                        name="edit">Сохранить</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Модальное окно Modal edit -->

                            <!-- Модальное окно Modal delete-->
                            <div class="modal fade" id="delete<?php echo $res->id_product; ?>" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Удалить товар №
                                                <?php echo $res->id_product; ?>
                                            </h1><br>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Закрыть"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h2>
                                                <?php echo $res->product_name; ?>
                                            </h2>
                                            <p>Категория:
                                                <?php echo $res->category_name; ?>
                                            </p>
                                            <p>Пол:
                                                <?php echo $res->gender_name; ?>
                                            </p>
                                            <p>Новая цена: 
                                                <?php echo $res->price; ?> руб.
                                            </p>
                                            <p>Скидка: 
                                                <?php echo $res->sale; ?> %
                                            </p>
                                            <p>Новая цена: 
                                                <?php echo $res->price - ceil($res->price * $res->sale / 100); ?> руб.
                                            </p>
                                            <p>Цвет: 
                                                <?php echo $res->color_name; ?>
                                            </p>
                                            <p>Размер: 
                                                <?php echo $res->size_name; ?>
                                            </p>
                                            <p>Состав: 
                                                <?php echo $res->material_name; ?>
                                            </p>
                                            <p>Количество на складе: 
                                                <?php echo $res->store_count; ?>
                                            </p>
                                            <p>Заблокирован: 
                                                <?php if($res->blocked) { echo 'да'; } else { echo 'нет';} ?>
                                            </p>
                                            <p>Описание товара: 
                                                <?php echo $res->product_description; ?>
                                            </p>

                                            <div class="modal-footer">
                                                <!-- Добавим форму -->
                                                <form action="?id=<?php echo $res->id_product; ?>" method="post">

                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Закрыть</button>
                                                    <button type="submit" class="btn btn-danger"
                                                        name="delete">Удалить</button>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Модальное окно Modal delete -->

                        <?php } ?>

                    </tbody>
                </table>

                <!-- Подключение навигации по страницам - пагинация -->
                <?php include("pagination.php") ?>
            </div>
        </div>
    </div>

    <!-- Модальное окно Modal create (для добавления товара)-->
    <div class="modal fade" id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Добавить товар</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <!-- Добавим форму -->
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <small>Название товара</small>
                            <input type="text" class="form-control" name="product_name">
                        </div>
                        <div class="form-group">
                            <small>Доступен для заказа</small><br>
                            <input type="radio" class="radio" name="blocked" value="0"><small> разблокировать</small>
                            <input type="radio" class="radio" name="blocked" value="1"><small> заблокировать</small>
                        </div>
                        <div class="form-group">
                            <small>Выберите пол</small><br>
                            <?php foreach ($gender as $gen) { ?>
                                <input type="radio" class="radio" name="id_gender" id="gender<?php echo $gen->id_gender ?>"
                                    value="<?php echo $gen->id_gender ?>">
                                <label for="gender<?php echo $gen->id_gender ?>"><small>
                                        <?php echo $gen->gender_name ?>
                                    </small></label><br>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <small>Категория товара</small>
                            <select name="id_category" class="form-control">
                                <?php foreach ($categories as $cat) { ?>
                                    <option value="<?php echo $cat->id_category; ?>">
                                        <?php echo $cat->category_name; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <small>Состав</small>
                            <select name="id_material" class="form-control">
                                <?php foreach ($material as $cloth) { ?>
                                    <option value="<?php echo $cloth->id_material ?>">
                                        <?php echo $cloth->material_name ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <small>Выберите цвет</small>
                            <select name="id_color" class="form-control">
                                <?php foreach ($colors as $color) { ?>
                                    <option value="<?php echo $color->id_color ?>">
                                        <?php echo $color->color_name ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <small>Размер</small>
                            <select name="id_size" class="form-control">
                                <?php foreach ($sizes as $size) { ?>
                                    <option value="<?php echo $size->id_size ?>">
                                        <?php echo $size->size_name ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <small>Количество элементов</small>
                            <input type="text" class="form-control" name="elements_count">
                        </div>
                        <div class="form-group">
                            <small>Количество на складе</small>
                            <input type="text" class="form-control" name="store_count">
                        </div>
                        <div class="form-group">
                            <small>Цена</small>
                            <input type="text" class="form-control" name="price">
                        </div>
                        <div class="form-group">
                            <small>Скидка, в %</small>
                            <input type="text" class="form-control" name="sale">
                        </div>
                        <div class="form-group">
                            <small>Новинка (1-новинка, 0-нет)</small>
                            <input type="text" class="form-control" name="new">
                        </div>
                        <div class="form-group">
                            <small>Описание</small>
                            <textarea class="form-control" name="product_description" id="product_description" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <small>Артикул магазина, если есть</small>
                            <input type="text" class="form-control" name="artikul_store">
                        </div>
                        <div class="form-group">
                            <small>Артикул производителя</small>
                            <input type="text" class="form-control" name="artikul_manufacture">
                        </div>
                        <div class="form-group">
                            <small>Номер производителя (можно будет выбрать из таблицы!!!)</small>
                            <input type="text" class="form-control" name="id_manufacture">
                        </div>
                        <div class="form-group">
                            <small>Дата изготовления</small>
                            <input type="text" class="form-control" name="make_date">
                        </div>
                        <div class="form-group">
                            <small>Срок годности</small>
                            <input type="text" class="form-control" name="exp_date">
                        </div>

                        <!-- добавим изображения -->
                        <div class="form-group">
                            <small>Выберите каталог с изображениями товара:</small>
                            <input name="userfile[]" type="file" webkitdirectory multiple />
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                            <button type="submit" class="btn btn-primary" name="add">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Модальное окно Modal create -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>