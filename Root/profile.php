<?php
include ("mysql_con.php");
include ("timecal.php");
include ("links.php");
include ("header.php");

$newsFeed = array(); // Array for the newsfeedtab

$browserUSER = $_SESSION['username']; // User that starts the session

if (isset($browserUSER)) {
	$stmt = mysqli_prepare($con, "SELECT id, friends FROM tbl_accounts WHERE username = ?") or die("Unable to prepare statement: " . mysqli_error($con));
	if ($stmt) {
		mysqli_stmt_bind_param($stmt, 's', $browserUSER);
		mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
		mysqli_stmt_bind_result($stmt, $bwsrID, $FRbwsr);
		mysqli_stmt_fetch($stmt);
		$bwsrFR = explode(',', $FRbwsr);
		mysqli_stmt_close($stmt);
	}
}

$getprofilename = mysqli_real_escape_string($con, $_GET['profilename']);

$stmt = mysqli_prepare($con, $query_user_info) or die("Unable to prepare statement: " . mysqli_error($con));
if ($stmt) {
	mysqli_stmt_bind_param($stmt, 's', $getprofilename);
	mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
	mysqli_stmt_bind_result($stmt,
	$pr_id,
	$pr_username,
	$pr_firstname,
	$pr_lastname,
	$pr_showName,
	$pr_xbox,
	$pr_playstation,
	$pr_steam,
	$pr_console,
	$pr_game,
	$pr_quote,
	$pr_bio,
	$pr_rank,
	$pr_since,
	$pr_town,
	$pr_country,
	$pr_website,
	$pr_facebook,
	$pr_twitter,
	$pr_googleplus,
	$pr_level,
	$pr_picture,
	$pr_badges,
	$pr_favs,
	$pr_friends,
	$pr_clan,
	$pr_clantime,
	$pr_photos,
	$pr_cover_pic);
	mysqli_stmt_fetch($stmt);
	mysqli_stmt_close($stmt);
}

$pr_status = array();
$stmt = mysqli_prepare($con, $query_user_status) or die("Unable to prepare statement: " . mysqli_error($con));
if ($stmt) {
	mysqli_stmt_bind_param($stmt, 's', $pr_username);
	mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
	mysqli_stmt_bind_result($stmt, $stts_username, $stts_status, $stts_date_status, $stts_likes);
	while (mysqli_stmt_fetch($stmt)) {
		$stts = array($stts_username, $stts_status, $stts_date_status, $stts_likes);
		array_push($pr_status, $stts);
		array_push($stts, "0");
		array_push($newsFeed, $stts);
	}
}
if (empty($pr_status)) {
	$status = "Greetings outlander!";
	array_push($newsFeed, array($getprofilename, $status, $pr_since, "0", "0"));
}

$stmt = mysqli_prepare($con, $query_user_rank) or die("Unable to prepare statement: " . mysqli_error($con));
if ($stmt) {
	mysqli_stmt_bind_param($stmt, 's', $pr_rank);
	mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
	mysqli_stmt_bind_result($stmt, $pr_rank_name);
	mysqli_stmt_fetch($stmt);
	mysqli_stmt_close($stmt);
}

/* Number of views */
$action = "view";
$views = array();
$stmt = mysqli_prepare($con, $query_user_exp) or die("Unable to prepare statement: " . mysqli_error($con));
if ($stmt) {
	mysqli_stmt_bind_param($stmt, 'ss', $getprofilename, $action);
	mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
	mysqli_stmt_bind_result($stmt, $feedDate, $feedURL);
	while (mysqli_stmt_fetch($stmt)) {
		array_push($views, array($getprofilename, $feedDate, $feedURL));
		array_push($newsFeed, array($getprofilename, "read", $feedDate, $feedURL, "1"));
	}
	mysqli_stmt_close($stmt);
}
$num_rows = sizeof($views);
if ($num_rows == 1) {
	$user_views = 1;
	$text_view = "view";
} else {
	$user_views = $num_rows;
	$text_view = "views";
}

/* Number of bites */
$action = "bite";
$bites = array();
$stmt = mysqli_prepare($con, $query_user_exp) or die("Unable to prepare statement: " . mysqli_error($con));
if ($stmt) {
	mysqli_stmt_bind_param($stmt, 'ss', $getprofilename, $action);
	mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
	mysqli_stmt_bind_result($stmt, $feedDate, $feedURL);
	while (mysqli_stmt_fetch($stmt)) {
		array_push($bites, array($getprofilename, $feedDate, $feedURL));
		array_push($newsFeed, array($getprofilename, "bit", $feedDate, $feedURL, "1"));
	}
	mysqli_stmt_close($stmt);
}
$num_rows = sizeof($bites);
if ($num_rows == 1) {
	$user_bites = 1;
	$text_bite = "bite";
} else {
	$user_bites = $num_rows;
	$text_bite = "bites";
}

