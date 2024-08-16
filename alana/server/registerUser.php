<?php

include 'db.php';

// если логин введен
if (isset($_POST['firstName'])) {
    $firstName = (trim($_POST['firstName']));
    $firstName = strtolower($firstName);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $email = htmlspecialchars(trim($_POST['email']));
    $email = strtolower($email);
    $password = htmlspecialchars(trim($_POST['password']));
    $password = md5($password);

    $sql = "INSERT INTO customer (userName, userLastName, userSurname, birthdate, passport, INN, tel, email, password, password_salt, home_address, pup_address) VALUES (:userName, NULL, NULL, NULL, NULL, NULL, :tel, :email, :password, 'salt', 2, 1)";
    $result = $pdo->prepare($sql);
    try {
        $pdo->beginTransaction();
        $result->bindParam(':userName', $firstName, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':tel', $phone, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->execute();
        // ЗАПРАШИВАЕМ ID ЭТОГО КЛИЕНТА 
        $user_id = $pdo->lastInsertId();
        $pdo->commit();
        
        if ($user_id) {
            $user_token = gen_token();
            // запишем токен в БД
            $sql = "INSERT INTO `sessions` (customer_id, date_create, date_delete, token) VALUES (?, ?, ?, ?)";
            $query = $pdo->prepare($sql); // подготавливаем запрос к выполнению
            $query->execute([$user_id, date("Y-m-d H:i:s"),
                NULL, $user_token]);  // передаем значения с формы в запрос к БД
            // запишем токен в localStorage на стороне клиента
            echo "<script>
                localStorage.setItem('user_token', '$user_token');
                let messageText = document.querySelector('.regForm-title');
                messageText.innerHTML = 'Регистрация прошла успешно';
                </script>";
            // print_r($user_token);
            // // переходим на страницу каталога
            // header('Location: ../catalog.html');
            if ($query) {   // если запрос выполнен, то перегружаем страницу
                // sleep(5);
                header("Location: " . $_SERVER['HTTP_REFERER']);   
            }
        }
    } catch (PDOException $e) {

        // $pdo->rollback();

        print "Error!: " . $e->getMessage() . "</br>";

    }
} else {
    print_r('Значение не передано');
}

function gen_token()
{
    $token = md5(microtime() . 'salt' . time());
    return $token;
}