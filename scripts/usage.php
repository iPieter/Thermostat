<?php 


if (isset($_GET['interval'])) {
	$interval = $_GET['interval'];
} else {
	$interval = 'today';
	
}
?>
<h1>Statistics</h1>

<div class="row statrow">
<div class="stat col-sm-3 col-lg-2 col-lg-offset-2">
<div class="padFix">
	<h2><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Indoors</h2>
	<div class="value" id="inTemp">13/17</div>
</div></div>
<div class="stat col-sm-3 col-lg-2">
<div class="padFix">
	<h2><span class="glyphicon glyphicon-flash" aria-hidden="true"></span> Energy</h2>
	<div class="value" id="cons">3.14 kWh</div>
</div></div>
<div class="stat col-sm-3 col-lg-2">
<div class="padFix">
	<h2><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Outdoors</h2>
	<div class="value" id="outTemp">12/13</div>
</div></div>
<div class="stat col-sm-3 col-lg-2">
<div class="padFix">
	<h2><span class="glyphicon glyphicon-sort" aria-hidden="true"></span> A number</h2>
	<div class="value" id="RND">42</div>
</div></div>
</div>
<h1>Temperature</h1>

<div id="tempHistDiv" style="min-width: 310px; height: 258px; margin: 0 auto"></div>

<h1>Duty Cycle</h1>

<div id="dutyHistDiv" style="min-width: 310px; height: 258px; margin: 0 auto"></div>
