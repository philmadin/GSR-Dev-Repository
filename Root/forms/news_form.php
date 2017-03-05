<form class="grid_18 grid_0 submitform" id="submitnews" method="get" action="" enctype="multipart/form-data">
	<h6>Article Submission</h6>

	<?php if(has_perms("articlelist-finalise")){?>
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
	<?php } ?>

	<p class="scroll_section" id="type_section">
		<label for="articletype">Article Type</label>
		<select id="articletype" name="articletype">
			<?php	echo $new_article_types;	?>
		</select>
	</p>

	<p class="scroll_section" id="articlenewstitle_section">
		<label for="articlenewstitle">Title</label>
		<input name="articlenewstitle" class="form_box_right" style="margin-right: 241px;width: 345px;" type="text" value="" id="articlenewstitle" type="text" value="" placeholder="Enter your article's title here..." required />
	</p>

	<p class="scroll_section" id="main_section">
		<label for="main">Main - <i>(for subheadings use <?php echo htmlentities('<h3>subheading</h3>'); ?></i>)</label>
		<textarea name="main" id="main" placeholder="Main..." required></textarea>
	</p>
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
        </div>
	<p class="scroll_section" id="tags_section">
		<label for="tags">Article Tags - Relavent Keywords</label>
		<input name="tags" id="tags" type="text" value="" placeholder="Type tags in here..." required />
	</p>

	<p id="submit_section">
		<button name="submit" id="submit" type="submit" value="<?php echo $user; ?>">SUBMIT FORM</button>
	</p>
</form>

<ul class="grid_6 grid_0" id="checklist">
	<h6>Checklist</h6>
	<li class="check_btn complete" id="articletype_button">TYPE</li>
	<li class="check_btn" id="articlenewstitle_button">TITLE</li>
	<li class="check_btn" id="main_button">MAIN</li>
	<li class="check_btn" id="trailer_button">TRAILER</li>
	<li class="check_btn" id="tags_button">TAGS</li>
</ul>