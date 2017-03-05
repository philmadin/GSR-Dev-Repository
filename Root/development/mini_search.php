<?php

	session_start();

	include "mysql_con.php";

	$miniVAL = mysqli_real_escape_string($con, $_GET['string']);

	$miniQry = mysqli_query($con, "
		(SELECT id, title, article_type
		FROM tbl_review 
		WHERE tags LIKE '%$miniVAL%' OR gamename LIKE '%$miniVAL%' OR title LIKE '%$miniVAL%' OR author LIKE '%$miniVAL%')
		UNION ALL
		(SELECT id, title, article_type
		FROM tbl_opinion 
		WHERE tags LIKE '%$miniVAL%' OR gamename LIKE '%$miniVAL%' OR title LIKE '%$miniVAL%' OR author LIKE '%$miniVAL%')
		UNION ALL
		(SELECT id, title, article_type
		FROM tbl_news 
		WHERE tags LIKE '%$miniVAL%' OR gamename LIKE '%$miniVAL%' OR title LIKE '%$miniVAL%' OR author LIKE '%$miniVAL%')
		ORDER BY CASE WHEN title like '$miniVAL%' THEN 0
               WHEN title like '% %$miniVAL% %' THEN 1
               WHEN title like '%$miniVAL' THEN 2
               ELSE 3
          END, title
		LIMIT 10");

	echo '<option data-string="' . $miniVAL . '" value="' . $miniVAL . '">Search for &lsquo;' . $miniVAL . '&rsquo;</option>';

	while($miniRow = mysqli_fetch_assoc($miniQry)) {
		echo '<option data-string="' . $miniRow['title'] . '" value="' . $miniVAL . ' - ' . $miniRow['title'] . '">' . strtoupper($miniRow['article_type']) . '</option>';
	}

?>