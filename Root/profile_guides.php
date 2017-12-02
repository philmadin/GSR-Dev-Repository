<?php
include ("mysql_con.php");

// Gets the username
$user = $_GET['profilename'];

// Gets the ofset for the search
$offset = $_GET['offset'];

// Current page
$currentPage = ($offset + 9) / 9;

// Order by
$type = $_GET['type'];
$order = $_GET['order'];

// Gets the total number of articles the user has written
$totalArts = mysqli_num_rows(mysqli_query($con, "SELECT id FROM tbl_guide WHERE authuser = '$user' AND alpha_approved = 'true'"));

// Total amount of pages
$pages = ceil($totalArts / 9);

// Array that contains the information of every article written by the user
$articles_info = array();

// Fetch the information of every article written by the user
$query_user_arts = "SELECT id, article_type, title, author, month, images, views, createdate, bites FROM tbl_guide WHERE authuser = ? AND alpha_approved = 'true' ORDER BY " . $type . " ". $order ." LIMIT 9 OFFSET " .  $offset . ";";
$stmt = mysqli_prepare($con, $query_user_arts) or die("Unable to prepare statement: " . mysqli_error($con));
if ($stmt) {
  mysqli_stmt_bind_param($stmt, 's', $user);
  mysqli_stmt_execute($stmt) or die("Unable to execute query: " . mysqli_error($con));
  mysqli_stmt_bind_result($stmt, $art_rate, $art_type, $art_title, $art_author, $art_gamename, $art_image, $art_views, $art_date, $art_bites);
  while (mysqli_stmt_fetch($stmt)) {
    $images = unserialize($art_image);
    $article = array($art_rate, $art_type, $art_title, $art_author, $art_gamename, $images[0], $art_views, $art_date, $art_bites);
    array_push($articles_info, $article);
  }
  mysqli_stmt_close($stmt);
}

if ($totalArts == 0) { // If the user has written no guides.
  echo "<br><p class='profile_alert'>This user has written no Guides</p>";
  $pages = 1;
} else {
  for ($i = 0; $i <= sizeof($articles_info) - 1; $i++) {
    // Checks if the article does not have images.
    if (!empty($articles_info[$i][5])) { // Checks if the article has images or not
      $imgURL = strtolower($articles_info[$i][1]) . "/" . urlencode($articles_info[$i][5]); // Saves the url to the article image
    } else {
      $imgURL = "gsr_raw_logo.jpg"; // If the articles has no images, it will save GSR logo as the image to display
    }
    ?>
    <div class="thumbnail_element">
      <span class="thumbnail_<?php echo $articles_info[$i][1]; ?>" data-order="<?php echo $i; ?>">
        <!-- The article image works as the link -->
        <a href="<?php echo strtolower($articles_info[$i][1]); ?>.php?t=<?php echo urlencode(str_replace(' ', '_', $articles_info[$i][2])); ?>">
          <div class="thumbnail_gradient">
            <img class="article_image" src="imgs/<?php echo $imgURL; ?>" alt="<?php echo $articles_info[$i][2]?>">
          </div>
          <p class="title_articles"><?php echo $articles_info[$i][2]; ?></p>
        </a>
        <!-- Contanier with the information (author, date, number of views and number of bites) -->
        <div class="thumbnail_container_<?php echo $articles_info[$i][1]; ?>">
          <span class="container_title"><?php echo $articles_info[$i][1]; ?></span>
          <?php
          if (!strcmp($articles_info[$i][1], "Review")) { // If the article to show is a review, it will show the score
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
    </div>
    <?php
  }
}
?>
<!-- Create the navigation arrows -->
<div id="prevNextArt">
  <span id="articles_prev" onclick="prevGrid()">&#8249;</span>
  <span id="articles_pages"><?php echo $currentPage . "/" . $pages; ?></span>
  <span id="invis_value"><?php echo $totalArts;?></span>
  <span id="articles_next" onclick="nextGrid()">&#8250;</span>
</div>
<br>
