<?php

	include 'mysql_con.php';

	$types = array("Review", "Opinion", "Guide");
	$articleid = $_POST['articleid'];
	$articletype = $_POST['articletype'];
	$viewer_ip = $_SERVER['REMOTE_ADDR'];
	$stat_month = date('M');
	$stat_year = date('Y');
	$stat_timestamp = date("Y-m-d H:i:s");
	$stat_countrycode = geo(null, "countryCode");
	$stat_countryname = geo(null, "countryName");
	$stat_latitude = geo(null, "latitude");
	$stat_longitude = geo(null, "longitude");
	$stat_city = geo(null, "city");
	$stat_region = geo(null, "region");
	
	if(in_array($articletype, $types)){
	
	$vQUERY = mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE article_id = '$articleid' AND type = 'view' AND ip = '$viewer_ip' AND article_type = '$articletype'");
	if(mysqli_num_rows($vQUERY)<1000){ 
	$viewSQL = "INSERT INTO tbl_article_stats (article_id, article_type, type, ip, month, year, timestamp, countrycode, countryname, latitude, longitude, city, region)
	VALUES ($articleid, '$articletype', 'view', '$viewer_ip', '$stat_month', '$stat_year', '$stat_timestamp', '$stat_countrycode', '$stat_countryname', '$stat_latitude', '$stat_longitude', '$stat_city' , '$stat_region')";

	if (!mysqli_query($con, $viewSQL)) {
    echo "Error: " . $viewSQL . "<br>" . mysqli_error($con);
	}
	}
	
	$articleviews = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE article_id = '$articleid' AND type = 'view' AND article_type = '$articletype'"));
	
	if($articleviews==1){$articleviewtext="view";}
	else{$articleviewtext = "views";}
	
	switch ($articletype) {
    case "Review":
        $updateviewSQL = "UPDATE tbl_review SET views=$articleviews WHERE id=$articleid";
        break;
    case "Opinion":
       $updateviewSQL = "UPDATE tbl_opinion SET views=$articleviews WHERE id=$articleid";
        break;
    case "News":
       $updateviewSQL = "UPDATE tbl_news SET views=$articleviews WHERE id=$articleid";
        break;
    case "Guide":
       $updateviewSQL = "UPDATE tbl_guide SET views=$articleviews WHERE id=$articleid";
}
	

	if (!mysqli_query($con, $updateviewSQL)) {
    echo "Error: " . $updateviewSQL . "<br>" . mysqli_error($con);
	}
	
	echo $articleviews." ".$articleviewtext;
	
	}
	
	
?>