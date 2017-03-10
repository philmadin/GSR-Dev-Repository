<?php
	include "mysql_con.php";
	//include 'videos-get.php';

	$user = $_SESSION['username'];

	usort($v['i'], function($a, $b) {
    return $a['i']['statistics']['viewCount'] - $b['i']['statistics']['viewCount'];
	});

	if(!isset($user)) { header("location:index.php"); }

	$accountQRY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$user'");

	while($SAQRY = mysqli_fetch_assoc($accountQRY)) {
		$acc_firstname	= $SAQRY['firstname'];
		$acc_lastname	= $SAQRY['lastname'];
		$acc_fullname	= $acc_firstname . " " . $acc_lastname;
		$acc_posa		= $SAQRY['posa'];
		$acc_posb		= $SAQRY['posb'];
		$acc_position	= $acc_posa . " " . $acc_posb;
		$acc_db_rows    = unserialize($SAQRY['dashboard_rows']);
	}

if(!has_perms("dashboard")){
	header("Location: index.php");
}
	
	
function formatNum($num) {
	if(!isset($num)){return false;}
  $x = round($num);
  $x_number_format = number_format($x);
  $x_array = explode(',', $x_number_format);
  $x_parts = array('k', 'm', 'b', 't');
  $x_count_parts = count($x_array) - 1;
  $x_display = $x;
  $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
  $x_display .= $x_parts[$x_count_parts - 1];
  return $x_display;
}


$graph1 = last6months();$month_num=-1;
foreach($graph1 as $month){
	$month_num++;
	$stat_month = $graph1[$month_num][0];
	$stat_year = $graph1[$month_num][1];
	$graph1[$month_num][2] = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE type='view' AND month='$stat_month' AND year='$stat_year'"));
}


$review_count = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_review WHERE alpha_approved = 'true'"));
$opinion_count = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_opinion WHERE alpha_approved = 'true'"));
$news_count = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_news WHERE alpha_approved = 'true'"));
$guide_count = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_opinion WHERE alpha_approved = 'true'"));
$article_count = formatNum($review_count+$opinion_count+$guide_count+$news_count);
//$video_view_count = formatNum(totalViews());

