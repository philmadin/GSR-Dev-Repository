<?php
function date_compare($a, $b)
{
    $t1 = strtotime($b['createdate']);
    $t2 = strtotime($a['createdate']);
    return $t1 - $t2;
}
include 'mysql_con.php';

$XML_Pages = array(
    array(
        "domain"=>"http://gamesharkreviews.com",
        "dir"=>"/"
    ),
    array(
        "domain"=>"http://m.gamesharkreviews.com",
        "dir"=>"mobilesite/"
    )
);


foreach($XML_Pages as $xml){


$baseURL = $xml['domain'];

$rssfeed = '<?xml version="1.0" encoding="UTF-8"?>
<rss xmlns:content="http://purl.org/rss/1.0/modules/content/" version="2.0" >';
$rssfeed .= '<channel>
';
$rssfeed .= '<title>Game Shark Reviews Article RSS Feed</title>
';
$rssfeed .= '<link>'.$xml['domain'].'</link>
';
$rssfeed .= '<description>One of the world\'s best online gaming hubs!</description>
';
$rssfeed .= '<language>en-us</language>
';
$rssfeed .= '<copyright>Copyright (C) 2015 - '.date("Y").'</copyright>
';


$art_row = array();

$review_link_list = mysqli_query($con, "SELECT * FROM tbl_review WHERE alpha_approved = 'true' ORDER BY id DESC LIMIT 10");
while ($rvw_row = mysqli_fetch_assoc($review_link_list)) {
    array_push($art_row, $rvw_row);
}
$opinion_link_list = mysqli_query($con, "SELECT * FROM tbl_opinion WHERE alpha_approved = 'true' ORDER BY id DESC LIMIT 10");
while ($op_row = mysqli_fetch_assoc($opinion_link_list)) {
    array_push($art_row, $op_row);
}
$guide_link_list = mysqli_query($con, "SELECT * FROM tbl_guide WHERE alpha_approved = 'true' ORDER BY id DESC LIMIT 10");
while ($gd_row = mysqli_fetch_assoc($guide_link_list)) {
    array_push($art_row, $gd_row);
}

usort($art_row, 'date_compare');

foreach ($art_row as $article_row) {
    $art_id	= $article_row['id'];
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
    $pubDate= date("D, d M Y H:i:s T", $art_date);
    $art_rdat	= strtotime($article_row['release_date']);
    if($art_type=="review"){
        $art_url	= "/review.php?t=" . urlencode(str_replace(" ", "_", $art_name)) . htmlspecialchars(htmlentities("&")) ."g=" . urlencode(str_replace(" ", "_", $art_game));
    }
    if($art_type=="opinion"){
        $art_url	= "/opinion.php?t=" . urlencode(str_replace(" ", "_", $art_name));
    }
    if($art_type=="guide"){
        $art_url	= "/guide.php?t=" . urlencode(str_replace(" ", "_", $art_name));
    }

    $rssfeed .= '<item>
';
    $rssfeed .= '<title>'.htmlspecialchars(htmlentities($art_name)).'</title>
    ';
    $rssfeed .= '<link>'.$xml['domain'].$art_url.'</link>
    ';
    $rssfeed .= '<guid>'.md5($art_type.$art_id).'</guid>
    ';
    $rssfeed .= '<author>'.$art_auth.'</author>
    ';
    $rssfeed .= '<pubDate>'.$pubDate.'</pubDate>
    ';
    $rssfeed .= '<content:encoded><![CDATA[';
    $rssfeed .= '
    <!doctype html>
<html lang="en" prefix="op: http://media.facebook.com/op#">
  <head>
    <meta charset="utf-8">
    <link rel="canonical" href="">
    <link rel="stylesheet" title="default" href="#">
    <title>Style Your Instant Articles</title>
    <meta property="fb:article_style" content="Test Article Style">
  </head>
<body>
  <article>
    <header>
      <!-- The cover image shown inside your article --> 
      <figure>
        <img src="http://fb.me/ia-img-desert.jpg" />
        <figcaption>Header image description becomes visible when image has been tapped and expanded.</figcaption>
      </figure>
      
      <!-- The title and subtitle shown in your article -->
      <h1> Style Your Instant Articles </h1>
      <h2> Use this article to experiment with the look and feel of your brand in Instant Articles   </h2>

      <!-- A kicker for your article -->
      <h3 class="op-kicker">
        Customizable Design Elements
      </h3>

      <!-- The author of your article -->
      <address>
        Instant Articles Team
      </address>

      <!-- The published and last modified time stamps -->
      <time class="op-published" dateTime="2016-2-04T09:00">February 4th 2016, 9:00 AM</time>
      <time class="op-modified" dateTime="2016-2-04T09:00">February 4th 2016, 9:00 AM</time>
      </header>
  
    
<p>With the <a href="https://developers.facebook.com/docs/instant-articles/guides/design#style">Style Editor</a>, you can create and modify layout templates that can be applied automatically to individual articles. Each style that you build this way can feature its own logo as well as unique variations of typography and colors.</p>

    <p>To experiment, create a new article manually in your Instant Articles Library; copy the markup from this article, and replace the canonical URL with one of your own. You can then easily test out new layout combinations and define the style—or styles—that are right for your publication. This is scrap paper for Instant Articles. Have fun!</p> 
    
    <p>Learn more about each of the customizable design elements in the <a href="https://developers.facebook.com/docs/instant-articles/guides/design#design">Instant Articles Design Guide</a>.
    
    <h1>Example Text Starts Here</h1>
    
    
<p>Body Text. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut minim inline link veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. tpariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

<p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit.</p>



  <figure data-feedback="fb:likes, fb:comments">
      <img src="" />
       <figcaption><h1>Caption Title Small</h1><h2>Caption Description Small lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</h2>
                <cite>PHOTO BY JOHN SMITH</cite>
            </figcaption>
                   <script type="application/json" class="op-geotag">
                { 
                "type": "Feature", 
                "geometry":{ 
                "type": "Point", 
                "coordinates":[37.5922282, -106.7008752] },
                "properties":{ 
                "title": "LOCATION",
                "style": "hybrid",
                "radius": 2000
                 } 
                 }
            </script>


        </figure>
  <p>Body Text. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem doloremque, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt.</p>

  <h1> H1 lorem ipsum </h1>
  <p>Body Text. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet.</p>

  <aside>
  Pull quote lorem ipsum dolor sit amet, cons ectetur adipi sicing elit, sed do eiusmod.
  <cite>JOHN SMITH LOREM IPSUM</cite>
</aside>

<p>Body Text. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

<h2> H2 lorem ipsum </h2>
<p>Body Text. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet.</p>

<blockquote>
  Block quote. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostr ud exer citation ullamco laboris.
</blockquote>

<p>Body Text. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla.</p>

<figure data-feedback="fb:likes, fb:comments">
  <video>
    <source src="http://fb.me/ia-video-forest.mov" />
  </video>
<figcaption class="op-medium"><h1>2:08 | Caption Title Small</h1>Caption Description Medium</figcaption> 
</figure>

<p>Body Text. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem doloremque, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt.</p>

<footer>
      <aside>
        Footer totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
      </aside>
    
  <small>© Facebook</small>
  </footer>

   
  </article>
</body>
</html>
    ';
    $rssfeed .= ']]></content:encoded>
';
    $rssfeed .= '</item>
';

}

$rssfeed .= '</channel>
';
$rssfeed .= '</rss>';

$xmldir = $xml['dir'].'/rss.xml';
$fp = fopen($xmldir, 'w');
fwrite($fp, trim($rssfeed));
fclose($fp);
print("Successfully updated RSS/XML Feed for ".$xml['dir']."<br />");

}

?>