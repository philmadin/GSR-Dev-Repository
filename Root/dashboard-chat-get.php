<?php
include 'mysql_con.php';


	$user = $_SESSION['username'];

	if(!isset($user)) { die(); }

	if(!has_perms("dashboard")){
		die();
	}

$msg_array = array();
	$query = mysqli_query($con, "SELECT * FROM tbl_dashboard_chat ORDER by id DESC LIMIT 100");

	while($row = mysqli_fetch_assoc($query)) {
		$newrow = $row;
		$newrow['user'] = strtoupper($row['user']);
		$newrow['username'] = $row['user'];
		$accountQRY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '".$newrow['username']."'");
		if(mysqli_num_rows($accountQRY)>0){
		while($SAQRY = mysqli_fetch_assoc($accountQRY)) {
		$acc_firstname	= $SAQRY['firstname'];
		$acc_lastname	= $SAQRY['lastname'];
		$acc_fullname	= $acc_firstname . " " . $acc_lastname;
		}
		$newrow['name'] = 	$acc_fullname;
		}
		else{
		$newrow['name'] = $row['user'];
		}
		$newrow['time'] = date("g:ia", strtotime($row['timestamp']));
		$newrow['timestamp'] = $row['timestamp'];
		$newrow['message'] = addslashes($row['message']);
		$msg_array[] = $newrow;
	}
	echo json_encode(array_reverse($msg_array), JSON_HEX_QUOT | JSON_HEX_TAG);	
?>