/* Articles shared on social media */
$actions = array("social_fb", "social_twitter", "social_gplus");
foreach ($actions as $action) {
	$stmt = mysqli_prepare($con, $query_user_exp) or die("Unable to prepare statement: " . mysqli_error($con));
	if ($stmt) {
		mysqli_stmt_bind_param($stmt, 'ss', $getprofilename, $action);
		mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
		mysqli_stmt_bind_result($stmt, $feedDate, $feedURL);
		while (mysqli_stmt_fetch($stmt)) {
			array_push($newsFeed, array($getprofilename, "shared", $feedDate, $feedURL, "1"));
		}
		mysqli_stmt_close($stmt);
	}
}

/* Number of friends */
if (!empty($pr_friends) || $pr_friends != NULL || $pr_friends != "") { // If the user has friends
	$friends = array();
	$friends_ids = explode(',', $pr_friends); // Creates an array with the ids of each friend
	foreach ($friends_ids as $id) {
		$stmt = mysqli_prepare($con, $query_user_friend) or die("Unable to prepare statement: " . mysqli_error($con));
		if ($stmt) {
			mysqli_stmt_bind_param($stmt, 's', $id);
			mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
			mysqli_stmt_bind_result($stmt, $fr_showname, $fr_username, $fr_firstname, $fr_lastname, $fr_picture);
			while (mysqli_stmt_fetch($stmt)) {
				$friend = array($fr_showname, $fr_username, $fr_firstname, $fr_lastname, $fr_picture);
				array_push($friends, $friend); // Fill the array $friends with the information of every friend
			}
			mysqli_stmt_close($stmt);
		}
	}
	$num_rows = sizeof($friends_ids);
	if ($num_rows == 1) {
		$user_friends = 1;
		$text_friends = "friend";
	} else {
		$user_friends = $num_rows;
		$text_friends = "friends";
	}
} else {
	$text_friends = "no friends";
}

/* Number of achievements */
if (!empty($pr_badges) || $pr_badges != NULL || $pr_badges != "") { // If the user has badges
	$badges = array();
	$badges_array = explode(',', $pr_badges); // Creates an array with the id of each badge
	foreach ($badges_array as $badge) {
		$stmt = mysqli_prepare($con, $query_user_badges) or die("Unable to prepare statement: " . mysqli_error($con));
		if ($stmt) {
			mysqli_stmt_bind_param($stmt, 's', $badge_name, $badge_file);
			mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
			mysqli_stmt_bind_result($stmt, $badge_name, $badge_file);
			while (mysqli_stmt_fetch($stmt)) {
				$badge = array($badge_name, $badge_file);
				array_push($badges, $badge);
			}
			mysqli_stmt_close($stmt);
		}
	}
	$num_rows = sizeof($badges_array);
	if ($num_rows == 1) {
		$user_achievements = 1;
		$text_achievements = "achievement";
	} else {
		$user_achievements = $num_rows;
		$text_achievements = "achievements";
	}
} else {
	$text_achievements = "no badges";
}

/* Number of articles */
$articles_info = array();
//$reviews_info = array();
$stmt = mysqli_prepare($con, $query_user_articles) or die("Unable to prepare statement: " . mysqli_error($con));
if ($stmt) {
	mysqli_stmt_bind_param($stmt, 'ssss', $pr_username, $pr_username, $pr_username, $pr_username);
	mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
	mysqli_stmt_bind_result($stmt, $art_id, $art_type, $art_title, $art_author, $art_gamename, $art_image);
	while (mysqli_stmt_fetch($stmt)) {
		if ($art_type === "Guide") {
			$images = unserialize($art_image);
			$article = array($art_id, $art_type, $art_title, $art_author, $art_gamename, $images[0]);
		} else {
			$article = array($art_id, $art_type, $art_title, $art_author, $art_gamename, $art_image);
		}
		array_push($articles_info, $article);
	}
	mysqli_stmt_close($stmt);
}
$num_rows = sizeof($articles_info);
if ($num_rows == 1) {
	$user_articles = 1;
	$text_articles = "article";
} else {
	$user_articles = $num_rows;
	$text_articles = "articles";
}

