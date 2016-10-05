$(document).ready(function () {


    //*************************PROFILE PAGE SCRIPT*************************************
    $('#personal-data-wrap button[type="button"]').click(function () {
        $('#personal-data-wrap').addClass('hide');
        $('#edit-personal-data-wrap').removeClass('hide');
    });

    $('#edit-personal-data button[type="button"]').click(function () {
        $('#personal-data-wrap').removeClass('hide');
        $('#edit-personal-data-wrap').addClass('hide');
    });


    $('#edit-personal-data-wrap ul li .fa.fa-times').click(function () {
        var current_address_id = $(this).parents('li').attr('id');
        if (current_address_id != 'add-address-field' ){
            $('#' + current_address_id).remove();

            current_address_id = current_address_id.replace('address-', '');

            console.log(current_address_id);
            var ajax_url = location.protocol + '//' + location.host;
            ajax_url += '/wp-content/themes/twentythirteen/ajax/ajax_profile_edit.php';

            $.ajax({
                url:ajax_url,
                type:'POST',
                data:{'addressID':current_address_id, 'action':'removeAddress' },
                success:function (data) {
                }
            });
        }

    });

    $('#show-add-address-field').click(function () {
        $(this).addClass('hide');
        $('#add-address-field').removeClass('hide');
        $('#add-address-field input').prop('required',true);
    });


    $('#hide-address-edit-pinfo').click(function (e) {

        $('#add-address-field').addClass('hide');
        $('#add-address-field input').prop('required', false);
        $('#show-add-address-field').removeClass('hide');
    });

    $('#add-address-field #flat-value-single').bind("change keyup ", function () {
        var currentCount = $(this).val();
        var numberRegex = /^(1)$|^([1-9][0-9]*)$/;

        var $el = $(this);

        if (!numberRegex.test(currentCount) && $el.val() != "") {
            $el.val(1)
        }
    });


        //**************save data to DB*****************************************************
    $('#edit-personal-data button[type="submit"]').click(function(){
        var $formUser = $('#edit-personal-data');

        if ($formUser.valid() == true) {

            $formUser.on('submit', function (e) {

                // validation code here
                e.preventDefault();


            });

            var ajax_url = location.protocol + '//' + location.host;
            ajax_url += '/wp-content/themes/twentythirteen/ajax/ajax_profile_edit.php';

            var name;
            var login;
            var email;
            var phone;



            if ($('#edit-personal-data input[name="name"]').length > 0){
                name = $('#edit-personal-data input[name="name"]').val();
            }else{
                login = $('#edit-personal-data input[name="login"]').val();
            }
            email = $('#edit-personal-data input[type="email"]').val();
            phone = $('#edit-personal-data input[name="phone"]').val();


            if ($('#street-value-single').val() != '' && $('#build-value-single').val() != '' && $('#flat-value-single').val() != ''){
                var street;
                var flat;
                var build;

                street = $('#street-value-single').val();
                flat = $('#flat-value-single').val();
                build = $('#build-value-single').val();

            }


            $.ajax({
                url:ajax_url,
                type:'POST',
                data:{'action':'editInfo', 'userID':$('#user-id-hidden-field').val(), 'name':name, 'login':login, 'email':email, 'phone':phone,
                'street':street, 'build':build, 'flat':flat},
                success:function (data) {
                    location.reload();
                }
            });


        }else{

        }
    });

    //************************END PROFILE PAGE SCRIPT***********************************



    //************************START HISTORY ORDERS PROFILE SCRIPT************************

    $('#history-orders table tr ').click(function(){
        $(this).toggleClass('footable-detail-show');
        $(this).next().toggleClass('show-detail-tr');
    });

    //************************END HISTORY ORDERS PROFILE SCRIPT************************

});