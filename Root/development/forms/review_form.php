<form class="grid_18 grid_0 submitform" id="submitreview" method="get" action="" enctype="multipart/form-data">
	<h6>Article Submission</h6>
	<div class='article_form_group'>
	<?php //if(has_perms("articlelist-finalise")){?>
		<p class="scroll_section" id="submitas_section">
			<label for="articlesubmitas">Submit As</label>
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
		</p>
	<?php //} ?>

	<p class="scroll_section" id="type_section">
		<label for="articletype">Article Type</label>
		<select id="articletype" name="articletype">
			<?php	echo $new_article_types;	?>
		</select>
	</p>

	<p class="scroll_section" id="gamename_section">
		<label for="gamename">Game Title</label>
		<?php include 'gamename_input.php'; ?>
	</p>

	<p class="scroll_section" id="articletitle_section">
		<label for="articletitle">Title</label>
		<input name="articletitle" id="articletitle" style="margin-right: 241px;width: 345px;" type="text" value="" placeholder="Enter your article's title here..." required="" aria-required="true" class="form_box_right">
	</p>
	</div>
	<div class='article_form_group'>
		<div class='reviewSectionHeader' id="summary_header" onclick='expandReviewSection(this.id)'>
		<label for="summary">Summary <i>(MAX 100 CHARACTERS)</i></label>
		<div class='toggle_section_header' id="summary_toggle">+</div>
		</div>
	<p class="scroll_section toggle_text" id="summary_section">
		<textarea name="summary" id="summary" placeholder="Summary..." required maxlength="100"></textarea>
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

		<div class='reviewSectionHeader' id="gameplay_header" onclick='expandReviewSection(this.id)'>
		<label for="gameplay">Gameplay</label>
		<div class='toggle_section_header' id="gameplay_toggle">+</div>
		</div>
	<p class="scroll_section toggle_text" id="gameplay_section">
		<textarea name="gameplay" id="gameplay" placeholder="Gameplay..." required></textarea>
	</p>

		<div class='reviewSectionHeader' id="audio_header" onclick='expandReviewSection(this.id)'>
		<label for="audio">Audio</label>
		<div class='toggle_section_header' id="audio_toggle">+</div>
		</div>
	<p class="scroll_section toggle_text" id="audio_section">
		<textarea name="audio" id="audio" placeholder="Audio..." required></textarea>
	</p>

		<div class='reviewSectionHeader' id="graphics_header" onclick='expandReviewSection(this.id)'>
		<label for="graphics">Graphics</label>
		<div class='toggle_section_header' id="graphics_toggle">+</div>
		</div>
	<p class="scroll_section toggle_text" id="graphics_section">
		<textarea name="graphics" id="graphics" placeholder="Graphics..." required></textarea>
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

	<p class="scroll_section" id="releasedate_section">
		<label for="releasedate">Game Release Date <i>(FORMAT: YYYY-MM-DD)</i></label>
		<input name="releasedate" class="form_box_right" id="releasedate" type="text" value="" placeholder="2000-01-01" maxlength="10" minlength="10" required />
	</p>

	<p class="scroll_section" id="platforms_section">
		<label for="platforms">Available Platforms <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
		<input name="platforms" class="form_box_right" id="platforms" type="text" value="" placeholder="Type the available platforms here..." required />
	</p>

	<p class="scroll_section" id="testedplatforms_section">
		<label for="testedplatforms">Tested Platforms <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
		<input name="testedplatforms" class="form_box_right" id="testedplatforms" type="text" value="" placeholder="Type the platforms tested here..." required />
	</p>

	<p class="scroll_section" id="genre_section">
		<label for="genre">Game Genre</label>
		<input name="genre" class="form_box_right" id="genre" type="text" value="" placeholder="Type the game genre here..." required />
	</p>

	<p class="scroll_section" id="developers_section">
		<label for="developers">List of Developers <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
		<input name="developers" class="form_box_right" id="developers" type="text" value="" placeholder="Type the list of developers here..." required />
		<span>If the same as publisher please enter in both fields.</span>
	</p>

	<p class="scroll_section" id="publishers_section">
		<label for="publishers">List of Publishers <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
		<input name="publishers" class="form_box_right" id="publishers" type="text" value="" placeholder="Type the list of publishers here..." required />
		<span>If the same as developer please enter in both fields.</span>
	</p>

	<p class="scroll_section" id="officialsite_section">
		<label for="officialsite">Official Site</label>
		<input name="officialsite" class="form_box_right" id="officialsite" type="url" value="" placeholder="Type the game's official site here..." required />
		<span>If none exists please enter &lsquo;http://none.co&rsquo;</span>
	</p>

	<p class="scroll_section" id="developersites_section">
		<label for="developersites">List of Developers&rsquo; Sites <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
		<input name="developersites" class="form_box_right" id="developersites" type="text" value="" placeholder="Type the list of developers' sites here..." required />
		<span>If none exists please enter &lsquo;NA&rsquo;</span>
	</p>

	<p class="scroll_section" id="publishersites_section">
		<label for="publishersites">List of Publishers&rsquo; Sites <i>(separated by comma - &lsquo;,&rsquo;)</i></label>
		<input name="publishersites" class="form_box_right" id="publishersites" type="text" value="" placeholder="Type the list of developers' sites here..." required />
		<span>If none exists please enter &lsquo;NA&rsquo;</span>
	</p>
	</div>
	<div class='article_form_group'>
	<p class="scroll_section" id="storylinerating_section">
		<label for="storylinerating">Storyline Rating <i>(one decimal point)</i></label>
		<input class="ratingcheck" name="storylinecheck" id="ratingcheck1" type="checkbox" checked></input>
		<label id="ratinglabel1" for="ratingcheck1" class="ratingcheck_label" style="float: right; height: 30px; color: white; text-align: center;">&#10004;</label>
		<input name="storylinerating" class="form_box_right" id="storylinerating" type="text" value="" placeholder="0.0" required maxlength="4" minlength="3" />
	</p>

	<p class="scroll_section" id="gameplayrating_section">
		<label for="gameplayrating">Gameplay Rating <i>(one decimal point)</i></label>
		<input class="ratingcheck" name="gameplaycheck" id="ratingcheck2" type="checkbox" checked></input>
		<label id="ratinglabel2" for="ratingcheck2" class="ratingcheck_label" style="float: right; height: 30px; color: white; text-align: center;">&#10004;</label>
		<input name="gameplayrating" class="form_box_right" id="gameplayrating" type="text" value="" placeholder="0.0" required maxlength="4" minlength="3" />
	</p>

	<p class="scroll_section" id="audiorating_section">
		<label for="audiorating">Audio Rating <i>(one decimal point)</i></label>
		<input class="ratingcheck" name="audiocheck" id="ratingcheck3" type="checkbox" checked></input>
		<label id="ratinglabel3" for="ratingcheck3" class="ratingcheck_label" style="float: right; height: 30px; color: white; text-align: center;">&#10004;</label>
		<input name="audiorating" class="form_box_right" id="audiorating" type="text" value="" placeholder="0.0" required maxlength="4" minlength="3" />
	</p>

	<p class="scroll_section" id="graphicsrating_section">
		<label for="graphicsrating">Graphics Rating <i>(one decimal point)</i></label>
		<input class="ratingcheck" name="graphicscheck" id="ratingcheck4" type="checkbox" checked></input>
		<label id="ratinglabel4" for="ratingcheck4" class="ratingcheck_label" style="float: right; height: 30px; color: white; text-align: center;">&#10004;</label>
		<input name="graphicsrating" class="form_box_right" id="graphicsrating" type="text" value="" placeholder="0.0" required maxlength="4" minlength="3" />
	</p>

	<p class="scroll_section" id="mainrating_section">
		<label for="mainrating">Main Rating <i>(AUTO)</i></label>
		<input name="mainrating" class="form_box_right" id="mainrating" type="text" value="0.0" disabled />
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