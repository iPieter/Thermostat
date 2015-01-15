<?php
include("datalogin.php");

	$date = date("Y-m-d");


$result = mysqli_query($con,"SELECT * FROM history WHERE DATE(`time`) = '".$date."' ");


$data = array();
$data2 = array();

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

      $data[] = array( $time_raw,round($r['T_cur'],1)); 
      $data2[] = array( $time_raw,round($r['T_tar'],1)); 

    }

$table =array('cur' => $data,'tar' => $data2);
// convert data into JSON format
$jsonTable = json_encode($table);
echo $jsonTable;


?>