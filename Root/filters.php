<!--

This php file contains the HTML code used to render the filter buttons for both articles.php and profile.php (so far).

THIS FILE REQUIRES $articles_info TO BE SET TO FUNCTION CORRECTLY. Ex: profile.php

Currently, I am working on making it function between these two pages seamlessly. As I am not great at CSS, I have left that for somebody
else to handle.

As it stands, the sort by views and date functionality is working.

Justin Lillico 22/11/2017

-->



<div id="filters">
	<form id="filters_form">

		<!-- Creates the filter type dropdown menu -->
		<label for="article_type">TYPE</label>
		<select name="article_type" id="article_type">
			<option value="none" selected>None</option> <!-- JL added 22/11 -->
			<option value="reviews" >Reviews</option>
			<option value="opinions">Opinions</option>
			<option value="news">News</option>
			<option value="guides">Guides</option>
		</select>
		<div id="opinion_filters" class="filter_type">

		<!-- Creates the YEAR dropdown menu -->
		<label for="year">YEAR</label>
		<select name="year" id="opinion_year">
			<option selected>All</option>
			<option>2016</option>
			<option>2015</option>
		</select>

		<!-- Creates the month dropdown menu -->
		<label for="month">MONTH</label>
		<select name="month" id="opinion_month">
			<option selected>All</option>
			<option>Jan</option>
			<option>Feb</option>
			<option>Mar</option>
			<option>Apr</option>
			<option>May</option>
			<option>Jun</option>
			<option>Jul</option>
			<option>Aug</option>
			<option>Sep</option>
			<option>Oct</option>
			<option>Nov</option>
			<option>Dec</option>
		</select>
	</div> <!-- End opinion_filters -->

		<!-- Sets the differnt style of dropdowns for all but reviews -->
		<div id="news_filters" class="filter_type">
		<label for="year">YEAR</label>
		<select name="year" id="news_year">
			<option selected>All</option>
			<option>2016</option>
			<option>2015</option>
		</select>
		<label for="month">MONTH</label>
		<select name="month" id="news_month">
			<option selected>All</option>
			<option>Jan</option>
			<option>Feb</option>
			<option>Mar</option>
			<option>Apr</option>
			<option>May</option>
			<option>Jun</option>
			<option>Jul</option>
			<option>Aug</option>
			<option>Sep</option>
			<option>Oct</option>
			<option>Nov</option>
			<option>Dec</option>
		</select>
	</div><!-- End news_filters -->

		<!-- Sets the differnt style of dropdowns for all but reviews -->
		<div id="guide_filters" class="filter_type">
		<label for="year">YEAR</label>
		<select name="year" id="guide_year">
			<option selected>All</option>
			<option>2016</option>
			<option>2015</option>
		</select>
		<label for="month">MONTH</label>
		<select name="month" id="guide_month">
			<option selected>All</option>
			<option>Jan</option>
			<option>Feb</option>
			<option>Mar</option>
			<option>Apr</option>
			<option>May</option>
			<option>Jun</option>
			<option>Jul</option>
			<option>Aug</option>
			<option>Sep</option>
			<option>Oct</option>
			<option>Nov</option>
			<option>Dec</option>
		</select>
	</div><!-- End guide_filters -->
		<div id="review_filters" class="filter_type">

			<!-- This is for platform but is not currently in use -->
		<!--<label for="platform">PLATFORM</label>
		<select name="platform" id="review_platform">
			<option selected>All</option>
			<option>Xbox One</option>
			<option>Playstation 4</option>
			<option>PC</option>
			<option>DS &amp; 3DS</option>
			<option>Wii</option>
		</select>-->

		<!-- Sets the differnt style of dropdowns for all but reviews -->
		<label for="min_rating">MIN RATING</label>
		<input name="min_rating" type="range" value="0.0" min="0.0" max="10" />
		<label for="min_rating" id="rating_value">0.0</label>
		<label for="year">YEAR</label>
		<select name="year" id="review_year">
			<option selected>All</option>
			<option>2016</option>
			<option>2015</option>
		</select>
		<label for="month">MONTH</label>
		<select name="month" id="review_month">
			<option selected>All</option>
			<option>Jan</option>
			<option>Feb</option>
			<option>Mar</option>
			<option>Apr</option>
			<option>May</option>
			<option>Jun</option>
			<option>Jul</option>
			<option>Aug</option>
			<option>Sep</option>
			<option>Oct</option>
			<option>Nov</option>
			<option>Dec</option>
		</select>
	</div><!-- End min_rating -->
	<p> <!-- Added by JL for arrangement filters -->
	<label for="views">VIEWS</label>
	<select name="views" id="views_drop">
		<option value='none' selected>---</option>
		<option value='hightolow'>High to low</option>
		<option value='lowtohigh'>Low to high</option>
	</select>
	<label for="dates">DATE</label>
	<select name="dates" id="dates_drop">
		<option value='none' selected>---</option>
		<option value='hightolow'>Most Recent</option>
		<option value='lowtohigh'>Oldest first</option>
	</select>


	</form>
