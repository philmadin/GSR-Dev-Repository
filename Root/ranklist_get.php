<?php

try
{
    include 'mysql_con.php';
    //Getting records (listAction)
    if($_GET["action"] == "list")
    {


        $rows = array();



            //Get record count
            $result = mysqli_query($con, "SELECT COUNT(*) AS RecordCount FROM tbl_ranks;");
            $row = mysqli_fetch_array($result);
            $recordCount = $row['RecordCount'];


            $result = mysqli_query($con, "SELECT * FROM tbl_ranks ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";");

            //Add all records to an array
            while($row = mysqli_fetch_array($result))
            {
                $sectorlist = array();

                $sector_id = $row['sector'];
                $sectorQRY = mysqli_query($con, "SELECT * FROM tbl_rank_sectors WHERE id = $sector_id");
                while ($sectorROW = mysqli_fetch_assoc($sectorQRY)) {
                    $sector_name = $sectorROW['name'];
                    $row['sectorName'] = $sector_name;
                }
                $sectorQRY = mysqli_query($con, "SELECT * FROM tbl_rank_sectors");
                while ($sectorROW = mysqli_fetch_assoc($sectorQRY)) {
                    $sectorlist[] = $sectorROW;
                    $row['sectorlist'] = $sectorlist;
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

    //Updating a record (updateAction)
    else if($_GET["action"] == "update") {
        //Update record in database
        if (isset($_POST['id'])) {
            $rank_id = $_POST['id'];
            $rank_name = $_POST['name'];
            $rank_permissions = $_POST['permissions'];
            $sector_id = $_POST['sector'];
            $rank_qry = mysqli_query($con, "UPDATE tbl_ranks SET name = '$rank_name', permissions = '$rank_permissions', sector = $sector_id WHERE id = '$rank_id'");

            //Return result to jTable
            $jTableResult = array();
            $jTableResult['Result'] = "OK";
            print json_encode($jTableResult);
    }
    }
    //Deleting a record (deleteAction)
    else if($_GET["action"] == "delete") {
        //Update record in database
        if (isset($_POST['id'])) {
            $rank_id = $_POST['id'];
            $rank_qry = mysqli_query($con, "DELETE FROM tbl_ranks WHERE id = '$rank_id'");
            $clear_qry = mysqli_query($con, "ALTER TABLE tbl_ranks AUTO_INCREMENT = 1");

            //Return result to jTable
            $jTableResult = array();
            $jTableResult['Result'] = "OK";
            print json_encode($jTableResult);
    }
    }

    //Creating a record
    else if($_GET["action"] == "create")
    {
        //Update record in database
        if(isset($_POST['name'])) {
            $rank_name = $_POST['name'];
            $rank_permissions = $_POST['permissions'];
            $sector_id = $_POST['sector'];
            $rank_qry = mysqli_query($con, "INSERT INTO tbl_ranks (name, permissions, sector) VALUES ('$rank_name', '$rank_permissions', '$sector_id')");

            $rows = null;

            $result = mysqli_query($con, "SELECT * FROM tbl_ranks ORDER BY id DESC LIMIT 1");

            //Add all records to an array
            while ($row = mysqli_fetch_array($result)) {
                $sectorlist = array();

                $sector_id = $row['sector'];
                $sectorQRY = mysqli_query($con, "SELECT * FROM tbl_rank_sectors WHERE id = $sector_id");
                while ($sectorROW = mysqli_fetch_assoc($sectorQRY)) {
                    $sector_name = $sectorROW['name'];
                    $row['sectorName'] = $sector_name;
                }
                $sectorQRY = mysqli_query($con, "SELECT * FROM tbl_rank_sectors");
                while ($sectorROW = mysqli_fetch_assoc($sectorQRY)) {
                    $sectorlist[] = $sectorROW;
                    $row['sectorlist'] = $sectorlist;
                }

                $rows = $row;

            }

            //Return result to jTable
            $jTableResult = array();
            $jTableResult['Result'] = "OK";
            $jTableResult['Record'] = $rows;
            print json_encode($jTableResult);

        }

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