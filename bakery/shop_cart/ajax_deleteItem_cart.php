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

$itemID = $_POST['itemID'];

unset($_SESSION['product']->products[$itemID]);

$arrayItem = $_SESSION['product']->sortArray;


if (($key = array_search($itemID, $arrayItem)) !== false) {
    unset($arrayItem[$key]);
}

$_SESSION['product']->sortArray = $arrayItem;