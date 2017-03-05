<?php
	include "mysql_con.php";
	include "related-articles.php";

	$user = $_SESSION['username'];

	$opinion_title = mysqli_real_escape_string($con, str_replace("_", " ", $_GET['t']));

	if(!isset($_GET['t'])) { $articleSet = false; }
	if(isset($_GET['t'])) { $articleSet = true; }

	$accountQRY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$user'");

	while($infoQRY = mysqli_fetch_assoc($accountQRY)) {
		$check_firstname	= $infoQRY['firstname'];
		$check_lastname		= $infoQRY['lastname'];
		$check_fullname		= $check_firstname . " " . $check_lastname;
		$check_posa			= $infoQRY['posa'];
		$check_posb			= $infoQRY['posb'];
		$check_rank         = $infoQRY['rank'];
		$check_position		= $check_posa . " " . $check_posb;
	}

	$tQUERY = mysqli_query($con, "SELECT * FROM tbl_opinion WHERE title = '$opinion_title'");
	if(mysqli_num_rows($tQUERY)==0){ $articleSet = false; }
	while ($tROW = mysqli_fetch_array($tQUERY)) {
		$articleid 			= $tROW['id'];
		$articletype 	 	= $tROW['article_type'];
		$title 			 	= $tROW['title'];
		$file_main			= $tROW['main'];
		$content			= $tROW['Content'];
		$genre			 	= $tROW['genre'];
		$author			 	= $tROW['author'];
		$authuser			= $tROW['authuser'];
		$createdate		 	= $tROW['createdate'];
		$tags 				= $tROW['tags'];
		$aimage				= urlencode($tROW['a_image']);
		$bimage				= urlencode($tROW['b_image']);
		$cimage				= urlencode($tROW['c_image']);
		$dimage				= urlencode($tROW['d_image']);
		$eimage				= urlencode($tROW['e_image']);
		$url = "http://gamesharkreviews.com/opinion.php?t=" . str_replace(" ", "_", $title);
		$related = relatedArticles($tags, $articletype, 5, $title);
	}
	
	$viewer_ip = $_SERVER['REMOTE_ADDR'];

	$biteQUERY = mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE article_id = '$articleid' AND type = 'bite' AND ip = '$viewer_ip' AND article_type = '$articletype'");
	if(mysqli_num_rows($biteQUERY)>0){ 
	$hasbit=true;
	}else{$hasbit=false;}

	$bitecount = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE article_id = '$articleid' AND type = 'bite' AND article_type = '$articletype'"));
	if($bitecount==1){$bitecounttext="bite";}
	else{$bitecounttext = "bites";}
	
	$articleviews = (mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE article_id = '$articleid' AND type = 'view' AND article_type = '$articletype'"))+1);
	if($articleviews==1){$articleviewtext="view";}
	else{$articleviewtext = "views";}
	
	
	$aQUERY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$authuser'");
	while($aROW = mysqli_fetch_assoc($aQUERY)) {
		$arow_rank			= $aROW['rank'];
		$bQUERY = mysqli_query($con, "SELECT * FROM tbl_ranks WHERE id = $arow_rank");
		while($bROW = mysqli_fetch_assoc($bQUERY)) {
			$arow_position = $bROW['name'];
		}
		$arow_quote			= $aROW['quote'];
		$arow_pic			= $aROW['picture'];
	}

	if($arow_pic == NULL || $arow_pic == "" || empty($arow_pic)) {
		$arow_img = "default";
	} else {
		$arow_img = $arow_pic;
	}
	
	$fb_url = "http://www.facebook.com/sharer/sharer.php?u=".urlencode($url);
	$gplus_url = "https://plus.google.com/share?url=".urlencode($url);
	$twitter_url = "http://twitter.com/share?url=".urlencode($url)."&text=".urlencode($title.": \n");
	
?>

<!doctype html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?php echo $title . " by " . $author . " | " . $gamename . " Opinion Piece"; ?> | GSR</title>

<meta name="description" content="<?php echo $title . " by " . $author; ?>">

<meta name="author" content="<?php echo $author;?>" />

<meta itemprop="name" content="<?php echo $title;?>">
<meta itemprop="description" content="<?php echo $summary;?>">
<meta itemprop="image" content="http://gamesharkreviews.com/imgs/opinion/<?php echo $aimage; ?>">

<!-- for Facebook -->          
<meta property="og:title" content="<?php echo $title;?>" />
<meta property="og:type" content="article" />
<meta property="og:site_name" content="Gameshark Reviews (GSR)" />
<meta property="og:updated_time" content="<?php echo date("D jS M Y", strtotime($createdate));?>" />
<meta property="og:image" content="http://gamesharkreviews.com/imgs/opinion/<?php echo $aimage; ?>" />
<meta property="og:url" content="<?php echo $url;?>" />
<meta property="og:description" content="<?php echo $summary;?>" />

<!-- for Twitter -->          
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="<?php echo $title;?>" />
<meta name="twitter:description" content="<?php echo $summary;?>" />
<meta name="twitter:image" content="http://gamesharkreviews.com/imgs/opinion/<?php echo $aimage; ?>" />

<?php include "links.php"; ?>
</head>

<body>
<script type="application/ld+json">
	{
	"@context": "http://schema.org",
	"@type": "NewsArticle",
	"headline": "<?php echo $title;?> | <?php echo $author; ?>",
	"alternativeHeadline": "<?php echo $title;?> | <?php echo $author; ?>",
	"image": [
	"http://gamesharkreviews.com/imgs/opinion/<?php echo $aimage; ?>",
	"http://gamesharkreviews.com/imgs/opinion/<?php echo $bimage; ?>",
	"http://gamesharkreviews.com/imgs/opinion/<?php echo $cimage; ?>",
	"http://gamesharkreviews.com/imgs/opinion/<?php echo $dimage; ?>",
	"http://gamesharkreviews.com/imgs/opinion/<?php echo $eimage; ?>"
	],
	"datePublished": "<?php echo date(DATE_ISO8601, strtotime($createdate)); ?>",
	"description": "<?php echo strip_tags(substr(str_replace("\n","<br>",file_get_contents($file_main)), 0, 300).'...'); ?>"
	}
</script>

	<?php include "header.php"; ?>

	<div id="page" class="container_24">

		<article>
			<section class="grid_24" id="review_feature_image">
				<img src="imgs/opinion/<?php echo $aimage; ?>">
				<div id="gradient"></div>
				<h1><?php echo $title; ?><span><?php echo $articletype; ?></span></h1>
				<ul id="tagmenu">
					<li class="tagmenu_button" id="main_button">MAIN</li>
					<li class="tagmenu_button" id="author_button">AUTHOR</li>
				</ul>
			</section>

			<section id="review_page" class="grid_16">
				<p id="small_details">
					<small><b><?php echo $author . " / </b>" . date("D jS M Y", strtotime($createdate)); ?></small><br >
					<small><span id="displayviews"><?php echo $articleviews." ".$articleviewtext; ?></span><?php echo " <b> / </b> ".$bitecount. " " . $bitecounttext;?></small>
				</p>		
			
				<h2><?php echo $title; ?></h2>		
				<p class="content" id="main_section" style="margin:0px !important;">
					<?php echo strip_tags(html_entity_decode($content), $exclude_html); ?>
				</p>
				<br />
				<hr />
				<p class="social_share_bottom">
				<a class="social_fb" title="Share on Facebook" href="<?php echo $fb_url;?>" href="#"></a>
				<a class="social_twitter" title="Share on Twitter" href="<?php echo $twitter_url;?>" href="#"></a>
				<a class="social_gplus" title="Share on Google+" href="<?php echo $gplus_url;?>" href="#"></a>
				</p>
				<p id="bite_area">
				<?php 
				if($hasbit==true){ 
				echo '<button id="bite" title="Unbite" data-state="active"></button><span id="bite_count" data-state="active">'.$bitecount.'</span>';
				}
				if($hasbit==false){ 
				echo '<button id="bite" title="Take a bite" data-state="inactive"></button><span id="bite_count" data-state="inactive">'.$bitecount.'</span>';
				}
				?>
				<a id="bite-help" class="help-link" href="#">What's This?</a>
				</p>
				<p id="tags_area">
					<?php
						$explode_tags = explode(", ", $tags);
						foreach ($explode_tags as $tagvalue) {
							echo "<a rel='nofollow' href='search.php?q=".urlencode($tagvalue)."'>" . $tagvalue . "</a>";
						}
					?>
				</p>
				<p class="content" id="author_section">
				
					<span>ABOUT THE AUTHOR</span>
					<img src="imgs/users/<?php echo $arow_img; ?>-116x135.jpg" title="Profile picture of <?php echo $author; ?>">
					<big><?php echo $author; ?></big><br>
					<b><?php echo $arow_position; ?></b><br>
					<a rel='nofollow' href="profile.php?profilename=<?php echo $authuser; ?>">VIEW PROFILE PAGE</a>
				</p>
				<div class="comment_section"><a style="float:right;" id="disqus-help" class="help-link" href="#">What's This?</a>
				<div id="disqus_thread"></div>
				<script>
				/**
				* RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
				* LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
				*/
				var disqus_config = function () {
				this.page.identifier = "<?php echo $articleid.$articletype; ?>";
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
					 style="display:inline-block;width:670px;height:70px"
					 data-ad-client="ca-pub-8657869581265556"
					 data-ad-slot="9451171827"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</section>
			
			<div id="image_holder" class="grid_4 grid_0">
				<a href="imgs/opinion/<?php echo $aimage; ?>"><img src="imgs/opinion/<?php echo $aimage; ?>" width="200" height="100"></a>
				<a href="imgs/opinion/<?php echo $bimage; ?>"><img src="imgs/opinion/<?php echo $bimage; ?>" width="200" height="100"></a>
				<a href="imgs/opinion/<?php echo $cimage; ?>"><img src="imgs/opinion/<?php echo $cimage; ?>" width="200" height="100"></a>
				<a href="imgs/opinion/<?php echo $dimage; ?>"><img src="imgs/opinion/<?php echo $dimage; ?>" width="200" height="100"></a>
				<a href="imgs/opinion/<?php echo $eimage; ?>"><img src="imgs/opinion/<?php echo $eimage; ?>" width="200" height="100"></a>

				<hr />
				<h4>Related Opinion Pieces</h4>
				<ul id="related-articles" style="display: block !important;">
					<?php foreach($related as $rel){
						$rel['url'] = "opinion.php?t=" . str_replace(" ", "_", $rel['title']);
						$rel['image'] = "imgs/opinion/".urlencode($rel['a_image']);
						?>
						<li>
							<a class="related-contain" href="<?php echo $rel['url'];?>">
									<span style="background-image:url(<?php echo $rel['image'];?>);" class="related">
										<span class="related-bites">
											<?php echo formatNum($rel['bites']);?> bites
										</span>
										<span class="related-views">
											<?php echo formatNum($rel['views']);?> views
										</span>
									</span>
								<span class="related-title"><?php echo $rel['title'];?></span>
							</a>
						</li>
					<?php } ?>
				</ul>

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

        var articleid=<?php echo $articleid;?>;
        var articletype='<?php echo $articletype;?>';

        $(".social_share_side a, .social_share_bottom a").click(function(e){
            e.preventDefault();
            var socialURL = $(this).attr("href");
            var actionType = $(this).attr("class");
            window.open( socialURL, "socialWindow", "status = 1, height = 550, width = 600, resizable = 0" );
            ae8857b082115f203e8a5d23410461f7(50, articletype, articleid, actionType, "<h3>Article Share!</h3> You have been rewarded %xp%xp<br />for sharing this opinion piece.");
        });

        $(function() {
	$.post("article_view_action.php",
    {
        articleid: articleid,
        articletype: articletype
    },
    function(data, status){
		$("#displayviews").text(data);
		setTimeout(function(){
			ae8857b082115f203e8a5d23410461f7(150, articletype, articleid, "view", "<h3>Article View!</h3> You have been rewarded %xp%xp<br />for reading this opinion piece.");
		}, 30000);
    });
});

$("#bite").click(function(){
	var articleid=<?php echo $articleid;?>;
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
        articleid: articleid,
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
			$("#bite").attr("title", "Unbite");

	}
        ae8857b082115f203e8a5d23410461f7(50, articletype, articleid, "bite", "<h3>Article Bite!</h3> You have been rewarded %xp%xp<br />for biting this opinion piece.");
	$("#bite_count").text(new_count);
		
    });
	
	
	
	});

	
$('#image_holder').magnificPopup({
	delegate: 'a:not(.related-contain)', // child items selector, by clicking on it popup will open
	type: 'image',  
    gallery: {
      enabled: true
    }
  // other options
});

		$(function() {
			$(".tagmenu_button").each(function() {
				var btnID = $(this).attr("id").replace("_button","");

				$(this).click(function() {
					$("html, body").animate({
						scrollTop : ($("#" + btnID + "_section").offset().top - 80)
					}, 1000);
				});
			});
		});

	</script>

</body>
</html>