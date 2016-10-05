<?php
/*
Template Name: Menu page
*/

get_header(); ?>
<?php
global $wpdb;
$max_price = $wpdb->get_var('SELECT  max(cast(meta_value as unsigned)) FROM wp_postmeta WHERE meta_key="wpcf-price"');

?>
<div id="menu-page">
<div class="row" style="margin: 0">
<button class="navbar-toggle filtr" data-target=".navbar-ex2-collapse" data-toggle="collapse" type="button">
    <span class="sr-only">Toggle navigation</span>
    <span class="fa fa-bars"></span>
    Фільтр
</button>
<div id="filter-col" class="  navbar-collapse navbar-ex2-collapse collapse">
    <form action="" method="get" id="filter-products">
        <div class="col-lg-12">
            <h3>Категорії</h3>
            <ul>
                <?php
                global $wpdb;
                $array = array();
                $price_from = array();
                $price_to = array();
                if (isset($_GET['cat'])) {
                    if ($_GET['cat'] == 'all') { //if all posts
                        $terms = get_terms('product', 'fields=ids');
                        $array = array(
                            'taxonomy' => 'product',
                            'terms' => $terms,
                        );
                    } else {
                        $array = array(
                            'taxonomy' => 'product',
                            'field' => 'id',
                            'terms' => $_GET['cat']
                        );
                    }

                } else {
                    $terms = get_terms('product', 'fields=ids');
                    $array = array(
                        'taxonomy' => 'product',
                        'terms' => $terms,
                    );
                }
                if (isset($_GET['min'])) {
                    $query_price_min = $_GET['min'];
                    $price_from =
                        array(
                            'key' => 'wpcf-price',
                            'value' => $_GET['min'],
                            'compare' => '>=',
                            'type' => 'NUMERIC'
                        );

                } else {
                    $query_price_min = 0;
                    $price_from =
                        array(
                            'key' => 'wpcf-price',
                            'value' => 0,
                            'compare' => '>=',
                            'type' => 'NUMERIC'
                        );
                }
                if (isset($_GET['max'])) {
                    $query_price_max = $_GET['max'];
                    $price_to =
                        array(
                            'key' => 'wpcf-price',
                            'value' => $_GET['max'],
                            'compare' => '<=',
                            'type' => 'NUMERIC'
                        );
                } else {
                    $query_price_max = $max_price;
                    $price_to =
                        array(
                            'key' => 'wpcf-price',
                            'value' => $max_price,
                            'compare' => '<=',
                            'type' => 'NUMERIC'
                        );
                }


                $loop = new WP_Query(array(
                        'post_type' => 'prod',
                        'posts_per_page' => -1,
                        'tax_query' => array(
                            $array

                        ),
                        'meta_query' => array(
                            $price_from,
                            $price_to
                        )
                    )
                );


                $terms = get_terms('product');
                $count = count($terms);
                $total_count = 0;


                if ($count > 0) {
                    foreach ($terms as $term) {


                        $query = ("SELECT COUNT(wp_posts.ID) FROM wp_posts  INNER JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id) INNER JOIN wp_postmeta ON (wp_posts.ID = wp_postmeta.post_id)
INNER JOIN wp_postmeta AS mt1 ON (wp_posts.ID = mt1.post_id) WHERE 1=1  AND ( wp_term_relationships.term_taxonomy_id IN ($term->term_id) ) AND wp_posts.post_type = 'prod' AND (wp_posts.post_status = 'publish') AND ( (wp_postmeta.meta_key = 'wpcf-price' AND CAST(wp_postmeta.meta_value AS SIGNED) >= $query_price_min)
AND  (mt1.meta_key = 'wpcf-price' AND CAST(mt1.meta_value AS SIGNED) <= $query_price_max) )");

                        $count_query = $wpdb->get_var($query);


                        if (isset($_GET['min']) || $_GET['max']) {

                            $site_url = get_site_url();
                            $post = get_post(8);
                            $slug = $post->post_name;

                            $site_url = $site_url . '/' . $slug;
                            $site_url = $site_url . '/?cat=' . $term->term_id . '&min=' . $_GET['min'] . '&max=' . $_GET['max'];
                            if ($_GET['cat'] == $term->term_id) {
                                echo "<li class='active' onclick=" . 'window.location=' . "'" . $site_url . "'" . " id='$term->term_id' ><input type='hidden' value='$term->term_id' name='cat' /> <i class='fa fa-arrow-right'></i>$term->name<span> $count_query</span></li>  ";
                            } else {
                                echo "<li  onclick=" . 'window.location=' . "'" . $site_url . "'" . " id='$term->term_id' > <i class='fa fa-arrow-right'></i>$term->name<span> $count_query</span></li>  ";

                            }
                        } else {
                            $site_url = get_site_url();
                            $post = get_post(8);
                            $slug = $post->post_name;

                            $site_url = $site_url . '/' . $slug;
                            $site_url = $site_url . '/?cat=' . $term->term_id;
                            if ($_GET['cat'] == $term->term_id) {
                                echo "<li class='active'  onclick=" . 'window.location=' . "'" . $site_url . "'" . " id='$term->term_id' ><input type='hidden' value='$term->term_id' name='cat' /> <i class='fa fa-arrow-right'></i>$term->name<span>$count_query</span></li>  ";
                            } else {
                                echo "<li  onclick=" . 'window.location=' . "'" . $site_url . "'" . " id='$term->term_id' > <i class='fa fa-arrow-right'></i>$term->name<span> $count_query</span></li>  ";
                            }

                        }
                        $total_count = $total_count + $count_query;
                    }
                }
                $site_url = get_site_url();
                $post = get_post(8);
                $slug = $post->post_name;

                $site_url = $site_url . '/' . $slug;
                if (isset($_GET['min']) || $_GET['max']) {
                    $site_url = $site_url . '/?cat=all&min=' . $_GET['min'] . '&max=' . $_GET['max'];
                } else {
                    $site_url = $site_url . '/' . $slug;
                    $site_url = $site_url . '/?cat=all';
                }
                if (isset($_GET['cat'])) {
                    if ($_GET['cat'] == 'all') {
                        ?>
                        <li class="active" id='all' onclick='window.location="<? echo $site_url; ?>"'><i
                            class='fa fa-arrow-right'></i>Всі
                            категорії<span><? echo $total_count ?></span></li>
                        <?
                    } else {
                        ?>
                        <li id='all-category' onclick='window.location="<? echo $site_url; ?>"'><i
                            class='fa fa-arrow-right'></i>Всі
                            категорії<span><? echo $total_count ?></span></li>
                        <?
                    }
                }
                ?>

            </ul>

        </div>
        <div class="col-lg-12">
            <h3>Фільтр</h3>

            <div id="slider-range"></div>
            <br>

            <div class="col-lg-6" style="padding: 0">
                <span>Ціна:</span>

                <input type="text" id="amount" value="0" readonly id="filter-range-text">
                <input type="hidden" name="min" value="0">
                <input type="hidden" name="max" value="<? echo $max_price; ?>">
            </div>
            <div class="col-lg-6" style="padding: 0">
                <input type="submit" id="submit-price" value="Фільтр" class="reg-button">
            </div>
        </div>
    </form>
</div>

<div id="content-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div id="products-wrap">
                <ul class="clearfix gallery-photos">
                    <?php


                    if ($loop->have_posts()) :
                        while ($loop->have_posts()) : $loop->the_post();

                            $id = get_the_ID();
                            $term_list = wp_get_post_terms($id, 'product', array("fields" => "names"));
                            $list = '';
                            $price = types_render_field("price", array()) . ' грн';
                            ;
                            foreach ($term_list as $term) {
                                $list .= $term . ', ';
                            }
                            $term = substr($list, 0, -2);
                            ?>
                            <li class="col-md-4 col-sm-4 col-xs-6 view view-first">
                                <div class="border-wrap">
                                    <div class="photo-box"
                                         style="background-image:url(<?php echo types_render_field("my-image", array('output' => 'raw')) ?>)">
                                    </div>
                                    <div class="mask-m">
                                        <div class="wrap-pr-m">
                                            <div class="list-w-i">
                                                <ul>
                                                    <?
                                                    if (isset($_SESSION['product']) && array_key_exists($id, $_SESSION['product']->products)) {
                                                        ?>
                                                        <li><a title="Показати корзину" id="product-<?echo $id ?>"
                                                               class="icon-f in-cart"><i
                                                            class="fa fa-shopping-cart"></i></a></li><?
                                                    } else {
                                                        ?>
                                                        <li><a title="В корзину" id="product-<?echo $id ?>"
                                                               class="icon-f to-cart"><i
                                                            class="fa fa-shopping-cart"></i></a></li><?

                                                    }
                                                    ?>
                                                    <li><a onclick="getCustomPost(<?echo $id ?>)" title="Показати"
                                                           class="icon-t inline"><i class="fa fa-search"></i></a></li>
<!--                                                    <li><a title="Like" href="#" class="icon-g"><i-->
<!--                                                        class="fa fa-heart"></i></a></li>-->
                                                </ul>
                                            </div>
                                            <span class="name-product"><?php  echo get_the_title(); ?></span>
                                        <span class="name-category">
                                            <?php
                                            $term_list = wp_get_post_terms($id, 'product', array("fields" => "names"));
                                            $list = '';
                                            foreach ($term_list as $term) {
                                                $list .= $term . ', ';
                                            }
                                            $term = substr($list, 0, -2);
                                            echo ($term);
                                            ?>
                                        </span>
                                            <span
                                                class="price-product"><? echo types_render_field('price', array()) . ' грн'; ?></span>

                                        </div>
                                    </div>
                            </li>
                            <?
                        endwhile; else :
                        echo  ('<h3 class="text-left">Вибачте, не знайдено товарів. Спробуйте змінити фільтр</h3>');
                    endif;
                    ?>
                </ul>

            </div>
        </div>
    </div>
</div>
</div>
</div>

<script>
    $(function () {
        $("#slider-range").slider({
            range:true,
            min:0,
            max: <? echo($max_price); ?>,
            values:[ <? if (isset($_GET['min'])) echo $_GET['min']; else echo 0?>,  <? if (isset($_GET['max'])) echo $_GET['max']; else echo  $max_price;?> ],
            slide:function (event, ui) {
                $("#amount").val(ui.values[ 0 ] + " грн" + " - " + ui.values[ 1 ] + " грн ");
                $('#filter-col input[name="min"]').val(ui.values[ 0 ]);
                $('#filter-col input[name="max"]').val(ui.values[ 1 ]);

            }
        });

        $("#amount").val($("#slider-range").slider("values", 0) + " грн " +
            " - " + $("#slider-range").slider("values", 1) + " грн ");
    });

    function submitSearchCategory(cat_id) {
        $('#filter-col .active').removeClass('active');
        $('#filter-col #' + cat_id).addClass('active');
        var templateUrl = "<?php bloginfo('template_directory') ?>";
        templateUrl += '/ajax/oreder_by_category.php';
        $.ajax({
            url:templateUrl,
            data:{'cat_id':cat_id},
            type:'POST',
            success:function (data) {
                $('#products-wrap').html('').append(data);
            }
        });

        return false;
    }

    function getProductsByFilter() {
        var price_from = $("#slider-range").slider("values", 0)
        var price_to = $("#slider-range").slider("values", 1)

        var active_cat = $('#filter-col li.active').attr('id');


        var templateUrl = "<?php bloginfo('template_directory') ?>";
        templateUrl += '/ajax/order_by_price.php';
        $.ajax({
            url:templateUrl,
            data:{'price_from':price_from, 'price_to':price_to, 'active_cat':active_cat },
            type:'POST',
            success:function (data) {
                $('#products-wrap').html('').append(data);
            }
        });

        return false;

    }
    $('#submit-price').click(function () {

        $formUser = $('#filter-col form');

        var templateUrl = "<?php bloginfo('template_directory') ?>";
        templateUrl += '/ajax/ajax_filters.php';
        $formUser.on('submit', function (e) {
            // validation code here


            $.ajax({
                type:'GET',
                url:templateUrl,
                data:{ field1:"hello", field2:"hello2"},
                contentType:'application/json; charset=utf-8',

                success:function (data) {

                }
            });
        });

    });


</script>
<?php get_footer(); ?>
