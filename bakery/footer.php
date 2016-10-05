<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>


</div><!-- #page -->
<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="footer-wrap">
        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("sidebar-2")) : ?>
        <?php endif; ?>
    </div>
    <!-- <div class="rights-wrap">
         <p class="corp-right">2014 All rights reserved</p>
     </div>-->
</footer><!-- #colophon -->
<div id="data-about-product"></div>
<a title="Вгору" href="#0" class="cd-top"><i class="fa fa-arrow-up"></i></a>
<?php wp_footer(); ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/my_js/registration.js"></script>
<script>

if ($('#maps-wc7-form').length == 1) {
    function initialize() {
        var mapOptions = {
            zoom:14,
            center:new google.maps.LatLng(50.43489, 30.531983),
            scrollwheel:false,
            navigationControl:false,
            mapTypeControl:false,
            scaleControl:false,
            mapTypeControlOptions:{
                mapTypeIds:[google.maps.MapTypeId.ROADMAP, 'tehgrayz']
            },
            disableDefaultUI:true
        };
        var stylez = [
            {
                featureType:"all",
                elementType:"all",
                stylers:[
                    { saturation:-100 } // <-- THIS
                ]
            }
        ];
        var map = new google.maps.Map(document.getElementById('maps-wc7-form'),
            mapOptions);

        var mapType = new google.maps.StyledMapType(stylez, { name:"Grayscale" });
        map.mapTypes.set('tehgrayz', mapType);
        map.setMapTypeId('tehgrayz');

        var marker = new google.maps.Marker({
            position:map.getCenter(),
            icon:"/wp-content/themes/twentythirteen/images/google-icons.png",
            map:map
        });

    }

    google.maps.event.addDomListener(window, 'load', initialize);
}

function getCustomPost(post_id) {
    var templateUrl = "<?php bloginfo('template_directory') ?>";
    templateUrl += '/ajax/getCurrentProductPost.php';

    var dialog = new BootstrapDialog({
        title:'',
        cssClass:'cart-head',
        message:function (dialogRef) {
            var $message = $('<div>Loading...</div>');
            $.ajax({
                url:templateUrl,
                type:'POST',
                data:{'id':post_id },
                context:{
                    theDialogWeAreUsing:dialogRef
                },
                success:function (content) {
                    this.theDialogWeAreUsing.setMessage(content);
                }
            });
            return $message;
        }

    });
    dialog.open();


}

Share = {
    vkontakte:function () {
        var purl = location.href;
        var ptitle = $('.aj-pr-title').text();
        var pimg = $('.w-img-aj img').attr('src');
        var text = $('.wr-des-b').text();
        url = 'http://vkontakte.ru/share.php?';
        url += 'url=' + encodeURIComponent(purl);
        url += '&title=' + encodeURIComponent(ptitle);
        url += '&description=' + encodeURIComponent(text);
        url += '&image=' + encodeURIComponent(pimg);
        url += '&noparse=true';
        Share.popup(url);
    },
    twitter:function () {
        var purl = location.href;
        var ptitle = $('.aj-pr-title').text();
        var text = $('.wr-des-b').text();
        url = 'http://twitter.com/share?';
        url += 'text=' + encodeURIComponent(ptitle + ' ' + text);
        url += '&url=' + encodeURIComponent(purl);
        url += '&counturl=' + encodeURIComponent(purl);
        Share.popup(url);


    },
    /* odnoklassniki: function(purl, text) {
     url  = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1';
     url += '&st.comments=' + encodeURIComponent(text);
     url += '&st._surl='    + encodeURIComponent(purl);
     Share.popup(url);
     },
     facebook: function(purl, ptitle, pimg, text) {
     url  = 'http://www.facebook.com/sharer.php?s=100';
     url += '&p[title]='     + encodeURIComponent(ptitle);
     url += '&p[summary]='   + encodeURIComponent(text);
     url += '&p[url]='       + encodeURIComponent(purl);
     url += '&p[images][0]=' + encodeURIComponent(pimg);
     Share.popup(url);
     },
     twitter: function(purl, ptitle) {
     url  = 'http://twitter.com/share?';
     url += 'text='      + encodeURIComponent(ptitle);
     url += '&url='      + encodeURIComponent(purl);
     url += '&counturl=' + encodeURIComponent(purl);
     Share.popup(url);
     },
     mailru: function(purl, ptitle, pimg, text) {
     url  = 'http://connect.mail.ru/share?';
     url += 'url='          + encodeURIComponent(purl);
     url += '&title='       + encodeURIComponent(ptitle);
     url += '&description=' + encodeURIComponent(text);
     url += '&imageurl='    + encodeURIComponent(pimg);
     Share.popup(url)
     },
     */
    popup:function (url) {
        window.open(url, '', 'toolbar=0,status=0,width=626,height=436');
    }
};

/*Share = {
 *//**
 * Показать пользователю диалог шаринга в сооветствии с опциями
 * Метод для использования в inline-js в ссылках
 * При блокировке всплывающего окна подставит нужный адрес и ползволит браузеру перейти по нему
 *
 * @example <a href="" onclick="return share.go(this)">like+</a>
 *
 * @param Object _element - элемент DOM, для которого
 * @param Object _options - опции, все необязательны
 *//*
 go: function(_element, _options) {
 var
 self = Share,
 options = $.extend(
 {
 type:       'vk',    // тип соцсети
 url:        location.href,  // какую ссылку шарим
 count_url:  location.href,  // для какой ссылки крутим счётчик
 title:      $('.aj-pr-title').text(), // заголовок шаринга
 image:        $('.w-img-aj img').attr('src'),             // картинка шаринга
 text:       $('.wr-des-b').text(),             // текст шаринга
 },
 $(_element).data(), // Если параметры заданы в data, то читаем их
 _options            // Параметры из вызова метода имеют наивысший приоритет
 );

 if (self.popup(link = self[options.type](options)) === null) {
 // Если не удалось открыть попап
 if ( $(_element).is('a') ) {
 // Если это <a>, то подставляем адрес и просим браузер продолжить переход по ссылке
 $(_element).prop('href', link);
 return true;
 }
 else {
 // Если это не <a>, то пытаемся перейти по адресу
 location.href = link;
 return false;
 }
 }
 else {
 // Попап успешно открыт, просим браузер не продолжать обработку
 return false;
 }
 },

 // ВКонтакте
 vk: function(_options) {
 var options = $.extend({
 url:        location.href,  // какую ссылку шарим
 count_url:  location.href,  // для какой ссылки крутим счётчик
 title:      $('.aj-pr-title').text(), // заголовок шаринга
 image:        $('.w-img-aj img').attr('src'),             // картинка шаринга
 text:       $('.wr-des-b').text()           // текст шаринга
 }, _options);

 return 'http://vkontakte.ru/share.php?'
 + 'url='          + encodeURIComponent(options.url)
 + '&title='       + encodeURIComponent(options.title)
 + '&description=' + encodeURIComponent(options.text)
 + '&image='       + encodeURIComponent(options.image)
 + '&noparse=true';
 },

 // Одноклассники
 ok: function(_options) {
 var options = $.extend({
 url:    location.href,
 text:   '',
 }, _options);

 return 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1'
 + '&st.comments=' + encodeURIComponent(options.text)
 + '&st._surl='    + encodeURIComponent(options.url);
 },


 // Живой Журнал
 lj: function(_options) {
 var options = $.extend({
 url:    location.href,
 title:  document.title,
 text:   '',
 }, _options);

 return 'http://livejournal.com/update.bml?'
 + 'subject='        + encodeURIComponent(options.title)
 + '&event='         + encodeURIComponent(options.text + '<br/><a href="' + options.url + '">' + options.title + '</a>')
 + '&transform=1';
 },

 // Твиттер
 tw: function(_options) {
 var options = $.extend({
 url:        location.href,
 count_url:  location.href,
 title:       $('.aj-pr-title').text(),
 text:$('.wr-des-b').text()
 }, _options);

 return 'http://twitter.com/share?'
 + 'text='      + encodeURIComponent(options.title+options.text)
 + '&url='      + encodeURIComponent(options.url)
 + '&counturl=' + encodeURIComponent(options.count_url);
 },

 // Google+
 gg: function (_options) {
 var options = $.extend({
 url: location.href,
 title:      $('.aj-pr-title').text(), // заголовок шаринга
 image:        $('.w-img-aj img').attr('src'),
 }, _options);

 return 'https://plus.google.com/share?url='
 + encodeURIComponent(options.url)
 +encodeURIComponent(options.title);
 +encodeURIComponent(options.image);
 },

 // Mail.Ru
 mr: function(_options) {
 var options = $.extend({
 url:    location.href,
 title:  document.title,
 image:  '',
 text:   ''
 }, _options);

 return 'http://connect.mail.ru/share?'
 + 'url='          + encodeURIComponent(options.url)
 + '&title='       + encodeURIComponent(options.title)
 + '&description=' + encodeURIComponent(options.text)
 + '&imageurl='    + encodeURIComponent(options.image);
 },

 // Открыть окно шаринга
 popup: function(url) {
 return window.open(url,'','toolbar=0,status=0,scrollbars=1,width=626,height=436');
 }
 }
 $(document).on('click', '.social_share', function(){
 Share.go(this);
 });*/

function share() {
    var titleV = $('.aj-pr-title').text();
    console.log(titleV);
    $('.share').ShareLink({
        title:titleV,
        text:'SocialShare jQuery plugin for create share buttons and counters',
        image:'http://cdn.myanimelist.net/images/characters/3/27890.jpg',
        url:'http://www.morning-bakery.com.ua/blog/'
    });
    $('.counter').ShareCounter({
        url:'http://google.com/'
    });
}

function share() {
    FB.ui(
        {
            method:'feed',
            name:$('.aj-pr-title').text(),
            link:'http://morning-bakery.com.ua',
            description:$('.wr-des-b').text(),
            message:'',
            picture:$('.w-img-aj img').attr('src')
        });

}


/* function shareGoogle(){

 (function() {
 var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
 po.src = 'http://apis.google.com/js/client:plusone.js';
 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
 })();
 var options = {
 contenturl: '#',
 contentdeeplinkid: $('.w-img-aj img').attr('src'),
 clientid: '523648377771-0ler02do94qenemfsf2a8ltf3t1tcrp7.apps.googleusercontent.com',
 cookiepolicy: 'http://www.morning-bakery.com.ua',
 prefilltext: $('.wr-des-b').text(),
 calltoactionlabel: 'Open',
 calltoactionurl: 'http://www.morning-bakery.com.ua'
 };
 // Call the render method when appropriate within your app to display
 // the button.
 gapi.interactivepost.render('data', options);


 }*/


