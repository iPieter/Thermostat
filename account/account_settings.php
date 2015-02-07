<html>
<head>
	<title>Usage</title>
	<link rel="icon" type="image/png" href="http://thermostat.ipieter.be/images/favicon.png">
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	
	<link rel="stylesheet" type="text/css" href="../css/usage.css">
	<link rel="stylesheet" type="text/css" href="../css/sidebar.css">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

	<script src="http://code.highcharts.com/highcharts.js"></script>
	<script src="http://code.highcharts.com/modules/data.js"></script>
	<script src="http://code.highcharts.com/modules/exporting.js"></script>

	<script src="../js/bootstrap.js"></script>
</head>
<body>

	<?php 
    // First we execute our common code to connection to the database and start the session 
    require("../scripts/common.php"); 
     
    // At the top of the page we check to see whether the user is logged in or not 
    if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page. 
        header("Location: login.php?r=usage.php"); 
         
        // Remember that this die statement is absolutely critical.  Without it, 
        // people can view your members-only content without logging in. 
        die("Redirecting to login.php?r=usage.php"); 
    }
    
	include("../elements/sidebar/sidebar.php");
	?>
	<div id="topbar"> <div class="container"> 
	<div class="row"> 
		<div id="today" class="option col-lg-2 col-lg-offset-1 col-sm-3 selected">General Settings</div>
		<div id="yesterday" class="option col-lg-2 col-sm-3 ">Account & Login</div>
		<div id="this_week" class="option col-lg-2 col-sm-3 ">Devices</div>
		<div id="week" class="option col-lg-2 col-sm-3 ">Linked Accounts</div>
	</div></div></div>
	
	<div id="page" >
		<div class="container">
		</div>
	</div>


<script> 

$(".option").click(function(event) {
    $(".option").removeClass("selected");
    $(this).addClass("selected");
    
    var theId = $(this).attr('id');
});





    </script>
</body> 