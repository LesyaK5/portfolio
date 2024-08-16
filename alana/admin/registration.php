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
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- форма регистрации -->
    <div class="center">
        <form action="vender/regAndAuth/signup.php" method="post">
            <label for="">Логин</label>
            <input type="text" name="full_name" placeholder="Введите свой логин">
            <label for="">Телефон</label>
            <input type="text" name="tel" placeholder="Введите свой телефон">
            <label for="">Почта</label>
            <input type="email" name="email" placeholder="Введите свою электронную почту">
            <label for="">Пароль</label>
            <input type="password" name="password" placeholder="Введите пароль">
            <label for="">Повторите пароль</label>
            <input type="password" name="password_confirm" placeholder="Подтвердите пароль">
            <button type="submit">Зарегистрироваться</button>
            <p>
                У вас уже есть аккаунт? - <a href="/admin/index.php">авторизуйтесь</a>!
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