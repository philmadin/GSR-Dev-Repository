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

	//if(!has_perms("my-articles")){
	//	header("Location: dashboard.php");
	//}
	
	
	
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
				
					<div id="MyArticleTableContainer" style="width: 100%;"></div>


				</div>
			</section>

		</article>

	</div>

	<?php include "footer.html"; ?>
	<script type="text/javascript">
		$(document).ready(function () {
		    //Prepare jTable
			$('#MyArticleTableContainer').jtable({
				paging: true,
				pageSize: 25,
				sorting: true,
				defaultSorting: 'id DESC',
				actions: {
					listAction: 'myarticlelist_get.php?action=list'
					},
				fields: {
					id: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					modify: {
					sorting: false,
					width: '5%',
					display: function (data) {
					return '<a class="article-edit" title="Edit Article" href="edit'+data.record.article_type.toLowerCase()+'.php?article='+data.record.id+'"></a>';
					}
					},
					images: {
					sorting: false,
					width: '5%',
					display: function (data) {
					return '<a class="img-change" title="Change Images" href="articleimages.php?article_images='+data.record.id+'&type='+data.record.article_type.toLowerCase()+'"></a>';
					}
					},
					article_type: {
						title: 'Type'
					},
					title: {
						title: 'Title',
						width: '40%'
					},
					author: {
						title: 'Author',
						width: '20%'
					},
					createdate: {
						title: 'Date',
						width: '15%',
						type: 'date',
						create: false,
						edit: false
					},
					status: {
					title: "Status",
					sorting: false,
					width: '5%',
					display: function (data) {
					if(data.record.pending=="false" && data.record.beta_approved=="false" && data.record.alpha_approved=="false"){return '<b style="color:#E73030;">Pending</b>';} //TO be submitted
					if(data.record.pending=="true" && data.record.beta_approved=="false" && data.record.alpha_approved=="false"){return '<b style="color:#E88F00;">CD to edit</b>';} //CD edits and submits
					if(data.record.pending=="true" && data.record.beta_approved=="true" && data.record.alpha_approved=="false"){return '<b style="color:#00B3FF;">CEO to edit</b>';} //CEO & Dev edits and submits
					if(data.record.pending=="true" && data.record.beta_approved=="true" && data.record.alpha_approved=="true"){return '<b style="color:#51D624;">Published</b>';} //PUBLISHED
					}
					},
					action: {
					sorting: false,
					width: '5%',
					display: function (data) {
					if(data.record.pending=="false" && data.record.beta_approved=="false" && data.record.alpha_approved=="false"){return '<button class="jtable-action-button" onclick="confirmsub('+data.record.id+', '+"'"+data.record.article_type+"'"+');">Submit</button>';} //TO be submitted
					}
					}
			}

				

		});
		reloadTable();
		});
		
					function reloadTable(){
							$('#MyArticleTableContainer').jtable('load', {
							});
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
	</script>

</body>
</html>