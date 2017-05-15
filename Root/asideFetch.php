<?php
	include "mysql_con.php";
	include_once("videos-get.php");

	usort($v['i'], function($a, $b) {
		return $a['i']['statistics']['viewCount'] - $b['i']['statistics']['viewCount'];
	});

?>

<div class="sticky">
	<dl>
		<dt>Popular Reviews</dt>
		<?php


        $pop_num = 0;
        $articleAr = array();
        $weekly_sql = mysqli_query($con, "SELECT article_id FROM tbl_article_stats WHERE timestamp >= curdate() - INTERVAL DAYOFWEEK(curdate())+1 DAY
AND timestamp < curdate() - INTERVAL DAYOFWEEK(curdate())-9 DAY AND article_type='Review' GROUP BY article_id DESC LIMIT 3");


        while ($weekly = mysqli_fetch_assoc($weekly_sql)) {
            $weekly['num'] = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE timestamp >= curdate() - INTERVAL DAYOFWEEK(curdate())+1 DAY
AND timestamp < curdate() - INTERVAL DAYOFWEEK(curdate())-9 DAY AND article_type='Review' AND article_id=".$weekly['article_id']));

            array_push($articleAr, $weekly);

        }

        usort($articleAr, function($a, $b) {
            return $b['num'] - $a['num'];
        });


        ?>
        <?php
        foreach ($articleAr as $weekly){
        $popular_reviews = mysqli_query($con, "SELECT * FROM tbl_review WHERE id=".$weekly['article_id']." AND alpha_approved = 'true'");

			while ($poprev = mysqli_fetch_assoc($popular_reviews)) {
				$pop_title	= $poprev['title'];
				$pop_rating	= $poprev['main_rating'];
				$pop_url	= "review.php?t=" . urlencode(str_replace(" ", "_", $poprev['title'])) . "&g=" . urlencode(str_replace(" ", "_", $poprev['gamename']));
				$pop_num++;
			?>

			<dd><a href="<?php echo $pop_url; ?>">
				<span><?php echo $pop_num; ?></span>
				<?php echo $pop_title; ?>
				<strong><?php echo $pop_rating; ?></strong>
			</a></dd>

		<?php } ?>
		<?php } ?>
	</dl>
	<dl>
		<div class="ad_placeholder">
		Want to advertise your site on GSR? <a href="#">click here</a> to find out how.
	</div>
        </dl>
        <dl>
		<dt>Popular Opinion Pieces</dt>
		<?php
        $pop_num = 0;
        $articleAr = array();
        $weekly_sql = mysqli_query($con, "SELECT article_id FROM tbl_article_stats WHERE timestamp >= curdate() - INTERVAL DAYOFWEEK(curdate())+1 DAY
AND timestamp < curdate() - INTERVAL DAYOFWEEK(curdate())-9 DAY AND article_type='Opinion' GROUP BY article_id DESC LIMIT 3");


        while ($weekly = mysqli_fetch_assoc($weekly_sql)) {
            $weekly['num'] = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE timestamp >= curdate() - INTERVAL DAYOFWEEK(curdate())+1 DAY
AND timestamp < curdate() - INTERVAL DAYOFWEEK(curdate())-9 DAY AND article_type='Opinion' AND article_id=".$weekly['article_id']));

            array_push($articleAr, $weekly);

        }

        usort($articleAr, function($a, $b) {
            return $b['num'] - $a['num'];
        });


        ?>
            <?php
            foreach ($articleAr as $weekly){
            $popular_opinions = mysqli_query($con, "SELECT * FROM tbl_opinion WHERE id=".$weekly['article_id']." AND alpha_approved = 'true'");

			while ($popop = mysqli_fetch_assoc($popular_opinions)) {
				$pop_title	= $popop['title'];
				$pop_url	= "opinion.php?t=" . urlencode(str_replace(" ", "_", $popop['title']));
				$pop_num++;
			?>

			<dd><a href="<?php echo $pop_url; ?>">
				<span><?php echo $pop_num; ?></span>
				<?php echo $pop_title; ?>
			</a></dd>

		<?php } ?>
		<?php } ?>
            </dl>
        <dl>
		<dt>Popular News Articles</dt>
		<?php
        $pop_num = 0;
        $articleAr = array();
        $weekly_sql = mysqli_query($con, "SELECT article_id FROM tbl_article_stats WHERE timestamp >= curdate() - INTERVAL DAYOFWEEK(curdate())+1 DAY
AND timestamp < curdate() - INTERVAL DAYOFWEEK(curdate())-9 DAY AND article_type='News' GROUP BY article_id DESC LIMIT 3");


        while ($weekly = mysqli_fetch_assoc($weekly_sql)) {
            $weekly['num'] = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE timestamp >= curdate() - INTERVAL DAYOFWEEK(curdate())+1 DAY
AND timestamp < curdate() - INTERVAL DAYOFWEEK(curdate())-9 DAY AND article_type='News' AND article_id=".$weekly['article_id']));

            array_push($articleAr, $weekly);

        }

        usort($articleAr, function($a, $b) {
            return $b['num'] - $a['num'];
        });


        ?>
            <?php
            foreach ($articleAr as $weekly){
            $popular_news = mysqli_query($con, "SELECT * FROM tbl_news WHERE id=".$weekly['article_id']." AND alpha_approved = 'true'");

			while ($popop = mysqli_fetch_assoc($popular_news)) {
				$pop_title	= $popop['title'];
				$pop_url	= "news.php?t=" . urlencode(str_replace(" ", "_", $popop['title']));
				$pop_num++;
			?>

			<dd><a href="<?php echo $pop_url; ?>">
				<span><?php echo $pop_num; ?></span>
				<?php echo $pop_title; ?>
			</a></dd>

		<?php } ?>
		<?php } ?>
            </dl>
        <dl>
		<dt>Popular Guides</dt>
		<?php
        $pop_num = 0;
        $articleAr = array();
        $weekly_sql = mysqli_query($con, "SELECT article_id FROM tbl_article_stats WHERE timestamp >= curdate() - INTERVAL DAYOFWEEK(curdate())+1 DAY
AND timestamp < curdate() - INTERVAL DAYOFWEEK(curdate())-9 DAY AND article_type='Guide' GROUP BY article_id DESC LIMIT 3");


        while ($weekly = mysqli_fetch_assoc($weekly_sql)) {
            $weekly['num'] = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE timestamp >= curdate() - INTERVAL DAYOFWEEK(curdate())+1 DAY
AND timestamp < curdate() - INTERVAL DAYOFWEEK(curdate())-9 DAY AND article_type='Guide' AND article_id=".$weekly['article_id']));

            array_push($articleAr, $weekly);

        }

        usort($articleAr, function($a, $b) {
            return $b['num'] - $a['num'];
        });


        ?>
            <?php
            foreach ($articleAr as $weekly){
            $popular_guides = mysqli_query($con, "SELECT * FROM tbl_guide WHERE id=".$weekly['article_id']." AND alpha_approved = 'true'");

			while ($popop = mysqli_fetch_assoc($popular_guides)) {
				$pop_title	= $popop['title'];
				$pop_url	= "guide.php?t=" . urlencode(str_replace(" ", "_", $popop['title']));
				$pop_num++;
			?>

			<dd><a href="<?php echo $pop_url; ?>">
				<span><?php echo $pop_num; ?></span>
				<?php echo $pop_title; ?>
			</a></dd>

		<?php } ?>
		<?php } ?>
            </dl>
    <dl>
		<dt>Popular Videos</dt>
        <?php
        $pop_num = 0;
        $v['i'] = array_slice($v['i'], 0, 3);
        foreach($v['i'] as $vid){
            $pop_num++;
            ?>

            <dd><a href="video.php?id=<?php echo $vid['id']; ?>">
                    <span><?php echo $pop_num; ?></span>
                    <?php echo $vid['snippet']['title']; ?>
                </a></dd>

		<?php } ?>
	</dl>
	<div id="message">
		Contribute<br><br>
		Support your favourite game reviewers by <a href="https://www.gofundme.com/tecjc6y4">contributing here</a>.
	</div>
<ins data-revive-zoneid="1" data-revive-id="92efd1a11555b4b462d64394af1b51db"></ins>
<script async src="//gamesharkreviews.com/adserver/www/delivery/asyncjs.php"></script>
</div>