function setItemShop(itemID) {
    $('#shopMaker').show();
    var templateUrl = location.protocol + '//' + location.host;
    templateUrl += '/wp-content/themes/twentythirteen/shop_cart/ajax_SET_Update_cart.php';

    $.post(templateUrl, { 'itemID':itemID, action:'add'  },
        function (data) {

            var $objectItems = JSON.parse(data);
            var totalItem = $objectItems.totalItem;

            $('#sumItem').html('').append(totalItem);
            console.log($objectItems);

//            $('.icon-f.in-cart').click(function(){
//                showShopingCart(0);
//            });

        }
    );
}

function clearLocalStorage() {
    localStorage.clear();
}

$(document).ready(function () {

    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-66932076-1', 'auto');
    ga('send', 'pageview');

    var templateUrl = location.protocol + '//' + location.host;
    templateUrl += '/wp-content/themes/twentythirteen/ajax/login-dialog.php';
    var dialoguserLogin = new BootstrapDialog({
        title:'<h2>Вхід на morning-bakery.com.ua</h2>',
        message:$('<div></div>').load(templateUrl),
        cssClass:'dialog-login',
        animate:false
    });


    $('#shopMaker').on({
        'mouseenter':function () {
            $('#show-shop-cart-title').removeClass('hidden')
        }, 'mouseleave':function () {
            $('#show-shop-cart-title').addClass('hidden')
        }
    });

    $('#user-login-boot').click(function () {
        dialoguserLogin.open();

    });
//     localStorage.clear();
//    var masItem = localStorage.getItem('itemId');
//    var masPrice = localStorage.getItem('price');
//
//    if (masItem != null) {
//        var total = setTotalPrice();
//        var countItem = setTotalQuantityItem();
//        $('#shopMaker').removeClass('d-n-w').addClass('s-n-w');
//        setPriceCountTotalItem();
//        localStorage.setItem('countItem', JSON.stringify(countItem));
//    }


    // browser window scroll (in pixels) after which the "back to top" link is shown
    var offset = 300,
    //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
        offset_opacity = 1200,
    //duration of the top scrolling animation (in ms)
        scroll_top_duration = 700,
    //grab the "back to top" link
        $back_to_top = $('.cd-top');

    //hide or show the "back to top" link
    $(window).scroll(function () {
        ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
        if ($(this).scrollTop() > offset_opacity) {
            $back_to_top.addClass('cd-fade-out');
        }
    });

    //smooth scroll to top
    $back_to_top.on('click', function (event) {
        event.preventDefault();
        $('body,html').animate({
                scrollTop:0
            }, scroll_top_duration
        );
    });
});

function setAmountItem(count, id) {

    if (count == 0) {
        $('#shopHead #wr-tov' + id + ' .cart-amount input[name="quantity"]').val(parseFloat($('#shopHead #wr-tov' + id + ' .cart-amount input[name="quantity"]').val()) + 1);

    } else {
        if ($('#shopHead #wr-tov' + id + ' .cart-amount input[name="quantity"]').val() != 1) {
            $('#shopHead #wr-tov' + id + ' .cart-amount input[name="quantity"]').val($('#shopHead #wr-tov' + id + ' .cart-amount input[name="quantity"]').val() - 1);
        }

    }
    getPriceById(id).done(function (price) {
        $('#shopHead #wr-tov' + id + ' .sum-am-tot').html('').append((price * parseFloat($('#shopHead #wr-tov' + id + ' .cart-amount input[name="quantity"]').val())).toFixed(2) + ' грн');

    });
    var $el = $('#shopHead #wr-tov' + id + ' .cart-amount input[name="quantity"]');

    setInputItemQuantity('shopHead');

    setPriceCountTotalItem();
}
/*
 function onKeyDownCheck(){
 var $el = $('#wr-tov' + id + ' .cart-amount input[name="quantity"]');
 $el.onkeydown(function(){
 alert(1)
 });
 }
 onKeyDownCheck();*/


function getPriceById(id) {
    var templateUrl = "<?php bloginfo('template_directory') ?>";
    templateUrl += '/ajax/getPriceProdyctByItemId.php';
    return $.ajax({
        type:'POST',
        data:{'id':id},
        url:templateUrl
    });
}


function getIdItemLocalStorage(item) {
    var masItem = localStorage.getItem(item);
    if (masItem != null) {
        var total = 0;
        var i = 0;
        masItem = masItem.substring(1);
        masItem = masItem.substring(0, masItem.length - 1);
        masItem = masItem.split(',');
        return masItem;
    } else return false;
}

function saveDataToLocalStorage(data, price) {
    var arrayItem = getIdItemLocalStorage();

    var a;
    var tmp_price;
    //is anything in localstorage?
    if (localStorage.getItem('itemId') === null) {
        a = [];
        tmp_price = [];
    } else {
        // Parse the serialized data back into an array of objects
        a = JSON.parse(localStorage.getItem('itemId'));
        tmp_price = JSON.parse(localStorage.getItem('price'));
    }
    // Push the new data (whether it be an object or anything else) onto the array
    a.push(data);
    tmp_price.push(price);


    // Alert the array value
    // Re-serialize the array back into a string and store it in localStorage
    localStorage.setItem('itemId', JSON.stringify(a));
    localStorage.setItem('price', JSON.stringify(tmp_price));

}

function showShopingCart(btnType) {

    var templateUrl = location.protocol + '//' + location.host;
    templateUrl += '/wp-content/themes/twentythirteen/shop_cart/ajax_SET_Update_cart.php';

    var dialog = new BootstrapDialog({
        title:'Корзина',
        cssClass:'cart-head',
        animate:false,
        closable:false,
        onhide:function () {

            setSessionData();
            if ($('#products-append').length == 1) {
                getProductsForCart();
            }
        },
        buttons:[
            {
                label:'CloseCart',
                id:'closeCart',
                action:function (dialogRef) {
                    dialogRef.close();
                }
            }
        ],
        message:function (dialogRef) {
            var $message = $('<div>Завантаження...</div>');
            $.ajax({
                url:templateUrl,
                type:'POST',
                data:{'action':'getProducts' },
                context:{
                    theDialogWeAreUsing:dialogRef
                },
                success:function (data) {
                    var $objectItems = JSON.parse(data);
                    var totalItem = 0;


                    if ($objectItems != null && ($.isEmptyObject($objectItems.products)) !== true) { // якщо корзина не пуста
                        totalItem = $objectItems.totalItem;

                        var resLine = '<form action="/checkout" method="post"><div class="products-data main-box-body clearfix"><ul class="widget-products">';

                        var totalPriceObject = 0;


                        $.each($objectItems.sortArray, function (key, key_array) {

                            resLine += '<li><div href="#">' +
                                '<span class="deleteItem" id="delete-' + $objectItems.products[key_array].itemID + '"><i class="fa fa-times"></i></span>' +
                                '<span class="img">' + $objectItems.products[key_array].image + '</span><span class="product clearfix">' +
                                '<span class="name">' + $objectItems.products[key_array].title + '</span><span class="price">' + $objectItems.products[key_array].price + ' грн.</span>' +
                                '<span class="warranty form-inline"><a  class="cart-amount-minus" name="plus"><span class="sprite"></span></a>' +
                                '<input  name="quantity" id="quantity-' + $objectItems.products[key_array].itemID + '" type="text" class="input-text  cart-amount-input-text " value="' + +$objectItems.products[key_array].itemCount + '">' +
                                '<a class="cart-amount-plus" name="minus"><span class="sprite"></span></a>' +
                                '</span><span class="sum"> <span name="sum">' + ($objectItems.products[key_array].price * $objectItems.products[key_array].itemCount).toFixed(2) + '</span> грн.</span></span>' +
                                '</div></li>';
                            totalPriceObject = totalPriceObject + $objectItems.products[key_array].price * $objectItems.products[key_array].itemCount;
                        });


                        resLine += '</ul></div>';
                        resLine += '<div class="clearfix row"><div class="col-lg-12 ">' +
                            '<div class="col-lg-6" ></div><div  style="text-align: center" class="col-lg-6 p main-box infographic-box colored emerald-bg-yell"><p class="sum-total"><strong  class="pull-left">Всього:</strong>' +
                            '<span class="pull-right"><strong class="sum-tot">' + totalPriceObject.toFixed(2) + '</strong> грн.</span> </p>';
                        if (btnType == 'btn-in-cart') {
                            resLine += '<button type="button"  id="close-cart-continue" class="addOrder btn label-warning " >Оформити замовлення</button>';
                            resLine += '</div></div></form>';
                        } else {
                            resLine += '<button type="submit" class="addOrder btn label-warning " >Оформити замовлення</button>';
                            resLine += '</div><div class="clearfix continueShop"><a  id="close-cart-continue"  href="javascript:;" onclick="continueShop()" title="Продовжити покупки">Продовжити покупки</a></div></div>' +
                                '</div></form>';
                        }


                        this.theDialogWeAreUsing.setMessage(resLine);


                        $('.cart-amount-plus').click(function (el) {
                            addCartAmount(el);
                        });

                        $('.cart-amount-minus').click(function (el) {
                            minusCartAmount(el);
                        });

                        //*********************** check if good numbers*****************
                        $('.modal-body .widget-products input[name="quantity"]').bind("change keyup blur ", function () {
                            var currentCount = $(this).val();
                            var numberRegex = /^(1)$|^([1-9][0-9]*)$/;

                            var $el = $(this);

                            if (!numberRegex.test(currentCount) && $el.val() != "") {
                                $el.val(1)
                            }


                        });
                        $('.modal-body .widget-products input[name="quantity"]').blur(function () {
                            var $el = $(this);

                            if ($el.val() == "") {
                                $el.val(1)
                            }
                        });


                        //*************************set sum in table input["sum"]**********

                        $('.modal-body .widget-products input[name="quantity"]').bind("change paste keyup blur deleteItemShopCart", function () {
                            var curID = this.id;
                            curID = curID.replace('quantity-', '');

                            var currentPrice = $objectItems.products[curID]["price"];
                            $(this).parent().parent().find("span[name='sum']").html('').append((Number($(this).val()) * currentPrice).toFixed(2));
                            setSessionData();

                        });

                        //*************************delete item shop cart**********
                        $('.widget-products li .deleteItem').click(function (el) {
                            deleteItemShopCart(el);
                        });

                        $('#close-cart-continue').click(function () {
                            $('#closeCart').trigger('click');
                        })


                    } else {//якщо корзина пуста
                        this.theDialogWeAreUsing.setMessage('Корзина пуста');
                    }
                    dialog.setClosable(true);
                }
            });
            return $message;
        }

    });

    dialog.open();


}

