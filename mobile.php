<html>
<head>
	<title>Temperature</title>
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:100,300,600' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	
	<link rel="stylesheet" type="text/css" href="css/mobile.css">
	<link rel="stylesheet" type="text/css" href="css/sidebar.css">

<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="viewport"
  content="width=device-width,
  minimum-scale=1.0, maximum-scale=1.0" />
  <meta name="apple-mobile-web-app-status-bar-style" content="#34495e">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="js/bootstrap.js"></script>
</head>
<body>
<div id="wall" class="container-fluid">
	<div class="row">

<?php 

    // First we execute our common code to connection to the database and start the session 
    require("scripts/common.php"); 
     
    // At the top of the page we check to see whether the user is logged in or not 
    if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page. 
        header("Location: account/login.php?r=mobile.php"); 
         
        // Remember that this die statement is absolutely critical.  Without it, 
        // people can view your members-only content without logging in. 
        die("Redirecting to account/login.php?r=mobile.php"); 
    }


include("scripts/datalogin.php"); 
		    
//check the users access level
$username = htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8');

$accesslevel = mysqli_query($con, "SELECT * FROM users WHERE `users`.`username` = '$username';");
$row_accesslevel = mysqli_fetch_array($accesslevel);

if ($row_accesslevel['accesslevel'] == 'viewer') {
        header("Location: mobile_view.php"); 

        die("Redirecting to mobile_view.php"); }


//get the current target temperature
$my_access_token="ed12140a298d303849276bf9f204113269a44f2e";
$my_device="53ff6f065067544809431287";

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

$setpoint = $json->result;

$url="https://api.spark.io/v1/devices/$my_device/mode?access_token=$my_access_token";

curl_setopt($ch, CURLOPT_URL,$url);
$result=curl_exec($ch);
$json = json_decode($result);

$mode = $json->result;

}catch (Exception $e) {
	//include('cron.php');
}

?>


<div class="brickTop"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> Temperature</div>

<div class="col-md-6 "> 
	<div class="brick">
	<div id="temperatureDiv"><div class="tempKol"> <canvas id="tempCanvas" width="292" height="292">
	<!--<img id="tempCircle" src="images/sprites/tempCircle.png" alt="tempCircle"/>-->
		<span id="curTemperature">21</span>°<span id="tens">4</span>
		</canvas>
</div></div></div></div>

	  <div class="col-md-6 "> <div class="brick"><div class="tempKol" id="mode"> 
	<div class="btn-group btn-group-lg settings" id="modes" role="group" aria-label="Mode selector">
		<button type="button" id="btnAway" class="btn btn-default <?php if ($mode == 0) {echo 'active';} ?> "><span class="glyphicon glyphicon-road" aria-hidden="true"></button>
		<button type="button" id="btnHome" class="btn btn-default <?php if ($mode == 1) {echo 'active';}?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></button>
		<button type="button" id="btnSleep" class="btn btn-default <?php if ($mode == 2) {echo 'active';}?>"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></button>
	  </div>
	
	  <div class="input-group settings">
      	<span class="input-group-btn">
        	<button class="btn btn-default heightFix" id="minus" type="button"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>
        </span>
      <input type="number" class="form-control" id="temperature" min="0" max="100" value="<?php echo($setpoint); ?>">
      <span class="input-group-addon">&deg;C</span>
      <span class="input-group-btn">
        	<button class="btn btn-default heightFix" id="plus" type="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
        </span>
    </div>
</div>

</div>
<script>
$("#btnAway").click(function() {
 	doMethod('setMode', "away");
 	$("#btnAway").addClass("active");
 	$("#btnHome").removeClass("active");
 	$("#btnSleep").removeClass("active");
 	$input.val(8);
	redraw(8); 	
});

$("#btnHome").click(function() {
 	doMethod('setMode', "home");
 	$("#btnHome").addClass("active");
 	$("#btnAway").removeClass("active");
 	$("#btnSleep").removeClass("active");
 	$input.val(21);
	redraw(21); 	
});

$("#btnSleep").click(function() {
 	doMethod('setMode', "sleep");
 	$("#btnSleep").addClass("active");
 	$("#btnAway").removeClass("active");
 	$("#btnHome").removeClass("active");
 	$input.val(16);
	redraw(16); 	
});

$input = $("#temperature");
	var canvas = document.getElementById("tempCanvas");
	var context = canvas.getContext("2d");
	
function refreshTarget() {
	
	$.ajax({
	url: 'scripts/get_target.php', 
	data: "", 
	dataType: 'json',
	success: function(data){
			$input.val(data.T);
	        
	        redraw(tarTemp);		

			
	      },
	error: function (request, xhr) {
	}
	});
	
	
}

