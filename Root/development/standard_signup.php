<?php
	
	session_start();

	include "mysql_con.php";

	// ENCRYPT RECEIVED PASSWORD
	function generateHash($pass) {
		if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
			$salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
			return crypt($pass, $salt);
		}
	}

	$firstname 	= $_GET['firstname'];
	$lastname 	= $_GET['lastname'];
	$email 		= $_GET['email'];
	$username 	= $_GET['username'];
	$password 	= generateHash($_GET['password']);
	$confirm 	= $_GET['confirm'];

	$verification 	= md5($username . $email);
	$began 			= date("Y-m-d H:i:s");
	$na 			= "undefined";
	$de_bio 		= "If I had a dollar for every time someone asked to hear my story I would have a dollar... Maybe less.";
	$de_quo 		= "Greetings outlander.";
	$de_occ			= "Game Sharker";

	// CHECK IF USERNAME IS IN USE
	$check_username_query = mysqli_query($con, "SELECT username FROM tbl_users WHERE username = '$username'");
	if(mysqli_num_rows($check_username_query) == 1) {
		echo "taken";
	} else {
		
		// CHECK IF EMAIL IS IN USE
		$check_email_query = mysqli_query($con, "SELECT email FROM tbl_users WHERE email = '$email'");
		if(mysqli_num_rows($check_email_query) == 1) {
			echo "inuse";
		} else {
			$users_table = mysqli_query($con, "INSERT INTO tbl_users (email, verify, username, password, online) VALUES ('$email','$verification','$username','$password','ONLINE')");

			$accounts_table = mysqli_query($con, "INSERT INTO tbl_accounts (username, firstname, lastname, showname, xbox, playstation, steam, console, game, quote, biography, occupation, since, town, country, website, facebook, twitter, googleplus, level, xp) VALUES ('$username','$firstname','$lastname','false','$na','$na','$na','$na','$na','$de_quo','$de_bio','$de_occ','$began','$na','$na','$na','$na','$na','$na','1','0')");
			

			if($users_table && $accounts_table) {
				echo "newguy";

			    $to = $email;
			    $subject = "GSR - Game Shark Reviews Account Verification";
			    $headers  = "MIME-Version: 1.0" . PHP_EOL;
			    $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"" . PHP_EOL;
			    $headers .= "From: GSR (Game Shark Reviews) <noreply@gamesharkreviews.com>" . PHP_EOL;

			    $message = '<html><body style="font-family:Sans-serif;">';
			    $message .= '<p style="color:#000000;font-size:12px;">';
			    $message .= 'Dear ' . $firstname . ',<br><br>';
			    $message .= 'Thank you for taking the time to sign up to GSR.<br>';
			    $message .= 'Please click on the verification link below to verify your email address to your account,<br>';
			    $message .= 'if you require assistance please contact us.<br><br>';
			    $message .= "<a href='http://www.gamesharkreviews.com/account_verification.php?a=" . $email . "&h=" . $verification . "'>http://www.gamesharkreviews.com/account_verification.php?a=" . $email . "&h=" . $verification . "</a><br><br><br>";
			    $message .= 'We apologise in advance for any problems with the website due to ongoing construction.<br><br><br>';
			    $message .= 'Sincerely,<br><br>GSR - Game Shark Reviews';
			    $message .= '</p>';
			    $message .= "</body></html>";

			    ini_set('sendmail_from',$email);
			    mail($to, $subject, $message, $headers);
			    ini_restore('sendmail_from');
			}
		}
	}

?>