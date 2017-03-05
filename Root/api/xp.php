<?php
//header("Access-Control-Allow-Origin: http://www.gamesharkreviews.com");
//header("Access-Control-Allow-Origin: http://m.gamesharkreviews.com");

header("Access-Control-Allow-Methods: JSON, GET");

include 'mysql_con.php';
$xpuser = null;
if(isset($_GET['user'])){
    $xpuser = $_GET['user'];
}
else{
    $xpuser = $_SESSION['username'];
    if(!isset($xpuser)) {
        $xpuser = false;
    }
}

$error_json = array();

$user = $xpuser;

if($xpuser == false )
{
    $error_json['no_user'] = 'User not found';
}
function percentage($val1, $val2, $precision)
{
    $res = round( ($val1 / $val2) * 100, $precision );

    return $res;
}

$level_details = array();
$level_details['username'] = $user;
$user_xp_qry = mysqli_query($con, 'SELECT SUM(xp) AS user_xp FROM tbl_xp_log WHERE username="' . $user . '";');
$user_xp = mysqli_fetch_array($user_xp_qry);
if (!isset($user_xp['user_xp'])) {
    $level_details['current_xp'] = (int)0;
} else {
    $level_details['current_xp'] = (int)$user_xp['user_xp'];
}


$user_level = mysqli_query($con, "SELECT * FROM tbl_levels WHERE xp_required <= " . $level_details['current_xp'] . " ORDER BY id DESC LIMIT 1");

if (mysqli_num_rows($user_level) == 0) {
    $level_details['current_level'] = (int)1;
}
else{
    while ($level_row = mysqli_fetch_assoc($user_level)) {
        $level_details['current_level'] = (int)$level_row['id'];
    }
}
$level_details['next_level'] = ($level_details['current_level'] + 1);

$next_level = mysqli_query($con, "SELECT * FROM tbl_levels WHERE id = '".$level_details['next_level']."'");

while($next_level_row = mysqli_fetch_assoc($next_level)) {
    $level_details['level_xp'] = (int)$next_level_row['xp_required'];
}
$level_details['xp_required'] = $level_details['level_xp']-$level_details['current_xp'];
$level_details['level_percentage'] = percentage($level_details['current_xp'], $level_details['level_xp'], 2);

$current_level = $level_details['current_level'];
$current_xp = $level_details['current_xp'];

$sql = "UPDATE tbl_accounts SET level='$current_level', xp='$current_xp' WHERE username='$user'";

if (!mysqli_query($con, $sql)) {
    $error_json['error_sql'] = mysqli_error($con);
}

if(count($error_json)>0){
    header('Content-Type: application/json');
    die( json_encode( $error_json ) );
}



header('Content-Type: application/json');
echo json_encode($level_details);
?>