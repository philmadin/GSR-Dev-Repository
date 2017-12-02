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
			<option value="none" selected>All</option> <!-- JL added 22/11 -->
			<option value="reviews">Reviews</option>
			<option value="opinions">Opinions</option>
			<option value="news">News</option>
			<option value="guides">Guides</option>
		</select>
		<!-- Added by JL for arrangement filters -->
		<label for="type">ORDER BY</label>
		<select name="type" id="type_drop">
			<option value='createdate' selected>Date</option>
			<option value='views'>Views</option>
		</select>
		<!-- <label for="dates"></label> -->
		<select name="order" id="orderby_drop">
			<option value='DESC'selected>High to low</option>
			<option value='ASC'>Low to high</option>
		</select>
	</form>
</div>
