<?php
include ("mysql_con.php");
include ("timecal.php");
include ("links.php");
include ("header.php");

$browserUSER = $_SESSION['username']; // User that starts the session
if (isset($browserUSER)) {
	$stmt = mysqli_prepare($con, $query_user_info) or die("Unable to prepare statement: " . mysqli_error($con));
	if ($stmt) {
		mysqli_stmt_bind_param($stmt, 's', $browserUSER);
		mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
		$bwsrQRY = mysqli_stmt_get_result($stmt);
		while ($bwsrROW = mysqli_fetch_array($bwsrQRY)) {
			$bwsrID = $bwsrROW['id'];
			$bwsrFR = explode(',', $bwsrROW['friends']);
		}
		mysqli_stmt_close($stmt);
	}
}

$getprofilename = mysqli_real_escape_string($con, $_GET['profilename']);

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
	$pr_cover_pic = $prof['cover_pic'];
	$pr_badges = $prof['badges'];
	$pr_favs = $prof['favourites'];
	$pr_friends	= $prof['friends'];
	$pr_clan = $prof['clan'];
	$pr_clantime = $prof['clantime'];
	$pr_cotype = $prof['cotype'];
	$pr_photos = $prof['photos'];
}

if($pr_picture == NULL || $pr_picture == "" || empty($pr_picture)) {
	$pr_image = "default";
} else {
	$pr_image = $pr_picture;
}

