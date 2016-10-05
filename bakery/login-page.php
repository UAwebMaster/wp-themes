<?php
ob_start();
/*
Template Name: login page
*/
require_once 'SocialAuther/autoload.php';

get_header(); ?>

<?php
$fromPage = $_GET['from'];


?>
<div id="login-page">
    <div id="primary" class="content-area">
        <div class="site-content" role="main">
            <?php
            if (isset($_SESSION['user']) && isset( $_GET['from'])) {
                header("Location: http://morning-bakery.com.ua/checkout");
                die();
            } else if (!isset($_GET['code']) && !isset($_SESSION['user'])) {
                ?>
                <p class="msg-top">Для продовження оформлення замовлення скористайтесь формою логування або
                    реєстрації</p>
                <div class="reg-wrap-cont">
                    <div class="col-lg-6 col-xs-12 col-md-6">
                        <div class="reg-left-cont">
                            <h3>Логування</h3>

                            <p>Ввійдіть через соціальні мережі</p>
                            <ul class="social-networks-login">
                                <?
                                foreach ($adapters as $title => $adapter) {
                                    if (ucfirst($title) == 'Vk') {
                                        echo '<li><a title="' . ucfirst($title) . '" href="' . $adapter->getAuthUrl() . '"><i class="fa fa-vk"></i></a></li>';
                                    }
                                    if (ucfirst($title) == 'Facebook') {
                                        echo '<li><a title="' . ucfirst($title) . '" href="' . $adapter->getAuthUrl() . '"><i class="fa fa-facebook"></i></a></li>';
                                    }
                                    if (ucfirst($title) == 'Google') {
                                        /*  echo '<li><a href="' . $adapter->getAuthUrl() . '">G' . ucfirst($title) . '</a></li>';*/
                                        echo '<li><a title="' . ucfirst($title) . '" href="' . $adapter->getAuthUrl() . '"><i class="fa fa-google"></i></a></li>';
                                    }

                                }
                                ?>
                            </ul>
                            <p>або заповніть поле</p>

                            <div class="login-validation">
                                <label>
                                    <input type="text" name="login" placeholder="логін">
                                    <span class="msg error">Поле пусте</span>
                                </label>
                                <label>
                                    <input type="password" name="pwd" placeholder="пароль">
                                    <span class="msg error">Поле пусте</span>
                                </label>

                                <div id="login-err-wrap"></div>
                                <input type="submit" onclick="loginUser(<? echo "'$fromPage'"?>)" class="reg-button" value="OK"/>
                                <script>
                                    $(".login-validation").keyup(function(event){
                                        if(event.keyCode == 13){
                                            loginUser(<? echo "'$fromPage'" ?>);
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                <div class="col-lg-6 col-xs-12 col-md-6">
                    <div class="reg-right-cont">

                        <h3>Нові на morning-bakery.com.ua?</h3>

                        <p>Зареєструйтесь! Це швидко і просто</p>

                        <form action="http://www.morning-bakery.com.ua/reyestraciya/" name="register-form">
                            <input type="submit" value="Реєстрація" class="reg-button">
                            <input type="hidden" value="<? echo "$fromPage" ?>" name="fromPage">
                        </form>
                    </div>
                </div>

                </div>
            <?
            }else if (isset($_SESSION['user'])){
                header("Location: http://morning-bakery.com.ua/profile");
            }
            ?>
        </div>
        <!-- #content -->
    </div>
    <!-- #primary -->
</div>


<?php get_footer();
ob_end_flush(); ?>
