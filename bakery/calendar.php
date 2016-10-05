<?php
//ob_start();
///*
//Template Name: Calendar page
//*/
//require_once 'SocialAuther/autoload.php';
//
//get_header(); ?>
<!---->
<?php
//
//// конфигурация настроек адаптера
//$adapterConfigs = array(
//    'vk' => array(
//        'client_id' => '4648323',
//        'client_secret' => 's3sTnoE1BD782JKVbc7U',
//        'redirect_uri' => 'http://www.morning-bakery.com.ua/kalendar?provider=vk'
//
//    ),
//    'google' => array(
//        'client_id' => '523648377771-ho9cihnkcft20t7f3ebhkm06ke7f09b5.apps.googleusercontent.com',
//        'client_secret' => 'GBIHhbh1hvDSvHJFdT9Vdxqc',
//        'redirect_uri' => 'http://www.morning-bakery.com.ua/?provider=google'
//    ),
//    'facebook' => array(
//        'client_id' => '1574939529406261',
//        'client_secret' => '2707eb57dd2708846193b14214473277',
//        'redirect_uri' => 'http://www.morning-bakery.com.ua/?provider=facebook'
//    )
//);
//
//$adapters = array();
//foreach ($adapterConfigs as $adapter => $settings) {
//    $class = 'SocialAuther\Adapter\\' . ucfirst($adapter);
//    $adapters[$adapter] = new $class($settings);
//
//}
//
//if (isset($_GET['provider']) && array_key_exists($_GET['provider'], $adapters)) {
//    $auther = new SocialAuther\SocialAuther($adapters[$_GET['provider']]);
//
//    if ($auther->authenticate()) {
//
//        $result = mysql_query(
//            "SELECT *  FROM `wp_users_social` WHERE `provider` = '{$auther->getProvider()}' AND `social_id` = '{$auther->getSocialId()}' LIMIT 1"
//        );
//
//        $record = mysql_fetch_array($result);
//        if (!$record) {
//            $values = array(
//                $auther->getProvider(),
//                $auther->getSocialId(),
//                $auther->getName(),
//                $auther->getEmail(),
//                $auther->getSocialPage(),
//                $auther->getSex(),
//                date('Y-m-d', strtotime($auther->getBirthday())),
//                $auther->getAvatar()
//            );
//
//            $query = "INSERT INTO `wp_users_social` (`provider`, `social_id`, `name`, `email`, `social_page`, `sex`, `birthday`, `avatar`) VALUES ('";
//            $query .= implode("', '", $values) . "')";
//            $result = mysql_query($query);
//        } else {
//            $userFromDb = new stdClass();
//            $userFromDb->provider = $record['provider'];
//            $userFromDb->socialId = $record['social_id'];
//            $userFromDb->name = $record['name'];
//            $userFromDb->email = $record['email'];
//            $userFromDb->socialPage = $record['social_page'];
//            $userFromDb->sex = $record['sex'];
//            $userFromDb->birthday = date('m.d.Y', strtotime($record['birthday']));
//            $userFromDb->avatar = $record['avatar'];
//        }
//
//        $user = new stdClass();
//        $user->provider = $auther->getProvider();
//        $user->socialId = $auther->getSocialId();
//        $user->name = $auther->getName();
//        $user->email = $auther->getEmail();
//        $user->socialPage = $auther->getSocialPage();
//        $user->sex = $auther->getSex();
//        $user->birthday = $auther->getBirthday();
//        $user->avatar = $auther->getAvatar();
//
//        if (isset($userFromDb) && $userFromDb != $user) {
//            $idToUpdate = $record['id'];
//            $birthday = date('Y-m-d', strtotime($user->birthday));
//
//            mysql_query(
//                "UPDATE `wp_users_social` SET " .
//                    "`social_id` = '{$user->socialId}',  " .
//                    "`social_page` = '{$user->socialPage}', `sex` = '{$user->sex}', " .
//                    "`birthday` = '{$birthday}', `avatar` = '$user->avatar' " .
//                    "WHERE `id`='{$idToUpdate}'"
//            );
//        }
//
//
//    }
//    $url = $_SESSION['url'];
//    header("Location:$url");
//}
//if ($_REQUEST['exit']) {
//    session_start();
//    unset($_SESSION['user']);
//    header('Location: http://www.morning-bakery.com.ua/');
//}
//?>
<!--<div id="calendar-page">-->
<!--    <div id="primary" class="content-area" style="overflow: hidden;">-->
<!--        <div class="site-content" role="main">-->
<!--            --><?php
//            if (isset($_SESSION['user'])) {
//                $user = $_SESSION['user'];
//                if (!is_null($user->socialId)) {
//                    echo "<div class='form-group'><label class='col-lg-1 control-label'></label><div class='col-lg-6'><input class='form-control' id='userId' type='hidden' value='$user->socialId'/></div> </div>";
//                } else {
//                    echo "<div class='form-group'><label class='col-lg-1 control-label'></label><div class='col-lg-6'><input class='form-control' id='userId' value='$user' required /></div></div>";
//                }
//                ?>
<!--                <div id="calendar" class="col-lg-12">-->
<!---->
<!--                </div>-->
<!--                --><?php
//            } else if (!isset($_GET['code']) && !isset($_SESSION['user'])) {
//                ?>
<!--                <p class="msg-top">Щоб переглянути свою історію замовлень, скористайтесь формою логування або-->
<!--                    реєстрації</p>-->
<!--                <div class="reg-wrap-cont">-->
<!--                    <div class="reg-left-cont">-->
<!--                        <h3>Логування</h3>-->
<!---->
<!--                        <p>Ввійдіть через соціальні мережі</p>-->
<!--                        <ul class="social-networks-login">-->
<!--                            --><?//
//                            foreach ($adapters as $title => $adapter) {
//                                if (ucfirst($title) == 'Vk') {
//                                    echo '<li><a title="' . ucfirst($title) . '" href="' . $adapter->getAuthUrl() . '"><i class="fa fa-vk"></i></a></li>';
//                                }
//                                if (ucfirst($title) == 'Facebook') {
//                                    echo '<li><a title="' . ucfirst($title) . '" href="' . $adapter->getAuthUrl() . '"><i class="fa fa-facebook"></i></a></li>';
//                                }
//                                if (ucfirst($title) == 'Google') {
//                                    /*  echo '<li><a href="' . $adapter->getAuthUrl() . '">G' . ucfirst($title) . '</a></li>';*/
//                                    echo '<li><a title="' . ucfirst($title) . '" href="' . $adapter->getAuthUrl() . '"><i class="fa fa-google"></i></a></li>';
//                                }
//
//                            }
//                            ?>
<!--                        </ul>-->
<!--                        <p>або заповніть поле</p>-->
<!---->
<!--                        <div class="login-validation">-->
<!--                            <label>-->
<!--                                <input type="text" name="login" placeholder="логін">-->
<!--                                <span class="msg error">Поле пусте</span>-->
<!--                            </label>-->
<!--                            <label>-->
<!--                                <input type="password" name="pwd" placeholder="пароль">-->
<!--                                <span class="msg error">Поле пусте</span>-->
<!--                            </label>-->
<!---->
<!--                            <div id="login-err-wrap"></div>-->
<!--                            <input type="submit" onclick="loginUser()" class="reg-button" value="OK"/>-->
<!--                            <script>-->
<!--                                $(".login-validation").keyup(function (event) {-->
<!--                                    if (event.keyCode == 13) {-->
<!--                                        loginUser();-->
<!--                                    }-->
<!--                                });-->
<!--                            </script>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="reg-right-cont">-->
<!---->
<!--                        <h3>Нові на morning-bakery.com.ua?</h3>-->
<!---->
<!--                        <p>Зареєструйтесь! Це швидко і просто</p>-->
<!---->
<!--                        <form action="http://www.morning-bakery.com.ua/reyestraciya/" name="register-form">-->
<!--                            <input type="submit" value="Реєстрація" class="reg-button">-->
<!--                        </form>-->
<!--                    </div>-->
<!--                </div>-->
<!--                --><?//
//            }
//            ?>
<!--        </div>-->
<!--        <!-- #content -->-->
<!--    </div>-->
<!--    <!-- #primary -->-->
<!--</div>-->
<!---->
<!--<script type="text/javascript">-->
<!--    $(document).ready(function(){-->
<!--        showCalendar();-->
<!--    })-->
<!--</script>-->
<?php //get_footer();
//ob_end_flush(); ?>
