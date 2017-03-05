<?php
	include "mysql_con.php";

	$user = $_SESSION['username'];

	if(isset($user)) { header("location:index.php"); }

	if(isset($_GET['type'])){
		if($_GET['type']=="user"){
			$fgTYPE = 'user';
		}
		if($_GET['type']=="key"){
			if(isset($_GET['key']) && !empty($_GET['key']) && $_GET['key']!=""){
			$fgKEY = $_GET['key'];
			$fgTYPE = 'key';
			
			$keyQRY = mysqli_query($con, "SELECT * FROM tbl_resets WHERE unique_key = '$fgKEY'");
			if(mysqli_num_rows($keyQRY)>0){
			while ($keyInfo = mysqli_fetch_array($keyQRY)) {
			$keyUser = $keyInfo['user'];
			}
			$userQRY = mysqli_query($con, "SELECT * FROM tbl_users WHERE username = '$keyUser'");
			while($SUQRY = mysqli_fetch_array($userQRY)) {
			$key_question = $SUQRY['sec_question'];
			}
			}
			else{
			header("location:index.php");	
			}
			}
			else{
			header("location:index.php");	
			}
		}
		if($_GET['type']=="success"){
			$fgTYPE = 'success';
		}
		if($_GET['type']=="pass"){
			$fgTYPE = 'pass';
		}
		else if($_GET['type']!='user' && $_GET['type']!='pass' && $_GET['type']!='key' && $_GET['type']!='success'){
			header("location:index.php");
		}
	}
	else if(!isset($_GET['type'])){
		header("location:index.php");
	}
	
?>

<!doctype html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="index, follow, noarchive">
		        <?php 
				if($fgTYPE=='success'){echo '<title>Email Sent | Forgot | GSR</title>';}
				if($fgTYPE=='pass'){echo '<title>Forgot Password For Account | Forgot | GSR</title>';}
				if($fgTYPE=='user'){echo '<title>Forgot Username For Account | Forgot | GSR</title>';}
				if($fgTYPE=='key'){echo '<title>Change Password | Forgot | GSR</title>';}
				?>


<meta name="description" content="Can't log in to GSR? Click here to reset your password or recieve an email containing usernames you've created.">

<?php include "links.php"; ?>

</head>

