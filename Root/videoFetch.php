<?php
	include "mysql_con.php";
   	include_once("videos-get.php");
    	$temp = channelVideos();
    	$v['i'] = array_slice($temp['i'],0,3);
    	for ($x = 0; $x < 3; $x++) {
		echo '<li><a data-id="' . $v['i'][$x]['id'] . '" class="video-contain" href="video.php?id=' . $v['i'][$x]['id'] . '">';
                echo '<span style="background-image:url(https://i.ytimg.com/vi/' . $v['i'][$x]['id'] . '/mqdefault.jpg);" class="video">';
                echo '<span class="duration">' . str_replace("S","",str_replace("M",":",str_replace("H",":",str_replace("PT","",$v['i'][$x]['contentDetails']['duration'])))) . '</span>';
                echo '<span class="views">' . $v['i'][$x]['statistics']['viewCount'] . ' views</span>';
                echo '</span>';                
                echo '<span class="video-title">' . $v['i'][$x]['snippet']['title'] . '</span>';
		echo '</a></li>';
        }
?>
	<li class="video_link"><a href="videos.php" class="full grid_4">SEE MORE</a></li>