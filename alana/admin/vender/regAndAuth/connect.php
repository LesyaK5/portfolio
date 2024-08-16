<!-- mysqli_connect -->
<?php
$connect = mysqli_connect('localhost', 'root', '', 'shop1');

if (!$connect) {
    die('Ошибка соединения с БД');
}