<?php

include 'db.php';

if (isset($_POST['authButton'])) {
    $firstName = (trim($_POST['firstName']));
    $firstName = strtolower($firstName);
    $password = htmlspecialchars(trim($_POST['password']));
    $password = md5($password);
    // $password = md5('123');

    $sql = "SELECT id_customer, `password` FROM customer WHERE userName=?";
    $query = $pdo->prepare($sql);
    $query->execute([$firstName]);  // передаем значения с формы в запрос к БД
    $query = $query->fetch(PDO::FETCH_ASSOC);
    print_r($query);
    
    if ($query['password'] == $password) {
        // header("Location: ../cart.html");
        print_r('Пароль верный');

        $user_token = gen_token();
        // запишем токен в БД
        $sql = "INSERT INTO `sessions` (customer_id, date_create, date_delete, token) VALUES (?, ?, ?, ?)";
        $query2 = $pdo->prepare($sql); // подготавливаем запрос к выполнению
        $query2->execute([
            $query['id_customer'],
            date("Y-m-d H:i:s"),
            NULL,
            $user_token
        ]);  // передаем значения с формы в запрос к БД
        // запишем токен в localStorage на стороне клиента
        // localStorage.setItem('user_token', $user_token);
        echo "<script>localStorage.setItem('user_token', '$user_token');</script>";
        // print_r("<script>localStorage.setItem('user_token', '$user_token');</script>");
        // print_r($user_token);
        // // переходим на страницу каталога
        // header('Location: ../catalog.html');
        if ($query2) {   // если запрос выполнен, то переходим на страницу корзины
            // header("Location: " . $_SERVER['HTTP_REFERER']);
            print_r('сессия создана');
            // header("Location: ../cart.html");
        }
        
    } else {
        print_r('Неверный пароль');
        // header("Location: ../authorization.html");
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
    // $query->fetchColumn();
// $query->fetch();
// echo $query;
    // print_r('kkkkkkk');
    // print_r($query);
}

function gen_token()
{
    $token = md5(microtime() . 'salt' . time());
    return $token;
}