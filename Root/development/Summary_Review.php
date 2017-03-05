<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit','1000M');

    include "mysql_con.php";

    echo "<HTML><BODY>";
    
    $sql = "SELECT * FROM tbl_review";
    $result=mysqli_query($con,$sql);
    $counter=0;
    if ($result->num_rows > 0) {
       while($row = $result->fetch_assoc()) {
       
       	  $counter++;          
          $contents[$counter] = [
          	"title"=>$row["title"],
          	"id"=>$row["id"],
          	"Flats"=>[
          		"Overview"=>$row["Overview"],
	          	"Storyline"=>$row["Storyline"],
        	  	"Gameplay"=>$row["Gameplay"],
          		"Audio"=>$row["Audio"],
	          	"Graphics"=>$row["Graphics"],
        	  	"Verdict"=>$row["Verdict"]
        	  	],
          	"articles"=>[
          		"Overview"=>$row["content_1"],
          		"Storyline"=>$row["content_2"],
          		"Gameplay"=>$row["content_3"],
          		"Audio"=>$row["content_4"],
          		"Graphics"=>$row["content_5"],
          		"Verdict"=>$row["content_6"]
          		]          	
          	];
          }
    } else {
       echo "0 results";
    }
    
	foreach($contents as $article){
		//if($article["id"]==13){
			echo "<h1 style='display:block;width:100%'>".$article["id"].": ".$article["title"]."</h1>";
			foreach($article["articles"] as $title=>$section){
				try {
					//echo "<hr style='width:100%'/>".$title.":<br/>".$section."<br />";
	          			$tempFile = fopen($section,"r") or die("can't open file");
	          			$tempData = fread($tempFile,filesize($section));
	          			//$tempData = str_replace('‘',"'",$tempData);
	          			//$tempData = str_replace('’',"'",$tempData);
	          			//$tempData = str_replace('“','"',$tempData);
	          			//$tempData = str_replace('”','"',$tempData);
	          			//$tempData = str_replace('—','-',$tempData);
	          			$tempData = iconv('UTF-8', 'ASCII//TRANSLIT', $tempData);     
	          			//$tempData = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $tempData);
	          			$tempData = htmlentities($tempData, ENT_QUOTES);
	          			
    					//$sqlero = mysqli_prepare($con,"UPDATE tbl_review SET ".$title."=? WHERE id=?") or die(mysqli_error($con));
    					//mysqli_stmt_bind_param($sqlero, 'ss', $value, $identifier) or die(mysqli_error($con));
    					//$value=$tempData;
    					//$identifier=$article["id"];
    					//mysqli_stmt_execute($sqlero) or die(mysqli_error($con));
	          			//echo "<div style='width:100%;overflow: auto'><div style='border:solid red 1px;float:left;width:49%'>".$tempData."</div>";
	          			//echo "<div style='border:solid green 1px;float:right;width:49%'>".$article['Flats'][$title]."</div></div>";
	          			echo "<div>".(strlen($tempData)-strlen($article['Flats'][$title]))."</div>";
	          		}catch ( Exception $e ) {
					echo "thats an error";
	   			} 
	   			fclose($tempFile );
	          		unset($tempFile);
	          		unset($tempData);
	          	}
		//}
	}
	
    echo "Complete no memory errors.<br>";
	
    echo "</BODY></HTML>";