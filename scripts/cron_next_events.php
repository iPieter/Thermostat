<?php

//include('datalogin.php');
require('../model/class.iCalReader.php');
require('../model/Model.php');
require('../model/User.model.php');
require('../model/Alarm.model.php');


$ical   = new ICal('http://p02-calendarws.icloud.com/ca/subscribe/1/rIrjZCGQE_T9FeOOI_NVc0s0POg6Ye_k-6GNhtnK8Y3vb93CD53QPOJ78i7t1isf0-YiX2FoczojKvUhi_7u6d3VifAbHdXcTCSXKk5yVis');
//$ical   = new ICal('http://74.208.109.61/vcal.php?key=34315ec4957334b4f88fd38f112839c7&tzid=Europe%2FBrussels');
$events = $ical->events();

$date = reset($events)['DTSTART'];
echo 'The ical date: ';
echo $date;
echo "<br />\n";

echo 'The Unix timestamp: ';
echo $ical->iCalDateToUnixTimestamp($date);
echo "<br />\n";

echo 'The number of events: ';
echo $ical->event_count;
echo "<br />\n";

echo 'The number of todos: ';
echo $ical->todo_count;
echo "<br />\n";
echo '<hr/><hr/>';

$nextEvent;
$nextEventTime = time();

foreach ($events as $event) {
    if (time() < $ical->iCalDateToUnixTimestamp($event['DTSTART']) && ($nextEventTime > $ical->iCalDateToUnixTimestamp($event['DTSTART']) || $nextEventTime == time())) {
        $nextEvent = $event;
        $nextEventTime = $ical->iCalDateToUnixTimestamp($event['DTSTART']);
    }
}

    echo 'SUMMARY: ' . @$nextEvent['SUMMARY'] . "<br />\n";
    echo 'DTSTART: ' . $nextEvent['DTSTART'] . ' - UNIX-Time: ' . $ical->iCalDateToUnixTimestamp($nextEvent['DTSTART']) . "<br />\n";
    echo 'UID: ' . $nextEvent['UID'] . "<br />\n";
    echo 'LOCATION: ' . @$nextEvent['LOCATION'] . "<br />\n";
    echo '<hr/>';



try {        
//get the measured sum 
//Warning: BLACK MAGIC, DO NOT TOUCH!
$url="https://api.spark.io/v1/devices/$my_device/x?access_token=$my_access_token";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://api.spark.io/v1/devices/" . $my_device . "/digitalwrite");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,"access_token=" . $my_access_token . "&params=" . $output_pin . "," . $level);
curl_exec ($ch);
curl_close ($ch);

catch (Exception $e) {
	//include('cron.php');
}
mysqli_close($con);

?>