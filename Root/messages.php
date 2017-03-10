<?php
	include "mysql_con.php";

	$usersMessages = $_SESSION['username'];

	$msgQRY = mysqli_query($con, "SELECT * FROM tbl_messages WHERE receiver = '$usersMessages'");

	while ($msgROW = mysqli_fetch_assoc($msgQRY)) {
		$um_from	= $msgROW['sender'];
		$um_sub		= $msgROW['subject'];
		$um_msg		= $msgROW['message'];
		$um_date	= $msgROW['date'];
	}
?>

<!doctype html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="index, follow, noarchive">

<title><?php echo $usersMessages; ?>'s Messages | GSR</title>

<meta name="description" content="GSR - <?php echo $usersMessages; ?>'s message inbox.">

<?php include "links.php"; ?>

</head>

<body>

	<?php include "header.php"; ?>

	<div id="page" class="container_24">

		<article>

			<section class="grid_8" id="messagelist">
				<a id="inbox_button">INBOX <i>&#10094;</i></a>
				<ul id="inbox">
					<li><b>Don't mess with me</b> - daUS3rN4M3 - <i>Hey, that was some pretty cool work you did on COD but I'm still pro.</i></li>
					<li><b>You suck!</b> - s0m3G41 - <i>HAHA! With all your efforts you stood no chance!</i></li>
					<li><b>Welcome to the team!</b> - MijoroGUY - <i>G'day USER, nice to finally have you aboard the crew.</i></li>
					<li><b>Account Verification</b> - jojoReaper - <i>Dear USER, before we can accept you as one of us you must first do something.</i></li>
					<li><b>message to you</b> - bunnyKiLL3rz - <i>hi, how r u?</i></li>
					<li><b>Hey Bro!</b> - KiWiG41 - <i>HEY! So awesome to finally have someone working with me on this project!</i></li>
					<li><b>Nice to meet you</b> - magichickens - <i>Hey, I'm not too sure about that, you'd have to ask the CEO.</i></li>
					<li><b>Awesome work!</b> - MicaelduCiel - <i>Hey, Loved your work on this review, keep it up!</i></li>
				</ul>

				<a id="outbox_button" class="collapsed">OUTBOX <i>&#10094;</i></a>
				<ul id="outbox" class="collapsed">
					<li><b>Don't mess with me</b> - daUS3rN4M3 - <i>Hey, that was some pretty cool work you did on COD but I'm still pro.</i></li>
					<li><b>You suck!</b> - s0m3G41 - <i>HAHA! With all your efforts you stood no chance!</i></li>
					<li><b>Welcome to the team!</b> - MijoroGUY - <i>G'day USER, nice to finally have you aboard the crew.</i></li>
					<li><b>Account Verification</b> - jojoReaper - <i>Dear USER, before we can accept you as one of us you must first do something.</i></li>
					<li><b>message to you</b> - bunnyKiLL3rz - <i>hi, how r u?</i></li>
					<li><b>Hey Bro!</b> - KiWiG41 - <i>HEY! So awesome to finally have someone working with me on this project!</i></li>
					<li><b>Nice to meet you</b> - magichickens - <i>Hey, I'm not too sure about that, you'd have to ask the CEO.</i></li>
					<li><b>Awesome work!</b> - MicaelduCiel - <i>Hey, Loved your work on this review, keep it up!</i></li>
				</ul>
			</section>

			<section class="grid_16 grid_0" id="displaymessage">

			</section>

		</article>

	</div>

	<?php include "footer.html"; ?>

	<script type="text/javascript">
		$(function() {
			$("ul.collapsed").hide();

			$("#outbox_button").click(function() {
				$(this, "#outbox").toggleClass('collapsed');
				$("#outbox").toggle();
			});

			$("#inbox_button").click(function() {
				$(this, "#inbox").toggleClass('collapsed');
				$("#inbox").toggle();
			});

			$("#inbox li").each(function(index, el) {
				$(this).click(function(event) {
					$("#outbox li, #inbox li").not(this).removeClass('open');
					$(this).addClass('open');
				});
			});

			$("#outbox li").each(function(index, el) {
				$(this).click(function(event) {
					$("#outbox li, #inbox li").not(this).removeClass('open');
					$(this).addClass('open');
				});
			});
		});
	</script>

</body>
</html>