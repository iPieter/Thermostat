<div class="brickTop"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Today's Temperature</div>
<div id="tempHistDiv" style="min-width: 310px; height: 258px; margin: 0 auto"></div>

<script> 
var chart; 
var tid = setInterval(requestData, 300000);

function requestData(){
    $.ajax({
    url: 'http://thermostat.ipieter.be/scripts/get_graph_temp_improved.php',
	dataType: 'json',
	success: function(data){
           chart.series[1].setData(data['cur']);		
           chart.series[0].setData(data['tar']);		
			
	      },
	error: function (request, xhr) {
	}
	});
}

$(document).ready(function() {
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });
chart = new Highcharts.Chart({
     chart: {
        renderTo: 'tempHistDiv',
        type: 'spline',
        events: {
            load: requestData
        }
     },
     exporting: { enabled: false },
     credits: {
    enabled: false
    },
     
     title: {
         text: '',
         style: {
             display: 'none'
         }
     },
     subtitle: {
         text: '',
         style: {
             display: 'none'
         }
     },
     tooltip: {
            crosshairs: true,
            shared: true,
            valueSuffix: '°C'
        },
     xAxis: {
        type: 'datetime',

     },
     yAxis: {
        minPadding: 0.0,
            maxPadding: 0.0,
            title: {
                text: 'Temperature (°C)',
                margin: 10
            }
     },
     series: [{
        name: 'Target',
        color: 'rgb(230, 126, 34)',        
        data: [],
     },{
        name: 'Temperature',
        color: 'rgb(52, 73, 94)',
        data: [],
     }]
  });
  });
    </script>