if($pr_cover_pic == NULL || $pr_cover_pic == "" || empty($pr_cover_pic)) {
	$pr_cover = "default_cover";
} else {
	$pr_cover = $pr_cover_pic;
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
	$friends = array();
	$friends_ids = explode(',', $pr_friends); // Creates an array with the ids of each friend
	foreach ($friends_ids as $id) {
		$stmt = mysqli_prepare($con, $query_user_friend) or die("Unable to prepare statement: " . mysqli_error($con));
		if ($stmt) {
			mysqli_stmt_bind_param($stmt, 's', $id);
			mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
			$friend_info = mysqli_stmt_get_result($stmt);
			while ($friend_row = mysqli_fetch_array($friend_info)) {
				array_push($friends, $friend_row); // Fill the array $friends with the information of every friend
			}
			mysqli_stmt_close($stmt);
		}
	}
	//echo $friends[0]['username'] . " Hello";
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
			mysqli_stmt_bind_param($stmt, 's', $badge);
			mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
			$badge_info = mysqli_stmt_get_result($stmt);
			while ($badge_row = mysqli_fetch_array($badge_info)) {
				array_push($badges, $badge_row); // Fill the array $badges with the information of every badge
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
$reviews_info = array();
$stmt = mysqli_prepare($con, $query_user_articles) or die("Unable to prepare statement: " . mysqli_error($con));
if ($stmt) {
	mysqli_stmt_bind_param($stmt, 'sss', $pr_username, $pr_username, $pr_username);
	mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
	$us_articles = mysqli_stmt_get_result($stmt);
	while ($article_row = mysqli_fetch_array($us_articles)) {
		array_push($articles_info, $article_row);
	}
	mysqli_stmt_close($stmt);
}
$stmt = mysqli_prepare($con, $query_user_review) or die("Unable to prepare statement: " . mysqli_error($con));
if ($stmt) {
	mysqli_stmt_bind_param($stmt, 's', $pr_username);
	mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
	$us_reviews = mysqli_stmt_get_result($stmt);
	while ($review_row = mysqli_fetch_array($us_reviews)) {
		array_push($reviews_info, $review_row);
	}
	mysqli_stmt_close($stmt);
}
$num_rows = sizeof($articles_info) + sizeof($reviews_info);
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
				<img title="Cover Picture" id="coverPic" src="imgs/users/<?php echo $pr_cover; ?>.jpg">
				<img title="Profile Picture" id="profilePic" src="imgs/users/<?php echo $pr_image; ?>-232x270.jpg">
			</div>
			<!-- Add as a friend -->
			<?php
			if($pr_username != $browserUSER && isset($browserUSER)) {
				//$query_add_friend = "SELECT * FROM tbl_requests WHERE requestee = ? AND requester = ?";
				$stmt = mysqli_prepare($con, $query_add_friend) or die("Unable to prepare statement: " . mysqli_error($con));
				if ($stmt) {
					mysqli_stmt_bind_param($stmt, 'ii', $pr_id, $bwsrID);
					mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
					$requesteeQRY = mysqli_stmt_get_result($stmt);
					mysqli_stmt_close($stmt);
				}

				$stmt = mysqli_prepare($con, $query_add_friend) or die("Unable to prepare statement: " . mysqli_error($con));
				if ($stmt) {
					mysqli_stmt_bind_param($stmt, 'ii', $bwsrID, $pr_id);
					mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
					$requesterQRY = mysqli_stmt_get_result($stmt);
					mysqli_stmt_close($stmt);
				}

				if(mysqli_num_rows($requesteeQRY) > 0) { // The session user send a friend request
					?>
					<button id="requestfriend" name="FriendAdd" type="button" style="cursor: auto !important;"><i class="fa fa-user-o"></i>  Request sent</button>
					<?php
				} else if(mysqli_num_rows($requesterQRY) > 0) { // The session user receive a friend request
					?>
					<button id="acceptfriend" data-send-user="<?php echo $browserUSER; ?>" data-send-prof="<?php echo $pr_username; ?>" name="FriendAdd" type="button" style="cursor: auto !important;"><i class="fa fa-user"></i>  Accept request</button>
					<?php
				} else if(in_array($pr_id, $bwsrFR)) { // If the session user and the profile user are friends already
					?>
					<button id="friend" name="FriendAdd" type="button" disabled><i class="fa fa-user-o"></i>  Friend</button>
					<?php
				} else if(!in_array($pr_id, $bwsrFR) && mysqli_num_rows($requesterQRY) < 1 && mysqli_num_rows($requesteeQRY) < 1) { // If the session user and the profile user are not friends yet and none of them has sent a friend request
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
					<div id="modal" class="image_modal">
						<span class="close cursor" onclick="closeModal()">&times;</span>
						<div class="modal_content">
							<?php
							foreach ($photos as $photo) {
								?>
								<div class="images">
									<img class="modal_photo" src="imgs/users/<?php echo $photo; ?>.jpg" style="width:100%">
								</div>
								<?php
							}
							?>
							<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
							<a class="next" onclick="plusSlides(1)">&#10095;</a>

						</div>
					</div>
					<?php
				} else { // The user has no pictures
					?>
					<br>
					<span id="photo_gallery_text"><?php echo $photos_text; ?></span>
					<?php
				}
				?>
			</div>
			<br>
		</div>
		<div id="profile_aside">
			<div class="tab">
				<button class="tablinks" onclick="openTab(event, 'Activity')" id="defaultOpen">Activity</button>
				<button class="tablinks" onclick="openTab(event, 'Status')">Status</button>
				<button class="tablinks" onclick="openTab(event, 'Articles')">Articles</button>
				<button class="tablinks" onclick="openTab(event, 'Clan')">Clan</button>
				<button class="tablinks" onclick="openTab(event, 'About')">About</button>
				<button class="tablinks" onclick="openTab(event, 'Contact')">Contact</button>
			</div>

			<div id="Activity" class="tabcontent">
				<h3 class="tab_header">Activity tab</h3>
				<p class="paragraph">Real time changes.</p>
			</div>

			<div id="Status" class="tabcontent">
				<br>
				<!-- 250 character max... -->

			</div>

			<div id="Articles" class="tabcontent">
				<br>

			</div>

			<div id="Clan" class="tabcontent">
				<br>
				<h3 class="tab_header">Page under construction</h3>
				<p class="paragraph">Please check back soon.</p>
				<br>
			</div>

			<div id="About" class="tabcontent">
				<!--<h3>About</h3>
				<p>Biography
				favourite quote
				game platforms

				$pr_firstname	= $prof['firstname'];
				$pr_lastname = $prof['lastname'];
				$showName	= $prof['showname'];
				$pr_xbox = $prof['xbox'];
				$pr_playstation	= $prof['playstation'];
				$pr_steam = $prof['steam'];
				$pr_console	= $prof['console'];
				$pr_game = $prof['game'];
				$pr_quote	= $prof['quote']; *
				$pr_bio	= $prof['biography']; *

				$pr_since	= strtotime($prof['since']); *
				$pr_town = $prof['town']; *
				$pr_country	= $prof['country']; *


				$pr_favs = $prof['favourites'];
				$pr_friends	= $prof['friends'];

				$pr_cotype = $prof['cotype']; ?????
				</p>-->
				<br>
				<p style="font-size:16px;font-weight:500;margin:0;padding:0">Plays from <?php echo $pr_town . ", " . $pr_country; ?> since <?php echo humanTiming($pr_since); ?></p>
				<br>
				<h3 class="tab_header">Biography</h3>
				<p class="paragraph"><?php echo $pr_bio; ?></p>
				<br>
				<h3 class="tab_header">Favourite Quote</h3>
				<p class="paragraph"><?php echo $pr_quote; ?></p>
				<br>
			</div>

			<div id="Contact" class="tabcontent">
				<br>
				<?php
				if($pr_website != "undefined" || empty($pr_website)) {
					?>
					<a href="<?php echo $pr_website; ?>" class="socialMedia"><img class="socialIcon" alt="Website" src="imgs/profile_media/www.png">&nbsp;</a>
					<?php
				}
				if($pr_faceboook != "undefined" || empty($pr_faceboook)) {
					?>
					<a href="<?php echo $pr_faceboook; ?>" class="socialMedia"><img class="socialIcon" alt="Website" src="imgs/profile_media/facebook.png">&nbsp;</a>
					<?php
				}
				if($pr_twitter != "undefined" || empty($pr_twitter)) {
					?>
					<a href="<?php echo $pr_twitter; ?>" class="socialMedia"><img class="socialIcon" alt="Website" src="imgs/profile_media/twitter.png">&nbsp;</a>
					<?php
				}
				if($pr_googleplus != "undefined" || empty($pr_googleplus)) {
					?>
					<a href="<?php echo $pr_googleplus; ?>" class="socialMedia"><img class="socialIcon" alt="Website" src="imgs/profile_media/google-plus.png">&nbsp;</a>
					<?php
				}
				if ($pr_website != "undefined" || empty($pr_website) && $pr_faceboook != "undefined" || empty($pr_faceboook) && $pr_twitter != "undefined" || empty($pr_twitter) && $pr_googleplus != "undefined" || empty($pr_googleplus)) {
					?>
					<br>
					<br>
					<p style="font-size:8px;text-align:center">Icons made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></p>
					<?php
				} else {
					?>
					<p style="text-align:center;font-weight:bold;color:#e73030">This user cannot be contacted.</p>
					<?php
				}
				?>
				<br>
			</div>
		</div>
	</div>
	<?php include "footer.html"; ?>
	<script>
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

	// Modal
	function openModal() { // Shows the modal
		document.getElementById("modal").style.display = "block";
	}

	function closeModal() { // Hides the modal
		document.getElementById("modal").style.display = "none";
	}

	var slideIndex = 1;
	showSlides(slideIndex);

	function plusSlides(n) {
		showSlides(slideIndex += n);
	}

	function currentSlide(n) {
		showSlides(slideIndex = n);
	}

	function showSlides(n) {
		var i;
		var slides = document.getElementsByClassName("images");
		if (n > slides.length) {
			slideIndex = 1;
		}
		if (n < 1) {
			slideIndex = slides.length
		}
		for (i = 0; i < slides.length; i++) {
			slides[i].style.display = "none";
		}
		slides[slideIndex-1].style.display = "block";
	}

	// Get the element with id="defaultOpen" and click on it
	document.getElementsByClassName('tablinks')[0].click();
	function openTab(evt, cityName) {
		var i, tabcontent, tablinks;
		tabcontent = document.getElementsByClassName("tabcontent");
		for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		}
		tablinks = document.getElementsByClassName("tablinks");
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
		}
		document.getElementById(cityName).style.display = "block";
		evt.currentTarget.className += " active";
	}
	</script>
</body>
</html>
