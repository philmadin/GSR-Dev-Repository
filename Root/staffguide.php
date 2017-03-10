<?php
include 'mysql_con.php';

if(!isset($_GET['id'])){
    die("No ID was set");
}

$file_id = intval($_GET['id']);


$getGuide = mysqli_query($con, "SELECT * FROM tbl_staffguides WHERE id = $file_id");

if(mysqli_num_rows($getGuide)<1){die("Guide does not exist.");}

while ($guide_row = mysqli_fetch_assoc($getGuide)) {
    $file_path = $guide_row['path'];
    $file_permissions = $guide_row['permissions'];


$permissions = explode(",",$file_permissions);


    foreach($permissions as $permission){
        if(!has_perms($permission)){
            die("Permission denied.");
        }
    }

$file = 'staffguides/'.$file_path;
$filename = $file_path;
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="' . $filename . '"');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');
@readfile($file);


}
?>