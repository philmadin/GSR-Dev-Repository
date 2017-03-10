<?php

try
{
    include 'mysql_con.php';
    //Getting records (listAction)
    if($_GET["action"] == "list")
    {


        $rows = array();



        //Get record count
        $result = mysqli_query($con, "SELECT COUNT(*) AS RecordCount FROM tbl_staffguides;");
        $row = mysqli_fetch_array($result);
        $recordCount = $row['RecordCount'];


        $result = mysqli_query($con, "SELECT * FROM tbl_staffguides ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";");

        //Add all records to an array
        while($row = mysqli_fetch_array($result))
        {
            $permissions = explode(",",$row['permissions']);

            $row['locked'] = 'true';

            foreach($permissions as $permission){
                if(has_perms($permission)){
                   $row['locked'] = 'false';
                }
            }

            $rows[] = $row;
        }




        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result'] = "OK";
        $jTableResult['TotalRecordCount'] = $recordCount;
        $jTableResult['Records'] = $rows;
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