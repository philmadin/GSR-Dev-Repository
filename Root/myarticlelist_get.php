<?php

try
{
	include 'mysql_con.php';
	
	$user = $_SESSION['username'];

	//Getting records (listAction)
	if($_GET["action"] == "list")
	{
		$rows = array();
		//Get record count
		$result = mysqli_query($con, "SELECT COUNT(*) AS RecordCount FROM tbl_review WHERE authuser='$user';");
		$row = mysqli_fetch_array($result);
		$recordCount1 = $row['RecordCount'];
		$result = mysqli_query($con, "SELECT COUNT(*) AS RecordCount FROM tbl_opinion WHERE authuser='$user';");
		$row = mysqli_fetch_array($result);
		$recordCount2 = $row['RecordCount'];
		$result = mysqli_query($con, "SELECT COUNT(*) AS RecordCount FROM tbl_news WHERE authuser='$user';");
		$row = mysqli_fetch_array($result);
		$recordCount3 = $row['RecordCount'];
		$result = mysqli_query($con, "SELECT COUNT(*) AS RecordCount FROM tbl_guide WHERE authuser='$user';");
		$row = mysqli_fetch_array($result);
		$recordCount4 = $row['RecordCount'];
		
		$recordCount  = ($recordCount1+$recordCount2+$recordCount3+$recordCount4);
		
		//Get records from database
		$result = mysqli_query($con, "SELECT * FROM tbl_review WHERE authuser='$user' ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";");	
		while($row = mysqli_fetch_array($result))
		{
		    $rows[] = $row;
		}
		$result = mysqli_query($con, "SELECT * FROM tbl_opinion WHERE authuser='$user' ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";");	
		while($row = mysqli_fetch_array($result))
		{
		    $rows[] = $row;
		}
		$result = mysqli_query($con, "SELECT * FROM tbl_news WHERE authuser='$user' ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";");
		while($row = mysqli_fetch_array($result))
		{
		    $rows[] = $row;
		}
		$result = mysqli_query($con, "SELECT * FROM tbl_guide WHERE authuser='$user' ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";");	
		while($row = mysqli_fetch_array($result))
		{
		    $rows[] = $row;
		}

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);
	}
	
	//Updating a record (updateAction)
	/* else if($_GET["action"] == "update")
	{
		//Update record in database
		$result = mysql_query("UPDATE people SET Name = '" . $_POST["Name"] . "', Age = " . $_POST["Age"] . " WHERE PersonId = " . $_POST["PersonId"] . ";");

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
	*/

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