<?php
	include "mysql_con.php";

	$user = $_SESSION['username'];

	if(!isset($user)) { header("location:index.php"); }

	$accountQRY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$user'");

	while($SAQRY = mysqli_fetch_assoc($accountQRY)) {
		$acc_firstname	= $SAQRY['firstname'];
		$acc_lastname	= $SAQRY['lastname'];
		$acc_fullname	= $acc_firstname . " " . $acc_lastname;
		$acc_posa		= $SAQRY['posa'];
		$acc_posb		= $SAQRY['posb'];
		$acc_position	= $acc_posa . " " . $acc_posb;
	}

	if(!has_perms("dashboard")){
		header("Location: index.php");
	}

	if(has_perms("dashboard-announcement")) {
	if(isset($_POST['announcement'])){
		$update_msg = mysqli_real_escape_string($con, $_POST['announcement']);
		$msg_query = "INSERT INTO tbl_dashboard_msg (message, username) 
		VALUES ('$update_msg', '$user')";
		if (!mysqli_query($con, $msg_query)) {
		die("Error: " . $msg_query . "<br>" . mysqli_error($con));
		}
		if(isset($_POST['dashboard_chat'])){
			die("Announcement has been updated! Reload page to see the new one.");
		}
	}
	}
	
?>

<!doctype html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, follow, noarchive">

<title>Dashboard | Staff Announcements | GSR</title>

<meta name="description" content="Modify and adjust articles and uploaded images.">

<?php include "links.php"; ?>

</head>

<body>

	<?php include "header.php"; ?>

	<div id="page" class="container_24">

		<article>

			<section id="articlelist">
			
			<?php include 'dashboard-nav.php';?>
			
			<div id="db-main">
				<? if(has_perms("dashboard-announcement")) { ?>
				<h3>Update Announcement</h3>
				<form action="staff-announcement.php" method="post" id="update_announcement">
				<input type="text" name="announcement" placeholder="Announcement"/>
				<button type="submit">Update</button>
				</form>
				<br />
				<?php } ?>
				<h3>Current Announcement</h3>
				<?php include 'dashboard-msg.php';?>
				<br />
				<h3>Announcement History</h3>
				
				
				<?php
				$msgQuery1 = mysqli_query($con, "SELECT * FROM tbl_dashboard_msg ORDER BY id DESC");
				while ($msgROW1 = mysqli_fetch_assoc($msgQuery1)) {
					$msg_id1    = $msgROW1['id'];
					$staff_msg1 = $msgROW1['message'];
					$msg_time1  = date('d/m/Y', strtotime($msgROW1['timestamp']));
					$msg_user1  = $msgROW1['username'];
					$msgAccountQRY1 = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$msg_user1'");
					while($msgAQRY1 = mysqli_fetch_assoc($msgAccountQRY1)) {
						$msg_firstname1	= $msgAQRY1['firstname'];
						$msg_lastname1	= $msgAQRY1['lastname'];
						$msg_fullname1	= $msg_firstname1 . " " . $msg_lastname1;
					}
					if($msg_id1!=$msg_id){
					echo '<div class="announcement-list">';
					echo "<b>[".$msg_time1."] ".$msg_fullname1.":</b> ".$staff_msg1;
					echo "</div>";	
					}	
				}	
				?>
				
				
				</div>
			</section>

		</article>

	</div>

	<?php include "footer.html"; ?>


</body>
</html>