/* Clan */
if (!empty($pr_clan) || $pr_clan != NULL || $pr_clan != "") {
	$user_clan = $pr_clan;
} else {
	$user_clan = "No clan";
}

/* Photos */
if (!empty($pr_photos) || $pr_photos != NULL || $pr_photos != "") {
	$photos = explode(',', $pr_photos);
	$photos_var = "true";
} else {
	$photos_var = "false";
	$photos_text = "no pictures";
}

/* Organize the NewsFeed array by date */
function cmp($a, $b){
    $ad = strtotime($a[2]);
    $bd = strtotime($b[2]);
    return ($ad - $bd);
}
usort($newsFeed, 'cmp');

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
		<div class="profile_header">
			<div id="imagesProfile">
				<img title="Cover Picture" id="coverPic" src="imgs/users/<?php echo $pr_cover_pic; ?>.jpg">
				<img title="Profile Picture" id="profilePic" src="imgs/users/<?php echo $pr_picture; ?>-232x270.jpg">
			</div>
			<!-- Add as a friend -->
			<?php
			if($pr_username != $browserUSER && isset($browserUSER)) {
				$requesteeQRY = array();
				$requesterQRY = array();
				$stmt = mysqli_prepare($con, $query_add_friend) or die("Unable to prepare statement: " . mysqli_error($con));
				if ($stmt) {
					mysqli_stmt_bind_param($stmt, 'ii', $pr_id, $bwsrID);
					mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
					mysqli_stmt_bind_result($stmt, $requestee);
					while (mysqli_stmt_fetch($stmt)) {
						array_push($requesteeQRY, $requestee);
					};
					mysqli_stmt_close($stmt);
				}

				$stmt = mysqli_prepare($con, $query_add_friend) or die("Unable to prepare statement: " . mysqli_error($con));
				if ($stmt) {
					mysqli_stmt_bind_param($stmt, 'ii', $bwsrID, $pr_id);
					mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
					mysqli_stmt_bind_result($stmt, $requester);
					while (mysqli_stmt_fetch($stmt)) {
						array_push($requesterQRY, $requester);
					};
					mysqli_stmt_close($stmt);
				}

				if(sizeof($requesteeQRY) > 0) { // The session user send a friend request
					?>
					<button id="requestfriend" name="FriendAdd" type="button" style="cursor: auto !important;"><i class="fa fa-user-o"></i>  Request sent</button>
					<?php
				} else if(sizeof($requesterQRY) > 0) { // The session user receive a friend request
					?>
					<button id="acceptfriend" data-send-user="<?php echo $browserUSER; ?>" data-send-prof="<?php echo $pr_username; ?>" name="FriendAdd" type="button" style="cursor: auto !important;"><i class="fa fa-user"></i>  Accept request</button>
					<?php
				} else if(in_array($pr_id, $bwsrFR)) { // If the session user and the profile user are friends already
					?>
					<button id="friend" name="FriendAdd" type="button" disabled><i class="fa fa-user-o"></i>  Friend</button>
					<?php
				} else if(!in_array($pr_id, $bwsrFR) && sizeof($requesterQRY) < 1 && sizeof($requesteeQRY) < 1) { // If the session user and the profile user are not friends yet and none of them has sent a friend request
					?>
					<button id="addfriend" data-send-user="<?php echo $browserUSER; ?>" data-send-prof="<?php echo $pr_username; ?>" name="FriendAdd" type="button"><i class="fa fa-user-plus"></i>  Add friend</button>
					<?php
				}
			}
			?>
		</div>
		<div id="profile_sidebar">
			<div id="userInfo">
				<span id="NameUser"><?php echo $pr_username; ?></span><span id="levelUser">lvl <?php echo $pr_level; ?></span>
			</div>
			<div id="userStats">
				<div style="padding-top:15px;">
					<span id="userViews"><img id="backStats" src="imgs/stats_icons/views_icon.png"><span id="userStts"><?php echo $user_views; ?><strong id="stats"> <?php echo $text_view; ?></strong></span></span>
					<span id="userBites"><img id="backStats" src="imgs/stats_icons/bites_icon.png"><span id="userStts"><?php echo $user_bites ?><strong id="stats"> <?php echo $text_bite; ?></strong></span></span>
					<span id="userFriends"><img id="backStats" src="imgs/stats_icons/friends_icon.png"><span id="userStts"><?php echo $user_friends; ?><strong id="stats"> <?php echo $text_friends; ?></strong></span></span>
					<span id="userAchievements"><img id="backStats" src="imgs/stats_icons/achievements_icon.png"><span id="userStts"><?php echo $user_achievements; ?><strong id="stats"> <?php echo $text_achievements; ?></strong></span></span>
					<span id="userArticles"><img id="backStats" src="imgs/stats_icons/articles_icon.png"><span id="userStts"><?php echo $user_articles; ?><strong id="stats"> <?php echo $text_articles; ?></strong></span></span>
					<span><img id="backStats" src="imgs/stats_icons/clan_icon.png"><span id="userClanText"><?php echo $user_clan; ?></span>
				</div>
				<br>
			</div>
			<br>
			<div id="userPhotos">
				<span id="photosTag"><i id="backPhotos"><i class="fa fa-camera" aria-hidden="true" style="color:white;"></i></i><span id="textPhotos">photos</span></span>
				<br>
				<?php
				if ($photos_var === "true") { // The user has pictures
					?>
					<img id="main_Pic" src='imgs/users/<?php echo $photos[0]; ?>.jpg' onclick="openModal(); currentSlide(1)">
					<?php
					if (sizeof($photos) > 1) { // The user has just one picture
						?>
						<br>
						<img id="second_Pic" src='imgs/users/<?php echo $photos[1]; ?>.jpg' onclick="openModal(); currentSlide(2)">
						<?php
					} if (sizeof($photos) > 2) { // The user has two pictures
						?>
						<img id="third_Pic" src='imgs/users/<?php echo $photos[2]; ?>.jpg'>
						<b id="third_Pic_text" onclick="openModal(); currentSlide(1)">See more<br>photos</b>
						<?php
					}
					?>
					<!-- Modal -->
					<!-- <div id="modal" class="image_modal">
						<span class="close cursor" onclick="closeModal()">&times;</span>
						<div class="modal_content">
							<?php
							//foreach ($photos as $photo) {
								?>
								<div class="images">
									<img class="modal_photo" src="imgs/users/<?php //echo $photo; ?>.jpg" style="width:100%">
								</div>
								<?php
							//}
							?>
							<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
							<a class="next" onclick="plusSlides(1)">&#10095;</a>

						</div>
					</div> -->
					<?php
				} else { // The user has no pictures
					?>
					<br>
					<span class="sidebar_text"><?php echo $photos_text; ?></span>
					<?php
				}
				?>
			</div>
			<br>
			<div id="userFriendList">
				<span id="FriendsTag"><img id="backStats" src="imgs/stats_icons/friends_icon.png"><span id="textFriends">friends</span></span>
				<br>
				<?php
				if (!empty($friends)) { // If the user has friends
					?>
					<div id="friendsThumbnail">
						<?php
						for ($i = sizeof($friends) - 1; $i >= 0; $i--) {
							if ($i <= 8  || $i <= sizeof($friends)) {
								if ($friends[$i][0]) {
									$name = $friens[$i][2] . " " . $friens[$i][3];
								} else {
									$name = $friens[$i][1];
								}
								echo "<a href='profile.php?profilename=" . $friends[$i][1] . "'><img src='imgs/users/" . $friends[$i][4] . "-116x135.jpg' alt='" . $name . "' ></a>";
							} else {
								$i = sizeof($friends) + 1;
							}
						}
						?>
					</div>
					<?php
				} else {
					echo "<span class='sidebar_text'>This user has no friends</span>";
				} ?>
			</div>
			<br>
		</div>

		<div id="profile_aside">
			<ul class="tabs">
				<li class="tablinks active" data-tab="Activity">Activity</li>
				<li class="tablinks" data-tab="Stats">Stats</li>
				<li class="tablinks" data-tab="Articles">Articles</li>
				<li class="tablinks" data-tab="Clan">Clan</li>
				<li class="tablinks" data-tab="About">About</li>
				<li class="tablinks" data-tab="Contact">Contact</li>
			</ul>

			<div id="Activity" class="tabcontent active">
				<br>
				<?php
				if ($browserUSER === $getprofilename) {
					?>
					<form name="userStatus" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="statusFrame">
						<input type="text" name="status" placeholder="What are you playing?" id="statusInput">
						<br>
						<div style="margin-left:78%">
							<span id="charCount">250</span><button type="button" id="submitStatus" name="submitStatus">Submit</button>
						</div>
					</form>
					<br>
					<?php
				}
				?>
				<hr>
				<div id="news" class="feed">
					<?php
					$feed = array_slice(array_reverse($newsFeed), 0, 9);
					for ($i = 0; $i <= sizeof($feed) - 1; $i++){
						if ($feed[$i][4]) {
							$ttl = preg_split("/(\?t=|\&g=)/", $feed[$i][3]);
							$title = urldecode(str_replace("_", " ", $ttl[1]));
							?>
							<div id="savedAction">
								<img src="imgs/users/<?php echo $pr_picture; ?>-232x270.jpg" alt="<?php echo $getprofilename; ?>">
								<p id="name_action"><?php echo "<b>" . $pr_username . "'s</b> " . $feed[$i][1] . " <a href='" . $feed[$i][3] . "'>" . $title . "</a>"  . " <i>" . humanTiming(strtotime($feed[$i][2])) . " ago</i>"; ?></p>
							</div>
							<?php
						} else {
							?>
							<div id="savedStatus">
								<img src="imgs/users/<?php echo $pr_picture; ?>-232x270.jpg" alt="<?php echo $getprofilename; ?>">
								<p id="name_stts"><?php echo $pr_username; ?></p>
								<p id="timestamp"><?php echo humanTiming(strtotime($feed[$i][2])); ?> ago</p>
								<hr>
								<p id="statusSaved"><?php echo str_replace("-","'", str_replace("_", " ", $feed[$i][1])); ?></p>
							</div>
							<?php
						}
					}
					?>
				</div>
			</div>

			<div id="Stats" class="tabcontent">
				<p>profile bites, article bites, review bites, comments, etc</p>
			</div>

			<div id="Articles" class="tabcontent">
				<br>
				<?php
				if(!empty($articles_info)) {
					?>
					<div class="articlesThumbnail">
						<?php
						for ($i = 0; $i <= sizeof($articles_info) - 1; $i++) {
							// If the article does not have images.
							if (!empty($articles_info[$i][5])) {
								$imgURL = $articles_info[$i][1] . "/" . urlencode($articles_info[$i][5]);
							} else {
								$imgURL = "gsr_raw_logo.jpg";
							}
							echo "<a href='" . $articles_info[$i][1] . ".php?t=" . urlencode(str_replace(' ', '_', $articles_info[$i][2])) . "&g=" . urlencode(str_replace('' , '_', $articles_info[$i][4])) .
							"'>" . "<img src='imgs/". $imgURL . "' alt='" . $articles_info[$i][2] . "'></a>";
							if ($i <= 14) {

							} else {
								$i = sizeof($articles_info) + 1;
							}
						}
						?>
					</div>
					<?php
				} else {
					echo "<p style='text-align:center;font-weight:bold;font-size:16px;color:#e73030'>This user has written no articles</p>";
				}
				?>
			</div>

			<div id="Clan" class="tabcontent">
				<h3>Page under construction</h3>
				<p>Please check back soon.</p>
			</div>

			<div id="About" class="tabcontent">
				<div class="span1">
					<?php
					if ($pr_showName) {
						echo "<h4>" . $pr_firstname . " " . $pr_lastname . "</h4>";
					} else {
						echo "<h4>" . $pr_username . "</h4>";
					}
					echo "<h5>". $pr_rank_name ."</h5>";
					?>
				</div>
				<br>
				<div style="display: flex">
					<div class="span2">
						<h6>bio</h6>
						<?php echo "<p>" . $pr_bio . "</p>"; ?>
					</div>
					<div class="span3">
						<h6>quote</h6>
						<?php echo "<p style='font-style:italic;'>'" . $pr_quote . "'</p>"; ?>
					</div>
				</div>
				<div class="span4">
					<?php
					if ($pr_console != "undefined" || empty($pr_console)) {
						echo "<img id='consoleLove' alt='Favourite console' src='imgs/love_console.png'><p class='favText'>" . $pr_console . "</p>";
					}
					if ($pr_game != "undefined" || empty($pr_game)) {
						echo "<img id='gameLove' alt='Favourite game' src='imgs/1stplace.png'><p class='favText'>" . $pr_game . "</p>";
					}
					?>
				</div>
			</div>

			<div id="Contact" class="tabcontent">
				<?php
				$social = "false";
				if($pr_website != "undefined" || empty($pr_website)) {
					$social = "true";
					?>
					<a href="<?php echo $pr_website; ?>"><img id="webPage" alt="Website" src="imgs/profile_media/www.png">&nbsp;</a>
					<?php
				}
				if ($pr_facebook != "undefined" || empty($pr_facebook)) {
					$social = "true";
					?>
					<a href="<?php echo $pr_facebook; ?>"><img id="Facebook" alt="Website" src="imgs/profile_media/facebook.png">&nbsp;</a>
					<?php
				}
				if ($pr_twitter != "undefined" || empty($pr_twitter)) {
					$social = "true";
					?>
					<a href="<?php echo $pr_twitter; ?>"><img id="Twitter" alt="Website" src="imgs/profile_media/twitter.png">&nbsp;</a>
					<?php
				}
				if ($pr_googleplus != "undefined" || empty($pr_googleplus)) {
					$social = "true";
					?>
					<a href="<?php echo $pr_googleplus; ?>"><img id="Googleplus" alt="Website" src="imgs/profile_media/google-plus.png">&nbsp;</a>
					<?php
				}
				if ($social === "true") {
					?>
					<br>
					<br>
					<p style="font-size:8px;padding:0;text-align:center">Icons made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></p>
					<?php
				} else {
					?>
					<br>
					<p style="text-align:center;font-weight:bold;font-size:16px;color:#e73030">This user cannot be contacted.</p>
					<?php
				}
				?>
			</div>

		</div>
	</div>
	<?php include "footer.html"; ?>
	<script>
	var timeout = 30000 //30 seconds
	setInterval(function () {
		$.ajax({
    type: "POST",
    url: "profile.php?profilename=<?php echo $getprofilename; ?>",
		success: function (data) {
			$("body").html(data);
    }
    });
	}, timeout);

	$("#addfriend").click(function() {
		var sendUser = $(this).attr("data-send-user");
		var sendProf = $(this).attr("data-send-prof");

		var requestFriendURL = "requestfriend.php?user=" + sendUser + "&profile=" + sendProf;
		$.ajax({
			url : requestFriendURL,
			type : "GET",
			async : false,
			success: function() {
				location.reload();
			}
		});
	});

	$("#acceptfriend").click(function() {
		var sendUser = $(this).attr("data-send-user");
		var sendProf = $(this).attr("data-send-prof");

		var addFriendURL = "addfriend.php?user=" + sendUser + "&profile=" + sendProf;
		$.ajax({
			url : addFriendURL,
			type : "GET",
			async : false,
			success: function() {
				location.reload();
			}
		});
	});

	// // Modal
	// function openModal() { // Shows the modal
	// 	document.getElementById("modal").style.display = "block";
	// }
	//
	// function closeModal() { // Hides the modal
	// 	document.getElementById("modal").style.display = "none";
	// }
	//
	// var slideIndex = 1;
	// showSlides(slideIndex);
	//
	// function plusSlides(n) {
	// 	showSlides(slideIndex += n);
	// }
	//
	// function currentSlide(n) {
	// 	showSlides(slideIndex = n);
	// }
	//
	// function showSlides(n) {
	// 	var i;
	// 	var slides = document.getElementsByClassName("images");
	// 	if (n > slides.length) {
	// 		slideIndex = 1;
	// 	}
	// 	if (n < 1) {
	// 		slideIndex = slides.length
	// 	}
	// 	for (i = 0; i < slides.length; i++) {
	// 		slides[i].style.display = "none";
	// 	}
	// 	slides[slideIndex-1].style.display = "block";
	// }

	$(document).ready(function() {
		$('ul.tabs li').click(function() {
			var tab_id = $(this).attr('data-tab');
			$('ul.tabs li').removeClass('active');
			$('.tabcontent').removeClass('active');
			$(this).addClass('active');
			$("#" + tab_id).addClass('active');
		});
	});

	$('#statusInput').on('keyup', function() {
		var chars = $(this).val().length;
		$('#charCount').text(250 - chars);
		if (chars >= 251) {
			$('#charCount').text(250 - chars);
			$('#charCount').css('color', '#e73030');
			$('#submitStatus').prop('disabled', true);
		} else {
			$('#charCount').css('color', '#808080');
			$('#submitStatus').prop('disabled', false);
		}
	});

	$('#submitStatus').click(function() {
		var user = "<?php echo $getprofilename; ?>";
		var status = $('#statusInput').val().split(' ').join('_');
		status = status.replace(/'/g, "-");
		var statusURL = "newstatus.php?user=" + user + "&stt=" + status;
		$.ajax({
			url : statusURL,
			type : "GET",
			async : false,
			success: function() {
				location.reload();
			}
		});
	});
	</script>
</body>
</html>
