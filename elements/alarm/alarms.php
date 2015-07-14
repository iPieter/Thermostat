<div class="row">
    <?php 
    	//$alarms = $alarmManager->getAlarmsArray();
        
        $counter = 0; //for new rows
        foreach ($user->getDevices('alarm') as $alarm) {
			$alarmObj = new Alarm($alarm['id'],$alarm['spark_id'],$alarm['spark_token'],$alarm['location_name']);
			echo $alarmObj->getHTML();
	        
	        $counter++;
	        if ($counter%3 == 0) {
		        echo '</div> <div class="row">';
	        }
        }
     ?>
        		
</div>
<div class="row">
  <div class="col-md-4"> <div class="brick"><h1>Brightness</h1><p id="brightness"></p></div></div>
  <div class="col-md-4 "> <div class="brick"><h1>Vector</h1><p id="vector"></p></div></div>
  <div class="col-md-4 "> <div class="brick">.col-md-2</div></div>
</div>

