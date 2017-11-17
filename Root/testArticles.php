<?php
include ("mysql_con.php");
include ("timecal.php");

$pr_username = $_GET["username"];

$offset = $_GET["offset"];
if($offset == 0) {
  $final_offset = 0;
} else {
  $final_offset = $offset - 10;
}

$rating = $_GET['rating'];
if($rating == '10') {
  $rating = '9.9';
}

$year = $_GET["year"];
if($year != 'All') {
  $filtered_year .= " AND year = '$year'";
}

$month = ucfirst($_GET["month"]);
if($month != 'All') {
  $filtered_month .= " AND month = '$month'";
}

$statement = "SELECT main_rating, article_type, title, author, gamename, a_image, views, createdate, bites FROM tbl_review WHERE authuser = ? AND main_rating >= '$rating'" . $filtered_month . $filtered_year . " AND alpha_approved = 'true' ORDER BY id DESC LIMIT " . $final_offset . ", 10";
$num_art = 0;

$stmt = mysqli_prepare($con, $statement) or die("Unable to prepare statement: " . mysqli_error($con));
//$stmt = mysqli_prepare($con, $query_user_articles) or die("Unable to prepare statement: " . mysqli_error($con));
if ($stmt) {
  //mysqli_stmt_bind_param($stmt, 'ssss', $pr_username, $pr_username, $pr_username, $pr_username);
  mysqli_stmt_bind_param($stmt, 's', $pr_username);
  mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
  mysqli_stmt_bind_result($stmt, $art_rate, $art_type, $art_title, $art_author, $art_gamename, $art_image, $art_views, $art_date, $art_bites);
  while (mysqli_stmt_fetch($stmt)) {
    $num_art += 1;
    if (!empty($art_image)) {
      $imgURL = $art_type . "/" . urlencode($art_image);
    } else {
      $imgURL = "gsr_raw_logo.jpg";
    }
    ?>
    <span class="thumbnail_<?php echo $art_type; ?>">
      <a href="<?php echo $art_type; ?>.php?t=<?php echo urlencode(str_replace(' ', '_', $art_title)); ?>&g=<?php echo urlencode(str_replace('' , '_', $art_gamename)); ?>">
        <div class="thumbnail_gradient">
          <img class="article_image" src="imgs/<?php echo $imgURL; ?>" alt="<?php echo $art_title; ?>">
        </div>
        <p class="title_articles"><?php echo $art_title; ?></p>
      </a>
      <div class="thumbnail_container_<?php echo $art_type; ?>">
        <span class="container_title"><?php echo $art_type; ?></span>
        <?php
        if (!strcmp($art_type, "Review")) {
          ?>
          <span class="container_score"><?php echo $art_rate; ?></span>
          <?php
        }
        ?>
      </div>
      <div class="thumbnail_container1_<?php echo $art_type; ?>">
        <span class="author_date">by<br> <?php echo $art_author; ?><br> <?php echo date('jS M Y', strtotime($art_date)); ?></span>
        <span class="thumbnail_stats">
          <span class="thumbnail_stats1"><img src="imgs/stats_icons/views_icon.png"><?php echo $art_views . " " . $text_view; ?></span>
          <span class="thumbnail_stats1"><img src="imgs/stats_icons/bites_icon.png"><?php echo $art_bites . " " . $text_bite; ?></span>
        </span>
      </div>
    </span>
    <?php
    // if ($art_type === "Guide") {
    //   $images = unserialize($art_image);
    //   $article = array($art_rate, $art_type, $art_title, $art_author, $art_gamename, $images[0], $art_views, $art_date, $art_bites);
    //   $num_views += $art_views;
    //   $user_bites += $art_bites;
    // } else {
    //   $article = array($art_rate, $art_type, $art_title, $art_author, $art_gamename, $art_image, $art_views, $art_date, $art_bites);
    //   $num_views += $art_views;
    //   $user_bites += $art_bites;
    // }
    // array_push($articles_info, $article);
  }
  mysqli_stmt_close($stmt);
}
// $num_rows = sizeof($articles_info);

// function cmp($a, $b){
//   $ad = strtotime($a[2]);
//   $bd = strtotime($b[2]);
//   return ($ad - $bd);
// }
//
// usort($articles_info, 'cmp');

$resultsCount = ceil($num_art/10);

?>
<div id="nextprevcon">
  <p class="grid_18">
    <?php
    if ($final_offset > 0) {
      $prev_num = $final_offset;
      echo "<a class='pag_btn' id='prev_btn' style='width:50px !important;' data-button-name:'" . $prev_num . "'>PREV</a>";
    }
    for ($x = 1; $x <= $resultsCount; $x++) {
      if (($x * 10) - 10 == $final_offset) {
        echo "<a class='pag_btn active' data-button-name='" . $x . "0'>" . $x . "</a>";
      } else {
        echo "<a class='pag_btn' data-button-name='" . $x . "0'>" . $x . "</a>";
      }
    }
    if ($final_offset < ($resultsCount * 10 - 10)) {
      $nex_num = $final_offset + 20;
      echo "<a class='pag_btn' id='next_btn' style='width:50px !important;' data-button-name:'" . $nex_num . "'>PREV</a>";
    }
    ?>
  </p>
</div>
