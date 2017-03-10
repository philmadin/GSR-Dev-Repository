<?php

    session_start();

    include "mysql_con.php";

    $logoutUser = $_SESSION['username'];
    $logoutTime = date('Y-m-d H:i:s');

    if(mysqli_query($con, "UPDATE tbl_users SET online = '$logoutTime' WHERE username = '$logoutUser'")) {

        unset($_SESSION['username']);
        unset($_COOKIE['username']);
        setcookie('username', null, -1, '/');
        setcookie('username', null, -1, '/mobilesite');
        session_destroy();

    }

?>