<!doctype html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Coming Soon! | Upcoming features to GSR | GSR</title>

<meta name="description" content="These are the features that will come in future versions of the site.">

<?php include "links.php"; ?>

</head>

<body>

	<?php include "header.php"; ?>

	<div id="page" class="container_24">
	<div id="coming-soon-page">
	<h2>Coming Soon to GSR</h2>
	<?php
include 'mysql_con.php';

	$rQUERY = mysqli_query($con, "SELECT DISTINCT version FROM tbl_changelog ORDER by version DESC LIMIT 1");
	while($rROW = mysqli_fetch_assoc($rQUERY)) {
    $versionNum = $rROW['version'];
	echo '<ul>';
	$aQUERY = mysqli_query($con, "SELECT * FROM tbl_changelog WHERE version = $versionNum AND comingsoon = 1");
	while($aROW = mysqli_fetch_assoc($aQUERY)) {
		$description = $aROW['description'];
		echo '<li>'.$description.'</li>';
	}
	echo '</ul>';
	
	}
	
	
mysqli_close($con);
?>

<center><a href="changelog.php">Version history</a></center>
</div>
	</div>

	<?php include "footer.html"; ?>




</body>
</html>