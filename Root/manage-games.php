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

if(!has_perms("manage-wiki")){
    header("Location: dashboard.php");
}

function getColor($src)
{
    $image = imagecreatefrompng($src);
    $thumb = imagecreatetruecolor(1, 1);
    imagecopyresampled($thumb, $image, 0, 0, 0, 0, 1, 1, imagesx($image), imagesy($image));
    $mainColor = strtoupper(dechex(imagecolorat($thumb, 0, 0)));
    return $mainColor;
}

?>

<!doctype html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, follow, noarchive">

    <title>Dashboard | Manage Games | GSR</title>

    <meta name="description" content="Manage all the games in GSR's Database">

    <?php include "links.php"; ?>
    <style>
        div.jtable-main-container>table.jtable>tbody>tr.jtable-data-row>td {
            padding: 4px;
            vertical-align: middle;
            text-align: center;
            font-size:18px;
        }
    </style>

</head>

<body>

<?php include "header.php"; ?>

<div id="page" class="container_24">

    <article>

        <section id="articlelist">

            <?php include 'dashboard-nav.php';?>

            <div id="db-main">

                <?php include 'dashboard-msg.php';?>

                <form action="" method="post" id="game_search">
                    <input type="text" placeholder="Title of Game"/>
                    <button type="submit">Search</button>
                </form>

                <div id="MyGameTableContainer" style="width: 100%;"></div>
                <br />
                <a class="add-new" onclick="document.location='add-game.php';">Submit Game</a>

            </div>
        </section>

    </article>

</div>

<?php include "footer.html"; ?>
<script type="text/javascript">
    $(document).ready(function () {
        //Prepare jTable
        $('#MyGameTableContainer').jtable({
            paging: true,
            pageSize: 10,
            sorting: true,
            defaultSorting: 'title ASC',
            actions: {
                listAction: 'manage-games_get.php?action=list'
            },
            fields: {
                modify: {
                    title:"Edit",
                    sorting: false,
                    width: '5%',
                    display: function (data) {
                        return '<a class="article-edit" title="Edit Game" href="edit-game.php?game_id='+data.record.id+'"></a><br /><a class="img-change" title="Change Game Cover Image" href="gamecover.php?id='+data.record.id+'"></a>';
                    }
                },
                id: {
                    key: true,
                    create: false,
                    edit: false,
                    list: true,
                    width: "5%",
                    title: "#"
                },
                image: {
                    title:"Cover",
                    sorting: false,
                    width: '8%',
                    display: function (data) {
                        var src = "";
                        if(data.record.image==null){ src = "imgs/games/covers/404.jpg"; }
                        if(data.record.image!=null){ src = data.record.image; }
                        return '<img style="max-width:80px;display:block;margin:auto;" src="'+src+'" />';
                    }
                },
                title: {
                    title: 'Title',
                    width: '33%'
                },
                preview: {
                    title:"Preview",
                    sorting: false,
                    width: '5%',
                    display: function (data) {
                        return '<a class="preview" title="Preview Wiki Page" href="'+data.record.url+'"></a>';
                    }
                }
            }

        });
        reloadTable();
        $("#game_search").submit(function(e){
            e.preventDefault();
            if($('#game_search input').val()==""){
                $('#MyGameTableContainer').jtable('load');
            }
            else{
                $('#MyGameTableContainer').jtable('load', {
                    searchquery: $('#game_search input').val()
                });
            }


        });
    });

    function reloadTable(){
        $('#MyGameTableContainer').jtable('load', {
        });
    }

    <?php if(isset($_GET['game'])){ ?>
    <?php if($_GET['game']=="submitted"){ ?>
    $(function(){popup("Thank You!", "<h3>Game has been submitted!</h3><hr />To submit another one <br /><br /><a class='add-new' style='color:white;' href='add-game.php'>click here</a>");});
    <?php } ?>
    <?php if($_GET['game']=="saved"){ ?>
    $(function(){popup("Thank You!", "<h3>Game has been saved!</h3>");});
    <?php } ?>
    <?php if($_GET['game']=="cover"){ ?>
    $(function(){popup("Thank You!", "<h3>Game's Cover Image has been saved!</h3>");});
    <?php } ?>
    <?php } ?>

</script>

</body>
</html>