function getProductsForCart() {

    var templateUrl = location.protocol + '//' + location.host;
    templateUrl += '/wp-content/themes/twentythirteen/shop_cart/ajax_SET_Update_cart.php';

    $.post(templateUrl, { 'action':"getProducts"  },
        function (data) {
            var $objectItems = JSON.parse(data);

            var res = '<ul class="widget-products">';
            $.each($objectItems.sortArray, function (key, key_array) {
                res += '<li><div><span class="img">' + $objectItems.products[key_array].image + '</span>' +
                    ' <span class="product clearfix"><span class="name">' + $objectItems.products[key_array].title + '</span>' +
                    ' <div class="col-lg-12 row"><span class="col-lg-6 row pull-left text-left">' + $objectItems.products[key_array].itemCount + ' шт.</span>' +
                    ' <span class="col-lg-6 pull-right text-right row">' + ($objectItems.products[key_array].itemCount * $objectItems.products[key_array].price).toFixed(2) + 'грн.</span> </div></li>';
            });
            res += '</ul>';
            res += '<div style="padding: 15px 0"   class="clearfix col-lg-12   sum-total" ><div class="col-lg-6   text-left">Всього:</div>' +
                '<div class="col-lg-6   text-right">' + ($objectItems.totalPrice).toFixed(2) + ' грн.</div></div> ';

            $('#makeCheckout #products-append').html('').append(res);


            var res_step2 = '<ul class="widget-products-check">';

            $.each($objectItems.sortArray, function (key, key_array) {

                res_step2 += '<li><div><span class="img">' + $objectItems.products[key_array].image + '</span>' +
                    '<span class="name-check">' + $objectItems.products[key_array].title + '</span>' +
                    '<span class="count-check">' + $objectItems.products[key_array].itemCount + ' шт.</span>' +
                    '<span class="total-check">' + ($objectItems.products[key_array].itemCount * $objectItems.products[key_array].price).toFixed(2) + ' грн.</span></div></li>';
            });
            res_step2 += '</ul>';

            console.log($objectItems);

            $('.total-list-product').html('').append(res_step2);
            $('#total-order-quantity').html('').append($objectItems.totalItem);
            $('#total-price-order').html('').append($objectItems.totalPrice);
            $('#price-delivery').html('').append($objectItems.deliveryPrice);

            var totalPriceAccept = (Number($objectItems.deliveryPrice) + Number($objectItems.totalPrice)).toFixed(2);

            $('#total-price-accept').html('').append(totalPriceAccept);
        }
    );
}

function addCartAmount(el) {

    var currentCount = Number($(el.currentTarget).prev().val());
    currentCount = currentCount + 1;
    $(el.currentTarget).prev().val(currentCount).trigger('change');
    setSessionData();
}


function minusCartAmount(el) {
    var currentCount = Number($(el.currentTarget).next().val());
    currentCount = currentCount - 1;
    $(el.currentTarget).next().val(currentCount).trigger('change');
    setSessionData();
}

function setSessionData() {
    var $array_quantity = {};

    $('.products-data li input[name="quantity"]').each(function () {
        var object = {};
        var curID = this.id;
        curID = curID.replace('quantity-', '');
        object.itemID = curID;
        object.itemCount = $(this).val();

        $array_quantity[curID] = object;
    });


//    if ($.isEmptyObject($array_quantity)== false){

    var templateUrl = location.protocol + '//' + location.host;
    templateUrl += '/wp-content/themes/twentythirteen/shop_cart/ajax_Update_cart.php';

    var res = JSON.stringify($array_quantity);

    $.post(templateUrl, { 'itemArray':res  },
        function (data) {

            var $objectItems = JSON.parse(data);


            if ($.isEmptyObject($objectItems) !== true) {
                var totalItem = $objectItems.totalItem;

                $('#sumItem').html('').append(totalItem);
                $('.sum-total strong.sum-tot').html('').append(($objectItems.totalPrice).toFixed(2));
            } else {
                $('#sumItem').html('').append(0);
            }


        }
    );
//    }else {
//
//    }

}


function continueShop() {
    $('.fancybox-skin .fancybox-close').trigger('click');
}

function setPriceCountTotalItem() {
    var totalPrice = setTotalPrice();
    $('#shopHead #total-price span').html('').append(totalPrice + ' грн');
    $('#priceItem span').html('').append(totalPrice);
    $('#sumItem').html('').append(setTotalQuantityItem());

}

function setInputItemQuantity(elementID) {
    var arrayOfInputQuantity = [];
    $('#' + elementID + ' .cart-amount input[name="quantity"]').each(function () {
        arrayOfInputQuantity.push(Number($(this).val()));
    });
    localStorage.setItem('arrayOfInputQuantity', JSON.stringify(arrayOfInputQuantity));
}

function setTotalPrice() {
    var i = 0;
    var arrPriceItem = getIdItemLocalStorage('price');
    var arrQuantity = getIdItemLocalStorage('arrayOfInputQuantity');
    var totalPrice = 0;
    for (i = 0; i < arrPriceItem.length; i++) {
        totalPrice = parseFloat(totalPrice + Number(arrPriceItem[i]) * Number(arrQuantity[i]));
    }
    return totalPrice.toFixed(2);
}

function setTotalQuantityItem() {
    var arrQuantity = getIdItemLocalStorage('arrayOfInputQuantity');
    var totalItem = 0;
    var i = 0;
    for (i = 0; i < arrQuantity.length; i++) {
        totalItem += parseInt(arrQuantity[i])
    }
    return  totalItem;

}

//function getSetTotalPrice(){
//    var templateUrl = location.protocol + '//' + location.host;
//    templateUrl += '/wp-content/themes/twentythirteen/shop_cart/ajax_SET_Update_cart.php';
//    $.post(templateUrl, { 'itemID':0  },
//        function (data) {
//            var totalPrice = 0;
//            var $objectItems = JSON.parse(data);
//
//            $.each($objectItems.products, function (key, value) {
//                totalPrice = totalPrice + value.price * value.itemCount;
//
//            });
//            totalPrice = totalPrice.toFixed(2);
//            $('.sum-total strong.sum-tot').html('').append(totalPrice)
//        }
//    );
//
//}

function deleteItemShopCart(el) {
//    setTimeout(function(){   }, 500);

    var itemID = $(el.currentTarget).attr("id");
    itemID = itemID.replace('delete-', '');

    $('#product-' + itemID).removeClass('in-cart').addClass('to-cart');

    var templateUrl = location.protocol + '//' + location.host;
    templateUrl += '/wp-content/themes/twentythirteen/shop_cart/ajax_SET_Update_cart.php';


    $.post(templateUrl, { 'itemID':itemID, 'action':'delete'  },
        function (data) {


            if ($('.modal-dialog .widget-products li').length == 0) {
                if ($('#closeCart').length == 1) {
                    $('#closeCart').trigger('click');
                }

                clearShopingCart();

            }
            setSessionData(); // вставляєм в сесію дані які залишились

        }
    );
    $(el.currentTarget).parent().parent().remove();

}

function clearShopingCart() {

    var templateUrl = location.protocol + '//' + location.host;
    templateUrl += '/wp-content/themes/twentythirteen/shop_cart/ajax_SET_Update_cart.php';


    $.post(templateUrl, { 'action':'clearAll'  },
        function (data) {

        }
    );
}

$('.in-cart').click(function () {
    var productID = $(this).attr('id');
    productID = productID.replace('product-', '');
    if ($(this).hasClass('in-cart')) {
        showShopingCart(1);
    } else {
        setItemShop(productID);
    }
    $(this).removeClass('to-cart').addClass('in-cart')

});

$('.to-cart').click(function () {

    var productID = $(this).attr('id');
    productID = productID.replace('product-', '');
    if ($(this).hasClass('in-cart')) {
        showShopingCart(1);
    } else {
        setItemShop(productID);
    }
    $(this).removeClass('to-cart').addClass('in-cart')

});

