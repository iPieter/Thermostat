<?php
include("datalogin.php");

if (isset($_GET['month']) && isset($_GET['year'])) {
	
	$date = date("Y-m-d", strtotime($_GET['month'] . " " . $_GET['year']));
} else {

	$date = date("Y-m-d");
}

$result = mysqli_query($con,"SELECT * FROM `usage_day` WHERE MONTH(`date`) = MONTH('$date') AND YEAR(`date`) = YEAR('$date') ORDER BY `date`");


$data = array();
$data2 = array();
$data3 = array();
$data4 = array();
$consumption = 0;
$minT = 100;
$maxT = 0;
$minTOut = 100;
$maxTOut = 0;
/*
$table['labels'] = array(

array('label' => 'Time', 'type' => 'string'),
array('label' => 'Temperature', 'type' => 'number')

);
*/
    /* Extract the information from $result */
    foreach($result as $r) {
	  	 	  	  	        
      $time_raw = 1000* strtotime($r['date']);
      
      $avgTemp = $r['avg_temp'];
      $avgTempOut = $r['avg_temp_out'];
      $AvgPower = $r['avg_power'];
      $minTDay = $r['min_ind'];
      $maxTDay = $r['max_ind'];
      $consumption += $r['consumption'];
      
      $data[] = array( $time_raw,round($avgTemp,1)); 
      $data2[] = array( $time_raw,round($minTDay,1),round($maxTDay,1));       
      $data3[] = array( $time_raw,round($avgTempOut,1)); 
      $data4[] = array( $time_raw,round($AvgPower,0)); 

      //calculcate min and max temp
      if ($maxT < round($maxTDay,1)) {
	      $maxT = round($maxTDay,1);
      }
      
      if ($minT > round($minTDay,1)) {
	      $minT = round($minTDay,1);
      }
      
      if ($maxTOut < $avgTempOut) {
	      $maxTOut = round($avgTempOut,1);
      }
      
      if ($minTOut > $avgTempOut) {
	      $minTOut = round($avgTempOut,1);
      }
      


    }
    

$consumption = round($consumption,1);    
$stats = array('energy' => $consumption,'minT' => $minT,'maxT' => $maxT,'minTOut' => $minTOut,'maxTOut' => $maxTOut);
$table = array('ind' => $data,'ind_range' => $data2,'out' => $data3,'duty' => $data4,'stats' => $stats);
// convert data into JSON format
$jsonTable = json_encode($table);
echo $jsonTable;

//check if this day was analysed 
$day = mysqli_query($con,"SELECT * FROM usage_day WHERE DATE('$date') = DATE(`date`)");





?>