<?php
/*
Template Name: Contacts page
*/

get_header(); ?>
    <div id="contact-page">
        <div id="primary" class="content-area">
            <div  class="site-content" role="main" style="overflow: hidden;">
                <div id="form-products"><iframe src="https://docs.google.com/forms/d/1RNVMlopKKBaL4z-SGx1tvzQvzxgh5u1luONMGoMaZho/viewform?embedded=true" width="1200" height="1275" frameborder="0" marginheight="0" marginwidth="0" id="form-morn">
                    Loading...

                </iframe></div>

                <div id="maps-wc7-form">

                </div>

                <div class="col-lg-12" style="margin-top: 30px;">
                    <?php

                    $id=12;
                    $post = get_post($id);
                    $content = apply_filters('the_content', $post->post_content);
                    echo $content;

                    ?>
                </div>



            </div><!-- #content -->
        </div><!-- #primary -->
    </div>


<?php get_footer(); ?>
