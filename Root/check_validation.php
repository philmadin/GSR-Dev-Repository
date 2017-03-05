<?php

    include "mysql_con.php";

    $username = $_GET['username'];

    $getEmail = mysqli_query($con, "SELECT * FROM tbl_users WHERE username = '$username'");

    if(mysqli_num_rows($getEmail) > 0) {

        while($xyz = mysqli_fetch_assoc($getEmail)) {
            $verify = $xyz['verify'];
        }

        if($verify != "verified") {
            echo "false";
        } else {
            echo "true";
        }

    }
?>