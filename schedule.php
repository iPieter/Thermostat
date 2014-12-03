<html>
<head>
	<title>Schedule</title>
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:100,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	
	<link rel="stylesheet" type="text/css" href="css/wall.css">
	<link rel="stylesheet" type="text/css" href="css/topbar.css">
	<link rel="stylesheet" type="text/css" href="css/sidebar.css">

	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="js/bootstrap.js"></script>
</head>
<body>

	<?php 
    // First we execute our common code to connection to the database and start the session 
    require("scripts/common.php"); 
     
    // At the top of the page we check to see whether the user is logged in or not 
    if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page. 
        header("Location: account/login.php"); 
         
        // Remember that this die statement is absolutely critical.  Without it, 
        // people can view your members-only content without logging in. 
        die("Redirecting to account/login.php"); 
    }
    
	include("elements/sidebar/sidebar.php");
	include("elements/topbar/topbar.php"); ?>

</body> 