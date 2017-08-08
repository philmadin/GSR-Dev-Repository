<?php
include ("mysql_con.php");
include ("timecal.php");
include ("links.php");
include ("header.php");

$browserUSER = $_GET['profilename'];
$getprofilename = mysqli_real_escape_string($con, $browserUSER);

$stmt = mysqli_prepare($con, $query_user_info) or die("Unable to prepare statement: " . mysqli_error($con));
if ($stmt) {
	mysqli_stmt_bind_param($stmt, 's', $getprofilename);
	mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
	$proQRYA = mysqli_stmt_get_result($stmt);
	mysqli_stmt_close($stmt);
}

while ($prof = mysqli_fetch_array($proQRYA)) {
	$pr_id = $prof['id'];
	$pr_username = $prof['username'];
	$pr_firstname	= $prof['firstname'];
	$pr_lastname = $prof['lastname'];
	$showName	= $prof['showname'];
	$pr_xbox = $prof['xbox'];
	$pr_playstation	= $prof['playstation'];
	$pr_steam = $prof['steam'];
	$pr_console	= $prof['console'];
	$pr_game = $prof['game'];
	$pr_quote	= $prof['quote'];
	$pr_bio	= $prof['biography'];
	$pr_rank = $prof['rank'];
	$pr_since	= strtotime($prof['since']);
	$pr_town = $prof['town'];
	$pr_country	= $prof['country'];
	$pr_website	= $prof['website'];
	$pr_faceboook	= $prof['facebook'];
	$pr_twitter	= $prof['twitter'];
	$pr_googleplus = $prof['googleplus'];
	$pr_level	= $prof['level'];
	$pr_picture	= $prof['picture'];
	$pr_badges = $prof['badges'];
	$pr_favs = $prof['favourites'];
	$pr_friends	= $prof['friends'];
	$pr_clan = $prof['clan'];
	$pr_clantime = $prof['clantime'];
	$pr_cotype = $prof['cotype'];
}

if($pr_picture == NULL || $pr_picture == "" || empty($pr_picture)) {
	$pr_image = "default";
} else {
	$pr_image = $pr_picture;
}

/* Number of views */
$action = "view";
$stmt = mysqli_prepare($con, $query_user_exp) or die("Unable to prepare statement: " . mysqli_error($con));
if ($stmt) {
	mysqli_stmt_bind_param($stmt, 'ss', $getprofilename, $action);
	mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
	$statsUser = mysqli_stmt_get_result($stmt);
	mysqli_stmt_close($stmt);
}
$num_rows = mysqli_num_rows($statsUser);
if ($num_rows == 1) {
	$user_views = 1;
	$text_view = "view";
} else {
	$user_views = $num_rows;
	$text_view = "views";
}

/* Number of bites */
$action = "bite";
$stmt = mysqli_prepare($con, $query_user_exp) or die("Unable to prepare statement: " . mysqli_error($con));
if ($stmt) {
	mysqli_stmt_bind_param($stmt, 'ss', $getprofilename, $action);
	mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
	$statsUser = mysqli_stmt_get_result($stmt);
	mysqli_stmt_close($stmt);
}
$num_rows = mysqli_num_rows($statsUser);
if ($num_rows == 1) {
	$user_bites = 1;
	$text_bite = "bite";
} else {
	$user_bites = $num_rows;
	$text_bite = "bites";
}

/* Number of friends */
if (!empty($pr_friends) || $pr_friends != NULL || $pr_friends != "") { // If the user has friends
	// $stmt = mysqli_prepare($con, $query_user_frndachi) or die("Unable to prepare statement: " . mysqli_error($con));
	// if ($stmt) {
	//
	// }
	$friends_array = explode(',', $pr_friends);
	$num_rows = sizeof($friends_array);
	if ($num_rows == 1) {
		$user_friends = 1;
		$text_friends = "friend";
	} else {
		$user_friends = $num_rows;
		$text_friends = "friends";
	}
} else {
	$text_friends = "You have no friends";
}

