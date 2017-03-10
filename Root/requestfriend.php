<?php
    session_start();

    include "mysql_con.php";

    $user = $_GET['user'];
    $profile = $_GET['profile'];

    $userqry = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$user'");
    $profqry = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$profile'");

    $userid = mysqli_fetch_assoc($userqry)['id'];
    $profid = mysqli_fetch_assoc($profqry)['id'];

    $requestFriend = mysqli_query($con, "INSERT INTO tbl_requests (requester, requestee) VALUES ('$userid','$profid')");

    if($requestFriend) {
        return true;
    } else {
        return false;
    }
?>