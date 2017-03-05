<?php
	//include "mysql_con.php";
?>

<!doctype html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<meta name="robots" content="index, follow, noarchive">

<title>The Entire List of Articles From Game Shark Reviews | Articles | GSR</title>

<meta name="description" content="Our entire collection of our game reviews, walkthroughs and articles on tips and tricks.">

<?php include "links.php"; ?>

</head>

<body>

	<?php include "header.php"; ?>

	<div id="page" class="container_24">

		<article class="blog">
			<section id="main_featured_article">
				<?php
					$main_featured_qry = mysqli_query($con, "SELECT * FROM tbl_review WHERE year = '" . date("Y") . "' AND alpha_approved = 'true' ORDER BY id DESC LIMIT 1");
					if(mysqli_num_rows($main_featured_qry)<1){
					$main_featured_qry = mysqli_query($con, "SELECT * FROM tbl_review WHERE year = '" . (date("Y")-1) . "' AND alpha_approved = 'true' ORDER BY id DESC LIMIT 1");
					}
					$mainfeatROW = mysqli_fetch_assoc($main_featured_qry);
					$mainfeatURL = "review.php?t=" . urlencode(str_replace(" ", "_", $mainfeatROW['title'])) . "&g=" . urlencode(str_replace(" ", "_", $mainfeatROW['gamename']));
				?>

				<img src="imgs/review/<?php echo urlencode($mainfeatROW['a_image']); ?>">
				<a href="<?php echo $mainfeatURL; ?>" title="<?php echo $mainfeatROW['title']; ?>"></a>
				<h1 class="main_featured_article_banner"><abbr title="Game Shark Reviews">GSR</abbr> ARTICLES</h1>
			</section>
			<section class="grid_18">
				<br>
				<h2 id="filtering" style="margin-bottom:20px;">Filters</h2>
				<?php include "filters.html" ?>

				<ul class="article_list revpage">

					<div id="getter"></div>

				</ul>

	  			<span id="invis_value"></span>
			</section>

			<aside class="articles grid_6 tall_17">
				<?php include "aside.php"; ?>
			</aside>

		</article>
	</div>

	<?php include "footer.html"; ?>

	<script type="text/javascript">
		function bindNums(){
				$(".pag_btn, #next_btn, #prev_btn").click(function() {
				$(".pag_btn, #next_btn, #prev_btn").removeClass("active");
				$(this).addClass("active");
				$("#invis_value").text($(this).attr("data-button-name"));
				if($("#article_type").val()=="reviews"){
				setInterval(getReviewResults(),0);
				}
				if($("#article_type").val()=="opinions"){
				setInterval(getOpinionResults(),0);
				}
				if($("#article_type").val()=="news"){
				setInterval(getNewsResults(),0);
				}
				if($("#article_type").val()=="guides"){
				setInterval(getGuideResults(),0);
				}
				setInterval(reImage(),0);
				$("html, body").animate({
						scrollTop : ($("#filtering").offset().top - 80)
					}, "fast");
			});
		}
	
		$(function() {
			$(".filter_type").hide();
			$("#review_filters").show();
			var startup_url = "review_results.php?offset=0&rating=0&year=All&month=All";
			$.ajax({
				url : startup_url,
				type : "GET",
				async : false,
				success: function(startup_data) {
					$("#getter").html(startup_data);
					bindNums();
				}
			});

			$("#filters_form select, #filters_form input").change(function() {
				var article_type = $("#article_type").val();
				$("#invis_value").text("0");
				if(article_type=="reviews"){
				$(".filter_type").hide();
				$("#review_filters").show();
				setInterval(getReviewResults(),0);
				}
				if(article_type=="opinions"){
				$(".filter_type").hide();
				$("#opinion_filters").show();
				setInterval(getOpinionResults(),0);
				}
				if(article_type=="news"){
				$(".filter_type").hide();
				$("#news_filters").show();
				setInterval(getNewsResults(),0);
				}
				if(article_type=="guides"){
				$(".filter_type").hide();
				$("#guide_filters").show();
				setInterval(getGuideResults(),0);
				}
				
				setInterval(reImage(),0);
				$("html, body").animate({
						scrollTop : ($("#filtering").offset().top - 80)
					}, "fast");
			});

		

			setInterval(reImage(),0);
		});

		function getReviewResults() {
			var filtered_offset = "offset=" + $("#invis_value").text() + "&";
			//var filtered_platform = "platform=" + $("#review_filters select[name='platform']").val() + "&";
			var filtered_rating = "rating=" + $("#review_filters input[name='min_rating']").val() + "&";
			var filtered_year = "year=" + $("#review_filters select[name='year']").val() + "&";
			var filtered_month = "month=" + $("#review_filters select[name='month']").val();
			var filtered_url = "review_results.php?" + filtered_offset + filtered_rating + filtered_year + filtered_month;
			$.ajax({
				url : filtered_url,
				type : "GET",
				async : false,
				success: function(filtered_data) {
					$("#getter").html(filtered_data);
					bindNums();
				}
			});
		}

		function getOpinionResults() {
			var filtered_offset = "offset=" + $("#invis_value").text() + "&";
			var filtered_year = "year=" + $("#opinion_filters select[name='year']").val() + "&";
			var filtered_month = "month=" + $("#opinion_filters select[name='month']").val();
			var filtered_url = "opinion_results.php?" + filtered_offset +  filtered_year + filtered_month;
			$.ajax({
				url : filtered_url,
				type : "GET",
				async : false,
				success: function(filtered_data) {
					$("#getter").html(filtered_data);
					bindNums();
				}
			});
			
		}

		function getNewsResults() {
			var filtered_offset = "offset=" + $("#invis_value").text() + "&";
			var filtered_year = "year=" + $("#news_filters select[name='year']").val() + "&";
			var filtered_month = "month=" + $("#news_filters select[name='month']").val();
			var filtered_url = "news_results.php?" + filtered_offset +  filtered_year + filtered_month;
			$.ajax({
				url : filtered_url,
				type : "GET",
				async : false,
				success: function(filtered_data) {
					$("#getter").html(filtered_data);
					bindNums();
				}
			});

		}

		function getGuideResults() {
			var filtered_offset = "offset=" + $("#invis_value").text() + "&";
			var filtered_year = "year=" + $("#guide_filters select[name='year']").val() + "&";
			var filtered_month = "month=" + $("#guide_filters select[name='month']").val();
			var filtered_url = "guide_results.php?" + filtered_offset +  filtered_year + filtered_month;
			$.ajax({
				url : filtered_url,
				type : "GET",
				async : false,
				success: function(filtered_data) {
					$("#getter").html(filtered_data);
					bindNums();
				}
			});

		}

		function reImage() {
			$(".article_item").each(function() {
				$(this).children("#game_display").css("background", "url(imgs/"+$(this).attr("data-article-type")+"/" + $(this).attr("data-article-image") + ") no-repeat top right");
				$(this).children("#game_type").css("background", "url(imgs/"+$(this).attr("data-article-type")+"/" + $(this).attr("data-article-image") + ") no-repeat top left");
			});
		}
	</script>
</body>
</html>