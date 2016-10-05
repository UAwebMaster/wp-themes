<?php
ob_start();
/*
Template Name: shop Cart
*/

get_header(); ?>
<?
if ($_REQUEST['payment']){
    $state = $_REQUEST['payment']->state;
    parse_str($_REQUEST['payment'], $get_array);
    $orderID =  $get_array['order'];


    if ($state == 'ok' || $state == 'wait' || $state = 'test'){
        $query = mysql_query("UPDATE wp_orders SET order_status = 1, payment_status = 1 WHERE id IN ($orderID)");
        $query_calendar = mysql_query("UPDATE wp_event_calendar SET status = 1 WHERE id IN ($orderID)");

        if ($query){
        ?>
            <script type="text/javascript">
                BootstrapDialog.show({
                    title: "Ваше замовлення успішно сформовано. Найближчим часом ми зв'яжемось з Вами" ,
                    animate: false,
                    closable: false,
                    buttons: [{
                        label: 'OK',
                        cssClass:'btn btn-success',
                        action: function(dialog) {
                            var templateUrl = "<?php bloginfo('template_directory') ?>";
                            templateUrl += '/shop_cart/ajax_deleteIAllItem_cart.php';

                            $.ajax({
                                url:templateUrl,
                                type:'POST',
                                data:{},
                                success:function (invoice_object) {
                                    window.location.href = "http://www.morning-bakery.com.ua";
                                }
                            });
                            // Видалити сесію і перенаправити на головну сторінку
                        }
                    }],
                    cssClass:'inform-dialog'

                });
            </script>
        <?
        }

    }else if ($state == 'fail'){
        ?>
    <script type="text/javascript">
        BootstrapDialog.show({
            title: "Виникла помилка замовлення!" ,
            closable: false,
            animate: false,
            buttons: [{
                label: 'OK',
                cssClass:'btn btn-success',
                action: function(dialog) {
                    dialog.close();
                }
            }],
            cssClass:'inform-dialog'

        });
    </script>
    <?

    }
}
  ?>

