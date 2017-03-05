<?php

    include "mysql_con.php";

    $CRU_FRM    = $_GET['from'];
    $CRU_TO     = $_GET['to'];
    $CRU_MES    = $_GET['message'];
    $CRU_WEN    = date("Y-m-d H:i:s");

    $crunchQRY = "INSERT INTO tbl_crunchbox (id, receiver, sender, since, message) VALUES ('', '$CRU_TO', '$CRU_FRM', '$CRU_WEN', '$CRU_MES')";

    mysqli_query($con, $crunchQRY);

?>