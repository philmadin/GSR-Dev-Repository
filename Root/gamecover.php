<?php
include "mysql_con.php";

$user = $_SESSION['username'];
$setID = $_GET['id'];

if(!isset($user)) { header("location:index.php"); }
if(empty($setID)) { header("location:index.php"); }
if(!is_numeric($setID)){ header("location: index.php"); }

$setID = mysqli_real_escape_string($con, $setID);

$gameQRY = mysqli_query($con, "SELECT * FROM tbl_games WHERE id = '$setID'");

if(!has_perms("manage-wiki") || mysqli_num_rows($gameQRY)<1){
    header("Location: manage-games.php");
}

while ($game = mysqli_fetch_assoc($gameQRY)) {
    $title		= $game['title'];
    $id         = $game['id'];
    $image      = $game['image'];
}
?>

<!doctype html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, follow, noarchive">

    <title><?php echo $title;?> | Game Cover | GSR</title>

    <meta name="description" content="Upload or Change Games Cover Image..">

    <?php include "links.php"; ?>

    <style>

    </style>

</head>

<body>

<?php include "header.php"; ?>

<div id="page" class="container_24">

    <article>

        <section id="dashboard">

            <?php include 'dashboard-nav.php';?>

            <div id="db-main">

                <?php include 'dashboard-msg.php';?>


                <form id="submitform" action="manage-games_get.php?action=gamecover" method="post" enctype="multipart/form-data">
                    <div class="subtitle">
                        <h6>UPLOAD COVER</h6>
                        <span>(uploads will automatically remove already set cover)</span>
                    </div>

                    <div id="upload_section">
                        <input name="cover" id="cover" type="file" accept="image/*" />


                        <button name="upload_cover" id="upload_cover" type="submit" value="<?php echo $setID; ?>">Upload</button>

                    </div>


                    <div id="image-container">

                        <div class="progress">
                            <div id="upload_bar" class="progress-bar progress-bar-striped active" role="progressbar"
                                 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div >
                        </div>

                    <?php
                    if(!empty($image)) {
                        echo "<a class='setimage' data-set-image='cover_image' data-article-id='" . $id . "'><img style='width:100%;' src='".$image."'></a>";
                    } else {
                        echo "<a class='setimage' style='display:none;' data-set-image='cover_image' data-article-id='" . $id . "'><img style='width:100%;' src=''></a><span>There is no set image.</span>";
                    }
                    ?>

                    </div>
                </form>

            </div>
        </section>

    </article>

</div>

<style>
    #submitform{
        border:solid 1px #e73030;
        width:80%;
        display:block;
        margin:auto;
        box-shadow: 0 10px 6px -6px #777;
    }

    #submitform .subtitle{
        width:100%;
        text-align:center;
        color:white;
        background-color:#e73030;
        border-bottom:solid 1px #e73030;
        padding-top:10px;
        padding-bottom:10px;
    }

    #upload_section{
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        padding:15px;
        text-align:center;
    }

    #upload_section button{
        text-align: center;
        font-size: 14px;
        font-family: Arial,Helvetica,sans-serif;
        margin: auto;
        display: inline-block;
        width: 100px;
        height: 30px;
        line-height: 30px;
        background-color: #e73030;
        color: #fff;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        cursor: pointer;
        box-shadow: 0 10px 6px -6px #777;
        border: none;
    }

    #image-container{
        width:100%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        display:block;
        border-bottom:solid 1px #e73030;
        background-color:#e73030;
        padding:20px;
        color:white;
        text-align:center;
        font-size:16px;
    }

    .setimage {
        background-color: #e73030;
        display: block;
        -moz-box-shadow: inset 0 0 40px #000000;
        -webkit-box-shadow: inset 0 0 40px #000000;
        box-shadow: inset 0 0 40px #000000;
    }

    .setimage img{
        border:solid 1px white;
    }
    
    
    .progress{
        width:100%;
        background-color:#FFF;
        display:none;
        border:solid 1px white;
        border-bottom:none;
    }

    .progress #upload_bar{
        height:20px;
        display:block;
        text-align: center;
        line-height:20px;
        color: #fff;
        text-shadow: 1px 1px 1px #000;
        font-weight: normal;
        font-size: 14px;
        background-image: linear-gradient(to bottom,rgba(252,124,124,1) 0%,rgba(214,50,50,1) 50%,rgba(201,43,43,1) 51%,rgba(231,48,48,1) 100%);
    }
</style>

<?php include "footer.html"; ?>
<script src="http://malsup.github.com/jquery.form.js"></script>
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
    };

    $(function() {

        if($.urlParam('upload_error') == 'width') {
            $("#cover").addClass('error');
            $("#cover").after("<label class='error' id='filerror'>The image width was too small.</label>");
            console.log("2");
            $("#filerror").delay(5000).fadeOut('fast', function() {
                $("#cover").removeClass('error');
            });
        } else if($.urlParam('upload_error') == 'invalid') {
            $("#cover").addClass('error');
            $("#cover").after("<label class='error' id='filerror'>That file was invalid.</label>");
            console.log("3");
            $("#filerror").delay(5000).fadeOut('fast', function () {
                $("#cover").removeClass('error');
            });

        }

            var bar = $('#upload_bar');
            var percent = bar;

            $('#submitform').ajaxForm({
                beforeSend: function () {
                    var percentVal = '0%';
                    $(".progress").show();
                    bar.width(percentVal);
                    bar.attr("aria-valuenow", 0);
                    percent.html(percentVal);
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    bar.attr("aria-valuenow", percentComplete);
                    bar.width(percentVal);
                    percent.html(percentVal);
                },
                complete: function (xhr) {
                    bar.width("100%");
                    bar.attr("aria-valuenow", 100);
                    percent.html("100%");

                    var game_id = <?php echo $id;?>;

                    $.getJSON("api/games.php?id="+game_id, function(result){
                        $.each(result, function(i, game){
                            d = new Date();
                            $(".setimage").show();
                            $("#image-container span").remove();
                            $(".setimage img").attr("src", "").attr("src", game.cover+"?"+d.getTime());
                        });
                    });


                }
            });

        });


</script>

</body>
</html>