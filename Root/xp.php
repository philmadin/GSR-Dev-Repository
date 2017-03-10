<?php
header("Access-Control-Allow-Origin: http://gamesharkreviews.com");
header("Access-Control-Allow-Origin: http://m.gamesharkreviews.com");

header("Access-Control-Allow-Methods: JSON, GET");



include 'mysql_con.php';
            $splitter = "@##$@";
            $user = $_SESSION['username'];
            $giver = '';
            $reciever = '';
            $mp = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tbl_xpmultiplier ORDER BY id DESC"));

            $multiplier = intval($mp['multiplier']);
            $xp_amount = mysqli_real_escape_string($con, $_POST['xp_amount']*$multiplier);
            $item_type = mysqli_real_escape_string($con, $_POST['item_type']);
            $item_id = mysqli_real_escape_string($con, $_POST['item_id']);
            $action_type = mysqli_real_escape_string($con, $_POST['action_type']);
            $description = mysqli_real_escape_string($con, $_POST['description']);

            $desc = str_replace("%xp%", $xp_amount, $description);

if($_POST['reciever']!="null"){
    if(has_perms("manage-xp")) {
        $query = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username='" . $_POST['reciever'] . "'");

        if (mysqli_num_rows($query) > 0) {

            $giver = $user;
            $user = $_POST['reciever'];

        } else {
            if (!mysqli_query($con, $query)) {
                echo 'false' . $splitter . mysqli_error($con);
                return false;
            }
            else{
                echo 'false' . $splitter .'10';
            }
        }
    }
    else{
        echo 'false' . $splitter .'11';
    }
}

            $desc = str_replace("%giver%", $giver, $desc);
            $desc = str_replace("%reciever%", $user, $desc);

            $date_logged = date("Y-m-d");

            if($multiplier>1){
                $desc = $desc."<h5>You recieved x".$multiplier. " xp</h5>reason: " .$mp['eventdesc'];
            }


if(isset($user)) {

if(!isset($xp_amount) || !isset($item_type) || !isset($item_id) || !isset($action_type) || !isset($description)){
    echo 'false'.$splitter.'1';
    return false;
}
    else {

            if ($item_type == "daily_login") {
                $loginCheck = mysqli_query($con, "SELECT * FROM tbl_xp_log WHERE date_logged = '$date_logged' AND username = '$user' AND item_type = 'daily_login'");
                if (mysqli_num_rows($loginCheck) > 0) {
                    echo 'false'.$splitter.'5';
                    return false;
                } else {
                    $insertXp = "INSERT INTO tbl_xp_log (username, xp, item_type, item_id, action_type, date_logged, description) VALUES ('$user', '$xp_amount', '$item_type', '$item_id', '$action_type', '$date_logged', '$desc')";
                    if (!mysqli_query($con, $insertXp)) {
                        echo 'false'.$splitter.'6';
                        return false;
                    } else {
                        echo 'true'.$splitter.'1'.$splitter.$desc;
                        return false;

                    }
                }
            } else {
                $xpCheck = mysqli_query($con, "SELECT * FROM tbl_xp_log WHERE username = '$user' AND item_type = '$item_type' AND item_id = '$item_id' AND action_type = '$action_type'");
                if (mysqli_num_rows($xpCheck) < 1) {
                    $insertXp = "INSERT INTO tbl_xp_log (username,xp, item_type, item_id, action_type, date_logged, description) VALUES ('$user', '$xp_amount', '$item_type', '$item_id', '$action_type', '$date_logged', '$desc')";
                    if (!mysqli_query($con, $insertXp)) {
                        echo 'false'.$splitter.'7';
                        return false;
                    } else {

                        echo 'true'.$splitter.'2'.$splitter.$desc;
                        return false;
                    }
                } else {
                    echo 'false'.$splitter.'8';
                    return false;
                }
            }


    }

    }

else{
    echo 'false'.$splitter.'9';
    return false;
}

?>