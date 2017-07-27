<?php
	include "mysql_con.php";

	$user = $_SESSION['username'];

	$getArticle = $_GET['article'];

	if(!isset($user)) { header("location:index.php"); }
	if(empty($getArticle)) { header("location:index.php"); }

	$accountQRY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$user'");

	while($infoQRY = mysqli_fetch_assoc($accountQRY)) {
		$check_firstname	= $infoQRY['firstname'];
		$check_lastname		= $infoQRY['lastname'];
		$check_fullname		= $check_firstname . " " . $check_lastname;
	}

	$articleQRY = mysqli_query($con, "SELECT * FROM tbl_review WHERE id = '$getArticle'");

	while ($artROW = mysqli_fetch_assoc($articleQRY)) {
		$articletype 	 	= $artROW['article_type'];
		$title 			 	= $artROW['title'];
		$gamename		 	= $artROW['gamename'];
		$summary		 	= $artROW['summary'];
		$file_overview		= $artROW['content_1'];
		$file_storyline	 	= $artROW['content_2'];
		$file_gameplay		= $artROW['content_3'];
		$file_audio		 	= $artROW['content_4'];
		$file_graphics	 	= $artROW['content_5'];
		$file_verdict	 	= $artROW['content_6'];
		
		$overview 			= $artROW['Overview'];
		$Content1			= $artROW['HTMLContent_1'];
		$Content2	 		= $artROW['HTMLContent_2'];
		$Content4			= $artROW['HTMLContent_4'];
		$Content3 			= $artROW['HTMLContent_3'];
		$verdict 			= $artROW['Verdict'];

		$trailer		 	= $artROW['trailer'];
		$testedplatforms 	= $artROW['testedplatforms'];
		$genre			 	= $artROW['genre'];
		$author			 	= $artROW['author'];
		$createdate		 	= $artROW['createdate'];
		$developers		 	= $artROW['developers'];
		$publishers			= $artROW['publishers'];
		$platforms			= $artROW['platforms'];
		$release_date	 	= $artROW['release_date'];
		$officialsite	 	= $artROW['officialsite'];
		$developersites	 	= $artROW['developersites'];
		$publishersites	 	= $artROW['publishersites'];
		$temp				= array($artROW['Rating_1'],$artROW['Rating_2'],$artROW['Rating_3'],$artROW['Rating_4']);
		$main_rating		= $artROW['main_rating'];
		$file_beta_notes	= $artROW['beta_notes'];
		$file_alpha_notes	= $artROW['alpha_notes'];
		$tags 				= $artROW['tags'];
		$authuser 	    	= $artROW['authuser'];
		$pending			= $artROW['pending'];
		$beta_approval		= $artROW['beta_approval'];
		$alpha_approval		= $artROW['alpha_approval'];
		$classification		= $artROW['classification'];
	}
	$rating=array();
	foreach($temp as $string){
		$number = (float)$string;
		if($number<3.75){
			array_push($rating,2.5);
		}else if($number>=3.75&&$number<6.25){			
			array_push($rating,5);
		}else if($number>=6.25&&$number<8.75){
			array_push($rating,7.5);
		}else if($number>=8.75){
			array_push($rating,10);
		}
	}
	switch($classification){
		case "G":
			$generallabel="Game";
			$label1="Storyline";
			$label2="Gameplay";
			$label3="Graphics";
			$label4="Audio";
			break;
		case "T":
			$generallabel="Tech";
			$label1="Intuitive";
			$label2="Ergonomic";
			$label3="Design";
			$label4="Value";
			break;
		case "M":
			$generallabel="Movie";
			$label1="Storyline";
			$label2="Cinematography";
			$label3="Audio";
			$label4="Direction";
			break;
	}
global $authuser;
if (!has_perms("edit-article-override")) {
	if($user!=$authuser) {
		header("Location: articlelist.php");
	}
}



	if(!empty($file_beta_notes)) { $beta_notes = str_replace("\n","\r\n",file_get_contents($file_beta_notes)); } else { $beta_notes = 'No notes or corrections were given.'; }
	if(!empty($file_alpha_notes)) { $alpha_notes = str_replace("\n","\r\n",file_get_contents($file_alpha_notes)); } else { $alpha_notes = 'No notes or corrections were given.'; }