/* Number of achievements */
if (!empty($pr_badges) || $pr_badges != NULL || $pr_badges != "") {
	$badges_array = explode(',', $pr_badges);
	$num_rows = sizeof($badges_array);
	if ($num_rows == 1) {
		$user_achievements = 1;
		$text_achievements = "achievement";
	} else {
		$user_achievements = $num_rows;
		$text_achievements = "achievements";
	}
} else {
	$text_achievements = "You have no badges";
}

/* Number of articles */
$test = $pr_username;
$stmt = mysqli_prepare($con, $query_user_articles) or die("Unable to prepare statement: " . mysqli_error($con));
if ($stmt) {
	mysqli_stmt_bind_param($stmt, 'ssss', $test, $test, $test, $test);
	mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
	$us_articles = mysqli_stmt_get_result($stmt);
	mysqli_stmt_close($stmt);
}
$num_rows = mysqli_num_rows($us_articles);
if ($num_rows == 0) {
	$text_articles = "You have not articles";
} elseif ($num_rows == 1) {
	$user_articles = 1;
	$text_articles = "article";
}else {
	$user_articles = $num_rows;
	$text_articles = "articles";
}

/* Clan */
if (!empty($pr_clan) || $pr_clan != NULL || $pr_clan != "") {
	$user_clan = $pr_clan;
} else {
	$user_clan = "No clan";
}
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="index, follow, noarchive">
	<title><?php echo $pr_username; ?>'s Profile Page | GSR</title>
	<meta name="description" content="GSR - Welcome to <?php echo $pr_username; ?>'s profile page!">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<div id="page" class="container_24">
		<div id="imagesProfile">
			<img title="Cover Picture" id="coverPic" src="https://i.ytimg.com/vi/3CfTnEAmIwA/maxresdefault.jpg">
			<img title="Profile Picture" id="profilePic" src="imgs/users/<?php echo $pr_image; ?>-232x270.jpg">
		</div>
		<!-- Add as a friend -->
		<?php
		if($pr_username != $browserUSER && isset($browserUSER)) { // Don't show the button in the user profile that has started the session
			?>
			<button class="FriendAdd" name="FriendAdd" type="button"><i class="fa fa-user-plus"></i>  Add friend</button>
			<?php
		}
		?>
		<div id="userInfo">
			<span id="NameUser"><?php echo $pr_username; ?></span><span id="levelUser">lvl <?php echo $pr_level; ?></span>
		</div>
		<div id="userStats">
			<div style="padding-top:15px;padding-bottom:15px;">
				<span id="userViews"><img id="backStats" src="imgs/stats_icons/views_icon.png"><span id="userStts"><?php echo $user_views; ?><strong id="stats"> <?php echo $text_view; ?></strong></span></span>
				<span id="userBites"><img id="backStats" src="imgs/stats_icons/bites_icon.png"><span id="userStts"><?php echo $user_bites ?><strong id="stats"> <?php echo $text_bite; ?></strong></span></span>
				<span id="userFriends"><img id="backStats" src="imgs/stats_icons/friends_icon.png"><span id="userStts"><?php echo $user_friends; ?><strong id="stats"> <?php echo $text_friends; ?></strong></span></span>
				<span id="userAchievements"><img id="backStats" src="imgs/stats_icons/achievements_icon.png"><span id="userStts"><?php echo $user_achievements; ?><strong id="stats"> <?php echo $text_achievements; ?></strong></span></span>
				<span id="userArticles"><img id="backStats" src="imgs/stats_icons/articles_icon.png"><span id="userStts"><?php echo $user_articles; ?><strong id="stats"> <?php echo $text_articles; ?></strong></span></span>
				<span><img id="backStats" src="imgs/stats_icons/clan_icon.png"><span id="userClan"><?php echo $user_clan; ?></span>
			</div>
			<br>
		</div>
		<br>
		<div id="userPhotos">
			<span id="photosTag"><i id="backPhotos"><i class="fa fa-camera" aria-hidden="true" style="color:white;"></i></i><span id="textPhotos">photos</span></span>
		</div>
		<br>
	</div>
	<?php include "footer.html"; ?>
</body>
</html>
