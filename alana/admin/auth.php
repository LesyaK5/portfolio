<?php
session_start();

if ($_SESSION['user']) {    // если клиент авторизован, то переадресуем на страницу каталога
    header('Location: catalog.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="center">
        <!-- форма авторизации -->
        <form class="regForm" action="vender/regAndAuth/signin.php" method="post">
            <label for="">Логин</label>
            <input class="regForm__input" type="text" name="userName" placeholder="Введите свой логин">
            <label for="">Пароль</label>
            <input class="regForm__input" type="password" name="password" placeholder="Введите пароль">
            <button class="regForm__button" type="submit">Войти</button>
            <p>
                У вас нет аккаунта? - <a href="registration.php">зарегистрируйтесь</a>!
            </p>

            <?php
            if ($_SESSION['message']) { // если сообщение существует
                echo '<p class="message">' . $_SESSION['message'] . '</p>';
            }
            unset($_SESSION['message']);
            ?>
        </form>
    </div>


</body>

</html>