<?php
	include "mysql_con.php";

	$user = $_SESSION['username'];

	if(!isset($user)) { header("location:index.php"); }

	$accountQRY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$user'");

	while($SAQRY = mysqli_fetch_assoc($accountQRY)) {
		$acc_firstname	= $SAQRY['firstname'];
		$acc_lastname	= $SAQRY['lastname'];
		$acc_fullname	= $acc_firstname . " " . $acc_lastname;
		$acc_posa		= $SAQRY['posa'];
		$acc_posb		= $SAQRY['posb'];
		$acc_position	= $acc_posa . " " . $acc_posb;
	}

if(!has_perms("manage-articles")){
	header("Location: index.php");
}
	
	
	$type_ar = array(
	"review",
	"opinion",
	"news",
	"guide"
	);
	
	
if (in_array($_GET['type'], $type_ar))
  {
  $get_type = $_GET['type'];
  }
  else{
	$get_type="review";
  }	
	
?>

<!doctype html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, follow, noarchive">

<title>Dashboard | Manage Articles | GSR</title>

<meta name="description" content="Modify and adjust articles and uploaded images.">

<?php include "links.php"; ?>

</head>

<body>

	<?php include "header.php"; ?>

	<div id="page" class="container_24">

		<article>

			<section id="articlelist">
			
			<?php include 'dashboard-nav.php';?>
			
			<div id="db-main">
			
		<?php include 'dashboard-msg.php';?>
			
		<select name="type_select" id="type_select">
		<?php
		$article_types = "
		<option value='review'>Reviews</option>
		<option value='opinion'>Opinion Pieces</option>
		<option value='news'>News Articles</option>
		<option value='guide'>Guides/Walkthroughs</option>
		";
		$new_article_types = str_replace("<option value='".$get_type."'>", "<option value='".$get_type."' selected>", $article_types);
		echo $new_article_types;
		?>
		</select>
		
				
					<div id="ArticleTableContainer" style="width: 100%;"></div>


				</div>
			</section>

		</article>

	</div>

	<?php include "footer.html"; ?>
	<script type="text/javascript">
	var get_type = '<?php echo $get_type;?>';
		$(function () {
			$("#type_select").change(function(){
			reloadTable();
			});
		    //Prepare jTable
			$('#ArticleTableContainer').jtable({
				paging: true,
				pageSize: 25,
				sorting: true,
				defaultSorting: 'id DESC',
				actions: {
					listAction: 'articlelist_get.php?action=list'
					},
				fields: {
					id: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					authuser: {
						create: false,
						edit: false,
						list: false
					},
					modify: {
					sorting: false,
					width: '5%',
					display: function (data) {
						<?php
						if(has_perms("edit-article-override")){
							echo "var hasperms = true;";
						}
						else{
							echo "var hasperms = false;";
						}
						?>
						if(data.record.authuser=='<?php echo $user;?>' || hasperms==true) {
							return '<a class="article-edit" title="Edit Article" href="edit' + data.record.article_type.toLowerCase() + '.php?article=' + data.record.id + '"></a>';
						}
					}
					},
					images: {
					sorting: false,
					width: '5%',
					display: function (data) {
					return '<a class="img-change" title="Change Images" href="articleimages.php?article_images='+data.record.id+'&type='+data.record.article_type.toLowerCase()+'"></a>';
					}
					},
					title: {
						title: 'Title',
						width: '45%'
					},
					author: {
						title: 'Author',
						width: '20%'
					},
					<?php if(has_perms("articlelist-editorschoice")) { ?>
					editorschoice: {
						title: 'EditorsChoice',
						width: '5%',
						sorting: false,
						display: function (data) {
                            console.log(data.record.featured);
							if(data.record.pending=="true" && data.record.beta_approved=="true" && data.record.alpha_approved=="true"){
							if(data.record.featured=="1"){
							var choiceButton = '<center>' +
								'<button class="jtable-choice-button-active">1</button>'+
							'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 2);">2</button>'+
							'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 3);">3</button>'+
							'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 4);">4</button>'+
							'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 5);">5</button></center>';
							}
							if(data.record.featured=="2"){
							var choiceButton = '<center>' +
								'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 1);">1</button>'+
							'<button class="jtable-choice-button-active">2</button>'+
							'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 3);">3</button>'+
							'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 4);">4</button>'+
							'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 5);">5</button></center>';
							}
							if(data.record.featured=="3"){
							var choiceButton = '<center>' +
								'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 1);">1</button>'+
							'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 2);">2</button>'+
							'<button class="jtable-choice-button-active">3</button>'+
							'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 4);">4</button>'+
							'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 5);">5</button></center>';
							}
							if(data.record.featured=="4"){
							var choiceButton = '<center>' +
								'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 1);">1</button>'+
							'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 2);">2</button>'+
							'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 3);">3</button>'+
							'<button class="jtable-choice-button-active">4</button>'+
							'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 5);">5</button></center>';
							}
							if(data.record.featured=="5"){
							var choiceButton = '<center>' +
								'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 1);">1</button>'+
							'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 2);">2</button>'+
							'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 3);">3</button>'+
							'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 4);">4</button>'+
							'<button class="jtable-choice-button-active">5</button></center>';
							}
							else if(data.record.featured!="1" && data.record.featured!="2" && data.record.featured!="3" && data.record.featured!="4" && data.record.featured!="5"){
							var choiceButton = '<center><button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 1);">1</button>'+
							'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 2);">2</button>'+
							'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 3);">3</button>'+
							'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 4);">4</button>'+
							'<button class="jtable-choice-button" onclick="editorschoice('+data.record.id+', '+"'"+data.record.article_type+"'"+', 5);">5</button></center>';
							}
							
							return choiceButton;
							}
						}
					},
						<?php } ?>
					status: {
					title: "Status",
					sorting: false,
					width: '15%',
					display: function (data) {
					if(data.record.pending=="true" && data.record.beta_approved=="false" && data.record.alpha_approved=="false"){return '<b style="color:#E88F00;">CD to edit</b>';} //CD edits and submits
					if(data.record.pending=="true" && data.record.beta_approved=="true" && data.record.alpha_approved=="false"){return '<b style="color:#00B3FF;">CEO to edit</b>';} //CEO & Dev edits and submits
					if(data.record.pending=="true" && data.record.beta_approved=="true" && data.record.alpha_approved=="true"){return '<b style="color:#51D624;">Published</b>';} //PUBLISHED
					}
					}<?php if(has_perms("articlelist-approve")) { ?>,
					action: {
					sorting: false,
					width: '5%',
					display: function (data) {
					if(data.record.pending=="true" && data.record.beta_approved=="false" && data.record.alpha_approved=="false"){return '<button class="jtable-action-button" onclick="approvebeta('+data.record.id+', '+"'"+data.record.article_type+"'"+');">Approve</button>';}
					<?php if(has_perms("articlelist-finalise")){ ?>
					if(data.record.pending=="true" && data.record.beta_approved=="true" && data.record.alpha_approved=="false"){return '<button class="jtable-action-button" onclick="approvealpha('+data.record.id+', '+"'"+data.record.article_type+"'"+');">Finalise</button>';}
					<?php } ?>
					}
					}
					<?php } ?>
				}
			});

			reloadTable();

		});
		
		
							function reloadTable(){
							$('#ArticleTableContainer').jtable('load', {
							articletype: $('#type_select').val()
							});
								changeUrlParam("type", $('#type_select').val());
					}
		
		
					function confirmsub(id, article_type){					
					$.ajax({
				        url : "submit"+ article_type.toLowerCase() +".php?pending=" + id,
				        type : "GET",
			            dataType: "html",
				        async : false,
				        success: function() {
				           reloadTable();
				        }
				    });
					}		
		
					function approvealpha(id, article_type){					
					$.ajax({
				        url : "submit"+ article_type.toLowerCase() +".php?alpha=" + id,
				        type : "GET",
			            dataType: "html",
				        async : false,
				        success: function() {
				            reloadTable();
				        }
				    });
					}		
		
					function approvebeta(id, article_type){					
					$.ajax({
				        url : "submit"+ article_type.toLowerCase() +".php?beta=" + id,
				        type : "GET",
			            dataType: "html",
				        async : false,
				        success: function() {
				            reloadTable();
				        }
				    });
					}		
		
					function editorschoice(id, article_type, choice){					
					$.ajax({
				        url : "submit"+ article_type.toLowerCase() +".php?choice="+choice+"&id=" + id,
				        type : "GET",
			            dataType: "html",
				        async : false,
				        success: function() {
				            reloadTable();
				        }
				    });
					}

	</script>
			
			



</body>
</html>