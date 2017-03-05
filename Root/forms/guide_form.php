<form class="grid_18 grid_0 submitform" id="submitguide" method="get" action="" enctype="multipart/form-data">
	<h6>Article Submission</h6>

	<?php if(has_perms("articlelist-finalise")){?>
		<p class="scroll_section" id="submitas_section">
			<label for="articlesubmitas">Submit As</label>
			<select id="articlesubmitas" name="articlesubmitas">
				<?php
				$sasQRY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE rank!=0 ORDER BY id");

				while($submitasQRY = mysqli_fetch_assoc($sasQRY)) {
					$submitas_id			= $submitasQRY['id'];
					$submitas_username 		= $submitasQRY['username'];
					$submitas_firstname		= $submitasQRY['firstname'];
					$submitas_lastname		= $submitasQRY['lastname'];
					$submitas_fullname		= $submitas_firstname . " " . $submitas_lastname;


					if($submitas_id==$check_id){
						echo '<option value="'.$submitas_username.'" selected>'.$submitas_fullname.'</option>';
					}
					else{
						echo '<option value="'.$submitas_username.'">'.$submitas_fullname.'</option>';
					}

				}
				?>
			</select>
		</p>
	<?php } ?>

	<p class="scroll_section" id="type_section">
		<label for="articletype">Article Type</label>
		<select id="articletype" name="articletype">
			<?php	echo $new_article_types;	?>
		</select>
	</p>

	<p class="scroll_section" id="gamename_section">
		<label for="gamename">Game Title</label>
		<?php include 'gamename_input.php'; ?>
	</p>

	<p class="scroll_section" id="articleguidetitle_section">
		<label for="articleguidetitle">Title</label>
		<input name="articleguidetitle" class="form_box_right" style="margin-right: 241px;width: 345px;" type="text" value="" id="articleguidetitle" type="text" value="" placeholder="Enter your article's title here..." required />
	</p>

	<p class="scroll_section" id="intro_section">
		<label for="intro">Introduction</label>
		<textarea name="intro" id="intro" placeholder="Introduction..." required></textarea>
	</p>

	<p class="scroll_section" id="article_checklist_section">
		<label for="article_checklist">Checklist</label>
		<span style="font-size:14px;"><input type="checkbox" name="article_checklist" id="article_checklist" value="false" />&laquo; Tick this to add a checklist.</span>
						<span id="checklist_input">
						<label for="checklist_add">Add Item</label>
						<input type="number" name="checklist_quan" id="checklist_quan" placeholder="Quantity"/><input type="text" name="checklist_add" id="checklist_add" placeholder="Item Name"/><button id="checklist_add_btn">ADD ITEM</button>
						</span>
		<textarea name="guide_checklist" id="guide_checklist" style="display:none;"></textarea>
	</p>
					<span>
					<ul id="checklist_display"></ul>
					</span>

	<p class="scroll_section" id="step_section">
					<span id="step_wrapper">
					<span><label for="step_1">Step 1</label><textarea id="step_1" name="step[]" placeholder="Step 1..." required></textarea></span>
					</span>
		<button class="add_step_button" style="margin:auto;">Add Step</button>
	</p>

	<p class="scroll_section" id="tags_section">
		<label for="tags">Article Tags - Relavent Keywords</label>
		<input name="tags" id="tags" type="text" value="" placeholder="Type tags in here..." required />
	</p>

	<p id="submit_section">
		<button name="submit" id="submit" type="submit" value="<?php echo $user; ?>">SUBMIT FORM</button>
	</p>
</form>

<ul class="grid_6 grid_0" id="checklist">
	<h6>Checklist</h6>
	<li class="check_btn complete" id="articletype_button">TYPE</li>
	<li class="check_btn" id="articleguidetitle_button">TITLE</li>
	<li class="check_btn" id="intro_button">INTRODUCTION</li>
	<li class="check_btn" id="step_button">STEPS</li>
	<li class="check_btn" id="tags_button">TAGS</li>
</ul>

<script>
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
		$("#checklist_display li").each(function(){
			checklisthtml += '<li>';
			checklisthtml += $(this).html().replace(' - <a href="#" class="remove_item">remove</a>', '');
			checklisthtml += '</li>';
		});
		checklisthtml += '</ul>';
		$("#guide_checklist").val(checklisthtml);
	}

	$(function(){
		$("#article_checklist").change(function(){
			if ($('#article_checklist').is(":checked"))
			{
				$(this).val("true");
				$("#checklist_input").slideDown("fast");
			}
			else{
				$(this).val("false");
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
				$("#checklist_display").append('<li>'+quanval+' x '+itemval+' - <a href="#" class="remove_item">remove</a></li>');
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

		var x = 1;
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
		});

		$(wrapper).on("click",".remove_step", function(e){
			e.preventDefault(); $(this).parent('span').slideUp("fast", function(){$(this).remove();sortsteps();}); x--;
		});

	});
</script>