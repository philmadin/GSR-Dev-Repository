<?php
function geo($ip, $type){
	if($ip==null){
	$geo =  unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $_SERVER['REMOTE_ADDR']) );	
	}
	else{
	$geo =  unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip) );		
	}
	return $geo["geoplugin_".$type];
	}
	
	
function last6months(){
	$month_array = array();
	
array_push($month_array,array(date('M'), date('Y')));	

for ($i = 1; $i < 6; $i++) {
  array_push($month_array,array(date('M', strtotime("-$i month")), date('Y', strtotime("-$i month"))));	
}
	return $month_array;
}

function stringToColorCode($str) {
  $code = dechex(crc32($str));
  $code = substr($code, 0, 6);
  return $code;
}

?>