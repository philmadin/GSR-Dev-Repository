<?php
	include "mysql_con.php";

	$user = $_SESSION['username'];

	if(!isset($user)) { header("location:index.php"); }

	$accountQRY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$user'");

	while($infoQRY = mysqli_fetch_assoc($accountQRY)) {
		$check_id  			= $infoQRY['id'];
		$check_firstname	= $infoQRY['firstname'];
		$check_lastname		= $infoQRY['lastname'];
		$check_fullname		= $check_firstname . " " . $check_lastname;
	}

		if(!has_perms("my-articles")){
			header("Location: index.php");
		}
	
						$article_types = '
							<option disabled>--SELECT A TYPE--</option>
				            <option value="Review">Review</option>
				            <option value="Opinion">Opinion Piece</option>
				            <option value="News">News Article</option>
				            <option value="Guide">Guide/Walkthrough</option>
						';
						
						$new_article_types = str_replace('<option value="'.$_GET['type'].'"', '<option value="'.$_GET['type'].'" selected' , $article_types);
?>

<!doctype html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, follow, noarchive">

<title>Submit An Article | Article Submission | GSR</title>

<meta name="description" content="Create and submit your article here to be reviewed by your peers before published.">

<?php include "links.php"; ?>

</head>

<body>
<script>
function expandReviewSection(id) {
	var textarea = document.getElementById(id);
	var header = id.substring(0, id.length-6)+"header";
	var toggle_id = id.substring(0, id.length-6)+"toggle";
	var id = id.substring(0, id.length-6)+"section"
	var toggle_icon = document.getElementById(toggle_id)
	var header = document.getElementById(header)
	var section = document.getElementById(id)
	console.log(textarea)
	if (section.style.display == 'block') {
		toggle_icon.innerHTML = "+";
		section.style.display = 'none';
		header.style.marginBottom = '10px';
	} else {
		toggle_icon.innerHTML = "-";
		section.style.display = 'block';
		header.style.marginBottom = '0px';
	}
}

</script>
	<?php include "header.php"; ?>

	<div id="page" class="container_24">

		<article>

			<section id="articlesubmit">

				<?php
				if($_GET['type']=="Review"){include_once 'forms/review_form.php';}
				else if($_GET['type']=="Opinion"){include_once 'forms/opinion_form.php';}
				else if($_GET['type']=="News"){include_once 'forms/news_form.php';}
				else if($_GET['type']=="Guide"){include_once 'forms/guide_form.php';}
				?>

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

			//popup("ATTENTION!", "<h3>Warning to all submitters</h3>If you are copying and pasting from another source (i.e word document) click this button<br /><img src='imgs/article_cp.png'/>");

            $("#submitreview textarea:not(#summary), #submitopinion textarea, #submitnews textarea, #submitguide #intro").jqte({
                formats: [
                ["h3","Header 3"],
                ["h4","Header 4"],
                ["h5","Header 5"],
                ["h6","Header 6"],
                ["pre","Preformatted"]
            ]
            });

			if(window.File && window.FileReader && window.FileList && window.Blob) { } else {
				alert("NOTICE: Please upgrade your browser! Latest HTML5 features are needed for this page to function correctly.");
			}
			
			$("#articletype").change(function(){
			document.location="submit.php?type="+$(this).val();
			});

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

			$("#summary").on('keyup', function(event) {
				var maxChars = 100;
				var curChars = $(this).val().length;

				if(curChars == maxChars) {
					$("#charCount").text("You've reached the character limit.");
				} else if(curChars >= maxChars) {
					$("#charCount").text("You've exceeded the character limit by " + (curChars - maxChars) + " characters.");
				} else {
					$("#charCount").text((maxChars - curChars) + " Characters left.");
				}
			});

			$("#storylinerating, #gameplayrating, #audiorating, #graphicsrating").on('keyup', function(event) {
				var s_rating = $("#storylinerating").val() == "" ? 0.0 : parseFloat($("#storylinerating").val());
				var p_rating = $("#gameplayrating").val() == "" ? 0.0 : parseFloat($("#gameplayrating").val());
				var a_rating = $("#audiorating").val() == "" ? 0.0 : parseFloat($("#audiorating").val());
				var g_rating = $("#graphicsrating").val() == "" ? 0.0 : parseFloat($("#graphicsrating").val());

				var add_ratings = s_rating + p_rating + a_rating + g_rating;
				var total_rating = parseFloat(add_ratings / 4);

				$("#mainrating").val(total_rating.toFixed(1));
			});
