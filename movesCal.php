<?php

include 'PHPtoICS.php';

date_default_timezone_set('Asia/Tokyo');

$string = file_get_contents("movesAll.json");
$json=json_decode($string,true);
$json = $json['export'];

//need to remove trailing commas
foreach($json as $date) {
  $i=0;
  foreach($date['segments'] as $segment) {
    $startTime = strtotime($segment['startTime']);
    $endTime = strtotime($segment['endTime']);

    if($i==0 && date("d",$startTime) != date("d",$endTime))
      continue;

    //place
    if($segment['type'] == "place") {
      echo date("Y.m.d H:i:s",$startTime) . " ";
      if(isset($segment['place']['name']))
	echo $i . $segment['place']['name'] . " ";
      else
	echo $i . "a place";
      echo "\n";

      $i++;
    }
    //move
    else  {
      foreach($segment['activities'] as $activity) {
	$startTime = strtotime($activity['startTime']);
	$endTime = strtotime($activity['endTime']);
	echo date("Y.m.d H:i:s",$startTime) . " ";
	echo $i . "act " .$activity['activity'] . " ";
	echo "\n";
      }
      $i++;
    }    
  }
}
?>
