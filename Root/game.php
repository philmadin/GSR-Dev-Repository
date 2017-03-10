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
        #wiki-header{
            width:100%;
            height:300px;
            display:block;
            position:relative;
        }

        #game-main-image{
            width:208px;
            height:188px;
            background-image:url(imgs/logo-area.png);
            left:50%;
            bottom:-50px;
            margin-left:-104px;
            position:absolute;
            display:block;
            z-index:2;
        }

        #game-main-image img{
            max-width:100%;
            max-height:100%;
        }

        #game-info-bar{
            width:100%;
            display:block;
            background-color:#E73030;
            height:60px;
            list-style-type:none;
            margin:0;
            line-height:60px;
        }

        #game-info-bar li{
            display:inline-block;
            width:478px;
            height:60px;
            line-height:60px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            margin:0;
        }

        #game-info-bar li.left{
            text-align:right;
            padding-right:150px;
        }

        #game-info-bar li.right{
            text-align:left;
            padding-left:150px;
        }

        #game-info-bar li a{
            color:white;
            font-size:18px;
            display:inline-block;
            margin-left:10px;
            margin-right:10px;
        }

        #game-info-bar li a:hover{
            color:#000000;
        }

        #header-background-container{
            width:100%;
            height:100%;
            position:absolute;
            top:0;
            left:0;
            background-size:auto 100%;/*width x height*/
            background-position:center;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            border-left:solid 3px #CF1F1B;
            border-top:solid 3px #CF1F1B;
            border-right:solid 3px #CF1F1B;
            background-color:#CF1F1B;
            z-index:1;
        }

        #header-background-image-left{
            width:475px;
            display:inline-block;
            height:100%;
            border:none;
            background-color:transparent;
            background-size:cover;
            background-image:url(<?php echo $game->cover;?>);
            -moz-box-shadow:    inset 0 0 10px #000000;
            -webkit-box-shadow: inset 0 0 10px #000000;
            box-shadow:         inset 0 0 10px #000000;
        }

        #header-background-image-right{
            width:475px;
            display:inline-block;
            height:100%;
            border:none;
            background-color:transparent;
            background-size:cover;
            background-image:url(<?php echo $game->cover;?>);
            -moz-box-shadow:    inset 0 0 10px #000000;
            -webkit-box-shadow: inset 0 0 10px #000000;
            box-shadow:         inset 0 0 10px #000000;
        }


        #banner-container{
            width:100%;
            display:block;
            height:150px;
            text-align:center;
        }

        #banner-container #left-wing{
            display:inline-block;
            background-image:url(imgs/left.png);
            width:111px;
            margin-top:5px;
            height:100px;
            vertical-align: top;
        }

        #banner-title-container{
            width:365px;
            height:auto;
            display:inline-block;
            vertical-align: top;
        }

        #banner-title-top{
            width:365px;
            height:45px;
            background-image:url(imgs/middle_top.png);
            display:block;
        }

        #banner-title{
            width:365px;
            height:auto;
            display:block;
            background-color:white;
            min-height:30px;
            font-size:30px;
            color:#e73030;
        }

        #banner-title-bottom{
            width:365px;
            height:74px;
            background-image:url(imgs/middle_bottom.png);
            display:block;
        }

        #banner-container #right-wing{
            display:inline-block;
            margin-top:5px;
            background-image:url(imgs/right.png);
            width:111px;
            height:100px;
            vertical-align: top;
        }



        .ui-tooltip {
            padding: 0;
            color: black;
            box-shadow: 0 0 7px #e73030;
            background:none;
            border:solid 1px #e73030;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;

        }

        .ui-tooltip ul{
            width:300px;
            background-color:transparent;
            margin:0;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            -moz-box-shadow:    inset 0 0 10px #000000;
            -webkit-box-shadow: inset 0 0 10px #000000;
            box-shadow:         inset 0 0 10px #000000;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
        }

        .ui-tooltip ul li{
            display:block;
            height:30px;
            background-color:rgba(255, 255, 255, 1);
            text-align:center;
            margin:0;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
        }

        .ui-tooltip ul li a{
            color:#e73030;
            width:100%;
            height:100%;
            line-height:30px;
            font-size:16px;
            display:inline-block;
            text-indent:30px;
            text-align:left;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        #game-content-container{
            width:787px;
            margin:auto;
        }

        #website-bar{
            margin-top:10px;
            margin-bottom:5px;
            width:100%;
            background-color:#E73030;
            display:block;
            height:40px;
            line-height:40px;
            color:white;
            text-align:center;
            position:relative;
        }

        #website-bar:before{
            content: "";
            position: absolute;
            display: block;
            background-color: rgba(255,255,255,1);
            width: 60px;
            height: 60px;
            top: -30px;
            left: -40px;
            -ms-transform: rotate(30deg);
            -webkit-transform: rotate(30deg);
            transform: rotate(30deg);
        }


        #website-bar:after{
            content: "";
            position: absolute;
            display: block;
            background-color: rgba(255,255,255,1);
            width: 60px;
            height: 60px;
            top: -30px;
            right: -40px;
            -ms-transform: rotate(-30deg);
            -webkit-transform: rotate(-30deg);
            transform: rotate(-30deg);
        }

        .game-content-block{
            width:100%;
            display:block;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .game-content-subtitle, .game-content-subtitle.inactive{
            width:100%;
            height:40px;
            line-height:40px;
            color:#FFF;
            background-color:#393939;
            display:block;
            font-size:16px;
            text-indent:20px;
            cursor:pointer;
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }

        .game-content-subtitle:hover{
            color:#e73030;
        }

        .game-content-block.active .game-content-subtitle{
            text-indent:15px;
        }

        .game-content-block.active .game-content-subtitle .game-content-subtitle-arrow.fa-caret-right:before{
            content: "\f0d7";
        }

        .game-content-block.inactive .game-content-subtitle .game-content-subtitle-arrow.fa-caret-right:before{
            content: "\f0da";
        }

        .game-content-subtitle-arrow{
            vertical-align:middle;
            margin-right:15px;
        }

        .game-content-block.active .game-content-subtitle .game-content-subtitle-arrow{
            margin-right:18px;
        }

        .game-content{
            padding:15px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }


    </style>

</head>

<body>
<?php include "header.php"; ?>

<div id="wiki-page" class="container_24">

<div id="game-info-tooltips" style="display:none;">
    <div id="genres">
        <ul>
            <?php foreach($game->genres as $genre){ ?>
                <li><a href="#"><?php echo $genre;?></a></li>
            <?php } ?>
        </ul>
    </div>
    <div id="developers">
        <ul>
            <?php foreach($game->developers as $developer){ ?>
                <li><a href="<?php echo $developer->website;?>"><?php echo $developer->name;?></a></li>
            <?php } ?>
        </ul>
    </div>
    <div id="publishers">
        <ul>
            <?php foreach($game->publishers as $publisher){ ?>
                <li><a href="<?php echo $publisher->website;?>"><?php echo $publisher->name;?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>

<div id="wiki-header">

    <div id="header-background-container">
        <div id="header-background-image-left"></div>
        <div id="header-background-image-right"></div>
    </div>

    <div id="game-main-image">
        <!--<img src="<?php echo $game->cover;?>" />-->
    </div>

</div>


    <ul id="game-info-bar">
        <li class="left">
            <a class='info-tooltip' data-info-type="genres" href="#" title><i class="fa fa-caret-up" aria-hidden="true"></i> Genres</a>
        </li>
        <li class="right">
            <a class='info-tooltip' data-info-type="developers" href="#" title><i class="fa fa-caret-up" aria-hidden="true"></i> Developers</a>
            <a class='info-tooltip' data-info-type="publishers" href="#" title><i class="fa fa-caret-up" aria-hidden="true"></i> Publishers</i></a>
        </li>
    </ul>

    <div id="banner-container">
        <div id="left-wing"></div>
        <div id="banner-title-container">
            <div id="banner-title-top"></div>
            <div id="banner-title"><?php echo $game->title;?></div>
            <div id="banner-title-bottom"></div>
        </div>
        <div id="right-wing"></div>
    </div>


    <div id="game-content-container">

        <div id="website-bar"><?php echo $game->website;?></div>

        <div class="game-content-block">
            <div class="game-content-subtitle"><i class="fa fa-caret-right fa-2x game-content-subtitle-arrow" aria-hidden="true"></i> About</div>
            <div class="game-content">
                This is the about this is lorem ipsum is the about about about ipsum
                This is the about this is lorem ipsum is the about about about ipsum
                This is the about this is lorem ipsum is the about about about ipsum
                This is the about this is lorem ipsum is the about about about ipsum
                This is the about this is lorem ipsum is the about about about ipsum
                This is the about this is lorem ipsum is the about about about ipsum
                This is the about this is lorem ipsum is the about about about ipsum
                This is the about this is lorem ipsum is the about about about ipsum
                This is the about this is lorem ipsum is the about about about ipsum
                This is the about this is lorem ipsum is the about about about ipsum
                This is the about this is lorem ipsum is the about about about ipsum
                This is the about this is lorem ipsum is the about about about ipsum
                This is the about this is lorem ipsum is the about about about ipsum
                This is the about this is lorem ipsum is the about about about ipsum
                This is the about this is lorem ipsum is the about about about ipsum
                This is the about this is lorem ipsum is the about about about ipsum
            </div>
        </div>

    </div>


</div>


<?php include "footer.html"; ?>
<script type="text/javascript">

    $(function(){

        $(".game-content-subtitle").each(function(){
            $(this).parent().data("display", "block").addClass("active");
            $(this).click(function(){
                var content_block = $(this).parent();

                if(content_block.data("display")=="block"){
                    content_block.removeClass('active').addClass('inactive');
                    content_block.find(".game-content").hide("slow", function(){
                        content_block.data("display", "none");
                    });
                }

                if(content_block.data("display")=="none"){
                    content_block.removeClass('inactive').addClass('active');
                    content_block.find(".game-content").show("slow", function(){
                        content_block.data("display", "block");
                    });
                }


            });
        });




        $(document).tooltip();
        $(".info-tooltip").tooltip({
            position: { my: "right bottom+10", at: "right top", collision: "flipfit" },
            content:function(){
            var info_type = $(this).attr("data-info-type");

            return $("#game-info-tooltips #"+info_type).html();
            },
            hide: { effect: "fade", duration: 1 },
            show: { effect: "fade", duration: 1 }
        });
    });
</script>
</body>
</html>