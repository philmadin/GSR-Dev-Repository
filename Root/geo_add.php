<?php
include 'mysql_con.php';

$hex = stringToColorCode($_GET['c']);
echo '<a href="http://colorpicker.com/'.$hex.'">'.$hex.'</a>';


?>