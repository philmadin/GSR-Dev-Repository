<?php

function average($numbers) {

        $a = $numbers;
        $b = 0;
        $c = 0;
        $d = 0;
        foreach ($a as $b) {
            $c = $c + $b;
            $d++;
        }
        return number_format($c/$d,1);
}

function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

   return $string; // Removes special chars.
}

function implode_multi($arr, $join, $key){
    $temp_ar = array();
    foreach($arr as $arr_item){
        array_push($temp_ar, $arr_item->$key);
    }
    return implode($join, $temp_ar);
}

    include "mysql_con.php";

    session_start();

    if(isset($_POST['submit'])) {
        $SUBMIT_articletype     = $_POST['articletype'];
        $SUBMIT_articletitle    = $_POST['articletitle'];
        $SUBMIT_classification	= $_POST['classification'];
        $SUBMIT_game            = mysqli_real_escape_string($con, $_POST['gamename']);
        $SUBMIT_gameid          = mysqli_real_escape_string($con, $_POST['gameid']); //ADDED THIS
        $SUBMIT_summary         = mysqli_real_escape_string($con, $_POST['summary']);
        $SUBMIT_overview        = $_POST['overview'];
	$SUBMIT_overview        = iconv('UTF-8', 'ASCII//TRANSLIT', $SUBMIT_overview); 
	$SUBMIT_overview	= htmlentities($SUBMIT_overview, ENT_QUOTES); 
        $SUBMIT_storyline       = $_POST['storyline'];
	$SUBMIT_storyline = iconv('UTF-8', 'ASCII//TRANSLIT', $SUBMIT_storyline); 
	$SUBMIT_storyline = htmlentities($SUBMIT_storyline, ENT_QUOTES); 
        $SUBMIT_gameplay        = $_POST['gameplay'];
	$SUBMIT_gameplay = iconv('UTF-8', 'ASCII//TRANSLIT', $SUBMIT_gameplay); 
	$SUBMIT_gameplay = htmlentities($SUBMIT_gameplay, ENT_QUOTES); 
        $SUBMIT_audio           = $_POST['audio'];
	$SUBMIT_audio = iconv('UTF-8', 'ASCII//TRANSLIT', $SUBMIT_audio); 
	$SUBMIT_audio = htmlentities($SUBMIT_audio, ENT_QUOTES); 
        $SUBMIT_graphics        = $_POST['graphics'];
	$SUBMIT_graphics = iconv('UTF-8', 'ASCII//TRANSLIT', $SUBMIT_graphics); 
	$SUBMIT_graphics = htmlentities($SUBMIT_graphics, ENT_QUOTES); 
        $SUBMIT_verdict         = $_POST['verdict'];
        $SUBMIT_trailer         = $_POST['trailer'];
	$SUBMIT_verdict = iconv('UTF-8', 'ASCII//TRANSLIT', $SUBMIT_verdict); 
	$SUBMIT_verdict = htmlentities($SUBMIT_verdict, ENT_QUOTES); 
        $SUBMIT_releasedate     = mysqli_real_escape_string($con, $_POST['releasedate'] . " 00:00:00");
		$SUBMIT_officialsite    = mysqli_real_escape_string($con, $_POST['officialsite']);
        $SUBMIT_storylinerating = floatval($_POST['storylinerating']);
        $SUBMIT_gameplayrating  = floatval($_POST['gameplayrating']);
        $SUBMIT_audiorating     = floatval($_POST['audiorating']);
        $SUBMIT_graphicsrating  = floatval($_POST['graphicsrating']);
        $SUBMIT_mainrating      = $_POST['mainrating'];
        $SUBMIT_tags            = mysqli_real_escape_string($con, $_POST['tags']);


        $g = file_get_contents("http://gamesharkreviews.com/api/games?id=".$SUBMIT_gameid);
        $games = json_decode($g);
        if (isset($games->{0}->title) && $games->{0}->title==$SUBMIT_game){
                $game = $games->{0};
                $SUBMIT_gameid          = $game->id;
                $SUBMIT_releasedate     = $game->release_date;
                $SUBMIT_platforms       = implode_multi($game->platforms, ", ", "name");
                $SUBMIT_genre           = implode_multi($game->genres, ", ", "name");
                $SUBMIT_developers      = implode_multi($game->developers, ", ", "name");
                $SUBMIT_publishers      = implode_multi($game->publishers, ", ", "name");
                $SUBMIT_officialsite    = $game->website;
                $SUBMIT_developersites  = implode_multi($game->developers, ", ", "website");
                $SUBMIT_publishersites  = implode_multi($game->publishers, ", ", "website");
        }
        if (!isset($games->{0}->title) || $games->{0}->title!=$SUBMIT_game){
                $sql = "INSERT INTO tbl_games (title) VALUES ('$SUBMIT_game')";

                if (!mysqli_query($con, $sql)) {

                }
                $game_id = mysqli_insert_id($con);
                $SUBMIT_gameid = $game_id;

             $sql = array();


             $sql[] = "UPDATE tbl_games SET title='$SUBMIT_game' WHERE id=" . mysqli_real_escape_string($con, $game_id);
             $sql[] = "UPDATE tbl_games SET website='$SUBMIT_officialsite' WHERE id=" . mysqli_real_escape_string($con, $game_id);
             $sql[] = "UPDATE tbl_games SET release_date='$SUBMIT_releasedate' WHERE id=" . mysqli_real_escape_string($con, $game_id);
             $sql[] = "UPDATE tbl_games SET storyline='$SUBMIT_storyline' WHERE id=" . mysqli_real_escape_string($con, $game_id);
             $sql[] = "UPDATE tbl_games SET approved=0 WHERE id=" . mysqli_real_escape_string($con, $game_id);

            foreach ($sql as $sqli) {
                if (!mysqli_query($con, $sqli)) {

                }
            }
        }
            


		
		$SUBMIT_mainrating = average(array($SUBMIT_storylinerating, $SUBMIT_gameplayrating, $SUBMIT_audiorating, $SUBMIT_graphicsrating));
		

        $overview_file          = "texts/review/" . clean($SUBMIT_articletitle) . "_overview.txt";
        $storyline_file         = "texts/review/" . clean($SUBMIT_articletitle) . "_storyline.txt";
        $gameplay_file          = "texts/review/" . clean($SUBMIT_articletitle) . "_gameplay.txt";
        $audio_file             = "texts/review/" . clean($SUBMIT_articletitle) . "_audio.txt";
        $graphics_file          = "texts/review/" . clean($SUBMIT_articletitle) . "_graphics.txt";
        $verdict_file           = "texts/review/" . clean($SUBMIT_articletitle) . "_verdict.txt";
        $beta_notes_file        = "texts/review/" . clean($SUBMIT_articletitle) . "_beta_notes.txt";
        $alpha_notes_file       = "texts/review/" . clean($SUBMIT_articletitle) . "_alpha_notes.txt";

        $open_overview          = fopen($overview_file, "w+");
        $open_storyline         = fopen($storyline_file, "w+");
        $open_gameplay          = fopen($gameplay_file, "w+");
        $open_audio             = fopen($audio_file, "w+");
        $open_graphics          = fopen($graphics_file, "w+");
        $open_verdict           = fopen($verdict_file, "w+");
        $open_betanotes         = fopen($beta_notes_file, "w+");
        $open_alphanotes        = fopen($alpha_notes_file, "w+");

        $write_overview         = fwrite($open_overview, $SUBMIT_overview);
        $write_storyline        = fwrite($open_storyline, $SUBMIT_storyline);
        $write_gameplay         = fwrite($open_gameplay, $SUBMIT_gameplay);
        $write_audio            = fwrite($open_audio, $SUBMIT_audio);
        $write_graphics         = fwrite($open_graphics, $SUBMIT_graphics);
        $write_verdict          = fwrite($open_verdict, $SUBMIT_verdict);
        $write_betanotes        = fwrite($open_betanotes, "No notes or corrections were given.");
        $write_alphanotes       = fwrite($open_alphanotes, "No notes or corrections were given.");

        $close_overview         = fclose($open_overview);
        $close_storyline        = fclose($open_storyline);
        $close_gameplay         = fclose($open_gameplay);
        $close_audio            = fclose($open_audio);
        $close_graphics         = fclose($open_graphics);
        $close_verdict          = fclose($open_verdict);
        $close_betanotes        = fclose($open_betanotes);
        $close_alphanotes       = fclose($open_alphanotes);
		
		$overview_file          = mysqli_real_escape_string($con, $overview_file);
        $storyline_file         = mysqli_real_escape_string($con, $storyline_file);
        $gameplay_file          = mysqli_real_escape_string($con, $gameplay_file);
        $audio_file             = mysqli_real_escape_string($con, $audio_file);
        $graphics_file          = mysqli_real_escape_string($con, $graphics_file);
        $verdict_file           = mysqli_real_escape_string($con, $verdict_file);
        $beta_notes_file        = mysqli_real_escape_string($con, $beta_notes_file);
        $alpha_notes_file       = mysqli_real_escape_string($con, $alpha_notes_file);

        $SUBMIT_username        = $_POST['submit'];
		
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
		
		$SUBMIT_articletitle    = mysqli_real_escape_string($con, strip_tags($_POST['articletitle']));
		$SUBMIT_game            = mysqli_real_escape_string($con, strip_tags($_POST['gamename']));
        mysqli_query($con, "INSERT INTO tbl_review (classification, article_type, title, gamename, game_id, summary, content_1, content_2, content_3, content_4, content_5, content_6, Overview, HTMLContent_1, HTMLContent_2, HTMLContent_4, HTMLContent_3, Verdict, trailer, author, authuser, createdate, month, year, release_date, officialsite, main_rating, Rating_1, Rating_2, Rating_3, Rating_4, pending, beta_approved, alpha_approved, beta_notes, alpha_notes, editors_choice, tags) VALUES ('$SUBMIT_classification','$SUBMIT_articletype', '$SUBMIT_articletitle', '$SUBMIT_game', '$SUBMIT_gameid', '$SUBMIT_summary', '$overview_file', '$storyline_file', '$gameplay_file', '$audio_file', '$graphics_file', '$verdict_file', '$SUBMIT_overview', '$SUBMIT_storyline', '$SUBMIT_gameplay', '$SUBMIT_audio', '$SUBMIT_graphics', '$SUBMIT_verdict', '$SUBMIT_trailer', '$SUBMIT_author', '$SUBMIT_username', '$SUBMIT_date', '$SUBMIT_month', '$SUBMIT_year', '$SUBMIT_releasedate', '$SUBMIT_officialsite', '$SUBMIT_mainrating', '$SUBMIT_storylinerating', '$SUBMIT_gameplayrating', '$SUBMIT_graphicsrating', '$SUBMIT_audiorating', '$ifbossa', '$ifbossb', 'false', '$beta_notes_file', '$alpha_notes_file', '0', '$SUBMIT_tags')");
        $last_id = mysqli_insert_id($con);
		switch($SUBMIT_classification){
			case "G":
				$SUBMIT_genre           = mysqli_real_escape_string($con, $_POST['genre']);
				$SUBMIT_platforms       = mysqli_real_escape_string($con, $_POST['platforms']);
       			$SUBMIT_testedplatforms = mysqli_real_escape_string($con, $_POST['testedplatforms']);
				$SUBMIT_developers      = mysqli_real_escape_string($con, $_POST['developers']);
				$SUBMIT_developersites  = mysqli_real_escape_string($con, $_POST['developersites']);
				$SUBMIT_publishers      = mysqli_real_escape_string($con, $_POST['publishers']);
        		$SUBMIT_publishersites  = mysqli_real_escape_string($con, $_POST['publishersites']);
        		$sqlero = mysqli_prepare($con,"INSERT INTO tbl_game_review VALUES (?,?,?,?,?,?,?,?)") or die(mysqli_error($con));
				mysqli_stmt_bind_param($sqlero, 'isssssss', $last_id, $SUBMIT_genre, $SUBMIT_platforms,$SUBMIT_testedplatforms,$SUBMIT_developers,$SUBMIT_developersites,$SUBMIT_publishers,$SUBMIT_publishersites) or die(mysqli_error($con));
    			mysqli_stmt_execute($sqlero) or die(mysqli_error($con));
			break;

			case "M":
				$SUBMIT_moviegenre      = mysqli_real_escape_string($con, $_POST['moviegenre']);
				$SUBMIT_duration       	= mysqli_real_escape_string($con, $_POST['duration']);
       			$SUBMIT_directors 		= mysqli_real_escape_string($con, $_POST['directors']);
				$SUBMIT_cast      		= mysqli_real_escape_string($con, $_POST['cast']);
				$SUBMIT_publishers      = mysqli_real_escape_string($con, $_POST['moviepublishers']);
				$SUBMIT_publisherssites = mysqli_real_escape_string($con, $_POST['moviepublisherssites']);
        		$sqlero = mysqli_prepare($con,"INSERT INTO tbl_movie_review VALUES (?,?,?,?,?,?)") or die(mysqli_error($con));
				mysqli_stmt_bind_param($sqlero, 'isssssss', $last_id, $SUBMIT_genre, $SUBMIT_platforms,$SUBMIT_testedplatforms,$SUBMIT_developers,$SUBMIT_developersites,$SUBMIT_publishers,$SUBMIT_publishersites) or die(mysqli_error($con));
    			mysqli_stmt_execute($sqlero) or die(mysqli_error($con));
			break;

			case "T":
				$SUBMIT_category      		= mysqli_real_escape_string($con, $_POST['category']);
				$SUBMIT_rrp       			= mysqli_real_escape_string($con, $_POST['rrp']);
       			$SUBMIT_manu 				= mysqli_real_escape_string($con, $_POST['manufacturers']);
				$SUBMIT_manusites      		= mysqli_real_escape_string($con, $_POST['manufacturerssites']);
			break;
		}
	}

    if(isset($_POST['save'])) {
        $SUBMIT_type            = $_POST['articletype'];        
        $SUBMIT_classification	= $_POST['classification'];
        $SUBMIT_articletitle    = $_POST['articletitle'];
        $SUBMIT_game            = $_POST['gamename'];
        $SUBMIT_summary         = mysqli_real_escape_string($con, $_POST['summary']);
        $SUBMIT_overview        = $_POST['overview'];
	$SUBMIT_overview        = iconv('UTF-8', 'ASCII//TRANSLIT', $SUBMIT_overview); 
	$SUBMIT_overview	= htmlentities($SUBMIT_overview, ENT_QUOTES); 
        $SUBMIT_storyline       = $_POST['storyline'];
	$SUBMIT_storyline 	= iconv('UTF-8', 'ASCII//TRANSLIT', $SUBMIT_storyline); 
	$SUBMIT_storyline 	= htmlentities($SUBMIT_storyline, ENT_QUOTES); 
        $SUBMIT_gameplay        = $_POST['gameplay'];
	$SUBMIT_gameplay 	= iconv('UTF-8', 'ASCII//TRANSLIT', $SUBMIT_gameplay); 
	$SUBMIT_gameplay 	= htmlentities($SUBMIT_gameplay, ENT_QUOTES); 
        $SUBMIT_audio           = $_POST['audio'];
	$SUBMIT_audio = iconv('UTF-8', 'ASCII//TRANSLIT', $SUBMIT_audio); 
	$SUBMIT_audio = htmlentities($SUBMIT_audio, ENT_QUOTES); 
        $SUBMIT_graphics        = $_POST['graphics'];
	$SUBMIT_graphics = iconv('UTF-8', 'ASCII//TRANSLIT', $SUBMIT_graphics); 
	$SUBMIT_graphics = htmlentities($SUBMIT_graphics, ENT_QUOTES); 
        $SUBMIT_verdict         = $_POST['verdict'];
	$SUBMIT_verdict = iconv('UTF-8', 'ASCII//TRANSLIT', $SUBMIT_verdict); 
	$SUBMIT_verdict = htmlentities($SUBMIT_verdict, ENT_QUOTES); 
        $SUBMIT_trailer         = $_POST['trailer'];
        $SUBMIT_testedplatforms = mysqli_real_escape_string($con, $_POST['testedplatforms']);
        $SUBMIT_releasedate     = mysqli_real_escape_string($con, $_POST['releasedate'] . " 00:00:00");
        $SUBMIT_platforms       = mysqli_real_escape_string($con, $_POST['platforms']);
        $SUBMIT_genre           = mysqli_real_escape_string($con, $_POST['genre']);
        $SUBMIT_developers      = mysqli_real_escape_string($con, $_POST['developers']);
        $SUBMIT_publishers      = mysqli_real_escape_string($con, $_POST['publishers']);
        $SUBMIT_officialsite    = mysqli_real_escape_string($con, $_POST['officialsite']);
        $SUBMIT_developersites  = mysqli_real_escape_string($con, $_POST['developersites']);
        $SUBMIT_publishersites  = mysqli_real_escape_string($con, $_POST['publishersites']);
        $SUBMIT_storylinerating = floatval($_POST['storylinerating']);
        $SUBMIT_gameplayrating  = floatval($_POST['gameplayrating']);
        $SUBMIT_audiorating     = floatval($_POST['audiorating']);
        $SUBMIT_graphicsrating  = floatval($_POST['graphicsrating']);
        $SUBMIT_mainrating      = $_POST['mainrating'];
        $SUBMIT_betanotes       = $_POST['beta_notes'];
        $SUBMIT_alphanotes      = $_POST['alpha_notes'];
        $SUBMIT_id              = $_POST['save'];
        $SUBMIT_updatedate      = $_POST['updatedate'];
        $SUBMIT_tags            = mysqli_real_escape_string($con, $_POST['tags']);
		
		$SUBMIT_mainrating = average(array($SUBMIT_storylinerating, $SUBMIT_gameplayrating, $SUBMIT_audiorating, $SUBMIT_graphicsrating));


        $overview_file          = "texts/review/" . clean($SUBMIT_articletitle) . "_overview.txt";
        $storyline_file         = "texts/review/" . clean($SUBMIT_articletitle) . "_storyline.txt";
        $gameplay_file          = "texts/review/" . clean($SUBMIT_articletitle) . "_gameplay.txt";
        $audio_file             = "texts/review/" . clean($SUBMIT_articletitle) . "_audio.txt";
        $graphics_file          = "texts/review/" . clean($SUBMIT_articletitle) . "_graphics.txt";
        $verdict_file           = "texts/review/" . clean($SUBMIT_articletitle) . "_verdict.txt";
        $beta_notes_file        = "texts/review/" . clean($SUBMIT_articletitle) . "_beta_notes.txt";
        $alpha_notes_file       = "texts/review/" . clean($SUBMIT_articletitle) . "_alpha_notes.txt";

        $open_overview          = fopen($overview_file, "w+");
        $open_storyline         = fopen($storyline_file, "w+");
        $open_gameplay          = fopen($gameplay_file, "w+");
        $open_audio             = fopen($audio_file, "w+");
        $open_graphics          = fopen($graphics_file, "w+");
        $open_verdict           = fopen($verdict_file, "w+");
        $open_betanotes         = fopen($beta_notes_file, "w+");
        $open_alphanotes        = fopen($alpha_notes_file, "w+");

        $write_overview         = fwrite($open_overview, $SUBMIT_overview);
        $write_storyline        = fwrite($open_storyline, $SUBMIT_storyline);
        $write_gameplay         = fwrite($open_gameplay, $SUBMIT_gameplay);
        $write_audio            = fwrite($open_audio, $SUBMIT_audio);
        $write_graphics         = fwrite($open_graphics, $SUBMIT_graphics);
        $write_verdict          = fwrite($open_verdict, $SUBMIT_verdict);
        $write_betanotes        = fwrite($open_betanotes, $SUBMIT_betanotes);
        $write_alphanotes       = fwrite($open_alphanotes, $SUBMIT_alphanotes);

        $close_overview         = fclose($open_overview);
        $close_storyline        = fclose($open_storyline);
        $close_gameplay         = fclose($open_gameplay);
        $close_audio            = fclose($open_audio);
        $close_graphics         = fclose($open_graphics);
        $close_verdict          = fclose($open_verdict);
        $close_betanotes        = fclose($open_betanotes);
        $close_alphanotes       = fclose($open_alphanotes);
		
		$overview_file          = mysqli_real_escape_string($con, $overview_file);
        $storyline_file         = mysqli_real_escape_string($con, $storyline_file);
        $gameplay_file          = mysqli_real_escape_string($con, $gameplay_file);
        $audio_file             = mysqli_real_escape_string($con, $audio_file);
        $graphics_file          = mysqli_real_escape_string($con, $graphics_file);
        $verdict_file           = mysqli_real_escape_string($con, $verdict_file);
        $beta_notes_file        = mysqli_real_escape_string($con, $beta_notes_file);
        $alpha_notes_file       = mysqli_real_escape_string($con, $alpha_notes_file);
		
		$SUBMIT_articletitle    = mysqli_real_escape_string($con, $_POST['articletitle']);
		$SUBMIT_game            = mysqli_real_escape_string($con, $_POST['gamename']);

        
        mysqli_query($con, "UPDATE tbl_review SET classification = '$SUBMIT_classification', article_type = '$SUBMIT_type', title = '$SUBMIT_articletitle', gamename = '$SUBMIT_game', summary = '$SUBMIT_summary', trailer = '$SUBMIT_trailer', testedplatforms = '$SUBMIT_testedplatforms', genre = '$SUBMIT_genre', developers = '$SUBMIT_developers', publishers = '$SUBMIT_publishers', platforms = '$SUBMIT_platforms', release_date = '$SUBMIT_releasedate', officialsite = '$SUBMIT_officialsite', developersites = '$SUBMIT_developersites', publishersites = '$SUBMIT_publishersites', main_rating = '$SUBMIT_mainrating', Rating_1 = '$SUBMIT_storylinerating', Rating_2 = '$SUBMIT_gameplayrating', Rating_3 = '$SUBMIT_graphicsrating', Rating_4 = '$SUBMIT_audiorating', tags = '$SUBMIT_tags', Overview = '$SUBMIT_overview', HTMLContent_1= '$SUBMIT_storyline', HTMLContent_2= '$SUBMIT_gameplay', HTMLContent_4= '$SUBMIT_audio', HTMLContent_3= '$SUBMIT_graphics', Verdict= '$SUBMIT_verdict' WHERE id = '$SUBMIT_id'");
		

    }

    if(isset($_POST['upload_images'])) {

        $upload_id = $_POST['upload_images'];

        $article_query = mysqli_query($con, "SELECT * FROM tbl_review WHERE id = '$upload_id'");

        while ($UPAROW = mysqli_fetch_assoc($article_query)) {
            $UPLOAD_articletype  = preg_replace('/\s+/', "_", $UPAROW['article_type']);
            $UPLOAD_articletitle = preg_replace('/\s+/', "_", $UPAROW['title']);
            $UPLOAD_articlegame  = preg_replace('/\s+/', "_", $UPAROW['gamename']);
        }

        $upload_path = $_SERVER['DOCUMENT_ROOT'] . "/imgs/review/";

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
                header("Location: articleimages.php?article_images=" . $upload_id . "&upload_error=width&type=review");
            }
        } else {
            header("Location: articleimages.php?article_images=" . $upload_id . "&upload_error=invalid&type=review");
        }

        if(!empty($UPLOAD_aimage['name'])) {
            $aimage_path = clean("GSR-" . $UPLOAD_articletype . "-" . $UPLOAD_articletitle . "-" . $UPLOAD_articlegame . "-" . md5($aimage_name)) . "-a_image.jpg";
            $aimage_qury = mysqli_query($con, "UPDATE tbl_review SET a_image = '".mysqli_real_escape_string($con, $aimage_path)."' WHERE id = '$upload_id'");
            $aimage_upld = move_uploaded_file($aimage_temp, $upload_path . $aimage_path);
        }

        if(!empty($UPLOAD_bimage['name'])) {
            $bimage_path = clean("GSR-" . $UPLOAD_articletype . "-" . $UPLOAD_articletitle . "-" . $UPLOAD_articlegame . "-" . md5($bimage_name)) . "-b_image.jpg";
            $bimage_qury = mysqli_query($con, "UPDATE tbl_review SET b_image = '".mysqli_real_escape_string($con, $bimage_path)."' WHERE id = '$upload_id'");
            $bimage_upld = move_uploaded_file($bimage_temp, $upload_path . $bimage_path);
        }

        if(!empty($UPLOAD_cimage['name'])) {
            $cimage_path = clean("GSR-" . $UPLOAD_articletype . "-" . $UPLOAD_articletitle . "-" . $UPLOAD_articlegame . "-" . md5($cimage_name)) . "-c_image.jpg";
            $cimage_qury = mysqli_query($con, "UPDATE tbl_review SET c_image = '".mysqli_real_escape_string($con, $cimage_path)."' WHERE id = '$upload_id'");
            $cimage_upld = move_uploaded_file($cimage_temp, $upload_path . $cimage_path);
        }

        if(!empty($UPLOAD_dimage['name'])) {
            $dimage_path = clean("GSR-" . $UPLOAD_articletype . "-" . $UPLOAD_articletitle . "-" . $UPLOAD_articlegame . "-" . md5($dimage_name)) . "-d_image.jpg";
            $dimage_qury = mysqli_query($con, "UPDATE tbl_review SET d_image = '".mysqli_real_escape_string($con, $dimage_path)."' WHERE id = '$upload_id'");
            $dimage_upld = move_uploaded_file($dimage_temp, $upload_path . $dimage_path);
        }

        if(!empty($UPLOAD_eimage['name'])) {
            $eimage_path = clean("GSR-" . $UPLOAD_articletype . "-" . $UPLOAD_articletitle . "-" . $UPLOAD_articlegame . "-" . md5($eimage_name)) . "-e_image.jpg";
            $eimage_qury = mysqli_query($con, "UPDATE tbl_review SET e_image = '".mysqli_real_escape_string($con, $eimage_path)."' WHERE id = '$upload_id'");
            $eimage_upld = move_uploaded_file($eimage_temp, $upload_path . $eimage_path);
        }

        header("Location: articlelist.php?type=review");
    }

    if(isset($_GET['pending'])) { mysqli_query($con, "UPDATE tbl_review SET pending = 'true' WHERE id = '" . $_GET['pending'] . "'"); }
    if(isset($_GET['beta'])) { mysqli_query($con, "UPDATE tbl_review SET beta_approved = 'true' WHERE id = '" . $_GET['beta'] . "'"); }
    if(isset($_GET['alpha'])) { mysqli_query($con, "UPDATE tbl_review SET alpha_approved = 'true' WHERE id = '" . $_GET['alpha'] . "'");
        $SUBMIT_date        = date('Y-m-d H:i:s');
        $SUBMIT_year        = date('Y');
        $SUBMIT_month       = date('M');
        mysqli_query($con, "UPDATE tbl_review SET createdate = '$SUBMIT_date', month = '$SUBMIT_month', year = '$SUBMIT_year' WHERE id = '" . $_GET['alpha'] . "'");
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
			
            mysqli_query($con, "INSERT INTO tbl_featured (article_type, article_id, position) VALUES ('Review', $newId, $newChoice)");

    }

    if(isset($_GET['deny'])) {
        $denyid = $_GET['deny'];
        mysqli_query($con, "UPDATE tbl_review SET alpha_approved = 'false' WHERE id = '$denyid'");
        mysqli_query($con, "UPDATE tbl_review SET beta_approved = 'false' WHERE id = '$denyid'");
        mysqli_query($con, "UPDATE tbl_review SET pending = 'false' WHERE id = '$denyid'");
    }

    if(isset($_GET['deletionid'])) {
        $deletionid = $_GET['deletionid'];

        $files_query = mysqli_query($con, "SELECT * FROM tbl_review WHERE id = '$deletionid'");

        while ($filesROW = mysqli_fetch_assoc($files_query)) {
            $delete_aimageFILE     = $_SERVER['DOCUMENT_ROOT'] . "imgs/review/" . $filesROW['a_image'];
            $delete_bimageFILE     = $_SERVER['DOCUMENT_ROOT'] . "imgs/review/" . $filesROW['b_image'];
            $delete_cimageFILE     = $_SERVER['DOCUMENT_ROOT'] . "imgs/review/" . $filesROW['c_image'];
            $delete_dimageFILE     = $_SERVER['DOCUMENT_ROOT'] . "imgs/review/" . $filesROW['d_image'];
            $delete_eimageFILE     = $_SERVER['DOCUMENT_ROOT'] . "imgs/review/" . $filesROW['e_image'];

            $delete_content1FILE     = $_SERVER['DOCUMENT_ROOT'] . $filesROW['content_1'];
            $delete_content2FILE     = $_SERVER['DOCUMENT_ROOT'] . $filesROW['content_2'];
            $delete_content3FILE     = $_SERVER['DOCUMENT_ROOT'] . $filesROW['content_3'];
            $delete_content4FILE     = $_SERVER['DOCUMENT_ROOT'] . $filesROW['content_4'];
            $delete_content5FILE     = $_SERVER['DOCUMENT_ROOT'] . $filesROW['content_5'];
            $delete_content6FILE     = $_SERVER['DOCUMENT_ROOT'] . $filesROW['content_6'];

            $delete_notesaFILE       = $_SERVER['DOCUMENT_ROOT'] . $filesROW['alpha_notes'];
            $delete_notesbFILE       = $_SERVER['DOCUMENT_ROOT'] . $filesROW['beta_notes'];
        }

        if(file_exists($delete_aimageFILE)) { unlink($delete_aimageFILE); }
        if(file_exists($delete_bimageFILE)) { unlink($delete_bimageFILE); }
        if(file_exists($delete_cimageFILE)) { unlink($delete_cimageFILE); }
        if(file_exists($delete_dimageFILE)) { unlink($delete_dimageFILE); }
        if(file_exists($delete_eimageFILE)) { unlink($delete_eimageFILE); }
        if(file_exists($delete_content1FILE)) { unlink($delete_content1FILE); }
        if(file_exists($delete_content2FILE)) { unlink($delete_content2FILE); }
        if(file_exists($delete_content3FILE)) { unlink($delete_content3FILE); }
        if(file_exists($delete_content4FILE)) { unlink($delete_content4FILE); }
        if(file_exists($delete_content5FILE)) { unlink($delete_content5FILE); }
        if(file_exists($delete_content6FILE)) { unlink($delete_content6FILE); }
        if(file_exists($delete_notesaFILE)) { unlink($delete_notesaFILE); }
        if(file_exists($delete_notesbFILE)) { unlink($delete_notesbFILE); }

        mysqli_query($con, "DELETE FROM tbl_review WHERE id = '$deletionid'");
    }
?>