function send_order() {

    var type_order = $('#accept-order-btn').data('select-order-ex');

    $('#accept-order-btn').prop('disabled', true);

    if (type_order == 'single') { // if single order

        var templateUrl = location.protocol + '//' + location.host;
        templateUrl += '/wp-content/themes/twentythirteen/shop_cart/ajax_SET_Update_cart.php';
        var type_payment = $('input[name="payment-radio"]:checked').data('payment'); //type pf payment (private24) (cash)

        $.post(templateUrl, { 'action':"getProducts"  },
            function (data) {
                var $objectItems = JSON.parse(data);
                console.log($objectItems);

                ///////////////////////////GET FORM DATA////////////////////////////////////////
                var startTime = $('#order-time-picker-single .start').timepicker('getTime');
                var endTime = $('#order-time-picker-single .end').timepicker('getTime');
//                var date = $('#single-date-select').datepicker('getTime');
                var date = $.datepicker.formatDate("yy/mm/dd", $('#single-date-select').datepicker('getDate'));


                var address = $('#select-single-order-val select').val();
                var action_with_address = 'add-exist-address';
                if (address == 'new') {
                    if (($('input[name="street-value-single"]').val() != '' && $('input[name="build-value-single"]').val() != '' && $('input[name="flat-value-single"]').val() != ''  )) {
                        address = $('#street-value-single').val() + ', ' + $('#build-value-single').val() + ' кв.' + $('#flat-value-single').val();
                        action_with_address = 'add-new-address';
                    }
                } else if (($('input[name="street-value-single"]').val() != '' && $('input[name="build-value-single"]').val() != '' && $('input[name="flat-value-single"]').val() != ''  )) {
                    address = $('#street-value-single').val() + ', ' + $('#build-value-single').val() + ' кв.' + $('#flat-value-single').val();
                    action_with_address = 'add-new-address';
                }
                var templateUrl = "<?php bloginfo('template_directory') ?>";
                templateUrl += '/ajax/createOrders.php';

                $.ajax({
                    url:templateUrl,
                    type:'POST',
                    data:{'action':'single-orders', 'type_payment':type_payment, 'cheked_inputs':JSON.stringify($objectItems), 'userID':$('#userId').val(), 'date':date,
                        'startTime':moment(startTime).format("HH:mm:ss"), 'endTime':moment(endTime).format("HH:mm:ss"), 'address-order':address, 'action_with_address':action_with_address,
                        'phone':$('#user_phone').val()},

                    success:function (invoice_object) {
                        var $invoice_object = JSON.parse(invoice_object);

                        if ($invoice_object.type_payment == 'private24') {
                            if ($invoice_object.order > 1) {
                                var privateForm = '<form id="form-private-24-ok" class="hide" action="https://api.privatbank.ua/p24api/ishop" method="POST" accept-charset="UTF-8">';

                                privateForm += ' <input type="text" name="amt" value="' + $invoice_object.private24.amt + '"/>' +
                                    '<input type="text" name="ccy" value="' + $invoice_object.private24.ccy + '" />' +
                                    '<input type="hidden" name="merchant" value="' + $invoice_object.private24.merchant + '" />' +
                                    '<input type="hidden" name="order" value="' + $invoice_object.private24.order + '" />' +
                                    '<input type="hidden" name="details" value="' + $invoice_object.private24.details + '" />' +
                                    '<input type="hidden" name="ext_details" value="' + $invoice_object.private24.ext_details + '" />' +
                                    '<input type="hidden" name="pay_way" value="' + $invoice_object.private24.pay_way + '" />' +
                                    '<input type="hidden" name="return_url" value="' + $invoice_object.private24.return_url + '" />' +
                                    '<input type="hidden" name="server_url" value="' + $invoice_object.private24.server_url + '" />' +
                                    '<input type="hidden" name="signature" value="' + $invoice_object.private24.signature + '" />' +
                                    '<input type="submit" id="send-private24-btn" value="Оплатить" />';

                                privateForm += '</form>';

                                $('#accept-order-btn').after(privateForm);
                                $('#send-private24-btn').trigger('click');
                            }

                        } else {
                            if ($invoice_object.order > 1) {
                                BootstrapDialog.show({
                                    title:"Ваше замовлення №" + $invoice_object.order + " було успішно сформовано. Найближчим часом ми зв'яжемось з Вами!",
                                    closable:false,
                                    animate:false,
                                    buttons:[
                                        {
                                            label:'OK',
                                            cssClass:'btn btn-success',
                                            action:function (dialog) {
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
                                            }
                                        }
                                    ],
                                    cssClass:'inform-dialog'

                                });
                            } else {
                                BootstrapDialog.show({
                                    message:"Помилка при оформленні замовлення"
                                });
                            }

                        }
                        console.log($invoice_object)
                    }
                });


            }
        );


    } else if (type_order == 'multiple') { //if multiple order
        var templateUrl = "<?php bloginfo('template_directory') ?>";
        templateUrl += '/ajax/createOrders.php';


        var type_payment = $('input[name="payment-radio-multiple"]:checked').data('payment'); //type pf payment (private24) (cash)


        // add into db events which are not accepted
        var clients_object_events = {};
        var a = $('#calendar').fullCalendar('clientEvents', function (e) {
            if (!($.inArray('not-accept-event', e.className))) {
                var $object_tmp = {};
                $object_tmp.id = e.id;
                clients_object_events[e.id] = $object_tmp;

            }
        });
        var json_data = JSON.stringify(clients_object_events);

        $.ajax({
            url:templateUrl,
            type:'POST',
            data:{'action':'multiple-orders-payment', 'type_payment':type_payment, 'json_data':json_data, 'userID':$('#userId').val(), 'phone':$('#user_phone').val()},

            success:function (invoice_object) {
                var $invoice_object = JSON.parse(invoice_object);
                console.log($invoice_object);
                if ($invoice_object.type_payment == 'private24') {

                    if ($invoice_object.order) {
                        var privateForm = '<form id="form-private-24-ok" class="hide" action="https://api.privatbank.ua/p24api/ishop" method="POST" accept-charset="UTF-8">';

                        privateForm += ' <input type="text" name="amt" value="' + $invoice_object.private24.amt + '"/>' +
                            '<input type="text" name="ccy" value="' + $invoice_object.private24.ccy + '" />' +
                            '<input type="hidden" name="merchant" value="' + $invoice_object.private24.merchant + '" />' +
                            '<input type="hidden" name="order" value="' + $invoice_object.private24.order + '" />' +
                            '<input type="hidden" name="details" value="' + $invoice_object.private24.details + '" />' +
                            '<input type="hidden" name="ext_details" value="' + $invoice_object.private24.ext_details + '" />' +
                            '<input type="hidden" name="pay_way" value="' + $invoice_object.private24.pay_way + '" />' +
                            '<input type="hidden" name="return_url" value="' + $invoice_object.private24.return_url + '" />' +
                            '<input type="hidden" name="server_url" value="' + $invoice_object.private24.server_url + '" />' +
                            '<input type="hidden" name="signature" value="' + $invoice_object.private24.signature + '" />' +
                            '<input type="submit" id="send-private24-btn" value="Оплатить" />';

                        privateForm += '</form>';

                        $('#accept-order-btn').after(privateForm);
                        $('#send-private24-btn').trigger('click');
                    }

                } else {
                    if ($invoice_object.order) {
                        BootstrapDialog.show({
                            title:"Ваші замовлення №" + $invoice_object.order + " було успішно сформовано. Найближчим часом ми зв'яжемось з Вами!",
                            closable:false,
                            animate:false,
                            buttons:[
                                {
                                    label:'OK',
                                    cssClass:'btn btn-success',
                                    action:function (dialog) {
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
                                    }
                                }
                            ],
                            cssClass:'inform-dialog'

                        });
                    } else {
                        BootstrapDialog.show({
                            message:"Помилка при оформленні замовлення"
                        });
                    }

                }
            }
        });
    }

}

$('#send-data-order').on('submit', function (e) {

    warning_notification_before_submit_order();

    e.preventDefault();

});


</script>

<script>

$(document).ready(function () {
    getProductsForCart();

    var nowTemp = new Date();
    var now = new Date(new Date(new Date().getTime()));


    var tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);

    var endTime2 = moment('8:00pm', 'h:mma'); // max time for order
    var startTime2 = moment();


    if (!(startTime2.isBefore(endTime2))) { // if time is before 20:00
        var date = new Date();
        now = date.setDate(date.getDate() + 1);

        tomorrow.setDate(tomorrow.getDate() + 1);
    }


    $('#single-date-select').datepicker({
        format:'dd/mm/yyyy',
        beforeShowDay:function (date) {

            return date.valueOf() >= now.valueOf();
        }

    });
//    $('#single-date-select').datepicker("update", new Date());


    $('#single-date-select').datepicker("update", tomorrow);
    $('#single-date-select').keydown(function (e) {
        e.preventDefault();
        return false;
    });

    $('#payment-wrap label').click(function () {
        $('#payment-wrap label.active').removeClass('active');
        if ($(this).hasClass('active')) {
            $(this).removeClass('active')
        } else {
            $(this).addClass('active');
        }
    });


    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href");
        if ((target == '#tab-week-order')) {
            $('.help-block-p').addClass('hide');
            var row = '<div class="form-inline col-lg-12 payment-wrap " id="payment-wrap-multiple">' +
                '<div class="form-inline col-xs-12">' +
                '<div class="form-group col-xs-12">' +
                '<label for="banknot-payment-radio-multiple" class="active"><i class="sprite banknot-payment"></i><span>Оплата готівкою при отриманні</span></label>' +
                '<input type="radio" name="payment-radio-multiple" data-payment="cash" class="hide" checked="checked" id="banknot-payment-radio-multiple">' +
                '</div>' +
                '<div class="form-group col-xs-12">' +
                '<label for="private-24-radio-multiple"><i class="sprite private-24-payment"></i><span> Оплата карткою приват 24</span> </label>' +
                '<input type="radio" class="hide" data-payment="private24" name="payment-radio-multiple" id="private-24-radio-multiple">' +
                '</div>' +
                '</div>' +
                '</div>';

            $('#total-order-prepend').html('').append(row);
            $('#payment-wrap-multiple label').click(function () {
                $('#payment-wrap-multiple label.active').removeClass('active');
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active')
                } else {
                    $(this).addClass('active');
                }
            });
            showCalendar();
            getEventsTotalPrice();

            $('#accept-order-btn').data('select-order-ex', 'multiple');


        } else {
            $('#total-order-prepend').html('');
//            $('#accept-order-btn').prop("disabled", false);
            getProductsForCart();

            var startTime = $('#order-time-picker-single').find('.start').val();
            var endTime = $('#order-time-picker-single').find('.end').val();

            if (startTime != '' && endTime != '' && (($('#street-value-single').val() != '' && $('#build-value-single').val() != '' && $('#flat-value-single').val() != '') || ($('#select-single-order-val select').val() != null && $('#select-single-order-val select').val() != 'new' ) )) {
                $('#accept-order-btn').prop("disabled", false);
            } else {
                $('#accept-order-btn').prop("disabled", true);
            }
            $('#accept-order-btn').data('select-order-ex', 'single');
            check_error();

        }
    });


    $('#userInformation button[type="submit"]').click(function () {
        var $formUser = $('#userInformation form');

        if ($formUser.valid() == true) {

            $('#first-step-valid').addClass('hide');
            $('#hide-first-step').removeClass('hide');
            $('#show-step-2').removeClass('hide');
            $('.hidden-order-step').removeClass('hidden-order-step');
            $('#userInformation h3').addClass('hidden-ok-step');

            $formUser.on('submit', function (e) {
                // validation code here
                e.preventDefault();
            });

        } else {

        }
    });
    $('#hide-first-step').click(function () {
        $(this).addClass('hide');
        $('.hidden-ok-step').removeClass('hidden-ok-step');
        $('#first-step-valid').removeClass('hide');
        $('#step-2-wrap h3').addClass('hidden-order-step');
        $('#show-step-2').addClass('hide');
    });

    $('#date-time-order').datetimepicker({
        inline:true

    });
    addSingleOrderAddressTime();

});


