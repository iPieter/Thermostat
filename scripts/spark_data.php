<?php

include('datalogin.php');

$avg_temp = $_GET['t'];
$avg_power = 20 * $_GET['y'];
$tar = $_GET['tar'];
$id = $_GET['id'];
$mode = $_GET['mode'];

//get the temperature (T)
$json = file_get_contents('http://api.openweathermap.org/data/2.5/weather?q=gent,be');
$json = json_decode($json);
$T = $json->main->temp;

$sql = "INSERT INTO `history`(P, T_cur, T_tar, T_ext, device_id, mode) VALUES ($avg_power,$avg_temp,$tar,$T,'$id',$mode)";

mysqli_query($con, $sql);
mysqli_close($con);

?>
