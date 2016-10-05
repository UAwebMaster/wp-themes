<?php
/*
Template Name: news page
*/


include("../../../../wp-load.php");


?><?

$post_id = $_POST[id];


global $post;

$post = get_post($post_id);

$term_list = wp_get_post_terms($post_id, 'product', array("fields" => "names"));
$list = '';
foreach ($term_list as $term) {
    $list .= $term . ', ';
}
$term = substr($list, 0, -2);


wp_reset_postdata();

echo '<div id="plus-g" class="wrap-prod-ajax"> ' .
    '<div class="aj-pr-n"><span>' . types_render_field("price", array()) . ' грн</span></div>' .
    '<span class="aj-pr-title">' . get_the_title($post_id) . '</span>' .
    '<span class="aj-cat-name">' . $term . '</span>' .
    '<div class="w-l-b-a"></div>' .
    '<p class="wr-des-b">' . types_render_field("product-description", array()) . '</p>' .
    '<div class="w-img-aj">' . types_render_field("my-image", array("size" => "medium",)) . '</div>' .
    '<div class="soc-wr-i"><div class="icon-soc-p"><a title="facebook" onclick="share()"><i class="fa fa-facebook"></i></a></div>' .
    '<div class="icon-soc-p"><a title="VK" onclick="Share.vkontakte()" class="social_share" data-type="vk"><i class="fa fa-vk"></i></a></div>' .
    '<div class="icon-soc-p"><a title="twitter" onclick="Share.twitter()" class="social_share"  ><i class="fa fa-twitter"></i></a></div></div>' .
    /* '<div onclick="shareGoogle()" id ="sharePost">Share</div>'.*/
    ' </div>';

$array_list = $_SESSION['product']->sortArray;
//if ($array_list){
//    if (in_array($post_id, $array_list)){
//        echo '<input class="addToCartBut add-cart-ajax" id="cart-product-'.$post_id.'" value="В корзині" type="button" onclick="ifInCartSet()" />';
//    }else {
//        echo '<input class="addToCartBut show-cart-ajax" id="cart-product-'.$post_id.'" value="Купити"  onclick="ifInCartSet()"   type="button" />';
//    }
//}else {
//    echo '<input class="addToCartBut add-cart-ajax" id="cart-product-'.$post_id.'" value="Купити" onclick="ifInCartSet()" type="button"> ';
//}

//if ($itemIdArray !='false'){
//    if (in_array($post_id, $itemIdArray)) {
//
//    }else{
//        echo '<input id="addToCartBut" value="Купити" type="button" onclick="setItemShop(' . $post_id . ')"/>';
//    }
//}else {
//
//}

?>

