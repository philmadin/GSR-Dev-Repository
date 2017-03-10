<?php
	include "mysql_con.php";

	$user = $_SESSION['username'];
	$setID = $_GET['article_images'];
	$article_type = $_GET['type'];
	
	if(!isset($user)) { header("location:index.php"); }
	if(empty($setID)) { header("location:index.php"); }
	if(empty($article_type)) { header("location:index.php"); }
	if($article_type!="review" && $article_type!="opinion" && $article_type!="guide" && $article_type!="news"){ header("location:index.php"); }

	$accountQRY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$user'");
	$articleQRY = mysqli_query($con, "SELECT * FROM tbl_$article_type WHERE id = '$setID'");

	while($ACQRY = mysqli_fetch_assoc($accountQRY)) {
		$acc_firstname		= $ACQRY['firstname'];
		$acc_lastname		= $ACQRY['lastname'];
		$acc_fullname		= $acc_firstname . " " . $acc_lastname;
		$acc_posa			= $ACQRY['posa'];
		$acc_posb			= $ACQRY['posb'];
		$acc_position		= $acc_posa . " " . $acc_posb;
	}


	while ($ATQRY = mysqli_fetch_assoc($articleQRY)) {
		$art_type		= $ATQRY['article_type'];
		$authuser		= $ATQRY['authuser'];
		$art_title 		= urlencode($ATQRY['title']);
		$art_aimage		= urlencode($ATQRY['a_image']);
		$art_bimage		= urlencode($ATQRY['b_image']);
		$art_cimage		= urlencode($ATQRY['c_image']);
		$art_dimage		= urlencode($ATQRY['d_image']);
		$art_eimage		= urlencode($ATQRY['e_image']);


        global $authuser;
        if (!has_perms("edit-article-override")) {
            if($user!=$authuser) {
                header("Location: articlelist.php");
            }
        }

		
		$art_guide_images = unserialize($ATQRY['images']);
		
		$steps = unserialize($ATQRY['steps']);
		$step_num = 0;
		$step_num2 = 0;
	}
?>

<!doctype html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, follow, noarchive">

<title>Upload or Change Images | Article Images | GSR</title>

<meta name="description" content="Upload or Change Images For <?php echo $sub_articletitle; ?> | Article Images | GSR">

<?php include "links.php"; ?>

</head>

