<html>
<head>
	<title>Alarm Clock</title>
	<link rel="icon" type="image/png" href="http://thermostat.ipieter.be/images/favicon.png">
	<meta name="apple-mobile-web-app-capable" content="yes" />

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/alarm.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/sidebar.css">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	
	<script src="js/bootstrap.js"></script>

</head>
<body>

	<?php 
    // First we execute our common code to connection to the database and start the session 
    require("scripts/common.php"); 
    require("scripts/datalogin.php"); 
     
    // At the top of the page we check to see whether the user is logged in or not 
    if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page. 
        header("Location: account/login.php?r=alarm.php"); 
         
        // Remember that this die statement is absolutely critical.  Without it, 
        // people can view your members-only content without logging in. 
        die("Redirecting to account/login.php?r=alarm.php"); 
    }
    	
    //check the users access level
	$accesslevel = mysqli_query($con, "SELECT * FROM users WHERE `users`.`username` = '$username';");
	$row_accesslevel = mysqli_fetch_array($accesslevel);
	
	if ($row_accesslevel['accesslevel'] == 'viewer') {
        header("Location: index.php"); 

        die("Redirecting to index.php"); 
     }

	include("elements/sidebar/sidebar.php");
    
	?>
	<div class="page">


    <div class="input-group">
      <input type="number" class="form-control" id="day" placeholder="day" aria-describedby="day">
      <span class="input-group-addon" id="txt-day">day</span>
      <input type="number" class="form-control" id="hour" placeholder="hour" aria-describedby="hour">
      <span class="input-group-addon" id="txt-hour">h</span>
      <input type="number" class="form-control" id="minute" placeholder="minute" aria-describedby="minute">
      <span class="input-group-addon" id="txt-minute">m</span>
      <span class="input-group-btn">
        <button class="btn btn-default" id="submit" type="button">Go!</button>
      </span>
	</div></div>
<script> 

var coreID = '53ff6f065067544809431287';
var apiToken = 'ed12140a298d303849276bf9f204113269a44f2e';
var baseURL = "https://api.spark.io/v1/devices/";

$("#submit").click(function(event) {
	var timeMinutes = ($("#day").val()-1)*24*60 + $("#hour").val()*60 + $("#minute").val()*1;
	alert(timeMinutes);
});

function doMethod(method, data) {
    var url = baseURL + coreID + "/" + method;
    $.ajax({
      type: "POST",
      url: url,
      data: { access_token: apiToken, args: data },
      success: onMethodSuccess,
      dataType: "json"
    }).fail(function(obj) {
      onMethodFailure();
    });
  }
  
</script>
</body> 