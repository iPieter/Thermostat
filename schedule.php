<html>
<head>
	<title>Schedule</title>
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:100,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	
	<link rel="stylesheet" type="text/css" href="css/schedule.css">
	<link rel="stylesheet" type="text/css" href="css/sidebar.css">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="js/bootstrap.js"></script>
</head>
<body>

	<?php 

		//include("scripts/datalogin.php"); 
		
    // First we execute our common code to connection to the database and start the session 
    require("scripts/common.php"); 
     
    // At the top of the page we check to see whether the user is logged in or not 
    if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page. 
        header("Location: account/login.php?r=schedule.php"); 
         
        // Remember that this die statement is absolutely critical.  Without it, 
        // people can view your members-only content without logging in. 
        die("Redirecting to account/login.php?r=schedule.php"); 
    }
    
	include("elements/sidebar/sidebar.php"); ?>

<div id="schedule" class="container-fluid">
	<div class="row">

		<div class="col-md-12" id="selectDay"> <div class="brick">
			<div class="btn-group btn-group settings" id="modes" role="group" aria-label="Mode selector">

				<button type="button" id="btnAway" class="btn btn-default ">Mo</button>
				<button type="button" id="btnHome" class="btn btn-default ">Tu</button>
				<button type="button" id="btnSleep" class="btn btn-default ">We</button>
				<button type="button" id="btnAway" class="btn btn-default ">Th</button>
				<button type="button" id="btnHome" class="btn btn-default ">Fr</button>
				<button type="button" id="btnSleep" class="btn btn-default ">Sa</button>
				<button type="button" id="btnAway" class="btn btn-default ">Su</button>
			</div>
		</div></div>
	</div>
	<div class="row">
	  <div class="col-md-4"> <div class="brick">.col-md-3</div></div>
	  <div class="col-md-4 "> <div class="brick">.col-md-3</div></div>
	  <div class="col-md-4 "> <div class="brick">.col-md-2</div></div>
	</div>
	<div class="row">
	  <div class="col-md-6 "> <div class="brick">.col-md-4</div></div>
	  <div class="col-md-6 "> <div class="brick">.col-md-3</div></div>
	</div>
</div>
</div>

</body> 