?>

<!doctype html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, follow, noarchive">

<title>Edit/Revise <?php echo $title . " from " . $author; ?> | Article Revision | GSR</title>

<meta name="description" content="Edit and/or revise <?php echo $title . " from " . $author; ?>.">

<?php include "links.php"; ?>

</head>

<body>
	<script>

	function changeTo(event){
		switch(event){
			case "G":
				$('#content_1_section label').text("Storyline");
				$('#firstContentRating').text("Storyline");
				$('#content_2_section label').text("Gameplay");
				$('#secondContentRating').text("Gameplay");
				$('#content_3_section label').text("Graphics");
				$('#thirdContentRating').text("Graphics");
				$('#content_4_section label').text("Audio");
				$('#fourthContentRating').text("Audio");
				$('#storylinerating option')[0].innerHTML="2.5 - Very basic storyline or ambiguous storyline.";
				$('#storylinerating option')[1].innerHTML="5.0 - Mediocre storyline or not original, lacks creativity.";
				$('#storylinerating option')[2].innerHTML="7.5 - Great storyline or better than average.";
				$('#storylinerating option')[3].innerHTML="10 - Incredible storyline, very creative or immersive.";
				$('#gameplayrating option')[0].innerHTML="2.5 - Hard to play or not intuitive at all.";
				$('#gameplayrating option')[1].innerHTML="5.0 - Mediocre gameplay or lacks creativity, average.";
				$('#gameplayrating option')[2].innerHTML="7.5 - Great gameplay or better than average.";
				$('#gameplayrating option')[3].innerHTML="10 - Incredible gameplay, very creative or immersive.";
				$('#graphicsrating option')[0].innerHTML="2.5 - Poor quality graphics or graphics are very basic.";
				$('#graphicsrating option')[1].innerHTML="5.0 - Standard graphics; nothing new; mediocre.";
				$('#graphicsrating option')[2].innerHTML="7.5 - Great graphics; fluid; better than average.";
				$('#graphicsrating option')[3].innerHTML="10 - Incredible graphics, very creative or high quality.";
				$('#audiorating option')[0].innerHTML="2.5 - Very basic sounds; not a huge variety; poor.";
				$('#audiorating option')[1].innerHTML="5.0 - Standard sound effects or not really immersive.";
				$('#audiorating option')[2].innerHTML="7.5 - Great audio effects; slightly immersive.";
				$('#audiorating option')[3].innerHTML="10 - Incredible sound effects, very immersive/creative.";
				break;
			case "T":
				$('#content_1_section label').text("Intuitive");
				$('#firstContentRating').text("Intuitive");
				$('#content_2_section label').text("Ergonomic");
				$('#secondContentRating').text("Ergonomic");
				$('#content_3_section label').text("Design");
				$('#thirdContentRating').text("Design");
				$('#content_4_section label').text("Value");
				$('#fourthContentRating').text("Value");
				$('#storylinerating option')[0].innerHTML="2.5 - Was difficult to learn or not easy to learn.";
				$('#storylinerating option')[1].innerHTML="5.0 - Was neither easy or difficult to learn.";
				$('#storylinerating option')[2].innerHTML="7.5 - Was easy to learn and engaging.";
				$('#storylinerating option')[3].innerHTML="10 - Incredibly easy to learn, extremely natural.";
				$('#gameplayrating option')[0].innerHTML="2.5 - Not comfortable or feels uncomfortable.";
				$('#gameplayrating option')[1].innerHTML="5.0 - Doesn’t feel bad and doesn’t feel good.";
				$('#gameplayrating option')[2].innerHTML="7.5 - Feels great, not too shabby at all.";
				$('#gameplayrating option')[3].innerHTML="10 - Feels incredible! This can’t get any better!.";
				$('#graphicsrating option')[0].innerHTML="2.5 - Very poor design for the intended purpose of use.";
				$('#graphicsrating option')[1].innerHTML="5.0 - Mediocre design, designed for the intended purpose.";
				$('#graphicsrating option')[2].innerHTML="7.5 - Excellent design, above and beyond.";
				$('#graphicsrating option')[3].innerHTML="10 - Incredible design, sets the benchmark!.";
				$('#audiorating option')[0].innerHTML="2.5 - Not worth the money; poor value for money.";
				$('#audiorating option')[1].innerHTML="5.0 - Was a just cost, though I wouldn’t pay a cent more.";
				$('#audiorating option')[2].innerHTML="7.5 - Was definitely worth the investment.";
				$('#audiorating option')[3].innerHTML="10 - Great value for money, I’d buy this again!";
				break;
			case "M":
				$('#content_1_section label').text("Storyline");
				$('#firstContentRating').text("Storyline");
				$('#content_2_section label').text("Cinematography");
				$('#secondContentRating').text("Cinematography");
				$('#content_3_section label').text("Audio");
				$('#thirdContentRating').text("Audio");
				$('#content_4_section label').text("Direction");
				$('#fourthContentRating').text("Direction");
				$('#storylinerating option')[0].innerHTML="2.5 - The storyline was very cookie-cutter, not original.";
				$('#storylinerating option')[1].innerHTML="5.0 - Basic storyline, not boring, but not exciting either.";
				$('#storylinerating option')[2].innerHTML="7.5 - Great story! But I wouldn’t see it again anytime soon.";
				$('#storylinerating option')[3].innerHTML="10 - Wow! Can we watch that again?.";
				$('#gameplayrating option')[0].innerHTML="2.5 - Awkward angles; poor scenery; bad camera work.";
				$('#gameplayrating option')[1].innerHTML="5.0 - Average camera work, not bad.";
				$('#gameplayrating option')[2].innerHTML="7.5 - Great placement, good locations and shots.";
				$('#gameplayrating option')[3].innerHTML="10 - Incredible camera work, couldn’t have been better!";
				$('#graphicsrating option')[0].innerHTML="2.5 - Very poor quality; not creative.";
				$('#graphicsrating option')[1].innerHTML="5.0 - Average quality, nothing noteworthy.";
				$('#graphicsrating option')[2].innerHTML="7.5 - Terrific quality, creative and slightly immersive.";
				$('#graphicsrating option')[3].innerHTML="10 - Incredible graphics, very creative or high quality.";
				$('#audiorating option')[0].innerHTML="2.5 - Poor cast; no chemistry; rushed film; uncreative.";
				$('#audiorating option')[1].innerHTML="5.0 - Standard chemistry; cast weren’t special; average.";
				$('#audiorating option')[2].innerHTML="7.5 - Great cast; good direction; very creative; good pace.";
				$('#audiorating option')[3].innerHTML="10 - Incredible cast, great pace; great chemistry; terrific!";
				break;
		}
	}

	$(document).ready(function(){
		changeTo("<?php echo $classification?>");
	})
	</script>
	<?php include "header.php"; ?>

	<div id="page" class="container_24">

		<article>

			<section id="articlesubmit">

				<form class="grid_18 grid_0 submitform" id="submitform" method="get" action="" enctype="multipart/form-data">
					<h6>Article Submission</h6>

				    <p class="scroll_section" id="type_section" style="display:none;">
				    	<label for="articletype">Article Type</label>
				        <select id="articletype" name="articletype">
				            <option value="Review" selected>Review</option>
				        </select>
				    </p>
					<table>
						<tr>		
							<td>
								<label for="classification">Subject Classification</label>
							</td>
							<td>
								<select id="classification" name="classification" onchange="changeTo(this.value);">
								<?php
									switch($classification){
										case "G":
											
											echo "<option value='G'>Game review</option>";
											echo "<option value='M'>Movie review</option>";
											echo "<option value='T'>Tech review</option>";
											break;
										case "T":					
											echo "<option value='T'>Tech review</option>";					
											echo "<option value='G'>Game review</option>";
											echo "<option value='M'>Movie review</option>";
											break;
										case "M":
											echo "<option value='M'>Movie review</option>";
											echo "<option value='G'>Game review</option>";
											echo "<option value='T'>Tech review</option>";
											break;
										}
								?>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<label for="gamename">Subject Title</label>
							</td>
							<td>
				       			<input name="gamename" id="gamename" type="text" value="<?php echo $gamename; ?>" placeholder="<?php echo $gamename; ?>" required />
							</td>
						</tr>
						<tr>
							<td>
								<label for="articletitle">Title</label>
							</td>
							<td>
								<input name="articletitle" id="articletitle" type="text" value="<?php echo $title; ?>" placeholder="<?php echo $title; ?>" required />
							</td>
						</tr>
					</table>

				    <p class="scroll_section" id="summary_section">
				    	<label for="summary">Summary <i>(MAX 100 CHARACTERS)</i></label>
				        <textarea name="summary" id="summary" required maxlength="100"><?php echo $summary; ?></textarea>
				        <span id="charCount">100 Characters left.</span>
				    </p>

				    <p class="scroll_section" id="overview_section">
				    	<label for="overview">Overview</label>
				        <textarea name="overview" id="overview" required><?php echo $overview; ?></textarea>
				    </p>

				    <p class="scroll_section" id="content_1_section">
				    	<label for="storyline"><?php echo $label1; ?></label>
				        <textarea name="storyline" id="storyline" required><?php echo $Content1; ?></textarea>
				    </p>

				    <p class="scroll_section" id="content_2_section">
				    	<label for="gameplay"><?php echo $label2; ?></label>
				        <textarea name="gameplay" id="gameplay" required><?php echo $Content2; ?></textarea>
				    </p>
					
				    <p class="scroll_section" id="content_3_section">
				    	<label for="graphics"><?php echo $label3; ?></label>
				        <textarea name="graphics" id="graphics" required><?php echo $Content3; ?></textarea>
				    </p>

				    <p class="scroll_section" id="content_4_section">
				    	<label for="audio"><?php echo $label4; ?></label>
				        <textarea name="audio" id="audio" required><?php echo $Content4; ?></textarea>
				    </p>

				    <p class="scroll_section" id="verdict_section">
				    	<label for="verdict">Verdict</label>
				        <textarea name="verdict" id="verdict" required><?php echo $verdict; ?></textarea>
				    </p>

				    <p class="scroll_section" id="trailer_section">
				    	<label for="trailer">Official Trailer - YOUTUBE URL <i>(prefered if more than one)</i></label>
				        <input name="trailer" id="trailer" type="url" value="<?php echo $trailer; ?>" placeholder="<?php echo $trailer; ?>"/>
				        <span>
				        	<b>1. &nbsp; </b> Find your trailer video on YouTube<br>
				        	<b>2. &nbsp; </b> Click on &lsquo;Share&rsquo; found under the video<br>
				        	<b>3. &nbsp; </b> Click on the &lsquo;Embed&rsquo; tab<br>
				        	<b>4. &nbsp; </b> Copy the URL found in the &lsquo;src=&rsquo; attribute of the given code<br>
				        	<b>5. &nbsp; </b> Paste the URL here.
				        </span>
				    </p>

				    <p class="scroll_section" id="releasedate_section">
				    	<label for="releasedate">Game Release Date <i>(FORMAT: YYYY-MM-DD)</i></label>
				        <input name="releasedate" id="releasedate" type="text" value="<?php echo date('Y-m-d', strtotime($release_date)); ?>" placeholder="<?php echo $releasedate; ?>" maxlength="10" minlength="10" required />
				    </p>

				    <p class="scroll_section" id="platforms_section">
				    	<label for="platforms">Available Platforms <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
				        <input name="platforms" id="platforms" type="text" value="<?php echo $platforms; ?>" placeholder="<?php echo $platforms; ?>" required />
				    </p>

				    <p class="scroll_section" id="testedplatforms_section">
				    	<label for="testedplatforms">Tested Platforms <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
				        <input name="testedplatforms" id="testedplatforms" type="text" value="<?php echo $testedplatforms; ?>" placeholder="<?php echo $testedplatforms; ?>" required />
				    </p>

				    <p class="scroll_section" id="genre_section">
				    	<label for="genre">Game Genre</label>
				        <input name="genre" id="genre" type="text" value="<?php echo $genre; ?>" placeholder="<?php echo $genre; ?>" required />
				    </p>

				    <p class="scroll_section" id="developers_section">
				    	<label for="developers">List of Developers <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
				        <input name="developers" id="developers" type="text" value="<?php echo $developers; ?>" placeholder="<?php echo $developers; ?>" required />
				        <span>If the same as publisher please enter in both fields.</span>
				    </p>

				    <p class="scroll_section" id="publishers_section">
				    	<label for="publishers">List of Publishers <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
				        <input name="publishers" id="publishers" type="text" value="<?php echo $publishers; ?>" placeholder="<?php echo $publishers; ?>" required />
				        <span>If the same as developer please enter in both fields.</span>
				    </p>

				    <p class="scroll_section" id="officialsite_section">
				    	<label for="officialsite">Official Site</label>
				        <input name="officialsite" id="officialsite" type="url" value="<?php echo $officialsite; ?>" placeholder="<?php echo $officialsite; ?>" required />
				        <span>If none exists please enter &lsquo;http://none.co&rsquo;</span>
				    </p>

				    <p class="scroll_section" id="developersites_section">
				    	<label for="developersites">List of Developers&rsquo; Sites <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
				        <input name="developersites" id="developersites" type="text" value="<?php echo $developersites; ?>" placeholder="<?php echo $developersites; ?>" required />
				        <span>If none exists please enter &lsquo;NA&rsquo;</span>
				    </p>

				    <p class="scroll_section" id="publishersites_section">
				    	<label for="publishersites">List of Publishers&rsquo; Sites <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
				        <input name="publishersites" id="publishersites" type="text" value="<?php echo $publishersites; ?>" placeholder="<?php echo $publishersites; ?>" required />
				        <span>If none exists please enter &lsquo;NA&rsquo;</span>
				    </p>


					<p class="scroll_section" id="storylinerating_section">
						<label for="storylinerating"><span id="firstContentRating">Storyline</span> Rating</label>
						<input class="ratingcheck" name="storylinecheck" id="ratingcheck1" type="checkbox"  style="display: none;" checked></input>
						<label id="ratinglabel1" for="ratingcheck1" class="ratingcheck_label" style="float: right; height: 30px; color: white; text-align: center;">&#10004;</label>
						<select name="storylinerating"  id="storylinerating">
							<option>2.5</option>
							<option>5.0</option>
							<option>7.5</option>
							<option>10</option>
						</select>
					</p>

					<p class="scroll_section" id="gameplayrating_section">
						<label for="gameplayrating"><span id="secondContentRating">Gameplay</span> Rating</label>
						<input class="ratingcheck" name="gameplaycheck" id="ratingcheck2" type="checkbox" style="display: none;" checked></input>
						<label id="ratinglabel2" for="ratingcheck2" class="ratingcheck_label" style="float: right; height: 30px; color: white; text-align: center;">&#10004;</label>
						<select name="gameplayrating" id="gameplayrating">
							<option>2.5</option>
							<option>5.0</option>
							<option>7.5</option>
							<option>10</option>
						</select>
					</p>

					<p class="scroll_section" id="graphicsrating_section">
						<label for="graphicsrating"><span id="thirdContentRating">Graphics</span> Rating</label>
						<input class="ratingcheck" name="graphicscheck" id="ratingcheck4" type="checkbox"  style="display: none;" checked></input>
						<label id="ratinglabel4" for="ratingcheck4" class="ratingcheck_label" style="float: right; height: 30px; color: white; text-align: center;">&#10004;</label>
						<select name="graphicsrating" id="graphicsrating">
							<option>2.5</option>
							<option>5.0</option>
							<option>7.5</option>
							<option>10</option>
						</select>
					</p>

					<p class="scroll_section" id="audiorating_section">
						<label for="audiorating"><span id="fourthContentRating">Audio</span> Rating</label>
						<input class="ratingcheck" name="audiocheck" id="ratingcheck3" type="checkbox"  style="display: none;" checked></input>
						<label id="ratinglabel3" for="ratingcheck3" class="ratingcheck_label" style="float: right; height: 30px; color: white; text-align: center;">&#10004;</label>
						<select name="audiorating" id="audiorating">
							<option>2.5</option>
							<option>5.0</option>
							<option>7.5</option>
							<option>10</option>
						</select>
					</p>
					<?php
						echo "Story" . $rating[1];
					?>
					<script>
						$('#storylinerating')[0].selectedIndex=<?php echo ($rating[0]/2.5)-1 ?>;
						$('#gameplayrating')[0].selectedIndex=<?php echo ($rating[1]/2.5)-1 ?>;
						$('#graphicsrating')[0].selectedIndex=<?php echo ($rating[2]/2.5)-1 ?>;
						$('#audiorating')[0].selectedIndex=<?php echo ($rating[3]/2.5)-1 ?>;
					</script>

				    <p class="scroll_section" id="mainrating_section">
				    	<label for="mainrating">Main Rating <i>(AUTO)</i></label>
				        <input name="mainrating" id="mainrating" type="text" value="<?php echo $main_rating; ?>" disabled />
				    </p>

				    <p class="scroll_section" id="tags_section">
				    	<label for="tags">Article Tags - Relavent Keywords </label>
				        <input name="tags" id="tags" type="text" value="<?php echo $tags; ?>" placeholder="<?php echo $tags; ?>" required />
				    </p>

				    <p>
				    	<label for="updatedate">Update Date <i>(NO/YES)</i></label>
				    	<input id="updatedate" name="updatedate" type="range" type="range" value="0" min="0" max="1" />
				    </p>

				    <p>
				        <button name="save" id="save" value="<?php echo $getArticle; ?>" type="submit">SAVE</button>
				    </p>

				    <?php
					    if(has_perms("articlelist-approve")) {
					    	echo '<p><button name="deny" id="deny" value="' . $getArticle . '" type="button">SEND BACK</button></p>';
					    }
				    ?>

				    <p>
				        <button name="delete" id="delete" value="<?php echo $getArticle; ?>" type="button">DELETE</button>
				    </p>

				    <p id="confirmation_section">
				        <button name="confirm" id="confirm" value="<?php echo $getArticle; ?>" type="button">CONFIRM REMOVAL</button>
				    </p>
				</form>

				<ul class="grid_6 grid_0" id="checklist">
					<?php if(has_perms("editarticle-checklist")) { ?>
					<h6>Checklist</h6>
					<li class="check_btn complete" id="articletype_button">TYPE</li>
					<li class="check_btn complete" id="articletitle_button">TITLE</li>
					<li class="check_btn complete" id="gamename_button">GAME NAME</li>
					<li class="check_btn complete" id="summary_button">SUMMARY</li>
					<li class="check_btn complete" id="overview_button">OVERVIEW</li>
					<li class="check_btn complete" id="storyline_button">STORYLINE</li>
					<li class="check_btn complete" id="gameplay_button">GAMEPLAY</li>
					<li class="check_btn complete" id="audio_button">AUDIO</li>
					<li class="check_btn complete" id="graphics_button">GRAPHICS</li>
					<li class="check_btn complete" id="verdict_button">VERDICT</li>
					<li class="check_btn complete" id="trailer_button">TRAILER</li>
					<li class="check_btn complete" id="releasedate_button">RELEASE DATE</li>
					<li class="check_btn complete" id="testedplatforms_button">TESTED PLATFORMS</li>
					<li class="check_btn complete" id="platforms_button">AVAILABLE PLATFORMS</li>
					<li class="check_btn complete" id="genre_button">GENRE</li>
					<li class="check_btn complete" id="developers_button">DEVELOPERS</li>
					<li class="check_btn complete" id="publishers_button">PUBLISHERS</li>
					<li class="check_btn complete" id="officialsite_button">OFFICIAL SITE</li>
					<li class="check_btn complete" id="developersites_button">DEVELOPER SITES</li>
					<li class="check_btn complete" id="publishersites_button">PUBLISHER SITES</li>
					<li class="check_btn complete" id="storylinerating_button">STORYLINE RATING</li>
					<li class="check_btn complete" id="gameplayrating_button">GAMEPLAY</li>
					<li class="check_btn complete" id="audiorating_button">AUDIO RATING</li>
					<li class="check_btn complete" id="graphicsrating_button">GRAPHICS RATING</li>
					<li class="check_btn complete" id="tags_button">TAGS</li>
					<?php } else {
						if(has_perms("articlelist-approve")) { ?>
							<h6>Notes &amp; Corrections</h6>
							<label for="beta_notes">Director's Notes</label>
							<textarea class="notes" name="beta_notes" id="beta_notes" <?php if(has_perms("articlelist-finalise")) { echo "disabled"; } ?>><?php echo $beta_notes; ?></textarea>
							<?php if(has_perms("articlelist-finalise")) { ?>
								<label for="alpha_notes">CEO's Notes</label>
								<textarea class="notes" name="alpha_notes" id="alpha_notes"><?php echo $alpha_notes; ?></textarea>
								<?php
							}
						}
					}
					?>
				</ul>

			</section>

		</article>

	</div>

	<?php include "footer.html"; ?>

	<script type="text/javascript">

		$("#tags").tagit({ fieldName: "tags", removeConfirmation: false, caseSensitive: true, allowDuplicates: false, allowSpaces: false, readOnly: false, tagLimit: null, singleField: false, singleFieldDelimiter: ', ', singleFieldNode: null, tabIndex: null, placeholderText: "Type tags in here...", beforeTagAdded: function(event, ui) { }, afterTagAdded: function(event, ui) { }, beforeTagRemoved: function(event, ui) { }, onTagExists: function(event, ui) { }, onTagClicked: function(event, ui) { }, onTagLimitExceeded: function(event, ui) { } });

		jQuery.validator.addMethod("hasletters", function(value, element) {
			if(value.match(/([a-zA-Z])/)) { return false; } else { return true; }
		}, "ERROR");

		$(function() {
            $("textarea:not(.notes):not(#summary)").jqte({
                formats: [
                    ["h3","Header 3"],
                    ["h4","Header 4"],
                    ["h5","Header 5"],
                    ["h6","Header 6"],
                    ["pre","Preformatted"]
                ]
            });

			$("#gamename").autocomplete({
			source: function (request, response) {
				$.get("get_games.php", {
					query: request.term
				}, function (data) {
					response(JSON.parse(data));
				});
			},
			minLength: 1
		});

			$("#confirmation_section").hide();

			if(window.File && window.FileReader && window.FileList && window.Blob) { } else {
				alert("NOTICE: Please upgrade your browser! Latest HTML5 features are needed for this page to function correctly.");
			}

			$(".check_btn").each(function() {
				var btnID = $(this).attr("id").replace("_button","");

				$(this).click(function() {
					$("html, body").animate({
						scrollTop : ($("#" + btnID + "_section").offset().top - 80)
					}, 1000);

					$(".scroll_section").removeClass('highlight');
					$("#" + btnID + "_section").addClass("highlight");
				});
			});

			$("input, textarea, select").on('change, ready, keyup', function(event) {
				var getBTN = $(this).attr("id") + "_button";

				if($(this).val() != "") {
					$(this).parent().removeClass('highlight');
					$("#" + getBTN).addClass("complete");
				} else {
					$(this).parent().addClass('highlight');
					$("#" + getBTN).removeClass("complete");
				}
			});

			$("#summary").on('keyup', function(event) {
				var maxChars = 100;
				var curChars = $(this).val().length;

				if(curChars == maxChars) {
					$("#charCount").text("You've reached the character limit.");
				} else if(curChars >= maxChars) {
					$("#charCount").text("You've exceeded the character limit by " + (curChars - maxChars) + " characters.");
				} else {
					$("#charCount").text((maxChars - curChars) + " Characters left.");
				}
			});

			$("#storylinerating, #gameplayrating, #audiorating, #graphicsrating").on('keyup, ready, change', function(event) {
				var s_rating = $("#storylinerating").val() == "" ? 0.0 : parseFloat($("#storylinerating").val());
				var p_rating = $("#gameplayrating").val() == "" ? 0.0 : parseFloat($("#gameplayrating").val());
				var a_rating = $("#audiorating").val() == "" ? 0.0 : parseFloat($("#audiorating").val());
				var g_rating = $("#graphicsrating").val() == "" ? 0.0 : parseFloat($("#graphicsrating").val());

				var add_ratings = s_rating + p_rating + a_rating + g_rating;
				var total_rating = parseFloat(add_ratings / 4);

				$("#mainrating").val(total_rating.toFixed(1));
			});

			var avaURL = "signup_availability.php";

			$("#delete").on('click', function(event) {
				$("#confirmation_section").show();
			});

			$("#confirm").on('click', function(event) {
				$.ajax({
			        url : "submitreview.php?deletionid=" + $(this).val(),
			        type : "GET",
			        dataType: "html",
			        async : false,
			        success: function(data) {
			            document.location = "articlelist.php?type=review";
			        }
			    });
			});

			$("#deny").on('click', function(event) {
				$.ajax({
			        url : "submitreview.php?deny=" + $(this).val(),
			        type : "GET",
			        dataType: "html",
			        async : false,
			        success: function(data) {
			            document.location = "articlelist.php?type=review";
			        }
			    });
			});

			$("#submitform").validate({
				rules: {
					gamename: {
						required: true
					},
					summary: {
						required: true,
						maxlength: 100
					},
					overview: {
						required: true
					},
					gameplay: {
						required: true
					},
					storyline: {
						required: true
					},
					audio: {
						required: true
					},
					graphics: {
						required: true
					},
					verdict: {
						required: true
					},
					trailer: {
						required: false,
						url: true
					},
					releasedate: {
						required: true,
						maxlength: 10,
						minlength: 10,
						hasletters: true
					},
					platforms: {
						required: true
					},
					genre: {
						required: true
					},
					developers: {
						required: true
					},
					publishers: {
						required: true
					},
					officialsite: {
						required: true,
						url: true
					},
					developersites: {
						required: true
					},
					publishersites: {
						required: true
					},
					storylinerating: {
						required: true
					},
					gameplayrating: {
						required: true
					},
					audiorating: {
						required: true
					},
					graphicsrating: {
						required: true
					},
					tags: {
						required: true
					}
				},
				messages: {
					gamename: {
						required: "Please enter the title of the game."
					},
					summary: {
						required: "Please provide a short summary for the article.",
						maxlength: "You summary cannot be more than 100 characters."
					},
					overview: {
						required: "Please provide the 'Overview' section of your review."
					},
					gameplay: {
						required: "Please provide the 'Gameplay' section of your review."
					},
					storyline: {
						required: "Please provide the 'Storyline' section of your review."
					},
					audio: {
						required: "Please provide the 'Audio' section of your review."
					},
					graphics: {
						required: "Please provide the 'Graphics' section of your review."
					},
					verdict: {
						required: "Please provide the 'Verdict' section of your review."
					},
					trailer: {
						required: "Please follow the instructions to provide a URL.",
						url: "That URL is invalid."
					},
					releasedate: {
						required: "Please provide the game&rsquo;s release date.",
						maxlength: "Please follow the given format.",
						minlength: "Please follow the given format.",
						hasletters: "No letters accepted for the release date."
					},
					platforms: {
						required: "Please provide all platforms that the game is available on."
					},
					genre: {
						required: "Please provide the genre of the game."
					},
					developers: {
						required: "Please provide all developer company names."
					},
					publishers: {
						required: "Please provide all company names of the publishers."
					},
					officialsite: {
						required: "Please enter the official site URL.",
						url: "That URL is invalid."
					},
					developersites: {
						required: "Please provide all developer companies website URL's."
					},
					publishersites: {
						required: "Please provide all publisher companies website URL's."
					},
					storylinerating: {
						required: "You must give a rating."
					},
					gameplayrating: {
						required: "You must give a rating."
					},
					audiorating: {
						required: "You must give a rating."
					},
					graphicsrating: {
						required: "You must give a rating."
					},
					storylinerating: {
						required: "You must provide a storyline quality rating."
					},
					gameplayrating: {
						required: "You must provide a gameplay quality rating."
					},
					audiorating: {
						required: "You must provide a audio quality rating."
					},
					graphicsrating: {
						required: "You must provide a graphics quality rating."
					},
					tags: {
						required: "You must provide tags (relavent keywords) for your article."
					}
				},
				submitHandler: function(form) {
					var addedVars = "&beta_notes=" + encodeURI($("#beta_notes").val()) + "&alpha_notes=" + encodeURI($("#alpha_notes").val());
					var gsrSUBMIT = $(form).serialize() + addedVars;
			        $.ajax({
			            url : "submitreview.php",
			            data : gsrSUBMIT,
			            type : "POST",
			            dataType: "html",
			            async : false,
			            success: function(data) {
			            	document.location = "articlelist.php?type=review";
			            }
			        });
				}
			});
		});
	</script>

</body>
</html>