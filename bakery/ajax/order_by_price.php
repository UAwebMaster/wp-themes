<?php
/*
Template Name: news page
*/
include("../../../../wp-load.php");




$price_from = $_POST['price_from'];
$price_to = $_POST['price_to'];
$active_cat = $_POST['active_cat'];

if ($active_cat != ''){
    if ($active_cat == 'all'){
        $loop = new WP_Query( array(
                'post_type'         => 'prod',
                'meta_query' => array(
                    array(
                        'key' => 'wpcf-price',
                        'value' => $price_from,
                        'compare' => '>=',
                        'type' => 'NUMERIC'
                    ),
                    array(
                        'key' => 'wpcf-price',
                        'value' => $price_to,
                        'compare' => '<=',
                        'type' => 'NUMERIC'
                    )
                )

            )
        );
    }else {
        $loop = new WP_Query( array(
                'post_type'         => 'prod',
                'tax_query'     => array(
                    array(
                        'taxonomy'  => 'product',
                        'field'     => 'id',
                        'terms'     => $active_cat
                    )
                ),
                'meta_query' => array(
                    array(
                        'key' => 'wpcf-price',
                        'value' => $price_from,
                        'compare' => '>=',
                        'type' => 'NUMERIC'
                    ),
                    array(
                        'key' => 'wpcf-price',
                        'value' => $price_to,
                        'compare' => '<=',
                        'type' => 'NUMERIC'
                    )
                )

            )
        );
    }

}else{
    $loop = new WP_Query( array(
            'post_type'         => 'prod',

            'meta_query' => array(
                array(
                    'key' => 'wpcf-price',
                    'value' => $price_from,
                    'compare' => '>=',
                    'type' => 'NUMERIC'
                ),
                array(
                    'key' => 'wpcf-price',
                    'value' => $price_to,
                    'compare' => '<=',
                    'type' => 'NUMERIC'
                )
            )

        )
    );
}

echo '<ul class="clearfix gallery-photos">';
  if ($loop->have_posts()) :
 while ( $loop->have_posts() ) : $loop->the_post();   $id = get_the_ID();
     $term_list = wp_get_post_terms($id, 'product', array("fields" => "names"));
     $list = '';
     $price =  types_render_field( "price", array() ).' грн'; ;
     foreach($term_list as $term){
         $list .= $term.', ';
     }
     $term = substr($list, 0, -2);
     echo '
                                <li class="col-md-4 col-sm-4 col-xs-6 view view-first">
                                    <div class="border-wrap">
                                        <div class="photo-box" style="background-image:url(' . types_render_field("my-image", array('output' => 'raw')) . ')" >
                                        </div>
                                        <div class="mask-m">
                                            <div class="wrap-pr-m">
                                                <div class="list-w-i">
                                                    <ul>
                                                        <li><a title="В корзину"  onclick="setItemShop(' . $id . ')" class="icon-f"><i class="fa fa-shopping-cart"></i></a></li>
                                                        <li><a onclick="getCustomPost(' . $id . ' )" title="Показати" href="#data-about-product"  class="icon-t inline"><i class="fa fa-search"></i></a></li>
                                                        <li><a title="Like" href="#" class="icon-g"><i class="fa fa-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                                <span class="name-product">'.get_the_title().'</span>
                                                <span class="name-category">'.$term.'</span>
                                                <span class="price-product">'.$price.'</span>
                                            </div>
                                     </div>

                                    </div>
                                </li>
                                ';
 endwhile;
else : echo '<h3 style="text-align: left">Не знайдено жодного товару. Спробуйте змінити фільтр</h3>';
  endif;
echo '</ul>';
?>
