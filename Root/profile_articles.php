<?php
include ("mysql_con.php");
include ("timecal.php");

$pr_username = $_GET["profilename"];

/* Number of articles */
$articles_info = array();
$num_views = 0;
$user_bites = 0;
//$reviews_info = array();
$stmt = mysqli_prepare($con, $query_user_articles) or die("Unable to prepare statement: " . mysqli_error($con));
if ($stmt) {
  mysqli_stmt_bind_param($stmt, 'ssss', $pr_username, $pr_username, $pr_username, $pr_username);
  mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
  mysqli_stmt_bind_result($stmt, $art_rate, $art_type, $art_title, $art_author, $art_gamename, $art_image, $art_views, $art_date, $art_bites);
  while (mysqli_stmt_fetch($stmt)) {
    if ($art_type === "Guide") {
      $images = unserialize($art_image);
      $article = array($art_rate, $art_type, $art_title, $art_author, $art_gamename, $images[0], $art_views, $art_date, $art_bites);
      $num_views += $art_views;
      $user_bites += $art_bites;
    } else {
      $article = array($art_rate, $art_type, $art_title, $art_author, $art_gamename, $art_image, $art_views, $art_date, $art_bites);
      $num_views += $art_views;
      $user_bites += $art_bites;
    }
    array_push($articles_info, $article);
  }
  mysqli_stmt_close($stmt);
}
$num_rows = sizeof($articles_info);
if ($num_rows == 1) {
  $user_articles = 1;
  $text_articles = "article";
} else {
  $user_articles = $num_rows;
  $text_articles = "articles";
}
if ($num_views == 1) {
  $text_view = "view";
} else {
  $text_view = "views";
}
$num_rows = sizeof($bites);
if ($user_bites == 1) {
  $text_bite = "bite";
} else {
  $text_bite = "bites";
}

function cmp($a, $b){
  $ad = strtotime($a[7]);
  $bd = strtotime($b[7]);
  return ($bd - $ad);
}

usort($articles_info, 'cmp');

for ($i = 0; $i <= sizeof($articles_info) - 1; $i++) {
  // If the article does not have images.
  if (!empty($articles_info[$i][5])) {
    $imgURL = $articles_info[$i][1] . "/" . urlencode($articles_info[$i][5]);
  } else {
    $imgURL = "gsr_raw_logo.jpg";
  }
  ?>
  <span class="thumbnail_<?php echo $articles_info[$i][1]; ?>">
    <a href="<?php echo $articles_info[$i][1]; ?>.php?t=<?php echo urlencode(str_replace(' ', '_', $articles_info[$i][2])); ?>&g=<?php echo urlencode(str_replace('' , '_', $articles_info[$i][4])); ?>">
      <div class="thumbnail_gradient">
        <img class="article_image" src="imgs/<?php echo $imgURL; ?>" alt="<?php echo $articles_info[$i][2]?>">
      </div>
      <p class="title_articles"><?php echo $articles_info[$i][2]; ?></p>
    </a>
    <div class="thumbnail_container_<?php echo $articles_info[$i][1]; ?>">
      <span class="container_title"><?php echo $articles_info[$i][1]; ?></span>
      <?php
      if (!strcmp($articles_info[$i][1], "Review")) {
        ?>
        <span class="container_score"><?php echo $articles_info[$i][0]; ?></span>
        <?php
      }
      ?>
    </div>
    <div class="thumbnail_container1_<?php echo $articles_info[$i][1]; ?>">
      <span class="author_date">by<br> <?php echo $articles_info[$i][3]; ?><br> <?php echo date('jS M Y', strtotime($articles_info[$i][7])); ?></span>
      <span class="thumbnail_stats">
        <span class="thumbnail_stats1"><img src="imgs/stats_icons/views_icon.png"><?php echo $articles_info[$i][6] . " " . $text_view; ?></span>
        <span class="thumbnail_stats1"><img src="imgs/stats_icons/bites_icon.png"><?php echo $articles_info[$i][8] . " " . $text_bite; ?></span>
      </span>
    </div>
  </span>
  <?php
}
?>
