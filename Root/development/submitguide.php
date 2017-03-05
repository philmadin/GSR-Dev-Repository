<?php

    include "mysql_con.php";

    session_start();
	
function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function implode_multi($arr, $join, $key){
    $temp_ar = array();
    foreach($arr as $arr_item){
        array_push($temp_ar, $arr_item->$key);
    }
    return implode($join, $temp_ar);
}

    if(isset($_POST['submit'])) {
        $SUBMIT_articletype     = $_POST['articletype'];
        $SUBMIT_game            = mysqli_real_escape_string($con, $_POST['gamename']);
        $SUBMIT_gameid          = mysqli_real_escape_string($con, $_POST['gameid']); //ADDED THIS
        $SUBMIT_articletitle    = $_POST['articleguidetitle'];
        $SUBMIT_intro   	= $_POST['intro'];
        $SUBMIT_tags            = mysqli_real_escape_string($con, $_POST['tags']);
	$SUBMIT_username     	= $_POST['submit'];

        $g = file_get_contents("http://gamesharkreviews.com/api/games?id=".$SUBMIT_gameid);
        $games = json_decode($g);
        if (isset($games->{0}->title) && $games->{0}->title==$SUBMIT_game){
            $game = $games->{0};
            $SUBMIT_gameid          = $game->id;
        }
        if (!isset($games->{0}->title) || $games->{0}->title!=$SUBMIT_game){
            $sql = "INSERT INTO tbl_games (title) VALUES ('$SUBMIT_game')";

            if (!mysqli_query($con, $sql)) {

            }
            $game_id = mysqli_insert_id($con);
            $SUBMIT_gameid = $game_id;

            $sql = array();


            $sql[] = "UPDATE tbl_games SET title='$SUBMIT_game' WHERE id=" . mysqli_real_escape_string($con, $game_id);
            $sql[] = "UPDATE tbl_games SET approved=0 WHERE id=" . mysqli_real_escape_string($con, $game_id);

            foreach ($sql as $sqli) {
                if (!mysqli_query($con, $sqli)) {

                }
            }
        }

		if (isset($_POST['article_checklist'])) {
			$SUBMIT_checklist = mysqli_real_escape_string($con, $_POST['guide_checklist']);
		}


		else{
			$SUBMIT_checklist = '';
		}
		$step_array = array();
		$step_content_array = [];
		$step_num = 0;
		foreach($_POST["step"] as $key => $step_text){
			if(!empty($step_text) && $step_text!=""){
				$step_num++;
				$step_file          = "texts/guide/" . clean($SUBMIT_articletitle) . "_step_".$step_num.".txt";
	        		$open_step          = fopen($step_file, "w+");
	        		$write_step         = fwrite($open_step, $step_text);
	        		$close_step         = fclose($open_step);
				$step_file          = mysqli_real_escape_string($con, $step_file);
				array_push($step_array, $step_file);
				array_push($step_content_array, $step_text);
			}
		}
		
		$step_files = serialize($step_array);

        	$intro_file          = "texts/guide/" . clean($SUBMIT_articletitle) . "_intro.txt";
        	$open_intro          = fopen($intro_file, "w+");
        	$write_intro         = fwrite($open_intro, $SUBMIT_intro);
        	$close_intro         = fclose($open_intro);
		$intro_file          = mysqli_real_escape_string($con, $intro_file);

		
		if(isset($_POST['articlesubmitas'])){$SUBMIT_username=$_POST['articlesubmitas'];}

	        $author_qry = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$SUBMIT_username'");
	        $SUBMIT_author = null;
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

		$SUBMIT_articletitle    = mysqli_real_escape_string($con, strip_tags($_POST['articleguidetitle']));
        mysqli_query($con, "INSERT INTO tbl_guide (article_type, game_id, title, intro, checklist, steps, author, authuser, createdate, month, year, pending, beta_approved, alpha_approved, editors_choice, tags, step_count) 
		VALUES ('$SUBMIT_articletype', '$SUBMIT_gameid', '$SUBMIT_articletitle', '$intro_file', '$SUBMIT_checklist', '$step_files', '$SUBMIT_author', '$SUBMIT_username', '$SUBMIT_date', '$SUBMIT_month', '$SUBMIT_year', '$ifbossa', '$ifbossb', 'false', '0', '$SUBMIT_tags', '$step_num')");
        	$identifier = mysqli_insert_id($con);
        	mysqli_query($con, "INSERT INTO tbl_guide_content (articleidFK, Content) VALUES ('$identifier', '$SUBMIT_intro')");
		foreach($step_content_array as $content){
        		mysqli_query($con, "INSERT INTO tbl_guide_content (articleidFK, Content) VALUES ('$identifier', '$content')");		
		}
    
		
	
	}

    if(isset($_POST['save'])) {
        $SUBMIT_articletype     = $_POST['articletype'];
        $SUBMIT_articletitle    = $_POST['articleguidetitle'];
        $SUBMIT_intro   		= $_POST['intro'];
        $SUBMIT_tags            = mysqli_real_escape_string($con, $_POST['tags']);
        $SUBMIT_id              = $_POST['save'];
        $SUBMIT_updatedate      = $_POST['updatedate'];
		
		if (isset($_POST['article_checklist'])) {
			$SUBMIT_checklist = mysqli_real_escape_string($con, $_POST['guide_checklist']);
		}
		else{
			$SUBMIT_checklist = '';
		}


		$step_array = array();
		$step_content_array = [];
		$step_num = 0;
		foreach($_POST["step"] as $key => $step_text){
			if(!empty($step_text) && $step_text!=""){
				$step_num++;
				$step_file          = "texts/guide/" . clean($SUBMIT_articletitle) . "_step_".$step_num.".txt";
			        $open_step          = fopen($step_file, "w+");
			        $write_step         = fwrite($open_step, $step_text);
			        $close_step         = fclose($open_step);
				$step_file          = mysqli_real_escape_string($con, $step_file);
				array_push($step_array, $step_file);
				array_push($step_content_array, $step_text);
			}
		}
		
		$step_files = serialize($step_array);
	
	        $intro_file          = "texts/guide/" . clean($SUBMIT_articletitle) . "_intro.txt";
	        $open_intro          = fopen($intro_file, "w+");
	        $write_intro         = fwrite($open_intro, $SUBMIT_intro);
	        $close_intro         = fclose($open_intro);
		$intro_file          = mysqli_real_escape_string($con, $intro_file);
		
        	mysqli_query($con, "UPDATE tbl_guide SET article_type = '$SUBMIT_articletype', steps = '$step_files', checklist = '$SUBMIT_checklist', title = '$SUBMIT_articletitle', intro = '$intro_file', tags = '$SUBMIT_tags' WHERE id = '$SUBMIT_id'");
        	
        	mysqli_query($con, "DELETE FROM tbl_guide_content WHERE articleidFK='$SUBMIT_id'");
        	mysqli_query($con, "INSERT INTO tbl_guide_content (articleidFK, Content) VALUES ('$SUBMIT_id', '$SUBMIT_intro')");
		foreach($step_content_array as $content){
        		mysqli_query($con, "INSERT INTO tbl_guide_content (articleidFK, Content) VALUES ('$SUBMIT_id', '$content')");		
		}
    }

    if(isset($_POST['upload_images'])) {
        ini_set('max_file_uploads', 50);
        ini_set('upload_max_filesize', "100M");

        $upload_id = $_POST['upload_images'];

        $article_query = mysqli_query($con, "SELECT * FROM tbl_guide WHERE id = '$upload_id'");

        while ($UPAROW = mysqli_fetch_assoc($article_query)) {
            $UPLOAD_articletype  = preg_replace('/\s+/', "_", $UPAROW['article_type']);
            $UPLOAD_articletitle = preg_replace('/\s+/', "_", $UPAROW['title']);
			$steps = unserialize($UPAROW['steps']);
        }

        $upload_path = $_SERVER['DOCUMENT_ROOT'] . "/imgs/guide/";
		$img_num = -1;
		$img_num2 = -1;
		for ($x = 0; $x <= count($steps); $x++) {
			$img_num++;
			$UPLOAD_image[$img_num] = $_FILES[$img_num.'image'];
			$image_temp[$img_num] = $UPLOAD_image[$img_num]['tmp_name'];
			$image_name[$img_num] = basename($UPLOAD_image[$img_num]['name'], ".jpg");
			$image_info[$img_num] = getimagesize($image_temp[$img_num]);
		}
		
        


        if($image_info[0]) {
            $imagewidth = $image_info[0][0];
            if($imagewidth <= 960) {
                header("Location: articleimages.php?article_images=" . $upload_id . "&upload_error=width&type=guide");
            }
        } else {
            header("Location: articleimages.php?article_images=" . $upload_id . "&upload_error=invalid&type=guide");
        }

		for ($x = 0; $x <= count($steps); $x++) {
		$img_num2++;
        if(!empty($UPLOAD_image[$img_num2]['name'])) {
            $image_path = "GSR-" . $UPLOAD_articletype . "-" . clean($UPLOAD_articletitle . "-" . md5($image_name[$img_num2])) . "-".$img_num2."_image.jpg";
            $image_upld = move_uploaded_file($image_temp[$img_num2], $upload_path . $image_path);
			$image_array[$img_num2] = $image_path;
		}

		}
		
		$images_array = serialize($image_array);
		$image_qury = mysqli_query($con, "UPDATE tbl_guide SET images = '$images_array' WHERE id = '$upload_id'");
        header("Location: articlelist.php?type=guide");
    }

    if(isset($_GET['pending'])) { mysqli_query($con, "UPDATE tbl_guide SET pending = 'true' WHERE id = '" . $_GET['pending'] . "'"); }
    if(isset($_GET['beta'])) { mysqli_query($con, "UPDATE tbl_guide SET beta_approved = 'true' WHERE id = '" . $_GET['beta'] . "'"); }
    if(isset($_GET['alpha'])) { mysqli_query($con, "UPDATE tbl_guide SET alpha_approved = 'true' WHERE id = '" . $_GET['alpha'] . "'");
        $SUBMIT_date        = date('Y-m-d H:i:s');
        $SUBMIT_year        = date('Y');
        $SUBMIT_month       = date('M');
        mysqli_query($con, "UPDATE tbl_guide SET createdate = '$SUBMIT_date', month = '$SUBMIT_month', year = '$SUBMIT_year' WHERE id = '" . $_GET['alpha'] . "'");
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

    mysqli_query($con, "INSERT INTO tbl_featured (article_type, article_id, position) VALUES ('Guide', $newId, $newChoice)");

}

    if(isset($_GET['deny'])) {
        $denyid = $_GET['deny'];
        mysqli_query($con, "UPDATE tbl_guide SET alpha_approved = 'false' WHERE id = '$denyid'");
        mysqli_query($con, "UPDATE tbl_guide SET beta_approved = 'false' WHERE id = '$denyid'");
        mysqli_query($con, "UPDATE tbl_guide SET pending = 'false' WHERE id = '$denyid'");
    }

    if(isset($_GET['deletionid'])) {
        $deletionid = $_GET['deletionid'];

        $files_query = mysqli_query($con, "SELECT * FROM tbl_guide WHERE id = '$deletionid'");

        while ($filesROW = mysqli_fetch_assoc($files_query)) {
            $delete_aimageFILE     = $_SERVER['DOCUMENT_ROOT'] . "imgs/opinion/" . $filesROW['a_image'];
            $delete_bimageFILE     = $_SERVER['DOCUMENT_ROOT'] . "imgs/opinion/" . $filesROW['b_image'];
            $delete_cimageFILE     = $_SERVER['DOCUMENT_ROOT'] . "imgs/opinion/" . $filesROW['c_image'];
            $delete_dimageFILE     = $_SERVER['DOCUMENT_ROOT'] . "imgs/opinion/" . $filesROW['d_image'];
            $delete_eimageFILE     = $_SERVER['DOCUMENT_ROOT'] . "imgs/opinion/" . $filesROW['e_image'];

            $delete_mainFILE     = $_SERVER['DOCUMENT_ROOT'] . $filesROW['main'];
        }

        if(file_exists($delete_aimageFILE)) { unlink($delete_aimageFILE); }
        if(file_exists($delete_bimageFILE)) { unlink($delete_bimageFILE); }
        if(file_exists($delete_cimageFILE)) { unlink($delete_cimageFILE); }
        if(file_exists($delete_dimageFILE)) { unlink($delete_dimageFILE); }
        if(file_exists($delete_eimageFILE)) { unlink($delete_eimageFILE); }
        if(file_exists($delete_mainFILE)) { unlink($delete_mainFILE); }

        mysqli_query($con, "DELETE FROM tbl_opinion WHERE id = '$deletionid'");
    }
?>