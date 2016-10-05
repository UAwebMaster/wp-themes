<?php

include("../../../../wp-load.php");


$query = mysql_query("SELECT * FROM wp_posts INNER JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id WHERE post_type='prod' AND meta_key = 'wpcf-price' ");
$array = array();
while ($res = mysql_fetch_assoc($query)){
    $array[$res['ID']]['price'] = $res['meta_value'];
    $array[$res['ID']]['image'] = do_shortcode('[types field="my-image" id=' . $res['ID'] . ' width="80px" height="auto" "]');
    $array[$res['ID']]['title'] = $res['post_title'];
    $array[$res['ID']]['itemID'] = $res['ID'];
}
echo json_encode($array);



?>