<script>


$(document).ready(function () {

	 $('.dropdown-toggle').dropdown();
});

</script>

<div id="sidebar">

	<div id="user">
		<?php 
		//get the username and image from the current user
		$baseurl = "http://thermostat.ipieter.be/";
		
		$username = htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8');
		$image = $baseurl. "images/users/". $username . ".jpg";
		
		echo "<div id='avatar'> <img src=". $image ." alt=". $username ."/> </div>";
		echo "		<div class='dropdown'><a role='button' href='#'  data-toggle='dropdown' class='dropdown-toggle'> <div id='username'>  <span class='text'> $username </span>";
		
		function curPageName() {
			return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
		}

		
		?>
		<span class="glyphicon glyphicon-chevron-down"></span></div> </a> 
		

		  	<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $baseurl?>account/account_settings.php" data-target="#">User settings</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $baseurl?>account/wall_layout.php" data-target="#">Customize wall</a></li>

		    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Help and support</a></li>
		    <li role="presentation" class="divider"></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $baseurl?>account/logout.php" data-target="#">Log out</a></li>
		  </ul>
		</div>
		
	</div>
	
	<hr> 
	<! -- NAVIGATION -->
	
	<div class="navigation">
		<ul class="nav nav-pills  nav-stacked">
			<li <?php if (curPageName() == "index.php") {echo "class='active'";} ?> ><a href="<?php echo $baseurl?>" data-target="#"><span class="glyphicon glyphicon-th-large"></span> Dashboard</a></li>
			<li <?php if (curPageName() == "schedule.php") {echo "class='active'";} ?>> <a href="<?php echo $baseurl?>schedule.php" data-target="#"><span class="glyphicon glyphicon-calendar"></span> Schedule</a></li>
			<hr>
			<li class="device">Thermostat</li>
			<li <?php if (curPageName() == "usage.php") {echo "class='active'";} ?>><a href="<?php echo $baseurl?>usage.php" data-target="#"><span class="glyphicon glyphicon-stats"></span> Usage</a></li>
			<hr>
			<li class="device">Alarm Clock</li>
			<li <?php if (curPageName() == "alarm.php") {echo "class='active'";} ?>><a href="<?php echo $baseurl?>alarm.php" data-target="#"><span class="glyphicon glyphicon-time"></span> Alarm</a></li>
			<hr>
		</ul>
	</div>
	
 
	<! -- BRICKS -->
	
	
</div>