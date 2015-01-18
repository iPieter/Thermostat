<?php
include("datalogin.php");

if (isset($_GET['date'])) {

switch ($_GET['date']) {
	case 'today': 
		$date = date("Y-m-d");
		$date2 = date("Y-m-d");
		$interval = 0; break;
	case 'yesterday': 
		$date = date("Y-m-d", time() - 24*60*60);
		$date2 = date("Y-m-d", time() - 24*60*60);
		$interval = 0; break;
	case 'this_week': 
		$date = date("Y-m-d");
		$date2 = date("Y-m-d");
		$interval = 7; break;			
		case 'week': 
		$date = date("Y-m-d", time() - 7*24*60*60);
		$date2 = date("Y-m-d");
		$interval = 7; break;	
}

} else {

	$date = date("Y-m-d");
	$date2 = date("Y-m-d");
	$interval =1;

}

$result = mysqli_query($con,"SELECT * FROM history WHERE DATE_SUB('$date', INTERVAL $interval DAY) <= date(time) AND  date(time) <= date($date2) ");


$data = array();

/*
$table['labels'] = array(

array('label' => 'Time', 'type' => 'string'),
array('label' => 'Temperature', 'type' => 'number')

);
*/
    /* Extract the information from $result */
    foreach($result as $r) {
	  	 	  	  	        
      $temp = array();
      $time_raw = 1000* strtotime($r['time']);
      $time = date('H:i', $time_raw);

      $data[] = array( $time_raw,round($r['P'],1)); 


    }

$table =array('duty' => $data);
// convert data into JSON format
$jsonTable = json_encode($table);
echo $jsonTable;


?>