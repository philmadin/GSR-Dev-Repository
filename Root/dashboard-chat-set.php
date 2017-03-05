<?php
include 'mysql_con.php';

$filename = 'dashboard-chat.txt';
$user = $_SESSION['username'];

$msg_str = trim(strip_tags($_POST['msg_str']));
$url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i'; 
$msg_str = preg_replace($url, '<a href="$0" target="_blank" title="$0">link</a>', $msg_str);
$msg_str = mysqli_real_escape_string($con, $msg_str);
$timestamp = date('Y-m-d G:i:s');

$sql = "INSERT INTO tbl_dashboard_chat (user, message, timestamp)
VALUES ('$user', '$msg_str', '$timestamp')";

if (!mysqli_query($con, $sql)) {
	echo("Error description: " . mysqli_error($con));
}

?>