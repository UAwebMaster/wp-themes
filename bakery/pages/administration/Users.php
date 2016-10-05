<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slavik
 * Date: 08.12.15
 * Time: 16:56
 * To change this template use File | Settings | File Templates.
 */
class Users
{

    public function get_users(){
        $query = mysql_query("SELECT * from wp_users_social");
        $array = array();
        while($result = mysql_fetch_assoc($query)){
            $array[]= $result;
        }
        return json_encode($array);

    }

}