window.addEventListener("load",function() {
	// Set a timeout...
	setTimeout(function(){
		// Hide the address bar!
		window.scrollTo(0, 1);
	}, 0);
	



	devicePixelRatio = window.devicePixelRatio || 1,
    backingStoreRatio = context.webkitBackingStorePixelRatio ||
                            context.mozBackingStorePixelRatio ||
                            context.msBackingStorePixelRatio ||
                            context.oBackingStorePixelRatio ||
                            context.backingStorePixelRatio || 1,

    ratio = devicePixelRatio / backingStoreRatio;
        
	var oldWidth = canvas.width;
    var oldHeight = canvas.height;

    canvas.width = oldWidth * ratio;
    canvas.height = oldHeight * ratio;
	canvas.style.width = oldWidth + 'px';
    canvas.style.height = oldHeight + 'px';
    context.scale(ratio, ratio);

});


$("#minus").click(function() {

var curValue = parseInt($input.val());

if (curValue > 8) {
 	$input.val((curValue - 1));
 	redraw(curValue - 1);
 	
 	 doMethod('setTarget', curValue - 1);
 	 	
}});

$("#plus").click(function() {
var curValue = parseInt($input.val());
if (curValue < 34) {
 	$input.val((curValue + 1));
 	redraw(curValue + 1);
 	
 	doMethod('setTarget', curValue + 1);
}});

$(window).load(refresh());

var tid = setInterval(refresh, 5000);
var curTemp;

var coreID = '53ff6f065067544809431287';
var apiToken = 'ed12140a298d303849276bf9f204113269a44f2e';

function redraw(tarTemp) {
		
	context.clearRect(0, 0, canvas.width, canvas.height);

    //draw the current temp
	context.beginPath();

	context.fillStyle = '#333';
	context.textAlign = 'center';
	context.font = '50pt Open Sans';
    context.fillText(curTemp + '\xB0', 146, 158);
	
	if (curTemp <= 8) {
	    curTemp = 8;
	} else if (curTemp >= 34){
	    curTemp = 34;
	}
	
	var tarTempAngle = 20/360 * Math.PI * (Math.max(Math.min(tarTemp,34),8) - 30);
    var curTempAngle = 20/360 * Math.PI * (Math.max(Math.min(curTemp,34),8) - 30);
    

	

	context.moveTo(130*Math.cos(curTempAngle) + 146, 130*Math.sin(curTempAngle)+ 146);
	context.lineTo(88*Math.cos(curTempAngle) + 146 ,88*Math.sin(curTempAngle) + 146);
	context.strokeStyle = "#bdc3c7";
	if (curTemp == 8 || curTemp == 34) {
	    context.lineWidth = 7;
	} else {
	    context.lineWidth = 3;
	}
	context.stroke();
	
	//draw the target temp
	context.beginPath();
	context.moveTo(121*Math.cos(tarTempAngle) + 146, 121*Math.sin(tarTempAngle)+ 146);
	context.lineTo(98*Math.cos(tarTempAngle) + 146 ,98*Math.sin(tarTempAngle) + 146);
	if (tarTemp == 8 || tarTemp == 34) {
	    context.lineWidth = 7;
	} else {
	    context.lineWidth = 3;
	}
	
	if ((tarTemp - 0.5) < curTemp &&  curTemp < (tarTemp + 0.5)) {
	context.strokeStyle = "#2ecc71";
	} else {
	context.strokeStyle = "#e67e22";
	}
	
	context.stroke();
	
}

var baseURL = "https://api.spark.io/v1/devices/";

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

function refresh() {
	
	$.ajax({
	url: 'scripts/get_temperature.php', 
	data: "", 
	dataType: 'json',
	success: function(data){
			var tarTemp = parseInt($input.val());
	        curTemp = parseFloat(data.T);
	        
	        redraw(tarTemp);		
			
			usageChart.addData([Math.round(20*data.dutyCycle)], getTime());
			usageChart.removeData();
			
	      },
	error: function (request, xhr) {
	    context.clearRect(0, 0, canvas.width, canvas.height);
	  	context.font = '50pt Open Sans';
	    context.fillText( ":'(", 146, 160);
	}
	});
	
	
}

function refreshTarget() {
	
	$.ajax({
	url: 'scripts/get_target.php', 
	data: "", 
	dataType: 'json',
	success: function(data){
			$input.val(data.T);
	        
	        redraw(tarTemp);		

			
	      },
	error: function (request, xhr) {
	}
	});
	
	
}

function getTime() {
    var now     = new Date(); 
    var hour    = now.getHours();
    var minute  = now.getMinutes();
    var second  = now.getSeconds(); 
        if(hour.toString().length == 1) {
        var hour = '0'+hour;
    }
    if(minute.toString().length == 1) {
        var minute = '0'+minute;
    }
    if(second.toString().length == 1) {
        var second = '0'+second;
    }   
    var dateTime = hour+':'+minute+':'+second;   
     return dateTime;
}


 function onMethodSuccess() {

  }

  function onMethodFailure() {
    
  }

</script>
</body>