<script>
	window.fbAsyncInit = function() {
		FB.init({
			appId      : '208284399553569',
			xfbml      : true,
			version    : 'v2.6'
		});
	};

	(function(d, s, id){
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>





<?php
	include "mysql_con.php";


	if(isset($_SESSION['username'])){$sessionlogin = $_SESSION['username'];}
	if(isset($_COOKIE['username'])){$cookielogin = $_COOKIE['username'];}


$getVersion = mysqli_query($con, "SELECT * FROM tbl_changelog WHERE comingsoon=0 ORDER BY id DESC LIMIT 1");
while ($versionNum = mysqli_fetch_assoc($getVersion)) {
	$GSR_version_num = $versionNum['version'];
}
?>
<script>
	var GSR_version_num = <?php echo $GSR_version_num;?>;
</script>
<?php
include 'holiday-code.php';
?>
<header>
	<div class="navigation container_24">
		<a id="svg" href="index.php">
			<svg version="1.1" id="gsr_logo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
				 viewBox="0 0 1095 321" enable-background="new 0 0 1095 321" xml:space="preserve">
				<defs>
				    <linearGradient id="linGrad" x1="0%" y1="0%" x2="0%" y2="100%">
						<stop offset="0%" style="stop-color:rgb(230,39,39);stop-opacity:1" />
				      	<stop offset="100%" style="stop-color:rgb(231,48,48);stop-opacity:1" />
				    </linearGradient>
				</defs>
				<path fill="#9A1C1F" class="controller_back" d="M1021.5,237.1H785.8c0-33.2,23-60,51.4-60c0.6,0,1.2,0,1.9,0.1V177h132.9v0.1C999.4,178.2,1021.5,204.6,1021.5,237.1z"/>
				<path fill="url(#linGrad)" class="controller_body" d="M1021.5,228.9c0,28.6-23,51.8-51.4,51.8c-16.5,0-31.2-7.9-40.6-20.1h-51.7c-9.4,12.2-24.1,20.1-40.6,20.1c-28.4,0-51.4-23.2-51.4-51.8s23-51.8,51.4-51.8c0.6,0,1.2,0,1.9,0v0h132.9v0C999.4,178.1,1021.5,200.9,1021.5,228.9z"/>
				<rect fill="url(#linGrad)" class="controller_wire" x="898.8" y="39.8" width="9.7" height="138.2"/>
				<path fill="#FFFFFF" class="controller_btns" d="M983.5,228.8c-6.2,0-11.3-5.1-11.3-11.3c0-6.3,5.1-11.4,11.3-11.4c6.2,0,11.3,5.1,11.3,11.4C994.8,223.7,989.8,228.8,983.5,228.8z M961.3,251.1c-6.3,0-11.3-5.1-11.3-11.4c0-6.3,5.1-11.3,11.3-11.3c6.3,0,11.3,5.1,11.3,11.3C972.7,246,967.6,251.1,961.3,251.1z"/>
				<path fill="#FFFFFF" class="controller_dpad" d="M856.1,234.2h-15.3v15.1h-11.1v-15.1h-15.1v-11.1h15.1v-15.4h11.1v15.4h15.3V234.2z"/>
				<g enable-background="new">
					<path fill="url(#linGrad)" class="letter_r" d="M579.3,38.4h73.4c33.6,0,59.4,0.3,80.1,16.3C750.5,68.2,760,89,760,114.1c0,37.7-19,61.8-54.3,69.3l66.2,97.8h-74.7l-55.7-95.1v95.1h-62.1V38.4z M653.7,153.1c27.8,0,41.1-8.8,41.1-30.2c0-25.5-12.6-33.6-40.1-33.6h-13.2v63.8H653.7z"/>
				</g>
				<g enable-background="new">
					<path fill="url(#linGrad)" class="letter_s" d="M447.9,236c18.3,0,30.2-10.9,30.2-25.1c0-19.4-13.2-25.1-40.8-32.3c-43.8-11.5-65.2-29.2-65.2-67.2c0-45.2,32.9-78.8,83.9-78.8c27.2,0,50.9,7.1,72,21.7l-20.7,47.5c-15.3-12.9-31.6-19.4-46.5-19.4c-16.3,0-26.8,8.8-26.8,20.4c0,17.3,16.6,21.1,38.7,26.8c43.1,11.5,66.9,27.5,66.9,72.3c0,50.6-36,85.6-93.1,85.6c-34.3,0-60.1-10.9-86.3-35.7l29.9-49.2C409.6,224.8,428.6,236,447.9,236z"/>
				</g>
				<g enable-background="new">
					<path fill="url(#linGrad)" class="letter_g" d="M214.8,140.9h130.1c0.3,5.1,0.3,9.8,0.3,14.6c0,83.9-47.5,131.4-126.3,131.4c-38.7,0-68.9-11.2-93.4-36c-23.1-23.4-36.3-56.7-36.3-91c0-73.7,55-127,129.7-127c47.2,0,84.2,19,109.4,56l-57.4,27.5c-13.6-18.7-30.6-27.8-52-27.8c-38.7,0-63.8,27.2-63.8,74c0,46.5,24.8,74.4,63.8,74.4c34.3,0,58.4-19,61.8-45.2h-65.9V140.9z"/>
				</g>
			</svg>
		</a>

		<nav class="grid_19">
			<ul>
				<?php include "menu.html"; ?>

				<?php
					if(!isset($sessionlogin) || !isset($cookielogin)) {
						echo '<li><a class="live">LOGIN</a></li>';
					} else {
						echo '<li><a class="unlive">LOGOUT</a></li>';
					}
				?>
				<li>
				<form action="search.php?">
				<input class="search" name="q" type="search" value="<?php echo $_GET['q'];?>" placeholder="Search"/>
				</form>
				</li>
			</ul>
			<div class="marquee_links">
			<p>
				<?php
					$MQi = 0;
					$art_row = array();
						
					$review_link_list = mysqli_query($con, "SELECT * FROM tbl_review WHERE alpha_approved = 'true' ORDER BY id DESC LIMIT 3");
					while ($rvw_row = mysqli_fetch_assoc($review_link_list)) {
					array_push($art_row, $rvw_row);
					}
					$opinion_link_list = mysqli_query($con, "SELECT * FROM tbl_opinion WHERE alpha_approved = 'true' ORDER BY id DESC LIMIT 3");
					while ($op_row = mysqli_fetch_assoc($opinion_link_list)) {
					array_push($art_row, $op_row);
					}
					$news_link_list = mysqli_query($con, "SELECT * FROM tbl_news WHERE alpha_approved = 'true' ORDER BY id DESC LIMIT 3");
					while ($news_row = mysqli_fetch_assoc($news_link_list)) {
					array_push($art_row, $news_row);
					}
					$guide_link_list = mysqli_query($con, "SELECT * FROM tbl_guide WHERE alpha_approved = 'true' ORDER BY id DESC LIMIT 3");
					while ($gd_row = mysqli_fetch_assoc($guide_link_list)) {
					array_push($art_row, $gd_row);
					}
						
						function date_compare($a, $b)
						{
							$t1 = strtotime($b['createdate']);
							$t2 = strtotime($a['createdate']);
							return $t1 - $t2;
						}    
						usort($art_row, 'date_compare');
						$art_row = array_slice($art_row, 0, 3);
						
					foreach ($art_row as $MQrow) {
					$MQi++;
					$MQtitle = $MQrow['title'];
					$MQsummary = $MQrow['summary'];
					$MQgamename = $MQrow['gamename'];
					
					if($MQrow['article_type']=="Review"){	
					$MQurl = "review.php?t=" . urlencode(str_replace(" ", "_", $MQtitle)) . "&g=" . urlencode(str_replace(" ", "_", $MQgamename));
					echo '<a href="'.$MQurl.'">'.$MQtitle.' - '.substr($MQsummary, 0, -80).'...</a>';if($MQi!=3){echo '&nbsp; &bull; &nbsp;';}
					}					
					if($MQrow['article_type']=="Opinion"){	
					$MQurl = "opinion.php?t=" . urlencode(str_replace(" ", "_", $MQtitle));
					echo '<a href="'.$MQurl.'">'.$MQtitle.'</a>';if($MQi!=3){echo '&nbsp; &bull; &nbsp;';}
					}						
					if($MQrow['article_type']=="News"){	
					$MQurl = "news.php?t=" . urlencode(str_replace(" ", "_", $MQtitle));
					echo '<a href="'.$MQurl.'">'.$MQtitle.'</a>';if($MQi!=3){echo '&nbsp; &bull; &nbsp;';}
					}					
					if($MQrow['article_type']=="Guide"){	
					$MQurl = "guide.php?t=" . urlencode(str_replace(" ", "_", $MQtitle));
					echo '<a href="'.$MQurl.'">'.$MQtitle.'</a>';if($MQi!=3){echo '&nbsp; &bull; &nbsp;';}
					}
					
					
					}
				?>
				</p>
			</div>
		</nav>
	</div>
</header>



<?php

	$exclude_html = '<a><b><bold><strong><img><i><h1><h2><h3><h4><h5><h6><br><hr>';


	if(!isset($sessionlogin) || !isset($cookielogin)) {
		include "loginform.php";
	} else {
		include "usermenu.php";
	}
?>