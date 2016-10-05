<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slavik
 * Date: 25.09.15
 * Time: 11:44
 * To change this template use File | Settings | File Templates.
 */
include("../../../../wp-load.php");

if ($_REQUEST['payment']){
    $state = $_REQUEST['payment']->state;
    parse_str($_REQUEST['payment'], $get_array);
    $orderID =  $get_array['order'];


    if ($state == 'ok' ||  $state = 'test'){
        $query = mysql_query("UPDATE wp_orders SET order_status = 1, payment_status = 1 WHERE id IN ($orderID)");
        $query_calendar = mysql_query("UPDATE wp_event_calendar SET status = 1 WHERE id IN ($orderID)");
    }
}
