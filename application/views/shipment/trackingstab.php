<div class="row m-0">
	<div class="col-md-9" style="margin: 0 auto;float: initial;">
		<div class="text-center bg-info p-2 font-weight-bold f16">Tracking</div>

		<div class="row m-0">
			<div class="col-md-12 pt-4">
				<div class="form-group row">
					<label class="col-sm-6 col-form-label" for="st_zip_country">					
						Shipment Date/Time &nbsp;&nbsp; <?php echo date("m/d/Y H:i", strtotime($shipInfo['ready_date_time']));?>
					</label>
										
					<label class="col-sm-6 col-form-label" for="st_zip_country">
						Scheduled Delivery Date/Time &nbsp;&nbsp; <?php echo date("m/d/Y H:i", strtotime($shipInfo['schedule_date_time']));?> 
					</label>
					

				</div>
				
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="current_status">Current Status</label>
					<div class="col-sm-5">
						<select class="form-control" id="current_status" name="track[current_status]">
							<option value="0">Select</option>
							<?php
							if(!empty($orderstatus))
							{
								foreach ($orderstatus as $os)
								{
									?>
									<option value="<?php echo $os['status_id'] ?>" <?php if($os['status_id'] == (isset($trackrecords['current_status']) ? $trackrecords['current_status'] : '')) {echo "selected='selected'";} ?>><?php echo $os['status_name'] ?></option>
									<?php
								}
							}
							?>
						</select>
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="event_date">Event Date/Time</label>
					<div class="col-sm-3">
						<input type="text" class="form-control dateonlypicker" id="event_date" value="<?php echo (isset($trackrecords['event_date']) ? date('m/d/Y',strtotime($trackrecords['event_date'])) : ''); ?>" name="track[event_date]" placeholder="mm/dd/yyyy">
					</div>
					
					<div class="col-sm-2">
						<input type="text" class="form-control timepicker" id="event_time" value="<?php echo (isset($trackrecords['event_time']) ? date('H:i',strtotime($trackrecords['event_time'])) : ''); ?>" name="track[event_time]" placeholder="hh:mm"> 
					</div> 
					
				</div>
				
				
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="freight_location">Freight Location</label>
					<label class="col-sm-2 col-form-label" for="freight_location">City</label>
					<div class="col-sm-2">
						<input type="text" class="form-control" value="<?php echo (isset($trackrecords['freight_city']) ? $trackrecords['freight_city'] : ''); ?>" id="freight_city" name="track[freight_city]" maxlength="128">
					</div>
					
					<label class="col-sm-2 col-form-label" for="freight_location">State</label>
					
					<div class="col-sm-3">
						<select class="form-control" id="freight_state" name="track[freight_state]">
							<option value="0">State</option>
							<?php
							if(!empty($s_states))
							{
								foreach ($s_states as $st)
								{
									?>
									<option value="<?php echo $st['state_id'] ?>" <?php if($st['state_id'] == (isset($trackrecords['freight_state']) ? $trackrecords['freight_state'] : '')) {echo "selected='selected'";} ?>><?php echo $st['state_name'] ?></option>
									<?php
								}
							}
							?>
						</select>
					</div>
				</div>
				
				<div class="form-group row bg-info pt-2 pb-2 mb-0">
					<label class="col-sm-3 col-form-label" for="pod_date">POD Date/Time</label>
					<div class="col-sm-3">
						<input type="text" class="form-control dateonlypicker" id="pod_date" value="<?php echo (isset($trackrecords['pod_date']) ? date('m/d/Y',strtotime($trackrecords['pod_date'])) : ''); ?>" name="track[pod_date]" placeholder="mm/dd/yyyy">
					</div>
					
					<div class="col-sm-2">
						<input type="text" class="form-control timepicker" id="pod_time" value="<?php echo (isset($trackrecords['pod_time']) ? date('H:i',strtotime($trackrecords['pod_time'])) : ''); ?>" name="track[pod_time]" placeholder="hh:mm">
					</div> 
					
				</div>
				
				<div class="form-group row bg-info pt-2 pb-2 mb-2">
					<label class="col-sm-3 col-form-label" for="pod_name">POD Name</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="pod_name" value="<?php echo (isset($trackrecords['pod_name']) ? $trackrecords['pod_name'] : ''); ?>" name="track[pod_name]">
					</div>
					
					<div class="col-sm-2">
						<input class="form-check-input" type="checkbox" value="1" name="track[pod_delivered]" id="pod_delivered" <?php echo (isset($trackrecords['pod_delivered']) ? $trackrecords['pod_delivered'] : ''); ?>>
						Delivered
					</div> 
					
				</div>
				
				<div class="form-group row pt-2 pb-2 mb-2">
					<label class="col-sm-3 col-form-label" for="t_comments">Comments</label>
					<div class="col-sm-9">
						<textarea name='track[t_comments]' id="t_comments" class="form-control" rows="3"><?php echo (isset($trackrecords['t_comments']) ? $trackrecords['t_comments'] : ''); ?></textarea>
					</div>
										
				</div>
				
			</div>
		</div> 


	</div>
</div>