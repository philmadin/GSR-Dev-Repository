<div id="db-left">
	<br /><br />
<ul id="db-nav" class="sticky">
			<li><a href="dashboard.php"><span class="fa fa-2x fa-dashboard"></span>	&nbsp;   Dashboard</a></li>
			<li><a href="staff-announcement.php"><span class="fa fa-2x fa-bullhorn"></span>	&nbsp;   Staff Announcements</a></li>
			<li><a href="staffguides.php"><span class="fa fa-2x fa-question-circle"></span>	&nbsp;   HOW-TO Staff Guides</a></li>
			<?php if(has_perms("my-articles")) {  ?>
			<li><a href="myarticlelist.php"><span class="fa fa-2x fa-list-alt"></span>	&nbsp;   My Articles</a></li>
			<?php } ?>
			<?php if(has_perms("manage-articles")) { ?>
			<li><a class="toggle-sub-nav" data-id="articletypes" href="articlelist.php"><span class="fa fa-2x fa-list"></span>	&nbsp;   Manage Articles</a></li>
			<ul class="sub-nav" id="sub-articletypes">
			<li><a href="articlelist.php?type=review"><span class="fa fa-2x fa-star"></span>	&nbsp;   Reviews</a></li>
			<li><a href="articlelist.php?type=opinion"><span class="fa fa-2x fa-street-view"></span>	&nbsp;   Opinion Pieces</a></li>
			<li><a href="articlelist.php?type=news"><span class="fa fa-2x fa-newspaper-o"></span>	&nbsp;   News Articles</a></li>
			<li><a href="articlelist.php?type=guide"><span class="fa fa-2x fa-th-list"></span>	&nbsp;   Guides/Walkthroughs</a></li>
			</ul>
			<?php } ?>

			<?php if(has_perms("my-articles")) { ?>
				<li><a class="toggle-sub-nav" data-id="submittypes" href="submit.php"><span class="fa fa-2x fa-plus-square"></span>	&nbsp;   Submit Article</a></li>
				<ul class="sub-nav" id="sub-submittypes">
					<li><a href="submit.php?type=Review"><span class="fa fa-2x fa-star"></span>	&nbsp;   Review</a></li>
					<li><a href="submit.php?type=Opinion"><span class="fa fa-2x fa-street-view"></span>	&nbsp;   Opinion Piece</a></li>
					<li><a href="submit.php?type=News"><span class="fa fa-2x fa-newspaper-o"></span>	&nbsp;   News Articles</a></li>
					<li><a href="submit.php?type=Guide"><span class="fa fa-2x fa-th-list"></span>	&nbsp;   Guides/Walkthrough</a></li>
				</ul>
			<?php } ?>

			<?php if(has_perms("manage-wiki")){ ?>
				<li><a class="toggle-sub-nav" data-id="managewiki" href="#"><span class="fa fa-2x fa-wrench"></span>	&nbsp;   Manage Wiki</a></li>
				<ul class="sub-nav" id="sub-managewiki">
					<li><a href="manage-games.php"><span class="fa fa-2x fa-gamepad"></span>	&nbsp;   Games</a></li>
					<li><a href="manage-characters.php"><span class="fa fa-2x fa-male"></span>	&nbsp;   Characters</a></li>
					<li><a href="manage-platforms.php"><span class="fa fa-2x fa-power-off"></span>	&nbsp;   Platforms</a></li>
					<li><a href="manage-devpubs.php"><span class="fa fa-2x fa-code"></span>	&nbsp;   Developers/Publishers</a></li>
				</ul>

			<?php } ?>

            <?php if(has_perms("manage-users")) { ?>
            <li><a href="users.php"><span class="fa fa-2x fa-users"></span>	&nbsp;   Manage Users</a></li>
			<?php }
            if(has_perms("manage-staff")) { ?>
			<li><a href="staff.php"><span class="fa fa-2x fa-user-md"></span>	&nbsp;   Manage Staff</a></li>
			<?php }
            if(has_perms("manage-ranks")) { ?>
			<li><a href="ranks.php"><span class="fa fa-2x fa-trophy"></span>	&nbsp;   Manage Ranks</a></li>
			<?php } ?>
</ul>

<?php
	include 'dashboard-chat.php';
?>

</div>

<script>
$(".toggle-sub-nav").click(function(e){
	e.preventDefault();
	var sub_nav = $("#sub-"+$(this).attr("data-id"));
	$('.sub-nav:not(#sub-'+$(this).attr("data-id")+')').slideUp("fa fa-2xst");
	sub_nav.slideToggle("fa fa-2xst");
});
</script>