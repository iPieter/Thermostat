<?php
include("datalogin.php");

	$date = date("Y-m-d");


$result = mysqli_query($con,"SELECT * FROM history WHERE DATE(`time`) = '".$date."' ");


$data = array();
$data2 = array();
$labels = array();
$table = array();
/*
$table['labels'] = array(

array('label' => 'Time', 'type' => 'string'),
array('label' => 'Temperature', 'type' => 'number')

);
*/
    /* Extract the information from $result */
    foreach($result as $r) {
	  	 	 
	  	  	        
      $temp = array();
      $time_raw = strtotime($r['time']);
      $time = date('H:i', $time_raw);
      $labels[] =(string) $time; 


      $data[] = round($r['T_cur'],1); 
      $data2[] = (float)$r['T_tar'];
    }
$table['labels'] = $labels;

$dataset = 
array('label' => 'Temperature', 'fillColor' => 'rgba(151,187,205,0.2)', 'strokeColor' => 'rgba(151,187,205,2)', 'pointColor' => 'rgba(151,187,205,2)','data' => $data);

$dataset2 = 
array('label' => 'Target', 'fillColor' => 'rgba(220,220,220,0.2)', 'strokeColor' => 'rgba(220,220,220,2)','pointColor' => 'rgba(220,220,220,2)','data' => $data2);


$table['datasets'] = array($dataset, $dataset2);

// convert data into JSON format
$jsonTable = json_encode($table);
echo $jsonTable;


?>