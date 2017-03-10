<?php
	include "mysql_con.php";

	$user = $_SESSION['username'];

	$getArticle = $_GET['article'];

	if(!isset($user)) { header("location:index.php"); }
	if(empty($getArticle)) { header("location:index.php"); }

	$accountQRY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$user'");

	while($infoQRY = mysqli_fetch_assoc($accountQRY)) {
		$check_firstname	= $infoQRY['firstname'];
		$check_lastname		= $infoQRY['lastname'];
		$check_fullname		= $check_firstname . " " . $check_lastname;
	}

	$articleQRY = mysqli_query($con, "SELECT * FROM tbl_opinion WHERE id = '$getArticle'");

	while ($artROW = mysqli_fetch_assoc($articleQRY)) {
		$articletype 	 	= $artROW['article_type'];
		$title 			 	= $artROW['title'];
		$file_main			= $artROW['main'];
		$content			= $artROW['Content'];
		$tags 				= $artROW['tags'];
		$author 			= $artROW['author'];
		$authuser 	    	= $artROW['authuser'];
		$pending			= $artROW['pending'];
		$beta_approval		= $artROW['beta_approval'];
		$alpha_approval		= $artROW['alpha_approval'];
	}

global $authuser;
if (!has_perms("edit-article-override")) {
	if($user!=$authuser) {
		header("Location: articlelist.php");
	}
}



	$main = file_get_contents($file_main);


?>

<!doctype html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, follow, noarchive">

<title>Edit/Revise <?php echo $title . " from " . $author; ?> | Article Revision | GSR</title>

<meta name="description" content="Edit and/or revise <?php echo $title . " from " . $author; ?>.">

<?php include "links.php"; ?>

</head>

<body>

	<?php include "header.php"; ?>

	<div id="page" class="container_24">

		<article>

			<section id="articlesubmit">

				<form class="grid_18 grid_0 submitform" id="submitform" method="get" action="" enctype="multipart/form-data">
					<h6>Article Submission</h6>

				    <p class="scroll_section" id="type_section" style="display:none;">
				    	<label for="articletype">Article Type</label>
				        <select id="articletype" name="articletype">
				            <option value="Opinion" selected>Opinion</option>
				        </select>
				    </p>

				    <p class="scroll_section" id="title_section">
				    	<label for="articletitle">Title</label>
				        <input name="articletitle" id="articletitle" type="text" value="<?php echo $title; ?>" placeholder="<?php echo $title; ?>" required />
				    </p>

				    <p class="scroll_section" id="main_section">
				    	<label for="main">Main</label>
				        <textarea name="main" id="main" required><?php echo $content; ?></textarea>
				    </p>


				    <p class="scroll_section" id="tags_section">
				    	<label for="tags">Article Tags - Relavent Keywords</label>
				        <input name="tags" id="tags" type="text" value="<?php echo $tags; ?>" placeholder="<?php echo $tags; ?>" required />
				    </p>

				    <p>
				    	<label for="updatedate">Update Date <i>(NO/YES)</i></label>
				    	<input id="updatedate" name="updatedate" type="range" type="range" value="0" min="0" max="1" />
				    </p>

				    <p>
				        <button name="save" id="save" value="<?php echo $getArticle; ?>" type="submit">SAVE</button>
				    </p>

				    <?php
					    if(has_perms("articlelist-approve")) {
					    	echo '<p><button name="deny" id="deny" value="' . $getArticle . '" type="button">SEND BACK</button></p>';
					    }
				    ?>

				    <p>
				        <button name="delete" id="delete" value="<?php echo $getArticle; ?>" type="button">DELETE</button>
				    </p>

				    <p id="confirmation_section">
				        <button name="confirm" id="confirm" value="<?php echo $getArticle; ?>" type="button">CONFIRM REMOVAL</button>
				    </p>
				</form>


			</section>

		</article>

	</div>

	<?php include "footer.html"; ?>

	<script type="text/javascript">

		$("#tags").tagit({ fieldName: "tags", removeConfirmation: false, caseSensitive: true, allowDuplicates: false, allowSpaces: false, readOnly: false, tagLimit: null, singleField: false, singleFieldDelimiter: ', ', singleFieldNode: null, tabIndex: null, placeholderText: "Type tags in here...", beforeTagAdded: function(event, ui) { }, afterTagAdded: function(event, ui) { }, beforeTagRemoved: function(event, ui) { }, onTagExists: function(event, ui) { }, onTagClicked: function(event, ui) { }, onTagLimitExceeded: function(event, ui) { } });

		jQuery.validator.addMethod("hasletters", function(value, element) {
			if(value.match(/([a-zA-Z])/)) { return false; } else { return true; }
		}, "ERROR");

		$(function() {
            $("textarea").jqte({
                formats: [
                    ["h3","Header 3"],
                    ["h4","Header 4"],
                    ["h5","Header 5"],
                    ["h6","Header 6"],
                    ["pre","Preformatted"]
                ]
            });

			$("#confirmation_section").hide();

			if(window.File && window.FileReader && window.FileList && window.Blob) { } else {
				alert("NOTICE: Please upgrade your browser! Latest HTML5 features are needed for this page to function correctly.");
			}

			$(".check_btn").each(function() {
				var btnID = $(this).attr("id").replace("_button","");

				$(this).click(function() {
					$("html, body").animate({
						scrollTop : ($("#" + btnID + "_section").offset().top - 80)
					}, 1000);

					$(".scroll_section").removeClass('highlight');
					$("#" + btnID + "_section").addClass("highlight");
				});
			});

			$("input, textarea, select").on('change, ready, keyup', function(event) {
				var getBTN = $(this).attr("id") + "_button";

				if($(this).val() != "") {
					$(this).parent().removeClass('highlight');
					$("#" + getBTN).addClass("complete");
				} else {
					$(this).parent().addClass('highlight');
					$("#" + getBTN).removeClass("complete");
				}
			});

			var avaURL = "signup_availability.php";

			$("#delete").on('click', function(event) {
				$("#confirmation_section").show();
			});

			$("#confirm").on('click', function(event) {
				$.ajax({
			        url : "submitopinion.php?deletionid=" + $(this).val(),
			        type : "GET",
			        dataType: "html",
			        async : false,
			        success: function(data) {
			            document.location = "articlelist.php?type=opinion";
			        }
			    });
			});

			$("#deny").on('click', function(event) {
				$.ajax({
			        url : "submitopinion.php?deny=" + $(this).val(),
			        type : "GET",
			        dataType: "html",
			        async : false,
			        success: function(data) {
			            document.location = "articlelist.php?type=opinion";
			        }
			    });
			});

			$("#submitform").validate({
				rules: {
					main: {
						required: true
					},
					tags: {
						required: true
					}
				},
				messages: {
					main: {
						required: "Please provide the 'Main' section of your review."
					},
					tags: {
						required: "You must provide tags (relavent keywords) for your article."
					}
				},
				submitHandler: function(form) {
					var gsrSUBMIT = $(form).serialize();
			        $.ajax({
			            url : "submitopinion.php",
			            data : gsrSUBMIT,
			            type : "POST",
			            dataType: "html",
			            async : false,
			            success: function(data) {
							//alert(data);return false;
			            	 document.location = "articlelist.php?type=opinion";
			            }
			        });
				}
			});
		});
	</script>

</body>
</html>