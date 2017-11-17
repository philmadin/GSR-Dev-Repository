<?php
include ('mysql_con.php');

$query = mysqli_fetch_assoc(mysqli_query($con, "SELECT title, gamename FROM tbl_review WHERE id = '90'"));
$title = urlencode(str_replace(" ", "_", $query['title']));
$gamename = urlencode(str_replace(" ", "_", $query['gamename']));
$url = "review.php?t=" . $title . "&g=" . $gamename;
echo $url;
?>
