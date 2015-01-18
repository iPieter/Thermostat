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
      
      $data[] = array( $time_raw,round($r['T_cur'],1)); 
      $data2[] = array( $time_raw,round($r['T_tar'],1)); 
      $data4[] = array( $time_raw,round($r['P'],1)); 
      $tExt = round($r['T_ext'] -273.15,1);
      $data3[] = array( $time_raw,$tExt); 
      
      //calculcate min and max temp
      if ($maxT < round($r['T_cur'],1)) {
	      $maxT = round($r['T_cur'],1);
      }
      
      if ($minT > round($r['T_cur'],1)) {
	      $minT = round($r['T_cur'],1);
      }
      
      if ($maxTOut < $tExt) {
	      $maxTOut = $tExt;
      }
      
      if ($minTOut > $tExt) {
	      $minTOut = $tExt;
      }

      //calculate average power
      $consumption += $r['P'] * ($time_raw - $lastTime)/ 3600000000;
      $lastTime = $time_raw;
    }
    
    
$stats = array('minT' => $minT,'maxT' => $maxT,'cons' => round($consumption,1),'minTOut' => $minTOut,'maxTOut' => $maxTOut);
$table = array('cur' => $data,'tar' => $data2,'out' => $data3,'duty' => $data4,'stats' => $stats);
// convert data into JSON format
$jsonTable = json_encode($table);
echo $jsonTable;


?>