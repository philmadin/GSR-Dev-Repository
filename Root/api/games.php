<?php
 header('Access-Control-Allow-Origin: *');  
include 'mysql_con.php';
function average($arr) {
    $count = count($arr); //total numbers in array
    foreach ($arr as $value) {
        $total = $total + $value; // total value of array numbers
    }
    $average = ($total/$count); // get average value
    return (int)$average;
}


$error_json = array();
$games_ar = array();
if($_GET['debug']=="true"){
    $debugmode = true;
}
else{
    $debugmode = false;
}

//QUERIES

$get_games = null;

if(isset($_GET['id']) && isset($_GET['title']) && isset($_GET['genre']) && isset($_GET['platform']))
{
    $get_games = mysqli_query($con, "SELECT * FROM tbl_games"." ORDER BY title ASC");
}
if(!isset($_GET['id']) && !isset($_GET['title']) && !isset($_GET['genre']) && !isset($_GET['platform']))
{
    $get_games = mysqli_query($con, "SELECT * FROM tbl_games"." ORDER BY title ASC");
}
else{
    if(isset($_GET['id'])){
        if(is_numeric ($_GET['id'])){
            $get_games = mysqli_query($con, "SELECT * FROM tbl_games WHERE id=".$_GET['id']." ORDER BY title ASC");
        }
        else{
            $error_json[] = "__ERROR__: Game ID was not numeric.";
        }
    }
    if(isset($_GET['genre'])){
        if(is_numeric ($_GET['genre'])){
            $get_games = mysqli_query($con, "SELECT * FROM tbl_games WHERE FIND_IN_SET(".$_GET['genre'].", genres)"." ORDER BY title ASC");
        }
        else{
            $error_json[] = "__ERROR__: Genre ID was not numeric.";
        }
    }
    if(isset($_GET['platform'])){
        if(is_numeric ($_GET['platform'])){
            $get_games = mysqli_query($con, "SELECT * FROM tbl_games WHERE FIND_IN_SET(".$_GET['platform'].", platforms)"." ORDER BY title ASC");
        }
        else{
            $error_json[] = "__ERROR__: Platform ID was not numeric.";
        }
    }
    if(isset($_GET['title'])){
        $get_games = mysqli_query($con, "SELECT * FROM tbl_games WHERE title='" . mysqli_real_escape_string($con, $_GET['title']) . "'"." ORDER BY title ASC");
    }
}

//QUERIES

