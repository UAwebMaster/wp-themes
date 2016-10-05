<?
include("../../../../wp-load.php");

$addressID = $_POST['addressID'];
$action = $_POST['action'];

if ($action == 'removeAddress'){

    $query = mysql_query("DELETE FROM  `wp_user_addresses`  WHERE id = $addressID ");
}else if ($action == 'editInfo'){


    $name = $_POST['name'];
    $login = $_POST['login'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $userID = $_POST['userID'];


    if(isset($_POST['street'])){
        $street = $_POST['street'];
        $build = $_POST['build'];
        $flat = $_POST['flat'];

        $address = $street.', '.$build.' кв.'.$flat;

        mysql_query("INSERT INTO wp_user_addresses  (user_id, address) VALUES  ('$userID',  '$address') ");
    }

    if ($name){
        mysql_query(
            "UPDATE `wp_users_social` SET " .
                "`name` = '{$name}', `email` = '{$email}', " .
                "`email` = '{$email}', `phone` = '{$phone}' " .
                "WHERE `social_id`='{$userID}'"
        );

    }else if ($login){
        mysql_query(
            "UPDATE `wp_users_social` SET " .
                "`login` = '{$login}', `email` = '{$email}', " .
                "`email` = '{$email}', `phone` = '{$phone}' " .
                "WHERE `id`='{$userID}'"
        );

    }


}
?>