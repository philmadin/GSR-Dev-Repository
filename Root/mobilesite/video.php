<?php
	include "mysql_con.php";
	//include 'videos-get.php';
	//$v = channelVideos();
	//if(!isset($_GET['id']) || !array_key_exists($_GET['id'], $v)){die("Video not found.");}
	$id = $_GET['id'];
	$articletype = "Video";

function makeLinks($str, $target='_blank')
{
	if ($target)
	{
		$target = ' target="'.$target.'"';
	}
	else
	{
		$target = '';
	}
	// find and replace link
	$str = preg_replace('@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)*)@', '<a href="$1" '.$target.'>$1</a>', $str);
	// add "http://" if not set
	$str = preg_replace('/<a\s[^>]*href\s*=\s*"((?!https?:\/\/)[^"]*)"[^>]*>/i', '<a href="http://$1" '.$target.'>', $str);
	return $str;
}

$viewer_ip = $_SERVER['REMOTE_ADDR'];

$biteQUERY = mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE video_id = '$id' AND type = 'bite' AND ip = '$viewer_ip' AND article_type = '$articletype'");
if(mysqli_num_rows($biteQUERY)>0){
	$hasbit=true;
}else{$hasbit=false;}

$bitecount = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE video_id = '$id' AND type = 'bite' AND article_type = '$articletype'"));
if($bitecount==1){$bitecounttext="bite";}
else{$bitecounttext = "bites";}


?>
<!doctype html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<meta name="robots" content="index, follow, noarchive">

<title><?php echo $v[$id]['snippet']['title'];?> | Video | GSR</title>

<meta name="description" content="<?php echo $v[$id]['snippet']['description'];?>">
<script data-cfasync="false">
  (function(r,e,E,m,b){E[r]=E[r]||{};E[r][b]=E[r][b]||function(){
  (E[r].q=E[r].q||[]).push(arguments)};b=m.getElementsByTagName(e)[0];m=m.createElement(e);
  m.async=1;m.src=("file:"==location.protocol?"https:":"")+"//s.reembed.com/G-nOLay1.js";
  b.parentNode.insertBefore(m,b)})("reEmbed","script",window,document,"api");
</script>
<?php include "externals.php"; ?>

</head>

<body>

	<?php include "header.php"; ?>

	<div id="video-page" class="container_24">

		<article>
		
			<section class="grid_24">
				<div id="video-display">
<iframe width="100%" height="376" src="https://www.youtube.com/embed/<?php echo $id;?>?rel=0&amp;showinfo=0&theme=light" frameborder="0" allowfullscreen></iframe>
				
				</div>
			</section>
			
			<section id="video-info" class="grid_16">
				<h3><?php echo $v[$id]['snippet']['title'];?></h3>
				<hr />
				<div id="views"><?php echo $v[$id]['statistics']['viewCount'];?> views</div>
				<p id="bite_area">
					<?php
					if($hasbit==true){
						echo '<button id="bite" title="Unbite" data-state="active"></button><span id="bite_count" data-state="active">'.$bitecount.'</span>';
					}
					if($hasbit==false){
						echo '<button id="bite" title="Take a bite" data-state="inactive"></button><span id="bite_count" data-state="inactive">'.$bitecount.'</span>';
					}
					?>

				</p>
				<div id="description">
					<?php print( makeLinks($v[$id]['snippet']['description']) ); ?>
                    <br />
				</div>
                <div class="comment_section"><a style="float:right;" id="disqus-help" class="help-link" href="#">What's This?</a>
                    <div id="disqus_thread"></div>
                    <script>
                        /**
                         * RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                         * LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
                         */
                        var disqus_config = function () {
                            this.page.identifier = "<?php echo $id.$articletype; ?>";
                        };
                        (function() { // DON'T EDIT BELOW THIS LINE
                            var d = document, s = d.createElement('script');

                            s.src = '//gamesharkreview.disqus.com/embed.js';

                            s.setAttribute('data-timestamp', +new Date());
                            (d.head || d.body).appendChild(s);
                        })();
                    </script>
                    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
                </div>
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- GSR Article Bottom -->
                <ins class="adsbygoogle"
                     style="display:inline-block;margin-left:-40px;width:670px;height:70px"
                     data-ad-client="ca-pub-8657869581265556"
                     data-ad-slot="9451171827"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                </section>

            <div id="related_videos" class="grid_4 grid_0">
                <h4 style="margin-left:15px;">Related Videos</h4>
                <ul id="video-list"><center>Loading Related Videos...</center></ul>
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- GSR Article Side -->
                <ins class="adsbygoogle"
                     style="display:inline-block;width:200px;height:450px"
                     data-ad-client="ca-pub-8657869581265556"
                     data-ad-slot="8271829821"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>

            </div>


		</article>
	</div>

	<?php include "footer.html"; ?>
	<script type="text/javascript">

$(function(){

    function timeFormat(timeD){
        return timeD.replace("PT","").replace("H",":").replace("M",":").replace("S","");
    }

    $.get("videos-get.php?suggested-videos=true&num=5&exclude=<?php echo $id; ?>", function(data){
        $("#video-list").fadeOut("fast", function(){
            $("#video-list").html("");
            var v = eval('(' + data + ')');
            for (d = 0; d < v.length; d++) {
                var vhtml 	 = '<li><a data-id="'+v[d].id+'" class="video-contain" href="video.php?id='+v[d].id+'">';
                vhtml 		+= '<span style="background-image:url(https://i.ytimg.com/vi/'+v[d].id+'/mqdefault.jpg);" class="video">';
                vhtml 		+= '<span class="duration">'+timeFormat(v[d].contentDetails.duration)+'</span>';
                vhtml 		+= '<span class="views">'+v[d].statistics.viewCount+' views</span>';
                vhtml 		+= '</span>';
                vhtml 		+= '<span class="video-title">'+v[d].snippet.title+'</span>';
                vhtml 		+= '</a></li>';
                $("#video-list").append(vhtml);
                $("#video-list").fadeIn("fast");

            }
        });
    });

	$("#bite").click(function(){
		var videoid='<?php echo $id;?>';
		var articletype='<?php echo $articletype;?>';
		var state = $(this).attr("data-state");
		var count = parseInt($("#bite_count").text());
		var action;
		if(state=="active"){
			action = "unbite";
			$("#bite, #bite_count").attr("data-state", "inactive");
			$("#bite").attr("title", "Take a bite");
			count--;
		}
		if(state=="inactive"){
			action = "bite";
			$("#bite, #bite_count").attr("data-state", "active");
			$("#bite").attr("title", "Unbite");
			count++;
		}

		$("#bite_count").text(count);


		$.get("bite_action.php",
			{
				videoid: videoid,
				articletype: articletype,
				action: action
			},
			function(data, status){
				var row = data.split("-");
				var new_action = row[0];
				var new_count = row[1];
				if(new_action=="unbite"){
					$("#bite, #bite_count").attr("data-state", "inactive");
					$("#bite").attr("title", "Take a bite")
				}
				if(new_action=="bite"){
					$("#bite, #bite_count").attr("data-state", "active");
					$("#bite").attr("title", "Unbite")
				}
                ae8857b082115f203e8a5d23410461f7(50, articletype, videoid, "bite", "<h3>Article Bite!</h3> You have been rewarded %xp%xp<br />for biting this video.");
				$("#bite_count").text(new_count);

			});



	});

});

	</script>
</body>
</html>