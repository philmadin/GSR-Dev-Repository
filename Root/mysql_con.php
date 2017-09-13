<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

$con = mysqli_connect('127.0.0.1','root','root','gameshar_gsr',3306);

if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}

date_default_timezone_set('Australia/Brisbane');

include_once("geoplugin.php");
include_once("perms.php");
include_once("tokengen.php");

/* Prepared Statements */
$query_user_info = "SELECT * FROM tbl_accounts WHERE username = ?";
$query_user_exp = "SELECT * FROM tbl_xp_log WHERE username = ? AND action_type = ?";
$query_user_friend = "SELECT * FROM tbl_accounts WHERE id = ?";
$query_user_badges = "SELECT * FROM tbl_badges WHERE id = ?";
$query_user_articles = "SELECT id, article_type, title, author, createdate FROM tbl_guide WHERE authuser = ? UNION SELECT id, article_type, title, author, createdate FROM tbl_news WHERE authuser = ? UNION SELECT id, article_type, title, author, createdate FROM tbl_opinion WHERE authuser = ?;";
$query_user_review = "SELECT id, article_type, title, gamename, author, createdate FROM tbl_review WHERE authuser = ?";
$query_add_friend = "SELECT * FROM tbl_requests WHERE requestee = ? AND requester = ?";
$query_request_friend = "INSERT INTO tbl_requests (requester, requestee) VALUES (?, ?)";

?>
