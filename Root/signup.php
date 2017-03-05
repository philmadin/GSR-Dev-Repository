<?php
if(isset($_GET['user'])){$social_user = json_decode(base64_decode($_GET['user']));}else{$social_user = false;}
if(isset($_GET['auth_type'])){$auth_type = $_GET['auth_type'];}else{$auth_type = false;}

$uid       = $social_user->uid;

$fullName = "";
$firstName = "";
$lastName = "";
$email = "";


if($social_user!=false){

    if(is_null($social_user->displayName)){$fullName = $social_user->providerData{0}->displayName;}else{$fullName = $social_user->displayName;}
    $splitName = explode(" ",$fullName);
    $firstName = $splitName[0];
    $lastName = $splitName[1];
    if(is_null($social_user->email)){$email = $social_user->providerData{0}->email;}else{$email = $social_user->email;}
}

/*echo '<pre>';
var_dump($social_user);
echo '</pre>';*/

?>

<!doctype html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="index, follow, noarchive">

<title>Register with Game Shark Reviews | Sign Up | GSR</title>

<meta name="description" content="GSR - Welcome to <?php echo $pr_username; ?>'s profile page!">

<?php include "links.php"; ?>

</head>

<body>

	<?php include "header.php"; ?>

	<div id="page" class="container_24">

		<article class="blog grid_0_top">
			<section class="grid_24" id="signuppage">
		        <h1 class="grid_16">SIGN UP WITH GAME SHARK REVIEWS - GSR</h1>
		        <div id="forms_wrapper" class="grid_16">
		        	<ul id="forms_tabs">
						<li class="active"><a id="individual" class="tab_button">Individual</a></li>
						<!--<li><a id="company" class="tab_button">Company</a></li>-->
					</ul>
					<form id="signup_individual" method="get" action="">
			            <ul class="grid_8">
                            <?php if($auth_type!=false && $social_user!=false){ ?>
                            <li style="display:none;">
                                <input id="auth_type" name="auth_type" value="<?php echo $auth_type;?>" type="text" hidden/>
                                <input id="social_user" name="social_user" value="<?php echo base64_encode(json_encode($social_user));?>" type="text" hidden/>
                            </li>
                            <?php } ?>
			            	<li>
				                <input id="firstname" name="firstname" value="<?php echo $firstName;?>" type="text" placeholder="First Name" required />
				            </li>
				            <li>
			                	<input id="lastname" name="lastname" value="<?php echo $lastName;?>" type="text" placeholder="Last Name" required />
							</li>
				            <li>
			                	<input id="email_individual" name="email_individual" value="<?php echo $email;?>" type="email" placeholder="Email Address" required />
							</li>
							<li>
			                	<input id="username_individual" name="username_individual" type="text" placeholder="Username" minlength="6" maxlength="12" required />
							</li>
							<li>
			                	<input id="password_individual" name="password_individual" type="password" placeholder="Password" minlength="8" required />
							</li>
							<li>
			                	<input id="confirm_individual" name="confirm_individual" type="password" placeholder="Confirm Password" required />
							</li>
							<li>
							<select id="securityquestion_individual" name="securityquestion_individual">
							<?php
							$questionQRY = mysqli_query($con, "SELECT * FROM tbl_questions ORDER BY id");
							echo '<option disabled selected>Security Question</option>';
							while($qQRY = mysqli_fetch_assoc($questionQRY)) {
							$questionId = $qQRY['id'];
							$questionQ = $qQRY['question'];
							echo '<option value="'.$questionId.'">'.$questionQ.'</option>';	
							}
							?>
							</select>
							</li>

							<li>
								<input id="securityanswer_individual" name="securityanswer_individual" placeholder="Security Answer" required />
							</li>
							<li class="agreements">
								<input id="gua_individual" name="gua_individual[]" type="checkbox" required />
								<label class="checkbox" for="gua_individual"> I have read and agree to the<br><a href="legal/GSR-User-Policy.php" class="userpolicy">GSR User Policy</a></label>
							</li>
							<li class="agreements">
								<input id="gpp_individual" name="gpp_individual[]" type="checkbox" required />
								<label class="checkbox" for="gpp_individual"> I have read and agree to the<br><a href="legal/GSR-Terms-And-Conditions.php" class="tandc">GSR Terms and Conditions</a></label>
							</li>
							<li id="antirobot">
								<input id="mobile_individual" name="mobile_individual" type="tel" placeholder="ANTI-ROBOT" required />
							</li>
			            </ul>

						<ul class="errorswrapper"></ul>

						<button name="signup_individual" type="submit" id="signup_individual">SIGN UP</button>
			        </form>

			        <form id="signup_company">
			            <ul class="grid_8">
			            	<li>
				                <input id="companyname" name="companyname" type="text" placeholder="Company Name" required />
				            </li>
				            <li>
			                	<input id="website" name="website" type="url" placeholder="Website URL" />
							</li>
				            <li>
			                	<input id="email_company" name="email_company" type="email" placeholder="Email Address" required />
							</li>
							<li>
			                	<input id="username_company" name="username_company" type="text" placeholder="Username" minlength="6" maxlength="12" required />
							</li>
							<li>
			                	<input id="password_company" name="password_company" type="password" placeholder="Password" minlength="8" required />
							</li>
							<li>
			                	<input id="confirm_company" name="confirm_company" type="password" placeholder="Confirm Password" required />
							</li>
							<li>
							<select id="securityquestion_company" name="securityquestion_company">
							<?php
							$questionQRY = mysqli_query($con, "SELECT * FROM tbl_questions ORDER BY id");
							echo '<option disabled selected>Security Question</option>';
							while($qQRY = mysqli_fetch_assoc($questionQRY)) {
							$questionId = $qQRY['id'];
							$questionQ = $qQRY['question'];
							echo '<option value="'.$questionId.'">'.$questionQ.'</option>';	
							}
							?>
							</select>
							</li>

							<li>
								<input id="securityanswer_company" name="securityanswer_company" placeholder="Security Answer" required />
							</li>
							<li class="agreements">
								<input id="gua_company" name="gua_company[]" type="checkbox" required />
								<label class="checkbox" for="gua_company"> I have read and agree to the<br><a href="legal/GSR-User-Policy.php" class="userpolicy">GSR User Policy</a></label>
							</li>
							<li class="agreements">
								<input id="gpp_company" name="gpp_company[]" type="checkbox" required />
								<label class="checkbox" for="gpp_company"> I have read and agree to the<br><a href="legal/GSR-Terms-And-Conditions.php" class="tandc">GSR Terms and Conditions</a></label>
							</li>
							<li class="agreements">
								<input id="gcb_company" name="gcb_company[]" type="checkbox" required />
								<label class="checkbox" for="gcb_company"> I confirm that I am a registered business.</label>
							</li>
						</ul>

						<ul class="errorswrapper"></ul>

						<button name="signup_company" type="submit" id="signup_company">SIGN UP</button>
			        </form>
			    </div>
			</section>
		</article>

	</div>
	

	<?php include "footer.html"; ?>

	<script type="text/javascript">
		jQuery.validator.addMethod("passwordStrength", function(value, element) {
			var strength = 0
			if (value.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))  strength += 1
			if (value.match(/([a-zA-Z])/) && value.match(/([0-9])/))  strength += 1
		    return strength > 1;
		}, "ERROR");

		jQuery.validator.addMethod("uniqueUsername", function(value, element) {
			if(/^[a-zA-Z0-9_]*$/.test(value) == true) return true;
		}, "ERROR");

		jQuery.validator.addMethod("antiRobot", function(value, element) {
			if(value == "") return true;
		}, "ERROR");

		$(function() {

			$('.userpolicy').magnificPopup({
			type: 'ajax',
			removalDelay: 300,
			mainClass: 'mfp-fade'
			});
			
			$('.tandc').magnificPopup({
			type: 'ajax',
			removalDelay: 300,
			mainClass: 'mfp-fade'
			});

			$("#signup_company").hide();

			$("input").focus(function() { $(this).removeClass('error') });

			$("#individual").click(function() {
				$("#signup_company").hide();
				$("#signup_individual").show();
				$("#individual").parent("li").addClass('active');
				$("#company").parent("li").removeClass('active');
			});

			$("#company").click(function() {
				$("#signup_company").show();
				$("#signup_individual").hide();
				$("#company").parent("li").addClass('active');
				$("#individual").parent("li").removeClass('active');
			});

			var avaURL = "signup_availability.php";
			
			$("#securityquestion_individual").change(function(){
			$("#securityanswer_individual").val("");
			})
			$("#securityquestion_company").change(function(){
			$("#securityanswer_company").val("");
			});

			$("#signup_individual").validate({
				ignore: [],
				rules: {
					firstname: "required",
					lastname: "required",
					username_individual: {
						required: true,
						minlength: 6,
						maxlength: 12,
						uniqueUsername: true,
						remote: avaURL
					},
					password_individual: {
						required: true,
						minlength: 8,
						passwordStrength: true
					},
					confirm_individual: {
						required: true,
						equalTo: "#password_individual"
					},
					email_individual: {
						required: true,
						email: true,
						remote: avaURL
					},
					securityquestion_individual: {
						required: true
					},
					securityanswer_individual: {
						required: true
					},
					'gua_individual[]': {
						required: true
					},
					'gpp_individual[]': {
						required: true
					},
					mobile_individual: {
						required: false,
						antiRobot: true
					}
				},
				messages: {
					firstname: "Please enter your first name.",
					lastname: "Please enter your last name.",
					username_individual: {
						required: "Please enter a unique username.",
						minlength: "Your username must consist of at least 6 characters.",
						maxlength: "Your username cannot be more than 12 characters long.",
						uniqueUsername: "Your username must not consist of any SPACES or SPECIAL CHARACTERS.",
						remote: "That username is already taken."
					},
					password_individual: {
						required: "Please provide a unique password.",
						minlength: "Your password must be at least 8 characters long.",
						passwordStrength: "You must have at least ONE UPPERCASE, ONE LOWERCASE and ONE DIGIT in your password."
					},
					confirm_individual: "Please re-enter the same password as above.",
					email_individual: {
						required: "Please enter a valid email address.",
						email: "That is not a valid email address.",
						remote: "That email address is already linked to an account, please use another email address or click on 'forgot password' under the login form."
					},
					securityquestion_individual: {
						required: "Please select a security question."
					},
					securityanswer_individual: {
						required: "Please provide a security answer."
					},
					'gua_individual[]': "You must read, acknowledge and agree to the GSR User Agreement.",
					'gpp_individual[]': "You must read, acknowledge and agree to the GSR Privacy Policy.",
					mobile_individual: {
						required: "NO ROBOTS ALLOWED! <br><br>If you used a robot please refresh the page.",
						antiRobot: "NO ROBOTS ALLOWED! <br><br>If you used a robot please refresh the page."
					}
				},
				errorElement: "div",
				errorPlacement: function(error, element) {
			     	error.appendTo('#signup_individual .errorswrapper');
			   	},
				submitHandler: function(form) {

					var form_individual = $(form).serialize();
					var form_username = $("#username_individual").val();

			        $.ajax({
			            url : "registeruser.php",
			            data : form_individual,
			            type : "GET",
			            dataType: "html",
			            async : false,
			            success: function() {
			                window.location.replace('email_verification.php');
			            }
			        });
				}
			});

			$("#signup_company").validate({
				ignore: [],
				rules: {
					companyname: "required",
					website: "url",
					username_company: {
						required: true,
						minlength: 6,
						maxlength: 12,
						uniqueUsername: true,
						remote: avaURL
					},
					password_company: {
						required: true,
						minlength: 8,
						passwordStrength: true
					},
					securityquestion_company: {
						required: true
					},
					securityanswer_company: {
						required: true
					},					
					confirm_company: {
						required: true,
						equalTo: "#password_company"
					},
					email_company: {
						required: true,
						email: true,
						remote: avaURL
					},
					'gua_company[]': {
						required: true
					},
					'gpp_company[]': {
						required: true
					},
					'gcb_company[]': {
						required: true
					}
				},
				messages: {
					companyname: "Please enter your company name.",
					website: "That website url is not valid. Please make sure your website url contains 'http://'.",
					username_company: {
						required: "Please enter a unique username.",
						minlength: "Your username must consist of at least 6 characters.",
						maxlength: "Your username cannot be more than 12 characters long.",
						uniqueUsername: "Your username must not consist of any SPACES or SPECIAL CHARACTERS.",
						remote: "That username is already taken."
					},
					password_company: {
						required: "Please provide a unique password.",
						minlength: "Your password must be at least 8 characters long.",
						passwordStrength: "You must have at least ONE UPPERCASE, ONE LOWERCASE and ONE DIGIT in your password."
					},
					securityquestion_company: {
						required: "Please select a security question."
					},
					securityanswer_company: {
						required: "Please provide a security answer."
					},					
					confirm_company: "Please re-enter the same password as above.",
					email_company: {
						required: "Please enter a valid email address.",
						email: "That is not a valid email address.",
						remote: "That email address is already linked to an account, please use another email address or click on 'forgot password' under the login form."
					},
					'gua_company[]': "You must read, acknowledge and agree to the GSR User Agreement.",
					'gpp_company[]': "You must read, acknowledge and agree to the GSR Privacy Policy.",
					'gcb_company[]': "You must be a registered business to sign up as a business."
				},
				errorElement: "div",
				errorPlacement: function(error, element) {
			     	error.appendTo('#signup_company .errorswrapper');
			   	},
				submitHandler: function(form) {

					var form_company = $(form).serialize();
					var form_couser = $("#username_company").val();

			        $.ajax({
			            url : "registerco.php",
			            data : form_company,
			            type : "GET",
			            dataType: "html",
			            async : false,
			            success: function() {
			                window.location.replace('profile.php?profilename=' + form_couser);
			            }
			        });
				}
			});
		});
	</script>

</body>
</html>