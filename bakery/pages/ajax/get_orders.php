<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slavik
 * Date: 09.12.15
 * Time: 11:25
 * To change this template use File | Settings | File Templates.
 */
include("../../../../../wp-load.php");
require_once('../administration/AdministrationOrders.php');

$Orders = new AdministrationOrders();


$date_start = $_POST['date_start'];
$date_end = $_POST['date_end'];


$array_orders = array();
$array_orders =  json_decode($Orders -> getOrders($date_start,$date_end)) ;




foreach ($array_orders as $single_order){
    $quantity = $Orders -> getQuantityInvoiceByID($single_order->invoice_id); // get total quantity by invoice_id

    $price = $Orders -> getPriceInvoiceByID($single_order->invoice_id);
    $price += $single_order -> delivery_price;  // get total price by invoice_id
//        print_r($single_order);

    if ($single_order->payment_type == 'cash'){
        $oplata = 'Готівкою';
    }else if ($single_order->payment_type == 'private24'){
        $oplata = 'Оплачено Приват24';
    }else{
        $oplata = '';
    }
    $order_status = '';
    if($single_order->order_status == 1){
        $order_status = '<button id="accept-order-id" data-order-id="'.$single_order->invoice_id.'">Прийняти</button>';
    }else if($single_order->order_status == 2){
        $order_status = 'Прийнято';
    }
    $single_order->quantity = $quantity;
//    $single_order->order_status = $order_status;
    $single_order->price  = $price;
    $single_order->oplata  = $oplata;



}
echo  json_encode( $array_orders);
die();
