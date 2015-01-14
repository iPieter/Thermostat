<?php

include('datalogin.php');

$avg_temp = $_POST['t'];
$avg_power = 20 * $_POST['y'];
$tar = $_POST['tar'];

//get the temperature (T)
$json = file_get_contents('http://api.openweathermap.org/data/2.5/weather?q=gent,be');
$json = json_decode($json);
$T = $json->main->temp;


$sql = "INSERT INTO `history`(P, T_cur, T_tar, T_ext) VALUES ($avg_power,$avg_temp,$tar,$T)";

mysqli_query($con, $sql);
mysqli_close($con);

?>