function addSingleOrderAddressTime() {
    if ($('#cart-page').length > 0 || $('#calendar').length > 0) {


        var addresse_url = "<?php bloginfo('template_directory') ?>";
        addresse_url += '/ajax/ajax_get_user_addresses.php';

        $.ajax({
            url:addresse_url,
            type:'POST',
            data:{'userID':$('#userId').val()},
            success:function (addresses) {
                console.log(addresses);

                var $objectAddresses = JSON.parse(addresses);
                console.log($objectAddresses);
                var addbuilding = '';
                if ($.isEmptyObject($objectAddresses) !== true) {
                    $('#select-single-order-val').removeClass('hide');
                    var resLine = '';

                    $.each($objectAddresses, function (key, value) {
                        resLine += '<option value="' + value.value + '">' + value.address + '</option>';
                    });
                    resLine += '<option value="new">додати іншу адресу...</option>';
                    $('#select-single-order-val select').html('').append(resLine);

                } else {
                    $('#select-value-for-address-div-single').removeClass('hide');
                }

                $('#select-single-order-val select').on('change', function (e) {
                    var selected_value = this.value;
                    if (selected_value == 'new') {
                        $('#select-value-for-address-div-single').removeClass('hide');

                    } else {
                        $('#select-value-for-address-div-single').addClass('hide');
                    }


                });
            }
        });
        check_error();


        $('#order-time-picker-single .time').timepicker({
            'showDuration':true,
            'timeFormat':'G:i',
            'minTime':'08:00:00',
            'maxTime':'14:00:00'
        });
        $('#order-time-picker-single .end').prop('disabled', true);


//        if (moment(moment().format("MM-DD-YYYY")).isSame(moment($('#single-date-select ').datepicker("getDate")).format("MM-DD-YYYY"))) {
//            $('#order-time-picker-single .time').timepicker({
//                'showDuration':true,
//                'timeFormat':'G:i',
//                'minTime':moment().add(1, 'hours').format('HH:mm:ss'),
//                'maxTime':'20:00:00'
//            });
//        }


        $('#order-time-picker-single .time').on('changeTime', function () {
//        $('#onselectTarget').text($(this).val());
            $('#order-time-picker-single .end').prop('disabled', false);
        });
//        $('#single-date-select').on('change', function () {
//            if (!moment(moment().format("MM-DD-YYYY")).isSame(moment($('#single-date-select ').datepicker("getDate")).format("MM-DD-YYYY"))) {
//                $('#order-time-picker-single .time').timepicker('remove');
//                $('#order-time-picker-single .time').timepicker({
//                    'showDuration':true,
//                    'timeFormat':'G:i',
//                    'minTime':'08:00:00',
//                    'maxTime':'14:00:00'
//                });
//            } else {
//                $('#order-time-picker-single .time').timepicker('remove');
//                $('#order-time-picker-single .time').timepicker({
//                    'showDuration':true,
//                    'timeFormat':'G:i',
//                    'minTime':moment().add(1, 'hours').format('HH:mm:ss'),
//                    'maxTime':'20:00:00'
//                });
//            }
//        });


        var timeOnlyExampleEl = document.getElementById('order-time-picker-single');
        var timeOnlyDatepair = new Datepair(timeOnlyExampleEl);
        //end inicialize

        $('#order-time-picker-single .time').keydown(function (e) {
            e.preventDefault();
            return false;
        });

        var startTime = '';
        var endTime = '';

        $('#order-time-picker-single ').on('rangeSelected', function (e) {
            startTime = $(this).find('.start').val();
            endTime = $(this).find('.end').val();
            check_error();
            if (startTime != '' && endTime != '' && (($('#street-value-single').val() != '' && $('#build-value-single').val() != '' && $('#flat-value-single').val() != '') || ($('#select-single-order-val select').val() != null && $('#select-single-order-val select').val() != 'new' ) )) {
                $('#accept-order-btn').prop("disabled", false);
            } else {
                $('#accept-order-btn').prop("disabled", true);
            }

            // do something with milliseconds value
        });

        $('#select-single-order-val select').on('change', function (e) {
            check_error();
            if (startTime != '' && endTime != '' && (($('#street-value-single').val() != '' && $('#build-value-single').val() != '' && $('#flat-value-single').val() != '') || ($('#select-single-order-val select').val() != null && $('#select-single-order-val select').val() != 'new' ) )) {
                $('#accept-order-btn').prop("disabled", false);
            } else {
                $('#accept-order-btn').prop("disabled", true);
            }
        });

        $('#single-order-wrap input[name="flat-value-single"]').bind("change keyup ", function () {
            var currentCount = $(this).val();
            var numberRegex = /^(1)$|^([1-9][0-9]*)$/;

            var $el = $(this);

            if (!numberRegex.test(currentCount) && $el.val() != "") {
                $el.val(1)
            }


        });
        $('#single-order-wrap input[name="flat-value-single"], #single-order-wrap input[name="build-value-single"], #single-order-wrap input[name="street-value-single"]').bind("change keyup ", function () {
            check_error();
            if (startTime != '' && endTime != '' && (($('#street-value-single').val() != '' && $('#build-value-single').val() != '' && $('#flat-value-single').val() != '') || ($('#select-single-order-val select').val() != null && $('#select-single-order-val select').val() != 'new' ) )) {
                $('#accept-order-btn').prop("disabled", false);
                $('#single-order-wrap').find('.error').removeClass('error')
            } else {

                $('#accept-order-btn').prop("disabled", true);
            }
        });

    }

}
function check_error() {

    $('#single-order-wrap .form-control').each(function () {
        if ($(this).val() == '') {
            $(this).addClass('error');
        } else {
            $(this).removeClass('error')
        }
    });
    if (($('#select-single-order-val select').val() != 'new') === false || $('#select-single-order-val select option').length < 1) {
        if ($('.error').length > 0) {
            $('.help-block-p').removeClass('hide');
        } else $('.help-block-p').addClass('hide');
    }


}

// accept orders
function acceptOrder() {
    // add into db events which are not accepted
    var clients_object_events = {};
    var a = $('#calendar').fullCalendar('clientEvents', function (e) {
        if (!($.inArray('not-accept-event', e.className))) {
            var $object_tmp = {};
            $object_tmp.id = e.id;
            clients_object_events[e.id] = $object_tmp;

        }
    });
    var json_data = JSON.stringify(clients_object_events);

    var templateUrl = "<?php bloginfo('template_directory') ?>";
    templateUrl += '/ajax/ajax_calendar_events.php';

    if ($.isEmptyObject(clients_object_events) !== true) {
        $.ajax({
            url:templateUrl,
            type:'POST',
            data:{'action':'update_client_event', 'json_update':json_data },
            success:function (content) {

                console.log(content);
                $('#calendar').fullCalendar('removeEvents');
                $('#calendar').fullCalendar('refetchEvents');
            }
        });
    }
    //end add events

}

