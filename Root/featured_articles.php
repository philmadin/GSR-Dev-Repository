<?php
	
	session_start();

	include "mysql_con.php";

	$featuredSQL = "SELECT * FROM tbl_featured WHERE position > 0 ORDER BY position ASC";
	$ftQuery = mysqli_query($con, $featuredSQL);	
	$ftIndex = 1;
	
	while($ftROW = mysqli_fetch_assoc($ftQuery)) {
		switch($ftROW['article_type']) {
			case "Review":
				$detailsQuery = "SELECT id, article_type, title, gamename, a_image, author, authuser, createdate FROM tbl_review WHERE id = " . $ftROW['article_id'];
			break;
			case "News":
				$detailsQuery = "SELECT id, article_type, title, a_image, author, authuser, createdate FROM tbl_news WHERE id = " . $ftROW['article_id'];			
			break;
			case "Opinion":
				$detailsQuery = "SELECT id, article_type, title, a_image, author, authuser, createdate FROM tbl_opinion WHERE id = " . $ftROW['article_id'];
			break;
			case "Guide":
				$detailsQuery = "SELECT id, article_type, title, images, author, authuser, createdate FROM tbl_guide WHERE id = " . $ftROW['article_id'];			
			break;			
		}

		$whileQuery = mysqli_query($con, $detailsQuery);
		$ftROW = mysqli_fetch_assoc($whileQuery);

		echo '<div class="interaction" id="id' . $ftIndex . '">';

			echo '<div class="left_side">'; 
				if($ftROW['article_type'] == "Guide") {
					$a_image = unserialize($ftROW['images']);
					echo '<img src="/imgs/guide/' . $a_image[0] . '" class="ftBG">';
				} else {
					echo '<img src="/imgs/' . strtolower($ftROW['article_type']) . '/' . $ftROW['a_image'] . '" class="ftBG">';
				}
				echo '<div class="content_overlay" data-article-type="' . $ftROW['article_type'] . '" data-article-id="'. $ftROW['id'] . '" data-article-user="'. $ftROW['authuser'] . '"></div>';
			echo '</div>';

			echo '<div class="right_side">';
				switch($ftROW['article_type']) {
					case "Review":
						echo '<a class="pressi-title" href="review.php?t=' . urlencode(str_replace(" ", "_", $ftROW['title'])) . '&g=' . urlencode(str_replace(" ", "_", $ftROW['gamename'])) . '">' . $ftROW['title'] . '</a>';
					break;
					case "News":
						echo '<a class="pressi-title" href="news.php?t=' . urlencode(str_replace(" ", "_", $ftROW['title'])) . '">' . $ftROW['title'] . '</a>';
					break;
					case "Opinion":
					echo '<a class="pressi-title" href="opinion.php?t=' . urlencode(str_replace(" ", "_", $ftROW['title'])) . '">' . $ftROW['title'] . '</a>';
					break;
					case "Guide":
					echo '<a class="pressi-title" href="guide.php?t=' . urlencode(str_replace(" ", "_", $ftROW['title'])) . '">' . $ftROW['title'] . '</a>';	
					break;			
				}
				if(!empty($ftROW['gamename'])) { echo '<a class="pressi-game">' . $ftROW['gamename'] . '</a>'; }
				echo '<a class="pressi-article">' . $ftROW['article_type'] . '</a>';
				echo '<a class="pressi-date">' . date("jS F, Y", strtotime($ftROW['createdate'])) . '</a>';
				
				echo '<div class="pressi-buttons">';
					echo '<a data-article-type="' . $ftROW['article_type'] . '" data-article-id="'. $ftROW['id'] . '" data-article-user="'. $ftROW['authuser'] . '" class="pressi-info">';
						echo '<svg width="56.5" height="56.5" viewBox="0 0 56.5 56.5">';
						  	echo '<circle class="info-ring" fill="#ffffff" cx="28.25" cy="28.25" r="28.25"/>';
						  	echo '<circle class="info-inner" fill="#373030" cx="25.425" cy="25.425" r="25.425" transform="translate(2.825 2.825)"/>';
						  	echo '<path class="info-point" fill="#ffffff" d="M2381.5,1170.55a2.7,2.7,0,0,1,2.7,2.7v0.03a2.7,2.7,0,1,1-5.4,0v-0.03A2.7,2.7,0,0,1,2381.5,1170.55Z" transform="translate(-2353.81 -1151.56)"/>';
						  	echo '<path class="info-dash" fill="#ffffff" d="M2381.5,1178.84a2.7,2.7,0,0,1,2.7,2.71v6.7a2.7,2.7,0,1,1-5.4,0v-6.7A2.7,2.7,0,0,1,2381.5,1178.84Z" transform="translate(-2353.81 -1151.84)"/>';
						echo '</svg>';
					echo '</a>';

					switch($ftROW['article_type']) {
						case "Review":
							echo '<a class="pressi-follow" href="review.php?t=' . urlencode(str_replace(" ", "_", $ftROW['title'])) . '&g=' . urlencode(str_replace(" ", "_", $ftROW['gamename'])) . '">';
						break;
						case "News":
							echo '<a class="pressi-follow" href="news.php?t=' . urlencode(str_replace(" ", "_", $ftROW['title'])) . '">';
						break;
						case "Opinion":
						echo '<a class="pressi-follow" href="opinion.php?t=' . urlencode(str_replace(" ", "_", $ftROW['title'])) . '">';
						break;
						case "Guide":
						echo '<a class="pressi-follow" href="guide.php?t=' . urlencode(str_replace(" ", "_", $ftROW['title'])) . '">';	
						break;			
					}
					echo '<svg width="56.5" height="56.5" viewBox="0 0 56.5 56.5">';
						echo '<circle class="follow-ring" fill="#ffffff" cx="28.25" cy="28.25" r="28.25"/>';
					  	echo '<circle class="follow-inner" fill="#373030" cx="25.425" cy="25.425" r="25.425" transform="translate(2.825 2.825)"/>';
					   	echo '<path class="follow-arrow" fill="#ffffff" d="M12.7125 12.7125 L12.7125 38.1375 L35 25.425 Z" transform="translate(7 3)"/>';
					echo '</svg></a>';

					echo '<a class="pressi-text">READ</a>';
				echo '</div>';
			echo '</div>';

		echo '</div>';
		$ftIndex++;
	}
?>