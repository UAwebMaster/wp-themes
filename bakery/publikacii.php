<?php
/*
Template Name: publication page
*/
get_header(); ?>
<div class="site-content">
    <div class="row">

        <div class="row" id="blog-list-wrap">
            <div class="col-lg-12">
                <h1>Наші публікації</h1>


                    <?php
                    $args = array( 'category' => 9, 'orderby' => 'post_date');
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



<?php get_footer(); ?>