function showCalendar() {

    var events_utl = "<?php bloginfo('template_directory') ?>";
    events_utl += '/ajax/ajax_calendar_events.php';

    var total_dialog;

    var cal = $('#calendar').fullCalendar({
        header:{
            left:'prev,next',
            center:'title',
            right:''
        },
//        viewRender:function (currentView) { // only 2 weel
//            var minDate = moment(),
//                maxDate = moment().add(2, 'weeks');
//            // Past
//            if (minDate >= currentView.start && minDate <= currentView.end) {
//                $(".fc-prev-button").prop('disabled', true);
//                $(".fc-prev-button").addClass('fc-state-disabled');
//            }
//            else {
//                $(".fc-prev-button").removeClass('fc-state-disabled');
//                $(".fc-prev-button").prop('disabled', false);
//            }
//            // Future
//            if (maxDate >= currentView.start && maxDate <= currentView.end) {
//                $(".fc-next-button").prop('disabled', true);
//                $(".fc-next-button").addClass('fc-state-disabled');
//            } else {
//                $(".fc-next-button").removeClass('fc-state-disabled');
//                $(".fc-next-button").prop('disabled', false);
//            }
//        },
        lang:"uk",
        defaultDate:moment().format(),
        monthNames:['Січень', 'Лютий', 'Березень', 'Квітень', 'Травень', 'Червень', 'Липень', 'Серпень', 'Вересень', 'Жовтень', 'Листопад', 'Грудень'],
        monthNamesShort:['Січ.', 'Лют.', 'Бер', 'Квіт.', 'Трав', 'Черв', 'Лип', 'Серп.', 'Верс.', 'Жовт.', 'Лстп.', 'Грд.'],
        dayNames:["Неділя", "Понеділок", "Вівторок", "Середа", "Четвер", "П'ятниця", "Субота"],
        dayNamesShort:["НД", "ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ"],
        defaultView:'month',
        editable:false,
        minTime:"06:00:00",
        maxTime:"21:00:00",
        axisFormat:"H:mm",
        firstDay:moment().day(),
        columnFormat:"ddd",
        allDaySlot:false,
        selectable:true,
        draggable:false,
        events:{
            url:events_utl,
            data:{'userID':$('#userId').val()},
            type:'POST', // Send post data
            error:function () {

            },
            color:'#00C230',
            className:"not-accept-order"

        },
        eventRender:function (event, element) {
            element.click(function () {

                var invoiceID = event.id;

                var templateUrl = "<?php bloginfo('template_directory') ?>";
                templateUrl += '/ajax/ajax_get_invoice_by_id.php';
                //******************************************// if new event*********************************************
                if (!($.inArray('not-accept-event', event.className))) {
                    var url_ajax_get_order_by_id = "<?php bloginfo('template_directory') ?>";
                    url_ajax_get_order_by_id += '/ajax/ajax_get_tmp_order_by_ID_for_edit.php';


                    var edit_dialog = new BootstrapDialog({
                        title:'Виберіть товари, та вкажіть їхню кількість і час доставки <p id="time-order-edit"></p>',
                        cssClass:'cart-head enable-footer',
                        buttons:[
                            {
                                label:'Редагувати',
                                cssClass:'btn btn-success',
                                id:'add-day-order-db',
                                action:function (dialog) {
                                    dialog.getButton('add-day-order-db').disable();
                                    var $check_object = {};
                                    $('.cart-head.enable-footer input[type="checkbox"]').each(function () {
                                        var $tmp_object = {};
                                        var item_quantity = $(this).parents('tr').find('input[name="quantity_number"]').val();
                                        $tmp_object.itemID = this.id;
                                        $tmp_object.count = item_quantity;
                                        if ($(this).is(':checked')) {
                                            $tmp_object.active = 1;
                                        } else {
                                            $tmp_object.active = 0;
                                        }
                                        $check_object[this.id] = $tmp_object;
                                    });
                                    var checked_inputs = JSON.stringify($check_object);

                                    if ($.isEmptyObject($check_object) !== true) {//not empty calendar order to one day
                                        //add to DB
                                        var templateUrl = "<?php bloginfo('template_directory') ?>";
                                        templateUrl += '/ajax/createOrders.php';

                                        var startTime = $('#order-time-picker .start').timepicker('getTime');
                                        var endTime = $('#order-time-picker .end').timepicker('getTime');

                                        var address_order = '';
                                        var action_with_address = '';
                                        if ($('#street-value').length > 0 && ($('#street-value').val() != '' && $('#build-value').val() != '' && $('#flat-value').val() != ''  )) {
                                            address_order = $('#street-value').val() + ', ' + $('#build-value').val() + ' кв.' + $('#flat-value').val();
                                            action_with_address = 'add-new-address';
                                        } else {
                                            address_order = $('#select-order-addr select').val();
                                            action_with_address = 'add-exist-address';
                                        }

                                        $.ajax({
                                            url:templateUrl,
                                            type:'POST',
                                            data:{'action':'edit-invoice', 'invoiceID':invoiceID, 'cheked_inputs_edit':checked_inputs, 'userID':$('#userId').val(),
                                                'startTime':moment(startTime).format("HH:mm:ss"), 'endTime':moment(endTime).format("HH:mm:ss"), 'action_with_address':action_with_address, 'address_order':address_order},

                                            success:function (data) {

                                                var $invoice_object = JSON.parse(data);


                                                event.title = $invoice_object.totalPrice;

                                                $('#calendar').fullCalendar('updateEvent', event);
                                                getEventsTotalPrice();
                                                dialog.close();
                                            }
                                        });
                                    }
                                    $('#accept-order-btn').removeAttr('disabled');

                                }
                            },
                            {
                                label:'Відмінити',
                                cssClass:'btn btn-close',
                                action:function (dialog) {
                                    dialog.close();
                                }
                            },
                            {
                                label:'Видалити замовлення',
                                id:'delete-order-btn',
                                cssClass:'btn btn-danger hide',
                                action:function (dialog) {
                                    $('#calendar').fullCalendar('removeEvents', event.id);
                                    $('#calendar').fullCalendar('refetchEvents');

                                    var url_del = "<?php bloginfo('template_directory') ?>";
                                    url_del += '/ajax/ajax_calendar_events.php';
                                    $.ajax({
                                        url:url_del,
                                        type:'POST',
                                        data:{'action':'deleteEvent', 'delete-event':event.id },
                                        success:function (content) {
                                            console.log(content);
                                            dialog.close();

                                            getEventsTotalPrice();
                                        }
                                    });

                                }
                            }
                        ],
                        onshown:function () {

                            var addresse_url = "<?php bloginfo('template_directory') ?>";
                            addresse_url += '/ajax/ajax_get_user_addresses.php';

                            $.ajax({
                                url:addresse_url,
                                type:'POST',
                                data:{'userID':$('#userId').val(), 'eventID':event.id},
                                success:function (addresses) {
                                    var $objectAddresses = JSON.parse(addresses);
                                    console.log($objectAddresses)
                                    if ($.isEmptyObject($objectAddresses) !== true) {

                                        var resLine = '';

                                        $.each($objectAddresses, function (key, value) {
                                            if (value.current == 1) {
                                                resLine += '<option value="' + value.value + '" selected>' + value.address + '</option>';
                                            } else {
                                                resLine += '<option value="' + value.value + '">' + value.address + '</option>';

                                            }
                                        });
                                        resLine += '<option value="new">додати іншу адресу...</option>';
                                        $('#select-value-for-address').append(resLine);
                                        $('#select-order-addr select').on('change', function (e) {
                                            var selected_value = this.value;
                                            if (selected_value == 'new') {
                                                $('#select-value-for-address-div').removeClass('hide');

                                            } else {
                                                $('#select-value-for-address-div').addClass('hide');
                                            }

                                        });


                                    }
                                }
                            });
                        },
                        message:function (dialogRef) {
                            var $message = $('<div>Loading...</div>');

                            $.ajax({
                                url:url_ajax_get_order_by_id,
                                type:'POST',
                                data:{'invoiceID':invoiceID },
                                context:{
                                    theDialogWeAreUsing:dialogRef
                                },
                                success:function (content) {
                                    var $objectItems = JSON.parse(content);

                                    console.log($objectItems);
                                    var resLine = '<div id="get-all-products-cart"><table><thead><tr>' +
                                        '<th style="width: 10%"></th>' +
                                        '<th style="width: 60%"></th>' +
                                        '<th style="width: 15%"></th>' +
                                        '<th style="width: 10%"></th>' +
                                        '<th style="width: 5%"></th>' +
                                        '</tr></thead><tbody>';
                                    var total_price = 0;
                                    $.each($objectItems.products, function (key, value) {

                                        resLine += '<tr>' +
                                            '<td>' + value.image + '</td>' +
                                            '<td><span>' + value.title + '</span></td>' +
                                            '<td><span>' + value.price + ' грн.</span></td>';

                                        if (value.status == 1) {
                                            total_price += value.itemCount * value.price;
                                            resLine +=
                                                '<td><input type="text" class="form-control" name="quantity_number" value="' + value.itemCount + '" required></td>' +
                                                    '<td><div class="checkbox-nice checkbox-inline"><input type="checkbox" checked id="' + value.itemID + '">' +
                                                    '<label for="' + value.itemID + '"></label></div></td>' +
                                                    '</tr>';
                                        } else {
                                            resLine +=
                                                '<td><input type="text" class="form-control" name="quantity_number" value="1" required></td>' +
                                                    '<td><div class="checkbox-nice checkbox-inline"><input type="checkbox" id="' + value.itemID + '">' +
                                                    '<label for="' + value.itemID + '"></label></div></td>' +
                                                    '</tr>';
                                        }

                                    });
                                    resLine += '</tbody></table></div>' +
                                        '<div class="main-box"> <div class="main-box-body form-horizontal"><div class="form-group"><label style="color: #000; padding-top: 10px;" class="col-lg-3 control-label">Вкажіть час доставки:</label>' +
                                        '<div class="form-inline col-lg-9 " id="order-time-picker">' +
                                        'з <label class="col-lg-3 input-group input-append bootstrap-timepicker"><span class="add-on input-group-addon"><i class="fa fa-clock-o"></i></span><input  type="text" class="form-control time start ui-timepicker-input" value="' + $objectItems.startTime + '" autocomplete="off"></label> до' +
                                        '<label class="col-lg-3 input-group input-append bootstrap-timepicker"><span class="add-on input-group-addon"><i class="fa fa-clock-o"></i></span><input type="text" value="' + $objectItems.endTime + '" class="form-control time end ui-timepicker-input" autocomplete="off"></label>' +
                                        '</div></div>' +
                                        '<div id="select-order-addr" class="form-group"><label style="color: #000; padding-top: 10px;" class="col-lg-3 control-label">Адреса доставки:</label>' +
                                        '<div class="form-inline col-lg-9  ">' +
                                        '<select id="select-value-for-address" style="width: 100%" class="form-control"></select>' +
                                        '<div id="select-value-for-address-div" class="hide"><div class="input-group col-lg-8"><input class="form-control" type="text" id="street-value"/><span class="help-block">вулиця</span></div>' +
                                        '<div class="input-group col-lg-2"><input class="form-control" type="text" id="build-value"/><span class="help-block">будинок</span></div>' +
                                        '<div class="input-group col-lg-2"><input class="form-control" name="flat-value" type="text" id="flat-value"/><span class="help-block">квартира</span></div>' +
                                        '</div></div>' +
                                        '</div></div></div>' +
                                        '<div class="main-box"><div  class="clearfix col-lg-12   sum-total"><div class="col-lg-6   text-left">Всього:</div><div class="col-lg-6 text-right"><span id="calendar-total-price">' + total_price.toFixed(2) + '</span> грн.</div></div></div>';

                                    $('#time-order-edit').html('').append(moment(event.start).locale('ua').format('dddd, MMMM D, YYYY'));
                                    this.theDialogWeAreUsing.setMessage(resLine);

                                    $('#get-all-products-cart').height($(window).height() / 2);

                                    $('#order-time-picker .time').timepicker({
                                        'showDuration':true,
                                        'timeFormat':'G:i',
                                        'minTime':'8:00:00',
                                        'maxTime':'20:00:00'
                                    });


                                    var timeOnlyExampleEl = document.getElementById('order-time-picker');
                                    var timeOnlyDatepair = new Datepair(timeOnlyExampleEl);
                                    //end inicialize

                                    $('#order-time-picker .time').keydown(function (e) {
                                        e.preventDefault();
                                        return false;
                                    });

                                    $('.bootstrap-dialog-message table td input[type="checkbox"]').click(function () {

                                        getTotalPriceForCalendarDay($objectItems.products, dialogRef);

                                    });


                                    $('.bootstrap-dialog-message table td input[name="quantity_number"]').bind("change keyup ", function () {
                                        var currentCount = $(this).val();
                                        var numberRegex = /^(1)$|^([1-9][0-9]*)$/;

                                        var $el = $(this);

                                        if (!numberRegex.test(currentCount) && $el.val() != "") {
                                            $el.val(1)
                                        }

                                        getTotalPriceForCalendarDay($objectItems.products, dialogRef);

                                    });
                                }
                            });
                            return $message;

                        }


                    });
                    edit_dialog.open();
                    //*********************************************************** end show new event**************************************************
                } else { //if accepted event
                    var dialog = new BootstrapDialog({
                        title:'',
                        cssClass:'cart-head enable-footer success-orders',
                        buttons:[
                            {
                                label:'Закрити',
                                cssClass:'btn btn-close',
                                action:function (dialog) {
                                    dialog.close();
                                }
                            }
                        ],
                        message:function (dialogInvoice) {
                            var $message = $('<div>Loading...</div>');

                            // if accepted event
                            $.ajax({
                                url:templateUrl,
                                type:'POST',
                                data:{'invoiceID':invoiceID},
                                context:{
                                    theDialogWeAreUsing:dialogInvoice
                                },
                                success:function (content) {
                                    var $object_invoice = JSON.parse(content);
                                    console.log($object_invoice);

                                    var res_line = '<table><thead><tr>' +
                                        '<th style="width: 10%"></th>' +
                                        '<th style="width: 40%">Назва</th>' +
                                        '<th style="width: 10%">Ціна</th>' +
                                        '<th style="width: 10%">К-ть</th>' +
                                        '<th style="width: 10%">Сума</th>' +

                                        '</tr>';
                                    var total_price = 0;
                                    $.each($object_invoice.products, function (key, value) {
                                        total_price += value.quantity * value.price
                                        res_line += '<tr>' +
                                            '<td>' + value.image + '</td>' +
                                            '<td>' + value.title + '</td>' +
                                            '<td>' + value.price + ' грн.</td>' +
                                            '<td>' + value.quantity + '</td>' +
                                            '<td>' + (value.quantity * value.price).toFixed(2) + ' грн.</td>' +
                                            '</tr>';
                                    });
                                    res_line += '</tbody></table><p class="sum-total"><strong class="pull-left">Всього:</strong><span class="pull-right"><strong class="sum-tot">' + total_price.toFixed(2) + '</strong> грн.</span> </p>'
                                    this.theDialogWeAreUsing.setTitle('<h4 class="dialog-header-h">Замовлення № ' + $object_invoice.invoiceID + ' </h4><span class="dialog-time"><span><i class="fa fa-calendar"></i></span> Дата:<strong>' + $object_invoice.date + '</strong></span>' +
                                        '<span class="dialog-time"> <span><i class="fa fa-clock-o"></i></span> Час:<strong>' + $object_invoice.startTime.slice(0, -3) + ' - ' + $object_invoice.endTime.slice(0, -3) + '</strong></span>' +
                                        '<div class="dialog-time"><span><i class="fa fa-building-o"></i></span> Адреса: ' + $object_invoice.current_address + '</div>');
                                    this.theDialogWeAreUsing.setMessage(res_line);
                                }
                            });


                            return $message;
                        }

                    });
                    dialog.open();
                }

            });
        },
        select:function (start, end, jsEvent, view) {


//            var date = moment().subtract(1, 'days');
            var date = moment();
            var tomorrow = moment().add('days', 1).locale('uk').format('D.MM.YYYY');


            var endTime1 = moment('8:00pm', 'h:mma'); // max time for order
            var startTime1 = moment();


            if (!(startTime1.isBefore(endTime1))) { // if time is before 20:00
                date = date.add('days', 1);
                tomorrow = moment().add('days', 2).locale('uk').format('D.MM.YYYY');
            }


            if (start < date) {
                // Do whatever you want here.
//                alert('Cannot select past dates.');
                BootstrapDialog.show({
                    title:'Неможливо зробити замовлення на цей день. Найближчий день доставки - <b>' + tomorrow + '</b>',
                    message:'',
                    cssClass:'unableDay',
                    buttons:[
                        {
                            label:'ОК',
                            cssClass:'btn-success',
                            action:function (dialog) {
                                dialog.close();
                            }
                        }
                    ]
                });
                return;
            }
            var templateUrl = "<?php bloginfo('template_directory') ?>";
            templateUrl += '/shop_cart/ajax_SET_Update_cart.php';
            total_dialog = new BootstrapDialog({
                title:'Виберіть товари, та вкажіть їхню кількість і час доставки <p>' + moment(start).locale('ua').format('dddd, MMMM D, YYYY') + '</p>',
                cssClass:'cart-head enable-footer',
                buttons:[
                    {
                        label:'Додати',
                        cssClass:'btn btn-success',
                        id:'add-day-order-db',
                        action:function (dialog) {

                            dialog.getButton('add-day-order-db').disable();
                            var $check_object = {};
                            $('.cart-head.enable-footer input[type="checkbox"]').each(function () {
                                var $tmp_object = {};
                                var item_quantity = $(this).parents('tr').find('input[name="quantity_number"]').val();
                                $tmp_object.itemID = this.id;
                                $tmp_object.count = item_quantity;
                                if ($(this).is(':checked')) {
                                    $tmp_object.active = 1;
                                } else {
                                    $tmp_object.active = 0;
                                }
                                $check_object[this.id] = $tmp_object;
                            });

                            var checked_inputs = JSON.stringify($check_object);

                            if ($.isEmptyObject($check_object) !== true) {//not empty calendar order to one day
                                //add to DB
                                var templateUrl = "<?php bloginfo('template_directory') ?>";
                                templateUrl += '/ajax/createOrders.php';

                                var startTime = $('#order-time-picker .start').timepicker('getTime');
                                var endTime = $('#order-time-picker .end').timepicker('getTime');

                                var address_order = '';
                                var action_with_address = '';
                                if ($('#street-value').length > 0 && ($('#street-value').val() != '' && $('#build-value').val() != '' && $('#flat-value').val() != ''  )) {
                                    address_order = $('#street-value').val() + ', ' + $('#build-value').val() + ' кв.' + $('#flat-value').val();
                                    action_with_address = 'add-new-address';
                                } else {
                                    address_order = $('#select-order-addr select').val();
                                    action_with_address = 'add-exist-address';
                                }

                                $.ajax({
                                    url:templateUrl,
                                    type:'POST',
                                    data:{'action':'multiple-orders', 'cheked_inputs':checked_inputs, 'userID':$('#userId').val(), 'date':moment(start).format("YYYY-MM-DD"),
                                        'startTime':moment(startTime).format("HH:mm:ss"), 'endTime':moment(endTime).format("HH:mm:ss"), 'address-order':address_order, 'action_with_address':action_with_address, 'phone':$('#user_phone').val()},

                                    success:function (invoice_object) {
                                        var $invoice_object = JSON.parse(invoice_object);

                                        var eventData;
                                        if ($invoice_object.totalPrice) {
                                            eventData = {
                                                id:$invoice_object.invoiceID,
                                                title:$invoice_object.totalPrice + ' грн.',
                                                start:start,
                                                end:end,
                                                backgroundColor:'#E41818',
                                                className:'not-accept-event'
                                            };
                                            $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
                                            var calendar_url = "<?php bloginfo('template_directory') ?>";
                                            calendar_url += '/ajax/ajax_calendar_events.php';

                                            $.ajax({
                                                url:calendar_url,
                                                type:'POST',
                                                data:{'action':'add-event', 'price':$invoice_object.totalPrice, 'start':moment(start).format("YYYY-MM-DD"),
                                                    'end':moment(end).format("YYYY-MM-DD"), 'userID':$('#userId').val(), 'eventID':$invoice_object.invoiceID},

                                                success:function (content) {
                                                    getEventsTotalPrice();
                                                    console.log(content);
                                                }
                                            });

                                        }

                                        dialog.close();

                                        $('#accept-order-btn').removeAttr('disabled');

                                    }
                                });
                            }

                        }
                    },
                    {
                        label:'Відмінити',
                        cssClass:'btn btn-close',
                        action:function (dialog) {
                            dialog.close();
                        }
                    }
                ],
                onshow:function (dialog) {
                    dialog.getButton('add-day-order-db').disable();

                },
                onshown:function (dialog) {

                    var addresse_url = "<?php bloginfo('template_directory') ?>";
                    addresse_url += '/ajax/ajax_get_user_addresses.php';

                    var jqXHR = $.ajax({
                        url:addresse_url,
                        type:'POST',
                        data:{'userID':$('#userId').val()},
                        success:function (addresses) {
                            var $objectAddresses = JSON.parse(addresses);
                            var addbuilding = '';
                            if ($.isEmptyObject($objectAddresses) !== true) {
                                $('#select-value-for-address').removeClass('hide');
                                var resLine = '';

                                $.each($objectAddresses, function (key, value) {
                                    resLine += '<option value="' + value.value + '">' + value.address + '</option>';
                                });
                                resLine += '<option value="new">додати іншу адресу...</option>';
                                $('#select-value-for-address').html('').append(resLine);

                            } else {
                                $('#select-value-for-address-div').removeClass('hide');
                            }

                            $('#select-order-addr select').on('change', function (e) {
                                var selected_value = this.value;
                                if (selected_value == 'new') {

                                    $('#select-value-for-address-div').removeClass('hide');

                                } else {
                                    $('#select-value-for-address-div').addClass('hide');
                                }


                            });
                        }
                    });
                },
                message:function (dialogRef) {
                    var $message = $('<div>Loading...</div>');
                    var templateUrl1 = "<?php bloginfo('template_directory') ?>";
                    templateUrl1 += '/ajax/ajax_fget_all_products.php';

                    $.ajax({
                        url:templateUrl1,
                        type:'POST',
                        data:{'action':'getProducts'},
                        context:{
                            theDialogWeAreUsing:dialogRef
                        },
                        success:function (content) {
                            var $objectItems = JSON.parse(content);
                            console.log($objectItems);
                            var resLine = '<div id="get-all-products-cart"><table><thead><tr>' +
                                '<th style="width: 10%"></th>' +
                                '<th style="width: 60%"></th>' +
                                '<th style="width: 15%"></th>' +
                                '<th style="width: 10%"></th>' +
                                '<th style="width: 5%"></th>' +
                                '</tr></thead><tbody>';
                            $.each($objectItems, function (key, value) {
                                resLine += '<tr>' +
                                    '<td>' + value.image + '</td>' +
                                    '<td><span>' + value.title + '</span></td>' +
                                    '<td><span>' + value.price + ' грн.</span></td>' +
                                    '<td><input type="text" class="form-control" name="quantity_number" value="1" required></td>' +
                                    '<td><div class="checkbox-nice checkbox-inline"><input type="checkbox" id="' + value.itemID + '">' +
                                    '<label for="' + value.itemID + '"></label></div></td>' +
                                    '</tr>';

                            });
                            resLine += '</tbody></table></div>' +
                                '<div class="main-box"> <div class="main-box-body form-horizontal">' +
                                '<div id="addreses-order"  class="form-group"><label style="color: #000; padding-top: 10px;" class="col-lg-3 control-label">Вкажіть час доставки:</label>' +
                                '<div class="form-inline col-lg-9 " id="order-time-picker">' +
                                'з <label class="col-lg-3 input-group input-append bootstrap-timepicker"><span class="add-on input-group-addon"><i class="fa fa-clock-o"></i></span><input  type="text" class="form-control time start ui-timepicker-input" autocomplete="off"></label> до' +
                                '<label class="col-lg-3 input-group input-append bootstrap-timepicker"><span class="add-on input-group-addon"><i class="fa fa-clock-o"></i></span><input type="text" class="form-control time end ui-timepicker-input" autocomplete="off"></label>' +
                                '</div>' +
                                '</div>' +
                                '<div id="select-order-addr" class="form-group"><label style="color: #000; padding-top: 10px;" class="col-lg-3 control-label">Адреса доставки:</label>' +
                                '<div class="form-inline col-lg-9 ">' +
                                '<select id="select-value-for-address" style="width: 100%" class="form-control hide"></select>' +
                                '<div id="select-value-for-address-div" class="hide"><div class="input-group col-lg-8"><input class="form-control" type="text" id="street-value"/><span class="help-block">вулиця</span></div>' +
                                '<div class="input-group col-lg-2"><input class="form-control" type="text" id="build-value"/><span class="help-block">будинок</span></div>' +
                                '<div class="input-group col-lg-2"><input class="form-control" name="flat-value" type="text" id="flat-value"/><span class="help-block">квартира</span></div>' +
                                '</div></div>' +
                                '</div></div>' +
                                '<div class="main-box"><div  class="clearfix col-lg-12   sum-total"><div class="col-lg-6   text-left">Всього:</div><div class="col-lg-6 text-right"><span id="calendar-total-price">0</span> грн.</div></div></div>';


                            this.theDialogWeAreUsing.setMessage(resLine);

                            $('#get-all-products-cart').height($(window).height() / 2)
                            //inicialize timepicker
                            $('#order-time-picker .time').timepicker({
                                'showDuration':true,
                                'timeFormat':'G:i',
                                'minTime':'8:00:00',
                                'maxTime':'14:00:00'
                            });

                            $('#order-time-picker .end').prop('disabled', true);
                            $('#order-time-picker .time').on('changeTime', function () {
                                $('#order-time-picker .end').prop('disabled', false);
                            });


                            var timeOnlyExampleEl = document.getElementById('order-time-picker');
                            var timeOnlyDatepair = new Datepair(timeOnlyExampleEl);
                            //end inicialize

                            if (moment(moment().format("MM-DD-YYYY")).isSame(moment(start).format("MM-DD-YYYY"))) {
                                $('#order-time-picker .time').timepicker({
                                    'showDuration':true,
                                    'timeFormat':'G:i',
                                    'minTime':moment().add(1, 'hours').format('HH:mm:ss'),
                                    'maxTime':'20:00:00'
                                });
                            }


                            $('#order-time-picker .time').keydown(function (e) {
                                e.preventDefault();
                                return false;
                            });

                            $('.bootstrap-dialog-message table td input[type="checkbox"]').click(function () {

                                getTotalPriceForCalendarDay($objectItems, dialogRef);

                            });


                            $('.bootstrap-dialog-message table td input[name="quantity_number"], .bootstrap-dialog-message input[name="flat-value"]').bind("change keyup ", function () {
                                var currentCount = $(this).val();
                                var numberRegex = /^(1)$|^([1-9][0-9]*)$/;

                                var $el = $(this);

                                if (!numberRegex.test(currentCount) && $el.val() != "") {
                                    $el.val(1)
                                }

                                getTotalPriceForCalendarDay($objectItems, dialogRef);

                            });


                        }
                    });
                    return $message;

                }


            });
            total_dialog.open();
        }



    });


}

