<?php
    session_start();

    include "mysql_con.php";

    $user = $_GET['user'];
    $profile = $_GET['profile'];

    $stmt = mysqli_prepare($con, $query_user_info) or die("Unable to prepare statement: " . mysqli_error($con));
    if ($stmt) {
      mysqli_stmt_bind_param($stmt, 's', $user);
      mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
      $userqry = mysqli_stmt_get_result($stmt);
      $userid = mysqli_fetch_array($userqry)['id'];
      mysqli_stmt_close($stmt);
    }

    $stmt = mysqli_prepare($con, $query_user_info) or die("Unable to prepare statement: " . mysqli_error($con));
    if ($stmt) {
      mysqli_stmt_bind_param($stmt, 's', $profile);
      mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
      $profqry = mysqli_stmt_get_result($stmt);
      $profid = mysqli_fetch_array($profqry)['id'];
      mysqli_stmt_close($stmt);
    }

    $stmt = mysqli_prepare($con, $query_request_friend) or die("Unable to prepare statement: " . mysqli_error($con));
    if ($stmt) {
      mysqli_stmt_bind_param($stmt, 'ii', $userid, $profid);
      mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
      $requestFriend = mysqli_stmt_get_result($stmt);
      mysqli_stmt_close($stmt);
    }

    if($requestFriend) {
        return true;
    } else {
        return false;
    }
?>
