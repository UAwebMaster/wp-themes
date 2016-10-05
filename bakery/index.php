<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>
<?php echo do_shortcode("[epsshortcode id=29 ]"); ?>


<!-- #Display top products list -->
<div class="cont-c-p-r-pr">
    <div class='category-products-row'>

        <h3 style="margin-bottom: 0" class='name-category-products'>Круасани та хліб з доставкою до Вашого дому</h3>



        <ul class="clearfix gallery-photos">
            <?php $loop = new WP_Query(array(
                'post_type' => 'prod',
                'posts_per_page' => '8',
//                        'orderby'	    => 'meta_value_num', Для сортування по ціні
                'orderby' => 'rand',
                'order' => 'ASC',
                'meta_key' => 'wpcf-price',
            )
        );
            ?>
            <?php while ($loop->have_posts()) : $loop->the_post();
            $id = get_the_ID(); ?>
            <li class="col-lg-3 col-md-4 col-xs-6 view view-first">
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
                                               class="icon-f in-cart"><i class="fa fa-shopping-cart"></i></a></li><?
                                    } else {
                                        ?>
                                        <li><a title="В корзину" id="product-<?echo $id ?>" class="icon-f to-cart"><i
                                            class="fa fa-shopping-cart"></i></a></li><?

                                    }
                                    ?>
                                    <li><a onclick="getCustomPost(<?echo $id ?>)" title="Показати"
                                           class="icon-t inline"><i class="fa fa-search"></i></a></li>
<!--                                    <li><a title="Like" href="#" class="icon-g"><i class="fa fa-heart"></i></a></li>-->
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
                            <span class="price-product"><? echo types_render_field('price', array()) . ' грн'; ?></span>

                        </div>
                    </div>
            </li>


            <?php endwhile; ?>
        </ul>
    </div>
</div>

<!-- #Display category list -->
<div class="cont-c-p-r">
<!--    <div class='category-products-row'>-->
<!---->
<!--        <h3 style="margin-bottom: 0" class='name-category-products'>Основні категорії продуктів</h3>-->
<!---->
<!--        <p class='description-category-products'>Наші послуги є кращими в місті, ми пропонуємо відмінну якість-->
<!--            хлібобулочних виробів</p>-->
<!---->
<!--        <div class="c-3-r">-->
<!--            <div class="row">-->
<!--                <div class="clearfix">-->
<!--                    --><?//
//                        $args = array(
//                            'orderby' => 'count',
//                            'order' => 'ASC',
//                            'number' => '4',
//                    );
//
//                    $terms = get_terms("product", $args);
//                    $count = count($terms);
//                    if ($count > 0) {
//                        foreach ($terms as $term) {
//                            ?>
<!--                <div class="col-lg-3">-->
<!--                    <div class="img-i-c-p"><img src="--><?php //echo z_taxonomy_image_url($term->term_id); ?><!--"/></div>--><?//
//                            echo "<h3 class='name-category-products'>$term->name</h3><span class='line-bottom-h'></span>";
//                            echo "<p class='description-category-products'>$term->description</p></div>";
//                        }
//                        echo "</div>";
//                    }
//                    ?>
<!--                </div>-->
<!--            </div>-->
<!---->
<!---->
<!--        </div>-->
<!--        </div>-->
<!--        <!-- #content -->
<!--    </div>-->
    <!-- </div>-->
