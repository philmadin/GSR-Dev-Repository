<script>
function changeTo(event){
		switch(event){
			case "G":
				$('#gameSpecifics').css('display','');
				$('#movieSpecifics').css('display','none');
				$('#techSpecifics').css('display','none');
				$('#storyline_header label').text("Storyline");
				$('#firstContentRating').text("Storyline");
				$('#gameplay_header label').text("Gameplay");
				$('#secondContentRating').text("Gameplay");
				$('#graphics_header label').text("Graphics");
				$('#thirdContentRating').text("Graphics");
				$('#audio_header label').text("Audio");
				$('#fourthContentRating').text("Audio");
				$('#storylinerating option')[4].innerHTML="2.5 - Very basic storyline or ambiguous storyline.";
				$('#storylinerating option')[9].innerHTML="5.0 - Mediocre storyline or not original, lacks creativity.";
				$('#storylinerating option')[14].innerHTML="7.5 - Great storyline or better than average.";
				$('#storylinerating option')[19].innerHTML="10 - Incredible storyline, very creative or immersive.";
				$('#gameplayrating option')[4].innerHTML="2.5 - Hard to play or not intuitive at all.";
				$('#gameplayrating option')[9].innerHTML="5.0 - Mediocre gameplay or lacks creativity, average.";
				$('#gameplayrating option')[14].innerHTML="7.5 - Great gameplay or better than average.";
				$('#gameplayrating option')[19].innerHTML="10 - Incredible gameplay, very creative or immersive.";
				$('#graphicsrating option')[4].innerHTML="2.5 - Poor quality graphics or graphics are very basic.";
				$('#graphicsrating option')[9].innerHTML="5.0 - Standard graphics; nothing new; mediocre.";
				$('#graphicsrating option')[14].innerHTML="7.5 - Great graphics; fluid; better than average.";
				$('#graphicsrating option')[19].innerHTML="10 - Incredible graphics, very creative or high quality.";
				$('#audiorating option')[4].innerHTML="2.5 - Very basic sounds; not a huge variety; poor.";
				$('#audiorating option')[9].innerHTML="5.0 - Standard sound effects or not really immersive.";
				$('#audiorating option')[14].innerHTML="7.5 - Great audio effects; slightly immersive.";
				$('#audiorating option')[19].innerHTML="10 - Incredible sound effects, very immersive/creative.";
				break;
			case "T":
				$('#gameSpecifics').css('display','none');
				$('#movieSpecifics').css('display','none');
				$('#techSpecifics').css('display','');
				$('#storyline_header label').text("Intuitive");
				$('#firstContentRating').text("Intuitive");
				$('#gameplay_header label').text("Ergonomic");
				$('#secondContentRating').text("Ergonomic");
				$('#graphics_header label').text("Design");
				$('#thirdContentRating').text("Design");
				$('#audio_header label').text("Value");
				$('#fourthContentRating').text("Value");
				$('#storylinerating option')[4].innerHTML="2.5 - Was difficult to learn or not easy to learn.";
				$('#storylinerating option')[9].innerHTML="5.0 - Was neither easy or difficult to learn.";
				$('#storylinerating option')[14].innerHTML="7.5 - Was easy to learn and engaging.";
				$('#storylinerating option')[19].innerHTML="10 - Incredibly easy to learn, extremely natural.";
				$('#gameplayrating option')[4].innerHTML="2.5 - Not comfortable or feels uncomfortable.";
				$('#gameplayrating option')[9].innerHTML="5.0 - Doesn’t feel bad and doesn’t feel good.";
				$('#gameplayrating option')[14].innerHTML="7.5 - Feels great, not too shabby at all.";
				$('#gameplayrating option')[19].innerHTML="10 - Feels incredible! This can’t get any better!.";
				$('#graphicsrating option')[4].innerHTML="2.5 - Very poor design for the intended purpose of use.";
				$('#graphicsrating option')[9].innerHTML="5.0 - Mediocre design, designed for the intended purpose.";
				$('#graphicsrating option')[14].innerHTML="7.5 - Excellent design, above and beyond.";
				$('#graphicsrating option')[19].innerHTML="10 - Incredible design, sets the benchmark!.";
				$('#audiorating option')[4].innerHTML="2.5 - Not worth the money; poor value for money.";
				$('#audiorating option')[9].innerHTML="5.0 - Was a just cost, though I wouldn’t pay a cent more.";
				$('#audiorating option')[14].innerHTML="7.5 - Was definitely worth the investment.";
				$('#audiorating option')[19].innerHTML="10 - Great value for money, I’d buy this again!";
				break;
			case "M":			
				$('#gameSpecifics').css('display','none');
				$('#techSpecifics').css('display','none');
				$('#movieSpecifics').css('display','');
				$('#storyline_header label').text("Storyline");
				$('#firstContentRating').text("Storyline");
				$('#gameplay_header label').text("Cinematography");
				$('#secondContentRating').text("Cinematography");
				$('#graphics_header label').text("Script");
				$('#thirdContentRating').text("Script");
				$('#audio_header label').text("Direction");
				$('#fourthContentRating').text("Direction");
				$('#storylinerating option')[4].innerHTML="2.5 - The storyline was very cookie-cutter, not original.";
				$('#storylinerating option')[9].innerHTML="5.0 - Basic storyline, not boring, but not exciting either.";
				$('#storylinerating option')[14].innerHTML="7.5 - Great story! But I wouldn’t see it again anytime soon.";
				$('#storylinerating option')[19].innerHTML="10 - Wow! Can we watch that again?.";
				$('#gameplayrating option')[4].innerHTML="2.5 - Awkward angles; poor scenery; bad camera work.";
				$('#gameplayrating option')[9].innerHTML="5.0 - Average camera work, not bad.";
				$('#gameplayrating option')[14].innerHTML="7.5 - Great placement, good locations and shots.";
				$('#gameplayrating option')[19].innerHTML="10 - Incredible camera work, couldn’t have been better!";
				$('#graphicsrating option')[4].innerHTML="2.5 - Poor script; predictable, not entertaining.";
				$('#graphicsrating option')[9].innerHTML="5.0 - Average story and characters, predictable.";
				$('#graphicsrating option')[14].innerHTML="7.5 - Fresh concept, gripping and entertaining.";
				$('#graphicsrating option')[19].innerHTML="10 - Incredible script, unique, perfect story and characters.";
				$('#audiorating option')[4].innerHTML="2.5 - Poor cast; no chemistry; rushed film; uncreative.";
				$('#audiorating option')[9].innerHTML="5.0 - Standard chemistry; cast weren’t special; average.";
				$('#audiorating option')[14].innerHTML="7.5 - Great cast; good direction; very creative; good pace.";
				$('#audiorating option')[19].innerHTML="10 - Incredible cast, great pace; great chemistry; terrific!";
				break;
		}
	}
	$(document).ready(function(){
		changeTo('G');		
	})

