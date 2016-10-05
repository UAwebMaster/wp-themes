<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slavik
 * Date: 28.04.15
 * Time: 15:27
 * To change this template use File | Settings | File Templates.
 */


class AdministrationOrders
{
    public function getOrders($date_start, $date_end){
        $request_date = '';
        if($date_end==''){
            $request_date = 'date = "'.$date_start.'"';
        }else{
            $request_date = 'date BETWEEN "'.$date_start.'"  AND "'.$date_end.'"';
        }

        $query = mysql_query("SELECT wp_orders.id AS invoice_id, date, userId AS user_id, time_from, time_to, order_address_id, order_status, payment_type, payment_status,
delivery_price, address, phone, email, name, login, wp_orders.order_date as order_date
FROM wp_orders
INNER JOIN wp_user_addresses ON wp_orders.order_address_id = wp_user_addresses.id
INNER JOIN wp_users_social ON ( wp_orders.userId = wp_users_social.social_id
OR wp_orders.userId = wp_users_social.id ) WHERE ($request_date) AND (wp_orders.order_status = 1 AND wp_orders.payment_type = 'cash' || wp_orders.payment_type = 'private24' AND wp_orders.payment_status = 1)
 ORDER BY date DESC");


        $rows = array();
        while($r = mysql_fetch_assoc($query)) {

            $rows[] = $r;
        }
        return  json_encode ($rows);

    }


    public function getQuantityInvoiceByID($invoice_id){
        $query = mysql_query("SELECT * FROM wp_goodsfororders WHERE invoice_id = $invoice_id AND status = 1 ");
        $quantity = 0;

        while($r = mysql_fetch_assoc($query)) {
            $quantity += $r['quantity'];
        }
        return $quantity;
    }

    public function getPriceInvoiceByID($invoice_id){

        $query = mysql_query("SELECT * FROM wp_goodsfororders WHERE invoice_id = $invoice_id AND status = 1");
        $price = 0;

        while($r = mysql_fetch_assoc($query)) {
            $itemID = $r['itemId'];
            $quantity = $r['quantity'];

            $query_price = mysql_result(mysql_query("SELECT meta_value FROM wp_postmeta WHERE meta_key = 'wpcf-price' AND post_id = $itemID"), 0);


            $price += (float)$query_price * $quantity;

        }

        return $price;
    }

}