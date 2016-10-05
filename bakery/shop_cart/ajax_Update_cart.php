<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slavik
 * Date: 07.04.15
 * Time: 11:42
 * To change this template use File | Settings | File Templates.
 */
session_start();
include("../../../../wp-load.php");

$itemArr =  (json_decode(stripslashes($_POST['itemArray'])));

$total = 0;

$totalPrice = 0;
if (isset($_SESSION['product'])){
    foreach ($itemArr as $item){

        $_SESSION['product']->products[$item->itemID]->itemCount = $item -> itemCount;
        $total = $total+$item -> itemCount;

        $totalPrice = $totalPrice + $_SESSION['product']->products[$item->itemID]->itemCount* $_SESSION['product']->products[$item->itemID]->price;

    }


    $_SESSION['product']->totalPrice = $totalPrice;
    $_SESSION['product']->totalItem = $total;


}




print_r(json_encode($_SESSION['product']));