</div>

<script type="text/javascript">
//This is to make articles.php play nice until I can merge the two
var profilePage = window.location.href.includes("profile.php");
if(profilePage){


	//Variables

	var js_article_info = [[], []];
	var original_order = [[], []];
	var parent;

	//END variables

		//Creates the JS array containing views and dates.

		<?php

			echo "var js_views_dates = [";
			for ($i = 0; $i < sizeof($articles_info); $i++) {
				echo " [ " . $articles_info[$i][6] . ", " . strtotime($articles_info[$i][7]) . "] ,";
			}
			echo "];";


		?>

		// END PHP

	//Functions

	//This function arranges the displayed array in the way that is selected.
	//original_array = The array to be sorted
	//order_by = The position in the array to sort by.
	//high_low = A boolean representing which way to sort.
	function setupOrder(original_array, order_by, high_low){


		//This is a sort function that arranges the array by the first dimention, in numeric lowest to highest order
		original_array.sort(function(a, b){
			if (a[order_by] === b[order_by]) {
        return 0;
    	}
    	else {
        return (a[order_by] < b[order_by]) ? -1 : 1;
    	}
		});

		if(high_low)
			original_array.reverse();
	}

	//This function updates the articles on screen according to an array.
	//order: The 2d array it is to sort the articles by.
	function updateArticles(order){

		//This while loop simply removes the contents of the parent div by ID.
		while (document.getElementById("article_box").hasChildNodes()) {
			document.getElementById("article_box").removeChild(document.getElementById("article_box").lastChild);
		}

		//This for loop appends the objects from start to finish of the new array.
		for (var i = 0; i < order.length; i++){
			document.getElementById("article_box").appendChild(order[i][0]);
		}
	}

	//END Functions


	//JQuery
		$(document).ready(function() {

			//Get the elements.
			parent = document.getElementById("article_box").children;

			//Here, we combine the object in its original form along with the views and date gathered from the php.
			//0 : views
			//1 : dates
			for (var i = 0; i < js_views_dates.length; i++){
				js_article_info[i] = [parent[i], js_views_dates[i][0], js_views_dates[i][1]];
			}

			//This preserves the original order of the articles
			original_order = js_article_info.slice();



			//Organizes by view count
			$("#views_drop").change(function() {

				if ($(this).val() === 'none'){
					updateArticles(original_order);
				}

				if ($(this).val() === 'hightolow'){
					setupOrder(js_article_info, 1, true);
					updateArticles(js_article_info);
				}

				if ($(this).val() === 'lowtohigh'){
					setupOrder(js_article_info, 1, false);
					updateArticles(js_article_info);
				}

				//Sets dates to none as it is not the 'select' in use.
				$("#dates_drop").val('none');

			});

			//Organizes by date
			$("#dates_drop").change(function() {

				if ($(this).val() === 'none'){
					updateArticles(original_order);
				}

				if ($(this).val() === 'hightolow'){
					setupOrder(js_article_info, 2, true);
					updateArticles(js_article_info);
				}

				if ($(this).val() === 'lowtohigh'){
					setupOrder(js_article_info, 2, false);
					updateArticles(js_article_info);
				}

				//Sets views to none as it is not the 'select' in use.
				$("#views_drop").val('none');

			});




		//Filter by type

			$("#article_type").change(function() {
				if ($(this).val() === 'reviews'){

					$(".thumbnail_Guide").hide();
			    $(".thumbnail_Opinion").hide();
			    $(".thumbnail_News").hide();
			    $(".thumbnail_Review").show();

				}
				if ($(this).val() === 'opinions'){

					$(".thumbnail_Guide").hide();
			    $(".thumbnail_Review").hide();
			    $(".thumbnail_News").hide();
			    $(".thumbnail_Opinion").show();

				}
				if ($(this).val() === 'news'){

					$(".thumbnail_Guide").hide();
			    $(".thumbnail_Opinion").hide();
			    $(".thumbnail_Review").hide();
			    $(".thumbnail_News").show();

				}
				if ($(this).val() === 'guides'){

					$(".thumbnail_Review").hide();
			    $(".thumbnail_Opinion").hide();
			    $(".thumbnail_News").hide();
			    $(".thumbnail_Guide").show();

				}

				if ($(this).val() === 'none'){
			    $(".thumbnail_Guide").show();
			    $(".thumbnail_Opinion").show();
			    $(".thumbnail_Review").show();
			    $(".thumbnail_News").show();
			  }
			});
	});



}//END if statement
</script>
