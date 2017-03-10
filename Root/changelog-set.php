<?php
include 'mysql_con.php';

$description = $_POST['description'];
$version = $_POST['version'];
$comingsoon = $_POST['comingsoon'];
$dateof = $_POST['dateof'];

if(has_perms("manage-changelog")) {
    $query = "INSERT INTO tbl_changelog (description, version, comingsoon, dateof) VALUES ('$description', '$version', '$comingsoon', '$dateof')";
    if (!mysqli_query($con,$query) )
    {
        echo("Error description: " . mysqli_error($con));
    }
    else{
        echo 'Added to changelog: "'.$description.' (Version '.$version.')" - '.$dateof;
    }
}
else{
    echo ("Denied permission");
}
mysqli_close($con);
?>