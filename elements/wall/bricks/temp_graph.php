<div class="brickTop"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Today's Temperature</div>
<div id="tempHistDiv"><canvas id="tempHistCanvas" height="261"></canvas></div>

<script>

$(window).load(drawTemp());

var tid2 = setInterval(refreshTemp, 600000);
var curTemp;
// Get the context of the canvas element we want to select
var canvasTemp =document.getElementById("tempHistCanvas");
var ctxTemp = canvasTemp.getContext("2d");
fitToContainer(canvasTemp);

var tempCart = new Chart(ctxTemp).Line();

function drawTemp() {

$.ajax({
	url: 'scripts/get_graph_temp.php', 
	data: "", 
	dataType: 'json',
	success: function(data){
	tempCart = new Chart(ctxTemp).Line(data, {scaleBeginAtZero: false, animationSteps: 1, pointDot : false, bezierCurveTension : 0.2,multiTooltipTemplate: "<%= value %>\xB0C",
});	
}
});	

}

function refreshTemp() {
$.ajax({
	url: 'scripts/get_graph_temp.php', 
	data: "", 
	dataType: 'json',
	success: function(data){
	
	
		tempCart.clear();
		tempCart.destroy();

		tempCart = new Chart(ctxTemp).Line(data, {scaleBeginAtZero: false, animationSteps: 1, pointDot : false, bezierCurveTension : 0.2,multiTooltipTemplate: "<%= value %>\xB0C",
});	
}
});	

}






function fitToContainer(canvasTemp){
  canvasTemp.style.width='100%';
  canvasTemp.style.height='261px';
  canvasTemp.width  = canvasTemp.offsetWidth;
  canvasTemp.height = canvasTemp.offsetHeight;
}

</script>