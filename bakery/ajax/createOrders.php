<?

include("../../../../wp-load.php");

$action = $_POST['action'];

$userID = $_POST['userID'];

$startTime = $_POST['startTime']; // get Time
$endTime = $_POST['endTime']; // get Time
$date = $_POST['date']; // get date
$phone = $_POST['phone'];

require_once(ABSPATH . 'wp-content/themes/twentythirteen/PHPMailer-master/class.phpmailer.php');

mysql_query("UPDATE wp_users_social SET phone = '$phone' WHERE id= $userID or social_id = '$userID'");


if ($action == 'multiple-orders') { // if multiple orders

    $address_order = $_POST['address-order'];
    $orders = json_decode(stripslashes($_POST['cheked_inputs']));

    $action_with_address = $_POST['action_with_address'];

    $address_id = 0;
    $invoice_id = 0;

    $query =   mysql_query("SELECT price FROM wp_price_delivery where id = 1");
    $data = mysql_fetch_assoc($query);
    $delivery_price = $data['price'];

    if ($action_with_address == 'add-new-address') { // if add new address
        // add addresses to order//******************************
        mysql_query("INSERT INTO wp_user_addresses (user_id, address) VALUES ($userID, '$address_order')");
        $address_id = mysql_insert_id();
        $result = mysql_query("INSERT INTO `wp_orders` (userId, date, time_from, time_to, order_address_id, delivery_price) VALUES ($userID, '$date', '$startTime', '$endTime', $address_id, $delivery_price  ) ");
        $invoice_id = mysql_insert_id();

        //********end addresses**********************************
    } else { // if address exist
        $result = mysql_query("INSERT INTO `wp_orders` (userId, date, time_from, time_to, order_address_id, delivery_price) VALUES ($userID, '$date', '$startTime', '$endTime', $address_order,$delivery_price  ) ");
        $invoice_id = mysql_insert_id();
    }

    $invoice_price = 0;
    if ($invoice_id) {
        foreach ($orders as $single_order) {


            if ($single_order->active == 1) {
                $query_price = mysql_result(mysql_query("SELECT meta_value FROM wp_postmeta WHERE meta_key = 'wpcf-price' AND post_id = $single_order->itemID"), 0);
                $invoice_price = $invoice_price + $query_price * $single_order->count;
                $result_tmp = mysql_query("INSERT INTO `wp_goodsfororders` (itemId, quantity, invoice_id, status) VALUES ($single_order->itemID, $single_order->count,$invoice_id, 1  ) ");

            } else {
                $result_tmp = mysql_query("INSERT INTO `wp_goodsfororders` (itemId, quantity, invoice_id, status) VALUES ($single_order->itemID, $single_order->count,$invoice_id, 0  ) ");

            }


        }
    }
    $object = new stdClass();
    $object->totalPrice = $invoice_price;
    $object->invoiceID = $invoice_id;

    echo json_encode($object);


}else if($action == 'multiple-orders-payment'){
    $orders =  $orders_edit = json_decode(stripslashes($_POST['json_data']));
    $payment_type = $_POST['type_payment'];

    $objectArray = new ArrayObject();

    $total_price = 0;

    $query =   mysql_query("SELECT price FROM wp_price_delivery where id = 1");
    $data = mysql_fetch_assoc($query);
    $delivery_price = $data['price'];

    $invoice_multiple_line_id = '';

    foreach ($orders as $order_id){
        sentMail($order_id->id,$delivery_price,$userID);


        $invoice_multiple_line_id .= $order_id->id.',';
        $query = mysql_query("SELECT itemId, quantity FROM wp_goodsfororders WHERE invoice_id = $order_id->id and status = 1");
        while ($data_query  = mysql_fetch_assoc($query)){
            $itemID = $data_query['itemId'];
            $quantity = $data_query['quantity'];
            $query_price = mysql_result(mysql_query("SELECT meta_value FROM wp_postmeta WHERE meta_key = 'wpcf-price' AND post_id = $itemID"), 0);

            $total_price = $total_price + $query_price*$quantity;
        }
        $total_price = $total_price + $delivery_price;
    }

    $invoice_multiple_line_id =  rtrim($invoice_multiple_line_id, ",");

    if ($payment_type == 'private24'){

        $query =   mysql_query("SELECT price FROM wp_price_delivery where id = 1");
        $data = mysql_fetch_assoc($query);
        $delivery_price = $data['price'];


        $object_private24 = new stdClass();

        $amt = $total_price;
        $pass = 'IDQu5J2n7u08Ga85s1r6qkB47Wk518eq';
        $details = 'Замовлення №'.$invoice_multiple_line_id;
        $ext_details = 'IN'.$invoice_multiple_line_id;
        $payment = "amt=$amt&ccy=UAH&details=$details&ext_details=$ext_details&pay_way=privat24&order=$invoice_multiple_line_id&merchant=112022";
        $signature = sha1(md5($payment.$pass));

        $object_private24 -> amt = $amt;
        $object_private24 -> ccy = 'UAH';
        $object_private24 -> merchant = 112022;
        $object_private24 -> order = $invoice_multiple_line_id;
        $object_private24 -> details = $details ;
        $object_private24 -> ext_details = $ext_details;
        $object_private24 -> pay_way = 'privat24';
        $object_private24 -> return_url = get_site_url().'/checkout';
        $object_private24 -> signature = $signature;
        $object_private24 -> payment = $payment;
        $object_private24 -> server_url = get_template_directory_uri().'/ajax/private_return.php';

        $objectArray['private24'] = $object_private24;
        $objectArray['type_payment'] = 'private24';
        $objectArray['order'] = $invoice_multiple_line_id;

        $query= mysql_query("UPDATE wp_orders SET payment_type = '$payment_type' WHERE id IN ($invoice_multiple_line_id)");

    }else{
        $query_calendar = mysql_query("UPDATE wp_event_calendar SET status = 1 WHERE id IN ($invoice_multiple_line_id)");
        $query= mysql_query("UPDATE wp_orders SET payment_type = '$payment_type', order_status = 1 WHERE id IN ($invoice_multiple_line_id)");



        $objectArray['type_payment'] = 'cash';
        $objectArray['order'] = $invoice_multiple_line_id;
    }



    echo json_encode($objectArray);



} else if ($action == 'edit-invoice') {
    $invoice_id_edit = $_POST['invoiceID'];
    $total_price_edit = 0;
    $orders_edit = json_decode(stripslashes($_POST['cheked_inputs_edit']));




    foreach ($orders_edit as $product) {

        if ($product->active == 1) {
            mysql_query("INSERT INTO wp_goodsfororders (itemId,quantity,invoice_id, status)
                 VALUES ($product->itemID, $product->count, $invoice_id_edit, 1)
             ON DUPLICATE KEY UPDATE quantity = $product->count, status = 1    ");
            $itemID_tmp = $product->itemID;
            $price = do_shortcode('[types field="price" id=' . $itemID_tmp . ' "]');
            $total_price_edit = $total_price_edit + $product->count * $price;
        } else {
            mysql_query("INSERT INTO wp_goodsfororders (itemId,quantity,invoice_id, status)
                 VALUES ($product->itemID, $product->count, $invoice_id_edit, 0)
             ON DUPLICATE KEY UPDATE quantity = $product->count, status = 0   ");
        }


    }

    $date_update = current_time( 'mysql' );

    $address_order = $_POST['address_order'];
    $action_with_address = $_POST['action_with_address'];
    $total_price_edit = $total_price_edit . ' грн';
    mysql_query("UPDATE wp_event_calendar SET title = '$total_price_edit'  WHERE id = $invoice_id_edit");
    if ($action_with_address == 'add-new-address') {
        mysql_query("INSERT INTO wp_user_addresses (user_id, address) VALUES ($userID, '$address_order')");
        $address_id = mysql_insert_id();
        mysql_query("UPDATE wp_orders SET time_from = '$startTime' ,time_to = '$endTime', order_address_id = $address_id, order_date = '$date_update' WHERE id = $invoice_id_edit");

    } else {
        mysql_query("UPDATE wp_orders SET time_from = '$startTime' ,time_to = '$endTime', order_address_id = $address_order,  order_date = '$date_update'  WHERE id = $invoice_id_edit");
    }

    $object_tmp_edit = new stdClass();
    $object_tmp_edit->totalPrice = $total_price_edit;
    $object_tmp_edit->invoiceID = $invoice_id_edit;
    echo json_encode($object_tmp_edit);

} else { // if single order

    $type_payment = $_POST['type_payment'];
    $action_with_address = $_POST['action_with_address'];

    $address_order = $_POST['address-order'];

    $address_id = 0;
    $invoice_id = 0;
    $invoice_price = 0;

    $orders = json_decode(stripslashes($_POST['cheked_inputs']));

    $query =   mysql_query("SELECT price FROM wp_price_delivery where id = 1");
    $data = mysql_fetch_assoc($query);
    $delivery_price = $data['price'];

    $order_status = 0;
    if ($type_payment == 'cash'){
        $order_status = 1;
    }


    if ($action_with_address == 'add-new-address') { // if add new address
        // add addresses to order//******************************
        mysql_query("INSERT INTO wp_user_addresses (user_id, address) VALUES ($userID, '$address_order')");
        $address_id = mysql_insert_id();

        $result = mysql_query("INSERT INTO `wp_orders` (userId, date, time_from, time_to, order_address_id, payment_type, order_status, delivery_price) VALUES ($userID, '$date', '$startTime', '$endTime', $address_id, '$type_payment', $order_status, $delivery_price) ");
        $invoice_id = mysql_insert_id();

        //********end addresses**********************************
    } else { // if address exist
        $result = mysql_query("INSERT INTO `wp_orders` (userId, date, time_from, time_to, order_address_id, payment_type, order_status, delivery_price) VALUES ($userID, '$date', '$startTime', '$endTime', $address_order, '$type_payment', $order_status, $delivery_price ) ");
        $invoice_id = mysql_insert_id();
    }

    if ($invoice_id) {
        foreach ($orders->products as $single_order) {

            $query_price = mysql_result(mysql_query("SELECT meta_value FROM wp_postmeta WHERE meta_key = 'wpcf-price' AND post_id = $single_order->itemID"), 0);
            $invoice_price = $invoice_price + $query_price * $single_order->itemCount;
            $result_tmp = mysql_query("INSERT INTO `wp_goodsfororders` (itemId, quantity, invoice_id, status) VALUES ($single_order->itemID, $single_order->itemCount,$invoice_id, 1  ) ");

        }
    }

    sentMail($invoice_id,$delivery_price,$userID);



    $objectArray = new ArrayObject();

    if ($type_payment == 'private24'){

        $query =   mysql_query("SELECT price FROM wp_price_delivery where id = 1");
        $data = mysql_fetch_assoc($query);
        $delivery_price = $data['price'];


        $object_private24 = new stdClass();

        $amt = $invoice_price + $delivery_price;
        $pass = 'IDQu5J2n7u08Ga85s1r6qkB47Wk518eq';
        $details = 'Замовлення №'.$invoice_id;
        $ext_details = 'IN'.$invoice_id;
        $payment = "amt=$amt&ccy=UAH&details=$details&ext_details=$ext_details&pay_way=privat24&order=$invoice_id&merchant=112022";
        $signature = sha1(md5($payment.$pass));

        $object_private24 -> amt = $amt;
        $object_private24 -> ccy = 'UAH';
        $object_private24 -> merchant = 112022;
        $object_private24 -> order = $invoice_id;
        $object_private24 -> details = $details ;
        $object_private24 -> ext_details = $ext_details;
        $object_private24 -> pay_way = 'privat24';
        $object_private24 -> return_url = get_site_url().'/checkout';
        $object_private24 -> signature = $signature;
        $object_private24 -> payment = $payment;
        $object_private24 -> server_url = get_template_directory_uri().'/ajax/private_return.php';
        $objectArray['private24'] = $object_private24;
        $objectArray['type_payment'] = 'private24';
        $objectArray['order'] = $invoice_id;

    }else{
        $objectArray['type_payment'] = 'cash';
        $objectArray['order'] = $invoice_id;
    }
    echo json_encode($objectArray);



}




function sentMail($invoice_id,$delivery_price,$userID)
{



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
    $products = '<table style="border-spacing:0;padding-top:10px; ; max-width: 620px" width="100%"><thead><tr><th style="width: 10%"></th><th style="width: 40%">Назва</th><th style="width: 10%">Ціна</th><th style="width: 10%">К-ть</th><th style="width: 10%">Сума</th></tr></thead><tbody>';
    $total_price = $delivery_price;


    $email = new PHPMailer();
    $email->CharSet = "UTF-8";
    $email->IsHTML(true);
    $email->From = 'morning-bakery.com.ua';
    $email->FromName = 'morning-bakery.com.ua';
$payment_type = '';
    while ($data = mysql_fetch_assoc($res_query)){
        $total = $data['quantity']*do_shortcode('[types field="price" id=' . $data['itemId'] . ' "]');
        $image = do_shortcode('[types field="my-image"   id=' . $data['itemId'] . ' width="50" height="50" "]');
        $products .= '<tr>
        <td style="text-align:center"> </td>
        <td>'.get_the_title($data['itemId']).'</td>
        <td style="text-align:center">'. do_shortcode('[types field="price" id=' . $data['itemId'] . ' "]').' грн</td>
        <td style="text-align:center">'.$data['quantity'].'</td>
        <td style="text-align:center">'.$total.' грн.</td>
        </tr>';
        $object = new stdClass();

        $itemID = $data['itemId'];

        $object -> itemID = $data['itemId'];

        $date_invoice =   $data['date'];
        $startTime =    $data['time_from'];
        $endTime  =   $data['time_to'];
        $current_address = $data['address'];

        $object_products[$itemID]= $object;
        $total_price = $total_price +$total;
        $payment_type = $data['payment_type'];
    }
    if($payment_type == 'cash'){
        $payment_type = 'готівкою при отриманні';
    }else if ($payment_type = 'private24'){
        $payment_type = 'оплата здійснена з допомогою Приват24';
    }
    $row = '<h4>Замовлення №'.$invoice_id.'</h4>';
    $row .='<div><span>Дата:</span><b>'.$date_invoice.'</b></div>';
    $row .='<div><span>Час:</span><b>'.$startTime.'-'.$endTime.'</b></div>';
    $row .='<div><span>Адреса:</span><b>'.$current_address.'</b></div>';

    $products .= '</tbody></table><div>Всього:<b>'.$total_price.' грн.</b></div>';

    $phone_login = mysql_query("SELECT login,phone,name FROM wp_users_social WHERE id = $userID OR social_id = '$userID'");
    $data_phone = mysql_fetch_assoc($phone_login);
    $phone_number = $data_phone['phone'];
    $login = $data_phone['login'];
    $name = $data_phone['name'];
    $user_name = $login;
    if ($name !=''){
        $user_name = $name;
    }

    $row .='<div>Користувач: <b>'.$user_name.'</b></div>';
    $row .='<div>Телефон: <b>'.$phone_number.'</b></div>';
    $row .='<div>Оплата: <b>'.$payment_type.'</b></div>';
//


$email->Subject = 'Замовлення №'.$invoice_id.'';
    $email->Body =  $row.$products;

    $email->AddAddress('morningbakery1@gmail.com');
    $email->AddAddress('aniutka91@mail.ru');
    $email->Send();



}


?>