<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slavik
 * Date: 12.03.15
 * Time: 9:54
 * To change this template use File | Settings | File Templates.
 */

class Orders
{
    public $user_session_id; // id loginning user

    public function get_orders_by_id($invoice_id){
        $res_query = mysql_query("SELECT * FROM wp_orders
INNER JOIN wp_goodsfororders ON wp_orders.id = wp_goodsfororders.invoice_id
INNER JOIN wp_user_addresses ON wp_user_addresses.id = wp_orders.order_address_id
WHERE wp_orders.id = $invoice_id AND wp_goodsfororders.status = 1");


        $totalObject = new ArrayObject();

        $date_invoice = '';
        $startTime = '';
        $endTime = '';
        $current_address = '';

        $object_products = new ArrayObject();
        while ($data = mysql_fetch_assoc($res_query)){
            $object = new stdClass();

            $itemID = $data['itemId'];

            $object -> itemID = $data['itemId'];
            $object -> price =  do_shortcode('[types field="price" id=' . $data['itemId'] . ' "]');
            $object -> image =  do_shortcode('[types field="my-image" id=' . $data['itemId'] . ' width="50" height="50" "]');
            $object -> title =  get_the_title($data['itemId']);

            $object -> quantity =   $data['quantity'];

            $date_invoice =   $data['date'];
            $startTime =    $data['time_from'];
            $endTime  =   $data['time_to'];
            $current_address = $data['address'];

            $object_products[$itemID]= $object;
        }
        $totalObject['date'] = $date_invoice ;
        $totalObject['startTime'] = $startTime ;
        $totalObject['endTime'] = $endTime ;
        $totalObject['products'] = $object_products ;
        $totalObject['invoiceID'] = $invoice_id ;
        $totalObject['current_address'] = $current_address ;

        return json_encode($totalObject);
    }


}
