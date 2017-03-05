<?php

function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

try {
    include 'mysql_con.php';

    $user = $_SESSION['username'];

    //Getting records (listAction)
    if ($_GET["action"] == "list") {

        $rows = array();
        //Get record count
        if(isset($_POST['searchquery'])) {
            $query = mysqli_real_escape_string($con, $_POST['searchquery']);
            $result = mysqli_query($con, "SELECT COUNT(*) AS RecordCount FROM tbl_games  WHERE (title LIKE '%".$query."%')");
        }
        else{
            $result = mysqli_query($con, "SELECT COUNT(*) AS RecordCount FROM tbl_games;");
        }
        $row = mysqli_fetch_array($result);
        $recordCount = $row['RecordCount'];

        //Get records from database
        if(isset($_POST['searchquery'])) {
            $query = mysqli_real_escape_string($con, $_POST['searchquery']);
            $result = mysqli_query($con, "SELECT * FROM tbl_games  WHERE (title LIKE '%".$query."%') ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";");
        }
        else{
            $result = mysqli_query($con, "SELECT * FROM tbl_games ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";");
        }
        while ($row = mysqli_fetch_array($result)) {
            $row['filteredAbout'] = nl2br(str_replace("[bullet]", "&bull;", $row['about']));
            $row['url'] = "game.php?title=" . urlencode(str_replace(" ", "_", $row['title']));
            $rows[] = $row;
        }

        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result'] = "OK";
        $jTableResult['TotalRecordCount'] = $recordCount;
        $jTableResult['Records'] = $rows;
        print json_encode($jTableResult);
    }

    $errors = array();
    $splitter = "@##$^@";

    if ($_GET['action'] == "addgame") {
        if ($_POST['title'] == "" || !isset($_POST['title'])) {
            array_push($errors, "Please enter the title.");
        }
        $title = mysqli_real_escape_string($con, $_POST['title']);
        if (!empty($errors)) {
            echo "false" . $splitter . implode(",", $errors);
            return false;
        }
        
            $cover = NULL;
        
        
        if ($_POST["storyline"] != "" && isset($_POST["storyline"])) {
            $storyline = mysqli_real_escape_string($con, $_POST['storyline']);
        } else {
            $storyline = NULL;
        }
        if ($_POST["about"] != "" && isset($_POST["about"])) {
            $about = mysqli_real_escape_string($con, $_POST['about']);
        } else {
            $about = NULL;
        }
        if ($_POST["release-date"] != "" && isset($_POST["release-date"])) {
            $release_date = mysqli_real_escape_string($con, $_POST['release-date']);
        } else {
            $release_date = NULL;
        }
        if ($_POST["website"] != "" && isset($_POST["website"])) {
            $website = mysqli_real_escape_string($con, $_POST['website']);
        } else {
            $website = NULL;
        }

        if ($_POST["platforms"] != "" && isset($_POST["platforms"])) {
            $platforms = implode(",", $_POST["platforms"]);
        } else {
            $platforms = NULL;
        }
        if ($_POST["genres"] != "" && isset($_POST["genres"])) {
            $genres = implode(",", $_POST["genres"]);
        } else {
            $genres = NULL;
        }
        if ($_POST["developers"] != "" && isset($_POST["developers"])) {
            $developers = implode(",", $_POST["developers"]);
        } else {
            $developers = NULL;
        }
        if ($_POST["publishers"] != "" && isset($_POST["publishers"])) {
            $publishers = implode(",", $_POST["publishers"]);
        } else {
            $publishers = NULL;
        }
        if ($_POST["characters"] != "" && isset($_POST["characters"])) {
            $characters = implode(",", $_POST["characters"]);
        } else {
            $characters = NULL;
        }

        if ($_POST["levels"] != "" && isset($_POST["levels"])) {
            $levels = mysqli_real_escape_string($con, $_POST['levels']);
        } else {
            $levels = NULL;
        }
        if ($_POST["missions"] != "" && isset($_POST["missions"])) {
            $missions = mysqli_real_escape_string($con, $_POST['missions']);
        } else {
            $missions = NULL;
        }
        if ($_POST["weapons"] != "" && isset($_POST["weapons"])) {
            $weapons = mysqli_real_escape_string($con, $_POST['weapons']);
        } else {
            $weapons = NULL;
        }
        if ($_POST["cheats"] != "" && isset($_POST["cheats"])) {
            $cheats = mysqli_real_escape_string($con, $_POST['cheats']);
        } else {
            $cheats = NULL;
        }


        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $endMessage = "Game has been saved.";
            $game_id = $_GET['id'];
        } else {
            $sql = "INSERT INTO tbl_games (title) VALUES ('$title')";

            if (!mysqli_query($con, $sql)) {
                array_push($errors, "Error in the SQL: ".mysqli_error($con));
            }
            $game_id = mysqli_insert_id($con);
            $endMessage = "Game has been submitted.";
        }

        $sql = array();

        if ($title != NULL) {
            $sql[] = "UPDATE tbl_games SET title='$title' WHERE id=" . mysqli_real_escape_string($con, $game_id);
        } else {
            $sql[] = "UPDATE tbl_games SET title=NULL WHERE id=" . mysqli_real_escape_string($con, $game_id);
        }

        if ($platforms != NULL) {
            $sql[] = "UPDATE tbl_games SET platforms='$platforms' WHERE id=" . mysqli_real_escape_string($con, $game_id);
        } else {
            $sql[] = "UPDATE tbl_games SET platforms=NULL WHERE id=" . mysqli_real_escape_string($con, $game_id);
        }

        if ($website != NULL) {
            $sql[] = "UPDATE tbl_games SET website='$website' WHERE id=" . mysqli_real_escape_string($con, $game_id);
        } else {
            $sql[] = "UPDATE tbl_games SET website=NULL WHERE id=" . mysqli_real_escape_string($con, $game_id);
        }

        if ($genres != NULL) {
            $sql[] = "UPDATE tbl_games SET genres='$genres' WHERE id=" . mysqli_real_escape_string($con, $game_id);
        } else {
            $sql[] = "UPDATE tbl_games SET genres=NULL WHERE id=" . mysqli_real_escape_string($con, $game_id);
        }

        if ($release_date != NULL) {
            $sql[] = "UPDATE tbl_games SET release_date='$release_date' WHERE id=" . mysqli_real_escape_string($con, $game_id);
        } else {
            $sql[] = "UPDATE tbl_games SET release_date=NULL WHERE id=" . mysqli_real_escape_string($con, $game_id);
        }

        if ($developers != NULL) {
            $sql[] = "UPDATE tbl_games SET developers='$developers' WHERE id=" . mysqli_real_escape_string($con, $game_id);
        } else {
            $sql[] = "UPDATE tbl_games SET developers=NULL WHERE id=" . mysqli_real_escape_string($con, $game_id);
        }

        if ($characters != NULL) {
            $sql[] = "UPDATE tbl_games SET characters='$characters' WHERE id=" . mysqli_real_escape_string($con, $game_id);
        } else {
            $sql[] = "UPDATE tbl_games SET characters=NULL WHERE id=" . mysqli_real_escape_string($con, $game_id);
        }

        if ($publishers != NULL) {
            $sql[] = "UPDATE tbl_games SET publishers='$publishers' WHERE id=" . mysqli_real_escape_string($con, $game_id);
        } else {
            $sql[] = "UPDATE tbl_games SET publishers=NULL WHERE id=" . mysqli_real_escape_string($con, $game_id);
        }

        if ($storyline != NULL) {
            $sql[] = "UPDATE tbl_games SET storyline='$storyline' WHERE id=" . mysqli_real_escape_string($con, $game_id);
        } else {
            $sql[] = "UPDATE tbl_games SET storyline=NULL WHERE id=" . mysqli_real_escape_string($con, $game_id);
        }

        if ($about != NULL) {
            $sql[] = "UPDATE tbl_games SET about='$about' WHERE id=" . mysqli_real_escape_string($con, $game_id);
        } else {
            $sql[] = "UPDATE tbl_games SET about=NULL WHERE id=" . mysqli_real_escape_string($con, $game_id);
        }

        if ($weapons != NULL) {
            $sql[] = "UPDATE tbl_games SET weapons='$weapons' WHERE id=" . mysqli_real_escape_string($con, $game_id);
        } else {
            $sql[] = "UPDATE tbl_games SET weapons=NULL WHERE id=" . mysqli_real_escape_string($con, $game_id);
        }

        if ($levels != NULL) {
            $sql[] = "UPDATE tbl_games SET levels='$levels' WHERE id=" . mysqli_real_escape_string($con, $game_id);
        } else {
            $sql[] = "UPDATE tbl_games SET levels=NULL WHERE id=" . mysqli_real_escape_string($con, $game_id);
        }

        if ($missions != NULL) {
            $sql[] = "UPDATE tbl_games SET missions='$missions' WHERE id=" . mysqli_real_escape_string($con, $game_id);
        } else {
            $sql[] = "UPDATE tbl_games SET missions=NULL WHERE id=" . mysqli_real_escape_string($con, $game_id);
        }

        if ($cheats != NULL) {
            $sql[] = "UPDATE tbl_games SET cheats='$cheats' WHERE id=" . mysqli_real_escape_string($con, $game_id);
        } else {
            $sql[] = "UPDATE tbl_games SET cheats=NULL WHERE id=" . mysqli_real_escape_string($con, $game_id);
        }
            $sql[] = "UPDATE tbl_games SET approved=0 WHERE id=" . mysqli_real_escape_string($con, $game_id);

        foreach ($sql as $sqli) {
            if (!mysqli_query($con, $sqli)) {
                array_push($errors, "Error in the SQL: " . mysqli_error($con));
            }
        }

        if (!empty($errors)) {
            echo "false" . $splitter . implode(",", $errors);
            return false;
        } else {
            echo "true" . $splitter . $endMessage;
        }
        return false;
    }
    
    if($_GET['action'] == "gamecover"){

        $upload_id = $_POST['upload_cover'];

        $game_query = mysqli_query($con, "SELECT * FROM tbl_games WHERE id = '$upload_id'");

        while ($game = mysqli_fetch_assoc($game_query)) {
            $game_title = $game['title'];
        }

        $upload_path = $_SERVER['DOCUMENT_ROOT'] . "/imgs/games/covers/";
        $UPLOAD_cover = $_FILES['cover'];
        $cover_temp = $UPLOAD_cover['tmp_name'];
        $fileName    = $UPLOAD_cover["name"];
        $imageFileType = pathinfo($fileName,PATHINFO_EXTENSION);
        $cover_name = strtolower(str_replace(" ", "_", clean($game_title))).".jpg";
        $cover_info = getimagesize($cover_temp);

        if(strtolower($imageFileType) != "jpg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpeg") {
            array_push($errors, "Sorry, only JPG, JPEG & PNG files are allowed. NOT: ".$imageFileType);
        }

        if($cover_info) {
            $imagewidth = $cover_info[0];
            if($imagewidth <= 400) {
                array_push($errors, "The image width was too small.");
            }
        } else {
            array_push($errors, "That file was invalid.");
        }

        if(!empty($UPLOAD_cover['name'])) {
            $cover_path = strtolower(str_replace(" ", "_", clean($game_title))).".jpg";
            $cover_qury = mysqli_query($con, "UPDATE tbl_games SET image = '".'imgs/games/covers/'.$cover_path."' WHERE id = '$upload_id'");
            $cover_upld = move_uploaded_file($cover_temp, $upload_path . $cover_path);
        }
        if( !empty( $errors ) )
        {
            echo "false".$splitter.implode(",",$errors);
            return false;
        }
        else{
            echo "true".$splitter."Cover Image Uploaded";
        }



    }
    
    if($_GET['action'] == "addplatform"){
        if(!isset($_POST['name']) || $_POST['name']==""){
            array_push($errors, "Please enter the name of the platform.");
        }
        if(!isset($_POST['base64']) || $_POST['base64']==""){
            array_push($errors, "Please upload an icon.");
        }

        $name = mysqli_real_escape_string($con, $_POST['name']);
        if(isset($_POST['base64']) || $_POST['base64']!=""){
            $base64string = $_POST['base64'];
            $icon = 'imgs/games/platforms/'.strtolower(str_replace(" ", "_", clean($name))).".png";
            file_put_contents($icon, base64_decode($base64string));
        }
        if( !empty( $errors ) )
        {
            echo "false".$splitter.implode(",",$errors);
            return false;
        }

        $sql = "INSERT INTO tbl_platforms (name, icon)
VALUES ('$name', '$icon')";

        if (!mysqli_query($con, $sql)) {
            array_push($errors, "Error in the SQL: ".mysqli_error($con));
        }

        if( !empty( $errors ) )
        {
            echo "false".$splitter.implode(",",$errors);
            return false;
        }
        else{
            echo "true".$splitter."New platform has been added.";
        }
    }

    if($_GET['action'] == "adddeveloper"){
        if(!isset($_POST['name']) || $_POST['name']==""){
            array_push($errors, "Please enter the name of the developer.");
        }
        if(!isset($_POST['website']) || $_POST['website']=="" || !filter_var($_POST['website'], FILTER_VALIDATE_URL)){
            array_push($errors, "Please enter a valid website URL.");
        }
        if(!isset($_POST['base64']) || $_POST['base64']==""){
            array_push($errors, "Please upload a logo.");
        }

        $name = mysqli_real_escape_string($con, $_POST['name']);
        $website = mysqli_real_escape_string($con, $_POST['website']);
        if(isset($_POST['base64']) || $_POST['base64']!=""){
            $base64string = $_POST['base64'];
            $logo = 'imgs/games/developers/'.strtolower(str_replace(" ", "_", clean($name))).".png";
            file_put_contents($logo, base64_decode($base64string));
        }
        if( !empty( $errors ) )
        {
            echo "false".$splitter.implode(",",$errors);
            return false;
        }

        $sql = "INSERT INTO tbl_gamedevelopers (name, logo, website)
VALUES ('$name', '$logo', '$website')";

        if (!mysqli_query($con, $sql)) {
            array_push($errors, "Error in the SQL: ".mysqli_error($con));
        }

        if( !empty( $errors ) )
        {
            echo "false".$splitter.implode(",",$errors);
            return false;
        }
        else{
            echo "true".$splitter."New Developer has been added.";
        }
    }
    if($_GET['action'] == "addpublisher"){
        if(!isset($_POST['name']) || $_POST['name']==""){
            array_push($errors, "Please enter the name of the publisher.");
        }
        if(!isset($_POST['website']) || $_POST['website']=="" || !filter_var($_POST['website'], FILTER_VALIDATE_URL)){
            array_push($errors, "Please enter a valid website URL.");
        }
        if(!isset($_POST['base64']) || $_POST['base64']==""){
            array_push($errors, "Please upload a logo.");
        }

        $name = mysqli_real_escape_string($con, $_POST['name']);
        $website = mysqli_real_escape_string($con, $_POST['website']);
        if(isset($_POST['base64']) || $_POST['base64']!=""){
            $base64string = $_POST['base64'];
            $logo = 'imgs/games/publishers/'.strtolower(str_replace(" ", "_", clean($name))).".png";
            file_put_contents($logo, base64_decode($base64string));
        }
        if( !empty( $errors ) )
        {
            echo "false".$splitter.implode(",",$errors);
            return false;
        }

        $sql = "INSERT INTO tbl_gamepublishers (name, logo, website)
VALUES ('$name', '$logo', '$website')";

        if (!mysqli_query($con, $sql)) {
            array_push($errors, "Error in the SQL: ".mysqli_error($con));
        }

        if( !empty( $errors ) )
        {
            echo "false".$splitter.implode(",",$errors);
            return false;
        }
        else{
            echo "true".$splitter."New Publisher has been added.";
        }
    }
    
    if($_GET['action'] == "addcharacter"){
        if(!isset($_POST['name']) || $_POST['name']==""){
            array_push($errors, "Please enter the name of the character.");
        }
        if(!isset($_POST['about']) || $_POST['about']==""){
            array_push($errors, "Please fill out some information on the character.");
        }
        if(!isset($_POST['base64']) || $_POST['base64']==""){
            array_push($errors, "Please upload a logo.");
        }

        $name = mysqli_real_escape_string($con, $_POST['name']);
        $about = mysqli_real_escape_string($con, $_POST['about']);
        if(isset($_POST['base64']) || $_POST['base64']!=""){
            $base64string = $_POST['base64'];
            $image = 'imgs/games/characters/'.strtolower(str_replace(" ", "_", clean($name))).".png";
            file_put_contents($image, base64_decode($base64string));
        }
        if( !empty( $errors ) )
        {
            echo "false".$splitter.implode(",",$errors);
            return false;
        }

        $sql = "INSERT INTO tbl_characters (name, image, about)
VALUES ('$name', '$image', '$about')";

        if (!mysqli_query($con, $sql)) {
            array_push($errors, "Error in the SQL: ".mysqli_error($con));
        }

        if( !empty( $errors ) )
        {
            echo "false".$splitter.implode(",",$errors);
            return false;
        }
        else{
            echo "true".$splitter."New Character has been added.";
        }
    }

    //Close database connection
    mysqli_close($con);

}
catch(Exception $ex)
{
    //Return error message
    $jTableResult = array();
    $jTableResult['Result'] = "ERROR";
    $jTableResult['Message'] = $ex->getMessage();
    print json_encode($jTableResult);
}

?>