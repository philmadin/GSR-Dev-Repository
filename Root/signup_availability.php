<?php

    include "mysql_con.php";

    session_start();

    $GETuserINDIV = $_GET['username_individual'];
    $GETemailINDIV = $_GET['email_individual'];
    $GETuserCOMPA = $_GET['username_company'];
    $GETemailCOMPA = $_GET['email_company'];

    $GETemail = $_GET['email'];
    $GETpass = $_GET['oldpassword'];

    $SUB_title = $_GET['articletitle'];
    $SUB_opiniontitle = $_GET['articleopiniontitle'];
    $SUB_newstitle = $_GET['articlenewstitle'];
    $SUB_guidetitle = $_GET['articleguidetitle'];

    $IMG_a = $_FILES['aimage'];
    $IMG_b = $_FILES['bimage'];
    $IMG_c = $_FILES['cimage'];
    $IMG_d = $_FILES['dimage'];
    $IMG_e = $_FILES['eimage'];

    if(isset($GETuserINDIV)) {
        $userINDIVqry = mysqli_query($con, "SELECT username FROM tbl_users WHERE username = '$GETuserINDIV'");

        if(mysqli_num_rows($userINDIVqry) != 0) {
            echo "false";
        } else { echo "true"; }
    }

    if(isset($GETemailINDIV)) {
        $emailINDIVqry = mysqli_query($con, "SELECT email FROM tbl_users WHERE email = '$GETemailINDIV'");

        if(mysqli_num_rows($emailINDIVqry) != 0) {
            echo "false";
        } else { echo "true"; }
    }

    if(isset($GETuserCOMPA)) {
        $userCOMPAqry = mysqli_query($con, "SELECT username FROM tbl_users WHERE username = '$GETuserCOMPA'");

        if(mysqli_num_rows($userCOMPAqry) != 0) {
            echo "false";
        } else { echo "true"; }
    }

    if(isset($GETemailCOMPA)) {
        $emailCOMPAqry = mysqli_query($con, "SELECT email FROM tbl_users WHERE email = '$GETemailCOMPA'");

        if(mysqli_num_rows($emailCOMPAqry) != 0) {
            echo "false";
        } else { echo "true"; }
    }

    if(isset($GETemail)) {
        $emailqry = mysqli_query($con, "SELECT email FROM tbl_users WHERE email = '$GETemail'");

        if(mysqli_num_rows($emailqry) != 0) {
            $emailqryB = mysqli_query($con, "SELECT email FROM tbl_users WHERE email = '$GETemail' AND username = '" . $_SESSION['username'] . "'");

            if(mysqli_num_rows($emailqryB) != 0) {
                echo "true";
            } else {
                echo "false";
            }
        } else {
            echo "true";
        }
    }

    if(isset($GETpass)) {
        $passqry = mysqli_query($con, "SELECT password FROM tbl_users WHERE password = '" . sha1(md5($GETpass)) . "' AND username = '" . $_SESSION['username'] . "'");

        if(mysqli_num_rows($passqry) == 0) {
            echo "false";
        } else { echo "true"; }
    }

    if(isset($SUB_title)) {
        $sub_title_qry = mysqli_query($con, "SELECT title FROM tbl_review WHERE title = '$SUB_title' AND alpha_approved = 'true'");

        if(mysqli_num_rows($sub_title_qry) == 0) {
            echo "true";
        } else { echo "false"; }
    }

    if(isset($SUB_opiniontitle)) {
        $sub_optitle_qry = mysqli_query($con, "SELECT title FROM tbl_opinion WHERE title = '$SUB_opiniontitle' AND alpha_approved = 'true'");

        if(mysqli_num_rows($sub_optitle_qry) == 0) {
            echo "true";
        } else { echo "false"; }
    }

    if(isset($SUB_newstitle)) {
        $sub_optitle_qry = mysqli_query($con, "SELECT title FROM tbl_news WHERE title = '$SUB_newstitle' AND alpha_approved = 'true'");

        if(mysqli_num_rows($sub_optitle_qry) == 0) {
            echo "true";
        } else { echo "false"; }
    }

    if(isset($SUB_guidetitle)) {
        $sub_guidetitle_qry = mysqli_query($con, "SELECT title FROM tbl_guide WHERE title = '$SUB_guidetitle' AND alpha_approved = 'true'");

        if(mysqli_num_rows($sub_guidetitle_qry) == 0) {
            echo "true";
        } else { echo "false"; }
    }

?>