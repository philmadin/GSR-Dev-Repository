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

if(!has_perms("dashboard")){
    header("Location: index.php");
}

if(has_perms("dashboard-announcement")) {
    if(isset($_POST['announcement'])){
        $update_msg = mysqli_real_escape_string($con, $_POST['announcement']);
        $msg_query = "INSERT INTO tbl_dashboard_msg (message, username) 
		VALUES ('$update_msg', '$user')";
        if (!mysqli_query($con, $msg_query)) {
            die("Error: " . $msg_query . "<br>" . mysqli_error($con));
        }
        if(isset($_POST['dashboard_chat'])){
            die("Announcement has been updated! Reload page to see the new one.");
        }
    }
}

?>

<!doctype html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, follow, noarchive">

    <title>Dashboard | Staff Announcements | GSR</title>

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

            </div>
        </section>

    </article>

</div>

<?php include "footer.html"; ?>
<script>
    $(function(){
        openGame();
    });

    function openGame(){
        $.magnificPopup.open({
            items: {
                src: 'minigame/1/'
            },
            type: 'iframe'
        });
    }
</script>

</body>
</html>