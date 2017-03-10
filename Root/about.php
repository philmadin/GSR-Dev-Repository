<?php include "mysql_con.php"; ?>

<!doctype html>
<html lang="en">
<head>

<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<meta name="robots" content="index, follow, noarchive">

<title>Meet the Frenzy of Game Shark Reviews | About | GSR</title>

<meta name="description" content="The Frenzy - Meet the Game Shark Reviews team">

<?php include "links.php"; ?>

</head>

<body>

	<?php include "header.php"; ?>

	<article class="aboutPage">
		<section class="about_section-sky">
			<div id="floating_clouds"></div>
			<h1 class="frenzy_title">
				<small class="frenzy_upper">THE</small>
				FRENZY
				<small class="frenzy_lower">MEET THE <a href="index.php">GAME SHARK REVIEWS</a> TEAM</small>
			</h1>
			<div class="animated_wave back-wave"></div>
			<div class="animated_fins">
				<img src="imgs/gsr_about_page_shark_fin_2.png" class="fin_2">
				<img src="imgs/gsr_about_page_shark_fin_1.png" class="fin_1">
			</div>
			<div class="animated_wave front-wave"></div>
		</section>
		
				<?php

			$sectorQRY = mysqli_query($con, "SELECT * FROM tbl_rank_sectors");
				while ($sectorROW = mysqli_fetch_assoc($sectorQRY)) {
					$sector_id = $sectorROW['id'];
					$sector_name = $sectorROW['name'];
						echo '<section class="container_24"><div class="grid_24">';
						echo '<h2>'.$sector_name.'</h2>';
					$rankQRY = mysqli_query($con, "SELECT * FROM tbl_ranks WHERE sector = $sector_id");
					while ($rankROW = mysqli_fetch_assoc($rankQRY)) {
						$rank_id = $rankROW['id'];
						$rank_name = $rankROW['name'];

						$aboutQRY1 = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE rank = $rank_id");

						while ($aboutROW1 = mysqli_fetch_assoc($aboutQRY1)) {
							$about_username1		= $aboutROW1['username'];
							$about_firstname1	= $aboutROW1['firstname'];
							$about_lastname1		= $aboutROW1['lastname'];
							$about_picture1		= $aboutROW1['picture'];
							$about_level		= $aboutROW1['level'];

							if($about_picture1 == NULL || $about_picture1 == "" || empty($about_picture1)) {
								$about_image1 = "default";
							} else {
								$about_image1 = $about_picture1;
							}

							echo '

							<a class="shark_pic" data-shark-picture="'.$about_image1.'" href="profile.php?profilename='.$about_username1.'">
							<span>
                                    '.$about_firstname1.' '.$about_lastname1.'
                                <br>
								<small>'.$rank_name.'</small><br />
								<small>LVL: '.$about_level.'</small>
							</span>
							</a>

							';

						}

					}

					echo '</div></section>';
				}

		?>


		<section id="contact_information" class="container_24">
			<p class="grid_8">
				Administration<br>
				<span>admin@gamesharkreviews.com</span>
			</p>
			<p class="grid_8">
				Content Director<br>
				<span>cd@gamesharkreviews.com</span>
			</p>
			<p class="grid_8">
				Community Manager<br>
				<span>cm@gamesharkreviews.com</span>
			</p>
			<p class="grid_8">
				Media Director<br>
				<span>md@gamesharkreviews.com</span>
			</p>
			<p class="grid_8">
				Web Developer<br>
				<span>dev@gamesharkreviews.com</span>
			</p>
			<p class="grid_8">
				CEO<br>
				<span>ceo@gamesharkreviews.com</span>
			</p>
		</section>

	</article>

	<?php include "footer.html"; ?>

	<script type="text/javascript">
		$(function() {

			const clouds_num = 10;

			function init_clouds() {
				var anim_clouds = document.getElementById('floating_clouds');
				for (var i = 0; i < clouds_num; i++) {
				    anim_clouds.appendChild(createACloud());
				}
			}

			function randomInteger(low, high) { return low + Math.floor(Math.random() * (high - low)); }
			function randomFloat(low, high) { return low + Math.random() * (high - low); }
			function pixelValue(value) { return value + 'px'; }
			function durationValue(value) { return value + 's'; }
			function cloudValue(low, high) { return low + Math.floor(Math.random() * (high - low + 1))}

			function createACloud() {
				var cloudDiv = document.createElement('div');
				var aCloud = document.createElement('img');

				aCloud.src = 'imgs/gsr_about_page_cloud_' + cloudValue(1, 2) + '.svg';

				cloudDiv.style.top = pixelValue(randomInteger(0, 250));
				cloudDiv.style.height = pixelValue(randomInteger(50, 80));
				cloudDiv.style.opacity = "." + randomInteger(1, 99);
				cloudDiv.style.webkitAnimationName = 'moveCloud';

				var fadeAndDropDuration = durationValue(randomFloat(18, 26));
				cloudDiv.style.webkitAnimationDuration = fadeAndDropDuration;

				var cloudDelay = durationValue(randomFloat(0, 10));
				cloudDiv.style.webkitAnimationDelay = cloudDelay;

				cloudDiv.appendChild(aCloud);
				return cloudDiv;
			}

			window.addEventListener('load', init_clouds, false);
		});
	</script>

</body>
</html>