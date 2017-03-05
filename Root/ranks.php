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

if(!has_perms("manage-ranks")){
    header("Location: index.php");
}

$sectorlist1 = array();

$sectorQRY = mysqli_query($con, "SELECT * FROM tbl_rank_sectors");
while ($sectorROW = mysqli_fetch_assoc($sectorQRY)) {
    $sectorlist1[] = $sectorROW;
}

?>

<!doctype html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, follow, noarchive">

    <title>Dashboard | Manage Ranks | GSR</title>

    <meta name="description" content="Manage the almighty ranking system.">

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

                <div id="RankTableContainer" style="width: 100%;"></div>

            </div>
        </section>

    </article>

</div>

<?php include "footer.html"; ?>
<script type="text/javascript">

    $(document).ready(function () {

        var sectorlist = eval('(' + '<?php echo json_encode($sectorlist1); ?>' + ')');


        //Prepare jTable
        $('#RankTableContainer').jtable({
            title: "Manage Ranks",
            paging: true,
            pageSize: 20,
            sorting: true,
            defaultSorting: 'id ASC',
            actions: {
                listAction: function (postData, jtParams) {
                    return $.Deferred(function ($dfd) {
                        $.ajax({
                            url: 'ranklist_get.php?action=list&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
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
                updateAction: function (postData, jtParams) {
                    return $.Deferred(function ($dfd) {
                        $.ajax({
                            url: 'ranklist_get.php?action=update',
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
                <?php if(has_perms("delete-ranks")) { ?>
                deleteAction: function (postData, jtParams) {
                    return $.Deferred(function ($dfd) {
                        $.ajax({
                            url: 'ranklist_get.php?action=delete',
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
                <?php } ?>
                createAction: function (postData, jtParams) {
                    return $.Deferred(function ($dfd) {
                        $.ajax({
                            url: 'ranklist_get.php?action=create',
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
                name: {
                    edit: true,
                    title: 'Name',
                    width: '20%',
                    create: true
                },
                sectorName: {
                    edit: false,
                    sorting: false,
                    create: false,
                    list: true,
                    title: 'Sector',
                    width: '30%',
                    input: function (data) {
                        if (data.record.sector != 0) {

                        }
                    }
                },
                sector: {
                    edit: true,
                    list: false,
                    create: true,
                    title: 'Sector',
                    input: function (data) {
                            if(data.record) {
                                if (data.record.id == 0) {
                                    var sectors = "<select name='sector' disabled>";
                                }
                                else {
                                    var sectors = "<select name='sector'>";
                                }
                            }
                            else{
                                var sectors = "<select name='sector'>";
                            }
                            for (i = 0; i < sectorlist.length; i++) {
                                if(data.record) {
                                    if (sectorlist[i].id == data.record.sector) {
                                        sectors += '<option value="' + sectorlist[i].id + '" selected>' + sectorlist[i].name + '</option>';
                                    }
                                    else{
                                        sectors += '<option value="' + sectorlist[i].id + '">' + sectorlist[i].name + '</option>';
                                    }
                                }
                                else{
                                    sectors += '<option value="' + sectorlist[i].id + '">' + sectorlist[i].name + '</option>';
                                }
                            }
                            sectors += "</select>";
                            return sectors;
                    }
                },
                permissions: {
                    edit: true,
                    create: true,
                    title: 'Permissions',
                    width: '40%',
                    input: function (data){
                        if(data.record) {
                            if (data.record.permissions != "") {
                                return '<textarea name="permissions" cols="50" rows="8">' + data.record.permissions + '</textarea>';
                            }
                            else {
                                return '<textarea name="permissions" cols="50" rows="8" placeholder="No permissions"></textarea>';
                            }
                        }
                        else {
                            return '<textarea name="permissions" cols="50" rows="8" placeholder="No permissions"></textarea>';
                        }

                    },
                    display: function (data) {
                       if(data.record.permissions!=""){
                           var permissions_list = data.record.permissions.split(", ");
                           var perms = "<ul style='margin-bottom:0px;'>";
                           for (i = 0; i < permissions_list.length; i++) {
                               perms += '<li>'+permissions_list[i]+'</li>';
                           }
                           perms += "</ul>";
                           return perms;
                       }
                        else{
                           return "<ul style='margin-bottom:0px;'><li>no permissions</li></ul>";
                       }
                    }
                }

            }
        });

        $('#RankTableContainer').jtable('load');

    });

</script>


</body>
</html>