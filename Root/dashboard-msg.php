<br /><br />
<div data-id="1" class="sort" id="row_1">
<?php
$msgQuery = mysqli_query($con, "SELECT * FROM tbl_dashboard_msg ORDER BY id DESC LIMIT 1");
while ($msgROW = mysqli_fetch_assoc($msgQuery)) {
	$msg_id    = $msgROW['id'];
	$staff_msg = $msgROW['message'];
	$msg_time  = date('d/m/Y', strtotime($msgROW['timestamp']));
	$msg_user  = $msgROW['username'];
	$msgAccountQRY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$msg_user'");
	while($msgAQRY = mysqli_fetch_assoc($msgAccountQRY)) {
		$msg_firstname	= $msgAQRY['firstname'];
		$msg_lastname	= $msgAQRY['lastname'];
		$msg_fullname	= $msg_firstname . " " . $msg_lastname;
	}
	echo "<b>[".$msg_time."] ".$msg_fullname.":</b> ".$staff_msg;
}	
?>
</div>