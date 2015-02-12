<html>
<head>
	<title>Usage</title>
	<link rel="icon" type="image/png" href="http://thermostat.ipieter.be/images/favicon.png">
	<meta name="apple-mobile-web-app-capable" content="yes" />

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	
	<link rel="stylesheet" type="text/css" href="css/usage.css">
	<link rel="stylesheet" type="text/css" href="css/sidebar.css">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

	<script src="http://code.highcharts.com/highcharts.js"></script>
	<script src="http://code.highcharts.com/modules/data.js"></script>

	<script src="http://code.highcharts.com/highcharts-more.js"></script>
	
	<script src="js/bootstrap.js"></script>
	<script src="js/chart.js"></script>
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
        header("Location: account/login.php?r=usage.php"); 
         
        // Remember that this die statement is absolutely critical.  Without it, 
        // people can view your members-only content without logging in. 
        die("Redirecting to account/login.php?r=usage.php"); 
    }
    
	include("elements/sidebar/sidebar.php");
	
	//get all the devices the user gets access to
	$user = mysqli_query($con,"SELECT id FROM users WHERE username = '$username' ");
	$userRow = mysqli_fetch_array($user);
	
	$devices = mysqli_query($con,"SELECT * FROM devices WHERE user_id = " . $userRow['id']);
	
	$devicelist = "";
	
    foreach($devices as $deviceRow) {
    	$devicelist =$devicelist . '<li role="presentation"><a role="menuitem" id='. $deviceRow['spark_id'] .' class="selector device" tabindex="-1" href="#">'. $deviceRow['location_name'] .'</a></li>'; 
    }
    
	?>
	<div class="page">
	<div class="container">
		
		<div class="dropdown date">
		<a role='button' href='#'  data-toggle='dropdown' class='dropdown-toggle'>
		<h1 id="month">January</h1><h1><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>  </h1>  </a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
		    <li role="presentation"><a class="selector month" role="menuitem" tabindex="-1" href="#">January</a></li>
		    <li role="presentation"><a class="selector month" role="menuitem" tabindex="-1" href="#">February</a></li>
		  </ul>
		</div>
		
		<div class="dropdown date">
		<a role='button' href='#'  data-toggle='dropdown' class='dropdown-toggle'>
		<h1 id="year">2015</h1><h1><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span> </h1>  </a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu2">
		    <li role="presentation"><a class="selector year" role="menuitem" tabindex="-1" href="#">2015</a></li>
		  </ul>
		</div>
		
		<div class="dropdown">
		<a role='button' href='#'  data-toggle='dropdown' class='dropdown-toggle'>
		<h2 id="device">All Devices</h2> <h2> <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span> </h2>  </a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu3">
		    <li role="presentation"><a role="menuitem" class="selector device" tabindex="-1" href="#">All Devices</a></li>
		    <li role="presentation" class="divider"></li>
		    <?php 
		    //list all the devices the user gets access to
		    	echo $devicelist;
		    ?>
		  </ul>
		</div>
		
		
	<div class="row statrow">
		<div class="stat col-sm-4">
		      <div class="padFix">
		      	<h4><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Indoors</h4>
		      	<div class="value" id="inTemp"></div>
		</div></div>
		<div class="stat col-sm-4 ">
		      <div class="padFix">
		      	<h4><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> Energy</h4>
		      	<div class="value" id="energy"></div>
		</div></div>
		<div class="stat col-sm-4">
		      <div class="padFix">
		      	<h4><span class="glyphicon glyphicon-tree-deciduous" aria-hidden="true"></span> Outdoors</h4>
		      	<div class="value" id="outTemp"></div>
		</div></div>
	</div>
					
	</div></div>	
	<div id="topbar"> <div class="container"> 
	<div class="row"> 
		<div id="statistics" class="option col-lg-2 col-lg-offset-2 col-sm-3 selected">Statistics</div>
		<div id="power" class="option col-lg-2 col-sm-3 ">Power Usage</div>
		<div id="devices" class="option col-lg-2 col-sm-3 ">Devices</div>
		<div id="history" class="option col-lg-2 col-sm-3 ">History</div>
	</div></div></div>
	
	<div id="page" class="page">
		<div class="container">
			<?php include("scripts/usage.php");?>
		</div>
	</div>


<script> 
var tempchart, dutychart; 


var tid = setInterval(requestData, 300000);

$(window).load(function() {
    $(".usage").addClass("hidden");
    $("." + $(".selected").attr('id')).removeClass("hidden");

});


$(".option").click(function(event) {
    $(".option").removeClass("selected");
    $(this).addClass("selected");

    $(".usage").addClass("hidden");
    $("." + $(this).attr('id')).removeClass("hidden");

});


$(".selector").click(function(event) {
	if ($(this).hasClass('month')) {
		$('#month').html($(this).html());
		
	} else if ($(this).hasClass('year')) {
		$('#year').html($(this).html());
	} else if ($(this).hasClass('device')) {
		$('#device').html($(this).html());
	}
    
    requestData();
});

function requestData(){
    $.ajax({
    url: 'http://thermostat.ipieter.be/scripts/get_usage_month.php',
	dataType: 'json',
	data: {'month': $('#month').html(), 'year': $('#year').html()},
	type: 'GET',
	success: function(data){
           tempchart.series[0].setData(data['ind']);		
           tempchart.series[1].setData(data['ind_range']);		
           tempchart.series[2].setData(data['out']);
           dutychart.series[0].setData(data['duty']);	
           
           $("#energy").html(data['stats']['energy'] + " <div class='slash'>kWh</div>");		
           $("#inTemp").html(data['stats']['minT'] + " <div class='slash'>&degC/</div>" + data['stats']['maxT'] + " <div class='slash'>&degC</div>");		
           $("#outTemp").html(data['stats']['minTOut'] + " <div class='slash'>&degC/</div>" + data['stats']['maxTOut'] + " <div class='slash'>&degC</div>");		
			
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
     credits: {
    enabled: false
    },
     
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
     tooltip: {
            crosshairs: true,
            shared: true,
            valueSuffix: '°C'
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
        name: 'Indoors',
        color: 'rgb(52, 73, 94)',
        data: [],
            marker: {
       enabled: false
    }
    },{
        name: 'Indoor Range',
        color: 'rgb(41, 128, 185)',        
        data: [],
        type: 'arearange',          
        lineWidth: 0,
        linkedTo: ':previous',
        fillOpacity: 0.3,
        marker: {
       enabled: false
    }
     },{
        name: 'Outdoors',
        color: 'rgb(230, 126, 34)',        
        data: [],
            marker: {
       enabled: false
    }
     }
     ]
  });
  
  dutychart = new Highcharts.Chart({
     chart: {
        renderTo: 'dutyHistDiv',
        type: 'spline',
        events: {
            load: requestData()
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
     credits: {
    enabled: false
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