<div id="cart-page">
    <div id="primary" class="content-area clearfix  ">
        <div class="site-content  " role="main">
            <div class="clearfix row"><h2 class="text-left">Оформлення замовлення</h2></div>

            <div class="row">
                <div class="clearfix">
                    <div id="userInformation">
                        <div class="  clearfix col-lg-12">
                            <h3 class="col-lg-9  text-left"><span class="col-lg-1 circle-form no-active">1</span><span
                                class="col-lg-11" style="  border-bottom: 1px solid #FDB822;">Контактна інформація   <a id="hide-first-step" class="hide" href="#">Редагувати</a></span>

                            </h3>
                            <form class="form-horizontal" action="" id="first-step-valid">
                            <div class="col-lg-9  ">

                                <div class="main-box">
                                    <div class=" clearfix row">

                                    </div>
                                    <div class="clearfix main-box-body">

                                        <?

                                        if (isset($_SESSION['user'])) {
                                            if (sizeof($_SESSION['product'])>0){
                                                $user = $_SESSION['user'];
//$res = '';
                                                if ($user->socialId == '') {
                                                    $query = mysql_query("SELECT *, id as social_id FROM wp_users_social WHERE id = $user")or die ("<br>Invalid query: " . mysql_error());
//                                              $res = "SELECT * FROM wp_users_social WHERE id = $user";
                                                }else{
                                                    $query = mysql_query("SELECT * FROM wp_users_social WHERE social_id = '$user->socialId'")or die ("<br>Invalid query: " . mysql_error());
//                                                    $res = "SELECT * FROM wp_users_social WHERE social_id = '$user->socialId'";
                                                }
//                                                echo $res;
                                                $user = new stdClass();
                                                while ($post_data = mysql_fetch_assoc($query)) {
                                                    $login = $post_data['name'];
                                                    $email = $post_data['email'];
                                                    $phone = $post_data['phone'];

                                                    if ($login){
                                                        $user->name = $login;
                                                    }else{
                                                        $user->name = $post_data['login'];
                                                    }

                                                    $user->socialId = $post_data['social_id'];
                                                    $user->email = $email;
                                                    $user->phone = $phone;
                                                }
//                                                print_r($user);
                                                if (!is_null($user->socialId)) {
                                                    echo "<div class='form-group'><label class='col-lg-1 control-label'></label><div class='col-lg-6'><input class='form-control' id='userId' type='hidden' value='$user->socialId'/></div> </div>";
                                                } else {
                                                    echo "<div class='form-group'><label class='col-lg-1 control-label'></label><div class='col-lg-6'><input class='form-control' id='userId' value='$user' required /></div></div>";
                                                }
                                                if (!is_null($user->name)) {
                                                    echo "<div class='form-group'><label class='col-lg-1 control-label'>Ім'я</label><div class='col-lg-6'><input class='form-control' type='text' value='$user->name' id='user_name' required/></div></div>";
                                                } else {
                                                    echo "<div class='form-group'><label class='col-lg-1 control-label'>Ім'я</label><div class='col-lg-6'><input class='form-control' type='text' id='user_name' required/> </div></div>";
                                                }

                                                if (!is_null($user->email)) {
                                                    echo "<div class='form-group'><label class='col-lg-1 control-label'>Email</label><div class='col-lg-6'><input  type='email' name='log-email' class='form-control'  value='$user->email' id='user_mail'  required=''/> </div></div>";
                                                } else {
                                                    echo "<div class='form-group'><label class='col-lg-1 control-label'>Email</label><div class='col-lg-6'><input type='email' name='log-email' class='form-control'  value='' id='user_mail'  required=''/> </div></div>";
                                                }
                                                if (!is_null($user->phone)) {
                                                    echo "<div class='form-group'><label class='col-lg-1 control-label'>Телефон</label><div class='col-lg-6'><input class='form-control' type='text' value='$user->phone' name='phone' id='user_phone' required/></div> </div>";
                                                } else {
                                                    echo "<div class='form-group'><label class='col-lg-1 control-label'>Телефон </label><div class='col-lg-6'><input class='form-control' type='text' name='phone' id='phone' required/></div></div>";
                                                }
                                            }else{
                                                header('Location: http://www.morning-bakery.com.ua/');
                                            }

                                        } else {
                                            header('Location: http://www.morning-bakery.com.ua/login/?from=cart');
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-success pull-left">Далі</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 bg-site-color panel-heading">
                                <div id="makeCheckout" class="products-data main-box-body clearfix">
                                    <div id="products-append">
                                    </div>
                                    <div class="clearfix text-center">
                                        <a onclick="showShopingCart('btn-in-cart')">Редагувати замовлення</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="step-2-wrap" >
                <div class="clearfix">

                    <div class="col-lg-12">
                        <div class=" clearfix   col-lg-9">
                            <h3 class="text-left hidden-order-step "><span class="col-lg-1 circle-form no-active">2</span><span
                                class="col-lg-11"
                                style="  border-bottom: 1px solid #FDB822;">Оформлення доставки та вибір оплати</span>
                            </h3>
                        </div>
                        <div id="show-step-2" class="hide">
                            <div class="col-lg-9">
                                <div class="main-box">
                                    <div class="main-box-body">
                                        <div class="tabs-wrapper" id="tabs">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a href="#tab-single-order" data-toggle="tab"><span
                                                    class="sprite choose-order "></span>Миттєве
                                                    замовлення</a></li>
                                                <li class=""><a href="#tab-week-order" data-toggle="tab"><span
                                                    class="sprite choose-order "></span>Багаторазове
                                                    замовлення</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane fade active in" id="tab-single-order">
                                                    <div class="clearfix main-box-body">
                                                        <div class="total-list-product">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12" id="single-order-wrap">
                                                            <div class="main-box">
                                                                <div class="main-box-body clearfix">
                                                                    <div class="form-horizontal">
                                                                        <div id="addreses-order" class="form-group"><label
                                                                            style="color: #000; padding-top: 10px;"
                                                                            class="col-lg-3 control-label">Вкажіть час доставки:<i id="show-information-block" class="fa icon-info-sign"></i></label>

                                                                            <div class="form-inline col-lg-9 " id="order-time-picker-single">
                                                                                <label class="col-lg-3 input-group ">
                                                                                    <span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                                    <input type="text" class="form-control" id="single-date-select">
                                                                                </label>

                                                                                &nbsp;з  <label
                                                                                    class="col-lg-3 input-group input-append bootstrap-timepicker"><span
                                                                                    class="add-on input-group-addon"><i
                                                                                    class="fa fa-clock-o"></i></span><input type="text"
                                                                                                                            class="form-control time start ui-timepicker-input"
                                                                                                                            autocomplete="off"></label>
                                                                                до <label
                                                                                    class="col-lg-3 input-group input-append bootstrap-timepicker"><span
                                                                                    class="add-on input-group-addon"><i
                                                                                    class="fa fa-clock-o"></i></span><input type="text"
                                                                                                                            class="form-control time end ui-timepicker-input"
                                                                                                                            autocomplete="off"></label>
                                                                            </div>
                                                                        </div>
                                                                        <div id="select-order-addr-single" class="form-group"><label style="color: #000; padding-top: 10px;" class="col-lg-3 control-label">Адреса доставки:</label>

                                                                            <div class="col-lg-9">
                                                                                <div>
                                                                                    <form role="form" id="select-single-order-val" class="hide row">
                                                                                        <div class="form-group col-xs-12">
                                                                                            <select class="form-control"></select>
                                                                                        </div>
                                                                                    </form>
                                                                                    <form role="form" id="select-value-for-address-div-single" class="hide row">

                                                                                        <div class="form-group col-xs-8">
                                                                                            <input class="form-control" name="street-value-single" type="text" id="street-value-single">
                                                                                            <span class="help-block">вулиця</span>
                                                                                        </div>
                                                                                        <div class="form-group col-xs-2">
                                                                                            <input class="form-control" name="build-value-single" type="text" id="build-value-single">
                                                                                            <span class="help-block">будинок</span>
                                                                                        </div>
                                                                                        <div class="form-group col-xs-2">
                                                                                            <input class="form-control" name="flat-value-single" type="text" id="flat-value-single">
                                                                                            <span class="help-block">квартира</span>
                                                                                        </div>

                                                                                    </form>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="control-label col-lg-3">Спосіб оплати:</label>
                                                                            <div class="form-inline col-lg-9 payment-wrap" id="payment-wrap">
                                                                                <div class="form-inline col-xs-12">
                                                                                    <div class="form-group col-xs-6 col-md-4">
                                                                                        <label for="banknot-payment-radio" class="active"><i class="sprite banknot-payment"></i><span>Оплата готівкою<br>при отриманні</span></label>
                                                                                        <input type="radio" name="payment-radio" data-payment = "cash" class="hide" checked="checked" id="banknot-payment-radio">
                                                                                    </div>
                                                                                    <div class="form-group col-md-4 col-xs-6" >
                                                                                        <label for="private-24-radio"><i class="sprite private-24-payment"></i><span> Оплата карткою<br>приват 24</span> </label>
                                                                                        <input type="radio" class="hide" data-payment = "private24" name="payment-radio" id="private-24-radio">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="tab-week-order">
                                                    <div class="clearfix main-box-body">
                                                        <div id="calendar" class="col-lg-12   "></div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div class="col-lg-3  bg-site-color panel-heading">
                                <div class="total-order-price-quantity text-left">Всього</div>
                                <div class="clearfix">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <form role="form" id="send-data-order" action="" method="post">
                                                <div class="main-box-body">
                                                    <div class="clearfix" style="border-bottom: 1px solid #FDB822;">
                                                        <div class="row radio">

                                                            <div class="col-lg-7 text-left"><span
                                                                id="total-order-quantity">0</span> товарів на суму
                                                            </div>
                                                            <div class="col-lg-5 text-right"><span
                                                                id="total-price-order">0</span> грн.
                                                            </div>
                                                        </div>
                                                        <div class="row radio">
                                                            <div class="col-lg-7     text-left">
                                                                <span>Доставка</span>
                                                            </div>
                                                            <div class="col-lg-5     text-right">
                                                                <span id="price-delivery">0</span> грн.
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="row radio total-accept-price">
                                                        <div class="col-lg-7  text-left">
                                                            <span>Сума:</span>
                                                        </div>
                                                        <div class="col-lg-5  text-right">
                                                            <span id="total-price-accept">0</span> грн.
                                                        </div>
                                                    </div>
                                                    <div style="padding: 15px 0" class="clearfix text-center">
                                                        <button type="submit" class="btn btn-success" id="accept-order-btn" data-select-order-ex = 'single'
                                                                 disabled>Підтвердити замовлення
                                                        </button>
                                                    </div>

                                                </div>
                                            </form>
                                            <div class="col-lg-12"><p class="help-block-p">Заповніть обов'язкові поля (обведені червоним)</p></div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3" id="total-order-prepend">

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- #content -->
    </div>
    <!-- #primary -->
</div>
<button type="button" onclick="getTime()" style="display: none">get</button>
<script type="text/javascript">
    function getTime(){
        var date = $('#single-date-select').val();

        console.log(  moment('"'+date+'"').format("DD-MM-YYYY"));
    }
</script>
<?php get_footer();
ob_end_flush(); ?>

