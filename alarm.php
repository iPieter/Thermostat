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
    if(empty($_SESSION['user'])) { 
        // If they are not, we redirect them to the login page. 
        header("Location: account/login.php?r=alarm.php"); 
         
        // Remember that this die statement is absolutely critical.  Without it, 
        // people can view your members-only content without logging in. 
        die("Redirecting to account/login.php?r=alarm.php"); 
    }
    require_once("model/Alarm.model.php");	
    require_once("controllers/AlarmManager.class.php");
    require_once("model/User.model.php");
    require_once("model/Model.php");

    //make the alarm and user objects
    $username = htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8');
    $model = new Model();
    $user = new User($username, $model);
    
    //check the users access level
	
	/*if (!($user->hasAccess('alarm'))) {
        header("Location: index.php"); 

        die("Redirecting to index.php"); 
     }*/
     
    //$alarmManager() = new AlarmManager($user);

    
    
    
	include("elements/sidebar/sidebar.php");
    
	?>
	<div class="page">
		<div id="menubar"> <div class="container"> 
			<div class="row"> 
				<div id="devices" class="option col-lg-3 col-lg-offset-1-5 col-sm-4 selected">Alarm Clocks</div>
				<div id="analysis" class="option col-lg-3 col-sm-4 ">Sleep Analysis</div>
				<div id="settings" class="option col-lg-3 col-sm-4 ">Settings</div>
			</div>
		</div></div>
		
		<div id="wall" class="container-fluid">
			<div class="alarm devices">
				<?php include("elements/alarm/alarms.php");?>
			</div>
			
			<div class="alarm analysis">
				<?php include("elements/alarm/analysis.php");?>

			</div>
			
			<div class="alarm settings">
				<?php include("elements/alarm/settings.php");?>
			</div>
		</div>	
	</div>
<script> 

$(window).load(function() {
    $(".alarm").addClass("hidden");
    $("." + $(".selected").attr('id')).removeClass("hidden");

});

$(".option").click(function(event) {
    $(".option").removeClass("selected");
    $(this).addClass("selected");

    $(".alarm").addClass("hidden");
    $("." + $(this).attr('id')).removeClass("hidden");

});

var tid = setInterval(refresh, 2000);

function refresh() {
	
	$.ajax({
	url: 'scripts/get_acceleration.php',
	type: "GET",
    data: {device: '53ff6f065067544809431287'},
	dataType: 'json',
	success: function(data){
			$("#x").html(data.x);
			$("#y").html(data.y);
			$("#z").html(data.z);
			
	      },
	error: function (request, xhr) {
	}
	});
	
	
}  
</script>
</body> 