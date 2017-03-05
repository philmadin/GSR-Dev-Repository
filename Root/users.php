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

	if(!has_perms("manage-users")){
		header("Location: index.php");
	}

$ranklist = array();

$rankQRY = mysqli_query($con, "SELECT * FROM tbl_ranks");
while ($rankROW = mysqli_fetch_assoc($rankQRY)) {
	$ranklist[] = $rankROW;
}
?>

<!doctype html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, follow, noarchive">

<title>Dashboard | Manage Users | GSR</title>

<meta name="description" content="Manage all members.">

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
			
					<form action="" method="post" id="user_search">
					<input type="text" placeholder="Username or Email"/>
					<button type="submit">Search</button>
					</form>
						
					<div id="UserTableContainer" style="width: 100%;"></div>


				</div>
			</section>

		</article>

	</div>

	<?php include "footer.html"; ?>
	<script type="text/javascript">

		$(document).ready(function () {

            var ranklist = eval('(' + '<?php echo json_encode($ranklist); ?>' + ')');

		    //Prepare jTable
			$('#UserTableContainer').jtable({
                title: "Manage Users",
				paging: true,
				pageSize: 20,
				sorting: true,
				defaultSorting: 'id ASC',
				actions: {
					listAction: function (postData, jtParams) {
					return $.Deferred(function ($dfd) {
						$.ajax({
							url: 'userlist_get.php?action=list&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
							type: 'POST',
							dataType: 'json',
							data: postData,
							success: function (data) {
								$dfd.resolve(data);
								console.log(data);
							},
							error: function () {
								$dfd.reject();
							}
						});
					});
				},
					updateAction: 'userlist_get.php?action=update'
					},
				fields: {
					id: {
						key: true,
						create: false,
						title: 'ID',
						edit: false,
						list: true
					},
					fullname: {
						edit: false,
						title: 'FullName',
						width: '30%'
					},
					rank: {
						list: false,
						title: 'Rank',
						edit: true,
                        input: function (data) {
                            if(data.record) {
                                if (data.record.id == 0) {
                                    var ranks = "<select name='rank' disabled>";
                                }
                                else {
                                    var ranks = "<select name='rank'>";
                                }
                            }
                            else{
                                var ranks = "<select name='rank'>";
                            }
                            for (i = 0; i < ranklist.length; i++) {
                                if(data.record) {
                                    if (ranklist[i].id == data.record.rank) {
                                        ranks += '<option value="' + ranklist[i].id + '" selected>' + ranklist[i].name + '</option>';
                                    }
                                    else{
                                        ranks += '<option value="' + ranklist[i].id + '">' + ranklist[i].name + '</option>';
                                    }
                                }
                                else{
                                    ranks += '<option value="' + ranklist[i].id + '">' + ranklist[i].name + '</option>';
                                }
                            }
                            ranks += "</select>";
                            return ranks;
                        }
					},
					password: {
						list: false,
						title: 'Set New Password',
						edit: true,
						input: function (data) {
							return '<input name="password" value="" type="password"/>';
						}
					},
					repassword: {
						list: false,
						title: 'Confirm New Password',
						edit: true,
						input: function (data) {
							return '<input name="repassword" value="" type="password"/>';
						}
					},
					email: {
						edit: false,
						title: 'Email',
						width: '40%'
					}
					
				}
			});

			$('#UserTableContainer').jtable('load');
			
			$("#user_search").submit(function(e){
				e.preventDefault();
				if($('#user_search input').val()==""){
				$('#UserTableContainer').jtable('load');	
				}
				else{
				$('#UserTableContainer').jtable('load', {
                searchquery: $('#user_search input').val()
				});
				}
				
				
			});

		});

	</script>


</body>
</html>