<?php
/*
Template Name: orders page
*/
require_once 'orders/Orders.php';
get_header();

$order = new Orders();

?>
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


                    ?>

                    <div class="main-box-header clearfix row">
                        <div class="clo-lg-12 text-left"><h2
                            style="border-bottom: 1px solid; width: 100%">Історія замовлень</h2>
                        </div>
                    </div>
                    <div class="main-box-body clearfix">
                        <div class="row">

                            <div class="col-lg-3">
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a href="<?php echo get_site_url()?>/profile">Профіль</a></li>
                                    <li class="active"><a href="<?php echo get_permalink(100) ?>">Історія замовлень</a>
                                    </li>
                                    <li><a href="<?php  bloginfo('template_directory')?>/logout.php">Вихід</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-9">
                                <div class="row" style="padding: 0px">
                                    <div class="col-lg-12" id="history-orders">
                                        <?php
                                        $query = mysql_query("SELECT * FROM wp_orders WHERE userId = '$user_id'");

                                        $row = '<table style="margin: 0" class="table footable toggle-circle-filled footable-loaded default breakpoint"><tbody>';
                                        while ($data = mysql_fetch_assoc($query)) {
                                            $invoice_id = $data['id'];
                                            $delivery_price = $data['delivery_price'];
                                            $current_order = json_decode($order->get_orders_by_id($invoice_id));


                                            $arr = (get_object_vars($current_order->products));

                                            $image = '';
                                            $quantity = 0;
                                            $price = $delivery_price;

                                            $product_list = ' <ul class="widget-products">';

                                            foreach ($arr as $product) {
                                                $product_list .= '<li><div><span class="img">'.$product->image.'</span>
                                                <span class="product clearfix"><span class="name">'.$product->title.'</span>
                                                <div class="col-lg-12">
                                                    <span class="col-lg-6  pull-left text-left">'.$product->quantity.' шт.</span>
                                                    <span class="col-lg-6 pull-right text-right ">'.$product->quantity*$product->price.' грн</span>
                                                </div>
                                                </span>
                                                </div></li>';



                                                $image .= $product->image;
                                                $quantity = $quantity + $product->quantity;
                                                $price = $price + $product->quantity * $product->price;

                                            }

                                           $product_list .='</ul><div class="row wid-pr-foot"><div class="col-lg-12">Вартість доставки:<span class="pull-right">'.$delivery_price.' грн.</span></div></div>
                                            <div class="row"><div class="col-lg-12">Всього:<span class="pull-right">'.$price.' грн.</span> </div></div>';

                                            $old_date = strtotime($data['order_date']);
                                            $new_date = date('Y-m-d H:i', $old_date);

                                            $row .= "<tr class='parent-tr-list-td'><td><span class='footable-toggle'></span>" . $invoice_id . "</td>
                                            <td>" . $new_date . "</td>
                                            <td class='image-wrap-table'>" . $image . "</td>
                                            <td>" . $quantity . ' товар' . NumberEnd($quantity, array('', 'и', 'ів')) . ' на ' . $price . " грн</td>
                                            <td>" . $data['order_status'] . "</td>
                                            </tr>
                                            <tr class='footable-row-detail'  ><td colspan='5'>$product_list";

                                            $row .=   " </td></tr>";


                                        }
                                        $row .= '</tbody></table>';
                                        echo $row;


                                        ?>


                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                    <?php
                } else {
                    header('Location: http://www.morning-bakery.com.ua/login');
                }

                ?>

            </div>
        </div>
    </div>


</div>


<?
function NumberEnd($number, $titles)
{
    $cases = array(2, 0, 1, 1, 1, 2);
    return $titles[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
}

?>
<?php get_footer(); ?>