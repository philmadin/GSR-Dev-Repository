<?php
    session_start();

    include "mysql_con.php";

    $user = $_GET['user'];
    $profile = $_GET['profile'];

    $userqry = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$user'");
    while ($userROW = mysqli_fetch_assoc($userqry)) {
        $userID = $userROW['id'];
        $userFR = $userROW['friends'];
    }

    $profqry = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$profile'");
    while ($profROW = mysqli_fetch_assoc($profqry)) {
        $profID = $profROW['id'];
        $profFR = $profROW['friends'];
    }

    if(empty($userFR)) {
        $useradd = $profID;
    } else {
        $useradd = $userFR . "," . $profID;
    }

    if(empty($profFR)) {
        $profadd = $userID;
    } else {
        $profadd = $profFR . "," . $userID;
    }

    $addtoUser = mysqli_query($con, "UPDATE tbl_accounts SET friends = '$useradd' WHERE username = '$user'");
    $addtoProfile = mysqli_query($con, "UPDATE tbl_accounts SET friends = '$profadd' WHERE username = '$profile'");
    $removeA = mysqli_query($con, "DELETE FROM tbl_requests WHERE requestee = '$profID' AND requester = '$userID'");
    $removeB = mysqli_query($con, "DELETE FROM tbl_requests WHERE requester = '$profID' AND requestee = '$userID'");

    if(($addtoUser && $addtoProfile) && ($removeA || $removeB)) {
        return true;
    } else {
        return false;
    }
?>