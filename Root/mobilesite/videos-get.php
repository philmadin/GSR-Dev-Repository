<?php

include 'mysql_con.php';


function channelVideos(){
    global $con;
$baseUrl = 'https://www.googleapis.com/youtube/v3/';
$apiKey = 'AIzaSyDx5v2Wl6vpDwysvaafFaPsK4WaXR_mV6Q';
$channelId = 'UCTfKW979nHGW5KW0WtV9Nbw';
$videos = array();
$url = $baseUrl .'channels?' .
    'id=' . $channelId .
    '&part=contentDetails,statistics' .
    '&key=' . $apiKey;
$json = json_decode(file_get_contents($url), true);
$videos['channel'] = $json['items'][0];
$playlist = $json['items'][0]['contentDetails']['relatedPlaylists']['uploads'];
 
$url = $baseUrl .'playlistItems?' .
 'part=snippet' .
 '&maxResults=50' .
 '&playlistId=' . $playlist .
 '&key=' . $apiKey;
$json = json_decode(file_get_contents($url), true);
 
foreach($json['items'] as $video)
    $videos['i'][] = $video['snippet']['resourceId']['videoId'];
 
while(isset($json['nextPageToken'])){
    $nextUrl = $url . '&pageToken=' . $json['nextPageToken'];
    $json = json_decode(file_get_contents($nextUrl), true);
    foreach($json['items'] as $video)
        $videos['i'][] = $video['snippet']['resourceId']['videoId'];
}

for ($x = 0; $x <= (count($videos['i'])-1); $x++) {
$url2 = $baseUrl .'videos?' .
	'id=' . $videos['i'][$x] .
	'&part=contentDetails,snippet,statistics' . 
	'&key=' . $apiKey;
	$json2 = json_decode(file_get_contents($url2), true);
    $videos['i'][$x] = $json2['items'][0];
}

foreach($videos['i'] as $vID){
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
} 

return $videos;
}

$v = channelVideos();

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

if(isset($_GET['video-list'])){
echo json_encode(channelVideos());
}

if(isset($_GET['suggested-videos'])){
echo json_encode(relatedVideos(intval($_GET['num']), $_GET['exclude']));
}
?>