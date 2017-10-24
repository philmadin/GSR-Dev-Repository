<?php
    session_start();

    include "mysql_con.php";

    $user = $_GET['user'];
    $status = $_GET['stt'];

    $addStatus = mysqli_query($con, "INSERT INTO tbl_status (username, status, date_status) VALUES ('$user', '$status', now())");

    if ($addStatus) {
      return true;
    } else {
      return false;
    }
?>