</script>

<form class="grid_18 grid_0 submitform" id="submitreview" method="get" action="" enctype="multipart/form-data">
	<h6>Article Submission</h6>
	<div class='article_form_group'>
	<table>	
	<?php if(has_perms("articlelist-finalise")){?>
	<tr>
		<td>
			<label for="articlesubmitas">Submit As</label>
		</td>
		<td>
			<select id="articlesubmitas" name="articlesubmitas">
				<?php
				$sasQRY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE rank!=0 ORDER BY id");

				while($submitasQRY = mysqli_fetch_assoc($sasQRY)) {
					$submitas_id			= $submitasQRY['id'];
					$submitas_username 		= $submitasQRY['username'];
					$submitas_firstname		= $submitasQRY['firstname'];
					$submitas_lastname		= $submitasQRY['lastname'];
					$submitas_fullname		= $submitas_firstname . " " . $submitas_lastname;


					if($submitas_id==$check_id){
						echo '<option value="'.$submitas_username.'" selected>'.$submitas_fullname.'</option>';
					}
					else{
						echo '<option value="'.$submitas_username.'">'.$submitas_fullname.'</option>';
					}

				}
				?>
			</select>
		</td>
	</tr>
	<?php } ?>
	<tr>
		<td>
			<label for="articletype">Article Type</label>
		</td>
		<td>
			<select id="articletype" name="articletype">
				<?php	echo $new_article_types;	?>
			</select>
		</td>
	</tr>
	<tr>		
		<td>
			<label for="classification">Subject Classification</label>
		</td>
		<td>
			<select id="classification" name="classification" onchange="changeTo(this.value);">
				<option value="G">Game review</option>
				<option value="M">Movie/Show review</option>
				<option value="T">Tech review</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			<label for="gamename">Subject Title</label>
		</td>
		<td>
			<?php include 'gamename_input.php'; ?>
		</td>
	</tr>
	<tr>
		<td>
			<label for="articletitle">Title</label>
		</td>
		<td>
			<input name="articletitle" id="articletitle" type="text" value="" placeholder="Enter your article's title here..." required="" aria-required="true">
		</td>
	</tr>
	</table>

	<p class="scroll_section" id="trailer_section">
		<label for="trailer">Official Trailer - YOUTUBE URL <i>(prefered if more than one)</i></label>
		<input name="trailer" class="form_box_right" id="trailer" type="url" value="" placeholder="" />
				        <span>
				        	<b>1. &nbsp; </b> Find your trailer video on YouTube<br>
				        	<b>2. &nbsp; </b> Click on &lsquo;Share&rsquo; found under the video<br>
				        	<b>3. &nbsp; </b> Click on the &lsquo;Embed&rsquo; tab<br>
				        	<b>4. &nbsp; </b> Copy the URL found in the &lsquo;src=&rsquo; attribute of the given code<br>
				        	<b>5. &nbsp; </b> Paste the URL here.
				        </span>
	</p>

	<p class="scroll_section" id="officialsite_section">
		<label for="officialsite">Official Site</label>
		<input name="officialsite" class="form_box_right" id="officialsite" type="url" value="" placeholder="Type the official site here..." required />
		<span>If none exists please enter &lsquo;http://none.co&rsquo;</span>
	</p>
	<p class="scroll_section" id="releasedate_section">
		<label for="releasedate">Initial Release Date <i>(FORMAT: YYYY-MM-DD)</i></label>
		<input name="releasedate" class="form_box_right" id="releasedate" type="text" value="" placeholder="2000-01-01" maxlength="10" minlength="10" required />
	</p>


	<div id="techSpecifics">
		<h2>Tech specific details</h2>
		<p class="scroll_section" id="category_section">
			<label for="category">Category</label>
			<input name="category" class="form_box_right" id="category" type="text" value="" placeholder="Type the subject's category here..." required />
		</p>
		<p class="scroll_section" id="rrp_section">
			<label for="rrp">Recomended Retail Price (RRP) at time of review</label>
			<input name="rrp" class="form_box_right" id="rrp" type="text" value="" placeholder="Type the subject's rrp here..." required />
		</p>
		<p class="scroll_section" id="manufacturers_section">
			<label for="manufacturers">List of Manufacturers <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
			<input name="manufacturers" class="form_box_right" id="manufacturers" type="text" value="" placeholder="Type the list of manufacturers here..." required />
		</p>

		<p class="scroll_section" id="manufacturerssites_section">
			<label for="manufacturerssites">List of Manufacturers sites <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
			<input name="manufacturerssites" class="form_box_right" id="manufacturerssites" type="text" value="" placeholder="Type the list of manufacturers sites here..." required />
		</p>
	</div>
	<div id="movieSpecifics">
		<h2>Movie / show specific details</h2>
		<p class="scroll_section" id="genre_section">
			<label for="moviegenre">Genre</label>
			<input name="moviegenre" class="form_box_right" id="moviegenre" type="text" value="" placeholder="Type the movie genre here..." required />
		</p>

		<p class="scroll_section" id="duration_section">
			<label for="duration">Duration <i>(minutes)</i></label>
			<input name="duration" class="form_box_right" id="duration" type="text" value="" placeholder="Type the movie duration here..." required />
		</p>
		
		<p class="scroll_section" id="directors_section">
			<label for="directors">List of Directors <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
			<input name="directors" class="form_box_right" id="directors" type="text" value="" placeholder="Type the list of directors here..." required />
		</p>

		<p class="scroll_section" id="cast_section">
			<label for="cast">List of main cast <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
			<input name="cast" class="form_box_right" id="cast" type="text" value="" placeholder="Type the list of cast here..." required />
		</p>


		<p class="scroll_section" id="moviepublishers_section">
			<label for="moviepublishers">List of Studios / Publishers <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
			<input name="moviepublishers" class="form_box_right" id="moviepublishers" type="text" value="" placeholder="Type the list of studios / publishers here..." required />
		</p>

		<p class="scroll_section" id="moviepublisherssites_section">
			<label for="moviepublisherssites">List of Studios / Publishers sites <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
			<input name="moviepublisherssites" class="form_box_right" id="moviepublisherssites" type="text" value="" placeholder="Type the list of studios / publishers sites here..." required />
		</p>
	</div>
	<div id="gameSpecifics">
		<h2>Game specific details</h2>
		<p class="scroll_section" id="genre_section">
			<label for="genre">Genre</label>
			<input name="genre" class="form_box_right" id="genre" type="text" value="" placeholder="Type the game genre here..." required />
		</p>

		<p class="scroll_section" id="platforms_section">
			<label for="platforms">Available Platforms <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
			<input name="platforms" class="form_box_right" id="platforms" type="text" value="" placeholder="Type the available platforms here..." required />
		</p>

		<p class="scroll_section" id="testedplatforms_section">
			<label for="testedplatforms">Tested Platforms <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
			<input name="testedplatforms" class="form_box_right" id="testedplatforms" type="text" value="" placeholder="Type the platforms tested here..." required />
		</p>


		<p class="scroll_section" id="developers_section">
			<label for="developers">List of Developers <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
			<input name="developers" class="form_box_right" id="developers" type="text" value="" placeholder="Type the list of developers here..." required />
			<span>If the same as publisher please enter in both fields.</span>
		</p>

		<p class="scroll_section" id="developersites_section">
			<label for="developersites">List of Developers&rsquo; Sites <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
			<input name="developersites" class="form_box_right" id="developersites" type="text" value="" placeholder="Type the list of developers' sites here..." required />
			<span>If none exists please enter &lsquo;NA&rsquo;</span>
		</p>


		<p class="scroll_section" id="publishers_section">
			<label for="publishers">List of Publishers <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
			<input name="publishers" class="form_box_right" id="publishers" type="text" value="" placeholder="Type the list of publishers here..." required />
			<span>If the same as developer please enter in both fields.</span>
		</p>

		<p class="scroll_section" id="publishersites_section">
			<label for="publishersites">List of Publishers&rsquo; Sites <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
			<input name="publishersites" class="form_box_right" id="publishersites" type="text" value="" placeholder="Type the list of developers' sites here..." required />
			<span>If none exists please enter &lsquo;NA&rsquo;</span>
		</p>
	</div>
	</div>
	<div class='article_form_group'>

		<h2>Review content</h2>
		<div class='reviewSectionHeader' id="summary_header" onclick='expandReviewSection(this.id)'>
		<label for="summary">Caption <i>(MAX 100 CHARACTERS)</i></label>
		<div class='toggle_section_header' id="summary_toggle">+</div>
		</div>
	<p class="scroll_section toggle_text" id="summary_section">
		<textarea name="summary" id="summary" placeholder="Caption..." required maxlength="100"></textarea>
		<span id="charCount">100 Characters left.</span>
	</p>

		<div class='reviewSectionHeader' id="overview_header" onclick='expandReviewSection(this.id)'>
		<label for="overview">Overview</label>
		<div class='toggle_section_header' id="overview_toggle">+</div>
		</div>
	<p class="scroll_section toggle_text" id="overview_section">
		<textarea name="overview" id="overview" placeholder="Overview..." required></textarea>
	</p>

		<div class='reviewSectionHeader' id="storyline_header" onclick='expandReviewSection(this.id)'>
		<label for="storyline">Storyline</label>
		<div class='toggle_section_header' id="storyline_toggle">+</div>
		</div>
	<p class="scroll_section toggle_text" id="storyline_section">
		<textarea name="storyline" id="storyline" placeholder="Storyline..." required></textarea>
	</p>

	<p class="scroll_section" id="storylinerating_section">
		<label for="storylinerating"><span id="firstContentRating">Storyline</span> Rating</label>
		<input class="ratingcheck" name="storylinecheck" id="ratingcheck1" type="checkbox"  style="display: none;" checked></input>
		<label id="ratinglabel1" for="ratingcheck1" class="ratingcheck_label" style="float: right; height: 30px; color: white; text-align: center;">&#10004;</label>
		<select name="storylinerating"  id="storylinerating">
				<option>0.5</option>
				<option>1.0</option>
				<option>1.5</option>
				<option>2.0</option>
				<option>2.5</option>
				<option>3.0</option>
				<option>3.5</option>
				<option>4.0</option>
				<option>4.5</option>
				<option>5.0</option>
				<option>5.5</option>
				<option>6.0</option>
				<option>6.5</option>
				<option>7.0</option>
				<option>7.5</option>
				<option>8.0</option>
				<option>8.5</option>
				<option>9.0</option>
				<option>9.5</option>
				<option>10</option>
		</select>
	</p>
		<div class='reviewSectionHeader' id="gameplay_header" onclick='expandReviewSection(this.id)'>
		<label for="gameplay">Gameplay</label>
		<div class='toggle_section_header' id="gameplay_toggle">+</div>
		</div>
	<p class="scroll_section toggle_text" id="gameplay_section">
		<textarea name="gameplay" id="gameplay" placeholder="Gameplay..." required></textarea>
	</p>

	<p class="scroll_section" id="gameplayrating_section">
		<label for="gameplayrating"><span id="secondContentRating">Gameplay</span> Rating</label>
		<input class="ratingcheck" name="gameplaycheck" id="ratingcheck2" type="checkbox" style="display: none;" checked></input>
		<label id="ratinglabel2" for="ratingcheck2" class="ratingcheck_label" style="float: right; height: 30px; color: white; text-align: center;">&#10004;</label>
		<select name="gameplayrating" id="gameplayrating">
			<option>0.5</option>
			<option>1.0</option>
			<option>1.5</option>
			<option>2.0</option>
			<option>2.5</option>
			<option>3.0</option>
			<option>3.5</option>
			<option>4.0</option>
			<option>4.5</option>
			<option>5.0</option>
			<option>5.5</option>
			<option>6.0</option>
			<option>6.5</option>
			<option>7.0</option>
			<option>7.5</option>
			<option>8.0</option>
			<option>8.5</option>
			<option>9.0</option>
			<option>9.5</option>
			<option>10</option>
		</select>
	</p>

		<div class='reviewSectionHeader' id="graphics_header" onclick='expandReviewSection(this.id)'>
		<label for="graphics">Graphics</label>
		<div class='toggle_section_header' id="graphics_toggle">+</div>
		</div>
	<p class="scroll_section toggle_text" id="graphics_section">
		<textarea name="graphics" id="graphics" placeholder="Graphics..." required></textarea>
	</p>

	<p class="scroll_section" id="graphicsrating_section">
		<label for="graphicsrating"><span id="thirdContentRating">Graphics</span> Rating</label>
		<input class="ratingcheck" name="graphicscheck" id="ratingcheck4" type="checkbox"  style="display: none;" checked></input>
		<label id="ratinglabel4" for="ratingcheck4" class="ratingcheck_label" style="float: right; height: 30px; color: white; text-align: center;">&#10004;</label>
		<select name="graphicsrating" id="graphicsrating">
			<option>0.5</option>
			<option>1.0</option>
			<option>1.5</option>
			<option>2.0</option>
			<option>2.5</option>
			<option>3.0</option>
			<option>3.5</option>
			<option>4.0</option>
			<option>4.5</option>
			<option>5.0</option>
			<option>5.5</option>
			<option>6.0</option>
			<option>6.5</option>
			<option>7.0</option>
			<option>7.5</option>
			<option>8.0</option>
			<option>8.5</option>
			<option>9.0</option>
			<option>9.5</option>
			<option>10</option>
		</select>
	</p>
		<div class='reviewSectionHeader' id="audio_header" onclick='expandReviewSection(this.id)'>
		<label for="audio">Audio</label>
		<div class='toggle_section_header' id="audio_toggle">+</div>
		</div>
	<p class="scroll_section toggle_text" id="audio_section">
		<textarea name="audio" id="audio" placeholder="Audio..." required></textarea>
	</p>

	<p class="scroll_section" id="audiorating_section">
		<label for="audiorating"><span id="fourthContentRating">Audio</span> Rating</label>
		<input class="ratingcheck" name="audiocheck" id="ratingcheck3" type="checkbox"  style="display: none;" checked></input>
		<label id="ratinglabel3" for="ratingcheck3" class="ratingcheck_label" style="float: right; height: 30px; color: white; text-align: center;">&#10004;</label>
		<select name="audiorating" id="audiorating">
			<option>0.5</option>
			<option>1.0</option>
			<option>1.5</option>
			<option>2.0</option>
			<option>2.5</option>
			<option>3.0</option>
			<option>3.5</option>
			<option>4.0</option>
			<option>4.5</option>
			<option>5.0</option>
			<option>5.5</option>
			<option>6.0</option>
			<option>6.5</option>
			<option>7.0</option>
			<option>7.5</option>
			<option>8.0</option>
			<option>8.5</option>
			<option>9.0</option>
			<option>9.5</option>
			<option>10</option>
		</select>
	</p>

		<div class='reviewSectionHeader' id="verdict_header" onclick='expandReviewSection(this.id)'>
		<label for="verdict">Verdict</label>
		<div class='toggle_section_header' id="verdict_toggle">+</div>
		</div>
	<p class="scroll_section toggle_text" id="verdict_section">
		<textarea name="verdict" id="verdict" placeholder="Verdict..." required></textarea>
	</p>
	</div>
	<div class='article_form_group'>




	<p class="scroll_section" id="mainrating_section">
		<label for="mainrating">Main Rating <i>(AUTO)</i></label>
