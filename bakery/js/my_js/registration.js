function registrationUser(fromPage) {
    console.log(fromPage)
    var $login = $('#registration-form input[name="login"]');
    var $email = $('#registration-form input[name="email"]');
    var $pwd = $('#registration-form input[name="pwd"]');
    var $confirm_pwd = $('#registration-form input[name="user-psw-confirm"]');
    var $phoneNumber = $('#registration-form input[name="phone"]');
    if (validateLogin($login.val()) == true && validateEmail($email.val()) == true && validatePwd($pwd.val(), $confirm_pwd.val()) == true) {
        //if validations is true
        var templateUrl = 'http://www.morning-bakery.com.ua';
        templateUrl += '/wp-content/themes/twentythirteen/ajax/registrationForm.php';

        $.post(templateUrl, {'login': $login.val(), 'email': $email.val(), 'pwd': $pwd.val(), 'phone': $phoneNumber.val(), 'action': 1},
            function (data) {
                var obj = data;
                if (obj == 0) {
                    $('#reg-err-wrap').html('').append('<p class="wpcf7-mail-sent-ng"></p><span>Користувач з таким іменем вже існує в базі даних</span>');
                } else if (fromPage == 'cart'){
                    window.location.href = "http://www.morning-bakery.com.ua/checkout/"
                } else if (obj == 1) {
                    window.location.href = "http://www.morning-bakery.com.ua/kalendar/"
                }
            }
        );

    } else {
        if (validateEmail($email.val()) == false) {
            validatePwd($pwd.val(), $confirm_pwd.val());
        }
    }
}

function validateLogin(login) {
    var onlyLetters = /^[a-zA-Z0-9_-]+$/.test(login);
    if (login.length == 0) {
        $(' input[name="login"]+.error').html('Поле пусте').show();
        $(' input[name="login"]+.error').hover(function () {
            $(this).fadeOut();
        });
    } else if (login.length < 4) {
        $(' input[name="login"]+.error').html('К-ть символів менша 4').show();
        $(' input[name="login"]+.error').hover(function () {
            $(this).fadeOut();
        });
    } else if (onlyLetters == false) {
        $(' input[name="login"]+.error').html('Тільки латиниця').show();
        $(' input[name="login"]+.error').hover(function () {
            $(this).fadeOut();
        });
    } else return true;
}

function validateEmail(email) {
    var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm;
    if (re.test(email)) {
        return true;
    } else {
        $(' input[name="email"]+.error').show();
        $(' input[name="email"]+.error').hover(function () {
            $(this).fadeOut();
        });
        $('.login-validation input[name="login"]+.error').html('Некоректний email').show();
        $('.login-validation input[name="login"]+.error').hover(function () {
            $(this).fadeOut();
        });
        return false;
    }
}

function validatePwd(val1, val2) {

    if (val1 != '' && val2 != '') {
        if (val1.length < 4 && val1.length != 0) {
            $('input[name="pwd"]+.error').html('К-ть символів менша 4').show();
            $('input[name="pwd"]+.error').hover(function () {
                $(this).fadeOut();
            })
        } else if (val2 == val1) {
            return true;
        }
        else {
            $(' input[name="user-psw-confirm"]+.error').html('Пароль не співпадає').show();
            $(' input[name="user-psw-confirm"]+.error').hover(function () {
                $(this).fadeOut();
            });
        }
    } else {
        if (val1 == '') {
            $(' input[name="pwd"]+.error').html('Поле пусте').show();
            $('input[name="pwd"]+.error').hover(function () {
                $(this).fadeOut();
            });
        } else {
            if (val1.length < 4 && val1.length != 0) {
                $(' input[name="pwd"]+.error').html('К-ть символів менша 4').show();
                $(' input[name="pwd"]+.error').hover(function () {
                    $(this).fadeOut();
                })
            }
        }
        if (val2 == '') {
            $(' input[name="user-psw-confirm"]+.error').html('Поле пусте').show();
            $(' input[name="user-psw-confirm"]+.error').hover(function () {
                $(this).fadeOut();
            });
        }
        return false;
    }
}


    $("input[name='phone']").mask("(999)-999-99-99");


$("input[name='phone']").on("blur", function() {
    var last = $(this).val().substr( $(this).val().indexOf("-") + 1 );

    if( last.length == 3 ) {
        var move = $(this).val().substr( $(this).val().indexOf("-") - 1, 1 );
        var lastfour = move + last;

        var first = $(this).val().substr( 0, 9 );

        $(this).val( first + '-' + lastfour );
    }
});
function loginUser(fromPage) {
    console.log(fromPage)
    var $login = $('.login-validation input[name="login"]');
    var $pwd = $('.login-validation input[name="pwd"]');
    var templateUrl = 'http://www.morning-bakery.com.ua';
    templateUrl += '/wp-content/themes/twentythirteen/ajax/registrationForm.php';

    if ($login.val != '' && $pwd.val() != '') {
        /*if ($login.val().indexOf('@')!=-1){

         var tmp_check =  validateEmail($login.val());
         if (tmp_check == true){
         $.post(templateUrl, {'login': $login.val(),  'pwd':$pwd.val(), 'action':2},
         function (data) {
         if (data == 1){
         window.location.href = 'http://www.morning-bakery.com.ua/kalendar/';
         }else{
         $('#login-err-wrap').html('').append(data);
         }
         }
         );
         }
         }else {*/
        if (validateLogin($login.val()) == true) {
            $.post(templateUrl, {'login': $login.val(), 'pwd': $pwd.val(), 'action': 2, 'fromPage':fromPage},
                function (data) {
                    if (data == 1) {
                        window.location.href = 'http://www.morning-bakery.com.ua/';
                    }else if(data == 2){

                        window.location.href = 'http://www.morning-bakery.com.ua/checkout/';
                    }
                    else {

                        $('#login-err-wrap').html('').append(data);
                    }
                }
            );
        }
        /* }*/
    } else {
        validateLogin($login.val());
        validatePwd($pwd.val());

    }

}
