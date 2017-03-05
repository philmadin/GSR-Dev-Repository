<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 20/05/2016
 * Time: 7:52 PM
 */

include 'mysql_con.php';

$return = array(
        "success"=>null,
        "redirect" => "index.php",
);


if(!isset($_POST) || !isset($_POST['auth_type']) || !isset($_POST['user'])){
        $return['redirect'] = $_SERVER["HTTP_REFERER"];
        $return['success'] = false;
        $return['message'] = "Invalid Request";
}

if($return['success']===false){
    die(json_encode($return));
}

$user = json_decode($_POST['user']);
$return['user'] = json_encode($user);
$auth_type = $_POST['auth_type'];
$return['auth_type'] = $_POST['auth_type'];
$uid       = $user->uid;
$logQRY = 0;




if($auth_type=="facebook"){
    $logQRY = mysqli_query($con, "SELECT * FROM tbl_users WHERE fb_uid = '$uid'");
}

if($auth_type=="twitter"){
    $logQRY = mysqli_query($con, "SELECT * FROM tbl_users WHERE twitter_uid = '$uid'");
}

if($auth_type=="google"){
    $logQRY = mysqli_query($con, "SELECT * FROM tbl_users WHERE gplus_uid = '$uid'");
}

$request['num_rows'] = mysqli_num_rows($logQRY);

if(mysqli_num_rows($logQRY) > 0) {

    while ($getUSER = mysqli_fetch_assoc($logQRY)) {
        $username = $getUSER['username'];
    }

    if(mysqli_query($con, "UPDATE tbl_users SET online = 'ONLINE' WHERE username = '$username'")) {


            setcookie('username', $username, time() + (86400 * 30), "/");
            setcookie('username', $username, time() + (86400 * 30), "/mobilesite");
            $_SESSION['username'] = $username;

        if(isset($_SERVER["HTTP_REFERER"])){
            $return['redirect'] = $_SERVER["HTTP_REFERER"];
            $return['success'] = true;
        }
        else{
            $return['redirect'] = "index.php";
            $return['success'] = true;
        }

    }

} else {
    $return['success'] = false;
}


die(json_encode($return));




?>