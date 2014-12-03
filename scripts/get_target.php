<?php

include('datalogin.php');
$my_access_token="ed12140a298d303849276bf9f204113269a44f2e";
$my_device="53ff6f065067544809431287";

$max_samples = 10;
$maxU = 3.3;
$bits = 4096;


try {        
//get the measured sum 
//Warning: BLACK MAGIC, DO NOT TOUCH!
$url="https://api.spark.io/v1/devices/$my_device/setpoint?access_token=$my_access_token";

//  Initiate curl
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
$result=curl_exec($ch);

$json = json_decode($result);
$target = $json->result;



//encode to json and show on the page
$d = array('T' => $target);

echo json_encode($d);
}

catch (Exception $e) {
	//include('cron.php');
}
//write everything in the database
//$sql = "INSERT INTO sensor_values (U1, P) VALUES ($U1, '$P')";

//mysqli_query($con, $sql);
//mysqli_close($con);

?>