<?php

include "mysql_con.php";

session_start();

function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

if(isset($_POST['submit'])) {
    	$SUBMIT_articletype     = $_POST['articletype'];
    	$SUBMIT_articletitle    = $_POST['articlenewstitle'];
    	$SUBMIT_main    		= $_POST['main'];
    	$SUBMIT_content       = $_POST['main'];
	$SUBMIT_content       = iconv('UTF-8', 'ASCII//TRANSLIT', $SUBMIT_content); 
	$SUBMIT_content       = htmlentities($SUBMIT_content, ENT_QUOTES); 
    	$SUBMIT_tags            = mysqli_real_escape_string($con, $_POST['tags']);
    	$SUBMIT_trailer         = $_POST['trailer'];
    	$main_file          = "texts/news/" . clean($SUBMIT_articletitle) . "_main.txt";
    	$open_main          = fopen($main_file, "w+");
    	$write_main         = fwrite($open_main, $SUBMIT_main);
    	$close_main         = fclose($open_main);
    	$SUBMIT_username        = $_POST['submit'];
    	$main_file          = mysqli_real_escape_string($con, $main_file);


    if(isset($_POST['articlesubmitas'])){$SUBMIT_username=$_POST['articlesubmitas'];}

    $author_qry = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$SUBMIT_username'");

    while ($aROW = mysqli_fetch_assoc($author_qry)) {
        $SUBMIT_firstname   = mysqli_real_escape_string($con, $aROW['firstname']);
        $SUBMIT_lastname    = mysqli_real_escape_string($con, $aROW['lastname']);
        $SUBMIT_posa        = $aROW['posa'];
        $SUBMIT_posb        = $aROW['posb'];
        $SUBMIT_position    = $SUBMIT_posa . " " . $SUBMIT_posb;
        $SUBMIT_author      = $SUBMIT_firstname . " " . $SUBMIT_lastname;
    }

    $SUBMIT_date            = date('Y-m-d H:i:s');
    $SUBMIT_year            = date('Y');
    $SUBMIT_month           = date('M');
    $ifbossa = "false";
    $ifbossb = "false";

    $SUBMIT_articletitle    = mysqli_real_escape_string($con, $_POST['articlenewstitle']);
    if(!mysqli_query($con, "INSERT INTO tbl_news (article_type, trailer, title, main, Content, author, authuser, createdate, month, year, pending, beta_approved, alpha_approved, editors_choice, tags) 
		VALUES ('$SUBMIT_articletype', '$SUBMIT_trailer', '".mysqli_real_escape_string($con, $SUBMIT_articletitle)."', '$main_file', '$SUBMIT_content', '$SUBMIT_author', '$SUBMIT_username', '$SUBMIT_date', '$SUBMIT_month', '$SUBMIT_year', '$ifbossa', '$ifbossb', 'false', '0', '$SUBMIT_tags')")){
        echo("Error description: " . mysqli_error($con));
    }




}

if(isset($_POST['save'])) {
    	$SUBMIT_articletype     = $_POST['articletype'];
    	$SUBMIT_articletitle    = $_POST['articletitle'];
    	$SUBMIT_main    		= $_POST['main'];
    	$SUBMIT_content       = $_POST['main'];
	$SUBMIT_content       = iconv('UTF-8', 'ASCII//TRANSLIT', $SUBMIT_content); 
	$SUBMIT_content       = htmlentities($SUBMIT_content, ENT_QUOTES); 
    	$SUBMIT_trailer   		= $_POST['trailer'];
    	$SUBMIT_tags            = mysqli_real_escape_string($con, $_POST['tags']);
    	$SUBMIT_id              = $_POST['save'];
    	$SUBMIT_updatedate      = $_POST['updatedate'];

    	$article_query = mysqli_query($con, "SELECT * FROM tbl_news WHERE id = '$SUBMIT_id'");

    while ($SUBROW = mysqli_fetch_assoc($article_query)) {
        $SUBMIT_mainfile = $SUBROW['main'];
    }

    $main_file          = $SUBMIT_mainfile;
    $open_main          = fopen($main_file, "w+");
    $write_main         = fwrite($open_main, $SUBMIT_main);
    $close_main         = fclose($open_main);
    $SUBMIT_username        = $_POST['submit'];
    $main_file          = mysqli_real_escape_string($con, $main_file);

    $SUBMIT_articletitle = mysqli_real_escape_string($con, $SUBMIT_articletitle);

    mysqli_query($con, "UPDATE tbl_news SET article_type = '$SUBMIT_articletype', trailer = '$SUBMIT_trailer', title = '$SUBMIT_articletitle', Content = '$SUBMIT_content', tags = '$SUBMIT_tags' WHERE id = '$SUBMIT_id'");
}

if(isset($_POST['upload_images'])) {

    $upload_id = $_POST['upload_images'];

    $article_query = mysqli_query($con, "SELECT * FROM tbl_news WHERE id = '$upload_id'");

    while ($UPAROW = mysqli_fetch_assoc($article_query)) {
        $UPLOAD_articletype  = preg_replace('/\s+/', "_", $UPAROW['article_type']);
        $UPLOAD_articletitle = preg_replace('/\s+/', "_", $UPAROW['title']);
    }

    $upload_path = $_SERVER['DOCUMENT_ROOT'] . "/imgs/news/";

    $UPLOAD_aimage = $_FILES['aimage'];
    $UPLOAD_bimage = $_FILES['bimage'];
    $UPLOAD_cimage = $_FILES['cimage'];
    $UPLOAD_dimage = $_FILES['dimage'];
    $UPLOAD_eimage = $_FILES['eimage'];

    $aimage_temp = $UPLOAD_aimage['tmp_name'];
    $bimage_temp = $UPLOAD_bimage['tmp_name'];
    $cimage_temp = $UPLOAD_cimage['tmp_name'];
    $dimage_temp = $UPLOAD_dimage['tmp_name'];
    $eimage_temp = $UPLOAD_eimage['tmp_name'];

    $aimage_name = basename($UPLOAD_aimage['name'], ".jpg");
    $bimage_name = basename($UPLOAD_bimage['name'], ".jpg");
    $cimage_name = basename($UPLOAD_cimage['name'], ".jpg");
    $dimage_name = basename($UPLOAD_dimage['name'], ".jpg");
    $eimage_name = basename($UPLOAD_eimage['name'], ".jpg");

    $aimage_info = getimagesize($aimage_temp);

    if($aimage_info) {
        $imagewidth = $aimage_info[0];
        if($imagewidth <= 960) {
            header("Location: articleimages.php?article_images=" . $upload_id . "&upload_error=width&type=news");
        }
    } else {
        header("Location: articleimages.php?article_images=" . $upload_id . "&upload_error=invalid&type=news");
    }

    if(!empty($UPLOAD_aimage['name'])) {
        $aimage_path = clean("GSR-" . $UPLOAD_articletype . "-" . $UPLOAD_articletitle . "-" . md5($aimage_name)) . "-a_image.jpg";
        $aimage_qury = mysqli_query($con, "UPDATE tbl_news SET a_image = '$aimage_path' WHERE id = '$upload_id'");
        $aimage_upld = move_uploaded_file($aimage_temp, $upload_path . $aimage_path);
    }

    if(!empty($UPLOAD_bimage['name'])) {
        $bimage_path = clean("GSR-" . $UPLOAD_articletype . "-" . $UPLOAD_articletitle . "-" . md5($bimage_name)) . "-b_image.jpg";
        $bimage_qury = mysqli_query($con, "UPDATE tbl_news SET b_image = '$bimage_path' WHERE id = '$upload_id'");
        $bimage_upld = move_uploaded_file($bimage_temp, $upload_path . $bimage_path);
    }

    if(!empty($UPLOAD_cimage['name'])) {
        $cimage_path = clean("GSR-" . $UPLOAD_articletype . "-" . $UPLOAD_articletitle . "-" . md5($cimage_name)) . "-c_image.jpg";
        $cimage_qury = mysqli_query($con, "UPDATE tbl_news SET c_image = '$cimage_path' WHERE id = '$upload_id'");
        $cimage_upld = move_uploaded_file($cimage_temp, $upload_path . $cimage_path);
    }

    if(!empty($UPLOAD_dimage['name'])) {
        $dimage_path = clean("GSR-" . $UPLOAD_articletype . "-" . $UPLOAD_articletitle . "-" . md5($dimage_name)) . "-d_image.jpg";
        $dimage_qury = mysqli_query($con, "UPDATE tbl_news SET d_image = '$dimage_path' WHERE id = '$upload_id'");
        $dimage_upld = move_uploaded_file($dimage_temp, $upload_path . $dimage_path);
    }

    if(!empty($UPLOAD_eimage['name'])) {
        $eimage_path = clean("GSR-" . $UPLOAD_articletype . "-" . $UPLOAD_articletitle . "-" . md5($eimage_name)) . "-e_image.jpg";
        $eimage_qury = mysqli_query($con, "UPDATE tbl_news SET e_image = '$eimage_path' WHERE id = '$upload_id'");
        $eimage_upld = move_uploaded_file($eimage_temp, $upload_path . $eimage_path);
    }

    header("Location: articlelist.php?type=news");
}

if(isset($_GET['pending'])) { mysqli_query($con, "UPDATE tbl_news SET pending = 'true' WHERE id = '" . $_GET['pending'] . "'"); }
if(isset($_GET['beta'])) { mysqli_query($con, "UPDATE tbl_news SET beta_approved = 'true' WHERE id = '" . $_GET['beta'] . "'"); }
if(isset($_GET['alpha'])) { mysqli_query($con, "UPDATE tbl_news SET alpha_approved = 'true' WHERE id = '" . $_GET['alpha'] . "'");
    $SUBMIT_date        = date('Y-m-d H:i:s');
    $SUBMIT_year        = date('Y');
    $SUBMIT_month       = date('M');
    mysqli_query($con, "UPDATE tbl_news SET createdate = '$SUBMIT_date', month = '$SUBMIT_month', year = '$SUBMIT_year' WHERE id = '" . $_GET['alpha'] . "'");
}

if(isset($_GET['choice'])) {
    $newChoice  = $_GET['choice'];
    $newId      = $_GET['id'];


    $clear_query = mysqli_query($con, "SELECT * FROM tbl_featured WHERE position = '$newChoice'");
    if(mysqli_num_rows($clear_query) > 0) {
        while ($OLDROW = mysqli_fetch_assoc($clear_query)) {
            $oldID = $OLDROW['id'];
        }
    }
    mysqli_query($con, "UPDATE tbl_featured SET position = '0' WHERE id = '$oldID'");

    mysqli_query($con, "INSERT INTO tbl_featured (article_type, article_id, position) VALUES ('News', $newId, $newChoice)");

}

if(isset($_GET['deny'])) {
    $denyid = $_GET['deny'];
    mysqli_query($con, "UPDATE tbl_news SET alpha_approved = 'false' WHERE id = '$denyid'");
    mysqli_query($con, "UPDATE tbl_news SET beta_approved = 'false' WHERE id = '$denyid'");
    mysqli_query($con, "UPDATE tbl_news SET pending = 'false' WHERE id = '$denyid'");
}

if(isset($_GET['deletionid'])) {
    $deletionid = $_GET['deletionid'];

    $files_query = mysqli_query($con, "SELECT * FROM tbl_news WHERE id = '$deletionid'");

    while ($filesROW = mysqli_fetch_assoc($files_query)) {
        $delete_aimageFILE     = $_SERVER['DOCUMENT_ROOT'] . "imgs/news/" . $filesROW['a_image'];
        $delete_bimageFILE     = $_SERVER['DOCUMENT_ROOT'] . "imgs/news/" . $filesROW['b_image'];
        $delete_cimageFILE     = $_SERVER['DOCUMENT_ROOT'] . "imgs/news/" . $filesROW['c_image'];
        $delete_dimageFILE     = $_SERVER['DOCUMENT_ROOT'] . "imgs/news/" . $filesROW['d_image'];
        $delete_eimageFILE     = $_SERVER['DOCUMENT_ROOT'] . "imgs/news/" . $filesROW['e_image'];

        $delete_mainFILE     = $_SERVER['DOCUMENT_ROOT'] . $filesROW['main'];
    }

    if(file_exists($delete_aimageFILE)) { unlink($delete_aimageFILE); }
    if(file_exists($delete_bimageFILE)) { unlink($delete_bimageFILE); }
    if(file_exists($delete_cimageFILE)) { unlink($delete_cimageFILE); }
    if(file_exists($delete_dimageFILE)) { unlink($delete_dimageFILE); }
    if(file_exists($delete_eimageFILE)) { unlink($delete_eimageFILE); }
    if(file_exists($delete_mainFILE)) { unlink($delete_mainFILE); }

    mysqli_query($con, "DELETE FROM tbl_news WHERE id = '$deletionid'");
}
?>