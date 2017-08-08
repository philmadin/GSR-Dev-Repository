<?php
	include "mysql_con.php";

	$getprofilename = mysqli_real_escape_string($con, $_GET['profilename']);

	$proQRYA = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$getprofilename'");
	$proQRYB = mysqli_query($con, "SELECT * FROM tbl_companies WHERE username = '$getprofilename'");

  if (mysqli_num_rows($proQRYA) < 1 && mysqli_num_rows($proQRYB) < 1) {
		header("Location: index.php");
	} else {
		if (mysqli_num_rows($proQRYA) < 1) {
			$profileQRY = $proQRYB;
		} else {
			$profileQRY = $proQRYA;
		}
	}
	while ($prof = mysqli_fetch_assoc($profileQRY)) {
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

	$bQUERY = mysqli_query($con, "SELECT * FROM tbl_ranks WHERE id = $pr_rank");
	while ($bROW = mysqli_fetch_assoc($bQUERY)) {
		$pr_position = $bROW['name'];
	}

	$profileGSQRY = mysqli_query($con, "SELECT * FROM tbl_users WHERE username = '$getprofilename'");

	while ($profGS = mysqli_fetch_assoc($profileGSQRY)) {
		$pr_online = $profGS['online'];
	}

	if($pr_picture == NULL || $pr_picture == "" || empty($pr_picture)) {
		$pr_image = "default";
	} else {
		$pr_image = $pr_picture;
	}

	include "timecal.php";

	if ($pr_since == strtotime("2014-01-01 00:00:00")) {
		$pr_date = "Co-founded";
	} else {
		$pr_date = humanTiming($pr_since) . " with";
	}

	if($pr_online != 'ONLINE') {
		$onlinestring = strtotime($pr_online);
		$statusOnline = "Last seen " . humanTiming($onlinestring) . " ago";
		$statusClass = "offline";
	} else {
		$statusOnline = $pr_online;
		$statusClass = "online";
	}

	$browserUSER = $_SESSION['username'];

	if(isset($browserUSER)) {
		$bwsrQRY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$browserUSER'");

		while($bwsrROW = mysqli_fetch_assoc($bwsrQRY)) {
			$bwsrID = $bwsrROW['id'];
			$bwsrFR = explode(',', $bwsrROW['friends']);
		}
	}
?>

<!doctype html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="index, follow, noarchive">

<title><?php echo $pr_username; ?>'s Profile Page | GSR</title>

<meta name="description" content="GSR - Welcome to <?php echo $pr_username; ?>'s profile page!">

<?php include "links.php"; ?>

</head>

<body>

	<?php include "header.php"; ?>

	<div id="page" class="container_24">

		<article class="blog grid_0_top">

			<section class="grid_18" id="blank_area"></section>

			<section class="grid_18" id="userprofile">

				<div class="grid_7 grid_0" id="profilepicture">
					<img src="imgs/users/<?php echo $pr_image; ?>-232x270.jpg" title="Profile picture of <?php echo $pr_username; ?>">
				</div>

				<div id="profiledetails" class="grid_6 grid_0">
					<p id='profilerealname'></p>
					<p id="profileusername"><?php if($showName == 1) { echo $pr_firstname . " " . $pr_lastname; } else { echo $pr_username; } ?></p>
					<p id="profileonline" class="<?php echo $statusClass; ?>"><?php echo $statusOnline; ?></p>
					<p id="profileposition"><?php echo $pr_position; ?></p>
					<p id="profiletime"><?php echo $pr_date; ?> <abbr title="Game Shark Reviews">GSR</abbr></p>
					<p id="profilelocation">
						<?php
							if($pr_town != "undefined" && $pr_country != "undefined") { echo $pr_town . ", " . $pr_country; }
							else if($pr_town != "undefined" && $pr_country == "undefined") { echo "Somewhere called " . $pr_town; }
							else if($pr_town == "undefined" && $pr_country != "undefined") { echo $pr_country; }
							else { echo "Lives Elsewhere..."; }
						?>
					</p>
					<p id="profilemedia">
						<?php
							if($pr_website != "undefined" || empty($pr_website)) { echo '<a href="' . $pr_website . '" class="profilemedia" id="website">&nbsp;</a>'; }
							if($pr_faceboook != "undefined" || empty($pr_faceboook)) { echo '<a href="' . $pr_faceboook . '" class="profilemedia" id="facebook">&nbsp;</a>'; }
							if($pr_twitter != "undefined" || empty($pr_twitter)) { echo '<a href="' . $pr_twitter . '" class="profilemedia" id="twitter">&nbsp;</a>'; }
							if($pr_googleplus != "undefined" || empty($pr_googleplus)) { echo '<a href="' . $pr_googleplus . '" class="profilemedia" id="googleplus">&nbsp;</a>'; }
						?>
					</p>
				</div>

				<div id="profilegaming" class="grid_4 grid_0">
					<p id="profileloves"><a id="lovesicon"></a></p>
					<p id="profileconsole">Loves <?php if($pr_console != "undefined") { echo $pr_console; } else { echo '<abbr title="Game Shark Reviews">GSR</abbr>'; } ?></p>
					<p id="profilealtuser"><?php if($showName == 1) { echo $pr_username; } else { echo "&nbsp;"; } ?></p>
					<p id="profilegame" title="<?php echo $pr_username . ' loves ' . $pr_game . ' on ' . $pr_console; ?>"><?php echo $pr_game; ?></p>
					<p id="profilexbox"><?php echo $pr_xbox; ?></p>
					<p id="profileplaystation"><?php echo $pr_playstation; ?></p>
					<p id="profilesteam"><?php echo $pr_steam; ?></p>
				</div>

				<div id="profilelevel" class="grid_12 grid_0">
					LEVEL <span><?php echo $pr_level; ?></span>

					<?php
						if($pr_username != $browserUSER && isset($browserUSER)) {

							$requesteeQRY = mysqli_query($con, "SELECT * FROM tbl_requests WHERE requestee = '$pr_id' AND requester = '$bwsrID'");
							$requesterQRY = mysqli_query($con, "SELECT * FROM tbl_requests WHERE requester = '$pr_id' AND requestee = '$bwsrID'");

							if(mysqli_num_rows($requesteeQRY) > 0) {
								echo "<a id='requestfriend'>REQUEST SENT</a>";
							} else if(mysqli_num_rows($requesterQRY) > 0) {
								echo "<a id='acceptfriend' data-send-user='" . $browserUSER . "' data-send-prof='" . $pr_username . "'>ACCEPT REQUEST</a>";
							} else if(in_array($pr_id, $bwsrFR)) {
								echo "<a id='friend'>FRIEND</a>";
							} else if(!in_array($pr_id, $bwsrFR) && mysqli_num_rows($requesterQRY) < 1 && mysqli_num_rows($requesteeQRY) < 1) {
								echo "<a id='addfriend' data-send-user='" . $browserUSER . "' data-send-prof='" . $pr_username . "'>ADD FRIEND</a>";
							}
						}
					?>
				</div>

	  			<div id="profilebadges" class="grid_4 grid_0">
	  				<div id="badgeswrapper">
	  					<div id="darkside"></div>
	  					<div id="liteside"></div>
	  					<p id="updown"><a>BADGES</a></p>
	  					<div id="badgelist">
	  				<?php
	  					if(!empty($pr_badges) || $pr_badges != NULL || $pr_badges != "") {

							$profileBadgesQRY = mysqli_query($con, "SELECT * FROM tbl_badges WHERE id IN ($pr_badges)");

							while ($proBadge = mysqli_fetch_assoc($profileBadgesQRY)) {
								$badge_id = $proBadge['id'];
								$badge_name = $proBadge['name'];
								$badge_desc = $proBadge['description'];
								$badge_file = $proBadge['file'];

								echo "<div class='badge'><img src='" . $badge_file . "'><span class='badgeText'><b>" . $badge_name . "</b><br>" . $badge_desc . "</span></div>";
							}

	  					} else {
	  						echo "This user has no badges... Yet...";
	  					}
	  				?>
	  					</div>
	  				</div>
	  			</div>

		  		<div id="profileinfo" class="grid_17 grid_0">
		  			<h4>FAVOURITE QUOTE</h4>
		  			<p id="quote">&ldquo; <?php echo $pr_quote; ?> &rdquo;</p>
		  			<h4>BIO</h4>
		  			<p><?php echo $pr_bio; ?></p>
		  		</div>

		  		<div id="profilefavourites" class="grid_17 grid_0">
		  			<h4>FAVOURITE REVIEWS</h4>
		  			<p>
		  				<?php
		  					if(!empty($pr_favs) || $pr_favs != NULL || $pr_favs != "") {

								$prFavsQRY = mysqli_query($con, "SELECT * FROM tbl_review WHERE id IN ($pr_favs)");

								while ($proFavs = mysqli_fetch_assoc($prFavsQRY)) {
									$fav_name = $proFavs['title'];
									$fav_auth = $proFavs['author'];
									$fav_stam = strtotime($proFavs['date']);
									$fav_date = new DateTime("@$fav_stam");
									$fav_id = $proFavs['id'];

									echo "<a href='review.php?review=" . $fav_id . "'><b>" . $fav_name . " </b>" . $fav_auth . "<i> - " . $fav_date->format('jS M Y') . "</i></a>";

								}

		  					} else {
		  						echo "<i>$pr_username has no favourite reviews.</i>";
		  					}
		  				?>
		  			</p>
		  		</div>

		  		<div id="profilefriends" class="grid_17 grid_0">
		  			<h4>FRIENDS</h4>
		  			<p>
		  				<?php
		  					if(!empty($pr_friends) || $pr_friends != NULL || $pr_friends != "") {

								$prFriendsQRY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE id IN ($pr_friends)");

								while ($pFriend = mysqli_fetch_assoc($prFriendsQRY)) {
									$fri_name = $pFriend['firstname'] . " " . $pFriend['lastname'];
									$fri_show = $pFriend['showname'];
									$fri_user = $pFriend['username'];

									if($fri_show == "true") {
										$displayname = $fri_name;
									} else {
										$displayname = $fri_user;
									}

									echo "<a class='grid_3 grid_0' href='profile.php?profilename=" . $fri_user . "'><b>" . $displayname . " </b></a>";

								}

		  					} else {
		  						echo "<i>$pr_username has no friends.</i> T_T";
		  					}
		  				?>
		  			</p>
		  		</div>

	  		</section>

			<aside class="grid_6 grid_0" id="useractivity">
				<h2>COMING SOON -- MORE ON PAGE</h2>

		  		<ul>
		  			<!--<li>
		  				<a>
		  					<b>Destiny</b>
		  					That&rsquo;s exactly what I thought but I never believed it to be true because it was so unrealistic in mos...
		  					<span>10 days ago</span>
		  				</a>
		  			</li>-->
		  		</ul>

		  		<?php
					$crunchCountQRY = mysqli_query($con, "SELECT id FROM tbl_crunchbox WHERE receiver = '$pr_username'");
					$crunchCount = mysqli_num_rows($crunchCountQRY);

					$crunchAmountQRY = mysqli_query($con, "SELECT id FROM tbl_crunchbox WHERE receiver = '$pr_username' AND id %5 = 1");
					$crunchAmount = mysqli_num_rows($crunchAmountQRY);
				?>

				<div id="activityPagination" data-max-offset="<?php echo $activityCount; ?>" data-offset-amount="<?php echo $activityAmount * 5 - 5; ?>">
					<p>
		  				<a id="prev_pag" class="pag" data-button-name="prev">PREV</a>
		  				<a id="next_pag" class="pag" data-button-name="next">NEXT</a>
		  			</p>
		  		</div>
			</aside>
		</article>

	</div>

	<?php include "footer.html"; ?>

	<script type="text/javascript">
		$(function() {

			$("#updown").hover(function() {
				$("#badgeswrapper").toggleClass('active');
			});

			$("#updown").click(function() {
				$("#badgeswrapper").toggleClass('showall');
			});

		    /*var startup_url = "recent_activity.php?user=<?php echo $pr_username; ?>&offset=0";
			$.ajax({
				url : startup_url,
				type : "GET",
				async : false,
				success: function(startup_data) {
					$("#useractivity ul").html(startup_data);
					setInterval(relinkImages(),0);
				}
			});*/

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

			$("#next_pag").click(function() {
				setInterval(nextCrunchyResults(),0);
			});

			$("#prev_pag").click(function() {
				setInterval(prevCrunchyResults(),0);
			});
		});

		function nextCrunchyResults() {

			var nxtVAL = parseInt($("#crunchOFFSET").text());
			var nxtMAX = parseInt($("#crunchy_pagination").attr("data-max-offset"));
			var nxtAMU = parseInt($("#crunchy_pagination").attr("data-offset-amount"));

			if(nxtAMU < 0 || nxtAMU == 0) {
				var nxtAMO = 0;
			} else {
				var nxtAMO = nxtAMU;
			}

		    if(nxtVAL == nxtAMU || nxtMAX < 5) {
		        var nxtOFF = nxtAMO;
		    } else {
		    	var nxtOFF = Math.round(parseInt(nxtVAL) + 5);
		    }

			var crunchURL = "profile_crunches.php?offset=" + nxtOFF + "&user=<?php echo $pr_username; ?>";

			$.ajax({
				url : crunchURL,
				type : "GET",
				async : false,
				success: function(crunch_data) {
					$("#crunchbox ul").html(crunch_data);
					setInterval(relinkImages(),0);
				}
			});
		}

		function prevCrunchyResults() {

			var cruVAL = parseInt($("#crunchOFFSET").text());
			var cruMAX = $("#crunchy_pagination").attr("data-max-offset");
			if(cruVAL > 0) {
				var cruOFF = Math.round(parseInt(cruVAL) - 5);
			} else if(cruVAL == 0) {
				var cruOFF = 0;
			}

			var crunchURL = "profile_crunches.php?offset=" + cruOFF + "&user=<?php echo $pr_username; ?>";

			$.ajax({
				url : crunchURL,
				type : "GET",
				async : false,
				success: function(crunch_data) {
					$("#crunchbox ul").html(crunch_data);
					setInterval(relinkImages(),0);
				}
			});
		}

		function relinkImages() {
			$(".shark_pic").each(function() {
		        if($(this).attr('data-shark-picture') == "default") {
		            $(this).css("background-image", "url(imgs/users/default-116x135.jpg)");
		        } else {
		            $(this).css("background-image", "url(imgs/users/" + $(this).attr('data-shark-picture') + "-116x135.jpg)");
		        }
		    });

		    var crofset = parseInt($("#crunchOFFSET").text());
			var cruofsm = parseInt($("#crunchy_pagination").attr("data-offset-amount"));
			var crumaxo = parseInt($("#crunchy_pagination").attr("data-max-offset"));

		    if(crofset == 0) {
		        $("#prev_pag").addClass('null');
		    } else {
		    	$("#prev_pag").removeClass('null');
		    }

		    if(crofset == cruofsm || crumaxo < 5) {
		        $("#next_pag").addClass('null');
		    } else {
		    	$("#next_pag").removeClass('null');
		    }
		}
	</script>

</body>
</html>
