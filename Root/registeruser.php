<?php
    include "mysql_con.php";

    if(isset($_GET['social_user'])){$social_user = json_decode(base64_decode($_GET['social_user']));}else{$social_user = false;}
    if(isset($_GET['auth_type'])){$auth_type = $_GET['auth_type'];}else{$auth_type = false;}
    $uid       = $social_user->uid;

    $FSfnam = mysqli_real_escape_string($con, $_GET['firstname']);
    $FSlnam = mysqli_real_escape_string($con, $_GET['lastname']);
    $FSunam = mysqli_real_escape_string($con, $_GET['username_individual']);
    $FSmail = mysqli_real_escape_string($con, $_GET['email_individual']);
    $FSquestion = mysqli_real_escape_string($con, $_GET['securityquestion_individual']);
    $FSanswer = mysqli_real_escape_string($con, $_GET['securityanswer_individual']);
    $FSpass = mysqli_real_escape_string($con, sha1(md5($_GET['password_individual'])));

    $FSsinc = date('Y-m-d H:i:s');

    $FSveri = md5($FSmail . $FSunam);

    $FSregA = "INSERT INTO tbl_users (username, email, verify, password, sec_question, sec_answer, online) VALUES ('$FSunam', '$FSmail', '$FSveri', '$FSpass', '$FSquestion', '$FSanswer', 'ONLINE')";

    $FSregB = "INSERT INTO tbl_accounts (username, firstname, lastname, showname, xbox, playstation, steam, console, game, quote, biography, rank, since, town, country, website, facebook, twitter, googleplus, level, xp, picture, badges, favourites, friends, clan, clantime)
                VALUES ('$FSunam', '$FSfnam', '$FSlnam', 'false', 'undefined', 'undefined', 'undefined', 'undefined', 'undefined', 'Greetings outlander.', 'If I had a dollar for every time someone asked to hear my story I would have a dollar... Maybe less.', 0, '$FSsinc', 'undefined', 'undefined', 'undefined', 'undefined', 'undefined', 'undefined', '1', '0', '', '', '', '', '', '')";

    mysqli_query($con, $FSregA) or die("COULDN'T RUN");


    if($auth_type=="facebook"){
        mysqli_query($con, "UPDATE tbl_users SET fb_uid = '".$uid."' WHERE username = '$FSunam'");
    }

    if($auth_type=="twitter"){
        mysqli_query($con, "UPDATE tbl_users SET twitter_uid = '".$uid."' WHERE username = '$FSunam'");
    }

    if($auth_type=="google"){
        mysqli_query($con, "UPDATE tbl_users SET gplus_uid = '".$uid."' WHERE username = '$FSunam'");
    }

    mysqli_query($con, $FSregB) or die("COULDN'T RUN");

    $to = $FSmail;
    $subject = "GSR - Game Shark Reviews Account Verification";
    $headers  = "MIME-Version: 1.0" . PHP_EOL;
    $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"" . PHP_EOL;
    $headers .= "From: GSR (Game Shark Reviews) <noreply@gamesharkreviews.com>" . PHP_EOL;

    $message = '<html><body style="font-family:Sans-serif;">';
    $message .= '<p style="color:#000000;font-size:12px;">';
    $message .= 'Dear ' . $FSfnam . ',<br><br>';
    $message .= 'Thank you for taking the time to sign up to GSR.<br>';
    $message .= 'Please click on the verification link below to verify your email address to your account,<br>';
    $message .= 'if you require assistance please contact us.<br><br>';
    $message .= "<a href='http://www.gamesharkreviews.com/account_verification.php?a=" . $FSmail . "&h=" . md5($FSmail . $FSunam) . "'>http://www.gamesharkreviews.com/account_verification.php?a=" . $FSmail . "&h=" . md5($FSmail . $FSunam) . "</a><br><br><br>";
    $message .= 'We apologise in advance for any problems with the website due to ongoing construction.<br><br><br>';
    $message .= 'Sincerely,<br><br>GSR - Game Shark Reviews';
    $message .= '</p>';
    $message .= "</body></html>";

    ini_set('sendmail_from',$FSmail);
    mail($to, $subject, $message, $headers);
    ini_restore('sendmail_from');

?>