<body>

	<?php include "header.php"; ?>

	<div id="page" class="container_24">

		<article class="blog grid_0_top">
			<section class="grid_24" id="forgotpage">
		        <?php 
				if($fgTYPE=='success'){echo '<h1 class="grid_16">EMAIL SENT - GSR</h1>';} 
				if($fgTYPE=='pass'){echo '<h1 class="grid_16">FORGOT PASSWORD - GSR</h1>';}
				if($fgTYPE=='user'){echo '<h1 class="grid_16">FORGOT USERNAME - GSR</h1>';}
				if($fgTYPE=='key'){echo '<h1 class="grid_16">CHANGE PASSWORD - GSR</h1>';}
				?>
		        <div id="forms_wrapper" class="grid_16">
				<div class="extrahelp">
				For any further support please contact GSR Admins at <a href="mailto:admin@gamesharkreviews.com">admin@gamesharkreviews.com</a>
				</div>
				<?php if($fgTYPE=='pass'){ ?>
					<form id="forgotpass" method="get" action="" autocomplete="off">
					<div class="description">
					Please enter your username and email address so we can send you a unique link to reset your password.
					</div>
			            <ul class="grid_8">
			            	<li>
				                <input id="username_pw" name="username_pw" type="username" placeholder="Username" required />
							</li>
							<li>
				                <input id="email_pw" name="email_pw" type="email" placeholder="Email Address" required />
				            </li>
			            </ul>

						<ul id="errorswrapper_pass" class="errorswrapper"></ul>

						<button name="forgotpass" type="submit" id="forgotpass">SEND</button>
			        </form>
				<?php } ?>
				<?php if($fgTYPE=='user'){ ?>
					<form id="forgotuser" method="get" action="" autocomplete="off">
					<div class="description">
					Please enter your  email address so we can send you a list of usernames linked to this account.
					</div>
			            <ul class="grid_8">
							<li>
				                <input id="email_user" name="email_user" type="email" placeholder="Email Address" required />
				            </li>
			            </ul>

						<ul id="errorswrapper_user" class="errorswrapper"></ul>

						<button name="forgotuser" type="submit" id="forgotuser">SEND</button>
			        </form>
				<?php } ?>
				<?php if($fgTYPE=='key'){ ?>
					<form id="forgotkey" method="get" action="" autocomplete="off">
					<div class="description">
					<?php 
					if($key_question>0){
					echo 'Please enter the answer to your security question, then enter your new password and confirm it.';
					}
					else{
					echo 'You have no security question set. <br /> You can still reset your password but it is highly recommended that you set one as soon as you log in for added security.';
					}
					?>
					</div>
			            <ul class="grid_8">
			            	<li>
								<?php if($key_question>0){ ?>
								<label for="answer_key"><?php
								$questionQRY = mysqli_query($con, "SELECT * FROM tbl_questions WHERE id = '$key_question' ORDER BY id");
								while($qQRY = mysqli_fetch_assoc($questionQRY)) {
									echo $qQRY['question'];
								}
								?></label>
				                <input id="answer_key" name="answer_key" type="text" placeholder="Answer" required />
				            </li>
								<?php } ?>
			            	<li>
				                <input id="pass_key" name="pass_key" type="password" placeholder="New Password" required />
				            </li>
			            	<li style="display:none;">
				                <input id="key_key" name="key_key" type="text" value="<?php echo $fgKEY;?>" required />
				            </li>
			            	<li>
				                <input id="confirm_key" name="confirm_key" type="password" placeholder="Confirm Password" required />
				            </li>
			            </ul>

						<ul id="errorswrapper_key" class="errorswrapper"></ul>

						<button name="forgotkey" type="submit" id="forgotkey">RESET</button>
			        </form>
				<?php } ?>
				<?php if($fgTYPE=='success'){ ?>
				<?php if($_GET['t']=="user"){?>
					<center><h3>An email that lists your usernames linked to this email address has been sent to your inbox.</h3></center>
				<?php } ?>
				<?php if($_GET['t']=="pass"){?>
					<center><h3>An email containing instructions on how to reset your password has been sent to your inbox.</h3></center>
				<?php } ?>
				<?php if($_GET['t']=="key"){?>
					<center><h3>Your password has been reset, you may now log in.</h3></center>
				<?php } ?>
				<?php } ?>
			    </div>
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


		jQuery.validator.addMethod("uniqueUsername", function(value, element) {
			if(/^[a-zA-Z0-9_]*$/.test(value) == true) return true;
		}, "ERROR");

		jQuery.validator.addMethod("antiRobot", function(value, element) {
			if(value == "") return true;
		}, "ERROR");

		$(function() {


			$("input").focus(function() { $(this).removeClass('error') });


			var avaURL = "forgot_check.php";

			$("#forgotkey").validate({
				ignore: [],
				rules: {
					<?php if($key_question>0){ ?>
					answer_key: {
					required: true,
					remote: { 
					url:avaURL, 
					data: {'answer_key_check':function(){return $('#key_key').val()}},
					async:false 
					}
					},
					<?php } ?>
					pass_key: {
						minlength: 8,
						passwordStrength: true,
						required: true
					},
					key_key: {
					required: true,
					remote: avaURL
					},
					confirm_key: {
					equalTo: "#pass_key"
					}
				},
				messages: {
					<?php if($key_question>0){ ?>
					answer_key: {
					required: "Please enter the answer to your question.",
					remote: "The answer to the question is incorrect."
					},
					<?php } ?>
					pass_key: {
						minlength: "New password must be at least 8 characters.",
						passwordStrength: "Needs an uppercase, a lowercase and a digit.",
						required: "Do you want a new password or what? Don't leave it blank!"
					},
					key_key: {
					required: "Why are you tampering with code?!?!",
					remote: "Key does not exist, so why bother changing it?"
					},
					confirm_key: {
					equalTo: "Passwords must match."
					}					
				},
				errorElement: "div",
				errorPlacement: function(error, element) {
			     	error.appendTo('#errorswrapper_key');
			   	},
				submitHandler: function(form) {

					var form_pass = $(form).serialize();

			        $.ajax({
			            url : "forgot_action.php",
			            data : form_pass,
			            type : "GET",
			            dataType: "html",
			            async : false,
			            success: function(data) {
			                window.location.replace('forgot.php?type=success&t=key');
			            }
			        });
				}
			});
			
			
			$("#forgotpass").validate({
				ignore: [],
				rules: {
					username_pw: {
					required: true,
					remote: avaURL
					},
					email_pw: {
					required: true,
					remote: avaURL,
					email: true
					}
				},
				messages: {
					username_pw: {
					required: "Please enter your username.",
					remote: "That username does not exist in our database."
					},
					email_pw: {
					required: "Please enter your email address.",
					remote: "That email address does not exist in our database.",
					email: "That is not a valid email address"
					}
				},
				errorElement: "div",
				errorPlacement: function(error, element) {
			     	error.appendTo('#errorswrapper_pass');
			   	},
				submitHandler: function(form) {

					var form_pass = $(form).serialize();

			        $.ajax({
			            url : "forgot_action.php",
			            data : form_pass,
			            type : "GET",
			            dataType: "html",
			            async : false,
			            success: function(data) {
			                window.location.replace('forgot.php?type=success&t=pass');
			            }
			        });
				}
			});
			$("#forgotuser").validate({
				ignore: [],
				rules: {
					email_user: {
					required: true,
					remote: avaURL,
					email: true
					}
				},
				messages: {
					email_user: {
					required: "Please enter your email address.",
					remote: "That email address does not exist in our database.",
					email: "That is not a valid email address"
					}
				},
				errorElement: "div",
				errorPlacement: function(error, element) {
			     	error.appendTo('#errorswrapper_user');
			   	},
				submitHandler: function(form) {

					var form_pass = $(form).serialize();

			        $.ajax({
			            url : "forgot_action.php",
			            data : form_pass,
			            type : "GET",
			            dataType: "html",
			            async : false,
			            success: function(data) {
			                window.location.replace('forgot.php?type=success&t=user');
			            }
			        });
				}
			});
			
			
			
		});
	</script>

</body>
</html>