<?php

try
{
	include 'mysql_con.php';
	//Getting records (listAction)
	if($_GET["action"] == "list")
	{	

		//Get records from database
		if($_GET["jtSorting"]=="fullname ASC"){
			$_GET["jtSorting"] = "firstname ASC";
		}
		if($_GET["jtSorting"]=="fullname DESC"){
			$_GET["jtSorting"] = "firstname DESC";
		}
		if($_GET["jtSorting"]=="email DESC"){
			$_GET["jtSorting"] = "id DESC";
		}
		if($_GET["jtSorting"]=="email ASC"){
			$_GET["jtSorting"] = "id ASC";
		}
		
		$rows = array();
		
		if(isset($_POST['searchquery'])){
		$query = mysqli_real_escape_string($con, $_POST['searchquery']);
		$searchQuery = mysqli_query($con, 'SELECT * FROM tbl_users WHERE (username LIKE "%'.$query.'%"  OR email LIKE "%'.$query.'%")');
		while($searchRow = mysqli_fetch_array($searchQuery))
		{
		$searchUsername = $searchRow['username'];
		$result = mysqli_query($con, "SELECT COUNT(*) AS RecordCount FROM tbl_accounts WHERE username='$searchUsername';");
		$row = mysqli_fetch_array($result);
		$recordCount = $row['RecordCount'];


		$result = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE username='$searchUsername' ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";");
		
		//Add all records to an array
		
		while($row = mysqli_fetch_array($result))
		{
		$row['fullname'] = $row['firstname']." ".$row['lastname'];
		$row['position'] = $row['posa']." ".$row['posb'];
		$username = $row['username'];
		$resultEmail = mysqli_query($con, "SELECT * FROM tbl_users WHERE username='$username'");
		while($rowEmail = mysqli_fetch_array($resultEmail))
		{
			$row['email'] = $rowEmail['email'];
		    $rows[] = $row;
		}
		}
		}
			
		}
		else{
			
		//Get record count
		$result = mysqli_query($con, "SELECT COUNT(*) AS RecordCount FROM tbl_accounts;");
		$row = mysqli_fetch_array($result);
		$recordCount = $row['RecordCount'];


		$result = mysqli_query($con, "SELECT * FROM tbl_accounts ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";");
		
		//Add all records to an array
		while($row = mysqli_fetch_array($result))
		{
		$row['fullname'] = $row['firstname']." ".$row['lastname'];
		$row['position'] = $row['posa']." ".$row['posb'];
		$username = $row['username'];
		$resultEmail = mysqli_query($con, "SELECT * FROM tbl_users WHERE username='$username'");
		while($rowEmail = mysqli_fetch_array($resultEmail))
		{
			$row['email'] = $rowEmail['email'];
		    $rows[] = $row;
		}
		}
		
	}
		
		

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);
	}
	
	//Updating a record (updateAction)
	else if($_GET["action"] == "update")
	{
		//Update record in database
		if(isset($_POST['id'])) {
			$user_id = $_POST['id'];
			$rank_id = $_POST['rank'];
			$rank_qry = mysqli_query($con, "UPDATE tbl_accounts SET rank = $rank_id WHERE id = '$user_id'");
			$getUSER = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE id = '$user_id'");
			while ($userROW = mysqli_fetch_array($getUSER)) {
				$ACC_username = $userROW['username'];
			}

			if (  $_POST['password']==$_POST['repassword'] ) {

				$ACC_password = mysqli_real_escape_string($con, sha1(md5($_POST['password'])));

				$getOPW = mysqli_query($con, "SELECT * FROM tbl_users WHERE username = '".$ACC_username."'");
				while ($oldpwROW = mysqli_fetch_array($getOPW)) {
					$origPW = $oldpwROW['password'];
				}


				if ($ACC_password == "67a74306b06d0c01624fe0d0249a570f4d093747") {
					$ACC_password = $origPW;
				}

				$pw_qry = mysqli_query($con, "UPDATE tbl_users SET password = '$ACC_password' WHERE username = '$ACC_username'");


			}

		}

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}

	//Close database connection
	mysqli_close($con);

}
catch(Exception $ex)
{
    //Return error message
	$jTableResult = array();
	$jTableResult['Result'] = "ERROR";
	$jTableResult['Message'] = $ex->getMessage();
	print json_encode($jTableResult);
}
	
?>