<?php
include "mysql_con.php";

function most_recent($a, $b)
{
	$t1 = strtotime($b['createdate']);
	$t2 = strtotime($a['createdate']);
	return $t1 - $t2;
}

function most_popular($a, $b)
{
	$t1 = (intval($b['views'])*intval($b['bites']));
	$t2 = (intval($a['views'])*intval($a['bites']));
	return $t1 - $t2;
}

function least_popular($a, $b)
{
	$t1 = (intval($a['views'])*intval($a['bites']));
	$t2 = (intval($b['views'])*intval($b['bites']));
	return $t1 - $t2;
}

function least_recent($a, $b)
{
	$t1 = strtotime($a['createdate']);
	$t2 = strtotime($b['createdate']);
	return $t1 - $t2;
}

$num_ar = array("All", 10, 20, 25, 50);
$sort_ar = array("most_recent", "least_recent", "most_popular", "least_popular");
if(!isset($_GET['q'])){header("Location: index.php");}
if(isset($_GET['q']) && !empty($_GET['q']) && $_GET['q']!=""){

	$query = strip_tags(urldecode(trim($_GET['q'])));
	$query = mysqli_real_escape_string($con, preg_replace('/\s\s+/', ' ', $query));
	$total_raw_results = mysqli_query($con, '
SELECT * FROM tbl_review
  WHERE (title LIKE "%'.$query.'%"
  OR gamename LIKE "%'.$query.'%"
  OR tags LIKE "%'.$query.'%"
  OR summary LIKE "%'.$query.'%"
  OR author LIKE "%'.$query.'%"
  OR authuser LIKE "%'.$query.'%"
  OR article_type LIKE "%'.$query.'%")
  AND alpha_approved = "true"
');
	$total_raw_results2 = mysqli_query($con, '
SELECT * FROM tbl_opinion
  WHERE (title LIKE "%'.$query.'%"
  OR tags LIKE "%'.$query.'%"
  OR author LIKE "%'.$query.'%"
  OR authuser LIKE "%'.$query.'%"
  OR article_type LIKE "%'.$query.'%")
  AND alpha_approved = "true"
');
	$total_raw_results3 = mysqli_query($con, '
SELECT * FROM tbl_guide
  WHERE (title LIKE "%'.$query.'%"
  OR tags LIKE "%'.$query.'%"
  OR author LIKE "%'.$query.'%"
  OR authuser LIKE "%'.$query.'%"
  OR article_type LIKE "%'.$query.'%")
  AND alpha_approved = "true"
');
	$total_raw_results4 = mysqli_query($con, '
SELECT * FROM tbl_news
  WHERE (title LIKE "%'.$query.'%"
  OR tags LIKE "%'.$query.'%"
  OR author LIKE "%'.$query.'%"
  OR authuser LIKE "%'.$query.'%"
  OR article_type LIKE "%'.$query.'%")
  AND alpha_approved = "true"
');
	$total_num_results = (mysqli_num_rows($total_raw_results) + mysqli_num_rows($total_raw_results2) + mysqli_num_rows($total_raw_results3) + mysqli_num_rows($total_raw_results4));

	if(isset($_GET['num'])){

		if(in_array($_GET['num'], $num_ar)){
			$per_page = mysqli_real_escape_string($con, $_GET['num']);
			if($per_page=="All"){
				$per_page = $total_num_results;
			}
		}
		else{
			$per_page = 10;
		}

	}
	else{
		$per_page = 10;
	}

	if(isset($_GET['sort'])){

		if(in_array($_GET['sort'], $sort_ar)){
			$order_by = $_GET['sort'];
		}
		else{
			$order_by = 'most_popular';
		}

	}
	else{
		$order_by = 'most_popular';
	}

	if(isset($_GET['page'])){
		$page_num = mysqli_real_escape_string($con, $_GET['page']);
	}
	else{
		$page_num = 1;
	}

	$current_start = ceil(($per_page*$page_num)-$per_page);

	$results_ar = array();

	$raw_results = mysqli_query($con, '
SELECT * FROM tbl_review
  WHERE (title LIKE "%'.$query.'%"
  OR gamename LIKE "%'.$query.'%"
  OR tags LIKE "%'.$query.'%"
  OR summary LIKE "%'.$query.'%"
  OR author LIKE "%'.$query.'%"
  OR authuser LIKE "%'.$query.'%"
  OR article_type LIKE "%'.$query.'%")
  AND alpha_approved = "true"
');
	while ($rvw_row = mysqli_fetch_assoc($raw_results)) {
		array_push($results_ar, $rvw_row);
	}
	$raw_results2 = mysqli_query($con, '
SELECT * FROM tbl_opinion
  WHERE (title LIKE "%'.$query.'%"
  OR tags LIKE "%'.$query.'%"
  OR author LIKE "%'.$query.'%"
  OR authuser LIKE "%'.$query.'%"
  OR article_type LIKE "%'.$query.'%")
  AND alpha_approved = "true"
');
	while ($op_row = mysqli_fetch_assoc($raw_results2)) {
		array_push($results_ar, $op_row);
	}
	$raw_results3 = mysqli_query($con, '
SELECT * FROM tbl_guide
  WHERE (title LIKE "%'.$query.'%"
  OR tags LIKE "%'.$query.'%"
  OR author LIKE "%'.$query.'%"
  OR authuser LIKE "%'.$query.'%"
  OR article_type LIKE "%'.$query.'%")
  AND alpha_approved = "true"
');
	while ($gd_row = mysqli_fetch_assoc($raw_results3)) {
		array_push($results_ar, $gd_row);
	}
	$raw_results4 = mysqli_query($con, '
SELECT * FROM tbl_news
  WHERE (title LIKE "%'.$query.'%"
  OR tags LIKE "%'.$query.'%"
  OR author LIKE "%'.$query.'%"
  OR authuser LIKE "%'.$query.'%"
  OR article_type LIKE "%'.$query.'%")
  AND alpha_approved = "true"
');
	while ($op_row = mysqli_fetch_assoc($raw_results4)) {
		array_push($results_ar, $op_row);
	}

	usort($results_ar, $order_by);
	$results_ar = array_slice($results_ar, $current_start, $per_page);



	$num_results = count($results_ar);


	echo mysqli_error($con);
	if($total_num_results==1){$num_results_keyword = "result";}
	else{$num_results_keyword = "results";}

	$user_ip = $_SERVER['REMOTE_ADDR'];

	$sqlSEARCH = "INSERT INTO tbl_search (query, per_page, order_by, page_num, ip)
VALUES ('$query', '$per_page', '$order_by', '$page_num', '$user_ip')";

	if (!mysqli_query($con, $sqlSEARCH)) {
		echo mysqli_error($con);
	}

}
else{
	$num_results = 0;
	$total_num_results = 0;
	$query=false;
}


$first_page = 1;
$last_page = ceil($total_num_results/$per_page);
$page = $page_num;

$create_pages = range($first_page, $last_page);
$pagination = '	<div style="margin-bottom:20px;" id="nextprevcon"><p style="margin-bottom:20px !important;" class="grid_18">';
foreach($create_pages as $the_page){

	if($the_page==$page){
		$pagination = $pagination.'<a rel="nofollow" href="search.php?q='.$query.'&page='.$the_page.'&num='.$per_page.'&sort='.$order_by.'" class="pag_btn active">'.$the_page.'</a>';
	}
	else{
		$pagination = $pagination.'<a rel="nofollow" href="search.php?q='.$query.'&page='.$the_page.'&num='.$per_page.'&sort='.$order_by.'" class="pag_btn">'.$the_page.'</a>';
	}
}
$pagination = $pagination.'</p></div>';
if (in_array($page, $create_pages))
{
	$pagination = $pagination;
}
else{
	$pagination = '';
}



?>
<!doctype html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Search: '<?php echo $query;?>' | Search | GSR</title>

	<meta name="description" content="User policy and User agreement.">

	<?php include "links.php"; ?>

</head>

<body>

<?php include "header.php"; ?>

<div id="page" class="container_24">
<br /><br /><br />
	<center><?php
		if($total_num_results!=0 && isset($_GET['q']) && !empty($_GET['q']) && $_GET['q']!=""){
			echo '<h2>Search for: "'. $query.'" -  showing '.$num_results."/" .$total_num_results." ".$num_results_keyword."</h2>";
		}
		else{
			echo "";
		}
		?></center>
	<div id="search_results">
		<?php
		if($total_num_results!=0 && isset($_GET['q']) && !empty($_GET['q']) && $_GET['q']!=""){
			?>

			<form method="get" action="search.php" id="search_parameters">
				<input name="q" value="<?php echo $query;?>" style="display:none;"/>
				<label for="num">Results shown per page</label>
				<select id="num" onchange="submit_search();" name="num">
					<option value="All">All</option>
					<option value="10">10</option>
					<option value="20">20</option>
					<option value="25">25</option>
					<option value="50">50</option>
				</select>
				<label for="sort">Sort by</label>
				<select id="sort" onchange="submit_search();" name="sort">
					<option value="most_popular">Most Popular</option>
					<option value="least_popular">Least Popular</option>
					<option value="most_recent">Most Recent</option>
					<option value="least_recent">Least Recent</option>
				</select>

			</form>

			<?php
			foreach($results_ar as $tROW) {
				$articleid 			= $tROW['id'];
				$articletype 	 	= $tROW['article_type'];
				$title 			 	= $tROW['title'];
				$gamename		 	= $tROW['gamename'];
				$summary		 	= $tROW['summary'];
				$trailer		 	= $tROW['trailer'];
				$testedplatforms 	= $tROW['testedplatforms'];
				$genre			 	= $tROW['genre'];
				$author			 	= $tROW['author'];
				$authuser			= $tROW['authuser'];
				$createdate		 	= $tROW['createdate'];
				$tags 				= $tROW['tags'];
				$views 				= $tROW['views'];
				$bites 				= $tROW['bites'];
				$aimage				= urlencode($tROW['a_image']);
				$bimage				= urlencode($tROW['b_image']);
				$cimage				= urlencode($tROW['c_image']);
				$dimage				= urlencode($tROW['d_image']);
				$eimage				= urlencode($tROW['e_image']);
				if($articletype=="Guide"){
					$images 			= unserialize($tROW['images']);
					$aimage = $images[0];
				}

				if($articletype=="Review"){
					$url = "review.php?t=" . urlencode(str_replace(" ", "_", $title)) . "&g=" . urlencode(str_replace(" ", "_", $gamename));
				}
				if($articletype=="Opinion"){
					$url = "opinion.php?t=" . urlencode(str_replace(" ", "_", $title));
				}
				if($articletype=="News"){
					$url = "news.php?t=" . urlencode(str_replace(" ", "_", $title));
				}
				if($articletype=="Guide"){
					$url = "guide.php?t=" . urlencode(str_replace(" ", "_", $title));
				}


				echo "<a href='".$url."' class='result' style='display:none;'>";
				echo '<div class="img" style="background-image:url(imgs/'.strtolower($articletype).'/'.$aimage.');">
		<div class="info_top">
		<div class="title">'.$title.'</div>
		<div class="summary">'.$summary.'</div>
		</div>
		<div class="info_bottom">
		Written by '.$author.'<br/>
		<hr />
		'.$tags.'
		</div>
		</div>';
				echo "</a>";

			}
			echo $pagination;
		}
		else{
			echo "<center><h2>No results found</h2></center>";
		}
		?>
	</div>
</div>

<?php include "footer.html"; ?>
<script>
	function submit_search(){
		$("#search_parameters").submit();
	}

	$(function(){
		$(".result").highlight("<?php echo $query;?>");


		$("#num option").each(function(){
			if($(this).val()=="<?php echo $per_page?>"){
				$(this).attr("selected", "selected");
			}
		});

		$("#sort option").each(function(){
			if($(this).val()=="<?php echo $order_by?>"){
				$(this).attr("selected", "selected");
			}
		});

		$('.result').each(function(i) {
			$(this).show(); //Uses the each methods index+1 to create a multiplier on the delay
		});


	});
</script>


</body>
</html>