<?php
include "mysql_con.php";

$user = $_SESSION['username'];

if(!isset($user)) { header("location:index.php"); }

$accountQRY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$user'");
$userQRY = mysqli_query($con, "SELECT * FROM tbl_users WHERE username = '$user'");

while($SAQRY = mysqli_fetch_assoc($accountQRY)) {
	$set_firstname		= $SAQRY['firstname'];
	$set_lastname		= $SAQRY['lastname'];
	$set_showname 		= $SAQRY['showname'];
	$set_xbox 			= $SAQRY['xbox'];
	$set_playstation	= $SAQRY['playstation'];
	$set_steam 			= $SAQRY['steam'];
	$set_console		= $SAQRY['console'];
	$set_game		 	= $SAQRY['game'];
	$set_quote 			= $SAQRY['quote'];
	$set_bio 			= $SAQRY['biography'];
	$set_town 			= $SAQRY['town'];
	$set_country 		= $SAQRY['country'];
	$set_website 		= $SAQRY['website'];
	$set_facebook 		= $SAQRY['facebook'];
	$set_twitter 		= $SAQRY['twitter'];
	$set_googleplus 	= $SAQRY['googleplus'];
	$set_picture 		= $SAQRY['picture'];
	$set_cover_pic = $SAQRY['cover_pic'];
}

if($set_picture == NULL || $set_picture == "" || empty($set_picture)) {
	$ur_image = "default";
} else {
	$ur_image = $set_picture;
}

if($set_cover_pic == NULL || $set_cover_pic == "" || empty($set_cover_pic)) {
	$ur_cover = "default_cover";
} else {
	$ur_cover = $set_cover_pic;
}

while($SUQRY = mysqli_fetch_assoc($userQRY)) {
	$set_email = $SUQRY['email'];
	$set_pswrd = $SUQRY['password'];
	$set_question = $SUQRY['sec_question'];
	$set_answer = $SUQRY['sec_answer'];
}
?>

<!doctype html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, follow, noarchive">

	<title><?php echo $user; ?>'s Account Settings | Settings | GSR</title>

	<meta name="description" content="Change your GSR account details and settings here.">

	<?php include "links.php"; ?>

</head>

