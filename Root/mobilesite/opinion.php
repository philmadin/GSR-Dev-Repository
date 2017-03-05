<?php
include "mysql_con.php";
include "related-articles.php";

$user = $_SESSION['username'];

$opinion_title = mysqli_real_escape_string($con, str_replace("_", " ", $_GET['t']));

if(!isset($_GET['t'])) { $articleSet = false; }
if(isset($_GET['t'])) { $articleSet = true; }

$accountQRY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$user'");

while($infoQRY = mysqli_fetch_assoc($accountQRY)) {
    $check_firstname	= $infoQRY['firstname'];
    $check_lastname		= $infoQRY['lastname'];
    $check_fullname		= $check_firstname . " " . $check_lastname;
    $check_posa			= $infoQRY['posa'];
    $check_posb			= $infoQRY['posb'];
    $check_rank         = $infoQRY['rank'];
    $check_position		= $check_posa . " " . $check_posb;
}

$tQUERY = mysqli_query($con, "SELECT * FROM tbl_opinion WHERE title = '$opinion_title'");
if(mysqli_num_rows($tQUERY)==0){ $articleSet = false; }
while ($tROW = mysqli_fetch_array($tQUERY)) {
    $articleid 			= $tROW['id'];
    $articletype 	 	= $tROW['article_type'];
    $title 			 	= $tROW['title'];
    $file_main			= "http://gamesharkreviews.com/".$tROW['main'];
    $genre			 	= $tROW['genre'];
    $author			 	= $tROW['author'];
    $authuser			= $tROW['authuser'];
    $createdate		 	= $tROW['createdate'];
    $tags 				= $tROW['tags'];
    $aimage				= urlencode($tROW['a_image']);
    $bimage				= urlencode($tROW['b_image']);
    $cimage				= urlencode($tROW['c_image']);
    $dimage				= urlencode($tROW['d_image']);
    $eimage				= urlencode($tROW['e_image']);
    $url = "http://m.gamesharkreviews.com/opinion.php?t=" . str_replace(" ", "_", $title);
    $related = relatedArticles($tags, $articletype, 5, $title);
}

$viewer_ip = $_SERVER['REMOTE_ADDR'];

$biteQUERY = mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE article_id = '$articleid' AND type = 'bite' AND ip = '$viewer_ip' AND article_type = '$articletype'");
if(mysqli_num_rows($biteQUERY)>0){
    $hasbit=true;
}else{$hasbit=false;}

$bitecount = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE article_id = '$articleid' AND type = 'bite' AND article_type = '$articletype'"));
if($bitecount==1){$bitecounttext="bite";}
else{$bitecounttext = "bites";}

