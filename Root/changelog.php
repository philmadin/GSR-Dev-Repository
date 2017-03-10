<?php
function formDate($fromdate){
$date = date_create_from_format('j/n/Y', $fromdate);
return date_format($date, 'jS M, Y');
}
?>
<!doctype html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Version History | GSR Changelog | GSR</title>

<meta name="description" content="The history of changes throughout the creation of the site.">

<?php include "links.php"; ?>

</head>

<body>

	<?php include "header.php"; ?>

	<div id="page" class="container_24">
	<div id="changelog-page">
	<h2>Version History</h2>
	<?php
include 'mysql_con.php';

	$rQUERY = mysqli_query($con, "SELECT DISTINCT version FROM tbl_changelog WHERE comingsoon = 0 ORDER by version DESC");
	while($rROW = mysqli_fetch_assoc($rQUERY)) {
    $versionNum = $rROW['version'];
	echo '<h4>Version '.$versionNum.'</h4>';
	echo '<ul>';
	$aQUERY = mysqli_query($con, "SELECT * FROM tbl_changelog WHERE version = $versionNum AND comingsoon = 0 ORDER by id DESC");
	while($aROW = mysqli_fetch_assoc($aQUERY)) {
		$description = $aROW['description'];
		$dateof = $aROW['dateof'];
		echo '<li>'.$description.'</li>';
	}
	echo '</ul><br />';
	
	}
	
	
mysqli_close($con);
?>
</div>
	</div>

	<?php include "footer.html"; ?>




</body>
</html>