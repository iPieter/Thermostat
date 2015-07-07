<script>


$(document).ready(function () {

	 $('.dropdown-toggle').dropdown();
});

</script>

<div id="sidebar">

	<div id="user">
		<?php 
		require_once("sidebarItem.class.php");
		//get the username and image from the current user
		$baseurl = "http://thermostat.ipieter.be/";
		
		
		
		$username = htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8');
		$image = $baseurl. "images/users/". $username . ".jpg";
		
		echo "<div id='avatar'> <img src=". $image ." alt=". $username ."/> </div>";
		echo "		<div class='dropdown'><a role='button' href='#'  data-toggle='dropdown' class='dropdown-toggle'> <div id='username'>  <span class='text'> $username </span>";
		
		
		$current = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
		

		
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
			<li <?php if ($current == "index.php") {echo "class='active'";} ?> ><a href="<?php echo $baseurl?>" data-target="#"><span class="glyphicon glyphicon-th-large"></span> Dashboard</a></li>
			<?php 
			if ($user->hasAccess('thermostat')) {
				echo "<hr>";
				echo "<li class='device'>Thermostat</li>";
				$shedule = new SidebarItem("Schedule", "calendar", "schedule.php");
				$thermostat = new SidebarItem("Usage", "stats", "usage.php");
				echo ($shedule->getHTML($baseurl, $current));
				echo ($thermostat->getHTML($baseurl, $current));
			}
			if ($user->hasAccess('alarm')) {
				echo "<hr>";
				echo "<li class='device'>Alarm Clock</li>";
				$time = new SidebarItem("Alarm", "time", "alarm.php");
				echo ($time->getHTML($baseurl, $current));
			}
			if ($user->hasAccess('administration')) {
				echo "<hr>";
				echo "<li class='device'>Administration</li>";
				$archive = new SidebarItem("Digital Archive", "briefcase", "administration.php");
				$users = new SidebarItem("Users", "user", "users.php");
				echo ($archive->getHTML($baseurl, $current));
				echo ($users->getHTML($baseurl, $current));


			}
			?>
			<hr>
		</ul>
	</div>
	
 	
	
</div>