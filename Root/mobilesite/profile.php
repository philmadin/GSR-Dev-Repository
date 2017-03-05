<?php
include "mysql_con.php";

$getprofilename = mysqli_real_escape_string($con, $_GET['profilename']);

$proQRYA = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$getprofilename'");
$proQRYB = mysqli_query($con, "SELECT * FROM tbl_companies WHERE username = '$getprofilename'");

if(mysqli_num_rows($proQRYA) < 1 && mysqli_num_rows($proQRYB) < 1){
    header("Location: index.php");
}
else{
    if(mysqli_num_rows($proQRYA) < 1) {
        $profileQRY = $proQRYB;
    } else {
        $profileQRY = $proQRYA;
    }
}


while ($prof = mysqli_fetch_assoc($profileQRY)) {
    $pr_id			= $prof['id'];
    $pr_username	= $prof['username'];
    $pr_firstname	= $prof['firstname'];
    $pr_lastname	= $prof['lastname'];
    $showName		= $prof['showname'];
    $pr_xbox		= $prof['xbox'];
    $pr_playstation	= $prof['playstation'];
    $pr_steam		= $prof['steam'];
    $pr_console		= $prof['console'];
    $pr_game		= $prof['game'];
    $pr_quote		= $prof['quote'];
    $pr_bio			= $prof['biography'];
    $pr_rank		= $prof['rank'];
    $pr_since		= strtotime($prof['since']);
    $pr_town		= $prof['town'];
    $pr_country		= $prof['country'];
    $pr_website		= $prof['website'];
    $pr_faceboook	= $prof['facebook'];
    $pr_twitter		= $prof['twitter'];
    $pr_googleplus	= $prof['googleplus'];
    $pr_level		= $prof['level'];
    $pr_picture		= $prof['picture'];
    $pr_badges		= $prof['badges'];
    $pr_favs		= $prof['favourites'];
    $pr_friends		= $prof['friends'];
    $pr_clan		= $prof['clan'];
    $pr_clantime	= $prof['clantime'];

    $pr_cotype		= $prof['cotype'];
}

$bQUERY = mysqli_query($con, "SELECT * FROM tbl_ranks WHERE id = $pr_rank");
while($bROW = mysqli_fetch_assoc($bQUERY)) {
    $pr_position = $bROW['name'];
}

$profileGSQRY = mysqli_query($con, "SELECT * FROM tbl_users WHERE username = '$getprofilename'");

while ($profGS = mysqli_fetch_assoc($profileGSQRY)) {
    $pr_online = $profGS['online'];
}

if($pr_picture == NULL || $pr_picture == "" || empty($pr_picture)) {
    $pr_image = "default";
} else {
    $pr_image = $pr_picture;
}

include "timecal.php";

if ($pr_since == strtotime("2014-01-01 00:00:00")) {
    $pr_date = "Co-founded";
} else {
    $pr_date = humanTiming($pr_since) . " with";
}

if($pr_online != 'ONLINE') {
    $onlinestring = strtotime($pr_online);
    $statusOnline = "Last seen " . humanTiming($onlinestring) . " ago";
    $statusClass = "offline";
} else {
    $statusOnline = $pr_online;
    $statusClass = "online";
}

$browserUSER = $_SESSION['username'];

if(isset($browserUSER)) {
    $bwsrQRY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$browserUSER'");

    while($bwsrROW = mysqli_fetch_assoc($bwsrQRY)) {
        $bwsrID = $bwsrROW['id'];
        $bwsrFR = explode(',', $bwsrROW['friends']);
    }
}
?>

<!doctype html>
<html>
<head>

    <title><?php echo $pr_username; ?>'s Profile Page | GSR</title>

    <meta name="description" content="GSR - Welcome to <?php echo $pr_username; ?>'s profile page!">

    <?php include "externals.php"; ?>

</head>

