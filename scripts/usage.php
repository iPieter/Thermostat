<div class="usage statistics">

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

	<h3>Temperature</h3>	
	<div id="tempHistDiv" style="width: auto; height: 258px; margin: 0 auto"></div>
</div>

<div class="usage power">
	<h3>Duty Cycle</h3>
	<div id="dutyHistDiv" style="width: auto; height: 258px; margin: 0 auto"></div>
</div>

<div class="usage devices">
	<h3>Registered Devices</h3>
	
<?php 
//list all the devices the user gets access to
    echo $devicelist;
?>
</div>