$('.ratingcheck').change(function() { 
	updateAverage();
	var checkbox = this;
	var str = this.id;
	var no = str.substring(11,12);
	labelid = "ratinglabel"+no;
	var label = document.getElementById(labelid);
	if (checkbox.checked) {
		label.style.background = "green"
		label.style.color = "white";
		label.innerHTML = "&#10004;";
		fadeTextbox(no, "on");
	} else {
		label.style.background = "red";
		label.style.color = "black";
		label.innerHTML = "N/A";
		fadeTextbox(no, "off");
	}
});

var fadeTextbox = function(no, direction) {
	if (no==1){
		var id="storylinerating"
	} else if(no==2){
		var id="gameplayrating"
	} else if(no==3){
		var id="audiorating"
	} else if(no==4){
		var id="graphicsrating"
	}
	var textbox = document.getElementById(id);
	if (direction == "off") {
		textbox.style.background = 'gray'
	} else {
		textbox.style.background = "white"
	}
}
			$("#storylinerating, #gameplayrating, #audiorating, #graphicsrating").on('change', function(event) {
				updateAverage()
			});
			$('#checkbox').click(function(){
				updateAverage()
			});
			function updateAverage() {
				var rating1 = $("#storylinerating").val() == "" ? 0.0 : parseFloat($("#storylinerating").val());
				var rating2 = $("#gameplayrating").val() == "" ? 0.0 : parseFloat($("#gameplayrating").val());
				var rating3 = $("#audiorating").val() == "" ? 0.0 : parseFloat($("#audiorating").val());
				var rating4 = $("#graphicsrating").val() == "" ? 0.0 : parseFloat($("#graphicsrating").val());

				var add_ratings = 0;
				var num_ratings = 0;
				
				for (i=1;i<5;i++) {
				    var checkname = "ratingcheck"+i;
				    var checkbox = document.getElementById(checkname);
				    if (checkbox.checked) {
				        num_ratings+=1;
				        if(i==1){add_ratings+=rating1}else if(i==2){add_ratings+=rating2}else if(i==3){add_ratings+=rating3}else if(i==4){add_ratings+=rating4}
				    }
				}
				if (num_ratings == 0){num_ratings = 1}
				console.log("Total rating = " + add_ratings + " / " + num_ratings + " = " + add_ratings/num_ratings)
                                var total_rating = parseFloat(add_ratings / num_ratings);

				$("#mainrating").val(total_rating.toFixed(1));
                        
                        }
                    
