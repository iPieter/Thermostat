<?php
include("datalogin.php");

if (isset($_GET['date'])) {

switch ($_GET['date']) {
	case 'today': 
		$date = date("Y-m-d");
		$date2 = date("Y-m-d"); break;
	case 'yesterday': 
		$date = date("Y-m-d", time() - 24*60*60);
		$date2 = date("Y-m-d", time() - 24*60*60); break;
	case 'this_week': 
		$date = date("Y-m-d");
		$date2 = date("Y-m-d"); break;			
		case 'week': 
		$date = date("Y-m-d", time() - 7*24*60*60);
		$date2 = date("Y-m-d"); break;	
}

} else {

	$date = date("Y-m-d");
	$date2 = date("Y-m-d");
	$interval =0;

}

$result = mysqli_query($con,"SELECT * FROM history WHERE DATE('$date') <= DATE(`time`) AND DATE(`time`) <= DATE('$date2')");


$data = array();
$data2 = array();
$data3 = array();
$data4 = array();
$minT = 100;
$maxT = 0;
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
      $tcur = $r['T_cur'];
      $ttar = $r['T_tar'];
      $power = $r['P'];
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

      //calculate average power
      $consumption += $power * ($time_raw - $lastTime)/ 3600000000;
      $lastTime = $time_raw;
    }
    
$rmse = 1-sqrt($rmse/$rmsecount)/($maxT - $minT);
    
$stats = array('minT' => $minT,'maxT' => $maxT,'cons' => round($consumption,1),'minTOut' => $minTOut,'maxTOut' => $maxTOut, 'rmse' => round($rmse*100,1));
$table = array('cur' => $data,'tar' => $data2,'out' => $data3,'duty' => $data4,'stats' => $stats);
// convert data into JSON format
$jsonTable = json_encode($table);
echo $jsonTable;


?>