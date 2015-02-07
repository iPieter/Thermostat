<?php
include("datalogin.php");

if (isset($_GET['date'])) {

	$date = $_GET['date'];
} else {

	$date = date("Y-m-d");
}

$result = mysqli_query($con,"SELECT * FROM history WHERE DATE('$date') = DATE(`time`)");


$data = array();
$data2 = array();
$data3 = array();
$data4 = array();
$minT = 100;
$maxT = 0;
$avgTemp = 0;
$avgTempOut = 0;
$count = 0;
$minTOut = 100;
$maxTOut = 0;
$consumption = 0;
$lastTime = 0;
$rmse = 0;
$rmsecount = 0;
/*
$table['labels'] = array(

array('label' => 'Time', 'type' => 'string'),
array('label' => 'Temperature', 'type' => 'number')

);
*/
    /* Extract the information from $result */
    foreach($result as $r) {
	  	 	  	  	        
      $time_raw = 1000* strtotime($r['time']);
      
      if ($lastTime == 0) {
	      $lastTime = $time_raw;
      }
      
      //calculate average power
      $consumption += ($power + $r['P']) * ($time_raw - $lastTime)/ 7200000000;
      $lastTime = $time_raw;

      
      $tcur = $r['T_cur'];
      $ttar = $r['T_tar'];
      $power = $r['P'];
      
      $count++;
      $avgTemp += $tcur;
      $avgTempOut += $tExt;
      
      $data[] = array( $time_raw,round($tcur,1)); 
      $data2[] = array( $time_raw,round($ttar,1)); 
      $data4[] = array( $time_raw,round($power,1)); 
      $tExt = round($r['T_ext'] -273.15,1);
      $data3[] = array( $time_raw,$tExt); 
      
      //calculcate min and max temp
      if ($maxT < round($tcur,1)) {
	      $maxT = round($tcur,1);
      }
      
      if ($minT > round($tcur,1)) {
	      $minT = round($tcur,1);
      }
      
      if ($maxTOut < $tExt) {
	      $maxTOut = $tExt;
      }
      
      if ($minTOut > $tExt) {
	      $minTOut = $tExt;
      }
      
      //calculate rmse 
      if ($r['mode'] != 0) {
	      $rmse += pow(($ttar - $tcur),2);
	      $rmsecount++;
      }

    }
    
$rmse = pow($rmse/$rmsecount,-1/2);

$avgTemp /= $count;
$avgTempOut /= $count;

$avgPower = round($consumption*1000/24,1); 
$consumption = round($consumption,1);    
$stats = array('minT' => $minT,'maxT' => $maxT,'cons' => $consumption,'minTOut' => $minTOut,'maxTOut' => $maxTOut, 'rmse' => round($rmse*100,1));
$table = array('cur' => $data,'tar' => $data2,'out' => $data3,'duty' => $data4,'stats' => $stats);
// convert data into JSON format
$jsonTable = json_encode($table);
echo $jsonTable;

//check if this day was analysed 
$day = mysqli_query($con,"SELECT * FROM usage_day WHERE DATE('$date') = DATE(`date`)");

if (!mysqli_fetch_array($day)) {
	mysqli_query($con,"INSERT INTO `usage_day`(`date`, `avg_power`, `avg_temp`, `avg_temp_out`, `min_ind`, `max_ind`, `consumption`) VALUES (DATE('$date'),$avgPower,$avgTemp,$avgTempOut,$minT,$maxT,$consumption)");
}



?>