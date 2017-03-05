<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit','1000M');

    include "mysql_con.php";

    echo "<HTML><BODY>";
    
    $sql = "SELECT tbl_guide.id 'GuideID', tbl_guide.title, tbl_guide.steps, tbl_guide.intro, tbl_guide_content.articleidFK, tbl_guide_content.Content FROM tbl_guide LEFT OUTER JOIN tbl_guide_content ON tbl_guide.id=tbl_guide_content.articleidFK";
    $result=mysqli_query($con,$sql);
    $counter=0;
    $lastID="";
    if ($result->num_rows > 0) {
       while($row = $result->fetch_assoc()) {
       
	if($lastID!=$row["GuideID"]){
	  $steps = unserialize($row['steps']);
       	  $counter++;          
       	  //echo $row["title"];
          $contents[$counter] = [
          	"title"=>$row["title"],
          	"id"=>$row["GuideID"],
          	"intro"=>file_get_contents($row["intro"]),
          	"Flats"=>[],
          	"articles"=>[]          	
          	];
          $step_num = 0;
          foreach($steps as $step_file){
		$step_num++;
		array_push($contents[$counter]['articles'],file_get_contents($step_file)); 
	  };
	}else{	  
	  array_push($contents[$counter]['Flats'],$row["Content"]); 
	}
	$lastID=$row["GuideID"];
       }
    } else {
       echo "0 results";
    }
	foreach($contents as $article){
		//if($article["id"]<100){
			//echo "<h1 style='display:block;width:100%'>".$article["id"].": ".$article["title"]."</h1>";
			//echo "<br/>". $article["intro"];
			$sqlero = mysqli_prepare($con,"INSERT INTO tbl_guide_content (articleidFK, Content) VALUES (?,?)") or die(mysqli_error($con));
    			mysqli_stmt_bind_param($sqlero, 'is', $article["id"], $article["intro"]) or die(mysqli_error($con));
    			mysqli_stmt_execute($sqlero) or die(mysqli_error($con));
    			$count=0;
			foreach($article["articles"] as $title=>$section){
				try {
					//echo "<hr style='width:100%'/>".$title.":<br/>".$section."<br />";
					
	          			//$tempFile = fopen($section,"r") or die("can't open file");
	          			//$tempData = fread($tempFile,filesize($section));
	          			//$tempData = str_replace('‘',"'",$tempData);
	          			//$tempData = str_replace('’',"'",$tempData);
	          			//$tempData = str_replace('“','"',$tempData);
	          			//$tempData = str_replace('”','"',$tempData);
	          			//$tempData = str_replace('—','-',$tempData);
	          			//$tempData = iconv('UTF-8', 'ASCII//TRANSLIT', $tempData);     
	          			//$tempData = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $tempData);
	          			//$tempData = htmlentities($tempData, ENT_QUOTES);
	          			
    					$sqlero = mysqli_prepare($con,"INSERT INTO tbl_guide_content (articleidFK, Content) VALUES (?,?)") or die(mysqli_error($con));
    					mysqli_stmt_bind_param($sqlero, 'is', $article["id"], $section) or die(mysqli_error($con));
    					
    					//$value=$tempData;
    					//$identifier=$article["id"];
    					mysqli_stmt_execute($sqlero);
    					//mysqli_stmt_execute($sqlero) or die(mysqli_error($con));
	          			//echo "<div style='width:100%;overflow: auto'><div style='border:solid red 1px;float:left;width:49%'>".$section."</div>";
	          			//echo "<div style='border:solid green 1px;float:right;width:49%'>".$article['Flats'][$count]."</div></div>";
	          			$count++;
	          			//echo "<div>".(strlen($tempData)-strlen($article['Flats'][$title]))."</div>";
	          		}catch ( Exception $e ) {
					echo "thats an error";
	   			} 
	   			//fclose($tempFile );
	          		//unset($tempFile);
	          		//unset($tempData);
	          	}
		//}
	}
	
    echo "Complete no memory errors.<br>";
	
    echo "</BODY></HTML>";