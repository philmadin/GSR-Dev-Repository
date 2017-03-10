<?php
include "mysql_con.php";
include "videos-get.php";

if(!isset($_GET['title'])){
    header("Location: index.php");
}
$game_title=null;
if(isset($_GET['title'])){
    $game_title = mysqli_real_escape_string($con, str_replace("_", " ", $_GET['title']));
}

$gQUERY = mysqli_query($con, "SELECT * FROM tbl_games WHERE title = '$game_title'");
if(mysqli_num_rows($gQUERY)<1){header("Location: index.php");}
while ($gROW = mysqli_fetch_array($gQUERY)) {
    $game_id = $gROW['id'];
}

$g = file_get_contents("http://gamesharkreviews.com/api/games?id=".$game_id);
$games = json_decode($g);

$game = $games->{0};

function get_id($url){
    parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
    return $my_array_of_vars['v'];
}

?>
<!doctype html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="robots" content="index, follow, noarchive">

    <title><?php echo $game->title;?> | Wiki | GSR</title>

    <meta name="description" content="<?php echo $game->about;?>">
    <script data-cfasync="false">
        (function(r,e,E,m,b){E[r]=E[r]||{};E[r][b]=E[r][b]||function(){
                (E[r].q=E[r].q||[]).push(arguments)};b=m.getElementsByTagName(e)[0];m=m.createElement(e);
            m.async=1;m.src=("file:"==location.protocol?"https:":"")+"//s.reembed.com/G-nOLay1.js";
            b.parentNode.insertBefore(m,b)})("reEmbed","script",window,document,"api");
    </script>
    <?php include "links.php"; ?>

    <style>

    </style>

</head>

<body>
<?php include "header.php"; ?>

<div id="wiki-page" class="container_24">

        <div id="game-cover">
            <div id="game-cover-container">
                <img src="<?php echo $game->cover;?>" />
            </div>
        </div>
        <h1><?php echo $game->title;?></h1>

    <div id="tabs">
        <ul>
            <!--TABS-->
            <li><a href="#tabs-overview">Overview</a></li>
            <?php if(!is_null($game->reviews)){echo '<li><a href="#tabs-reviews">Reviews</a></li>';}?>
            <?php if(!is_null($game->guides)){echo '<li><a href="#tabs-guides">Guides</a></li>';}?>
            <?php if(!is_null($game->characters)){echo '<li><a href="#tabs-characters">Characters</a></li>';}?>
            <?php if(!is_null($game->weapons)){echo '<li><a href="#tabs-weapons">Weapons</a></li>';}?>
            <?php if(!is_null($game->levels)){echo '<li><a href="#tabs-levels">Levels</a></li>';}?>
            <?php if(!is_null($game->missions)){echo '<li><a href="#tabs-missions">Missions</a></li>';}?>
            <?php if(!is_null($game->cheats)){echo '<li><a href="#tabs-cheats">Cheats</a></li>';}?>
            <?php if(!is_null($game->videos)){echo '<li><a href="#tabs-videos">Videos</a></li>';}?>

        </ul>
        <div id="tabs-overview" class="wiki-section">
                <ul class="wiki-list-1">
                    <?php if(!is_null($game->release_date)){ ?>
                        <li>
                            <b>Release Date: </b>
                            <?php echo date('F j, Y', strtotime($game->release_date)); ?>
                        </li>
                    <?php } ?>

                    <li>
                        <b>Developer(s): </b>
                        <?php $i=0;foreach($game->developers as $developer){if($i!=0){echo ", ";}echo '<a target="_blank" href="'.$developer->website.'">'.$developer->name.'</a>';$i++;}?>
                    </li>

                    <li>
                        <b>Publisher(s): </b>
                        <?php $i=0;foreach($game->publishers as $publisher){if($i!=0){echo ", ";}echo '<a target="_blank" href="'.$publisher->website.'">'.$publisher->name.'</a>';$i++;}?>
                    </li>

                    <li>
                        <b>Genre(s): </b>
                        <?php $i=0;foreach($game->genres as $genre){if($i!=0){echo ", ";}echo $genre;$i++;}?>
                    </li>

                    <li>
                        <b>Official Website: </b>
                        <a target="_blank" href="<?php echo $game->website;?>"><?php echo $game->website;?></a>
                    </li>

                    <li>
                        <b>GSR Rating: </b>
                        <?php if(!is_null($game->rating)){echo $game->rating."/10";} else{echo "Not yet reviewed";}?>
                    </li>

                </ul>
        </div>
        <?php if(!is_null($game->characters)){ ?>
            <div id="tabs-characters" class="wiki-section">
                <span class="wiki-subtitle">CHARACTERS</span>
                    <ul>
                        <?php foreach($game->characters as $character){ ?>
                            <li><?php echo $character->name;?></li>
                        <?php } ?>
                    </ul>
            </div>
        <?php } ?>
        <?php if(!is_null($game->reviews)){ ?>
            <div id="tabs-reviews" class="wiki-section">
                <span class="wiki-subtitle">REVIEWS</span>
                    <ul>
                        <?php foreach($game->reviews as $review){ ?>
                            <li><a href="<?php echo $review->url;?>"><?php echo $review->title;?></a></li>
                        <?php } ?>
                    </ul>
            </div>
        <?php } ?>
        <?php if(!is_null($game->guides)){ ?>
            <div id="tabs-guides" class="wiki-section">
                <span class="wiki-subtitle">GUIDES</span>
                    <ul>
                        <?php foreach($game->guides as $guide){ ?>
                            <li><a href="<?php echo $guide->url;?>"><?php echo $guide->title;?></a></li>
                        <?php } ?>
                    </ul>
            </div>
        <?php } ?>
        <?php if(!is_null($game->levels)){ ?>
            <div id="tabs-levels" class="wiki-section">
                <span class="wiki-subtitle">LEVELS</span>
                <?php echo $game->levels; ?>
            </div>
        <?php } ?>
        <?php if(!is_null($game->missions)){ ?>
            <div id="tabs-missions" class="wiki-section">
                <span class="wiki-subtitle">MISSIONS</span>
                <?php echo $game->missions; ?>
            </div>
        <?php } ?>
        <?php if(!is_null($game->weapons)){ ?>
            <div id="tabs-weapons" class="wiki-section">
                <span class="wiki-subtitle">WEAPONS</span>
                <?php echo $game->weapons; ?>
            </div>
        <?php } ?>
        <?php if(!is_null($game->cheats)){ ?>
            <div id="tabs-cheats" class="wiki-section">
                <span class="wiki-subtitle">CHEATS</span>
                <?php echo $game->cheats; ?>
            </div>
        <?php } ?>
        <?php if(!is_null($game->videos)){ ?>
            <div id="tabs-videos" class="wiki-section">
                <span class="wiki-subtitle">VIDEOS & TRAILERS</span>
                    <?php foreach($game->videos as $video){ ?>
                        <?php echo '<iframe style="width:100%;height:400px;margin-bottom:20px;" src="https://www.youtube.com/embed/'.get_id($video).'?rel=0" frameborder="0" allowfullscreen></iframe>'; ?>
                    <?php } ?>
            </div>
        <?php } ?>

    </div>


</div>


<?php include "footer.html"; ?>
<script type="text/javascript">

    $(function() {
        $( "#tabs" ).tabs({
            hide: { effect: "fade", direction:"right", duration: 150 },
            show: { effect: "fade", direction:"left", duration: 150 }
        });
    });

</script>
</body>
</html>