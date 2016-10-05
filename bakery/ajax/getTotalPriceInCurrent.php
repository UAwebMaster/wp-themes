<?php
/*
Template Name: news page
*/


include("../../../../wp-load.php");
include("../../../../wp-config.php");
/*define('DB_SERVER', 'a7second.mysql.ukraine.com.ua');
define('DB_USERNAME', 'a7second_bakery');
define('DB_PASSWORD', '3lvl2b5h');
define('DB_DATABASE', 'a7second_bakery');
$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die('Oops connection error -> ' . mysql_error());
mysql_select_db(DB_DATABASE, $connection) or die(mysql_error());*/

?><?

    $post_id_array = $_POST[post_id_array];
    $quantity_array = $_POST[quantity_array];
    $array_of_price = array();
    foreach($post_id_array as $post_id){

        $result = mysql_query("SELECT meta_value FROM `wp_postmeta` WHERE post_id = $post_id AND meta_key = 'wpcf-price' ")or die("ERROR: ".mysql_error());
        $res = mysql_fetch_assoc($result);
        $price = $res['meta_value'];
        array_push($array_of_price, $price);
    }
foreach ($array_of_price as $i => $price) {
       $total =$total+ $price* $quantity_array[$i];
}
echo $total;
?>

