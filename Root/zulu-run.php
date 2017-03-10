<?php

	session_start();

	include "mysql_con.php";

	$featured_ar = mysqli_query($con, "SELECT * FROM tbl_featured WHERE position != 0 AND article_type != 'Video' ORDER BY position ASC LIMIT 5");

    while ($ft_row = mysqli_fetch_assoc($featured_ar)) {

        $article_type = $ft_row['article_type'];
        $article_id = $ft_row['article_id'];
        $video_id = $ft_row['video_id'];
        
        if($article_type == "Video"){

            $ft_title 	= $v[$video_id]['snippet']['title'];
            $ft_image 	= "http://img.youtube.com/vi/".$video_id."/maxresdefault.jpg";
            $ft_url   	= "video.php?id=".$video_id;
            $ft_summary = null;
        }

        if($article_type == "Guide") {

            $guide_ar = mysqli_query($con, "SELECT * FROM tbl_guide WHERE id = $article_id");

            while ($guide_row = mysqli_fetch_assoc($guide_ar)) {
                $ft_title 	= $guide_row['title'];
                $ft_images 	= unserialize($guide_row['images']);
                $ft_image   = "imgs/guide/".urlencode($ft_images[0]);
                $ft_url     = "guide.php?t=" . urlencode(str_replace(" ", "_", $ft_title));
                $ft_summary = null;
            }
        }

        if($article_type=="Opinion") {

            $opinion_ar = mysqli_query($con, "SELECT * FROM tbl_opinion WHERE id = $article_id");

            while ($op_row 	= mysqli_fetch_assoc($opinion_ar)) {
                $ft_title 	= $op_row['title'];
                $ft_image 	= "imgs/opinion/".urlencode($op_row['a_image']);
                $ft_url 	= "opinion.php?t=" . urlencode(str_replace(" ", "_", $ft_title));
                $ft_summary = null;
            }
        }
 
        if($article_type == "News") {

            $news_ar = mysqli_query($con, "SELECT * FROM tbl_news WHERE id = $article_id");

            while ($op_row 	= mysqli_fetch_assoc($news_ar)) {
                $ft_title 	= $op_row['title'];
                $ft_image 	= "imgs/news/".urlencode($op_row['a_image']);
                $ft_url 	= "news.php?t=" . urlencode(str_replace(" ", "_", $ft_title));
                $ft_summary = null;
            }
        }

        if($article_type == "Review") {

            $review_ar = mysqli_query($con, "SELECT * FROM tbl_review WHERE id = $article_id");

            while ($rvw_row = mysqli_fetch_assoc($review_ar)) {
                $ft_title 	= $rvw_row['title'];
                $ft_game 	= $rvw_row['gamename'];
                $ft_image 	= "imgs/review/".urlencode($rvw_row['a_image']);
                $ft_url		= "review.php?t=" . urlencode(str_replace(" ", "_", $ft_title)) . "&g=" . urlencode(str_replace(" ", "_", $ft_game));
                $ft_summary = $rvw_row['summary'];
            }
        }

        echo '<li class="featured_item">';
		echo '<a href="' . $ft_url . '" id="featured_content" style="background-image:url(' . $ft_image; . ');">';
		echo '<h3 id="featured_title">' . $ft_title; . '</h3>';
        
        if(isset($ft_summary)) {
			echo '<p id="featured_summary">' . $ft_summary; . '</p>';
		}
                                    
        echo '<span id="type">' . $article_type; . '</span>';
        echo '<span id="overlay"></span></a></li>';
    }

?>