<!-- #primary -->
<!--<div id="wrap-adver">-->
<!--    <h1>DIFFERENT TYPES OF BREAD PRODUCTS</h1>-->
<!---->
<!--    <h2>You will find them only the best products in our stores</h2>-->
<!--</div>-->
<!-- #Members list -->
<!--<div id="team-members">-->
<!--    <div class='category-products-row'>-->
<!--        <h3 style="margin-bottom: 0" class='name-category-products'>Наші працівники</h3>-->
<!---->
<!--        <p class="description-category-products">У нашій команді працюють найкращі люди</p>-->
<!---->
<!--        <div class="row">-->
<!--            <div class="col-md-3">-->
<!--                <div class="wrap-b-b-i view view-first">-->
<!--                    <div class="img-i-c-p"><img src="/wp-content/themes/twentythirteen/images/chef1.jpg"-->
<!--                                                alt="Наша команда"/>-->
<!---->
<!--                        <div class="mask">-->
<!--                            <div class="social-w-i">-->
<!--                                <ul>-->
<!--                                    <li><a title="facebook" href="#" class="icon-f">f</a></li>-->
<!--                                    <li><a title="twitter" href="#" class="icon-t">t</a></li>-->
<!--                                    <li><a title="google+" href="#" class="icon-g">g</a></li>-->
<!--                                </ul>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <h3 class='name-category-products'>Ch. MORGAN DUTCH</h3>-->
<!--                </div>-->
<!--                <p class='description-category-products'>Whether the flitting attendance of the one still and-->
<!--                    solitary jet had gradually worked upon Ahab.</p>-->
<!--            </div>-->
<!---->
<!--            <div class="col-md-3">-->
<!--                <div class="wrap-b-b-i view view-first">-->
<!--                    <div class="img-i-c-p"><img src="/wp-content/themes/twentythirteen/images/chef2.jpg"-->
<!--                                                alt="Наша команда"/>-->
<!--                        <div class="mask">-->
<!--                            <div class="social-w-i">-->
<!--                                <ul>-->
<!--                                    <li><a title="facebook" href="#" class="icon-f">f</a></li>-->
<!--                                    <li><a title="twitter" href="#" class="icon-t">t</a></li>-->
<!--                                    <li><a title="google+" href="#" class="icon-g">g</a></li>-->
<!--                                </ul>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <h3 class='name-category-products'>Ass. MIKKIE RURK</h3>-->
<!--                </div>-->
<!--                <p class='description-category-products'>Whether the flitting attendance of the one still and-->
<!--                    solitary jet had gradually worked upon Ahab.</p>-->
<!--            </div>-->
<!---->
<!--            <div class="col-md-3">-->
<!--                <div class="wrap-b-b-i view view-first">-->
<!--                    <div class="img-i-c-p"><img src="/wp-content/themes/twentythirteen/images/chef1.jpg"-->
<!--                                                alt="Наша команда"/>-->
<!---->
<!--                        <div class="mask">-->
<!--                            <div class="social-w-i">-->
<!--                                <ul>-->
<!--                                    <li><a title="facebook" href="#" class="icon-f">f</a></li>-->
<!--                                    <li><a title="twitter" href="#" class="icon-t">t</a></li>-->
<!--                                    <li><a title="google+" href="#" class="icon-g">g</a></li>-->
<!--                                </ul>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <h3 class='name-category-products'>BRANDON RAZER</h3>-->
<!--                </div>-->
<!--                <p class='description-category-products'>Whether the flitting attendance of the one still and-->
<!--                    solitary jet had gradually worked upon Ahab.</p>-->
<!--            </div>-->
<!---->
<!--            <div class="col-md-3">-->
<!--                <div class="wrap-b-b-i view view-first">-->
<!--                    <div class="img-i-c-p"><img src="/wp-content/themes/twentythirteen/images/chef4.jpg"-->
<!--                                                alt="Наша команда"/>-->
<!---->
<!--                        <div class="mask">-->
<!--                            <div class="social-w-i">-->
<!--                                <ul>-->
<!--                                    <li><a title="facebook" href="#" class="icon-f">f</a></li>-->
<!--                                    <li><a title="twitter" href="#" class="icon-t">t</a></li>-->
<!--                                    <li><a title="google+" href="#" class="icon-g">g</a></li>-->
<!--                                </ul>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <h3 class='name-category-products'>LINDSIE ROB</h3>-->
<!--                </div>-->
<!--                <p class='description-category-products'>Whether the flitting attendance of the one still and-->
<!--                    solitary jet had gradually worked upon Ahab.</p>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!-- #end members list -->

<!-- #Blog list -->
<div id="blog-list-wrap">
    <div class='category-products-row'>
        <div class="row clearfix">
            <h3 style="margin-bottom: 0" class='name-category-products'>Останні публікації</h3>

            <p style="margin:0" class='description-category-products'>Перегляньте наші останні публікації та дізнайтесь про
                що ми розповідаємо</p>

            <div class="row clearfix">
                <?php
                $args = array('posts_per_page' => 3, 'category' => 9, 'orderby' => 'post_date');
                $myposts = get_posts($args);
                foreach ($myposts as $post) : setup_postdata($post); ?>
                    <div class="col-md-4">
                        <div class="col-lg-12">
                            <?php if (get_the_post_thumbnail()) { ?>
                            <div class="img-i-c-p"><a href="<?php the_permalink();?>"><? echo get_the_post_thumbnail()?></a>
                            </div><?
                        } else {
                            ?>
                            <div class="img-i-c-p"><a href="<?php the_permalink();?>"><img
                                src="/wp-content/themes/twentythirteen/images/simple-bg.png" width="350" height="270"/></a>
                            </div>
                            <? }?>
                            <h3 class='name-category-products'><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <p class='description-category-products'><?php custom_excerpt(25)?></p>
                            <span class='line-bottom-h'></span>
                            <ul>
                                <li><? echo get_the_date();?></li>
                                <li><? echo get_the_author();?></li>
                                <li><? echo comments_number('0 коментарів', '1 коментар', '% responses');?></li>
                            </ul>
                        </div>
                    </div>
                    <?php endforeach;
                wp_reset_postdata();?>
            </div>
        </div>

    </div>
</div>
</div>
<!-- #end blog list -->
<div id="contact-form">
    <?php echo do_shortcode('[contact-form-7 id="35" title="Контактна форма"]') ?>
</div>
<div id="maps-wc7-form">

</div>
<?php get_footer(); ?>