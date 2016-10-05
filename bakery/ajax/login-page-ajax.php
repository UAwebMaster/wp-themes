<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slavik
 * Date: 10.03.15
 * Time: 12:22
 * To change this template use File | Settings | File Templates.
 */

$adapterConfigs = array(
    'vk' => array(
        'client_id' => '4889900',
        'client_secret' => 'Q8QDFfqOHWhI7CYraLHn',
        'redirect_uri' => 'http://www.morning-bakery.com.ua/?provider=vk'

    ),
    'google' => array(
        'client_id' => '523648377771-ho9cihnkcft20t7f3ebhkm06ke7f09b5.apps.googleusercontent.com',
        'client_secret' => 'GBIHhbh1hvDSvHJFdT9Vdxqc',
        'redirect_uri' => 'http://www.morning-bakery.com.ua/?provider=google'
    ),
    'facebook' => array(
        'client_id' => '1574939529406261',
        'client_secret' => '2707eb57dd2708846193b14214473277',
        'redirect_uri' => 'http://www.morning-bakery.com.ua/?provider=facebook'
    )
);


$adapters = array();
foreach ($adapterConfigs as $adapter => $settings) {
    $class = 'SocialAuther\Adapter\\' . ucfirst($adapter);
    $adapters[$adapter] = new $class($settings);
}
if (isset($_GET['provider']) && array_key_exists($_GET['provider'], $adapters) && !isset($_SESSION['user'])) {
    $auther = new SocialAuther\SocialAuther($adapters[$_GET['provider']]);

    if ($auther->authenticate()) {

        $result = mysql_query(
            "SELECT *  FROM `wp_users_social` WHERE `provider` = '{$auther->getProvider()}' AND `social_id` = '{$auther->getSocialId()}' LIMIT 1"
        );

        $record = mysql_fetch_array($result);
        if (!$record) {
            $values = array(
                $auther->getProvider(),
                $auther->getSocialId(),
                $auther->getName(),
                $auther->getEmail(),
                $auther->getSocialPage(),
                $auther->getSex(),
                date('Y-m-d', strtotime($auther->getBirthday())),
                $auther->getAvatar()
            );

            $query = "INSERT INTO `wp_users_social` (`provider`, `social_id`, `name`, `email`, `social_page`, `sex`, `birthday`, `avatar`) VALUES ('";
            $query .= implode("', '", $values) . "')";
            $result = mysql_query($query);
        } else {
            $userFromDb = new stdClass();
            $userFromDb->provider = $record['provider'];
            $userFromDb->socialId = $record['social_id'];
            $userFromDb->name = $record['name'];
            $userFromDb->email = $record['email'];
            $userFromDb->socialPage = $record['social_page'];
            $userFromDb->sex = $record['sex'];
            $userFromDb->birthday = date('m.d.Y', strtotime($record['birthday']));
            $userFromDb->avatar = $record['avatar'];
        }

        $user = new stdClass();
        $user->provider = $auther->getProvider();
        $user->socialId = $auther->getSocialId();
        $user->name = $auther->getName();
        $user->email = $auther->getEmail();
        $user->socialPage = $auther->getSocialPage();
        $user->sex = $auther->getSex();
        $user->birthday = $auther->getBirthday();
        $user->avatar = $auther->getAvatar();

        if (isset($userFromDb) && $userFromDb != $user) {
            $idToUpdate = $record['id'];
            $birthday = date('Y-m-d', strtotime($user->birthday));

            mysql_query(
                "UPDATE `wp_users_social` SET " .
                    "`social_id` = '{$user->socialId}',  " .
                    "`social_page` = '{$user->socialPage}', `sex` = '{$user->sex}', " .
                    "`birthday` = '{$birthday}', `avatar` = '$user->avatar' " .
                    "WHERE `id`='{$idToUpdate}'"
            );
        }

        $_SESSION['user'] = $user;


    }

    $url = $_SESSION['url'];
    header("Location:$url");
}
?>