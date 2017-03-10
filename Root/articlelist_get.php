<?php

try
{
	include 'mysql_con.php';

	$articletype = $_POST['articletype'];
	//Getting records (listAction)
	if($_GET["action"] == "list")
	{
		//Get record count
		$result = mysqli_query($con, "SELECT COUNT(*) AS RecordCount FROM tbl_$articletype WHERE pending!='false';");
		$row = mysqli_fetch_array($result);
		$recordCount = $row['RecordCount'];

		//Get records from database
		$result = mysqli_query($con, "SELECT * FROM tbl_$articletype WHERE pending!='false' ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";");
		
		//Add all records to an array
		$rows = array();
		while($row = mysqli_fetch_array($result))
		{
			$id     = $row['id'];
			$featured_ar = mysqli_query($con, "SELECT * FROM tbl_featured WHERE article_id=$id AND article_type='".ucfirst($articletype)."'");
			while ($ft_row = mysqli_fetch_assoc($featured_ar)) {
				$position = $ft_row['position'];
			}
            if(mysqli_num_rows($featured_ar)!=0){$row['featured']=$position;}
            else{$row['featured'] = 0;}
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