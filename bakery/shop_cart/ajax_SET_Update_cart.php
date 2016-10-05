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

$itemID = $_POST['itemID']; // product ID

$action = $_POST['action'];
if ($action == 'add'){
    $sortArray = [];
    if (isset($_SESSION['product']->sortArray)){
        $sortArray = $_SESSION['product']->sortArray;
        array_push($sortArray, $itemID);
    }else{
        array_push($sortArray, $itemID);
    }


    $price = do_shortcode('[types field="price" id=' . $itemID . ' "]'); // price ID
    $image = do_shortcode('[types field="my-image" id=' . $itemID . ' width="80px" height="auto" "]');
    $title = get_the_title($itemID);

    $products_session = new ArrayObject();
    $total_product = new stdClass();


    if(isset($_SESSION['product'])){
        $products_session = $_SESSION['product']->products;



            $totalItem = $products_session[$itemID]-> itemCount;



            $objectItem = new stdClass();
            $objectItem -> itemID = $itemID;
            $objectItem -> price = $price;
            $objectItem -> image = $image;
            $objectItem -> title = $title;


            $objectItem -> itemCount = $totalItem + 1;


            $products_session[$itemID]=($objectItem);

            $_SESSION['product'] = $products_session;



    }else{
        $objectItem = new stdClass();
        $objectItem -> itemID = $itemID;
        $objectItem -> price = $price;
        $objectItem -> itemCount = 1;
        $objectItem -> image = $image;
        $objectItem -> title = $title;

        $products_session[$itemID]=($objectItem);
        $_SESSION['product'] = $products_session;

    }

    $products_session = $_SESSION['product'];

    $totalItem = 0;
    foreach ($products_session as $product){
        $totalItem = $totalItem + $product-> itemCount;
    }

    $total_product->products = $products_session;
    $total_product->totalItem = $totalItem;
    $total_product->sortArray = array_reverse($sortArray);

    $_SESSION['product'] = $total_product;
    print_r  ( json_encode($_SESSION['product']));
}else if ($action == "getProducts"){

    if (isset($_SESSION['product'])){
        $totalPrice = 0;


        $query =   mysql_query("SELECT price FROM wp_price_delivery where id = 1");
        $data = mysql_fetch_assoc($query);
        $cur_price = $data['price'];

        foreach ($_SESSION['product']->products as $item){
            $totalPrice = $totalPrice + $_SESSION['product']->products[$item->itemID]->itemCount* $_SESSION['product']->products[$item->itemID]->price;
        }

        $_SESSION['product']->totalPrice = $totalPrice;
        $_SESSION['product']->deliveryPrice = $cur_price;
        print_r  ( json_encode($_SESSION['product']));
    }else {
        $_SESSION['product'] = null;
        print_r  ( json_encode($_SESSION['product']));
    }




}else if ($action == 'delete'){

    unset($_SESSION['product']->products[$itemID]);


    $arrayItem = $_SESSION['product']->sortArray;
    if (($key = array_search($itemID, $arrayItem)) !== false) {
        unset($arrayItem[$key]);
    }
    $_SESSION['product']->sortArray = $arrayItem;
}else if($action="clearAll"){
      $_SESSION['product']->products = array();
}





//session_unset($_SESSION['product']);