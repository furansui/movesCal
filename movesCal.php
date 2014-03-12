<?php

include 'PHPtoICS.php';

date_default_timezone_set('Asia/Tokyo');

$string = file_get_contents("movesAll.json");
$json=json_decode($string,true);
$json = $json['export'];

//need to remove trailing commas
foreach($json as $date) {
  foreach($date['segments'] as $segment) {
    $startTime = strtotime($segment['startTime']);
    $endTime = strtotime($segment['endTime']);


    //place
    if($segment['type'] == "place") {

      echo date("Y.m.d H:i:s",$startTime) . " ";
      if(isset($segment['place']['name']))
	echo $segment['place']['name'] . " ";
      else
	echo "a place";
      echo "\n";


    }
    //move
    else  {
      foreach($segment['activities'] as $activity) {
	$startTime = strtotime($activity['startTime']);
	$endTime = strtotime($activity['endTime']);
	echo date("Y.m.d H:i:s",$startTime) . " ";
	echo $activity['activity'] . " ";
	echo "\n";
      }
    }
  }
}
?>
