<?php
ini_set('display_errors', 1);
ini_set('memory_limit','1000M'); 
include "mysql_con.php";

echo "<HTML><BODY>";

    $sql = "SELECT * FROM tbl_review";
    $result=mysqli_query($con,$sql);
	echo "<table border='1'>";
    while($row = $result->fetch_assoc()) {
	echo "<tr>";
	echo "<td>";
	echo $row["id"]."<br />";
	echo "</td>";
	echo "<td>";
	echo $row["genre"]."<br />";
	echo "</td>";
	echo "<td>";
	echo $row["platforms"]."<br />";
	echo "</td>";
	echo "<td>";
	echo $row["testedplatforms"]."<br />";
	echo "</td>";
	echo "<td>";
	echo $row["developers"]."<br />";
	echo "</td>";
	echo "<td>";
	echo $row["developersites"]."<br />";
	echo "</td>";
	echo "<td>";
	echo $row["publishers"]."<br />";
	echo "</td>";
	echo "<td>";
	echo $row["publishersites"]."<br />";
	echo "</td>";
	echo "</tr>";	
	//$sqlero = mysqli_prepare($con,"INSERT INTO tbl_game_review VALUES (?,?,?,?,?,?,?,?)") or die(mysqli_error($con));
	//mysqli_stmt_bind_param($sqlero, 'isssssss', $row["id"], $row["genre"],$row["platforms"],$row["testedplatforms"],$row["developers"],$row["developersites"],$row["publishers"],$row["publishersites"]) or die(mysqli_error($con));
    //mysqli_stmt_execute($sqlero) or die(mysqli_error($con));
    }
	

	echo "</table>";
echo "Complete no memory errors.<br>";
echo "</BODY></HTML>";
