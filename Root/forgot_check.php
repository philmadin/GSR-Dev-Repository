<?php

    include "mysql_con.php";

    session_start();

    $GETemailPASS = $_GET['email_pw'];
    $GETemailUSER = $_GET['email_user'];
    $GETusernamePASS = $_GET['username_pw'];
    $GETanswerKEY = strtolower($_GET['answer_key']);
    $GETcheckKEY = $_GET['answer_key_check'];
    $GETkeyKEY = $_GET['key_key'];
    $GETpasswordKEY = sha1(md5($_GET['pass_key']));
	

    if(isset($GETusernamePASS)) {
        $usernamePASSqry = mysqli_query($con, "SELECT username FROM tbl_users WHERE username = '$GETusernamePASS'");

        if(mysqli_num_rows($usernamePASSqry) == 0) {
            echo "false";
        } else { echo "true"; }
    }


    if(isset($GETemailPASS)) {
        $emailPASSqry = mysqli_query($con, "SELECT username FROM tbl_users WHERE email = '$GETemailPASS'");

        if(mysqli_num_rows($emailPASSqry) == 0) {
            echo "false";
        } else { echo "true"; }
    }
	
	
    if(isset($GETemailUSER)) {
        $emailUSERqry = mysqli_query($con, "SELECT username FROM tbl_users WHERE email = '$GETemailUSER'");

        if(mysqli_num_rows($emailUSERqry) == 0) {
            echo "false";
        } else { echo "true"; }
    }

    if(isset($GETkeyKEY)) {
        $keyKEYqry = mysqli_query($con, "SELECT * FROM tbl_resets WHERE unique_key = '$GETkeyKEY'");

        if(mysqli_num_rows($keyKEYqry) == 0) {
            echo "false";
        } else { echo "true"; }
    }
	
	
    if(isset($GETanswerKEY)) {
    if(isset($GETcheckKEY)) {
		
        $checkKEYqry = mysqli_query($con, "SELECT * FROM tbl_resets WHERE unique_key = '$GETcheckKEY'");
			if(mysqli_num_rows($checkKEYqry)>0){
			while ($keyInfo = mysqli_fetch_array($checkKEYqry)) {
			$keyUser = $keyInfo['user'];
			}
			$userQRY = mysqli_query($con, "SELECT * FROM tbl_users WHERE username = '$keyUser'");
			while($SUQRY = mysqli_fetch_array($userQRY)) {
			$key_answer = strtolower($SUQRY['sec_answer']);
			
			if($GETanswerKEY==$key_answer){echo "true";}
			else{echo "false";}
			
			}
		
    }
    }
	}

?>