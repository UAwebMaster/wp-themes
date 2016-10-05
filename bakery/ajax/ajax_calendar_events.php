<?php

include("../../../../wp-load.php");

$action = $_POST['action'];

$userID = $_POST['userID'];
$start = $_POST['start'];
$end = $_POST['end'];
$price = $_POST['price'] . ' грн';
$eventID = $_POST['eventID'];


if ($action == 'add-event') {

    $result = mysql_query("INSERT INTO `wp_event_calendar` (id, user_id, start, end, title, status) VALUES ($eventID, $userID, '$start', '$end', '$price', 0 )");


} else if ($action == 'update_client_event') { // update clients event
    $json_update = json_decode(stripslashes($_POST['json_update']));
    foreach ($json_update as $cur_invoice) {
        $result = mysql_query("UPDATE  `wp_event_calendar`  SET  status = 1 WHERE id =  $cur_invoice->id ");
        $result = mysql_query("UPDATE  `wp_orders`  SET  order_status = 1 WHERE id =  $cur_invoice->id ");
    }
} else if ($action == 'get_price') {

    //************get delivery price*********************************

    $query =   mysql_query("SELECT price FROM wp_price_delivery where id = 1");
    $data = mysql_fetch_assoc($query);
    $cur_price = $data['price'];
    $total_cur_price = 0;
    //***********************end get delivery price*********************
    $order_sum_object = new stdClass();
    $order_price_total = 0;
    $order_quantity_total = 0;
    $get_price = json_decode(stripslashes($_POST['json_update']));
    foreach ($get_price as $cur_invoice) {
        $invoiceID = $cur_invoice->id;
        $total_cur_price = $total_cur_price + $cur_price;

        $result = mysql_query("SELECT itemId, quantity FROM wp_goodsfororders WHERE invoice_id = $cur_invoice->id AND status = 1");

        while($data = mysql_fetch_assoc($result)){
            $itemID = $data['itemId'];
            $quantity = $data['quantity'];

            $tmp_price =  do_shortcode('[types field="price" id=' . $itemID . ' "]');
            $order_price_total = $order_price_total +  $tmp_price * $quantity;
            $order_quantity_total = $order_quantity_total + $quantity;
        }

    }


    $order_sum_object->totalPrice = $order_price_total;
    $order_sum_object->totalQuantity = $order_quantity_total;
    $order_sum_object->delivery_price = $total_cur_price;
    echo json_encode($order_sum_object);

} else if ($action == 'deleteEvent'){
    global $wpdb;
    $invoice_delID = $_POST['delete-event'];

    mysql_query("DELETE FROM wp_event_calendar WHERE id = $invoice_delID ");
    mysql_query("DELETE FROM wp_orders WHERE id = $invoice_delID ");
    mysql_query("DELETE FROM wp_goodsfororders WHERE invoice_id = $invoice_delID ");


}else {
    $rs = mysql_query("SELECT * FROM wp_event_calendar WHERE user_id = $userID AND status = 1 ORDER BY start ASC");
    $arr = array();

    while ($obj = mysql_fetch_object($rs)) {
        $arr[] = $obj;
    }

    echo json_encode($arr);
}



?>