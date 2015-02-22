<?php 
include("scripts/datalogin.php"); 
		    
//check the users access level
$username = htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8');

$accesslevel = mysqli_query($con, "SELECT * FROM users WHERE `users`.`username` = '$username';");
$row_accesslevel = mysqli_fetch_array($accesslevel);

if ($row_accesslevel['accesslevel'] == 'viewer') {
	header("Location: account/login.php?r=index.php"); 

	die("Redirecting to account/login.php?r=index.php"); 
}

$user_id = $row_accesslevel['id'];

$device = mysqli_query($con, "SELECT * FROM devices WHERE `devices`.`user_id` = $user_id;");
$row_device = mysqli_fetch_array($device);


//get the current target temperature
$my_device=$row_device['spark_id'];
?>

<div class="brickTop"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> Temperature</div>
<div id="temperatureDiv"><div class="tempKol"> <canvas id="tempCanvas" width="292" height="292">
	<!--<img id="tempCircle" src="images/sprites/tempCircle.png" alt="tempCircle"/>-->
	<span id="curTemperature">21</span>°<span id="tens">4</span>
</canvas>
</div>

<div class="tempKol" id="mode"> 
	  <div class="settings">
		  <h1><?php echo $row_device['location_name'];?></h1>

    </div>
    
	<div class="btn-group btn-group-lg settings" id="modes" role="group" aria-label="Mode selector">

		<button type="button" id="btn4" class="btn btn-default"><span class="glyphicon glyphicon-ice-lolly-tasted" aria-hidden="true"></button>
		<button type="button" id="btn1" class="btn btn-default"><span class="glyphicon glyphicon-road" aria-hidden="true"></button>
		<button type="button" id="btn2" class="btn btn-default"><span class="glyphicon glyphicon-home" aria-hidden="true"></button>
		<button type="button" id="btn3" class="btn btn-default"><span class="glyphicon glyphicon-bed" aria-hidden="true"></button>
	  </div>
	  
	  <div class="input-group settings">
      	<span class="input-group-btn">
        	<button class="btn btn-default heightFix" id="minus" type="button"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>
        </span>
      <input type="number" class="form-control" id="temperature" min="0" max="100" value="<?php echo($setpoint); ?>">
      <span class="input-group-addon">&degC</span>
      <span class="input-group-btn">
        	<button class="btn btn-default heightFix" id="plus" type="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
        </span>
    </div>
</div>

</div>

<script>

$("#btn1").click(function() {
 	doMethod('setMode', "away");
 	$(".btn").removeClass("active");
 	$("#btn1").addClass("active");
 	$input.val(14);
	redraw(14);	
});

$("#btn2").click(function() {
 	doMethod('setMode', "home");
 	$(".btn").removeClass("active");
 	$("#btn2").addClass("active");
  	$input.val(21);
	redraw(21);	
});

$("#btn3").click(function() {
 	doMethod('setMode', "sleep");
 	$(".btn").removeClass("active");
 	$("#btn3").addClass("active");
 	$input.val(18);
	redraw(18); 	
});

$("#btn4").click(function() {
 	doMethod('setMode', "freeze");
 	$(".btn").removeClass("active");
 	$("#btn4").addClass("active");
 	$input.val(8);
	redraw(8);	
});

$input = $("#temperature");

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

$(window).load(function() {
refresh();
refreshTarget();
});

var tid = setInterval(refresh, 5000);
var curTemp;

var coreID = '53ff6f065067544809431287';
var apiToken = 'ed12140a298d303849276bf9f204113269a44f2e';
var canvas = document.getElementById("tempCanvas");
var context = canvas.getContext("2d");

function redraw(tarTemp) {
		
	var tarTempAngle = 20/360 * Math.PI * (Math.max(Math.min(tarTemp,34),8) - 30);
    var curTempAngle = 20/360 * Math.PI * (Math.max(Math.min(curTemp,34),8) - 30);
    
    context.clearRect(0, 0, canvas.width, canvas.height);

    //draw the current temp
	context.beginPath();
	

	context.moveTo(130*Math.cos(curTempAngle) + 146, 130*Math.sin(curTempAngle)+ 146);
	context.lineTo(88*Math.cos(curTempAngle) + 146 ,88*Math.sin(curTempAngle) + 146);
	context.strokeStyle = "#bdc3c7";
	if (curTemp <= 8 || curTemp >= 34) {
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
	
	context.fillStyle = '#333';
	context.textAlign = 'center';
	context.font = '50pt Open Sans';
    context.fillText(curTemp + '°', 146, 160);
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
	type: "GET",
    data: {device: '<?php echo $row_device['spark_id'];?>'},
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
	    context.textAlign = 'center';
	  	context.font = '50pt Open Sans';
	    context.fillText( ":'(", 146, 160);
	}
	});
	
	
}

function refreshTarget() {
	
	$.ajax({
	url: 'scripts/get_target.php', 
	type: "GET",
    data: {device: '<?php echo $row_device['spark_id'];?>'},
	dataType: 'json',
	success: function(data){
			$input.val(data.T);
	        
	        //also set the right modes
	         	$(".btn").removeClass("active");
	         	$("#btn" + (data.mode + 1)).addClass("active");
	        
	        redraw(tarTemp);		

			
	      },
	error: function (request, xhr) {
	    context.clearRect(0, 0, canvas.width, canvas.height);
	    context.textAlign = 'center';
	  	context.font = '50pt Open Sans';
	    context.fillText( ":'(", 146, 160);
	  	context.font = '14pt Open Sans';

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