<?php
ob_start();
session_start();

global $adapters;

/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/jquery.fancybox.css"/>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/daterangepicker.css"/>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/datapicker.css"/>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/bootstrap-rtl.css"/>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/jquery-ui.css"/>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/fullcalendar.css"/>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/themes.css"/>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/footable.css"/>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
    <![endif]-->
    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery-2.1.1.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery-ui.min.js"></script>

    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery.fancybox.pack.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/moment.js"></script>

    <script src="<?php echo get_template_directory_uri(); ?>/js/fullcalendar.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap-dialog.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/masked-input-plugin.js"></script>

    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery.validate.min.js"></script>

    <script src="<?php echo get_template_directory_uri(); ?>/js/timepicker.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/datepicker.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery.blockUI.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/daterangepicker.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/datepair.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/my_js/script.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script type="text/javascript" src="https://apis.google.com/js/plusone.js">
        {
            parsetags: 'explicit'
        }
    </script>
    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function () {
        FB.init({
            appId: '323703671148800',
            status: true, // check login status
            cookie: true, // enable cookies to allow the server to access the session
            xfbml: true // parse XFBML
        });
    };

    (function () {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
    }());


</script>
<header id="masthead" class="site-header" role="banner">
    <button class="navbar-toggle" data-target=".navbar-ex1-collapse" data-toggle="collapse" type="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="fa fa-bars">Menu</span>
    </button>
    <a class="home-link" href="<?php echo esc_url(home_url('/')); ?>"
       title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
    </a>

    <div id="navbar" class="navbar navbar-collapse navbar-ex1-collapse collapse"">
        <nav id="site-navigation" class="navigation main-navigation" role="navigation">
            <?php wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'nav-menu')); ?>
        </nav>
        <!-- #site-navigation -->
    </div>
    <!-- #navbar -->
</header>
<!-- #masthead -->
<? session_start(); ?>
<?php require_once 'SocialAuther/autoload.php'; ?>
<?php require_once 'ajax/login-page-ajax.php'; ?>
<?
$_SESSION['url'] = $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; //for redirect to page

?>
<ul id="wrap-us-sh-inf">
    <li id="user-info">
<?//  session_unset($_SESSION['product']); ?>
        <?
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            if (!is_null($user->socialId)){
                $id = $user->socialId;
            }else {
                $id = $_SESSION['user'];
            }

            $result = mysql_query("SELECT * FROM `wp_users_social` WHERE id = '$id' OR social_id = '$id' ")or die("ERROR: ".mysql_error());
            $res = mysql_fetch_assoc($result);
            $login = $res['login'];
            $name = $res['name'];
            echo '<a class="dropdown-toggle" href="#" data-toggle="dropdown"><span><i class="fa fa-user"></i><span id="mobile-user-info">'.$name.''.$login.'</span></span><b class="caret"></b></a>';

            ?>
            <ul class="dropdown-menu dropdown-menu-right">
                <li><a href="/profile"><i class="fa fa-user"></i>Профіль</a></li>
                <li><a href="<?php  bloginfo('template_directory')?>/logout.php" title="Вийти"><i class="fa fa-sign-out"></i>Вийти</a></li>
            </ul>
           <?
        }else {
            ?>
        <span><i class="fa fa-user"></i></span><a href="#"  id="user-login-boot" title="Вийти">Ввійти</a>
            <?

//        echo session_id();
    } ?>

    </li>
    <li title="Корзина" id="shopMaker" class="d-b-w">
        <a id="goToshopCart" onclick="showShopingCart()">
            <span class="sprite shopping-cart"></span>

            <div class="arrow-left"></div>
            <span id="sumItem">
                <?
                    if ($_SESSION['product']->totalItem){
                        echo ( $_SESSION['product']->totalItem);
                    }else {
                        echo 0;
                    }
                ?>
            </span>

        </a>
        <div id="show-shop-cart-title" class="hidden">
            <span>Для оформлення замовлення перейдіть <a href="javascript:void(0)" onclick="showShopingCart()"><i class="fa icon-shopping-cart"></i> до корзини</a></span>
        </div>
<!--        <span id="priceItem">на <span></span> грн</span>-->
    </li>
</ul>
<div id="page" class="hfeed site">
    <div id="main" class="site-main">
