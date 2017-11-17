change_profile_image<?php

include "mysql_con.php";

session_start();

if(isset($_GET['update'])) {
  $UP_getxbox = mysqli_real_escape_string($con, $_GET['xbox']);
  $UP_getplaystation = mysqli_real_escape_string($con, $_GET['playstation']);
  $UP_getsteam = mysqli_real_escape_string($con, $_GET['steam']);
  $UP_console = mysqli_real_escape_string($con, $_GET['console']);
  $UP_getgame = mysqli_real_escape_string($con, $_GET['game']);
  $UP_getquote = mysqli_real_escape_string($con, $_GET['quote']);
  $UP_getbio = mysqli_real_escape_string($con, $_GET['bio']);
  $UP_gettown = mysqli_real_escape_string($con, $_GET['town']);
  $UP_getcountry = mysqli_real_escape_string($con, $_GET['country']);
  $UP_getwebsite = mysqli_real_escape_string($con, $_GET['website']);
  $UP_getfacebook = mysqli_real_escape_string($con, $_GET['facebook']);
  $UP_gettwitter = mysqli_real_escape_string($con, $_GET['twitter']);
  $UP_getgoogleplus = mysqli_real_escape_string($con, $_GET['googleplus']);
  $UP_username = mysqli_real_escape_string($con, $_GET['update']);

  if(empty($UP_getxbox)) { $UP_xbox = "undefined"; } else { $UP_xbox = $UP_getxbox; }
  if(empty($UP_getplaystation)) { $UP_playstation = "undefined"; } else { $UP_playstation = $UP_getplaystation; }
  if(empty($UP_getsteam)) { $UP_steam = "undefined"; } else { $UP_steam = $UP_getsteam; }
  if(empty($UP_getgame)) { $UP_game = "undefined"; } else { $UP_game = $UP_getgame; }
  if(empty($UP_getquote)) { $UP_quote = "Greetings outlander."; } else { $UP_quote = mysqli_real_escape_string($con, $UP_getquote); }
  if(empty($UP_getbio)) { $UP_bio = "If I had a dollar for every time someone asked to hear my story I would have a dollar... Maybe less."; } else { $UP_bio = mysqli_real_escape_string($con, $UP_getbio); }
  if(empty($UP_gettown)) { $UP_town = "undefined"; } else { $UP_town = $UP_gettown; }
  if(empty($UP_getcountry)) { $UP_country = "undefined"; } else { $UP_country = $UP_getcountry; }
  if(empty($UP_getwebsite)) { $UP_website = "undefined"; } else { $UP_website = $UP_getwebsite; }
  if(empty($UP_getfacebook)) { $UP_facebook = "undefined"; } else { $UP_facebook = $UP_getfacebook; }
  if(empty($UP_gettwitter)) { $UP_twitter = "undefined"; } else { $UP_twitter = $UP_gettwitter; }
  if(empty($UP_getgoogleplus)) { $UP_googleplus = "undefined"; } else { $UP_googleplus = $UP_getgoogleplus; }

  if($_SESSION['username']==$UP_username){
    $UPDATEinfo = mysqli_query($con, "UPDATE tbl_accounts SET xbox = '$UP_xbox', playstation = '$UP_playstation', steam = '$UP_steam', console = '$UP_console', game = '$UP_game', quote = '$UP_quote', biography = '$UP_bio', town = '$UP_town', country = '$UP_country', website = '$UP_website', facebook = '$UP_facebook', twitter = '$UP_twitter', googleplus = '$UP_googleplus' WHERE username = '$UP_username'");
    if($UPDATEinfo) {
      echo "true";
    } else {
      echo "false";
    }
  }else{
    echo "false";
  }
}

