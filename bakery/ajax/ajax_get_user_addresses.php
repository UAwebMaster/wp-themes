<?php

include("../../../../wp-load.php");



$user_id = $_POST['userID'];
$invoice_id = $_POST['eventID'];
$invoice_cur_address = 0;
if ($invoice_id){
   $query =  mysql_query("SELECT order_address_id FROM wp_orders WHERE id = $invoice_id");
   $result = mysql_fetch_assoc($query);
   $invoice_cur_address =  $result['order_address_id'];
}
$addresses = new stdClass();
$addresses_tmp = new ArrayObject();



if ($user_id){
    $query_addresses =  mysql_query("SELECT id,address FROM wp_user_addresses where user_id = $user_id ORDER BY id DESC");

    if ($query_addresses){
        while ($res_addresses = mysql_fetch_assoc($query_addresses)){
            $rows = new stdClass();
            if ($res_addresses['id'] == $invoice_cur_address){
                $rows->current = 1;
            }else {
                $rows->current = 0;

            }
            $rows->address = $res_addresses['address'];
            $rows->value = $res_addresses['id'];
            $addresses_tmp->append($rows);
        }
       $addresses = $addresses_tmp;
        echo json_encode($addresses);
    }

}


?>