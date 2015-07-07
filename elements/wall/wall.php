<div id="wall" class="container-fluid">
	<div class="row">
		<?php 
		    include("scripts/datalogin.php"); 
		    
		    //check the users access level
		    $accesslevel = mysqli_query($con, "SELECT * FROM users WHERE `users`.`username` = '$username';");
		    $row_accesslevel = mysqli_fetch_array($accesslevel);

		    if ($row_accesslevel['accesslevel'] == 'admin') {
			    $include = 'bricks/adjust_temp.php';
		    } else if ($row_accesslevel['accesslevel'] == 'viewer') {
			    $include = 'bricks/adjust_temp_viewer.php';			    
		    }
		    
		    
		    ?>
		    		
		<div class="col-md-6"> <div class="brick"><?php include($include) ?></div></div>
		<div class="col-md-6"> <div class="brick">Today's schedule</div></div>
	</div>
	<div class="row">
		<div class="col-md-4"> <div class="brick"><?php include("bricks/usage.php") ?></div></div>
		<div class="col-md-8"> <div class="brick"><?php include("bricks/temp_graph_improved.php") ?></div></div>
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