<?php
    include "mysql_con.php";

    if(isset($_GET['user'])){$social_user = json_decode(base64_decode($_GET['user']));}else{$social_user = false;}
    if(isset($_GET['auth_type'])){$auth_type = $_GET['auth_type'];}else{$auth_type = false;}

    $uid       = $social_user->uid;
    $socialQRY = 0;

    $username = $_GET['username'];
    $password = sha1(md5($_GET['password']));

    $logQRY = mysqli_query($con, "SELECT * FROM tbl_users WHERE username = '$username' AND password = '$password'");

    if(mysqli_num_rows($logQRY) != 0) {

        if($auth_type=="facebook"){
            mysqli_query($con, "UPDATE tbl_users SET fb_uid = '".$uid."' WHERE username = '$username'");
        }

        if($auth_type=="twitter"){
            mysqli_query($con, "UPDATE tbl_users SET twitter_uid = '".$uid."' WHERE username = '$username'");
        }

        if($auth_type=="google"){
            mysqli_query($con, "UPDATE tbl_users SET gplus_uid = '".$uid."' WHERE username = '$username'");
        }


        if(mysqli_query($con, "UPDATE tbl_users SET online = 'ONLINE' WHERE username = '$username'")) {
			
			if(isset($_GET['staylogged'])){
				setcookie('username', $username, time() + (3600*24*365*10), "/");
				setcookie('username', $username, time() + (3600*24*365*10), "/mobilesite");
			}
			else{
				setcookie('username', $username, time() + (86400 * 30), "/");
				setcookie('username', $username, time() + (86400 * 30), "/mobilesite");
			}
            
            $_SESSION['username'] = $username;

        }

    } else {
        echo "fail";
    }
?>