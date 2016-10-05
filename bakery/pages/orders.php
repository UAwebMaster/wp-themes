<?php
/*
Template Name: orders-admin page
*/
?>

<?php
require_once('admin-header.php');
wp_head();
?>

<?php
$date = current_time('d/m/Y');

?>
<div class="row" style="opacity: 1" id="orders-page">
    <div class="col-lg-12">
        <div class="main-box clearfix">
            <header class="main-box-header clearfix">
                <h2>Замовлення</h2>
            </header>
        </div>
        <div class="main-box-body clearfix">
            <div class="table-responsive">
                <input style="width: 200px" type="text" id="datarange-orders" class="form-control" name="daterange" value="<?php echo $date;?> - <?php echo $date;?>" />
                <div id="orders-wrapper">

                </div>
            </div>
        </div>
    </div>
</div>







<?php require_once('admin-footer.php') ?>
<script type="text/javascript">
    $(function(){
        $(function(){
            $('#nav-col li').removeClass('active');
            $('#orders-li').parent().addClass('active');

            $('#orders-page input[name="daterange"]').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
            get_orders();
            $('#datarange-orders').on('apply.daterangepicker', function(ev, picker) {
                get_orders();
            });


        })
    });
    //**************************************GET ORDERS BY DATE************************************************************************
    function get_orders(){
        var templateUrl = location.protocol + '//' + location.host;
        templateUrl += '/wp-content/themes/twentythirteen/pages/ajax/get_orders.php';
        jQuery.ajax({
            url:templateUrl,
            type:'POST',
            data:{'date_start': $('#datarange-orders').data('daterangepicker').startDate.format('YYYY-MM-DD'), 'date_end': $('#datarange-orders').data('daterangepicker').endDate.format('YYYY-MM-DD')},
            success:function (content) {

                if(JSON.parse(content).length>0){

                    console.log(JSON.parse(content));
                    var $orders = JSON.parse(content);
                    var table = '<table class="table"><thead><tr>' +
                        '<th>ID</th>' +
                        '<th>Дата</th>' +
                        '<th>Час</th>' +
                        '<th>Адреса</th>' +
                        '<th>Користувач</th>' +
                        '<th>Моб.номер</th>' +
                        '<th>Оплата</th>' +
                        '<th>К-ть</th>' +
                        '<th>Сума</th>' +
                        '<th>Статус</th>' +
                        '<th>Дії</th>' +
                        '</tr></thead><tbody>';

                    $.each($orders,function(key,value){
                        table += '<tr>' +
                            '<td class="show-orders-by-id" data-id="'+value.invoice_id+'">'+value.invoice_id+'</td>' +
                            '<td>'+value.date+'</td>' +
                            '<td>'+value.time_from+' - '+value.time_to+'</td>' +
                            '<td>'+value.address+'</td>' +
                            '<td>'+value.name+'</td>' +
                            '<td>'+value.phone+'</td>' +
                            '<td>'+value.oplata+'</td>' +
                            '<td>'+value.quantity+'</td>' +
                            '<td>'+value.price+' грн.</td>' +
                            '</tr>';

                    });


                    table +='</tbody></table>';
                    $('#orders-wrapper').html(table);
                }else{
                    $('#orders-wrapper').html('<h3 style="color:#000">Не знайдено жодного замовлення за заданий період</h3>');

                }

            }

        });
    }
    //**************************************GET INVOICE BY ID************************************************************/
    $(document).on('click','.show-orders-by-id',function(){
        var orderID = $(this).data('id');
        console.log(orderID);
        var templateUrl = location.protocol + '//' + location.host;
        templateUrl += '/wp-content/themes/twentythirteen/pages/ajax/ajax_get_invoice_by_id.php';

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
                var jQuerymessage = jQuery('<div>Loading...</div>');

                // if accepted event
                jQuery.ajax({
                    url:templateUrl,
                    type:'POST',
                    data:{'invoiceID':orderID},
                    context:{
                        theDialogWeAreUsing:dialogInvoice
                    },
                    success:function (content) {
                        var jQueryobject_invoice = JSON.parse(content);
                        var res_line = '<table><thead><tr>' +
                            '<th style="width: 10%"></th>' +
                            '<th style="width: 40%">Назва</th>' +
                            '<th style="width: 10%">Ціна</th>' +
                            '<th style="width: 10%">К-ть</th>' +
                            '<th style="width: 10%">Сума</th>' +

                            '</tr>';
                        var total_price = parseFloat(jQueryobject_invoice.delivery_price);
                        jQuery.each(jQueryobject_invoice.products, function (key, value) {
                            total_price += value.quantity * value.price;
                            res_line += '<tr>' +
                                '<td>' + value.image + '</td>' +
                                '<td>' + value.title + '</td>' +
                                '<td>' + value.price + ' грн.</td>' +
                                '<td>' + value.quantity + '</td>' +
                                '<td>' + (value.quantity * value.price).toFixed(2) + ' грн.</td>' +
                                '</tr>';
                        });
                        res_line += '</tbody></table><p class="sum-total"><strong class="pull-left">Всього:</strong>(з доставкою)<span class="pull-right"><strong class="sum-tot">' + ((total_price).toFixed(2)) + '</strong> грн.</span> </p>'
                        this.theDialogWeAreUsing.setTitle('<h4 class="dialog-header-h">Замовлення № ' + jQueryobject_invoice.invoiceID + ' </h4><span class="dialog-time"><span><i class="fa fa-calendar"></i></span> Дата:<strong>' + jQueryobject_invoice.date + '</strong></span>' +
                            '<span class="dialog-time"> <span><i class="fa fa-clock-o"></i></span> Час:<strong>' + jQueryobject_invoice.startTime.slice(0, -3) + ' - ' + jQueryobject_invoice.endTime.slice(0, -3) + '</strong></span>' +
                            '<div class="dialog-time"><span><i class="fa fa-building-o"></i></span> Адреса: ' + jQueryobject_invoice.current_address + '</div>');
                        this.theDialogWeAreUsing.setMessage(res_line);
                    }
                });
                return jQuerymessage;
            }
        });
        dialog.open();
    });
    //************************************END GET INVOICE BY ID******************************************************************
</script>