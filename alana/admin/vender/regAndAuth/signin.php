<?php
    session_start();
    require_once 'connect.php';

    $userName = $_POST['userName'];
    $password = $_POST['password'];
    $password = md5($password);

    $check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `userName` = '$userName' AND `password` = '$password'");

if (headers_sent()) {
    var_dump(headers_list());
}

if (mysqli_num_rows($check_user) > 0) {
        $user = mysqli_fetch_assoc($check_user); // запись/строку из БД переводим в массив
        $_SESSION['user'] = [
            "userId" => $user['id'],
            "userName" => $user['userName'],
            "tel" => $user['tel'],
            "email" => $user['email']
        ];
        header('Location: ../../catalog.php');
    } else {
        $_SESSION['message'] = 'Неверный логин или пароль';
        header('Location: ../../index.php'); // переход на страницу, чтобы вывести сообщение
    }
?>
<!-- <pre>
    <?php    
        print_r($check_user);
        print_r($user);
    ?>
</pre> -->