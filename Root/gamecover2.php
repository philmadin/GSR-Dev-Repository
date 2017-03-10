<?php
include "mysql_con.php";

$user = $_SESSION['username'];
$setID = $_GET['id'];

if(!isset($user)) { header("location:index.php"); }
if(empty($setID)) { header("location:index.php"); }
if(!is_numeric($setID)){ header("location: index.php"); }

$setID = mysqli_real_escape_string($con, $setID);

$gameQRY = mysqli_query($con, "SELECT * FROM tbl_games WHERE id = '$setID'");

if(!has_perms("manage-wiki")){
    header("Location: index.php");
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

    <title><?php echo $game['title'];?> | Game Cover | GSR</title>

    <meta name="description" content="Upload or Change Games Cover Image..">

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

                <form  id="submitform" action="submit<?php echo $article_type;?>.php" method="post" enctype="multipart/form-data">

                    <h6>UPLOAD IMAGES</h6>
                    <span>(uploads will automatically remove already set images)</span>


                    <p class="scroll_section" id="aimage_section">
                        <label for="cover">A. Image - Main Image <i>(&lsquo;jpg&rsquo;, &lsquo;png&rsquo; and &lsquo;gif&rsquo; files only)</i></label>
                        <input name="cover" id="cover" type="file" accept="image/*" />
				        <span>
				        	This image will be used in the article search and browsing as well as the cover image for the article.<br>
				        	Recommended image width &lsquo;960px&rsquo; - ask your lead web developer or graphic designer for support.<br>
				        	Cannot be more than 700KB.
				        </span>
                    </p>


                    <p id="submit_section">
                        <button name="upload_images" id="upload_images" type="submit" value="<?php echo $setID; ?>">UPLOAD</button>

                    <h6>Set Images</h6>

                    <p>
                        <?php
                        echo "<label>A. Image - Main Image</label>";
                        if(!empty($image)) {
                            echo "<a class='setimage' data-set-image='a_image' data-article-id='" . $setID . "'><img src='imgs/".$article_type."/" . $art_aimage . "'></a>";
                        } else {
                            echo "<span>There is no set image.</span>";
                        }
                        ?>
                    </p>



                </form>

            </div>
        </section>

    </article>

</div>

<?php include "footer.html"; ?>
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
            $("#filerror").delay(5000).fadeOut('fast', function() {
                $("#cover").removeClass('error');
            });
        } else if($.urlParam('upload_error') == 'invalid') {
            $("#cover").addClass('error');
            $("#cover").after("<label class='error' id='filerror'>That file was invalid.</label>");
            $("#filerror").delay(5000).fadeOut('fast', function() {
                $("#cover").removeClass('error');
            });
        }

        $("#submitform").validate({
            rules: {
                cover: {
                    maxbytes: true,
                    accept: "image/*"
                }
            },
            messages: {
                cover: {
                    maxbytes: "Use an image that is less than 700KB.",
                    accept: "Only image files are accepted."
                }
            }
        });
    });
</script>

</body>
</html>