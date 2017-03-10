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

	$articleQRY = mysqli_query($con, "SELECT * FROM tbl_guide WHERE id = '$getArticle'");

	while ($artROW = mysqli_fetch_assoc($articleQRY)) {
		$articletype 	 	= $artROW['article_type'];
		$title 			 	= $artROW['title'];
		$file_intro			= $artROW['intro'];
		$step_files		 	= $artROW['steps'];
		$step_file_list 	= unserialize($step_files);
		$checklist 			= $artROW['checklist'];
		$num_steps 			= $artROW['step_count'];
		$tags 				= $artROW['tags'];
		$author 			= $artROW['author'];
		$authuser 	    	= $artROW['authuser'];
		$pending			= $artROW['pending'];
		$beta_approval		= $artROW['beta_approval'];
		$alpha_approval		= $artROW['alpha_approval'];
	}

	$content_items = mysqli_query($con, "SELECT * FROM tbl_guide_content WHERE articleidFK = '$getArticle'");
	
	
global $authuser;
if (!has_perms("edit-article-override")) {
if($user!=$authuser) {
		header("Location: articlelist.php");
	}
}

	$intro = file_get_contents($file_intro);

if($checklist!=""){$isChecked="checked";}
if($checklist==""){$isChecked="";}
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
				            <option value="Guide" selected>Guide</option>
				        </select>
				    </p>

				    <p class="scroll_section" id="articleguidetitle_section">
				    	<label for="articleguidetitle">Title</label>
				        <input name="articleguidetitle" id="articleguidetitle" type="text" value="<?php echo $title;?>" placeholder="<?php echo $title;?>" required />
				    </p>
					
				    <p class="scroll_section" id="intro_section">
				    	<label for="intro">Introduction</label>
				        <textarea name="intro" id="intro"><?php echo mysqli_fetch_row($content_items)[2];?></textarea>
				    </p>
					
					<p class="scroll_section" id="article_checklist_section">
						<label for="article_checklist">Checklist</label>
						<span style="font-size:14px;"><input type="checkbox" name="article_checklist" id="article_checklist" <?php echo $isChecked;?>/>&laquo; Tick this to add a checklist.</span>
						<span id="checklist_input">
						<label for="checklist_add">Add Item</label>
						<input type="number" name="checklist_quan" id="checklist_quan" placeholder="Quantity"/><input type="text" name="checklist_add" id="checklist_add" placeholder="Item Name"/><button id="checklist_add_btn">ADD ITEM</button>
						</span>
						<textarea name="guide_checklist" id="guide_checklist" style="display:none;"><?php echo $checklist;?></textarea>
					</p>
					<span id="checklist_display">
					<?php if($isChecked=="checked"){echo str_replace("</li>", ' - <a href="#" class="remove_item">remove</a></li>', $checklist);}else{echo '<ul></ul>';}?>
					</span>
					
					<p class="scroll_section" id="step_section">
					<span id="step_wrapper">
					<?php
					$step_num = 0;
					while ($content_item = mysqli_fetch_array($content_items)) {
					$step_num++;
					$step_text = $content_item;
					?>
					<span>
					<label for="step_<?php echo $step_num;?>">Step <?php echo $step_num;?></label>
					<textarea id="step_<?php echo $step_num;?>" name="step[]" placeholder="<?php echo $step_text;?>" required><?php echo $content_item[2];?></textarea>
					<?php
					if($step_num>1){
					echo '<a href="#" class="remove_step">Remove</a>';
					}
					?>
					</span>
					<?php
					}
					?>
					</span>
					<button class="add_step_button" style="margin:auto;">Add Step</button>
					</p>

				    <p class="scroll_section" id="tags_section">
				    	<label for="tags">Article Tags - Relavent Keywords</label>
				        <input name="tags" id="tags" type="text" value="<?php echo $tags;?>" placeholder="<?php echo $tags;?>" required />
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

		jQuery.validator.addMethod("hasletters", function(value, element) {
			if(value.match(/([a-zA-Z])/)) { return false; } else { return true; }
		}, "ERROR");

		$(function() {
            $("#intro").jqte({
                formats: [
                    ["h3","Header 3"],
                    ["h4","Header 4"],
                    ["h5","Header 5"],
                    ["h6","Header 6"],
                    ["pre","Preformatted"]
                ]
            });

			$("#tags").tagit({ fieldName: "tags", removeConfirmation: false, caseSensitive: true, allowDuplicates: false, allowSpaces: false, readOnly: false, tagLimit: null, singleField: false, singleFieldDelimiter: ', ', singleFieldNode: null, tabIndex: null, placeholderText: "Type tags in here...", beforeTagAdded: function(event, ui) { }, afterTagAdded: function(event, ui) { }, beforeTagRemoved: function(event, ui) { }, onTagExists: function(event, ui) { }, onTagClicked: function(event, ui) { }, onTagLimitExceeded: function(event, ui) { } });

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
			        url : "submitguide.php?deletionid=" + $(this).val(),
			        type : "GET",
			        dataType: "html",
			        async : false,
			        success: function(data) {
			            document.location = "articlelist.php?type=guide";
			        }
			    });
			});

			$("#deny").on('click', function(event) {
				$.ajax({
			        url : "submitguide.php?deny=" + $(this).val(),
			        type : "GET",
			        dataType: "html",
			        async : false,
			        success: function(data) {
			            document.location = "articlelist.php?type=guide";
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
			            url : "submitguide.php",
			            data : gsrSUBMIT,
			            type : "POST",
			            dataType: "html",
			            async : false,
			            success: function(data) {
							//alert(data);return false;
			            	 document.location = "articlelist.php?type=guide";
			            }
			        });
				}
			});
		});
		
		
		
		
		
						function htmlappend(x){
					return '<label for="step_'+x+'">Step '+x+'</label><textarea id="step_'+x+'" name="step[]" placeholder="Step '+x+'..."></textarea><a href="#" class="remove_step">Remove</a>';
				}
				
				function sortsteps(){
				var eachnum = 0;
				$("#step_wrapper span").each(function(){
				eachnum++;
				$(this).find("label").attr("for", "step_"+eachnum).html("Step "+eachnum);
				$(this).find("textarea").attr("id", "step_"+eachnum).attr("placeholder", "Step "+eachnum+"...");
				});
				}
				
				function updatechecklist(){
					var checklisthtml = '<ul>';
					$("#checklist_display ul li").each(function(){
					checklisthtml += '<li>';
					checklisthtml += $(this).html().replace(' - <a href="#" class="remove_item">remove</a>', '');
					checklisthtml += '</li>';
					});
					checklisthtml += '</ul>';
					$("#guide_checklist").val(checklisthtml);
				}
				
				$(function(){					
				
				$("#checklist_display ul li .remove_item").click(function(e){
				e.preventDefault(); $(this).parent('li').slideUp("fast", function(){$(this).remove();updatechecklist();});
				});
				
				$("#article_checklist").change(function(){
				if ($('#article_checklist').is(":checked"))
				{
				$("#checklist_input").slideDown("fast");
				}
				else{
				$("#checklist_input").slideUp("fast");
				}
				});
				$("#checklist_input").hide();
				$("#checklist_add_btn").click(function(e){
					e.preventDefault();
					var itemval = $("#checklist_add").val();
					var quanval = $("#checklist_quan").val();
					if( itemval=="" ){
						alert("Please enter an item.");
						return false;
					}
					if( quanval=="" || parseInt(quanval)<1 ){
						alert("Please enter a quantity for the item.");
						return false;
					}
					else{
						$("#checklist_display ul").append('<li>'+quanval+' x '+itemval+' - <a href="#" class="remove_item">remove</a></li>');
						$("#checklist_add").val("");
						$("#checklist_quan").val("");
						$("#checklist_display").on("click",".remove_item", function(e){
					e.preventDefault(); $(this).parent('li').slideUp("fast", function(){$(this).remove();updatechecklist();});
				});
				updatechecklist();
					}
				});
				
				var max_fields      = 40;
				var wrapper         = $("#step_wrapper");
				var add_button      = $(".add_step_button");
				var x = <?php echo $num_steps;?>;
                    console.log(x+" Steps");
				$(add_button).click(function(e){
					e.preventDefault();
					if(x < max_fields){
						x++;
						$(wrapper).append('<span class="temp_step" style="display:none;">'+htmlappend(x)+'</span>');
						$(".temp_step").slideDown("fast", function(){
						$(this).removeClass(".temp_step");
						});
								sortsteps();
					}
					else{
						alert("Sorry you may not have any more steps, the maximum is "+max_fields+".");
					}
                    console.log(x+" Steps");
				});
				
				$(wrapper).on("click",".remove_step", function(e){
					e.preventDefault(); $(this).parent('span').slideUp("fast", function(){$(this).remove();sortsteps();}); x--;
				});
				if ($('#article_checklist').is(":checked"))
				{
				$("#checklist_input").slideDown("fast");
				}
				else{
				$("#checklist_input").slideUp("fast");
				}
			});
		
		
		
	</script>

</body>
</html>