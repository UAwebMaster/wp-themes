<?php
/*
Template Name: profile page
*/
get_header(); ?>
<div class="site-content">
    <div class="row">
        <div class="col-md-12">
            <div class="main-box profile">
                <?php

                if (isset($_SESSION['user'])) {
                    $user_id = $_SESSION['user'];
                    if ($user_id->socialId) {
                        $user_id = $user_id->socialId;
                    }

                    $result = mysql_query("SELECT *  FROM `wp_users_social` WHERE  `social_id` =  $user_id OR id = $user_id");

                    $record = mysql_fetch_array($result);

                    $userFromDb = new stdClass();
                    $userFromDb->provider = $record['provider'];
                    $userFromDb->socialId = $record['social_id'];

                    $userFromDb->name = $record['name'];
                    $userFromDb->login = $record['login'];
                    $userFromDb->email = $record['email'];
                    $userFromDb->socialPage = $record['social_page'];
                    $userFromDb->sex = $record['sex'];
                    $userFromDb->birthday = date('m.d.Y', strtotime($record['birthday']));
                    $userFromDb->avatar = $record['avatar'];
                    $userFromDb->phone = $record['phone'];

                    $query_address = mysql_query("SELECT * FROM wp_user_addresses WHERE user_id = $user_id ");


                    if (mysql_num_rows($query_address) == 0) {
                        //results are empty, do something here
                    } else {
                        $address_obj = new ArrayObject();
                        while ($addresses = mysql_fetch_array($query_address)) {
                            $object = new stdClass();
                            $object->address = $addresses['address'];
                            $object->id = $addresses['id'];
                            $address_obj->append($object);
                        }
                    }




                    ?>

                    <div class="main-box-header clearfix row">
                        <div class="clo-lg-12 text-left"><h2
                            style="border-bottom: 1px solid; width: 100%"><?php echo $userFromDb->name . $userFromDb->login ?></h2>
                        </div>
                    </div>
                    <div class="main-box-body clearfix">
                        <div class="row">

                            <div class="col-lg-3">
                                <ul class="nav nav-pills nav-stacked">
                                    <li class="active"><a href="<?php echo get_site_url()?>/profile">Профіль</a></li>
                                    <li><a href="<?php echo get_permalink(100) ?>">Історія замовлень</a></li>
                                    <li><a href="<?php  bloginfo('template_directory')?>/logout.php">Вихід</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-lg-12" id="personal-data-wrap">
                                        <h3>Моя інформація</h3>

                                        <form action="" class="form-horizontal">

                                            <div class="form-group">
                                                <div class="col-lg-10">
                                                    <?php echo '<input type="hidden" id="user-id-hidden-field" value="'.$user_id.'">'   ?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <?php
                                                $name = '';
                                                    if($userFromDb->name !=''){
                                                        $name = "Ім'я";
                                                    }else{
                                                        $name = "Логін";
                                                    }
                                                ?>
                                                <label class="col-lg-2"><?php echo $name ?></label>

                                                <div class="col-lg-10">
                                                    <?php echo $userFromDb->name . $userFromDb->login  ?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2">E-mail</label>

                                                <div class="col-lg-10">
                                                    <?php echo $userFromDb->email ?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2">Телефон</label>

                                                <div class="col-lg-10">
                                                    <?php echo $userFromDb->phone ?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2">Адреси для доставок</label>
                                                <ul class="col-lg-10 without-list-style">
                                                    <?php
                                                        if ($address_obj){
                                                            foreach ($address_obj as $address) {
                                                                echo '<li>' . $address->address . '</li>';
                                                            }
                                                        }

                                                    ?>
                                                </ul>
                                            </div>
                                            <button type="button" class="btn btn-success">Змінити власні дані</button>

                                        </form>
                                    </div>
                                    <div class="col-lg-12 hide" id="edit-personal-data-wrap">
                                        <h3>Редагування власних даних</h3>

                                        <form  class="form-horizontal" method="POST" id="edit-personal-data">
                                            <div class="form-group">

                                                <label class="col-lg-2"><?php echo $name; ?></label>

                                                <div class="col-lg-10">
                                                    <? if ($userFromDb->name) {
                                                    echo "<input type='text' name='name' class='form-control' value='" . $userFromDb->name . " ' required/> ";
                                                } else {
                                                    echo "<input type='text' name='login' class='form-control' value='" . $userFromDb->login . " ' required/> ";
                                                }
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2">E-mail</label>

                                                <div class="col-lg-10">
                                                    <?php echo "<input class='form-control' type='email' name='email' value='" . $userFromDb->email . " ' required/> ";  ?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2">Телефон</label>

                                                <div class="col-lg-10">
                                                    <?php echo "<input class='form-control' type='text' name='phone' value='" . $userFromDb->phone . " ' required/> ";  ?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2">Адреси для доставок</label>
                                                <ul class="col-lg-10 without-list-style">
                                                    <?php
                                                    if ($address_obj){
                                                        foreach ($address_obj as $address) {
                                                            echo '<li id="address-' . $address->id . '"><span class="text-left">' . $address->address . '</span><i class="text-right fa fa-times"></i></li>';
                                                        }
                                                        echo '<li><span id="show-add-address-field" >Додати</span></li>';
                                                        echo '<li id="add-address-field" class="hide ">';
                                                    }else{
                                                        echo '<li id="add-address-field" >';
                                                    }
                                                    ?>
                                                    <div class="form-group col-xs-7" style="padding-left: 0">
                                                        <input class="form-control" name="street-value-single"
                                                               type="text" id="street-value-single"  >
                                                        <span class="help-block">вулиця</span>
                                                    </div>
                                                    <div class="form-group col-xs-2">
                                                        <input class="form-control" name="build-value-single"
                                                               type="text" id="build-value-single"  >
                                                        <span class="help-block">будинок</span>
                                                    </div>
                                                    <div class="form-group col-xs-2">
                                                        <input class="form-control" name="flat-value-single" type="text"
                                                               id="flat-value-single"  >
                                                        <span class="help-block">квартира</span>
                                                    </div>
                                                    <div class="form-group col-xs-1">
                                                        <i id="hide-address-edit-pinfo" class="text-right fa fa-times"></i>
                                                    </div>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success">Зберегти</button>
                                                <button type="button" class="btn btn-danger">Відміна</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <?php
                }else{
                    header('Location: http://www.morning-bakery.com.ua/login');
                }

                ?>

            </div>
        </div>
    </div>

</div>


<?php

?>

<?php get_footer(); ?>