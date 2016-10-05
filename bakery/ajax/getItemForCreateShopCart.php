<?php
/*
Template Name: news page
*/


include("../../../../wp-load.php");

?><?
$arrayOfInputQuantity = array();
$post_id_array = array();
$post_id_array = $_POST[id_array];
$arrayOfInputQuantity = $_POST[arrayOfInputQuantity];
$requestFromCart = $_POST[requestFromCart];
if ($requestFromCart != true) {
    $deleteFromCart = 0;
    echo '<div id="shopHead">';
} else {
    $deleteFromCart = 1;
}

if ($requestFromCart != true) {
    if ($post_id_array[0] == '' || $post_id_array == 'false') {
        echo '<h1 class="empty-cart">Корзина пуста</h3>';
        die();
    } else {

        foreach ($post_id_array as $code => $post_id) {
            if ($post_id) {
                echo '<div class="wr-tov" id="wr-tov' . $post_id . '"><table><tbody><tr><td>' . (do_shortcode('[types field="my-image" id=' . $post_id . ' size="thumbnail" "]')) . '</table></tbody></tr></td>';
                echo '<div class="el-wr-k"><div class="tit-w-s-c"><p>' . get_the_title($post_id) . '</p></div>';

                    $price = do_shortcode('[types field="price" id=' . $post_id . ' "]');
                    $price = $price * $arrayOfInputQuantity[$code];
                    echo '<div class="price-w-s-c">' . (do_shortcode('[types field="price" id=' . $post_id . ' "]')) . ' грн</div><div class="cart-amount"><input id=' . $post_id . ' min="1" name="quantity" value="' . $arrayOfInputQuantity[$code] . '"/><div class="wrap-am-p-m">';
                    echo '<div class="plus-num" ><a onclick="setAmountItem(0, ' . $post_id . ')"><i class="fa fa-caret-up"></i></a></div><div class="minus-num"><a  onclick="setAmountItem(1,' . $post_id . ')"><i class="fa fa-caret-down"></i></a></div>';
                    echo '</div><div class="sum-am-tot">' . $price . ' грн</div></div></div><span class="del-tov"><a href="#"  onclick="deleteItemShopCart(' . $post_id . ')"><i class="fa fa-times"></i></a></span></div>';

            }
        }
        echo '<div class="w-l-b-a"></div>';
        echo '<div id="total-price">Всього: <span></span></div><span class="loading-price"><img src="/wp-content/themes/twentythirteen/images/loader2.gif"></span>';
        ?>
    <form action="/checkout" method="post">
        <button class="makeOrder" type="submit">Оформити замовлення</button>
    </form>
    <div class="continueShop"><a href="javascript:;" onclick="continueShop()" title="Продовжити покупки">Продовжити
        покупки</a></div>
    </div>
    <?

    }
} else {
    if ($post_id_array[0] == '' || $post_id_array == 'false') {
        echo '<h1 class="empty-cart">Корзина пуста</h1>';
        die();
    } else {
        foreach ($post_id_array as $code => $post_id) {
            if ($post_id) {
                echo '<div class="wr-tov"><table><tbody><tr><td>' . (do_shortcode('[types field="my-image" id=' . $post_id . ' size="thumbnail" "]')) . '</table></tbody></tr></td>';
                echo '<div class="el-wr-k"><div class="tit-w-s-c"><p>' . get_the_title($post_id) . '</p></div>';

                    $price = do_shortcode('[types field="price" id=' . $post_id . ' "]');
                    $price = $price * $arrayOfInputQuantity[$code];
                    echo '<div class="price-w-s-c">' . (do_shortcode('[types field="price" id=' . $post_id . ' "]')) . ' грн</div><div class="cart-amount">
                <input id=' . $post_id . ' min="1" name="quantity" value="' . $arrayOfInputQuantity[$code] . '"/>
                <div class="wrap-am-p-m">';


                    echo '<div class="plus-num" ><a onclick="setAmountItemCustom(0, this)"><i class="fa fa-caret-up"></i></a></div>
                    <div class="minus-num"><a  onclick="setAmountItemCustom(1,this)"><i class="fa fa-caret-down"></i></a></div>';

                    echo '</div>
                <div class="sum-am-tot">' . $price . ' грн</div>
                </div></div><span class="del-tov"><a href="#0"  onclick="deleteItemShopCart(' . $post_id . ')"><i class="fa fa-times"></i></a></span></div>';

//                } else {
//                    echo '<div class="price-w-s-c">' . (do_shortcode('[types field="price" id=' . $post_id . ' "]')) . ' грн</div><div class="cart-amount">
//                <input id=' . $post_id . ' min="1" name="quantity" value="1"/>
//                <div class="wrap-am-p-m">
//                <div class="plus-num" ><a onclick="setAmountItem(0, ' . $post_id . ')"><i class="fa fa-caret-up"></i></a></div>
//                <div class="minus-num"><a  onclick="setAmountItem(1,' . $post_id . ')"><i class="fa fa-caret-down"></i></a></div>
//                </div>
//                <div class="sum-am-tot">' . (do_shortcode('[types field="price" id=' . $post_id . ' "]')) . ' грн</div>
//                </div></div><span class="del-tov"><a href="#0" onclick="deleteItemShopCart(' . $post_id . ',' . $deleteFromCart . ')"><i class="fa fa-times"></i></a></span></div>';
//                }
            }
        }

        echo '<div id="datepair">
                <span><i class="fa fa-calendar"></i><input type="text" class="date start" /></span>
                <span><p>Від</p><i class="fa fa-clock-o"></i><input type="text" class="time start" />  </span>
                <span><p>До</p><i class="fa fa-clock-o"></i><input type="text" class="time end" /></span>

            </div>';
        echo '<div id="total-price">Всього: <span></span></div><span class="loading-price"><img src="/wp-content/themes/twentythirteen/images/loader2.gif"></span>';
        echo '<div style="text-align: center; clear: both;">
                    <button class="addOrder" type="button" onclick="createNewOrderCart()">Оформити замовлення</button>
                    <button class="addOrder" type="button" onclick="createWeeklyOrder()">Сформувати замовлення на
                        тиждень
                    </button>
                </div>';

    }
}


?>


