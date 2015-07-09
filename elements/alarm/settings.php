<?php
//get the last values for the form
$sql = "SELECT * FROM alarm_calendars WHERE user_id=" . $user->getId();


$row = mysqli_fetch_array(mysqli_query($con, $sql));
mysqli_close($con);

?>
<form class="form-horizontal col-sm-offset-1-5 col-sm-8">
  <div class="form-group" id="cal">
    <label for="inputWebcal" class="col-sm-2 control-label">Webcal</label>
    <div class="col-sm-9">
      <input type="url" class="form-control" id="inputWebcal" value="<?php echo $row['url']?>" >
      <p class="text-muted">By linking your Time with your calendar, he will be able to wake you up at just the right time. Usually, the link to your calendar will start with <code>webcal://</code>, although <code>http://</code> and <code>https://</code> will work as well. Also, make sure the calendar is publicly accessible, otherwise the Time will be sad. </p>
    </div>
  </div>
  <div class="form-group" id="offset">
    <label for="inputOffset" class="col-sm-2 control-label">Time offset</label>
    <div class="col-sm-9 input-group">
      <input type="number" class="form-control" id="inputOffset" placeholder="60">
      <span class="input-group-addon" >minutes</span>      

    </div>
    <div class="col-sm-9 col-sm-offset-2">
	    <p class="text-muted">Set the time window you normally need to start your day, so the Time can account for this. Because the Time uses state-of-the-art sleep analysis to wake you at just the right moment, this is used as a guideline.</p>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-9">
      <input type="hidden" class="form-control" id="userId" value="<?php echo $user->getId()?>">

      <button type="button" class="btn btn-default submit">Save changes</button>
    </div>
  </div>
</form>