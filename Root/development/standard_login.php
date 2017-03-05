<?php
	
	session_start();

	include "mysql_con.php";

	$username = $_GET['username'];
	$password = $_GET['password'];

	// FUNCTION TO MATCH RECEIVED PASSWORD WITH DATABASE PASSWORD
	function verify($pass, $hashedPassword) {
		return crypt($pass, $hashedPassword) == $hashedPassword;
	}

	if(empty($username) && empty($password)) { echo "false"; }
	else if(empty($username)) { echo "u_false"; }
	else if(empty($password)) { echo "p_false"; }
	else {

		$stnd_login = mysqli_query($con, "SELECT username, password FROM tbl_users WHERE username = '$username'");

		if(mysqli_num_rows($stnd_login) < 1) {
			echo "nope";
		} else {

			while($stnd_fetch = mysqli_fetch_assoc($stnd_login)) {
				$realpass = $stnd_fetch['password'];
			}

			$verifiedhash = verify($password, $realpass);

			if($verifiedhash == 1) {
				echo "login!";
			} else {
				echo "nope";
			}

		}
	}

?>