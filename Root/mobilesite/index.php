<?php
include "mysql_con.php";
//include_once("videos-get.php");
//$v = channelVideos();


?>

<!doctype html>
<html>
<head>

    <meta name="keywords" content="game, shark, reviews, gsr, games, review">

    <title>Game Shark Reviews | GSR | Homepage</title>

    <meta name="description" content="Welcome to GSR - Game Shark Reviews - one of the world's best online gaming hubs!">

    <?php include "externals.php"; ?>

    <script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "WebSite",
  "url": "http://gamesharkreviews.com/",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "http://gamesharkreviews.com/search.php?q={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>


<script>

	$(document).ready(function($) {
		$("#video-list").load("http://gamesharkreviews.com/videoStatic.html");
	});
</script>

</head>

<body>
<?php include "sidebar.php" ?>


<div id="page" class="canvas">


    <?php include "header.php"; ?>

    
    <header id="featuredArticles" class="carousel slide">
        <!-- Indicators -->
        <ol class="carousel-indicators">

            <?php
            $featured_ar = mysqli_query($con, "SELECT * FROM tbl_featured WHERE position!=0 AND article_type!='Video' ORDER BY position ASC LIMIT 5");
            $slide_num = -1;
            while ($ft_row = mysqli_fetch_assoc($featured_ar)) {
                $slide_num++;
                ?>

                <!--SLIDER CODE GOES HERE-->
                <li data-target="#featuredArticles" data-slide-to="<?php echo $slide_num;?>" class="<?php if($slide_num==0){echo 'active';}?>"></li>

            <?php } ?>



        </ol>

        <!-- Wrapper for Slides -->
        <div class="carousel-inner">



            <?php
            $featured_ar = mysqli_query($con, "SELECT * FROM tbl_featured WHERE position!=0 AND article_type!='Video' ORDER BY position ASC LIMIT 5");
            $slide_num = -1;
            while ($ft_row = mysqli_fetch_assoc($featured_ar)) {
                $slide_num++;
                $article_type = $ft_row['article_type'];
                $article_id = $ft_row['article_id'];
                $video_id = $ft_row['video_id'];
                if($article_type=="Video"){
                    $ft_title = $v[$video_id]['snippet']['title'];
                    $ft_image = "http://img.youtube.com/vi/".$video_id."/maxresdefault.jpg";
                    $ft_url   = "video.php?id=".$video_id;
                    $ft_summary = null;
                }
                if($article_type=="Guide"){
                    $guide_ar = mysqli_query($con, "SELECT * FROM tbl_guide WHERE id = $article_id");
                    while ($guide_row = mysqli_fetch_assoc($guide_ar)) {
                        $ft_title = $guide_row['title'];
                        $ft_images 	= unserialize($guide_row['images']);
                        $ft_image   = "http://gamesharkreviews.com/imgs/guide/".urlencode($ft_images[0]);
                        $ft_url     = "guide.php?t=" . urlencode(str_replace(" ", "_", $ft_title));
                        $ft_summary = null;
                    }
                }
                if($article_type=="Opinion"){
                    $opinion_ar = mysqli_query($con, "SELECT * FROM tbl_opinion WHERE id = $article_id");
                    while ($op_row = mysqli_fetch_assoc($opinion_ar)) {
                        $ft_title = $op_row['title'];
                        $ft_image = "http://gamesharkreviews.com/imgs/opinion/".urlencode($op_row['a_image']);
                        $ft_url     = "opinion.php?t=" . urlencode(str_replace(" ", "_", $ft_title));
                        $ft_summary = null;
                    }
                }
                if($article_type=="News"){
                    $news_ar = mysqli_query($con, "SELECT * FROM tbl_news WHERE id = $article_id");
                    while ($op_row = mysqli_fetch_assoc($news_ar)) {
                        $ft_title = $op_row['title'];
                        $ft_image = "http://gamesharkreviews.com/imgs/news/".urlencode($op_row['a_image']);
                        $ft_url     = "news.php?t=" . urlencode(str_replace(" ", "_", $ft_title));
                        $ft_summary = null;
                    }
                }
                if($article_type=="Review"){
                    $review_ar = mysqli_query($con, "SELECT * FROM tbl_review WHERE id = $article_id");
                    while ($rvw_row = mysqli_fetch_assoc($review_ar)) {
                        $ft_title = $rvw_row['title'];
                        $ft_game	= $rvw_row['gamename'];
                        $ft_image = "http://gamesharkreviews.com/imgs/review/".urlencode($rvw_row['a_image']);
                        $ft_url	= "review.php?t=" . urlencode(str_replace(" ", "_", $ft_title)) . "&g=" . urlencode(str_replace(" ", "_", $ft_game));
                        $ft_summary = $rvw_row['summary'];
                    }
                }


                ?>

                <!--SLIDER CODE GOES HERE-->
                <a href="<?php echo $ft_url;?>" class="item <?php if($slide_num==0){echo 'active';}?>">
                    <!-- Set the first background image using inline CSS below. -->
                    <div class="fill" style="background-image:url('<?php echo $ft_image;?>');"></div>
                    <div class="carousel-caption">
                        <h2><?php echo $ft_title;?></h2>
                    </div>
                </a>

            <?php } ?>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#featuredArticles" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#featuredArticles" data-slide="next">
            <span class="icon-next"></span>
        </a>

    </header>


    <div class="container">

        <div class="row">

            <div class="col-lg-12 list-block">

                    <h3 class="subtitle">LATEST ARTICLES</h3>


                    <?php
                    $art_row = array();

                    $review_link_list = mysqli_query($con, "SELECT * FROM tbl_review WHERE alpha_approved = 'true' ORDER BY id DESC LIMIT 4");
                    while ($rvw_row = mysqli_fetch_assoc($review_link_list)) {
                        array_push($art_row, $rvw_row);
                    }
                    $opinion_link_list = mysqli_query($con, "SELECT * FROM tbl_opinion WHERE alpha_approved = 'true' ORDER BY id DESC LIMIT 4");
                    while ($op_row = mysqli_fetch_assoc($opinion_link_list)) {
                        array_push($art_row, $op_row);
                    }
                    $news_link_list = mysqli_query($con, "SELECT * FROM tbl_news WHERE alpha_approved = 'true' ORDER BY id DESC LIMIT 4");
                    while ($nws_row = mysqli_fetch_assoc($news_link_list)) {
                        array_push($art_row, $nws_row);
                    }
                    $guide_link_list = mysqli_query($con, "SELECT * FROM tbl_guide WHERE alpha_approved = 'true' ORDER BY id DESC LIMIT 4");
                    while ($gd_row = mysqli_fetch_assoc($guide_link_list)) {
                        array_push($art_row, $gd_row);
                    }

                    usort($art_row, 'date_compare');
                    $art_row = array_slice($art_row, 0, 4);

                    foreach ($art_row as $article_row) {
                        $art_name	= $article_row['title'];
                        $art_game	= $article_row['gamename'];
                        $art_desc	= $article_row['summary'];
                        $art_rate	= $article_row['main_rating'];
                        $art_file	= urlencode($article_row['a_image']);
                        $art_auth	= $article_row['author'];
                        $art_plat	= $article_row['platform'];
                        $art_type	= strtolower($article_row['article_type']);
                        $art_tags 	= $article_row['tags'];
                        if($art_type=="Guide"){
                            $art_file = urlencode(unserialize($article_row['images'])[0]);
                        }
                        $art_date	= strtotime($article_row['createdate']);
                        $art_rdat	= strtotime($article_row['release_date']);
                        if($art_type=="review"){
                            $art_url	= "review.php?t=" . urlencode(str_replace(" ", "_", $art_name)) . "&g=" . urlencode(str_replace(" ", "_", $art_game));
                        }
                        if($art_type=="opinion"){
                            $art_url	= "opinion.php?t=" . urlencode(str_replace(" ", "_", $art_name));
                        }
                        if($art_type=="news"){
                            $art_url	= "news.php?t=" . urlencode(str_replace(" ", "_", $art_name));
                        }
                        if($art_type=="guide"){
                            $art_url	= "guide.php?t=" . urlencode(str_replace(" ", "_", $art_name));
                        }
                        ?>

                        <div onclick="document.location='<?php echo $art_url;?>'" class="col-lg-12 article-item">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3">
                                        <img class="article-preview" src="http://gamesharkreviews.com/imgs/<?php echo $art_type."/".$art_file;?>" />
                                    </div>
                                    <div class="col-lg-9 col-md-9">
                                        <h4><?php echo $art_name;?></h4>
                                        <p><?php echo $art_desc;?></p>
                                        <a href="#"><?php echo $art_auth;?></a> - <?php echo date("j F Y", $art_date); ?><br />
                                        <?php
                                        $explode_tags = explode(", ", $art_tags);
                                        foreach ($explode_tags as $tagvalue) {
                                            //echo "<a style='white-space:normal;' class='label label-default' rel='nofollow' href='search.php?q=".urlencode($tagvalue)."'>" . $tagvalue . "</a>";
                                        }
                                        ?>


                                    </div>
                                </div>
                        </div>

                    <?php } ?>



            </div>

        </div>

        <div class="row">

            <div class="col-lg-12 list-block">

                    <h3 class="subtitle">LATEST VIDEOS</h3>

		<ul id="video-list">
                    	<li class="video_link"><a href="videos.php" class="full grid_4">SEE MORE</a></li>
                </ul>
                    <!-- <ul id="video-list" class="col-lg-12"><center><h5>Loading Videos...</h5></center></ul> -->


            </div>

        </div>



        <?php include "footer.php"; ?>

    </div>







    <script>

        $(function(){
            function timeFormat(timeD){
                return timeD.replace("PT","").replace("H",":").replace("M",":").replace("S","");
            }

            /*$.get("videos-get.php?video-list=true", function(data){
                $("#video-list").fadeOut("fast",function(){
                    $(this).html("");

                    var v = eval('(' + data + ')');
                    //console.log(data);
                    v.i = v.i.slice(0, 6);
                    v.i.reverse();
                    for (d = 0; d < v.i.length; d++) {
                        var vhtml 	 = '<li class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><a data-id="'+v.i[d].id+'" class="video-contain" href="video.php?id='+v.i[d].id+'">';
                        vhtml 		+= '<span class="video">';
                        vhtml 		+= '<img class="play-overlay" src="imgs/video_playbutton_overlay.png"/>';
                        vhtml 		+= '<img class="video-cover" src="https://i.ytimg.com/vi/'+v.i[d].id+'/mqdefault.jpg"/>';
                        vhtml 		+= '<span class="duration">'+timeFormat(v.i[d].contentDetails.duration)+'</span>';
                        vhtml 		+= '<span class="views">'+v.i[d].statistics.viewCount+' views</span>';
                        vhtml 		+= '</span>';
                        vhtml 		+= '<span class="video-title">'+v.i[d].snippet.title+'</span>';
                        vhtml 		+= '</a></li>';
                        $(this).prepend(vhtml);
                        $(this).fadeIn("fast");
                    }
                });

            });*/
        });

    </script>

</div>

</body>
</html>