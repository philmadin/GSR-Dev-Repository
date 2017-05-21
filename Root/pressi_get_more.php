<?php 

	session_start();

	include "mysql_con.php";

	$table = "tbl_" . strtolower($_GET['article_type']);
	$idget = $_GET['article_id'];
	$userget = $_GET['article_user'];

	$actQRY = mysqli_query($con, "SELECT bites, views FROM " . $table . " WHERE id = '$idget'");
	$actROW = mysqli_fetch_assoc($actQRY);

	$authQRY = mysqli_query($con, "SELECT firstname, lastname, rank, picture FROM tbl_accounts WHERE username = '$userget'");
	$authROW = mysqli_fetch_assoc($authQRY);

	$posQRY = mysqli_query($con, "SELECT name FROM tbl_ranks WHERE id = '" . $authROW['rank'] . "'");
	$posROW = mysqli_fetch_assoc($posQRY);

	echo '<p class="pressi-activity">';
		echo number_format($actROW['bites']) . ' <b>BITES</b><br>';
		echo number_format($actROW['views']) . ' <b>VIEWS</b><br>';
	echo '</p>';

	echo '<div class="pressi-author">';
		echo '<p>';
			echo '<a class="pressi-name">' . $authROW['firstname'] . '<br>' . $authROW['lastname'] . '</a>';
			echo '<a class="pressi-user" href="/profile.php?profilename=' . $userget . '">' . $userget . '</a>';
			echo '<a class="pressi-position">' . $posROW['name'] . '</a>';
		echo '</p>';
		if(empty($authROW['picture'])) { $authPIC = "default"; } else { $authPIC = $authROW['picture']; }
		echo '<img src="/imgs/users/' . $authPIC . '-116x135.jpg">';
	echo '</div>';

?>