<body>

	<?php include "header.php"; ?>

	<div id="page" class="container_24">

		<article>

			<section id="articlesubmit">

				<form class="grid_24 grid_0 submitform" id="submitform" action="submit<?php echo $article_type;?>.php" method="post" enctype="multipart/form-data">

					<h6>UPLOAD IMAGES</h6>
					<span>(uploads will automatically remove already set images)</span>
					<?php if($art_type == "Guide"){ ?>
					
					<p class="scroll_section" id="aimage_section">
				    	<label for="0image">0. Image - Guide Main Image <i>(&lsquo;jpg&rsquo; files only)</i></label>
				        <input name="0image" id="aimage" type="file" accept="image/jpeg" />
				        <span>
				        	This image will be used in the article search and browsing as well as the cover image for the article.<br>
				        	Recommended image width &lsquo;960px&rsquo; - ask your lead web developer or graphic designer for support.<br>
				        	Cannot be more than 700KB.
				        </span>
				    </p>
					
					<?php foreach($steps as $step) {  $step_num++;   ?>
				    <p class="scroll_section" id="<?php echo $step_num;?>image_section">
				    	<label for="<?php echo $step_num;?>image">Step <?php echo $step_num;?>. Image <i>(&lsquo;jpg&rsquo; files only)</i></label>
				        <input name="<?php echo $step_num;?>image" id="<?php echo $step_num;?>image" type="file" accept="image/jpeg" />
				        <span>
				        	This is the image that will display for step <?php echo $step_num;?> of the guide.<br>
				        	Cannot be more than 2MB.
				        </span>
				    </p>
					
					<?php } ?>

				    <p id="submit_section">
				        <button name="upload_images" id="upload_images" type="submit" value="<?php echo $setID; ?>">UPLOAD</button>
				    </p>

				    <p>&nbsp;</p>
				    <p>&nbsp;</p>

					<h6>Set Images</h6>

					<p>
						<?php
							echo "<label>0. Image - Guide Main Image</label>";
							if(!empty($art_guide_images[0])) {
								echo "<a class='setimage' data-set-image='0_image' data-article-id='" . $setID . "'><img src='imgs/".$article_type."/" . $art_guide_images[0] . "'></a>";
							} else {
								echo "<span>There is no set image.</span>";
							}
						?>
					</p>
					
					<?php foreach($steps as $step){ $step_num2++;?>
					<p>
						<?php
							echo "<label>Step ".$step_num2.". Image</label>";
							if(!empty($art_guide_images[$step_num2])) {
								echo "<a class='setimage' data-set-image='".$step_num2."_image' data-article-id='" . $setID . "'><img src='imgs/".$article_type."/" . $art_guide_images[$step_num2] . "'></a>";
							} else {
								echo "<span>There is no set image.</span>";
							}
						?>
					</p>
					<?php } ?>

					
					
					<?php } else{  ?>

				    <p class="scroll_section" id="aimage_section">
				    	<label for="aimage">A. Image - Main Image <i>(&lsquo;jpg&rsquo; files only)</i></label>
				        <input name="aimage" id="aimage" type="file" accept="image/jpeg" />
				        <span>
				        	This image will be used in the article search and browsing as well as the cover image for the article.<br>
				        	Recommended image width &lsquo;960px&rsquo; - ask your lead web developer or graphic designer for support.<br>
				        	Cannot be more than 700KB.
				        </span>
				    </p>

				    <p class="scroll_section" id="bimage_section">
				    	<label for="bimage">B. Image <i>(&lsquo;jpg&rsquo; files only)</i></label>
				        <input name="bimage" id="bimage" type="file" accept="image/jpeg" />
				        <span>
				        	Wallpaper size is recommended.<br>
				        	Cannot be more than 2MB.
				        </span>
				    </p>

				    <p class="scroll_section" id="cimage_section">
				    	<label for="cimage">C. Image <i>(&lsquo;jpg&rsquo; files only)</i></label>
				        <input name="cimage" id="cimage" type="file" accept="image/jpeg" />
				        <span>
				        	Wallpaper size is recommended.<br>
				        	Cannot be more than 2MB.
				        </span>
				    </p>

				    <p class="scroll_section" id="dimage_section">
				    	<label for="dimage">D. Image <i>(&lsquo;jpg&rsquo; files only)</i></label>
				        <input name="dimage" id="dimage" type="file" accept="image/jpeg" />
				        <span>
				        	Wallpaper size is recommended.<br>
				        	Cannot be more than 2MB.
				        </span>
				    </p>

				    <p class="scroll_section" id="eimage_section">
				    	<label for="eimage">E. Image <i>(&lsquo;jpg&rsquo; files only)</i></label>
				        <input name="eimage" id="eimage" type="file" accept="image/jpeg" />
				        <span>
				        	Wallpaper size is recommended.<br>
				        	Cannot be more than 2MB.
				        </span>
				    </p>

				    <p id="submit_section">
				        <button name="upload_images" id="upload_images" type="submit" value="<?php echo $setID; ?>">UPLOAD</button>
				    </p>

				    <p>&nbsp;</p>
				    <p>&nbsp;</p>

					<h6>Set Images</h6>

					<p>
						<?php
							echo "<label>A. Image - Main Image</label>";
							if(!empty($art_aimage)) {
								echo "<a class='setimage' data-set-image='a_image' data-article-id='" . $setID . "'><img src='imgs/".$article_type."/" . $art_aimage . "'></a>";
							} else {
								echo "<span>There is no set image.</span>";
							}
						?>
					</p>

					<p>
						<?php
							echo "<label>B. Image</label>";
							if(!empty($art_bimage)) {
								echo "<a class='setimage' data-set-image='b_image' data-article-id='" . $setID . "'><img src='imgs/".$article_type."/" . $art_bimage . "'></a>";
							} else {
								echo "<span>There is no set image.</span>";
							}
						?>
					</p>

					<p>
						<?php
							echo "<label>C. Image</label>";
							if(!empty($art_cimage)) {
								echo "<a class='setimage' data-set-image='c_image' data-article-id='" . $setID . "'><img src='imgs/".$article_type."/" . $art_cimage . "'></a>";
							} else {
								echo "<span>There is no set image.</span>";
							}
						?>
					</p>

					<p>
						<?php
							echo "<label>D. Image</label>";
							if(!empty($art_dimage)) {
								echo "<a class='setimage' data-set-image='d_image' data-article-id='" . $setID . "'><img src='imgs/".$article_type."/" . $art_dimage . "'></a>";
							} else {
								echo "<span>There is no set image.</span>";
							}
						?>
					</p>

					<p>
						<?php
							echo "<label>E. Image</label>";
							if(!empty($art_eimage)) {
								echo "<a class='setimage' data-set-image='e_image' data-article-id='" . $setID . "'><img src='imgs/".$article_type."/" . $art_eimage . "'></a>";
							} else {
								echo "<span>There is no set image.</span>";
							}
						?>
					</p>
					
					<?php } ?>
					
				</form>

			</section>

		</article>

	</div>

	<?php include "footer.html"; ?>

	<script type="text/javascript">

		jQuery.validator.addMethod("maxbytes", function(value, element) {
			var elemSize = element.files[0].size;
			var megabyte = 1048576;
			var elemLimit = megabyte * 0.7;
			if(elemSize <= elemLimit) { return true; } else { return false; }
		}, "ERROR");

		jQuery.validator.addMethod("limitbytes", function(value, element) {
			var elemSize = element.files[0].size;
			var megabyte = 1048576;
			var elemLimit = megabyte * 2;
			if(elemSize <= elemLimit) { return true; } else { return false; }
		}, "ERROR");

		$.urlParam = function (url) {
			var pageAttr = new RegExp('[\?&]' + url + '=([^&#]*)').exec(window.location.href);
			if(pageAttr == null) {
				return null;
			} else {
				return pageAttr[1] || 0;
			}
		}

		$(function() {

			if($.urlParam('upload_error') == 'width') {
				$("#aimage").addClass('error');
				$("#aimage").after("<label class='error' id='filerror'>The image width was too small.</label>");
				$("#filerror").delay(5000).fadeOut('fast', function() {
					$("#aimage").removeClass('error');
				});
			} else if($.urlParam('upload_error') == 'invalid') {
				$("#aimage").addClass('error');
				$("#aimage").after("<label class='error' id='filerror'>That file was invalid.</label>");
				$("#filerror").delay(5000).fadeOut('fast', function() {
					$("#aimage").removeClass('error');
				});
			}

			$("#submitform").validate({
				rules: {
					aimage: {
						maxbytes: true,
						accept: "image/jpeg"
					},
					bimage: {
						limitbytes: true,
						accept: "image/jpeg"
					},
					cimage: {
						limitbytes: true,
						accept: "image/jpeg"
					},
					dimage: {
						limitbytes: true,
						accept: "image/jpeg"
					},
					eimage: {
						limitbytes: true,
						accept: "image/jpeg"
					}
				},
				messages: {
					aimage: {
						maxbytes: "Use an image that is less than 700KB.",
						accept: "Only &lsquo;jpg&rsquo; files are accepted."
					},
					bimage: {
						limitbytes: "Use an image that is less than 2 megabytes.",
						accept: "Only &lsquo;jpg&rsquo; files are accepted."
					},
					cimage: {
						limitbytes: "Use an image that is less than 2 megabytes.",
						accept: "Only &lsquo;jpg&rsquo; files are accepted."
					},
					dimage: {
						limitbytes: "Use an image that is less than 2 megabytes.",
						accept: "Only &lsquo;jpg&rsquo; files are accepted."
					},
					eimage: {
						limitbytes: "Use an image that is less than 2 megabytes.",
						accept: "Only &lsquo;jpg&rsquo; files are accepted."
					}
				}
			});
		});
	</script>

</body>
</html>