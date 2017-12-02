<?php
include ("mysql_con.php");
include ("timecal.php");
include ("links.php");
include ("header.php");
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
	$pr_cover_pic);
	mysqli_stmt_fetch($stmt);
	mysqli_stmt_close($stmt);
}
if (strcmp($pr_cover_pic, "default_cover") !== 0) {
	$pr_cover_pic .= "-851x315";
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
	}
	mysqli_stmt_close($stmt);
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
	}
	mysqli_stmt_close($stmt);
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
$artIds = array();
$num_views = 0; // Total number of views the articles of the user have
$user_bites = 0; // Total of bites the articles of the user have
$stmt = mysqli_prepare($con, $query_user_art_info) or die("Unable to prepare statement: " . mysqli_error($con));
if ($stmt) {
	mysqli_stmt_bind_param($stmt, 'ssss', $getprofilename, $getprofilename, $getprofilename, $getprofilename);
	mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
	mysqli_stmt_bind_result($stmt, $artId, $artViews, $artBites);
	while (mysqli_stmt_fetch($stmt)) {
		$num_views += $artViews;
		$user_bites += $artBites;
		array_push($artIds, $artId);
	}
	mysqli_stmt_close($stmt);
}
$num_rows = sizeof($artIds);
if ($num_rows == 1) {
	$user_articles = 1;
	$text_articles = "article";
} else {
	$user_articles = $num_rows;
	$text_articles = "articles";
}
if ($num_views == 1) {
	$text_view = "view";
} else {
	$text_view = "views";
}
$num_rows = sizeof($bites);
if ($user_bites == 1) {
	$text_bite = "bite";
} else {
	$text_bite = "bites";
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
		<div class="profile_header">
			<div id="imagesProfile">
				<div id="covercontainer"><img title="Cover Picture" id="coverPic" src="imgs/users/<?php echo $pr_cover_pic; ?>.jpg"></div>
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
					<span><img id="backStats" src="imgs/stats_icons/views_icon.png"><span id="userStts"><?php echo $num_views; ?><strong id="stats"> <?php echo $text_view; ?></strong></span></span>
					<span><img id="backStats" src="imgs/stats_icons/bites_icon.png"><span id="userStts"><?php echo $user_bites ?><strong id="stats"> <?php echo $text_bite; ?></strong></span></span>
					<span><img id="backStats" src="imgs/stats_icons/friends_icon.png"><span id="userStts"><?php echo $user_friends; ?><strong id="stats"> <?php echo $text_friends; ?></strong></span></span>
					<span><img id="backStats" src="imgs/stats_icons/achievements_icon.png"><span id="userStts"><?php echo $user_achievements; ?><strong id="stats"> <?php echo $text_achievements; ?></strong></span></span>
					<span><img id="backStats" src="imgs/stats_icons/articles_icon.png"><span id="userStts"><?php echo $user_articles; ?><strong id="stats"> <?php echo $text_articles; ?></strong></span></span>
					<!--<span><img id="backStats" src="imgs/stats_icons/clan_icon.png"><span id="userClanText"><?php //echo $user_clan; ?></span> -->
				</div>
				<br>
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
				<?php
				if ($browserUSER === $getprofilename) {
					?>
					<br>
					<form name="userStatus" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="statusFrame">
						<input type="text" name="status" placeholder="What are you playing?" id="statusInput">
						<br>
						<div style="margin-left:78%">
							<span id="charCount">250</span><button type="button" id="submitStatus" name="submitStatus">Submit</button>
						</div>
					</form>
					<br>
					<hr>
					<?php
				}
				?>
				<div id="news" class="feed">

				</div>
			</div>

			<div id="Stats" class="tabcontent">
				<br>
				<table id="tab_stats">
					<tr>
						<td class="key">My articles bites:</td>
						<td class="value"><?php echo $user_bites; ?></td>
					</tr>
					<tr>
						<td class="key">Bites made:</td>
						<td class="value"><?php echo sizeof($bites); ?></td>
					</tr>
					<tr>
						<td class="key">My articles views:</td>
						<td class="value"><?php echo $num_views; ?></td>
					</tr>
					<tr>
						<td class="key">Articles read:</td>
						<td class="value"><?php echo sizeof($views); ?></td>
					</tr>
					<tr>
						<td class="key">Badges earned:</td>
						<td class="value"><?php echo $user_achievements . " " . $text_achievements; ?></td>
					</tr>
					<tr>
						<td class="key">Articles written:</td>
						<td class="value"><?php echo " " . $user_articles;?></td>
					</tr>
					<tr>
						<td class="key">Member of:</td>
						<td class="value"><?php echo " " . $user_clan;?></td>
					</tr>
					<tr id="stts_border">
					</tr>
					<tr>
						<td class="key">Member of:</td>
						<td class="value"><?php echo " " . $user_clan;?></td>
					</tr>
				</table>
			</div>

			<div id="Articles" class="tabcontent">
				<?php
				if(!empty($artIds)) {
					?>
					<div class="filters_tab">
						<?php
						include "filters.php";
						?>
					</div>
					<div class="articlesThumbnail" id="article_box">

					</div>
					<?php
				} else {
					echo "<br><p class='profile_alert'>This user has written no articles</p>";
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
					<p class="profile_alert">This user cannot be contacted.</p>
					<?php
				}
				?>
			</div>

		</div>
	</div>
	<?php include "footer.html"; ?>
	<script>
	// Global variables
	var timeout = 60000; // 1 minute time out to refresh the newsfeed on the Activity tab.
	var num_pages = Math.ceil(<?php echo $user_articles; ?> / 9); // Amount of 3x3 grids.
	var currentPage = 1; // Initial page to show.
	var totalArts = 0;
	var url = "profile_articles.php";
	var type = "createdate";
	var order = "DESC";
	var artPages = document.getElementById("articles_pages"); // Span tag that displays the current grid page and the totoal amount of grids.
	// Start up functions.
	$(document).ready(function() {
		/* Manage the tabs */
		$('ul.tabs li').click(function() {
			var tab_id = $(this).attr('data-tab');
			$('ul.tabs li').removeClass('active');
			$('.tabcontent').removeClass('active');
			$(this).addClass('active');
			$("#" + tab_id).addClass('active');
		});
		/* Gets the information for the activity tab as soon as the page is loaded */
		$.ajax({
			type: "POST",
			url: "profile_activity.php?profilename=<?php echo $getprofilename; ?>&picture=<?php echo $pr_picture; ?>",
			success: function (data) {
				$("#news").html(data);
			}
		});
		// Gets the information for the articles tab. All types of articles.
		var art_url = "profile_articles.php?profilename=<?php echo $getprofilename; ?>&offset=0&type=createdate&order=DESC";
		$.ajax({
			url: art_url,
			type: "GET",
			async: false,
			success: function(data) {
				// Appends the data gotten from the profile_articles.php page and saves the value of invis_value into the totalArts variable.
				totalArts = $(".articlesThumbnail").html(data).find("#invis_value").text(); // Total amount of articles written by the user.
				artGrid();
			}
		});
	});
	/* Refresh the activity tab every minute */
	setInterval(function () {
		$.ajax({
    type: "POST",
    url: "profile_activity.php?profilename=<?php echo $getprofilename; ?>&picture=<?php echo $pr_picture; ?>",
		success: function (data) {
			$("#news").html(data);
    }
    });
	}, timeout);
	/* Add as a friend */
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
	/* Acepts the friend request */
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
	/* Checks that the status is no longer than 250 characters */
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
	/* Submit the status */
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
	// Manage the next and prev arrows on load.
	function artGrid () {
		document.getElementById("articles_prev").setAttribute("style", "cursor: default; color: #fad1d1;"); // Changes the color of the arrow and the cursor so it looks deactivated.
		document.getElementById("articles_prev").onclick = false; // Deactivates the onclick function for the prev arrow.
		if (totalArts <= 9) { // Check if the user has written 9 articles or less to disabled the next arrow as well.
			document.getElementById("articles_next").setAttribute("style", "cursor: default; color: #fad1d1;"); // Changes the color of the arrow and the cursor so it looks deactivated.
			document.getElementById("articles_next").onclick = false; // Deactivates the onclick function for the next arrow.
		}
	}
	// Shows the next 3x3 grid
	function nextGrid () {
		currentPage += 1;
		var offset = (currentPage * 9) - 9; // Increases the offset by 9.
		var url_art = url + "?profilename=<?php echo $getprofilename; ?>&offset=" + offset + "&type=" + type + "&order=" + order;
		// Ajax to refresh the articles grid
		$.ajax({
			url : url_art,
			type : "GET",
			async : false,
			success : function(data) {
				$(".articlesThumbnail").html(data);
			}
		});
		// Disables the next arrow when the user has reached the last page available
		if (currentPage == num_pages) {
			document.getElementById("articles_next").setAttribute("style", "cursor: default; color: #fad1d1;");
			document.getElementById("articles_next").onclick = false;
		}
	}
	// Shows the prev 3x3 grid
	function prevGrid () {
		currentPage -= 1;
		var offset = (currentPage * 9) - 9; // Decreases the offset by 9.
		var url_art = url + "?profilename=<?php echo $getprofilename; ?>&offset=" + offset + "&type=" + type + "&order=" + order;
		// Ajax to refresh the articles grid
		$.ajax({
			url : url_art,
			type : "GET",
			async : false,
			success : function(data) {
				$(".articlesThumbnail").html(data);
			}
		});
		// Disables the prev arrow when the user has reached the first page available
		if (currentPage == 1) {
			document.getElementById("articles_prev").setAttribute("style", "cursor: default; color: #fad1d1;");
			document.getElementById("articles_prev").onclick = false;
		}
	}
	// Filters by type
	$("#filters_form select").change(function () {
		var art_type = $("#article_type").val();
		order = $("#orderby_drop").val();
		type = $("#type_drop").val();
		if (art_type == "reviews") {
			setInterval(getReviews(order, type), 0);
			url = "profile_reviews.php";
		} else if (art_type == "opinions") {
			setInterval(getOpinions(order, type), 0);
			url = "profile_opinions.php";
		} else if (art_type == "news") {
			setInterval(getNews(order, type), 0);
			url = "profile_news.php";
		} else if (art_type == "guides") {
			setInterval(getGuides(order, type), 0);
			url = "profile_guides.php";
		} else {
			setInterval(getArticles(order, type), 0);
			url = "profile_articles.php";
		}
	});
	// Retrieve the reviews written by the user
	function getReviews (order, type) {
		var art_url = "profile_reviews.php?profilename=<?php echo $getprofilename; ?>&offset=0&type=" + type + "&order=" + order;
		$.ajax({
			url: art_url,
			type: "GET",
			async: false,
			success: function(data) {
				// Appends the data gotten from the profile_articles.php page and saves the value of invis_value into the totalArts variable.
				totalArts = $(".articlesThumbnail").html(data).find("#invis_value").text(); // Total amount of articles written by the user.
				setInterval(artGrid(), 0);
			}
		});
	}
	// Retrieve the opinions written by the user
	function getOpinions (order, type) {
		var art_url = "profile_opinions.php?profilename=<?php echo $getprofilename; ?>&offset=0&type=" + type + "&order=" + order;
		$.ajax({
			url: art_url,
			type: "GET",
			async: false,
			success: function(data) {
				// Appends the data gotten from the profile_articles.php page and saves the value of invis_value into the totalArts variable.
				totalArts = $(".articlesThumbnail").html(data).find("#invis_value").text(); // Total amount of articles written by the user.
				setInterval(artGrid(), 0);
			}
		});
	}
	// Retrieve the news written by the user
	function getNews (order, type) {
		var art_url = "profile_news.php?profilename=<?php echo $getprofilename; ?>&offset=0&type=" + type + "&order=" + order;
		$.ajax({
			url: art_url,
			type: "GET",
			async: false,
			success: function(data) {
				// Appends the data gotten from the profile_articles.php page and saves the value of invis_value into the totalArts variable.
				totalArts = $(".articlesThumbnail").html(data).find("#invis_value").text(); // Total amount of articles written by the user.
				setInterval(artGrid(), 0);
			}
		});
	}
	// Retrieve the guides written by the user
	function getGuides (order, type) {
		var art_url = "profile_guides.php?profilename=<?php echo $getprofilename; ?>&offset=0&type=" + type + "&order=" + order;
		$.ajax({
			url: art_url,
			type: "GET",
			async: false,
			success: function(data) {
				// Appends the data gotten from the profile_articles.php page and saves the value of invis_value into the totalArts variable.
				totalArts = $(".articlesThumbnail").html(data).find("#invis_value").text(); // Total amount of articles written by the user.
				artGrid();
			}
		});
	}
	// Retrieve the articles written by the user
	function getArticles (order, type) {
		var art_url = "profile_articles.php?profilename=<?php echo $getprofilename; ?>&offset=0&type=" + type + "&order=" + order;
		$.ajax({
			url: art_url,
			type: "GET",
			async: false,
			success: function(data) {
				// Appends the data gotten from the profile_articles.php page and saves the value of invis_value into the totalArts variable.
				totalArts = $(".articlesThumbnail").html(data).find("#invis_value").text(); // Total amount of articles written by the user.
				setInterval(artGrid(), 0);
			}
		});
	}
	</script>
</body>
</html>
