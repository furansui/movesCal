<?php

include 'PHPtoICS.php';

date_default_timezone_set('Asia/Tokyo');

$string = file_get_contents("movesAll.json");
$json=json_decode($string,true);
$json = $json['export'];

echo icshead() . "\n";

//need to remove trailing commas
foreach($json as $date) {
  foreach($date['segments'] as $segment) {
    $startTime = strtotime($segment['startTime']);
    $endTime = strtotime($segment['endTime']);


    //place
    if($segment['type'] == "place") {
      if(isset($segment['place']['name']))
	echo ics($segment['place']['name'],$startTime,$endTime,"","","","");   
      else
	echo ics("a place",$startTime,$endTime,"","","","");   
    }
    //move
    else  {
      foreach($segment['activities'] as $activity) {
	$startTime = strtotime($activity['startTime']);
	$endTime = strtotime($activity['endTime']);
	$act = "walk";
	if($activity['activity'] == "trp")
	  $act = "transport";	
	echo ics($act,$startTime,$endTime,"","","","");   
      }
    }
    echo "\n";
  }
}
echo icstail();
?>
