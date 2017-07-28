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
	echo $row["platform"]."<br />";
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
	echo "<td>";
	echo $row["tags"]."<br />";
	echo "</td>";
	echo "<td>";
	echo $row["views"]."<br />";
	echo "</td>";
	echo "<td>";
	echo $row["bites"]."<br />";
	echo "</td>";
	echo "</tr>";
    }
	

	echo "</table>";
echo "Complete no memory errors.<br>";
echo "</BODY></HTML>";