<label style="    float: right;
    width: 30px;
    height: 30px;
    background: none;
    border: none;
    color: white;
    text-align: center;">&nbsp;</label>
		<input name="mainrating" class="form_box_right" id="mainrating" type="text" value="0.0"disabled />

	</p>

	<p class="scroll_section" id="tags_section">
		<label for="tags">Article Tags - Relevant Keywords</label>
		<input name="tags" id="tags" type="text" style="width: 100%" value="" placeholder="Type tags in here..." required />
	</p>
	</div>
	<p id="submit_section">
		<button name="submit" id="submit" type="submit" value="<?php echo $user; ?>">SUBMIT FORM</button>
	</p>
</form>

<ul class="grid_6 grid_0" id="checklist">
	<h6>Checklist</h6>
	<li class="check_btn complete" id="articletype_button">TYPE</li>
	<li class="check_btn" id="articletitle_button">TITLE</li>
	<li class="check_btn" id="gamename_button">GAME NAME</li>
	<li class="check_btn" id="summary_button">SUMMARY</li>
	<li class="check_btn" id="overview_button">OVERVIEW</li>
	<li class="check_btn" id="storyline_button">STORYLINE</li>
	<li class="check_btn" id="gameplay_button">GAMEPLAY</li>
	<li class="check_btn" id="audio_button">AUDIO</li>
	<li class="check_btn" id="graphics_button">GRAPHICS</li>
	<li class="check_btn" id="verdict_button">VERDICT</li>
	<li class="check_btn" id="trailer_button">TRAILER</li>
	<li class="check_btn" id="releasedate_button">RELEASE DATE</li>
	<li class="check_btn" id="testedplatforms_button">TESTED PLATFORMS</li>
	<li class="check_btn" id="platforms_button">AVAILABLE PLATFORMS</li>
	<li class="check_btn" id="genre_button">GENRE</li>
	<li class="check_btn" id="developers_button">DEVELOPERS</li>
	<li class="check_btn" id="publishers_button">PUBLISHERS</li>
	<li class="check_btn" id="officialsite_button">OFFICIAL SITE</li>
	<li class="check_btn" id="developersites_button">DEVELOPER SITES</li>
	<li class="check_btn" id="publishersites_button">PUBLISHER SITES</li>
	<li class="check_btn" id="storylinerating_button">STORYLINE RATING</li>
	<li class="check_btn" id="gameplayrating_button">GAMEPLAY</li>
	<li class="check_btn" id="audiorating_button">AUDIO RATING</li>
	<li class="check_btn" id="graphicsrating_button">GRAPHICS RATING</li>
	<li class="check_btn" id="tags_button">TAGS</li>
</ul>