<body>

	<?php include "header.php"; ?>

	<div id="page" class="container_24">

		<article>

			<section id="settings">

				<ul class="grid_8 grid_0" id="settingslist">
					<h6>Settings</h6>
					<li class="opt_tab" id="profpic_button">PROFILE PICTURE<i>&#10094;</i></li>
					<li class="opt_tab" id="coverpic_button">COVER PICTURE<i>&#10094;</i></li>
					<li class="opt_tab active" id="gsrinfo_button">GAME SHARKER INFORMATION <i>&#10094;</i></li>
					<li class="opt_tab" id="accinfo_button">PERSONAL INFORMATION <i>&#10094;</i></li>
				</ul>

				<form class="grid_16 grid_0 settingsdisplay active" id="gsrinfo" method="get" action="" autocomplete="off">
					<ul>
						<li>
							<h6>Gamertags</h6>
							<p><input id="xbox" name="xbox" type="text" placeholder="Xbox gamertag..." value="<?php if($set_xbox != 'undefined') { echo $set_xbox; } ?>" /></p>
							<p><input id="playstation" name="playstation" type="text" placeholder="PlayStation gamertag..." value="<?php if($set_playstation != 'undefined') { echo $set_playstation; } ?>" /></p>
							<p><input id="steam" name="steam" type="text" placeholder="Steam gamertag..." value="<?php if($set_steam != 'undefined') { echo $set_steam; } ?>" /></p>
						</li>
						<li>
							<h6>Game &amp; Console</h6>
							<p>
								<label for="console">Favourite Console</label>
								<select id="console" name="console">
									<option disabled>--SELECT A CONSOLE--</option>
									<option <?php if($set_console == "undefined") { echo "selected"; } ?> value="undefined">None</option>
									<option <?php if($set_console == "PC") { echo "selected"; } ?> value="PC">PC</option>
									<option <?php if($set_console == "Steam") { echo "selected"; } ?> value="Steam">Steam</option>
									<option <?php if($set_console == "Xbox One") { echo "selected"; } ?> value="Xbox One">Xbox One (2013)</option>
									<option <?php if($set_console == "PlayStation 4") { echo "selected"; } ?> value="PlayStation 4">PlayStation 4 (2013)</option>
									<option <?php if($set_console == "Neo Geo X") { echo "selected"; } ?> value="Neo Geo X">Neo Geo X (2012)</option>
									<option <?php if($set_console == "Wii U") { echo "selected"; } ?> value="Wii U">Wii U (2012)</option>
									<option <?php if($set_console == "PlayStation Vita") { echo "selected"; } ?> value="PlayStation Vita">PlayStation Vita (2011)</option>
									<option <?php if($set_console == "Nintendo 3DS") { echo "selected"; } ?> value="Nintendo 3DS">Nintendo 3DS (2011)</option>
									<option <?php if($set_console == "CAANOO") { echo "selected"; } ?> value="CAANOO">CAANOO (2010)</option>
									<option <?php if($set_console == "Pandora") { echo "selected"; } ?> value="Pandora">Pandora (2010)</option>
									<option <?php if($set_console == "GP2X Wiz") { echo "selected"; } ?> value="GP2X Wiz">GP2X Wiz (2009)</option>
									<option <?php if($set_console == "Dingoo A320") { echo "selected"; } ?> value="Dingoo A320">Dingoo A320 (2009)</option>
									<option <?php if($set_console == "Leapfrog Didj") { echo "selected"; } ?> value="Leapfrog Didj">Leapfrog Didj (2008)</option>
									<option <?php if($set_console == "Wii") { echo "selected"; } ?> value="Wii">Wii (2006)</option>
									<option <?php if($set_console == "PlayStation 3") { echo "selected"; } ?> value="PlayStation 3">PlayStation 3 (2006)</option>
									<option <?php if($set_console == "V.Smile Pocket") { echo "selected"; } ?> value="V.Smile Pocket">V.Smile Pocket (2005)</option>
									<option <?php if($set_console == "GP2X") { echo "selected"; } ?> value="GP2X">GP2X (2005)</option>
									<option <?php if($set_console == "Gizmondo") { echo "selected"; } ?> value="Gizmondo">Gizmondo (2005)</option>
									<option <?php if($set_console == "Xbox 360") { echo "selected"; } ?> value="Xbox 360">Xbox 360 (2005)</option>
									<option <?php if($set_console == "PlayStation Portable") { echo "selected"; } ?> value="PlayStation Portable">PlayStation Portable (2004)</option>
									<option <?php if($set_console == "Nintendo DS") { echo "selected"; } ?> value="Nintendo DS">Nintendo DS (2004)</option>
									<option <?php if($set_console == "GP32") { echo "selected"; } ?> value="GP32">GP32 (2004)</option>
									<option <?php if($set_console == "GameKing") { echo "selected"; } ?> value="GameKing">GameKing (2003)</option>
									<option <?php if($set_console == "Zodiac") { echo "selected"; } ?> value="Zodiac">Zodiac (2003)</option>
									<option <?php if($set_console == "N-Gage") { echo "selected"; } ?> value="N-Gage">N-Gage (2003)</option>
									<option <?php if($set_console == "Pokemon Mini") { echo "selected"; } ?> value="Pokemon Mini">Pokemon Mini (2001)</option>
									<option <?php if($set_console == "Game Boy Advance") { echo "selected"; } ?> value="Game Boy Advance">Game Boy Advance (2001)</option>
									<option <?php if($set_console == "Xbox") { echo "selected"; } ?> value="Xbox">Xbox (2001)</option>
									<option <?php if($set_console == "Nintendo GameCube") { echo "selected"; } ?> value="Nintendo GameCube">Nintendo GameCube (2001)</option>
									<option <?php if($set_console == "PlayStation 2") { echo "selected"; } ?> value="PlayStation 2">PlayStation 2 (2000)</option>
									<option <?php if($set_console == "WonderSwan") { echo "selected"; } ?> value="WonderSwan">WonderSwan (1999)</option>
									<option <?php if($set_console == "Neo Geo Pocket") { echo "selected"; } ?> value="Neo Geo Pocket">Neo Geo Pocket (1998)</option>
									<option <?php if($set_console == "Dreamcast") { echo "selected"; } ?> value="Dreamcast">Dreamcast (1998)</option>
									<option <?php if($set_console == "Game.com") { echo "selected"; } ?> value="Game.com">Game.com (1997)</option>
									<option <?php if($set_console == "Nintento 64") { echo "selected"; } ?> value="Nintento 64">Nintento 64 (1996)</option>
									<option <?php if($set_console == "R-Zone") { echo "selected"; } ?> value="R-Zone">R-Zone (1995)</option>
									<option <?php if($set_console == "Design Master Senshi Mangajukuu") { echo "selected"; } ?> value="Design Master Senshi Mangajukuu">Design Master Senshi Mangajukuu (1995)</option>
									<option <?php if($set_console == "Nomad") { echo "selected"; } ?> value="Nomad">Nomad (1995)</option>
									<option <?php if($set_console == "Virtual Boy") { echo "selected"; } ?> value="Virtual Boy">Virtual Boy (1995)</option>
									<option <?php if($set_console == "Apple Bandai Pippin") { echo "selected"; } ?> value="Apple Bandai Pippin">Apple Bandai Pippin (1995)</option>
									<option <?php if($set_console == "PC-FX") { echo "selected"; } ?> value="PC-FX">PC-FX (1994)</option>
									<option <?php if($set_console == "Sega Saturn") { echo "selected"; } ?> value="Sega Saturn">Sega Saturn (1994)</option>
									<option <?php if($set_console == "PlayStation") { echo "selected"; } ?> value="PlayStation">PlayStation (1994)</option>
									<option <?php if($set_console == "Neo-Geo CD") { echo "selected"; } ?> value="Neo-Geo CD">Neo-Geo CD (1994)</option>
									<option <?php if($set_console == "Mega Duck") { echo "selected"; } ?> value="Mega Duck">Mega Duck (1993)</option>
									<option <?php if($set_console == "Amiga CD32") { echo "selected"; } ?> value="Amiga CD32">Amiga CD32 (1993)</option>
									<option <?php if($set_console == "3DO Interactive Multiplayer") { echo "selected"; } ?> value="3DO Interactive Multiplayer">3DO Interactive Multiplayer (1993)</option>
									<option <?php if($set_console == "Atari Jaguar") { echo "selected"; } ?> value="Atari Jaguar">Atari Jaguar (1993)</option>
									<option <?php if($set_console == "FM Towns Marty") { echo "selected"; } ?> value="FM Towns Marty">FM Towns Marty (1993)</option>
									<option <?php if($set_console == "Pioneer LaserActive") { echo "selected"; } ?> value="Pioneer LaserActive">Pioneer LaserActive (1993)</option>
									<option <?php if($set_console == "Supervision") { echo "selected"; } ?> value="Supervision">Supervision (1992)</option>
									<option <?php if($set_console == "CD-i") { echo "selected"; } ?> value="CD-i">CD-i (1991)</option>
									<option <?php if($set_console == "Game Master") { echo "selected"; } ?> value="Game Master">Game Master (1990)</option>
									<option <?php if($set_console == "Gamate") { echo "selected"; } ?> value="Gamate">Gamate (1990)</option>
									<option <?php if($set_console == "TurboExpress") { echo "selected"; } ?> value="TurboExpress">TurboExpress (1990)</option>
									<option <?php if($set_console == "Game Gear") { echo "selected"; } ?> value="Game Gear">Game Gear (1990)</option>
									<option <?php if($set_console == "Super Nintendo Entertainment System (SNES)") { echo "selected"; } ?> value="Super Nintendo Entertainment System (SNES)">Super Nintendo Entertainment System (1990)</option>
									<option <?php if($set_console == "NeoGeo") { echo "selected"; } ?> value="NeoGeo">Neo-Geo (1990)</option>
									<option <?php if($set_console == "Lynx") { echo "selected"; } ?> value="Lynx">Lynx (1989)</option>
									<option <?php if($set_console == "Game Boy") { echo "selected"; } ?> value="Game Boy">Game Boy (1989)</option>
									<option <?php if($set_console == "Sega Genesis") { echo "selected"; } ?> value="Sega Genesis">Sega Genesis (1988)</option>
									<option <?php if($set_console == "TurboGrafx-16") { echo "selected"; } ?> value="TurboGrafx-16">TurboGrafx-16 (1987)</option>
									<option <?php if($set_console == "Action Max") { echo "selected"; } ?> value="Action Max">Action Max (1987)</option>
									<option <?php if($set_console == "Sega Master System") { echo "selected"; } ?> value="Sega Master System">Sega Master System (1985)</option>
									<option <?php if($set_console == "Game Pocket Computer") { echo "selected"; } ?> value="Game Pocket Computer">Game Pocket Computer (1984)</option>
									<option <?php if($set_console == "Super Cassette Vision") { echo "selected"; } ?> value="Super Cassette Vision">Super Cassette Vision (1984)</option>
									<option <?php if($set_console == "Atari 7800") { echo "selected"; } ?> value="Atari 7800">Atari 7800 (1984)</option>
									<option <?php if($set_console == "PV-1000") { echo "selected"; } ?> value="PV-1000">PV-1000 (1983)</option>
									<option <?php if($set_console == "Nintendo Entertainment System (NES)") { echo "selected"; } ?> value="Nintendo Entertainment System (NES)">Nintendo Entertainment System (1983)</option>
									<option <?php if($set_console == "Adventure Vision") { echo "selected"; } ?> value="Adventure Vision">Adventure Vision (1982)</option>
									<option <?php if($set_console == "Vectrex") { echo "selected"; } ?> value="Vectrex">Vectrex (1982)</option>
									<option <?php if($set_console == "ColecoVision") { echo "selected"; } ?> value="ColecoVision">ColecoVision (1982)</option>
									<option <?php if($set_console == "Atari 5200") { echo "selected"; } ?> value="Atari 5200">Atari 5200 (1982)</option>
									<option <?php if($set_console == "Arcadia 2001") { echo "selected"; } ?> value="Arcadia 2001">Arcadia 2001 (1982)</option>
									<option <?php if($set_console == "Select-A-Game") { echo "selected"; } ?> value="Select-A-Game">Select-A-Game (1981)</option>
									<option <?php if($set_console == "Epoch Cassette Vision") { echo "selected"; } ?> value="Epoch Cassette Vision">Epoch Cassette Vision (1981)</option>
									<option <?php if($set_console == "VTech CreatiVision") { echo "selected"; } ?> value="VTech CreatiVision">VTech CreatiVision (1981)</option>
									<option <?php if($set_console == "Intellivision") { echo "selected"; } ?> value="Intellivision">Intellivision (1980)</option>
									<option <?php if($set_console == "Game &amp; Watch") { echo "selected"; } ?> value="Game &amp; Watch">Game &amp; Watch (1980)</option>
									<option <?php if($set_console == "Microvision") { echo "selected"; } ?> value="Microvision">Microvision (1979)</option>
									<option <?php if($set_console == "Fairchild Channel F II") { echo "selected"; } ?> value="Fairchild Channel F II">Fairchild Channel F II (1979)</option>
									<option <?php if($set_console == "Magnavox Odyssey 2") { echo "selected"; } ?> value="Magnavox Odyssey 2">Magnavox Odyssey 2 (1978)</option>
									<option <?php if($set_console == "VC 4000") { echo "selected"; } ?> value="VC 4000">VC 4000 (1978)</option>
									<option <?php if($set_console == "Bally Astrocade") { echo "selected"; } ?> value="Bally Astrocade">Bally Astrocade (1977)</option>
									<option <?php if($set_console == "Atari 2600") { echo "selected"; } ?> value="Atari 2600">Atari 2600 (1977)</option>
									<option <?php if($set_console == "RCA Studio II") { echo "selected"; } ?> value="RCA Studio II">RCA Studio II (1977)</option>
									<option <?php if($set_console == "Fairchild Channel F") { echo "selected"; } ?> value="Fairchild Channel F">Fairchild Channel F (1976)</option>
									<option <?php if($set_console == "Magnavox Odyssey") { echo "selected"; } ?> value="Magnavox Odyssey">Magnavox Odyssey (1972)</option>
								</select>
							</p>
							<p>
								<label for="game">Favourite Game <i>(relative to console)</i></label>
								<input id="game" name="game" type="text" placeholder="Favourite Game" value="<?php if($set_game != 'undefined') { echo $set_game; } ?>" />
							</p>
						</li>
						<li>
							<h6>About</h6>
							<p>
								<label for="quote">Favourite Quote</label>
								<textarea name="quote" id="quote" placeholder="Greetings outlander."><?php if($set_quote != "Greetings outlander.") { echo $set_quote; } ?></textarea>
							</p>
							<p>
								<label for="bio">Your Bio</label>
								<textarea name="bio" id="bio" placeholder="If I had a dollar for every time someone asked to hear my story I would have a dollar... Maybe less."><?php if($set_bio != "If I had a dollar for every time someone asked to hear my story I would have a dollar... Maybe less.") { echo $set_bio; } ?></textarea>
							</p>
						</li>
						<li>
							<h6>Location</h6>
							<p>
								<label for="town">Town:</label>
								<input id="town" name="town" type="text" placeholder="Town/City" <?php if($set_town != 'undefined') { ?>value="<?php echo $set_town; ?>"<?php } ?> />
							</p>
							<p>
								<label for="country">Country:</label>
								<input id="country" name="country" type="text" placeholder="Country" <?php if($set_country != 'undefined') { ?>value="<?php echo $set_country; ?>"<?php } ?> />
							</p>
						</li>
						<li>
							<h6>External Links</h6>
							<p>
								<label for="website">Personal Website</label>
								<input id="website" name="website" type="url" placeholder="http:// (YOUR PERSONAL WEBSITE URL)" <?php if($set_website != 'undefined') { ?>value="<?php echo $set_website; ?>"<?php } ?> />
							</p>
							<p>
								<label for="facebook">Facebook Account</label>
								<input id="facebook" name="facebook" type="url" placeholder="https:// (YOUR FACEBOOK URL)" <?php if($set_facebook != 'undefined') { ?>value="<?php echo $set_facebook; ?>"<?php } ?> />
							</p>
							<p>
								<label for="twitter">Twitter Account</label>
								<input id="twitter" name="twitter" type="url" placeholder="https:// (YOUR TWITTER URL)" <?php if($set_twitter != 'undefined') { ?>value="<?php echo $set_twitter; ?>"<?php } ?> />
							</p>
							<p>
								<label for="googleplus">Google Plus Account</label>
								<input id="googleplus" name="googleplus" type="url" placeholder="https:// (YOUR GOOGLE PLUS URL)" <?php if($set_googleplus != 'undefined') { ?>value="<?php echo $set_googleplus; ?>"<?php } ?> />
							</p>
						</li>
						<li id="gsrinfo_submit" class="submit_button">
							<h6>Update Information</h6>
							<p>
								<button name="update" value="<?php echo $user; ?>" type="submit">UPDATE</button>
							</p>
						</li>
					</ul>
				</form>

				<form class="grid_16 grid_0 settingsdisplay" id="profpic" action="updateGSRinfo.php" method="post" enctype="multipart/form-data">
					<ul>
						<li id="sharkface">
							<h6>PROFILE PICTURE</h6>
							<div id="sharkface_wrapper">
								<div class="sharkface" data-shark-picture="<?php echo $ur_image; ?>"></div>
								<div class="shark_pic" data-shark-picture="<?php echo $ur_image; ?>"></div>
							</div>
							<p>
								<label for="sharkface"><i>Upload a new profile picture (MAX 1MB)</i></label>
								<input id="sharkface" name="sharkface" type="file" class="required" accept="image/jpeg" />
							</p>
							<p id="profpic_submit" class="submit_button">
								<br>
								<button name="uploadIMG" value="<?php echo $user; ?>" type="submit">UPLOAD</button>
							</p>
						</li>
					</ul>
				</form>

				<form class="grid_16 grid_0 settingsdisplay" id="coverpic" action="updateGSRinfo.php" method="post" enctype="multipart/form-data">
					<ul>
						<li id="sharkcover">
							<h6>COVER PICTURE</h6>
							<div id="sharkcover_wrapper">
								<div class="sharkcover" data-cover-picture="<?php echo $ur_cover; ?>"></div>
							</div>
							<p>
								<label for="sharkcover"><i>Upload a new cover picture (MAX 2MB)</i></label>
								<input id="sharkcover" name="sharkcover" type="file" class="required" accept="image/jpeg" />
							</p>
							<p id="cover_pic_submit" class="submit_button">
								<br>
								<button name="upload_cover" value="<?php echo $user; ?>" type="submit">UPLOAD</button>
							</p>
						</li>
					</ul>
				</form>

				<form class="grid_16 grid_0 settingsdisplay" id="accinfo" method="get" action="" autocomplete="off">
					<ul>
						<li>
							<h6>Account Information</h6>
							<p>
								<label for="firstname">First Name</label>
								<input id="firstname" name="firstname" type="text" value="<?php echo $set_firstname; ?>" placeholder="<?php echo $set_firstname; ?>" required />
							</p>
							<p>
								<label for="lastname">Last Name</label>
								<input id="lastname" name="lastname" type="text" value="<?php echo $set_lastname; ?>" placeholder="<?php echo $set_lastname; ?>" required />
							</p>
							<p>
								<label for="showname">Show Full Name</label>
								<input id="showname" name="showname" type="range" type="range" value="<?php if($set_showname == 1) { echo '1'; } else { echo '0'; } ?>" min="0" max="1" />
							</p>
							<p>
								<label for="email">Email Address</label>
								<input id="email" name="email" type="email" value="<?php echo $set_email; ?>" placeholder="<?php echo $set_email; ?>" required />
							</p>
							<p>
								<label for="securityquestion">Security Question</label>
								<select id="securityquestion" name="securityquestion">
									<?php
									$questionQRY = mysqli_query($con, "SELECT * FROM tbl_questions ORDER BY id");
									if(empty($set_question)){
										echo '<option disabled selected>Select a question</option>';
									}
									while($qQRY = mysqli_fetch_assoc($questionQRY)) {
										$questionId = $qQRY['id'];
										$questionQ = $qQRY['question'];
										if($set_question==$questionId){
											echo '<option value="'.$questionId.'" selected>'.$questionQ.'</option>';
										}
										else{
											echo '<option value="'.$questionId.'">'.$questionQ.'</option>';
										}
									}
									?>
								</select>
							</p>

							<p>
								<label for="securityanswer">Security Answer</label>
								<input id="securityanswer" name="securityanswer" value="<?php echo $set_answer; ?>" placeholder="<?php echo $set_answer; ?>" required />
							</p>


							<p>
								<label for="oldpassword">Old Password</label>
								<input id="oldpassword" name="oldpassword" type="password" placeholder="Old Password" />
							</p>
							<p>
								<label for="newpassword">New Password</label>
								<input id="newpassword" name="newpassword" type="password" placeholder="New Password" minlength="8" />
							</p>
							<p>
								<label for="confirmpassword">Confirm Password</label>
								<input id="confirmpassword" name="confirmpassword" type="password" placeholder="Confirm Password" />
							</p>
							<p id="accinfo_submit" class="submit_button">
								<br>
								<button name="apply" value="<?php echo $user; ?>" type="submit">APPLY</button>
							</p>
						</li>
					</ul>
				</form>

			</section>

		</article>

	</div>

	<?php include "footer.html"; ?>

	<script type="text/javascript">
	jQuery.validator.addMethod("passwordStrength", function(value, element) {
		if(value != "") {
			var strength = 0
			if (value.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))  strength += 1
			if (value.match(/([a-zA-Z])/) && value.match(/([0-9])/))  strength += 1
			return strength > 1;
		} else {
			return true;
		}
	}, "ERROR");

	jQuery.validator.addMethod("samePass", function(value, element) {
		if(value != $("#oldpassword").val()) {
			return true;
		} else if(value == "" && $("#oldpassword").val() == "") {
			return true;
		}
	}, "ERROR");

	jQuery.validator.addMethod("hasOld", function(value, element) {
		if(value != "") {
			return true;
		} else if(value == "" && $("#newpassword").val() == "") {
			return true;
		}
	}, "ERROR");

	function liveButton(parentName) {

		$("#" + parentName + "_submit").show();

	}

	$.urlParam = function (url) {
		var pageAttr = new RegExp('[\?&]' + url + '=([^&#]*)').exec(window.location.href);
		if(pageAttr == null) {
			return null;
		} else {
			return pageAttr[1] || 0;
		}
	}

	function showNameRange() {
		var rangeVal = $("#showname").val();

		if(rangeVal == "0") {
			$("#showname").addClass('zero');
		} else {
			$("#showname").removeClass('zero');
		}
	}

	$(function() {

		setInterval(showNameRange(),0);

		$("#showname").on("click", function() {
			setInterval(showNameRange());
		});

		// $(".submit_button").each(function() {
		// 	$(this).hide();
		// });

		$(".opt_tab").each(function() {
			var btnID = $(this).attr("id").replace("_button","");
			liveButton(btnID);
			$(this).click(function() {
				$(".opt_tab").removeClass('active');
				$(this).addClass('active');

				$(".settingsdisplay").removeClass("active");
				$("#" + btnID).addClass("active");
			});
		});

		if($.urlParam('change_profile_image') == 'filesize_error') {
			$(".opt_tab").removeClass('active');
			$("#profpic_button").addClass('active');

			$(".settingsdisplay").removeClass("active");
			$("#profpic").addClass("active");

			$("input[type=file]").addClass('error');
			$("input[type=file]").after("<label class='error' id='filerror'>That image was too large.</label>");
			$("#filerror").delay(5000).fadeOut('fast', function() {
				$("input[type=file]").removeClass('error');
			});
		} else if($.urlParam('change_profile_image') == 'file_empty') {
			$(".opt_tab").removeClass('active');
			$("#profpic_button").addClass('active');

			$(".settingsdisplay").removeClass("active");
			$("#profpic").addClass("active");

			$("input[type=file]").addClass('error');
			$("input[type=file]").after("<label class='error' id='filerror'>Please select an image.</label>");
			$("#filerror").delay(5000).fadeOut('fast', function() {
				$("input[type=file]").removeClass('error');
			});
		} else if($.urlParam('change_profile_image') == 'file_invalid') {
			$(".opt_tab").removeClass('active');
			$("#profpic_button").addClass('active');

			$(".settingsdisplay").removeClass("active");
			$("#profpic").addClass("active");

			$("input[type=file]").addClass('error');
			$("input[type=file]").after("<label class='error' id='filerror'>That image was invalid, please try again.</label>");
			$("#filerror").delay(5000).fadeOut('fast', function() {
				$("input[type=file]").removeClass('error');
			});
		} else if($.urlParam('change_profile_image') == 'upload_successful') {
			$(".opt_tab").removeClass('active');
			$("#profpic_button").addClass('active');

			$(".settingsdisplay").removeClass("active");
			$("#profpic").addClass("active");
		}

		if($.urlParam('change_cover_image') == 'filesize_error') {
			$(".opt_tab").removeClass('active');
			$("#coverpic_button").addClass('active');

			$(".settingsdisplay").removeClass("active");
			$("#coverpic").addClass("active");

			$("input[type=file]").addClass('error');
			$("input[type=file]").after("<label class='error' id='filerror'>That image was too large.</label>");
			$("#filerror").delay(5000).fadeOut('fast', function() {
				$("input[type=file]").removeClass('error');
			});
		} else if($.urlParam('change_cover_image') == 'file_empty') {
			$(".opt_tab").removeClass('active');
			$("#coverpic_button").addClass('active');

			$(".settingsdisplay").removeClass("active");
			$("#coverpic").addClass("active");

			$("input[type=file]").addClass('error');
			$("input[type=file]").after("<label class='error' id='filerror'>Please select an image.</label>");
			$("#filerror").delay(5000).fadeOut('fast', function() {
				$("input[type=file]").removeClass('error');
			});
		} else if($.urlParam('change_cover_image') == 'file_invalid') {
			$(".opt_tab").removeClass('active');
			$("#coverpic_button").addClass('active');

			$(".settingsdisplay").removeClass("active");
			$("#coverpic").addClass("active");

			$("input[type=file]").addClass('error');
			$("input[type=file]").after("<label class='error' id='filerror'>That image was invalid, please try again.</label>");
			$("#filerror").delay(5000).fadeOut('fast', function() {
				$("input[type=file]").removeClass('error');
			});
		} else if($.urlParam('change_cover_image') == 'upload_successful') {
			$(".opt_tab").removeClass('active');
			$("#coverpic_button").addClass('active');

			$(".settingsdisplay").removeClass("active");
			$("#coverpic").addClass("active");
		}

		$("#gsrinfo").validate({
			rules: {
				website: { url: true },
				facebook: { url: true },
				twitter: { url: true },
				googleplus: { url: true }
			},
			messages: {
				website: "That website address is not valid.",
				facebook: "That Facebook URL is not valid.",
				twitter: "That Twitter URL is not valid.",
				googleplus: "That Google Plus URL is not valid."
			},
			submitHandler: function(form) {
				var gsrINFO = $(form).serialize();
				$.ajax({
					url : "updateGSRinfo.php",
					data : gsrINFO,
					type : "GET",
					dataType: "html",
					async : false,
					success: function(data) {
						window.location.reload();
					}
				});
			}
		});

		$("#profpic").validate();

		$("#coverpic").validate();

		var avaURL = "signup_availability.php";

		$("#securityquestion").change(function(){
			$("#securityanswer").val("");
		});

		$("#accinfo").validate({
			rules: {
				firstname: "required",
				lastname: "required",
				email: {
					required: true,
					email: true,
					remote: avaURL
				},
				securityquestion: {
					required: true
				},
				securityanswer: {
					required: true
				},
				oldpassword: {
					hasOld: true,
					remote: avaURL
				},
				newpassword: {
					minlength: 8,
					passwordStrength: true,
					samePass: true,
					required: false
				},
				confirmpassword: {
					equalTo: "#newpassword"
				}
			},
			messages: {
				firstname: "You must enter your first name.",
				lastname: "You must enter your last name.",
				email: {
					required: "You must enter your email address.",
					email: "That email address is invalid.",
					remote: "That email address is already in use."
				},
				securityquestion: {
					required: "Please select a security question.",
				},
				securityanswer: {
					required: "You may not leave your security answer blank.",
				},
				oldpassword: {
					hasOld: "You must enter your old password.",
					remote: "That password is incorrect."
				},
				newpassword: {
					minlength: "New password must be at least 8 characters.",
					passwordStrength: "Needs an uppercase, a lowercase and a digit.",
					samePass: "Please provide a unique password."
				},
				confirmpassword: {
					equalTo: "That is not the same password."
				}
			},
			submitHandler: function(form) {
				var accINFO = $(form).serialize();
				$.ajax({
					url : "updateGSRinfo.php",
					data : accINFO,
					type : "GET",
					dataType: "html",
					async : false,
					success: function(data) {
						window.location.reload();
					}
				});
			}
		});
	});
	</script>

</body>
</html>