function getEventsTotalPrice() {
    var clients_object_events = {};
    $('#calendar').fullCalendar('clientEvents', function (e) {
        if (!($.inArray('not-accept-event', e.className))) {
            var $object_tmp = {};
            $object_tmp.id = e.id;
            clients_object_events[e.id] = $object_tmp;

        }
    });
    var json_data = JSON.stringify(clients_object_events);


    var templateUrl = "<?php bloginfo('template_directory') ?>";
    templateUrl += '/ajax/ajax_calendar_events.php';

    if ($.isEmptyObject(clients_object_events) !== true) {
        $.ajax({
            url:templateUrl,
            type:'POST',
            data:{'action':'get_price', 'json_update':json_data },
            success:function (object_total) {
                var $object_order_total = JSON.parse(object_total);
                $('#total-order-quantity').html('').append($object_order_total.totalQuantity);
                $('#total-price-order').html('').append($object_order_total.totalPrice);
                $('#price-delivery').html('').append($object_order_total.delivery_price);

                var totalPriceAccept = (Number($object_order_total.delivery_price) + Number($object_order_total.totalPrice)).toFixed(2);

                $('#total-price-accept').html('').append(totalPriceAccept);
                if ($object_order_total.totalQuantity || $object_order_total.totalPrice) {
                    $('#accept-order-btn').prop('disabled', false);
                }
                console.log($object_order_total);

            }
        });
    } else {
        $('#total-order-quantity').html('').append(0);
        $('#total-price-order').html('').append(0);
        $('#price-delivery').html('').append(0);
        $('#total-price-accept').html('').append(0);
        $('#accept-order-btn').prop("disabled", true)
    }
}


