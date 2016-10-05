<?php
ob_start();

require_once '../SocialAuther/autoload.php';
require_once 'login-page-ajax.php';
?>

<?php


if (isset($_SESSION['user'])) {
} else if (!isset($_GET['code']) && !isset($_SESSION['user'])) {
    ?>
<div class="reg-wrap-cont " style="padding: 0; margin: 0">
    <div class="row">

        <div class="clearfix">
            <div class="col-lg-12" style="padding: 20px;">
                <div class="col-lg-6" style="border-right: 1px solid #fdb822">
                    <form role="from" action="" method="POST" id="user-login-form-dialog">
                        <p>Ввійдіть через соціальні мережі</p>
                        <ul class="social-networks-login dialog">
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

                        <div class="form-group">
                            <label class="col-lg-12">
                                <input class="form-control" type="text" name="login" placeholder="логін" required>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-12">
                                <input class="form-control" type="password" name="pwd" placeholder="пароль" required>
                            </label>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-login-dialog">OK</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6">

                    <h3>Нові на morning-bakery.com.ua?</h3>

                    <p>Зареєструйтесь! Це швидко і просто</p>

                    <form action="http://www.morning-bakery.com.ua/reyestraciya/" name="register-form">
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-login-dialog">Реєстрація</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?
}
?>



<? ob_end_flush(); ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#user-login-form-dialog button[type="submit"]').click(function () {
            var $formUser = $('#user-login-form-dialog');
            if ($formUser.valid() == true) {

                var templateUrl = 'http://www.morning-bakery.com.ua';
                templateUrl += '/wp-content/themes/twentythirteen/ajax/login-from-dialog.php';
                $.post(templateUrl, {'login': $('#user-login-form-dialog input[name="login"]').val(), 'pwd': $('#user-login-form-dialog input[name="pwd"]').val(), 'action': 2},
                    function (data) {
                        var $respons = JSON.parse(data);
                        if ($respons.status_login == 0  ){
                            $('#user-login-form-dialog input[name="login"]').addClass('error');
                        }else if ($respons.status_pwd == 0){
                            $('#user-login-form-dialog input[name="pwd"]').addClass('error');
                        }else if ($respons.status_login == 1){
                            location.reload(true);
                        }
                    }
                );

            }
            $formUser.on('submit', function (e) {
                // validation code here
                e.preventDefault();
            });
        });
    })

</script>