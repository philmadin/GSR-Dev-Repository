<?php
	include "mysql_con.php";
	//include 'videos-get.php';

	$user = $_SESSION['username'];

	usort($v['i'], function($a, $b) {
    return $a['i']['statistics']['viewCount'] - $b['i']['statistics']['viewCount'];
	});

	if(!isset($user)) { header("location:index.php"); }

	$accountQRY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$user'");

	while($SAQRY = mysqli_fetch_assoc($accountQRY)) {
		$acc_firstname	= $SAQRY['firstname'];
		$acc_lastname	= $SAQRY['lastname'];
		$acc_fullname	= $acc_firstname . " " . $acc_lastname;
		$acc_posa		= $SAQRY['posa'];
		$acc_posb		= $SAQRY['posb'];
		$acc_position	= $acc_posa . " " . $acc_posb;
		$acc_db_rows    = unserialize($SAQRY['dashboard_rows']);
	}

if(!has_perms("dashboard")){
	header("Location: index.php");
}
	
	
function formatNum($num) {
	if(!isset($num)){return false;}
  $x = round($num);
  $x_number_format = number_format($x);
  $x_array = explode(',', $x_number_format);
  $x_parts = array('k', 'm', 'b', 't');
  $x_count_parts = count($x_array) - 1;
  $x_display = $x;
  $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
  $x_display .= $x_parts[$x_count_parts - 1];
  return $x_display;
}

	


?>

<!doctype html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, follow, noarchive">

<title>Dashboard | Home | GSR</title>

<meta name="description" content="Staff Dashboard">

<?php include "links.php"; ?>

</head>

<body>

	<?php include "header.php"; ?>

	<div id="page" class="container_24">

		<article>

			<section id="dashboard">
	
			<?php include 'dashboard-nav.php';?>
			
			<div id="db-main">
			
<!--ROW1 START-->
<?php include 'dashboard-msg.php';?>
<!--ROW1 END-->
	
			</div>
			

			</section>

		</article>

	</div>

	<?php include "footer.html"; ?>
	
	
</body>
</html>