$search_count = formatNum(mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_search")));
$view_count = formatNum(mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE type='view'")));
$bite_count = formatNum(mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE type='bite' AND article_id!=0")));
$user_count = formatNum(mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_users")));


	$countryArray = array();
	$countryType = "countryname";
	array_push($countryArray, array('Country', 'Views'));
	$getCountries = mysqli_query($con, "SELECT distinct $countryType FROM tbl_article_stats");
	while ($stat = mysqli_fetch_assoc($getCountries)) {
		$country = $stat[$countryType];
		$countryNum = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_article_stats WHERE $countryType='$country'"));
		if($country!=""){array_push($countryArray, array($country, $countryNum));}
	}
	
	


?>

<!doctype html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, follow, noarchive">

<title>Dashboard | Home | GSR</title>

<meta name="description" content="Staff Dashboard">

<?php include "links.php"; ?>

</head>

<body>

	<?php include "header.php"; ?>

	<div id="page" class="container_24">

		<article>

			<section id="dashboard">
	
			<?php include 'dashboard-nav.php';?>
			
			<div id="db-main">
			
<!--ROW1 START-->
<?php include 'dashboard-msg.php';?>
<!--ROW1 END-->
	
<!--ROW2 START-->  <div data-id="2" class="row sort" id="row_2">
					<div class="box top-list">
					<span>Top Reviews</span>		
						<?php
						$popular_reviews = mysqli_query($con, "SELECT * FROM tbl_review WHERE alpha_approved = 'true' ORDER BY bites DESC, views DESC LIMIT 5");
						while ($poprev = mysqli_fetch_assoc($popular_reviews)) {
						$pop_title	= $poprev['title'];
						$pop_url	= "review.php?t=" . str_replace(" ", "_", $poprev['title']) . "&g=" . str_replace(" ", "_", $poprev['gamename']);
						?>
						<a href="<?php echo $pop_url; ?>"><?php echo $pop_title; ?></a>
						<?php } ?>
					</div>
					<div class="box top-list">
					<span>Top Opinion Pieces</span>
						<?php
						$popular_opinions = mysqli_query($con, "SELECT * FROM tbl_opinion WHERE alpha_approved = 'true' ORDER BY bites DESC, views DESC LIMIT 5");
						while ($popop = mysqli_fetch_assoc($popular_opinions)) {
						$pop_title	= $popop['title'];
						$pop_url	= "opinion.php?t=" . str_replace(" ", "_", $popop['title']);
						?>
						<a href="<?php echo $pop_url; ?>"><?php echo $pop_title; ?></a>
						<?php } ?>	
					</div>
					<div class="box top-list">
					<span>Top Guides</span>
						<?php
						$popular_guides = mysqli_query($con, "SELECT * FROM tbl_guide WHERE alpha_approved = 'true' ORDER BY bites DESC, views DESC LIMIT 5");
						while ($popguide = mysqli_fetch_assoc($popular_guides)) {
						$pop_title	= $popguide['title'];
						$pop_url	= "guide.php?t=" . str_replace(" ", "_", $popguide['title']);
						?>
						<a href="<?php echo $pop_url; ?>"><?php echo $pop_title; ?></a>
						<?php } ?>	
					</div>
<!--ROW2 END-->	   </div>	
		
<!--ROW3 START-->  <div data-id="3" class="row sort" id="row_3">
					<div class="box num-stats">
					<div class="box num-stat"><b><?php echo $article_count;?></b>Articles</div>
					<div class="box num-stat"><b><?php echo $search_count;?></b>Searches</div>
					<div class="box num-stat"><b><?php echo $view_count;?></b>Article Views</div>
					<div class="box num-stat"><b><?php echo $user_count;?></b>Users</div>
					<div class="box num-stat"><b><?php echo $video_view_count;?></b>Video Views</div>
					<div class="box num-stat"><b><?php echo $bite_count;?></b>Article Bites</div>
					</div>
<!--ROW3 END-->	   </div>

<!--ROW4 START-->  <div data-id="4" class="row sort" id="row_4">
					<div class="box graph">
					<span>Article views in last 6 months</span>
					<canvas id="graph1" width="335" height="270"></canvas>
					</div>
					<div class="box graph">
					<span>Graph 2</span>
					<canvas id="graph2" width="335" height="270"></canvas>
					</div>
<!--ROW4 END-->	   </div>

<!--ROW5 START-->  <div data-id="5" class="row sort" id="row_5">
					<div class="box top-list">
					<span>Top Searches</span>				
					<?php
					$top_searches = mysqli_query($con, "SELECT query, COUNT(*) AS occurrences FROM tbl_search WHERE page_num = 1 GROUP BY query ORDER BY occurrences DESC LIMIT 5");
					while ($search = mysqli_fetch_assoc($top_searches)) {
					$query = $search['query'];
					$search_num = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_search WHERE query = '$query' AND page_num = 1"));
					$search_url	= "search.php?q=".urlencode($query);
					?>
					<a href="<?php echo $search_url; ?>"><?php echo $query." <b>".$search_num."</b>"; ?></a>
					<?php } ?>	
					
					</div>
					<div class="box top-list">
					<span>Top Staff Contributers</span>
					<?php
					$top_conts = mysqli_query($con, "SELECT *, COUNT(*) AS occurrences FROM tbl_review GROUP BY authuser ORDER BY occurrences DESC LIMIT 5");
					while ($conts = mysqli_fetch_assoc($top_conts)) {
					$id 			= $conts["id"];
					$author 		= $conts["author"];
					$authuser 		= $conts["authuser"];
					$profile_url	= "profile.php?profilename=".$authuser;
					?>
					<a href="<?php echo $profile_url; ?>"><?php echo $author; ?></a>
					<?php } ?>	
					</div>
					<div class="box top-list">
					<span>Top Users</span>
					<?php
					$top_users = mysqli_query($con, "SELECT * FROM tbl_accounts ORDER BY level DESC, xp DESC LIMIT 5");
					while ($users = mysqli_fetch_assoc($top_users)) {
					$fullname 		= $users["firstname"]." ".$users["lastname"];
					$profile_url	= "profile.php?profilename=".$users["username"];
					?>
					<a href="<?php echo $profile_url; ?>"><?php echo $fullname; ?></a>
					<?php } ?>	
					</div>
<!--ROW5 END-->	   </div>

<!--ROW6 START-->  <div data-id="6" class="row sort" id="row_6">
					<div class="box top-list">
					<span>Top Videos</span>				
					<?php
					foreach($v['i'] as $vid){
						echo '<a class="more-info" href="video.php?id='.$vid['id'].'">';									echo $vid['snippet']['title'];
						echo '</a>';
						}
					?>
					</div>
					<div class="box top-list">
					<span>Placeholder Box</span>
					<!--PLACEHOLDER BOX-->
					</div>
					<div class="box top-list">
					<span>Placeholder Box</span>
					<!--PLACEHOLDER BOX-->
					</div>
<!--ROW6 END-->	   </div>

<!--ROW7 START-->  <div data-id="7" class="row sort" id="row_7">
					<div class="box geo">
					<span>Article views by country</span>
					<div id="geo-container"></div>
					</div>
<!--ROW7 END-->	   </div>

			
			</div>
			

			</section>

		</article>

	</div>

	<?php include "footer.html"; ?>
	
	
	
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['geochart']});
      google.charts.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
		var countries = <?php echo json_encode($countryArray); ?>;
        var data = google.visualization.arrayToDataTable(countries);

        var options = { 
		colorAxis: {colors: ['#E8A9A9', '#E73030']},
		datalessRegionColor: '#E8E8E8',
        defaultColor: '#FFF'
		};

        var chart = new google.visualization.GeoChart(document.getElementById('geo-container'));

        chart.draw(data, options);
      }
    </script>

	<script type="text/javascript">

	$('#db-main').sortable({
    axis: 'y',
	containment: "parent",
    update: function (event, ui) {
        var data = $(this).sortable('serialize');

       // POST to server using $.post or $.ajax
       $.post("dashboard-save.php", data, function(result){
    });
    }
});
var data1 = {
    labels: [<?php echo '"'.$graph1[5][0]." - ".$graph1[5][1].'", "'.$graph1[4][0]." - ".$graph1[4][1].'", "'.$graph1[3][0]." - ".$graph1[3][1].'", "'.$graph1[2][0]." - ".$graph1[2][1].'", "'.$graph1[1][0]." - ".$graph1[1][1].'", "'.$graph1[0][0]." - ".$graph1[0][1].'"';	?>],
    datasets: [
        {
            label: "Article views in last 6 months",
            fillColor: "#E73030",
            strokeColor: "#FFF",
            highlightFill: "#A22321",
            highlightStroke: "#FFF",
            data: [<?php echo $graph1[5][2].",".$graph1[4][2].",".$graph1[3][2].",".$graph1[2][2].",".$graph1[1][2].",".$graph1[0][2]; ?>]
        }
    ]
};
var graph1 = document.getElementById("graph1").getContext("2d");
var myBarChart1 = new Chart(graph1).Line(data1);

var data2 = [
    {
        value: 300,
        color:"#F7464A",
        highlight: "#FF5A5E",
        label: "Red"
    },
    {
        value: 50,
        color: "#46BFBD",
        highlight: "#5AD3D1",
        label: "Green"
    },
    {
        value: 100,
        color: "#FDB45C",
        highlight: "#FFC870",
        label: "Yellow"
    }
]

var graph2 = document.getElementById("graph2").getContext("2d");
var myPieChart2 = new Chart(graph2).Pie(data2);

$(function(){
var order = [<?php echo implode(",",$acc_db_rows);?>];
var el = $('#db-main');
var map = {};

$('#db-main .sort').each(function() { 
    var el = $(this);
    map[el.attr('data-id')] = el;
});

for (var i = 0, l = order.length; i < l; i ++) {
    if (map[order[i]]) {
        el.append(map[order[i]]);
    }
}
});  

	</script>

</body>
</html>