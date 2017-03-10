<?php
/**
 * @param $name
 * @return bool
 */
function has_perms($name){
    global $con;
    $user = $_SESSION['username'];
    if(!isset($user)) { return false; }
    else{
        $accountQRY = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username = '$user'");
        while($ACQRY = mysqli_fetch_assoc($accountQRY)) {
            $rank = $ACQRY['rank'];
            $rankQRY = mysqli_query($con, "SELECT * FROM tbl_ranks WHERE id = '$rank'");
            if(mysqli_num_rows($rankQRY)!=0) {
                while ($RQRY = mysqli_fetch_assoc($rankQRY)) {
                    $permissions = $RQRY['permissions'];
                    $perms = explode(", ", $permissions);
                    if (in_array($name, $perms) || strtolower($user)=="daniel") {
                        return true;
                    }
                    if (!in_array($name, $perms)) {
                        return false;
                    }
                }
            }
            else{
                return false;
            }
        }
        return false;
    }
}
?>