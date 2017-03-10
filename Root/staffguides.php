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

?>

<!doctype html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, follow, noarchive">

    <title>Dashboard | Staff Guides | GSR</title>

    <meta name="description" content="Guides/Tutorials on how to use the dashboard.">

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

                <div id="GuidesTableContainer" style="width: 100%;"></div>

            </div>
        </section>

    </article>

</div>

<?php include "footer.html"; ?>
<script type="text/javascript">

    $(document).ready(function () {


        //Prepare jTable
        $('#GuidesTableContainer').jtable({
            title: "HOW-TO Staff Guides",
            paging: true,
            pageSize: 20,
            sorting: true,
            defaultSorting: 'name ASC',
            actions: {
                listAction: function (postData, jtParams) {
                    return $.Deferred(function ($dfd) {
                        $.ajax({
                            url: 'staffguides_get.php?action=list&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
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
                }
            },
            fields: {
                id: {
                    key: true,
                    create: false,
                    edit: false,
                    list: true,
                    title: "Id",
                    width: "10%"
                },
                locked: {
                    edit: false,
                    create: false,
                    sorting: false,
                    title: 'Access',
                    width: '10%',
                    display: function (data) {
                        if(data.record.locked=='true'){
                            return '<center><span class="fa fa-lock fa-2x" title="No Access" style="margin:auto;"></span></center>';
                        }
                        if(data.record.locked=='false'){
                            return '<center><span class="fa fa-unlock fa-2x" style="margin:auto;" title="You can use this guide"></span></center>';
                        }

                    }
                },
                name: {
                    edit: false,
                    title: 'Name',
                    display: function (data){
                        return data.record.name;
                    },
                    width: '65%'
                },
                preview: {
                    title:"Open Guide",
                    sorting: false,
                    width: '15%',
                    display: function (data) {
                        if(data.record.locked=='true'){
                            return 'No Access';
                        }
                        if(data.record.locked=='false'){
                            return '<center><button class="jtable-action-button" title="Open: '+data.record.name+'" onclick="openGuide('+"'staffguide.php?id="+data.record.id+"'"+');">Open Guide</button></center>';
                        }

                    }
                }

            }
        });

        $('#GuidesTableContainer').jtable('load');

    });

    function openGuide(url) {
        window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,width="+$(window).width()+",height="+$(window).height());
    }

</script>


</body>
</html>