<style>
    .user-details {position: relative; padding: 0;}
    .user-details .user-image {position: relative;  z-index: 1; width: 100%; text-align: center;}
    .user-image img { clear: both; margin: auto; position: relative;}

    .user-details .user-info-block {width: 100%; position: absolute; top: 55px; background: rgb(255, 255, 255); z-index: 0; padding-top: 35px;}
    .user-info-block .user-heading {width: 100%; text-align: center; margin: 10px 0 0;}
    .user-info-block .navigation {float: left; width: 100%; margin: 0; padding: 0; list-style: none; border-bottom: 1px solid #E73030; border-top: 1px solid #E73030;}
    .navigation li {float: left; margin: 0; padding: 0;}
    .navigation li a {padding: 20px 30px; float: left;}
    .navigation li.active a {background: #E73030; color: #fff;}
    .user-info-block .user-body {float:left; padding: 5%; width: 90%;}
    .user-body .tab-content > div {float: left; width: 100%;}
    .user-body .tab-content h4 {width: 100%; margin: 10px 0; color: #333;}
</style>

<body>



<?php include "sidebar.php" ?>


<div id="page" class="canvas">


    <?php include "header.php"; ?>


    <div class="container">

        <div class="row white-page">

            <div class="col-sm-12 col-md-12 user-details">
                <div class="user-image">
                    <img src="http://gamesharkreviews.com/imgs/users/<?php echo $pr_image; ?>-232x270.jpg" style="width:100px;height:100px;" alt="Karan Singh Sisodia" title="Karan Singh Sisodia" class="img-thumbnail">
                </div>
                <div class="user-info-block">
                    <div class="user-heading">
                        <h3><?php if($showName == 1) { echo $pr_firstname . " " . $pr_lastname; } else { echo $pr_username; } ?></h3>
                        <span class="help-block"><?php echo $pr_position; ?></span>
                    </div>
                    <ul class="navigation">
                        <li class="active">
                            <a data-toggle="tab" href="#information">
                                <span class="fa fa-user"></span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#settings">
                                <span class="fa fa-cog"></span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#email">
                                <span class="fa fa-envelope"></span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#events">
                                <span class="fa fa-calendar"></span>
                            </a>
                        </li>
                        <li class="clearfix"></li>
                    </ul>
                    <div class="clearfix"></div>
                    <div class="user-body">
                        <div class="tab-content">
                            <div id="information" class="tab-pane active">
                                <h4>Account Information</h4>
                            </div>
                            <div id="settings" class="tab-pane">
                                <h4>Settings</h4>
                            </div>
                            <div id="email" class="tab-pane">
                                <h4>Send Message</h4>
                            </div>
                            <div id="events" class="tab-pane">
                                <h4>Events</h4>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clear"></div>
            </div>

        </div>


    </div>


    <?php include "footer.php"; ?>

</div>

<script type="text/javascript">

    function floatFix(){
        var user_image = $(".user-image");
        var user_info_block = $(".user-info-block");
        var user_image_h    = user_image.height();
        var user_info_block_h = user_info_block.height();
        var total_h = (user_image_h+user_info_block_h);
        $(".white-page").height(total_h);
    }

    $(function() {

        floatFix();
        $(window).resize(function(){
            floatFix();
        });

        $("#updown").hover(function() {
            $("#badgeswrapper").toggleClass('active');
        });

        $("#updown").click(function() {
            $("#badgeswrapper").toggleClass('showall');
        });

        /*var startup_url = "recent_activity.php?user=<?php echo $pr_username; ?>&offset=0";
         $.ajax({
         url : startup_url,
         type : "GET",
         async : false,
         success: function(startup_data) {
         $("#useractivity ul").html(startup_data);
         setInterval(relinkImages(),0);
         }
         });*/

        $("#addfriend").click(function() {
            var sendUser = $(this).attr("data-send-user");
            var sendProf = $(this).attr("data-send-prof");

            var requestFriendURL = "requestfriend.php?user=" + sendUser + "&profile=" + sendProf;
            $.ajax({
                url : requestFriendURL,
                type : "GET",
                async : false,
                success: function() {
                    location.reload();
                }
            });
        });

        $("#acceptfriend").click(function() {
            var sendUser = $(this).attr("data-send-user");
            var sendProf = $(this).attr("data-send-prof");

            var addFriendURL = "addfriend.php?user=" + sendUser + "&profile=" + sendProf;
            $.ajax({
                url : addFriendURL,
                type : "GET",
                async : false,
                success: function() {
                    location.reload();
                }
            });
        });

        $("#next_pag").click(function() {
            setInterval(nextCrunchyResults(),0);
        });

        $("#prev_pag").click(function() {
            setInterval(prevCrunchyResults(),0);
        });
    });

    function nextCrunchyResults() {

        var nxtVAL = parseInt($("#crunchOFFSET").text());
        var nxtMAX = parseInt($("#crunchy_pagination").attr("data-max-offset"));
        var nxtAMU = parseInt($("#crunchy_pagination").attr("data-offset-amount"));

        if(nxtAMU < 0 || nxtAMU == 0) {
            var nxtAMO = 0;
        } else {
            var nxtAMO = nxtAMU;
        }

        if(nxtVAL == nxtAMU || nxtMAX < 5) {
            var nxtOFF = nxtAMO;
        } else {
            var nxtOFF = Math.round(parseInt(nxtVAL) + 5);
        }

        var crunchURL = "profile_crunches.php?offset=" + nxtOFF + "&user=<?php echo $pr_username; ?>";

        $.ajax({
            url : crunchURL,
            type : "GET",
            async : false,
            success: function(crunch_data) {
                $("#crunchbox ul").html(crunch_data);
                setInterval(relinkImages(),0);
            }
        });
    }

    function prevCrunchyResults() {

        var cruVAL = parseInt($("#crunchOFFSET").text());
        var cruMAX = $("#crunchy_pagination").attr("data-max-offset");
        if(cruVAL > 0) {
            var cruOFF = Math.round(parseInt(cruVAL) - 5);
        } else if(cruVAL == 0) {
            var cruOFF = 0;
        }

        var crunchURL = "profile_crunches.php?offset=" + cruOFF + "&user=<?php echo $pr_username; ?>";

        $.ajax({
            url : crunchURL,
            type : "GET",
            async : false,
            success: function(crunch_data) {
                $("#crunchbox ul").html(crunch_data);
                setInterval(relinkImages(),0);
            }
        });
    }

    function relinkImages() {
        $(".shark_pic").each(function() {
            if($(this).attr('data-shark-picture') == "default") {
                $(this).css("background-image", "url(imgs/users/default-116x135.jpg)");
            } else {
                $(this).css("background-image", "url(imgs/users/" + $(this).attr('data-shark-picture') + "-116x135.jpg)");
            }
        });

        var crofset = parseInt($("#crunchOFFSET").text());
        var cruofsm = parseInt($("#crunchy_pagination").attr("data-offset-amount"));
        var crumaxo = parseInt($("#crunchy_pagination").attr("data-max-offset"));

        if(crofset == 0) {
            $("#prev_pag").addClass('null');
        } else {
            $("#prev_pag").removeClass('null');
        }

        if(crofset == cruofsm || crumaxo < 5) {
            $("#next_pag").addClass('null');
        } else {
            $("#next_pag").removeClass('null');
        }
    }
</script>



</body>
</html>