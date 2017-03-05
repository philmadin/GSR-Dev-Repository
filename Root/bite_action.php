<?php
include "mysql_con.php";

$action = $_GET['action'];

$articletype= $_GET['articletype'];
$article_id = $_GET['articleid'];
$video_id = $_GET['videoid'];
$viewer_ip = $_SERVER['REMOTE_ADDR'];
$tbl = strtolower($articletype);
	$stat_month = date('M');
	$stat_year = date('Y');
	$stat_timestamp = date("Y-m-d H:i:s");
	$stat_countrycode = geo(null, "countryCode");
	$stat_countryname = geo(null, "countryName");
	$stat_latitude = geo(null, "latitude");
	$stat_longitude = geo(null, "longitude");
	$stat_city = geo(null, "city");
	$stat_region = geo(null, "region");	

if($articletype=="Video"){
	if($action=="bite"){
		$prebitecount = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE video_id = '$video_id' AND type = 'bite' AND article_type = '$articletype'"));
		$biteQUERY = mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE video_id = '$video_id' AND type = 'bite' AND ip = '$viewer_ip' AND article_type = '$articletype'");
		if(mysqli_num_rows($biteQUERY)>0){
			echo "unbite-".$prebitecount;
		}
		else{
			$vQUERY = mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE video_id = '$video_id' AND type = 'view' AND ip = '$viewer_ip' AND article_type = '$articletype'");
			$insertSQL = "INSERT INTO tbl_article_stats (video_id, article_type, type, ip, month, year, timestamp, countrycode, countryname, latitude, longitude, city, region)
		VALUES ('$video_id', '$articletype', 'bite', '$viewer_ip', '$stat_month', '$stat_year', '$stat_timestamp', '$stat_countrycode', '$stat_countryname', '$stat_latitude', '$stat_longitude', '$stat_city' , '$stat_region')";
			if (!mysqli_query($con, $insertSQL)) {
				$bitecount = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE video_id = '$video_id' AND type = 'bite' AND article_type = '$articletype'"));
				echo "unbite-".$bitecount;
			}
			else{
				$bitecount = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE video_id = '$video_id' AND type = 'bite' AND article_type = '$articletype'"));
				echo "bite-".$bitecount;
			}
		}
	}




	if($action=="unbite"){
		$prebitecount = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE video_id = '$video_id' AND type = 'bite' AND article_type = '$articletype'"));
		$biteQUERY = mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE video_id = '$video_id' AND type = 'bite' AND ip = '$viewer_ip' AND article_type = '$articletype'");
		if(mysqli_num_rows($biteQUERY)<1){
			echo "bite-".$prebitecount;
		}
		else{
			$vQUERY = mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE video_id = '$video_id' AND type = 'view' AND ip = '$viewer_ip' AND article_type = '$articletype'");
			$insertSQL = "DELETE FROM tbl_article_stats WHERE video_id='$video_id' AND ip = '$viewer_ip' AND article_type = '$articletype'";
			if (!mysqli_query($con, $insertSQL)) {
				$bitecount = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE video_id = '$video_id' AND type = 'bite' AND article_type = '$articletype'"));
				echo "bite-".$bitecount;
			}
			else{
				$bitecount = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE video_id = '$video_id' AND type = 'bite' AND article_type = '$articletype'"));
				echo "unbite-".$bitecount;
			}
		}

	}
}
else{
	if($action=="bite"){
		$prebitecount = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE article_id = '$article_id' AND type = 'bite' AND article_type = '$articletype'"));
		$biteQUERY = mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE article_id = '$article_id' AND type = 'bite' AND ip = '$viewer_ip' AND article_type = '$articletype'");
		if(mysqli_num_rows($biteQUERY)>0){
			echo "unbite-".$prebitecount;
		}
		else{
			$vQUERY = mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE article_id = '$article_id' AND type = 'view' AND ip = '$viewer_ip' AND article_type = '$articletype'");
			$insertSQL = "INSERT INTO tbl_article_stats (article_id, article_type, type, ip, month, year, timestamp, countrycode, countryname, latitude, longitude, city, region)
		VALUES ('$article_id', '$articletype', 'bite', '$viewer_ip', '$stat_month', '$stat_year', '$stat_timestamp', '$stat_countrycode', '$stat_countryname', '$stat_latitude', '$stat_longitude', '$stat_city' , '$stat_region')";
			if (!mysqli_query($con, $insertSQL)) {
				$bitecount = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE article_id = '$article_id' AND type = 'bite' AND article_type = '$articletype'"));
				echo "unbite-".$bitecount;
			}
			else{
				$bitecount = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE article_id = '$article_id' AND type = 'bite' AND article_type = '$articletype'"));
				echo "bite-".$bitecount;
			}
		}
	}




	if($action=="unbite"){
		$prebitecount = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE article_id = '$article_id' AND type = 'bite' AND article_type = '$articletype'"));
		$biteQUERY = mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE article_id = '$article_id' AND type = 'bite' AND ip = '$viewer_ip' AND article_type = '$articletype'");
		if(mysqli_num_rows($biteQUERY)<1){
			echo "bite-".$prebitecount;
		}
		else{
			$vQUERY = mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE article_id = '$article_id' AND type = 'view' AND ip = '$viewer_ip' AND article_type = '$articletype'");
			$insertSQL = "DELETE FROM tbl_article_stats WHERE article_id='$article_id' AND ip = '$viewer_ip' AND article_type = '$articletype'";
			if (!mysqli_query($con, $insertSQL)) {
				$bitecount = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE article_id = '$article_id' AND type = 'bite' AND article_type = '$articletype'"));
				echo "bite-".$bitecount;
			}
			else{
				$bitecount = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE article_id = '$article_id' AND type = 'bite' AND article_type = '$articletype'"));
				echo "unbite-".$bitecount;
			}
		}

	}


	$reviewbitecount = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE article_id = '$article_id' AND type = 'bite' AND article_type = '$articletype'"));
	$updatebitesSQL = "UPDATE tbl_".$tbl." SET bites=$reviewbitecount WHERE id=$article_id";

	if (!mysqli_query($con, $updatebitesSQL)) {
		echo "Error: " . $updatebitesSQL . "<br>" . mysqli_error($con);
	}
}

mysqli_close($con);
?>