$articleviews = (mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE article_id = '$articleid' AND type = 'view' AND article_type = '$articletype'"))+1);
if($articleviews==1){$articleviewtext="view";}
else{$articleviewtext = "views";}


$aQUERY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$authuser'");
while($aROW = mysqli_fetch_assoc($aQUERY)) {
    $arow_rank			= $aROW['rank'];
    $bQUERY = mysqli_query($con, "SELECT * FROM tbl_ranks WHERE id = $arow_rank");
    while($bROW = mysqli_fetch_assoc($bQUERY)) {
        $arow_position = $bROW['name'];
    }
    $arow_quote			= $aROW['quote'];
    $arow_pic			= $aROW['picture'];
}

if($arow_pic == NULL || $arow_pic == "" || empty($arow_pic)) {
    $arow_img = "default";
} else {
    $arow_img = $arow_pic;
}

$fb_url = "http://www.facebook.com/sharer/sharer.php?u=".urlencode($url);
$gplus_url = "https://plus.google.com/share?url=".urlencode($url);
$twitter_url = "http://twitter.com/share?url=".urlencode($url)."&text=".urlencode($title.": \n");

?>

<!doctype html>
<html>
<head>


    <title><?php echo $title . " by " . $author . " | " . $gamename . " Opinion Piece"; ?> | GSR</title>

    <meta name="description" content="<?php echo $title . " - " . $summary; ?>">

    <meta name="author" content="<?php echo $author;?>" />

    <meta itemprop="name" content="<?php echo $title;?>">
    <meta itemprop="description" content="<?php echo $summary;?>">
    <meta itemprop="image" content="http://gamesharkreviews.com/imgs/opinion piece/<?php echo $aimage; ?>">

    <!-- for Facebook -->
    <meta property="og:title" content="<?php echo $title;?>" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="Gameshark Reviews (GSR)" />
    <meta property="og:updated_time" content="<?php echo date("D jS M Y", strtotime($createdate));?>" />
    <meta property="og:image" content="http://gamesharkreviews.com/imgs/opinion piece/<?php echo $aimage; ?>" />
    <meta property="og:url" content="<?php echo $url;?>" />
    <meta property="og:description" content="<?php echo $summary;?>" />

    <!-- for Twitter -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="<?php echo $title;?>" />
    <meta name="twitter:description" content="<?php echo $summary;?>" />
    <meta name="twitter:image" content="http://gamesharkreviews.com/imgs/opinion piece/<?php echo $aimage; ?>" />

    <?php include "externals.php"; ?>

</head>

<body>

<script type="application/ld+json">
	{
	"@context": "http://schema.org",
	"@type": "NewsArticle",
	"headline": "<?php echo $title;?> | <?php echo $author; ?>",
	"alternativeHeadline": "<?php echo $title;?> | <?php echo $author; ?>",
	"image": [
	"http://gamesharkreviews.com/imgs/opinion/<?php echo $aimage; ?>",
	"http://gamesharkreviews.com/imgs/opinion/<?php echo $bimage; ?>",
	"http://gamesharkreviews.com/imgs/opinion/<?php echo $cimage; ?>",
	"http://gamesharkreviews.com/imgs/opinion/<?php echo $dimage; ?>",
	"http://gamesharkreviews.com/imgs/opinion/<?php echo $eimage; ?>"
	],
	"datePublished": "<?php echo date(DATE_ISO8601, strtotime($createdate)); ?>",
	"description": "<?php echo strip_tags(substr(str_replace("\n","<br>",file_get_contents($file_main)), 0, 300).'...'); ?>"
	}
</script>

<?php include "sidebar.php" ?>


<div id="page" class="canvas">


    <?php include "header.php"; ?>


    <div class="container">

        <div class="row white-page">

            <div class="col-lg-12">
                <br />
                <br />

                <img src="http://gamesharkreviews.com/imgs/opinion/<?php echo $aimage; ?>" class="img-responsive img-thumbnail">
                <h4><?php echo $title;?></h4>
                <p class="lead"><i class="fa fa-user"></i> by <a href="profile.php?profilename=<?php echo $authuser;?>"><?php echo $author;?></a></p>
                <hr>
                <p><i class="fa fa-calendar"></i> Posted on <?php echo date("D jS M Y", strtotime($createdate)); ?></p>
                <p>
                    <i class="fa fa-eye"></i>
                    <span id="displayviews">
                        <?php echo $articleviews." ".$articleviewtext; ?>
                    </span>
                    <?php echo " <b>  &nbsp; / &nbsp;  </b> <i class='fa fa-thumbs-up'></i>".$bitecount. " " . $bitecounttext;?>
                </p>

                <hr>

                <p class="content well" id="main_section" style="margin:0px !important;">
                    <?php echo strip_tags(str_replace("</p>", "<br />", file_get_contents($file_main)), "<br>"); ?>
                </p>

                <hr />

                <p><i class="fa fa-tags"></i>
                    Tags:
                    <?php
                    $explode_tags = explode(", ", $tags);
                    foreach ($explode_tags as $tagvalue) {
                        echo "<a rel='nofollow' style='margin:5px;' href='search.php?q=".urlencode($tagvalue)."'><span style='font-size:16px;padding:5px;' class='badge badge-info'>" . $tagvalue . "</span></a>";
                    }
                    ?>

                </p>
                <hr />
                <p id="bite_area">
                    <?php
                    if($hasbit==true){
                        echo '<button id="bite" title="Unbite" data-state="active"></button><span id="bite_count" data-state="active">'.$bitecount.'</span>';
                    }
                    if($hasbit==false){
                        echo '<button id="bite" title="Take a bite" data-state="inactive"></button><span id="bite_count" data-state="inactive">'.$bitecount.'</span>';
                    }
                    ?>
                    <a id="bite-help" class="help-link" href="#">What's This?</a>
                </p>
                <div class="btn-group btn-group-justified social_share_bottom" role="group" aria-label="...">
                    <div class="btn-group" role="group">
                        <button type="button" title="Share on Facebook" class="btn btn-default social_fb" data-href="<?php echo $fb_url;?>"></button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" title="Share on Twitter" class="btn btn-default social_twitter" data-href="<?php echo $twitter_url;?>"></button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" title="Share on Google+" class="btn btn-default social_gplus" data-href="<?php echo $gplus_url;?>"></button>
                    </div>
                </div>

                <hr />
                <!-- the comment box -->
                <div id="disqus_thread"></div>
                <script>
                    /**
                     * RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                     * LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
                     */
                    var disqus_config = function () {
                        this.page.identifier = "<?php echo $articleid; ?>";
                    };
                    (function() { // DON'T EDIT BELOW THIS LINE
                        var d = document, s = d.createElement('script');

                        s.src = '//gamesharkreview.disqus.com/embed.js';

                        s.setAttribute('data-timestamp', +new Date());
                        (d.head || d.body).appendChild(s);
                    })();
                </script>
                <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>

            </div>


        </div>


    </div>


    <?php include "footer.php"; ?>

</div>

<script type="text/javascript">
    var articleid=<?php echo $articleid;?>;
    var articletype='<?php echo $articletype;?>';

    $(".social_share_side button, .social_share_bottom button").click(function(e){
        e.preventDefault();
        var socialURL = $(this).attr("data-href");
        var actionType = $(this).attr("class");
        window.open( socialURL, "socialWindow", "status = 1, height = 550, width = 600, resizable = 0" );
        ae8857b082115f203e8a5d23410461f7(50, articletype, articleid, actionType, "<h3>Article Share!</h3> You have been rewarded %xp%xp<br />for sharing this opinion piece.");
    });

    $(function() {


        $.post("article_view_action.php",
            {
                articleid: articleid,
                articletype: articletype
            },
            function(data, status){
                $("#displayviews").text(data);
                setTimeout(function(){
                    ae8857b082115f203e8a5d23410461f7(150, articletype, articleid, "view", "<h3>Article View!</h3> You have been rewarded %xp%xp<br />for reading this opinion piece.");
                }, 30000);
            });
    });

    $("#bite").click(function(){
        var articleid=<?php echo $articleid;?>;
        var articletype='<?php echo $articletype;?>';
        var state = $(this).attr("data-state");
        var count = parseInt($("#bite_count").text());
        var action;
        if(state=="active"){
            action = "unbite";
            $("#bite, #bite_count").attr("data-state", "inactive");
            $("#bite").attr("title", "Take a bite");
            count--;
        }
        if(state=="inactive"){
            action = "bite";
            $("#bite, #bite_count").attr("data-state", "active");
            $("#bite").attr("title", "Unbite");
            count++;
        }

        $("#bite_count").text(count);


        $.get("bite_action.php",
            {
                articleid: articleid,
                articletype: articletype,
                action: action
            },
            function(data, status){
                var row = data.split("-");
                var new_action = row[0];
                var new_count = row[1];
                if(new_action=="unbite"){
                    $("#bite, #bite_count").attr("data-state", "inactive");
                    $("#bite").attr("title", "Take a bite")
                }
                if(new_action=="bite"){
                    $("#bite, #bite_count").attr("data-state", "active");
                    $("#bite").attr("title", "Unbite")
                }
                ae8857b082115f203e8a5d23410461f7(50, articletype, articleid, "bite", "<h3>Article Bite!</h3> You have been rewarded %xp%xp<br />for biting this opinion piece.");
                $("#bite_count").text(new_count);

            });


    });

</script>


</body>
</html>