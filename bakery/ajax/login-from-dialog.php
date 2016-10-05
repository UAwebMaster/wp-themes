<?php
/*
Template Name: news page
*/
include("../../../../wp-load.php");

$login = $_POST['login'];
$pwd = $_POST['pwd'];


# Вытаскиваем из БД запись, у которой логин равняеться введенному
$data = mysql_fetch_assoc(mysql_query("SELECT id, password, email FROM `wp_users_social` WHERE `login`='" . mysql_real_escape_string($login) . "' LIMIT 1"));

$object = new stdClass();

if (!is_null($data['id'])) {
    # Соавниваем пароли
    if ($data['password'] === ($pwd) ) {
        # Ставим куки
        setcookie("id", $data['id'], time() + 60 * 60 * 24 * 30);
        # Переадресовываем браузер на страницу проверки нашего скрипта
        session_start();
        $_SESSION['user'] = $data['id'];

        $object->status_login = 1;

    } else {
        $object->status_pwd = 0;
    }
} else {
    $object->status_login = 0;
    $object->status_pwd = 0;
}

echo json_encode($object);



?>

