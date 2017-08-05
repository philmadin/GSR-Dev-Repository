<?php
	include ("mysql_con.php");
  include ("timecal.php");
  include ("links.php");
  include ("header.php");

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

	if($pr_picture == NULL || $pr_picture == "" || empty($pr_picture)) {
		$pr_image = "default";
	} else {
		$pr_image = $pr_picture;
	}

	$browserUSER = $_SESSION['username'];

  /* Number of views */
  $statsUser = mysqli_query($con, "SELECT * FROM tbl_xp_log WHERE username = '$_SESSION['username']' AND action_type = 'view'");
  $num_rows = mysqli_num_rows($statsUser);
  if ($num_rows == 1) {
    $user_views = 1;
    $text_view = "view";
  } else {
    $user_views = $num_rows;
    $text_view = "views";
  }

  /* Number of bites */
  $statsUser = mysqli_query($con, "SELECT * FROM tbl_xp_log WHERE username = '$_SESSION['username']' AND action_type = 'bite'");
  $num_rows = mysqli_num_rows($statsUser);
  if ($num_rows == 1) {
    $user_bites = 1;
    $text_bite = "bite";
  } else {
    $user_bites = $num_rows;
    $text_bite = "bites";
  }

  /* Number of friends */
  if (!empty($pr_friends) || $pr_friends != NULL || $pr_friends != "") {
    $prFriendsQRY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE id IN ($pr_friends)");
    $num_rows = mysqli_num_rows($prFriendsQRY);
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
    $prBadgesQRY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE id IN ($pr_badges)");
    $num_rows = mysqli_num_rows($prBadgesQRY);
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
  $ugQRY = mysqli_query($con, "SELECT * FROM tbl_guide WHERE authuser = '$_SESSION['username']'"); // Guides
  $uqRows = mysqli_num_rows($ugQRY);
  $uoQRY = mysqli_query($con, "SELECT * FROM tbl_opinion WHERE authuser = '$_SESSION['username']'"); // Opinion
  $uoRows = mysqli_num_rows($uoQRY);
  $urQRY = mysqli_query($con, "SELECT * FROM tbl_review WHERE authuser = '$_SESSION['username']'"); // Review
  $urRows = mysqli_num_rows($urQRY);
  $unQRY = mysqli_query($con, "SELECT * FROM tbl_news WHERE authuser = '$_SESSION['username']'"); // News
  $unRows = mysqli_num_rows($unQRY);
  $num_rows = $uqRows + $uoRows + $urRows + $unRows;
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
    <button class="FriendAdd" name="FriendAdd" type="button"><i class="fa fa-user-plus"></i>  Add friend</button>
    <div id="userInfo">
      <span id="NameUser"><?php echo $pr_username; ?></span><span id="levelUser">lvl <?php echo $pr_level; ?></span>
    </div>
    <div id="userStats">
      <div style="padding-top:15px;padding-bottom:15px;">
        <span id="userViews"><i id="backStats"><i class="fa fa-eye" aria-hidden="true" id="iconStats"></i></i> <span id="userStts"><?php echo $user_views; ?><strong id="stats"> <?php echo $text_view; ?></strong></span></span>
        <br>
        <span id="userBites"><i id="backStats"><i class="fa fa-thumbs-up" aria-hidden="true" id="iconStats"></i></i> <span id="userStts"><?php echo $user_bites ?><strong id="stats"> <?php echo $text_bite; ?></strong></span></span>
        <br>
        <span id="userFriends"><i id="backStats"><i class="fa fa-users" aria-hidden="true" id="iconStats"></i></i> <span id="userStts"><?php echo $user_friends; ?><strong id="stats"> <?php echo $text_friends; ?></strong></span></span>
        <br>
        <span id="userAchievements"><i id="backStats"><i class="fa fa-trophy" aria-hidden="true" id="iconStats"></i></i> <span id="userStts"><?php echo $user_achievements; ?><strong id="stats"> <?php echo $text_achievements; ?></strong></span></span>
        <br>
        <span id="userArticles"><i id="backStats"><i class="fa fa-pencil" aria-hidden="true" id="iconStats"></i></i> <span id="userStts"><?php echo $user_articles; ?><strong id="stats"> <?php echo $text_articles; ?></strong></span></span>
        <br>
        <span><i id="backStats"><i class="fa fa-gamepad" aria-hidden="true" id="iconStats"></i></i> <span id="userClan"><?php echo $user_clan; ?></span>
        <br>
      </div>
      <br>
    </div>
    <br>
    <div id="userPhotos">
      <span id="photosTag"><i id="backPhotos"><i class="fa fa-camera" aria-hidden="true" id="iconStats"></i></i><span id="textPhotos">photos</span></span>
    </div>
    <br>
  </div>
  <?php include "footer.html"; ?>
</body>
</html>
