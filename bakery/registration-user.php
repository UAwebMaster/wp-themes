<?php
/*
Template Name: Registration page
*/

get_header(); ?>
<? $fromPage = $_GET[fromPage];?>
    <div id="registration-page">

        <div id="primary" class="content-area">
            <div class="site-content" role="main">
                <p class="msg-top">Створіть ваш персональний акаунт</p>

                <div id="registration-form" class="col-lg-6 col-md-6 col-xs-12">
                    <h3> Заповніть ваші дані </h3>
                    <label>
                        <input type="text" maxlength="64" name="login" placeholder="логін...">
                        <span class="msg error">Тільки латиниця</span>
                    </label>
                    <label>
                        <input type="text" maxlength="64" name="email" placeholder="email...">
                        <span class="msg error">Некоректний email</span>
                    </label>
                    <label>
                        <input type="text" maxlength="64" name="phone" placeholder="телефон...">
                        <span class="msg error">Некоректний телефон</span>
                    </label>
                    <label>
                        <input type="password" minlength="4" name="pwd" placeholder="пароль">
                        <span class="msg error">Поле пусте</span>
                    </label>
                    <label>
                        <input type="password" name="user-psw-confirm" placeholder="підтвердіть пароль">
                        <span class="msg error">Пароль не співпадає</span>
                    </label>
                    <div id="reg-err-wrap"></div>
                    <input class="reg-button" type="submit" value="Реєстрація" onclick="registrationUser(<? echo("'$fromPage'") ?>)">
                    <script>
                        $("#registration-form").keyup(function(event){
                            if(event.keyCode == 13){
                                $("#registration-form input[type='submit']").trigger('click');
                            }
                        });
                    </script>
                </div>
                <?php
                    if( $fromPage == 'cart'){
                        ?>   <p class="reg-p-text">якщо Ви вже маєте акаунт, пройдіть <a href="/checkout">авторизацію</a></p><?
                    }else {
                        ?>  <p class="reg-p-text">якщо Ви вже маєте акаунт, пройдіть <a href="/kalendar">авторизацію</a></p> <?
                    }
                ?>


            </div>
            <!-- #content -->
        </div>
        <!-- #primary -->
    </div>


<?php get_footer(); ?>