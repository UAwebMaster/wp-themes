<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slavik
 * Date: 09.12.15
 * Time: 10:13
 * To change this template use File | Settings | File Templates.
 */
?>
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
<script src="<?php echo get_template_directory_uri(); ?>/js/moment-admin.js"></script>

<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap-dialog.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/masked-input-plugin.js"></script>

<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.validate.min.js"></script>

<script src="<?php echo get_template_directory_uri(); ?>/js/timepicker.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/datepicker.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.blockUI.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/daterangepicker-admin.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/datepair.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/my_js/script.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.js"></script>
<?php
  if (!(is_user_logged_in())) {
      header("Location:  http://www.morning-bakery.com.ua/wp-admin/"); /* Redirect browser */
      exit();
  }
?>
    <div id="theme-wrapper">
        <div id="administration">
            <div id="page-wrapper" class="container">

                <div class="row">
                    <div id="nav-col">
                        <section id="col-left" class="col-left-nano has-scrollbar">
                            <div id="col-left-inner" class="col-left-nano-content" tabindex="0" style="right: -17px;">

                                <div class="collapse navbar-collapse navbar-ex1-collapse" id="sidebar-nav">
                                    <ul class="nav nav-pills nav-stacked">

                                        <li >
                                            <a id="users-li" href="<?php echo get_site_url(); ?>/administration/users">
                                                <i class="fa fa-user"></i>
                                                <span>Користувачі</span>

                                            </a>
                                        </li>
                                        <li>
                                            <a id="orders-li" href="<?php echo get_site_url(); ?>/administration/orders-list">
                                                <i class="fa fa-order"></i>
                                                <span>Замовлення</span>

                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="nano-pane" style="display: block;">
                                <div class="nano-slider" style="height: 324px; transform: translate(0px, 0px);"></div>
                            </div>
                        </section>
                        <div id="nav-col-submenu"></div>
                    </div>
                    <div id="content-wrapper1">