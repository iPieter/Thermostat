<?php
$calendar = $_POST['inputWebcal'];
$offset = $_POST['inputOffset'];
$userId = $_POST['userId'];

include('datalogin.php');



//for now, we assume a webdav is already linked
//write everything in the database
//assume only one calender for each user


//return  everything ok
$replacedValues = array('webdav://', 'webcal://');
if (isDomainAvailible(str_replace($replacedValues, 'http://', $calendar))) {
	$d = array('cal' => true, 'offset' => true);
	
	$sql = "UPDATE alarm_calendars SET url='$calendar' WHERE user_id=$userId";
	
	mysqli_query($con, $sql);
} else {
	$d = array('cal' => false, 'offset' => true);

}

mysqli_close($con);

echo json_encode($d);

function isDomainAvailible($domain)
{
	//check, if a valid url is provided
	if(!filter_var($domain, FILTER_VALIDATE_URL))
	{
		return false;
	}
	
	//initialize curl
	$curlInit = curl_init($domain);
	curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
	curl_setopt($curlInit,CURLOPT_HEADER,true);
	curl_setopt($curlInit,CURLOPT_NOBODY,true);
	curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);
	
	//get answer
	$response = curl_exec($curlInit);
	
	curl_close($curlInit);
	
	if ($response) return true;
	
	return false;
}