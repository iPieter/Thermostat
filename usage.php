<html>
<head>
	<title>Dashboard</title>
	<link rel="icon" type="image/png" href="http://thermostat.ipieter.be/images/favicon.png">
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	
	<link rel="stylesheet" type="text/css" href="css/usage.css">
	<link rel="stylesheet" type="text/css" href="css/sidebar.css">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

	<script src="http://code.highcharts.com/highcharts.js"></script>
	<script src="http://code.highcharts.com/modules/data.js"></script>
	<script src="http://code.highcharts.com/modules/exporting.js"></script>

	<script src="js/bootstrap.js"></script>
	<script src="js/chart.js"></script>
</head>
<body>

	<?php 
    // First we execute our common code to connection to the database and start the session 
    require("scripts/common.php"); 
     
    // At the top of the page we check to see whether the user is logged in or not 
    if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page. 
        header("Location: account/login.php?r=usage.php"); 
         
        // Remember that this die statement is absolutely critical.  Without it, 
        // people can view your members-only content without logging in. 
        die("Redirecting to account/login.php?r=usage.php"); 
    }
    
	include("elements/sidebar/sidebar.php");
	?>
	<div id="topbar"> <div class="container"> 
	<div class="row"> 
		<div id="today" class="option col-lg-1 col-lg-offset-2 col-sm-2 selected">Today</div>
		<div id="yesterday" class="option col-lg-1 col-sm-2 ">Yesterday</div>
		<div id="this_week" class="option col-lg-1 col-sm-2 ">This week</div>
		<div id="week" class="option col-lg-1 col-sm-2 ">Last week</div>
		<div id="this_month" class="option col-lg-1 col-sm-2 ">This month</div>
		<div id="month" class="option col-lg-1 col-sm-2 ">Last month</div>
	</div></div></div>
	
	<div id="page" >
		<div class="container">
			<?php include("scripts/usage.php");?>
		</div>
	</div>


<script> 
var tempchart, dutychart; 
var tid = setInterval(requestData, 300000);

$(".option").click(function(event) {
    $(".option").removeClass("selected");
    $(this).addClass("selected");
    
    var theId = $(this).attr('id');
    requestData(theId);
});


function requestData(date){
    $.ajax({
    url: 'http://thermostat.ipieter.be/scripts/get_usage_temp_graph.php',
	dataType: 'json',
	data: {'date': date},
	type: 'GET',
	success: function(data){
           tempchart.series[2].setData(data['cur']);		
           tempchart.series[1].setData(data['tar']);		
           tempchart.series[0].setData(data['out']);
           dutychart.series[0].setData(data['duty']);
           $("#inTemp").html(data['stats']['minT'] + "&deg<div class='slash'>/</div>" + data['stats']['maxT'] + "&deg");		
           $("#outTemp").html(data['stats']['minTOut'] + "&deg<div class='slash'>/</div>" + data['stats']['maxTOut'] + "&deg");		

           $("#cons").html(data['stats']['cons'] + " kWh");		
			
	      },
	error: function (request, xhr) {
	}
	});
}

/*
function requestData2(date){
    $.ajax({
    url: 'http://thermostat.ipieter.be/scripts/get_usage_duty_graph.php',
	dataType: 'json',
	data: {'date': date},
	type: 'GET',
	success: function(data){
           dutychart.series[0].setData(data['duty']);	
			
	      },
	error: function (request, xhr) {
	}
	});
}
*/


$(document).ready(function() {
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });
tempchart = new Highcharts.Chart({
     chart: {
        renderTo: 'tempHistDiv',
        type: 'spline',

     },
     exporting: { enabled: false },
     
     title: {
         text: '',
         style: {
             display: 'none'
         }
     },
     subtitle: {
         text: '',
         style: {
             display: 'none'
         }
     },
     xAxis: {
        type: 'datetime',

     },
     yAxis: {
        minPadding: 0.0,
            maxPadding: 0.0,
            title: {
                text: 'Temperature (°C)',
                margin: 10
            }
     },
     series: [{
        name: 'Outdoors',
        color: 'rgb(230, 126, 34)',        
        data: [],
            marker: {
       enabled: false
    }
     },{
        name: 'Target',
        color: 'rgb(189, 195, 199)',        
        data: [],
            marker: {
       enabled: false
    }
     },{
        name: 'Indoors',
        color: 'rgb(52, 73, 94)',
        data: [],
            marker: {
       enabled: false
    }
     }]
  });
  
  dutychart = new Highcharts.Chart({
     chart: {
        renderTo: 'dutyHistDiv',
        type: 'spline',
        events: {
            load: requestData('today')
        }
     },
     exporting: { enabled: false },
     
     title: {
         text: '',
         style: {
             display: 'none'
         }
     },
     subtitle: {
         text: '',
         style: {
             display: 'none'
         }
     },
     xAxis: {
        type: 'datetime',

     },
     yAxis: {
     min: 0, max:2000,
        minPadding: 0.0,
            maxPadding: 0.0,
            title: {
                text: 'Power (W)',
                margin: 10
            }
     },
     series: [{
        name: 'Duty Cycle',
        color: 'rgb(52, 73, 94)',
        data: [],    marker: {
       enabled: false
    }
     }]
  });

  });
    </script>
</body> 