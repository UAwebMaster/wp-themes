<?php
/*
Template Name: news page
*/
include("../../../../wp-load.php");
include("../../../../wp-config.php");
?><?

    $login = $_POST[login];
    $pwd = $_POST[pwd];
    $phone = $_POST[phone];
    $mail = $_POST[email];
    $action = $_POST[action];
    $fromPage = $_POST[fromPage];

//    $result = mysql_query("SELECT meta_value FROM `wp_postmeta` WHERE post_id = $post_id AND meta_key = 'wpcf-price' ")or die("ERROR: ".mysql_error());
if ($action == 1){

    $err = array();


# проверяем, не сущестует ли пользователя с таким именем
    $query = mysql_query("SELECT COUNT(id) FROM wp_users_social WHERE login='".mysql_real_escape_string($login)."'")or die ("<br>Invalid query: " . mysql_error());
    if(mysql_result($query, 0) > 0)
    {
        $err[] = "Користувач з таким іменем вже існує в базі даних";
        echo (0);
    }
# Если нет ошибок, то добавляем в БД нового пользователя
    if(count($err) == 0)
    {
        mysql_query("INSERT INTO wp_users_social SET login='".$login."', phone='".$phone."',email='".$mail."', provider='registration', birthday='',sex='', password='".$pwd."'");
        $id = mysql_insert_id();
        # Ставим куки
        setcookie("id", $id, time()+60*60*24*30);

        # Переадресовываем браузер на страницу проверки нашего скрипта
        session_start();
        $_SESSION['user']= $id;

        echo (1);
    }
}else {

# Вытаскиваем из БД запись, у которой логин равняеться введенному
$data = mysql_fetch_assoc(mysql_query("SELECT id, password, email FROM `wp_users_social` WHERE `login`='".mysql_real_escape_string($login)."' LIMIT 1"));


    if (!is_null($data[id])){
        # Соавниваем пароли
        if($data['password'] === ($pwd) || $data['password'] === ($mail))
        {
            # Ставим куки
            setcookie("id", $data['users_id'], time()+60*60*24*30);
            # Переадресовываем браузер на страницу проверки нашего скрипта
            session_start();
            $_SESSION['user']= $data['id'];
            if($fromPage == 'cart'){
                echo (2);//from cart
            }else{
                echo (1);//from calendar
            }
        }else{
            echo '<p class="wpcf7-mail-sent-ng"></p><span>Введений невірний пароль</span>';
        }
    }else {
        echo '<p class="wpcf7-mail-sent-ng"></p><span>Не знайдено користувача з таким логіном</span>';
    }


}


?>

