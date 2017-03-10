<?php
    include "mysql_con.php";

    $FScnam = mysqli_real_escape_string($con, $_GET['companyname']);
    $FSunam = mysqli_real_escape_string($con, $_GET['username_company']);
    $FSwebs = mysqli_real_escape_string($con, $_GET['website']);
    $FSmail = mysqli_real_escape_string($con, $_GET['email_company']);
    $FSquestion = mysqli_real_escape_string($con, $_GET['securityquestion_company']);
    $FSanswer = mysqli_real_escape_string($con, $_GET['securityanswer_company']);
    $FSpass = mysqli_real_escape_string($con, sha1(md5($_GET['password_company'])));

    $FSsinc = date('Y-m-d H:i:s');

    $FSregA = "INSERT INTO tbl_users (username, email, password, gameshark, sec_question, sec_answer) VALUES ('$FSunam', '$FSmail', '$FSpass', 'false', '$FSquestion', '$FSanswer')";

    $FSregB = "INSERT INTO tbl_companies (username, coname, postage, address, town, country, since, quote, bio, website, level, exp, picture, coverphoto, cotype, badges)
                VALUES ('$FSunam', '$FScnam', 'undefined', 'undefined', 'undefined', 'undefined', '$FSsinc', 'undefined', 'undefined', '$FSwebs', '1', '0', '', '', 'Online Enterprise', '')";

    mysqli_query($con, $FSregA);

    mysqli_query($con, $FSregB);

    setcookie('username', $FSunam, time() + (86400 * 30), "/");
    $_SESSION['username'] = $FSunam;
?>