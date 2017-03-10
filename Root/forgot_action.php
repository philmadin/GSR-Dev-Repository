<?php
    include "mysql_con.php";
	
    $GETemailPASS = $_GET['email_pw'];
    $GETemailUSER = $_GET['email_user'];
    $GETusernamePASS = $_GET['username_pw'];
	$GETanswerKEY = strtolower($_GET['answer_key']);
    $GETkeyKEY = $_GET['key_key'];
    $GETpasswordKEY = sha1(md5($_GET['pass_key']));
	
	if(isset($_GET['forgotpass'])){
		
		$userQRY = mysqli_query($con, "SELECT * FROM tbl_users WHERE email = '$GETemailPASS' AND username = '$GETusernamePASS'");
		while ($getUser = mysqli_fetch_array($userQRY)) {
		$FSuser = $getUser['username'];
		$FSmail = $getUser['email'];
		}
		
	 $FSkey = sha1(md5($FSmail . $FSuser));
		
	$FSregA = "INSERT INTO tbl_resets (user, unique_key, email) VALUES ('$FSuser', '$FSkey', '$FSmail')";

    mysqli_query($con, $FSregA) or die(mysqli_error($con));


    $to = $FSmail;
    $subject = "GSR - Game Shark Reviews Password Reset";
    $headers  = "MIME-Version: 1.0" . PHP_EOL;
    $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"" . PHP_EOL;
    $headers .= "From: GSR (Game Shark Reviews) <noreply@gamesharkreviews.com>" . PHP_EOL;

    $message = '<html><body style="font-family:Sans-serif;">';
    $message .= '<p style="color:#000000;font-size:12px;">';
    $message .= 'Dear ' . $FSuser . ',<br><br>';
    $message .= 'We received a password reset request on Game Shark Reviews (GSR) for '.$FSmail.'.<br>';
    $message .= 'Please click on the link below to reset the password to your account,<br>';
    $message .= 'If you require further support please contact us.<br><br>';
    $message .= "<a href='http://gamesharkreviews.com/forgot.php?type=key&key=".$FSkey."'>http://gamesharkreviews.com/forgot.php?type=key&key=".$FSkey."</a><br><br><br>";
    $message .= 'Sincerely,<br><br>GSR - Game Shark Reviews';
    $message .= '</p>';
    $message .= "</body></html>";

    ini_set('sendmail_from',$FSmail);
    mail($to, $subject, $message, $headers);
    ini_restore('sendmail_from');
	}	
	
	if(isset($_GET['forgotuser'])){
		
		$userQRY = mysqli_query($con, "SELECT * FROM tbl_users WHERE email = '$GETemailUSER'");
		while ($getUser = mysqli_fetch_array($userQRY)) {
		$FSuser = $getUser['username'];
		$FSmail = $getUser['email'];
		}


    $to = $FSmail;
    $subject = "GSR - Game Shark Reviews Usernames";
    $headers  = "MIME-Version: 1.0" . PHP_EOL;
    $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"" . PHP_EOL;
    $headers .= "From: GSR (Game Shark Reviews) <noreply@gamesharkreviews.com>" . PHP_EOL;

    $message = '<html><body style="font-family:Sans-serif;">';
    $message .= '<p style="color:#000000;font-size:12px;">';
    $message .= 'Dear ' . $FSuser . ',<br><br>';
    $message .= 'We received a username request on Game Shark Reviews (GSR) for '.$FSmail.'.<br>';
    $message .= 'Here are a list of usernames linked to this email address: <br>';
	$message .= '<ul>';
		$usersQRY = mysqli_query($con, "SELECT * FROM tbl_users WHERE email = '$GETemailUSER'");
		while ($getUsers = mysqli_fetch_array($usersQRY)) {
		$FSusers = $getUsers['username'];
		$message .= '<li>'.$FSusers.'</li>';
		}
	$message .= '</ul>';
    $message .= 'If you require further support please contact us.<br><br>';
    $message .= 'Sincerely,<br><br>GSR - Game Shark Reviews';
    $message .= '</p>';
    $message .= "</body></html>";

    ini_set('sendmail_from',$FSmail);
    mail($to, $subject, $message, $headers);
    ini_restore('sendmail_from');
	}
	
	if(isset($_GET['forgotkey'])){
		
	        $checkKEYqry = mysqli_query($con, "SELECT * FROM tbl_resets WHERE unique_key = '$GETkeyKEY'");
			if(mysqli_num_rows($checkKEYqry)>0){
			while ($keyInfo = mysqli_fetch_array($checkKEYqry)) {
			$keyUser = $keyInfo['user'];
			}
			}
			$updatePW = "UPDATE tbl_users SET password = '$GETpasswordKEY' WHERE username = '$keyUser'";
			if (!mysqli_query($con, $updatePW)) {
			echo mysqli_error($con);
			}
			$deleteKEY = "DELETE FROM tbl_resets WHERE user = '$keyUser' AND unique_key = '$GETkeyKEY'";
			if (!mysqli_query($con, $deleteKEY)) {
			echo mysqli_error($con);
			}
		
	}

	

?>