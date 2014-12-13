<div class="brickTop"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Power usage (W)</div>
<div id="usageDiv"><canvas id="usageCanvas" height="261"></canvas></div>

<script>
// Get the context of the canvas element we want to select
var canvas =document.getElementById("usageCanvas");
var ctx = canvas.getContext("2d");
fitToContainer(canvas);

var data = {
    labels: ["0", "1", "2", "3", "4", "5", "6"],
    datasets: [
        {
            label: "Power Usage",
            fillColor: "rgba(151,187,205,0.2)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: [0, 0, 0, 0, 0, 0, 0]
        }
    ]
};

var usageChart = new Chart(ctx).Line(data, {scaleBeginAtZero: true, scaleOverride: true,

    // ** Required if scaleOverride is true **
    // Number - The number of steps in a hard coded scale
    scaleSteps: 8,
    // Number - The value jump in the hard coded scale
    scaleStepWidth: 250,
    // Number - The scale starting value
    scaleStartValue: 0,
    
    animationSteps: 10,
});



function fitToContainer(canvas){
  canvas.style.width='100%';
  canvas.style.height='261px';
  canvas.width  = canvas.offsetWidth;
  canvas.height = canvas.offsetHeight;
}

</script>