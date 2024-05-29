<?php
    session_start();
    require_once 'connect.php';

    $full_name = $_POST['full_name'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if ($password === $password_confirm) {
        $password = md5($password);
        if ( mysqli_query($connect, "INSERT INTO `users` (`userName`, `userSurname`, `gender`, `email`, `tel`, `password`, `avatar`) VALUES ('$full_name', NULL, 1, '$email', '$tel', '$password', NULL)")
        ) {
            $_SESSION['message'] = 'Запись в БД прошла успешно!';
            header('Location: ../../catalog.php'); // переход на страницу, чтобы вывести сообщение
        } else {
            $_SESSION['message'] = 'Запись в БД прошла неуспешно!';
            header('Location: ../../registration.php'); // переход на страницу, чтобы вывести сообщение
        }

        $_SESSION['message'] = 'Регистрация прошла успешно!';
        header('Location: ../../catalog.php'); // переход на страницу, чтобы вывести сообщение

    } else {
        $_SESSION['message'] = 'Пароли не совпадают';
        header('Location: ../../registration.php'); // переход на страницу, чтобы вывести сообщение
    }