if (mysqli_num_rows($get_games) == 0) {
    $error_json[] = "__ERROR__: Game not found.";
}
else{
    while ($game = mysqli_fetch_assoc($get_games)) {
        $game_ar = array();

        $game_ar['id'] = $game['id'];
        $game_ar['title'] = $game['title'];

        if(!is_null($game['about'])) {$game_ar['about'] = nl2br(str_replace("[bullet]", "&bull;", $game['about']));}else{$game_ar['about']=null;}
        if(!is_null($game['storyline'])) {$game_ar['storyline'] = nl2br(str_replace("[bullet]", "&bull;", $game['storyline']));}else{$game_ar['storyline']=null;}
        if(!is_null($game['release_date'])) {$game_ar['release_date'] = $game['release_date'];}else{$game_ar['release_date']=null;}
        if(!is_null($game['website'])) {$game_ar['website'] = $game['website'];}else{$game_ar['website']=null;}
        if(!is_null($game['image'])) {$game_ar['cover'] = "http://gamesharkreviews.com/".$game['image'];}else{$game_ar['cover']="http://gamesharkreviews.com/imgs/games/covers/404.jpg";}


        //REVIEWS & RATING
        $get_reviews = mysqli_query($con, "SELECT * FROM tbl_review WHERE game_id=".$game['id']." ORDER BY title ASC");
        if (mysqli_num_rows($get_reviews) == 0) {
            $game_ar['rating']=null;
            $game_ar['reviews']=null;
        }
        else{
                $rating_ar = array();
                $review_ar = array();
            while ($review = mysqli_fetch_assoc($get_reviews)) {
                array_push($rating_ar, $review['main_rating']);
                $reviews = array();
                $reviews['id']	= $review['id'];
                $reviews['title']	= $review['title'];
                $reviews['rating'] = (int)$review['main_rating'];
                $reviews['url']	= "http://gamesharkreviews.com/review.php?t=" . urlencode(str_replace(" ", "_", $review['title'])) . "&g=" . urlencode(str_replace(" ", "_", $review['gamename']));
                array_push($review_ar, $reviews);
                
            }
            $game_ar['rating'] = average($rating_ar);
            $game_ar['reviews'] = $review_ar;
        }
        //REVIEWS & RATING


        //GUIDES
        $get_guides = mysqli_query($con, "SELECT * FROM tbl_guide WHERE game_id=".$game['id']." ORDER BY title ASC");
        if (mysqli_num_rows($get_guides) == 0) {
            $game_ar['guides']=null;
        }
        else{
            $guide_ar = array();
            while ($guide = mysqli_fetch_assoc($get_guides)) {
                $guides = array();
                $guides['id']	= $guide['id'];
                $guides['title']	= $guide['title'];
                $guides['url']	= "http://gamesharkreviews.com/guide.php?t=" . urlencode(str_replace(" ", "_", $guide['title']));
                array_push($guide_ar, $guides);
                
            }
            $game_ar['guides'] = $guide_ar;
        }
        //GUIDES

        //ARTICLES
        $get_guides = mysqli_query($con, "SELECT * FROM tbl_guide WHERE game_id=".$game['id']." ORDER BY title ASC");
        if (mysqli_num_rows($get_guides) == 0) {
            $game_ar['guides']=null;
        }
        else{
            $guide_ar = array();
            while ($guide = mysqli_fetch_assoc($get_guides)) {
                $guides = array();
                $guides['id']	= $guide['id'];
                $guides['title']	= $guide['title'];
                $guides['url']	= "http://gamesharkreviews.com/guide.php?t=" . urlencode(str_replace(" ", "_", $guide['title']));
                array_push($guide_ar, $guides);

            }
            $game_ar['guides'] = $guide_ar;
        }
        //ARTICLES


        //PUBLISHERS
        if(!is_null($game['publishers'])) {
            $publishers = explode(",", $game['publishers']);
            $game_ar['publishers'] = array();
            foreach ($publishers as $publisher_id) {
                $get_publisher = mysqli_query($con, "SELECT * FROM tbl_gamepublishers WHERE id=$publisher_id"." ORDER BY name ASC");
                if (mysqli_num_rows($get_publisher) == 0) {
                    $error_json[] = "__ERROR__: Publisher with ID: " . $publisher_id . " was not found.";
                } else {
                    while ($publisher = mysqli_fetch_assoc($get_publisher)) {
                        $publisher_ar = array();
                        $publisher_ar['logo'] = "http://gamesharkreviews.com/".$publisher['logo'];
                        $publisher_ar['name'] = $publisher['name'];
                        $publisher_ar['website'] = $publisher['website'];
                        array_push($game_ar['publishers'], $publisher_ar);
                    }
                }
            }
        }
        else{
            $game_ar['publishers']=null;
        }
        //PUBLISHERS

        //GENRES
        if(!is_null($game['genres'])) {
            $genres = explode(",", $game['genres']);
            $game_ar['genres'] = array();
            foreach ($genres as $genre_id) {
                $get_genre = mysqli_query($con, "SELECT * FROM tbl_genres WHERE id=$genre_id"." ORDER BY genre ASC");
                if (mysqli_num_rows($get_genre) == 0) {
                    $error_json[] = "__ERROR__: Genre with ID: " . $genre_id . " was not found.";
                } else {
                    while ($genre = mysqli_fetch_assoc($get_genre)) {
                        array_push($game_ar['genres'], $genre['genre']);
                    }
                }
            }
        }
        else{
            $game_ar['genres']=null;
        }
        //GENRES

        //DEVELOPERS
        if(!is_null($game['developers'])) {
            $developers = explode(",", $game['developers']);
            $game_ar['developers'] = array();
            foreach ($developers as $developer_id) {
                $get_developer = mysqli_query($con, "SELECT * FROM tbl_gamedevelopers WHERE id=$developer_id"." ORDER BY name ASC");
                if (mysqli_num_rows($get_developer) == 0) {
                    $error_json[] = "__ERROR__: Developer with ID: " . $developer_id . " was not found.";
                } else {
                    while ($developer = mysqli_fetch_assoc($get_developer)) {
                        $developer_ar = array();
                        $developer_ar['logo'] = "http://gamesharkreviews.com/".$developer['logo'];
                        $developer_ar['name'] = $developer['name'];
                        $developer_ar['website'] = $developer['website'];
                        array_push($game_ar['developers'], $developer_ar);
                    }
                }
            }
        }
        else{
            $game_ar['developers']=null;
        }
        //DEVELOPERS

        //PLATFORMS
        if(!is_null($game['platforms'])) {
            $platforms = explode(",", $game['platforms']);
            $game_ar['platforms'] = array();
            foreach ($platforms as $platform_id) {
                $get_platform = mysqli_query($con, "SELECT * FROM tbl_platforms WHERE id=$platform_id"." ORDER BY name ASC");
                if (mysqli_num_rows($get_platform) == 0) {
                    $error_json[] = "__ERROR__: Platform with ID: " . $platform_id . " was not found.";
                } else {
                    while ($platform = mysqli_fetch_assoc($get_platform)) {
                        array_push($game_ar['platforms'], $platform['name']);
                    }
                }
            }
        }
        else{
            $game_ar['platforms']=null;
        }
        //PLATFORMS

        //DESIGNERS
        if(!is_null($game['designers'])) {
            $designers = explode(",", $game['designers']);
            $game_ar['designers'] = array();
            foreach($designers as $designer){
                array_push($game_ar['designers'], $designer);
            }
        }
        else{
            $game_ar['designers']=null;
        }
        //DESIGNERS


        //CHARACTERS
        if(!is_null($game['characters'])) {
            $characters = explode(",", $game['characters']);
            $game_ar['characters'] = array();
            foreach ($characters as $character_id) {
                $get_character = mysqli_query($con, "SELECT * FROM tbl_characters WHERE id=$character_id"." ORDER BY name ASC");
                if (mysqli_num_rows($get_character) == 0) {
                    $error_json[] = "__ERROR__: Character with ID: " . $character_id . " was not found.";
                } else {
                    while ($character = mysqli_fetch_assoc($get_character)) {
                        $character_ar = array();
                        $character_ar['name'] = $character['name'];
                        $character_ar['about'] = nl2br(str_replace("[bullet]", "&bull;", $character['about']));
                        $character_ar['image'] = "http://gamesharkreviews.com/".$character['image'];

                        array_push($game_ar['characters'], $character_ar);
                    }
                }
            }
        }
        else{
            $game_ar['characters']=null;
        }
        //CHARACTERS

        if(!is_null($game['levels'])) {$game_ar['levels'] = nl2br(str_replace("[bullet]", "&bull;", $game['levels']));}else{$game_ar['levels']=null;}
        if(!is_null($game['missions'])) {$game_ar['missions'] = nl2br(str_replace("[bullet]", "&bull;", $game['missions']));}else{$game_ar['missions']=null;}
        if(!is_null($game['weapons'])) {$game_ar['weapons'] = nl2br(str_replace("[bullet]", "&bull;", $game['weapons']));}else{$game_ar['weapons']=null;}
        if(!is_null($game['cheats'])) {$game_ar['cheats'] = nl2br(str_replace("[bullet]", "&bull;", $game['cheats']));}else{$game_ar['cheats']=null;}

        //VIDEOS
        if(!is_null($game['videos'])) {
            $videos = explode(",", $game['videos']);
            $game_ar['videos'] = array();
            foreach($videos as $video){
                array_push($game_ar['videos'], $video);
            }
        }
        else{
            $game_ar['videos']=null;
        }
        //VIDEOS


        array_push($games_ar, $game_ar);
    }
}


if(count($error_json)>0){
    header('Content-Type: application/json');
    die( json_encode( $error_json , JSON_FORCE_OBJECT) );
}

if($debugmode==true){
    echo '<pre>';
    var_dump($games_ar);
    echo '</pre>';
    return false;
}
else{
    header('Content-Type: application/json');
    echo json_encode($games_ar, JSON_FORCE_OBJECT);
}

?>