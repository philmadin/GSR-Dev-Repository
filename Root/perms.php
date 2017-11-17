<?php
/**
* @param $name
* @return bool
*/
function has_perms($name){
  global $con;
  $user = $_SESSION['username'];
  if(!isset($user)) {
    return false;
  }else{
    $statement=mysqli_prepare($con, "SELECT rank FROM tbl_accounts WHERE username = ?");
    mysqli_stmt_bind_param($statement,"s",$user);
    mysqli_stmt_execute($statement);
    mysqli_stmt_bind_result($statement, $accountQRY);
    mysqli_stmt_fetch($statement);
    mysqli_stmt_close($statement);
    $rankQRY = mysqli_prepare($con, "SELECT permissions FROM tbl_ranks WHERE id = ?");
    mysqli_stmt_bind_param($rankQRY ,"i",$accountQRY);
    mysqli_stmt_execute($rankQRY);
    mysqli_stmt_bind_result($rankQRY ,$RQRY);
    mysqli_stmt_fetch($rankQRY);
    $permissions = $RQRY;
    mysqli_stmt_close($rankQRY);
    $perms = explode(", ", $permissions);
    if (in_array($name, $perms)) {
      return true;
    }
    if (!in_array($name, $perms)) {
      return false;
    }
  }
}
?>
