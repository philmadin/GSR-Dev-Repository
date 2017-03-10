<!doctype html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, follow, noarchive">

<title>Account Verification | GSR</title>

<meta name="description" content="Account verification on GSR">

<?php include "links.php"; ?>

</head>

<body>

	<?php include "header.php"; ?>

	<div id="page" class="container_24">

		<article>

			<?php
				include "mysql_con.php";

				if(isset($user)) {
					header("location:index.php");
				} else {
					$email 	= $_GET['a'];
					$verify	= $_GET['h'];

					$verifyQRY = mysqli_query($con, "SELECT * FROM tbl_users WHERE email = '$email' AND verify = '$verify'");

					if(mysqli_num_rows($verifyQRY) < 1) {
						?>
							<script type="text/javascript">
								document.location = "index.php";
							</script>
						<?php
					} else {

						while($VRQRY = mysqli_fetch_assoc($verifyQRY)) {
							$ver_username 	= $VRQRY['username'];
							$ver_verify		= $VRQRY['verify'];
						}

						$hashCheck = md5($email . $ver_username);

						if($hashCheck == $verify) {
							$verifiedAccount = mysqli_query($con, "UPDATE tbl_users SET verify = 'verified' WHERE username = '$ver_username'");

							if($verifiedAccount) {
			?>

			<section>
				<div class="grid_16 plainpage">
					<h1>YOUR EMAIL HAS BEEN VERIFIED!</h1>
					<p>You will now be redirected to the homepage to login.</p>
				</div>
			</section>

			<?php
							}
						} else {
							?>
								<script type="text/javascript">
									document.location = "index.php";
								</script>
							<?php
						}
					}
				}
			?>


		</article>

	</div>

	<?php include "footer.html"; ?>

	<script type="text/javascript">
		$(function() {
			if($(".plainpage").length) {
				setInterval(function() {
					document.location = "index.php";
				}, 5000)
			}
		});
	</script>

</body>
</html>