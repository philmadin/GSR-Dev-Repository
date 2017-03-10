<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 24/02/2016
 * Time: 7:51 PM
 */

function getToken(){
    $token = md5(substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5));
    return $token;
}

?>