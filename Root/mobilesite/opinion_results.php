<?php
	include "mysql_con.php";

	$filtered_year = "";
	$filtered_month = "";

	$year = $_GET['year'];
	$month = ucfirst($_GET['month']);

	$filtered_offset = $_GET['offset'];

	if($filtered_offset == 0) {
		$final_offset = 0;
	} else {
		$final_offset = $filtered_offset - 10;
	}

	if($year != 'All') {
		$filtered_year .= " AND year = '$year'";
	}

	if($month != 'All') {
		$filtered_month .= " AND month = '$month'";
	}

	$total_num = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_opinion WHERE alpha_approved = 'true'" . $filtered_month . $filtered_year . " ORDER BY id DESC"));
	$opinion_link_list = mysqli_query($con, "SELECT * FROM tbl_opinion WHERE alpha_approved = 'true'" . $filtered_month . $filtered_year . " ORDER BY id DESC LIMIT " . $final_offset . ",10");

	while ($rvw_row = mysqli_fetch_assoc($opinion_link_list)) {
		$art_name	= $rvw_row['title'];
		$art_file	= urlencode($rvw_row['a_image']);
		$art_auth	= $rvw_row['author'];
		$art_type	= $rvw_row['article_type'];
		$art_date	= strtotime($rvw_row['createdate']);
		$art_rdat	= strtotime($rvw_row['release_date']);
		$art_url	= "opinion.php?t=" . urlencode(str_replace(" ", "_", $art_name));
	?>

		<li><a href="<?php echo $art_url; ?>" class="article_item" data-article-image="<?php echo $art_file; ?>" data-article-type="<?php echo strtolower($art_type); ?>">
			<h5><?php echo $art_name; ?></h5>
			<p class="game_details"><?php echo $art_auth; ?><span> - <?php echo date("j F Y", $art_date); ?></span></p>
			<div id="game_display">
				<div id="game_info">
				</div>
			</div>
			<div id="game_type">
				<span class="game_type"><?php echo $art_type; ?></span>
			</div>
		</a></li>

	<?php
	}

	$resultsCount = ceil($total_num/10);

?>
				<div id="nextprevcon">
					<p class="grid_18">
						<?php
						
						if($final_offset>0){
						$prev_num = $final_offset;
						echo '<a class="pag_btn" id="prev_btn" style="width:50px !important;" data-button-name="'.$prev_num.'">PREV</a>';
						}
						
							for ($x = 1; $x <= $resultsCount; $x++) {
								if(($x*10)-10==$final_offset){
								echo '<a class="pag_btn active" data-button-name="' . $x . '0">' . $x . '</a>';
								}else{
								echo '<a class="pag_btn" data-button-name="' . $x . '0">' . $x . '</a>';	
								}
							}
							
						if($final_offset<($resultsCount*10-10)){
						$next_num = $final_offset+20;
						echo '<a class="pag_btn" id="next_btn" style="width:50px !important;" data-button-name="'.$next_num.'">NEXT</a>';
						}
						
						?>
					</p>
				</div>