if(isset($_POST['uploadIMG'])) {

  $IMG_username   = $_POST['uploadIMG'];
  $IMG_path       = $_SERVER['DOCUMENT_ROOT'] . "/imgs/users/";
  $LRG_max_height = 270;
  $SML_max_height = 135;
  $LRG_max_width  = 232;
  $SML_max_width  = 116;

  if(empty($_FILES['sharkface']['name'])) {
    header("Location: settings.php?change_profile_image=file_empty");
    die("NO FILE");
  }

  $IMG_name = $_FILES['sharkface']['name'];
  $IMG_size = $_FILES['sharkface']['size'];
  $IMG_temp = $_FILES['sharkface']['tmp_name'];

  if($IMG_size > 1048576) {
    header("Location: settings.php?change_profile_image=filesize_error");
    die("IMAGE TOO LARGE");
  }

  $IMG_size_info = getimagesize($IMG_temp);

  if($IMG_size_info) {
    $IMG_width  = $IMG_size_info[0];
    $IMG_height = $IMG_size_info[1];
    $IMG_type   = $IMG_size_info['mime'];
  } else {
    header("Location: settings.php?change_profile_image=file_invalid");
    die("FILE INVALID");
  }

  $IMG_res = imagecreatefromjpeg($IMG_temp);

  if($IMG_res) {
    $IMG_info           = pathinfo($IMG_name);
    $IMG_extension      = strtolower($IMG_info['extension']);
    $IMG_name_only      = strtolower($IMG_info['filename']);

    $IMG_set_name       = $IMG_username . "_" . md5($IMG_name_only);

    $LRG_file_name      = $IMG_set_name . "-232x270." . $IMG_extension;
    $SML_file_name      = $IMG_set_name . "-116x135." . $IMG_extension;

    $LRG_save_folder    = $IMG_path . $LRG_file_name;
    $SML_save_folder    = $IMG_path . $SML_file_name;

    if($IMG_width <= 0 || $IMG_height <= 0) { return false; }

    $LRG_offset_y = ($IMG_height / 2) - ($IMG_height / 2);
    $LRG_offset_x = ($IMG_width / 2) - ($IMG_width / 2);

    $LRG_canvas = imagecreatetruecolor($LRG_max_width, $LRG_max_height);

    $LRG_resample = imagecopyresampled($LRG_canvas, $IMG_res, 0, 0, $LRG_offset_x, $LRG_offset_y, $LRG_max_width, $LRG_max_height, $IMG_width, $IMG_height);

    if($LRG_resample) {

      if($IMG_width <= 0 || $IMG_height <= 0) { return false; }

      $SML_offset_y = ($IMG_height / 2) - ($IMG_height / 2);
      $SML_offset_x = ($IMG_width / 2) - ($IMG_width / 2);

      $SML_canvas = imagecreatetruecolor($SML_max_width, $SML_max_height);

      $SML_resample = imagecopyresampled($SML_canvas, $IMG_res, 0, 0, $SML_offset_x, $SML_offset_y, $SML_max_width, $SML_max_height, $IMG_width, $IMG_height);
    }

    if(imagejpeg($LRG_canvas, $LRG_save_folder, 100) && imagejpeg($SML_canvas, $SML_save_folder, 100)) {

      imagedestroy($IMG_res);

      $IMG_upload = mysqli_query($con, "UPDATE tbl_accounts SET picture = '$IMG_set_name' WHERE username = '$IMG_username'");

      header("Location: settings.php?change_profile_image=upload_successful");
    }

  } else {
    die("FAILURE");
  }

}

if(isset($_GET['reimage'])) {
  mysqli_query($con, "UPDATE tbl_accounts SET picture = '" . $_GET['oldimage'] . "' WHERE username = '" . $_GET['oldimageuser'] . "'");
}

