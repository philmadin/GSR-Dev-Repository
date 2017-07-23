<?php

header('Content-Type: application/json');
include 'mysql_con.php';
set_time_limit(0);

function channelVideos(){
    global $con;
	$baseUrl = 'https://www.googleapis.com/youtube/v3/';
	$apiKey = 'AIzaSyDx5v2Wl6vpDwysvaafFaPsK4WaXR_mV6Q';
	$channelId = 'UCOP7Xx-EBE6vaV_ThC-h3cw';
	$videos = array();
	$url = $baseUrl .'channels?' .
    'id=' . $channelId .
    '&part=contentDetails,statistics' .
    '&key=' . $apiKey;
	$json = json_decode(file_get_contents($url), true);
	$locals['channel'] = $json['items'][0];
	$playlist = $json['items'][0]['contentDetails']['relatedPlaylists']['uploads'];
 
	$url = $baseUrl .'playlistItems?' .
 	'part=snippet,contentDetails' .
 	'&maxResults=5' .
 	'&playlistId=' . $playlist .
 	'&key=' . $apiKey;
	$json = json_decode(file_get_contents($url), true);
	$z=0;
	foreach($json['items'] as $video){
		array_push($videos,$z);
		$videos[$z]=array();
		$videos[$z]['id']=$video['snippet']['resourceId']['videoId'];
    	$z++;
	}
	while(isset($json['nextPageToken'])){
		$nextUrl = $url . '&pageToken=' . $json['nextPageToken'];
		$json = json_decode(file_get_contents($nextUrl), true);
		foreach($json['items'] as $video){
			array_push($videos,$z);
			$videos[$z]=array();
			$videos[$z]["id"]=$video['snippet']['resourceId']['videoId'];
			$z++;
		}
	}


	for ($x = 0; $x < (count($videos)-1); $x++) {
		$url2 = $baseUrl .'videos?' .
		'id=' . $videos[$x]['id'] .
		'&part=snippet,contentDetails,statistics' . 
		'&key=' . $apiKey;
		$json2 = json_decode(file_get_contents($url2), true);
		$videos[$x]['itemDetails'] = $json2['items'][0];
	}

/*
	//echo '<pre>';
	//print_r($videos);
	//echo '</pre>';

	foreach($videos as $vID){
		print_r($vID);
		$videos[$vID['id']] = $vID;
		$textdesc = $vID['snippet']['description'];
		preg_match_all('/{(.*?)}/', $textdesc, $matches);
		$user_array = $matches[1];
		$user_ar = explode(",",$user_array[0]);
		foreach($user_ar as $user){
			$query = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username='$user'");
			while($row = mysqli_fetch_assoc($query)) {
				if ($row['videos']!="") {
					$vidlist = explode(",", $row['videos']);
					if(!in_array($vID['id'], $vidlist)){
						array_push($vidlist,$vID['id']);
						$sql = "UPDATE tbl_accounts SET videos='".implode(",", $vidlist)."' WHERE username='$user'";
						if (mysqli_query($con, $sql)) {}
					}
				}
				else{
					$sql = "UPDATE tbl_accounts SET videos='".$vID['id']."' WHERE username='$user'";

					if (mysqli_query($con, $sql)) {}
				}
			}
		}
	} */
	//echo '<pre>';
	//print_r($videos);
	//echo '</pre>';
	
	return json_encode(array($videos));
}

//$v = channelVideos();

/**
 * @param $num
 * @param $exclude
 * @return mixed
 */
function relatedVideos($num, $exclude){
    global $v;
    $videos = array();
    foreach ($v['i'] as $vid) {
        if($vid['id']!=$exclude){
            $videos[] = $vid;
        }
    }
    shuffle($videos);
    return array_slice($videos, 0, $num);
}

function totalViews()
{
    global $v;

    $count = 0;
    foreach ($v['i'] as $vid) {
        $count = $count + $vid['statistics']['viewCount'];
    }
    return $count;

}


echo channelVideos();
?>