$('.ratingcheck').change(function() { 
updateAverage();
	var checkbox = this;
	console.log(checkbox)
	var str = this.id;
	var no = str.substring(11,12);
	no = "ratinglabel"+no
	console.log(no)
	var label = document.getElementById(no)
	if (checkbox.checked) {
		console.log("Checking");
		label.style.background = "green"
	} else {
		console.log("Unchecking");
		label.style.background = "red"
	}
});

			var avaURL = "signup_availability.php";

			$("#submitreview").validate({
				rules: {
					articletitle: {
						required: true,
						remote: avaURL
					},
					gamename: {
						required: true
					},
					summary: {
						required: true,
						maxlength: 100
					},
					overview: {
						required: true
					},
					gameplay: {
						required: true
					},
					storyline: {
						required: true
					},
					audio: {
						required: true
					},
					graphics: {
						required: true
					},
					verdict: {
						required: true
					},
					trailer: {
						required: false,
						url: true
					},
					releasedate: {
						required: true,
						maxlength: 10,
						minlength: 10,
						hasletters: true
					},
					platforms: {
						required: true
					},
					genre: {
						required: true
					},
					developers: {
						required: true
					},
					publishers: {
						required: true
					},
					officialsite: {
						required: true,
						url: true
					},
					developersites: {
						required: true
					},
					publishersites: {
						required: true
					},
					storylinerating: {
						required: true
					},
					gameplayrating: {
						required: true
					},
					audiorating: {
						required: true
					},
					graphicsrating: {
						required: true
					},
					tags: {
						required: true
					}
				},
				messages: {
					articletitle: {
						required: "You must provide a unique title for your article.",
						remote: "That title is already in use."
					},
					gamename: {
						required: "Please enter the title of the game."
					},
					summary: {
						required: "Please provide a short summary for the article.",
						maxlength: "You summary cannot be more than 100 characters."
					},
					overview: {
						required: "Please provide the 'Overview' section of your review."
					},
					gameplay: {
						required: "Please provide the 'Gameplay' section of your review."
					},
					storyline: {
						required: "Please provide the 'Storyline' section of your review."
					},
					audio: {
						required: "Please provide the 'Audio' section of your review."
					},
					graphics: {
						required: "Please provide the 'Graphics' section of your review."
					},
					verdict: {
						required: "Please provide the 'Verdict' section of your review."
					},
					trailer: {
						required: "Please follow the instructions to provide a URL.",
						url: "That URL is invalid."
					},
					releasedate: {
						required: "Please provide the game&rsquo;s release date.",
						maxlength: "Please follow the given format.",
						minlength: "Please follow the given format.",
						hasletters: "No letters accepted for the release date."
					},
					platforms: {
						required: "Please provide all platforms that the game is available on."
					},
					genre: {
						required: "Please provide the genre of the game."
					},
					developers: {
						required: "Please provide all developer company names."
					},
					publishers: {
						required: "Please provide all company names of the publishers."
					},
					officialsite: {
						required: "Please enter the official site URL.",
						url: "That URL is invalid."
					},
					developersites: {
						required: "Please provide all developer companies website URL's."
					},
					publishersites: {
						required: "Please provide all publisher companies website URL's."
					},
					storylinerating: {
						required: "You must provide a storyline quality rating."
					},
					gameplayrating: {
						required: "You must provide a gameplay quality rating."
					},
					audiorating: {
						required: "You must provide a audio quality rating."
					},
					graphicsrating: {
						required: "You must provide a graphics quality rating."
					},
					tags: {
						required: "You must provide tags (relavent keywords) for your article."
					}
				},
				submitHandler: function(form) {
					var gsrSUBMIT = $(form).serialize() + "&mainrating=" + $("#mainrating").val();
			        $.ajax({
			            url : "submitreview.php",
			            data : gsrSUBMIT,
			            type : "POST",
			            dataType: "html",
			            async : false,
			            success: function(data) {
			            	document.location = "myarticlelist.php";
			            }
			        });
				}
			});

			$("#submitnews").validate({
				rules: {
					articlenewstitle: {
						required: true,
						remote: avaURL
					},
					main: {
						required: true
					},
					trailer: {
						required: false,
						url: true
					},
					tags: {
						required: true
					}
				},
				messages: {
					articlenewstitle: {
						required: "You must provide a unique title for your article.",
						remote: "That title is already in use."
					},
					main: {
						required: "Please enter the the main text."
					},
					trailer: {
						required: "Please follow the instructions to provide a URL.",
						url: "That URL is invalid."
					},
					tags: {
						required: "You must provide tags (relavent keywords) for your article."
					}
				},
				submitHandler: function(form) {
					var gsrSUBMIT = $(form).serialize();
					$.ajax({
						url : "submitnews.php",
						data : gsrSUBMIT,
						type : "POST",
						dataType: "html",
						async : false,
						success: function(data) {
							//console.log(data);return false;
							document.location = "myarticlelist.php";
						}
					});
				}
			});
			
			
					$("#submitopinion").validate({
				rules: {
					articleopiniontitle: {
						required: true,
						remote: avaURL
					},
					main: {
						required: true
					},
					tags: {
						required: true
					}
				},
				messages: {
					articleopiniontitle: {
						required: "You must provide a unique title for your article.",
						remote: "That title is already in use."
					},
					main: {
						required: "Please enter the the main text."
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
			            	document.location = "myarticlelist.php";
			            }
			        });
				}
			});
			
				$("#submitguide").validate({
				rules: {
					articleguidetitle: {
						required: true,
						remote: avaURL
					},
					intro: {
						required: true
					},
					'step[]': {
						required: false
					},
					tags: {
						required: true
					}
				},
				messages: {
					articleguidetitle: {
						required: "You must provide a unique title for your article.",
						remote: "That title is already in use."
					},
					intro: {
						required: "Please enter the the main text."
					},
					'step[]': {
						required: "You are required to have atleast 1 step."
					},
					tags: {
						required: "You must provide tags (relavent keywords) for your article."
					}
				},
				submitHandler: function(form) {
					var gsrSUBMIT = $(form).serialize();
			        $.ajax({
			            url : "submitguide.php",
			            data : gsrSUBMIT,
			            type : "POST",
			            dataType: "html",
			            async : false,
			            success: function(data) {
			            	document.location = "myarticlelist.php";
			            }
			        });
				}
			});
			
			
			
		});
	</script>

</body>
</html>