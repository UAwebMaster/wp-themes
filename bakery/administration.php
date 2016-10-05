<?php
/*
Template Name: administration page
*/
?>

<?php
require_once('pages/admin-header.php');
?>

<?php wp_head();

?>


<!--                    <div class="row" style="opacity: 1;">-->
<!--                        <div class="col-lg-12">-->
<!--                            <div class="main-box clearfix">-->
<!---->
<!--                                <header class="main-box-header clearfix">-->
<!--                                    <h2 class="pull-left">Користувачі</h2>-->
<!--                                    <div id="reportrange" class="pull-right daterange-filter">-->
<!--                                        <i class="icon-calendar"></i>-->
<!---->
<!--                                    </div>-->
<!--                                </header>-->
<!--                                <div class="main-box-body clearfix">-->
<!--                                    <div class="table-responsive">-->
<!---->
<!--                                    </div>-->
<!--                                    --><?php
//                                    if (is_user_logged_in()) {
//
//                                        $users = json_decode($Users->get_users());
//                                        if(sizeof($Users)>0){
//                                            $table = '<table id = "users" class="table"><thead>
//                                <th>№</th>
//                                <th>Метод реєстрації</th>
//                                <th>Ім\'я</th>
//                                <th>Логін</th>
//                                <th>E-mail</th>
//                                <th>Телефон</th>
//                                </thead><tbody>';
//                                            foreach($users as $index=>$user){
//                                                $index =$index+1;
//                                                $table.='<tr>
//                                    <th>'.$index.'</th>
//                                    <th>'.$user->provider.'</th>
//                                    <th>'.$user->name.'</th>
//                                    <th>'.$user->login.'</th>
//                                    <th>'.$user->email.'</th>
//                                    <th>'.$user->phone.'</th>
//                                    </tr>';
//
//                                            }
//                                            $table.= '</tbody></table>';
//                                            echo $table;
//                                        }else{
//                                            echo '<h3>В базі не знайдено користувачів</h3>';
//                                        }
//
//
//                                    } else {
//                                        echo 'Welcome, visitor!';
//                                    }
//                                    ?>
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->

<?php require_once('pages/admin-footer.php') ?>