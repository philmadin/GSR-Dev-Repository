<?php
	include "mysql_con.php";
	include_once "videos-get.php";
?>
<!doctype html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<meta name="robots" content="index, follow, noarchive">

<title>The Entire List of Videos From Game Shark Reviews | Videos | GSR</title>

<meta name="description" content="The list of GSR's Video reviews, Interviews, Tips, Cheats and More.">

<?php include "links.php"; ?>

</head>

<body>

	<?php include "header.php"; ?>

	<div id="video-page" class="container_24">

		<article>

			<section id="main_featured_article">

					<center>
					<img style="width:auto;height:100%;margin:auto;display:block;position:static !important;" src="https://i.ytimg.com/vi/<?php echo $v['i'][0]['id'];?>/hqdefault.jpg" />
					</center>
				<a href="video.php?id=<?php echo $v['i'][0]['id'];?>" title="<?php echo $v['i'][0]['title'];?>"></a>
				<h1 class="main_featured_article_banner"><abbr title="Game Shark Reviews">GSR</abbr> VIDEOS</h1>
			</section>

			<section class="grid_18">
				<ul id="video-list"><center>Loading Videos...</center></ul>	
			</section>

			<aside class="articles grid_6 tall_8">
				<?php include "aside.php"; ?>
			</aside>

		</article>
	</div>

	<?php include "footer.html"; ?>
	<script type="text/javascript">

$(function(){
	
	function timeFormat(timeD){
		return timeD.replace("PT","").replace("H",":").replace("M",":").replace("S","");
	}
	
	$.get("videos-get.php?video-list=true", function(data){
			$("#video-list").fadeOut("fast", function(){
			$("#video-list").html("");
			var v = eval('(' + data + ')');
			console.log(data);
			for (d = 0; d < v.i.length; d++) { 
				var vhtml 	 = '<li><a data-id="'+v.i[d].id+'" class="video-contain" href="video.php?id='+v.i[d].id+'">';
				vhtml 		+= '<span style="background-image:url(https://i.ytimg.com/vi/'+v.i[d].id+'/maxresdefault.jpg);" class="video">';
				vhtml 		+= '<span class="duration">'+timeFormat(v.i[d].contentDetails.duration)+'</span>';
				vhtml 		+= '<span class="views">'+v.i[d].statistics.viewCount+' views</span>';
				vhtml 		+= '</span>';
				vhtml 		+= '<span class="video-title">'+v.i[d].snippet.title+'</span>';
				vhtml 		+= '</a></li>';
				$("#video-list").append(vhtml);
				$("#video-list").fadeIn("fast");
				
			}
		});
	});
	
});

	</script>
</body>
</html>