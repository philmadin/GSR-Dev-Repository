<?php
include "mysql_con.php";
$user = $_SESSION['username'];
$rows = $_POST['row'];

$row_array = serialize($rows);


mysqli_query($con, "UPDATE tbl_accounts SET dashboard_rows = '$row_array' WHERE username = '$user'");
?>