function getTotalPriceForCalendarDay($objectItems, dialogRef) {
    var total = 0;
    $('.bootstrap-dialog-message table td input:checked').each(function () {
        var itemID = this.id;
        var price = $objectItems[itemID].price;
        var quantity = $(this).parents('tr').find('input[name="quantity_number"]').val();

        total = total + Number(price) * Number(quantity);

    });
    var startTime = $('#order-time-picker ').find('.start').val();
    var endTime = $('#order-time-picker ').find('.end').val();

    $('#order-time-picker ').on('rangeSelected', function (e) {
        startTime = $(this).find('.start').val();
        endTime = $(this).find('.end').val();

        if (startTime !== '' && endTime !== '' && total > 0 && (($('#street-value').val() != '' && $('#build-value').val() != '' && $('#flat-value').val() != '') || ($('#select-value-for-address').val() != null && $('#select-value-for-address').val() != 'new' ) )) {
            dialogRef.getButton('add-day-order-db').enable();
        } else {
            dialogRef.getButton('add-day-order-db').disable();
        }

        // do something with milliseconds value
    });

    $('#select-order-addr select').on('change', function (e) {

        if (startTime !== '' && endTime !== '' && total > 0 && (($('#street-value').val() != '' && $('#build-value').val() != '' && $('#flat-value').val() != '') || ($('#select-value-for-address').val() != null && $('#select-value-for-address').val() != 'new' ) )) {
            dialogRef.getButton('add-day-order-db').enable();
        } else {
            dialogRef.getButton('add-day-order-db').disable();
        }

    });

    if (startTime !== '' && endTime !== '' && total > 0 && (($('#street-value').val() != '' && $('#build-value').val() != '' && $('#flat-value').val() != '') || ($('#select-value-for-address').val() != null && $('#select-value-for-address').val() != 'new' ) )) {
        dialogRef.getButton('add-day-order-db').enable();
        if ($('#delete-order-btn').length > 0) {
            $('#delete-order-btn').addClass('hide');
        }
    } else {
        if ($('#delete-order-btn').length > 0) {
            $('#delete-order-btn').removeClass('hide');
        }
        dialogRef.getButton('add-day-order-db').disable();
    }

    $('#calendar-total-price').html('').append(total.toFixed(2));
}


function confirmOrders1() {
    var templateUrl = "<?php bloginfo('template_directory') ?>";
    templateUrl += '/ajax/createOrders.php';
    var map = '';

    var objId = {};

    var arrtmp = [];
    var arrtmpQuantity = [];
    var arrDate = [];
    var dateString = '';
    var dateFrom = '';
    $('#makeCheckoutcontent .orderNumb').each(function () {
        arrtmp = [];
        arrtmpQuantity = [];
        dateString = '';
        var mapKey = this.id;
        dateFrom = '';
        var mapTmp = [];
        $(this).find('input[name="quantity"]').each(function () {
            arrtmp.push(Number(this.id));

        });
        $(this).find('input[name="quantity"]').each(function () {
            arrtmpQuantity.push(Number(this.value));
        });
        dateFrom = $('#' + mapKey + ' input.date.start').val();

        var masItem = arrtmp;
        var masQuantity = arrtmpQuantity;
        dateString += arrDate;
        map += 'id:[' + masItem + '] quantity:[' + masQuantity + '] time:[' + dateFrom + '] end';
    });


    $.ajax({
        url:templateUrl,
        type:'POST',
        data:{data:map, userID:$('#userId').val()},
        cache:false,
        success:function (data) {
            console.log(data); // не паше json

        }
    });

}


function confirmOrders() {
    var templateUrl = "<?php bloginfo('template_directory') ?>";
    templateUrl += '/ajax/createOrders.php';

    var arrtmpQuantity = [];
    var arr = [];
    $('#makeCheckoutcontent .orderNumb').each(function () {
        arr.push({
            zamovlennya:this.id,
            date:$(this).find('input.date.start').val()
        });

    });
    /*  $(this).find('input[name="quantity"]').each(function(){

        arr.push({
            id:Number(this.id),
            value: Number(this.value)

        });
    });*/
    $.each(arr, function (index, value) {
        var i = 0;
        $('#' + value.zamovlennya).find('input[name="quantity"]').each(function () {

            arr[index][i] = {
                id:this.id,
                value:this.value
            };
            i++;
        });
//            arr[index] = {
//                time:$('#'+value.zamovlennya+' input.date.start').val()
//            };

    });
    console.log(arr);


    $.ajax({
        url:templateUrl,
        type:'POST',

        data:{data:arr, userID:$('#userId').val()},

        success:function (data) {
            console.log(data); // не паше json

        }
    });

}
$(document).on('click', '#show-information-block', function () {
    BootstrapDialog.show({
        title:'Час доставки',
        cssClass:'close-btn',
        message:'<p>Зверніть увагу, що замовлення, які оформляються після <b>20:00 год</b> можуть бути доставлені лише через день(тобто післязавтра) після підтвердження оформлення.' +
            '</p>Замовлення до <b>20:00 год</b> виконуються на другий день з <b>8:00 до 14:00 год.</b><p>',
        buttons:[
            {
                label:'Закрити',
                cssClass:'btn-success',
                action:function (dialog) {
                    dialog.close();
                }
            }
        ]
    });
});

function warning_notification_before_submit_order() {
    var single_date = moment($('#single-date-select').val());
    var res = 1;
    var type_order1 = $('#accept-order-btn').data('select-order-ex');
    if (type_order1 = 'single') {
        res = compareDates(moment($('#single-date-select').val(),'DD-MM-YYYY').format('YYYY-MM-D'),moment().add('days', 1).format('YYYY-MM-D'))
    }
    var endTime = moment('8:00pm', 'h:mma'); // max time for order
    var startTime = moment();
    var after_tomorrow = moment().add('days', 2).locale('uk').format('D.MM.YYYY');
    var tomorrow = moment().add('days', 1).locale('uk').format('D/MM/YYYY');
    var a = 2;

    if ((!(startTime.isBefore(endTime))) && res!==2 && type_order1!='single') { // if time is after 20:00
        BootstrapDialog.show({
            title:'<h4 style="color:#000; margin:0">Зверніть увагу</h4>',
            cssClass:'close-btn',
            message:'<p>Ви зробили замовлення після <b>20:00</b>, тому Ваше замовленния може бути виконано лише <b>' + after_tomorrow + '</b> <p>',
            buttons:[
                {
                    label:'OK',
                    cssClass:'btn-success',
                    action:function (dialog) {

                        $('#single-date-select').datepicker("setDate", new Date( moment().add('days', 2).locale('uk').format( )) );
                        a = '2';
                        dialog.close();

                    }
                },
                {
                    label:'Відмінити',
                    cssClass:'btn-primary',
                    action:function (dialog) {
                        a = '1';
                        dialog.close();

                    }
                }
            ],
            onhidden:function () {
                if (a == '2') {
                    //function
                    send_order();
                }
            }
        });

    } else {
        //function
        send_order();
    }


}
function compareDates(date1, date2) {
    var a = 1;
    if (new Date(date1) <= new Date(date2)) {
        a = 1;
    } else {
       a= 2;
    }
    return a;
}


</script>


</body>
</html>