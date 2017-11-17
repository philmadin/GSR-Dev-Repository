<?php
include ("mysql_con.php");
include ("timecal.php");

$pr_username = $_GET["profilename"];
$getprofilename = $pr_username;
$pr_picture = $_GET["picture"];
$newsFeed = array(); // Array for the newsfeedtab

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

/* Organize the NewsFeed array by date */
function cmp($a, $b){
  $ad = strtotime($a[2]);
  $bd = strtotime($b[2]);
  return ($ad - $bd);
}

usort($newsFeed, 'cmp');

$feed = array_slice(array_reverse($newsFeed), 0, 10);
for ($i = 0; $i <= sizeof($feed) - 1; $i++){
  if ($feed[$i][4]) {
    $ttl = preg_split("/(\?t=|\&g=)/", $feed[$i][3]);
    $title = urldecode(str_replace("_", " ", $ttl[1]));
    ?>
    <div id="savedAction">
      <img src="imgs/users/<?php echo $pr_picture; ?>-232x270.jpg" alt="<?php echo $getprofilename; ?>">
      <p id="name_action"><?php echo "<b>" . $pr_username . "</b> " . $feed[$i][1] . " <a href='".$feed[$i][3]."'>".$title . "</a>"." <i>".humanTiming(strtotime($feed[$i][2]))." ago</i>"; ?></p>
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
