<?php

include("../../../../wp-load.php");



$invoice_id = $_POST['invoiceID'];

$res_query = mysql_query("SELECT * FROM wp_orders
INNER JOIN wp_goodsfororders ON wp_orders.id = wp_goodsfororders.invoice_id
INNER JOIN wp_user_addresses ON wp_orders.order_address_id = wp_user_addresses.id
WHERE wp_orders.id = $invoice_id");


$totalObject = new ArrayObject();

$date_invoice = '';
$startTime = '';
$endTime = '';


$object_products = new ArrayObject();
while ($data = mysql_fetch_assoc($res_query)){
    $object = new stdClass();

    $itemID = $data['itemId'];



    $object -> itemID = $data['itemId'];
    $object -> price =  do_shortcode('[types field="price" id=' . $data['itemId'] . ' "]');
    $object -> image =  do_shortcode('[types field="my-image" id=' . $data['itemId'] . ' width="50" height="50" "]');
    $object -> title =  get_the_title($data['itemId']);
    $object -> status = $data['status'];

    $object -> itemCount =   $data['quantity'];

    $date_invoice =   $data['date'];
    $startTime =    $data['time_from'];
    $endTime  =   $data['time_to'];



    $object_products[$itemID]= $object;
}



$totalObject['date'] = $date_invoice ;
$totalObject['startTime'] = $startTime ;
$totalObject['endTime'] = $endTime ;

$totalObject['invoiceID'] = $invoice_id ;

$totalObject['products'] = $object_products ;
$totalObject['sortArray'] = $_SESSION['product']->sortArray ;
echo json_encode($totalObject);

?>