if(isset($_POST['upload_cover'])) {

  $cover_username   = $_POST['upload_cover'];
  $cover_path       = $_SERVER['DOCUMENT_ROOT'] . "/imgs/users/";
  $cover_max_height = 315;
  $cover_max_width  = 851;

  if(empty($_FILES['sharkcover']['name'])) {
    header("Location: settings.php?change_cover_image=file_empty");
    die("NO FILE");
  }

  $cover_name = $_FILES['sharkcover']['name'];
  $cover_size = $_FILES['sharkcover']['size'];
  $cover_temp = $_FILES['sharkcover']['tmp_name'];

  if($cover_size > 1048576) {
    header("Location: settings.php?change_cover_image=filesize_error");
    die("IMAGE TOO LARGE");
  }

  $cover_size_info = getimagesize($cover_temp);

  if($cover_size_info) {
    $cover_width  = $cover_size_info[0];
    $cover_height = $cover_size_info[1];
    $cover_type   = $cover_size_info['mime'];
  } else {
    header("Location: settings.php?change_cover_image=file_invalid");
    die("FILE INVALID");
  }

  $cover_res = imagecreatefromjpeg($cover_temp);

  if($cover_res) {
    $cover_info           = pathinfo($cover_name);
    $cover_extension      = strtolower($cover_info['extension']);
    $cover_name_only      = strtolower($cover_info['filename']);

    $cover_set_name       = $cover_username . "_" . md5($cover_name_only);

    $cover_file_name      = $cover_set_name . "-851x315." . $cover_extension;

    $cover_save_folder    = $cover_path . $cover_file_name;

    if($cover_width <= 0 || $cover_height <= 0) { return false; }

    $cover_offset_y = ($cover_height / 2) - ($cover_height / 2);
    $cover_offset_x = ($cover_width / 2) - ($cover_width / 2);

    $cover_canvas = imagecreatetruecolor($cover_max_width, $cover_max_height);

    $cover_resample = imagecopyresampled($cover_canvas, $cover_res, 0, 0, $cover_offset_x, $cover_offset_y, $cover_max_width, $cover_max_height, $cover_width, $cover_height);

    if(imagejpeg($cover_canvas, $cover_save_folder, 100)) {

      imagedestroy($cover_res);

      $cover_upload = mysqli_query($con, "UPDATE tbl_accounts SET cover_pic = '$cover_set_name' WHERE username = '$cover_username'");

      header("Location: settings.php?change_cover_image=upload_successful");
    }

  } else {
    die("FAILURE");
  }

}

if(isset($_GET['reimage'])) {
  mysqli_query($con, "UPDATE tbl_accounts SET picture = '" . $_GET['oldimage'] . "' WHERE username = '" . $_GET['oldimageuser'] . "'");
}

if(isset($_GET['apply'])) {

  $ACC_username = mysqli_real_escape_string($con, $_GET['apply']);

  $ACC_firstname = mysqli_real_escape_string($con, $_GET['firstname']);
  $ACC_lastname = mysqli_real_escape_string($con, $_GET['lastname']);
  $ACC_password = mysqli_real_escape_string($con, sha1(md5($_GET['newpassword'])));
  $ACC_email = mysqli_real_escape_string($con, $_GET['email']);
  $ACC_question = mysqli_real_escape_string($con, $_GET['securityquestion']);
  $ACC_answer = mysqli_real_escape_string($con, $_GET['securityanswer']);
  $ACC_showYN = mysqli_real_escape_string($con, intval($_GET['showname']));

  $getOPW = mysqli_query($con, "SELECT * FROM tbl_users WHERE username = '$ACC_username'");
  while ($oldpwROW = mysqli_fetch_array($getOPW)) {
    $origPW 	 	= $oldpwROW['password'];
  }


  if($ACC_password=="67a74306b06d0c01624fe0d0249a570f4d093747"){
    $ACC_password = $origPW;
  }

  if($ACC_showYN == 1) {
    $ACC_showname = 1;
  } else {
    $ACC_showname = 0;
  }

  if($_SESSION['username']==$ACC_username){
    mysqli_query($con, "UPDATE tbl_accounts SET firstname = '$ACC_firstname', lastname = '$ACC_lastname', showname = $ACC_showname WHERE username = '$ACC_username'");
    mysqli_query($con, "UPDATE tbl_users SET password = '$ACC_password', email = '$ACC_email', sec_question = '$ACC_question', sec_answer = '$ACC_answer' WHERE username = '$ACC_username'");
  }else{
    echo "false";
  }


}
?>
