
<style>
.modal-dialog{width:900px;}
#addTransferalert .form-group{margin-bottom: 5px;}
</style>

<script type="text/javascript">
$(document).ready(function(){
	$( ".dateonlypicker" ).datetimepicker({
		format: 'm/d/Y',
		formatDate: 'm/d/Y',
		timepicker: false,
		datepicker: true,
		yearStart: <?php echo date('Y');?>,
	});
	
	$( ".timepicker" ).datetimepicker({
		format: 'H:i',
		formatTime: 'H:i',
		step: 30,
		timepicker: true,
		datepicker: false,
		yearStart: <?php echo date('Y');?>,
	});
	
	$('.us_phone_num_design').usPhoneFormat({
		format: 'x-xxx-xxx-xxxx',
	});
			
	jQuery('#t_country').on('change', function() {
		var countryId = $(this).val();
		if(countryId) {
			$.ajax({
				url: baseURL+'statecheck/'+countryId,
				type: "GET",
				dataType: "json",
				success:function(data) {
					$('#t_state').empty();
					$.each(data, function(key, value) {
						$('#t_state').append('<option value="'+ value.state_id +'">'+ value.state_name +'</option>');
					});
				}
			});
		}else{
			$('#t_state').empty();
		}
	});
	
	jQuery('#r_country').on('change', function() {
		var countryId = $(this).val();
		if(countryId) {
			$.ajax({
				url: baseURL+'statecheck/'+countryId,
				type: "GET",
				dataType: "json",
				success:function(data) {
					$('#r_state').empty();
					$.each(data, function(key, value) {
						$('#r_state').append('<option value="'+ value.state_id +'">'+ value.state_name +'</option>');
					});
				}
			});
		}else{
			$('#r_state').empty();
		}
	});
	
	$("#addTransferalert").submit(function(){
	
		var r_id= $('#addTransferalert #r_id').val();
		if(r_id == ''){
			alert('Please select anyone Recover From Shipper option!');
			return false;
		}
		
		var t_id= $('#addTransferalert #t_id').val();
		if(t_id == ''){
			alert('Please select anyone transfer To Consignee option!');
			return false;
		}
		
				
        dataString = $("#addTransferalert").serialize();

        $.ajax({
            type: "POST",
            url: baseURL+"addTransferAlert",
            data: dataString,
            success: function(data){
				
                $("#addTransferalert #resultdatao").html(data.message); 
				
				if(data.status == 'error'){
					$("#addTransferalert #resultdatao").addClass("alert alert-danger");
				}else{
					$("#addTransferalert #resultdatao").addClass("alert alert-success");
				}
				if(data.status == 'success'){
					setTimeout(function(){  
						$('#myModaloverlap').modal('toggle');
						$(".displaycontentpopup_overlap").html('');
					}, 1000);
				}
            }

        });

        return false;  //stop the actual form post !important!

    });
	
});
</script>

  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

             <span aria-hidden="true">&times;</span>

        </button>
        <h4 class="modal-title"><?php echo $popup_title; ?></h4>
      </div>
      <div class="modal-body">
			
			
			<form role="form" id="addTransferalert" method="post" >
			
			
			
			<div class="row m-0 border_bottom_2x">
				<div class="col-md-6 border_right_2x">
					<div class="text-center bg-info p-2 font-weight-bold f16 mb-2">RECOVER FROM</div>

					<div class="form-group row">
						<span class="font-weight-bold f16 col-sm-3">Shipper</span>
						<label class="col-sm-3 col-form-label font-weight-normal">
							<input class="form-check-input" type="radio" name="r_data[recover_from]" id="recover_from" value="1" onclick="changeTransferData('pickup', 1, <?php echo $shipInfo['shipment_id']; ?>,'addTransferalert');" <?php echo ((isset($aRecords['recover_from']) && $aRecords['recover_from'] == 1) ? 'checked' : ''); ?>>
							Shipper
						</label>
						<label class="col-sm-3 col-form-label font-weight-normal">
							<input class="form-check-input" type="radio" name="r_data[recover_from]" id="recover_from" value="2" onclick="changeTransferData('pickup', 2, <?php echo $shipInfo['shipment_id']; ?>,'addTransferalert');"  <?php echo ((isset($aRecords['recover_from']) && $aRecords['recover_from'] == 2) ? 'checked' : ''); ?>>
							Consignee
						</label>
						<label class="col-sm-3 col-form-label font-weight-normal">
							<input class="form-check-input" type="radio" name="r_data[recover_from]" id="recover_from" value="3" onclick="changeTransferData('pickup', 3, <?php echo $shipInfo['shipment_id']; ?>,'addTransferalert');" <?php echo ((isset($aRecords['recover_from']) && $aRecords['recover_from'] == 3) ? 'checked' : ''); ?>>
							Vendor
						</label> 
					</div>
			
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="shipper_name">Name</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" value="<?php echo (isset($aRecords['r_data']['r_name']) ? $aRecords['r_data']['r_name'] : ''); ?>" id="r_name" name="r_data[r_name]" maxlength="128">
							<input type="hidden" class="form-control" value="<?php echo (isset($aRecords['r_data']['r_id']) ? $aRecords['r_data']['r_id'] : ''); ?>" id="r_id" name="r_data[r_id]" >
							<input type="hidden" class="form-control" value="<?php echo $shipInfo['shipment_id']; ?>" id="shipment_id" name="shipment_id" >
						</div>
					</div>
																					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="r_address_1">Address 1</label>
						<div class="col-sm-9">
							
							<textarea name='r_data[r_address_1]' id="r_address_1" class="form-control" rows="1"><?php echo (isset($aRecords['r_data']['r_address_1']) ? $aRecords['r_data']['r_address_1'] : ''); ?></textarea>
						</div>
					</div>
			
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="r_address_2">Address 2</label>
						<div class="col-sm-9">
							<textarea name='r_data[r_address_2]' id="r_address_2" class="form-control" rows="1"><?php echo (isset($aRecords['r_data']['r_address_2']) ? $aRecords['r_data']['r_address_2'] : ''); ?></textarea>
						</div>
					</div>
			
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="r_city">City</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" value="<?php echo (isset($aRecords['r_data']['r_city']) ? $aRecords['r_data']['r_city'] : ''); ?>" id="r_city" name="r_data[r_city]" maxlength="128">
						</div>
					</div>
						
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="st_zip_country">St/Zip</label>
						<div class="col-sm-4 pr-0">
							<select class="form-control" id="r_state" name="r_data[r_state]">
								<option value="0">State</option>
								<?php
								if(!empty($r_states))
								{
									foreach ($r_states as $st)
									{
										?>
										<option value="<?php echo $st['state_id'] ?>" <?php if($st['state_id'] == (isset($aRecords['r_data']['r_state']) ? $aRecords['r_data']['r_state'] : '')) {echo "selected=selected";} ?>><?php echo $st['state_name'] ?></option>
										<?php
									}
								}
								?>
							</select>
						</div>
						<div class="col-sm-4 pr-0">
							<input type="text" class="form-control zip_en_data" value="<?php echo (isset($aRecords['r_data']['r_zip']) ? $aRecords['r_data']['r_zip'] : ''); ?>" id="r_zip" name="r_data[r_zip]" placeholder="Zip" maxlength="8">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="s_city">Country</label>
						<div class="col-sm-7">
							<select class="form-control required" id="r_country" name="r_data[r_country]">
								<option value="0">Country</option>
								<?php
								if(!empty($countries))
								{
									foreach ($countries as $rl)
									{
										?>
										<option value="<?php echo $rl['country_id'] ?>" <?php if($rl['country_id'] ==  (isset($aRecords['r_data']['r_country']) ? $aRecords['r_data']['r_country'] : '')) {echo "selected=selected";} ?>><?php echo $rl['country_name'] ?></option>
										<?php
									}
								}
								?>
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="st_zip_country">Phone</label>
						<div class="col-sm-5">
							<input type="text" class="form-control us_phone_num_design" id="r_phone" value="<?php echo (isset($aRecords['r_data']['r_phone']) ? $aRecords['r_data']['r_phone'] : ''); ?>" name="r_data[r_phone]" maxlength="14" placeholder="Phone">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="st_zip_country">Contact</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="r_contact" value="<?php echo (isset($aRecords['r_data']['r_contact']) ? $aRecords['r_data']['r_contact'] : ''); ?>" name="r_data[r_contact]" maxlength="128" placeholder="Contact">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="s_default_ref">MAWB/REF</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="r_default_ref" value="<?php echo (isset($aRecords['r_data']['r_default_ref']) ? $aRecords['r_data']['r_default_ref'] : ''); ?>" name="r_data[r_default_ref]" maxlength="128" placeholder="Reference #">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="">FLIGHT</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="r_flight" value="<?php echo (isset($aRecords['r_data']['r_flight']) ? $aRecords['r_data']['r_flight'] : ''); ?>" name="r_data[r_flight]" maxlength="128">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="">ARRIVAL</label>
						<div class="col-sm-5">
							<input type="text" class="form-control dateonlypicker" id="r_arrival_date" value="<?php echo ((isset($aRecords['r_data']['r_arrival_date'])  && !empty($aRecords['r_data']['r_arrival_date'])) ? date('m/d/Y',strtotime($aRecords['r_data']['r_arrival_date'])) : ''); ?>" name="r_data[r_arrival_date]">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="">ARRIVAL TIME</label>
						<div class="col-sm-5">
							<input type="text" class="form-control timepicker" id="r_arrival_time" value="<?php echo (isset($aRecords['r_data']['r_arrival_time']) ? $aRecords['r_data']['r_arrival_time'] : ''); ?>" name="r_data[r_arrival_time]">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="">MAWB CONSIGNED TO</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="r_mawb_consign_to" value="<?php echo (isset($aRecords['r_data']['r_mawb_consign_to']) ? $aRecords['r_data']['r_mawb_consign_to'] : ''); ?>" name="r_data[r_mawb_consign_to]" maxlength="128">
						</div>
					</div>
					
				</div>
				
				<div class="col-md-6">
					<div class="text-center bg-info p-2 font-weight-bold f16 mb-2">TRANSFER TO</div>
					
					<div class="form-group row">
						<span class="font-weight-bold f16 col-sm-3">Consignee</span>
						<label class="col-sm-3 col-form-label font-weight-normal">
							<input class="form-check-input" type="radio" name="t_data[transfer_to]" id="transfer_to" value="1" onclick="changeTransferData('delivery', 1, <?php echo $shipInfo['shipment_id']; ?>,'addTransferalert');"  <?php echo ((isset($aRecords['transfer_to']) && $aRecords['transfer_to'] == 1) ? 'checked' : ''); ?>>
							Shipper 
						</label>
						<label class="col-sm-3 col-form-label font-weight-normal">
							<input class="form-check-input" type="radio" name="t_data[transfer_to]" id="transfer_to" value="2" onclick="changeTransferData('delivery', 2, <?php echo $shipInfo['shipment_id']; ?>,'addTransferalert');"  <?php echo ((isset($aRecords['transfer_to']) && $aRecords['transfer_to'] == 2) ? 'checked' : ''); ?>>
							Consignee
						</label>
						<label class="col-sm-3 col-form-label font-weight-normal">
							<input class="form-check-input" type="radio" name="t_data[transfer_to]" id="transfer_to" value="3" onclick="changeTransferData('delivery', 3, <?php echo $shipInfo['shipment_id']; ?>,'addTransferalert');"  <?php echo ((isset($aRecords['transfer_to']) && $aRecords['transfer_to'] == 3) ? 'checked' : ''); ?>>
							Vendor
						</label> 
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="shipper_name">Name</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" value="<?php echo (isset($aRecords['t_data']['t_name']) ? $aRecords['t_data']['t_name'] : ''); ?>" id="t_name" name="t_data[t_name]" maxlength="128">
							<input type="hidden" class="form-control" value="<?php echo (isset($aRecords['t_data']['t_id']) ? $aRecords['t_data']['t_id'] : ''); ?>" id="t_id" name="t_data[t_id]" >
							<input type="hidden" class="form-control" value="<?php echo $shipInfo['shipment_id']; ?>" id="shipment_id" name="t_data[shipment_id]" >
						</div>
					</div>
																					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="t_address_1">Address 1</label>
						<div class="col-sm-9">
							
							<textarea name='t_data[t_address_1]' id="t_address_1" class="form-control" rows="1"><?php echo (isset($aRecords['t_data']['t_address_1']) ? $aRecords['t_data']['t_address_1'] : ''); ?></textarea>
						</div>
					</div>
			
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="t_address_2">Address 2</label>
						<div class="col-sm-9">
							<textarea name='t_data[t_address_2]' id="t_address_2" class="form-control" rows="1"><?php echo (isset($aRecords['t_data']['t_address_2']) ? $aRecords['t_data']['t_address_2'] : ''); ?></textarea>
						</div>
					</div>
			
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="t_city">City</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" value="<?php echo (isset($aRecords['t_data']['t_city']) ? $aRecords['t_data']['t_city'] : ''); ?>" id="t_city" name="t_data[t_city]" maxlength="128">
						</div>
					</div>
						
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="st_zip_country">St/Zip</label>
						<div class="col-sm-4 pr-0">
							<select class="form-control" id="t_state" name="t_data[t_state]">
								<option value="0">State</option>
								<?php
								if(!empty($t_states))
								{
									foreach ($t_states as $st)
									{
										?>
										<option value="<?php echo $st['state_id'] ?>" <?php if($st['state_id'] == (isset($aRecords['t_data']['t_state']) ? $aRecords['t_data']['t_state'] : '')) {echo "selected=selected";} ?>><?php echo $st['state_name'] ?></option>
										<?php
									}
								}
								?>
							</select>
						</div>
						<div class="col-sm-4 pr-0">
							<input type="text" class="form-control zip_en_data" value="<?php echo (isset($aRecords['t_data']['t_zip']) ? $aRecords['t_data']['t_zip'] : ''); ?>" id="t_zip" name="t_data[t_zip]" placeholder="Zip" maxlength="8">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="s_city">Country</label>
						<div class="col-sm-7">
							<select class="form-control required" id="t_country" name="t_data[t_country]">
								<option value="0">Country</option>
								<?php
								if(!empty($countries))
								{
									foreach ($countries as $rl)
									{
										?>
										<option value="<?php echo $rl['country_id'] ?>" <?php if($rl['country_id'] ==  (isset($aRecords['t_data']['t_country']) ? $aRecords['t_data']['t_country'] : '')) {echo "selected=selected";} ?>><?php echo $rl['country_name'] ?></option>
										<?php
									}
								}
								?>
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="st_zip_country">Phone</label>
						<div class="col-sm-5">
							<input type="text" class="form-control us_phone_num_design" id="t_phone" value="<?php echo (isset($aRecords['t_data']['t_phone']) ? $aRecords['t_data']['t_phone'] : ''); ?>" name="t_data[t_phone]" maxlength="14" placeholder="Phone">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="st_zip_country">Contact</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="t_contact" value="<?php echo (isset($aRecords['t_data']['t_contact']) ? $aRecords['t_data']['t_contact'] : ''); ?>" name="t_data[t_contact]" maxlength="128" placeholder="Contact">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="s_default_ref">MAWB/REF</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="t_default_ref" value="<?php echo (isset($aRecords['t_data']['t_default_ref']) ? $aRecords['t_data']['t_default_ref'] : ''); ?>" name="t_data[t_default_ref]" maxlength="128" placeholder="Reference #">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="">FLIGHT</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="t_flight" value="<?php echo (isset($aRecords['t_data']['t_flight']) ? $aRecords['t_data']['t_flight'] : ''); ?>" name="t_data[t_flight]" maxlength="128">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="">DEPARTURE</label>
						<div class="col-sm-5">
							<input type="text" class="form-control dateonlypicker" id="t_departure_date" value="<?php echo ((isset($aRecords['t_data']['t_departure_date']) && !empty($aRecords['t_data']['t_departure_date'])) ? date('m/d/Y',strtotime($aRecords['t_data']['t_departure_date'])) : ''); ?>" name="t_data[t_departure_date]">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="">DEPARTURE TIME</label>
						<div class="col-sm-5">
							<input type="text" class="form-control timepicker" id="t_departure_time" value="<?php echo (isset($aRecords['t_data']['t_departure_time']) ? $aRecords['t_data']['t_departure_time'] : ''); ?>" name="t_data[t_departure_time]">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="">Cutoff Date</label>
						<div class="col-sm-5">
							<input type="text" class="form-control dateonlypicker" id="t_cutoff_date" value="<?php echo ((isset($aRecords['t_data']['t_cutoff_date']) && !empty($aRecords['t_data']['t_cutoff_date'])) ? date('m/d/Y',strtotime($aRecords['t_data']['t_cutoff_date'])) : ''); ?>" name="t_data[t_cutoff_date]">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="">Cutoff TIME</label>
						<div class="col-sm-5">
							<input type="text" class="form-control timepicker" id="t_cutoff_time" value="<?php echo (isset($aRecords['t_data']['t_cutoff_time']) ? $aRecords['t_data']['t_cutoff_time'] : ''); ?>" name="t_data[t_cutoff_time]">
						</div>
					</div>
					
				</div>
				
				
				
			</div>
			
			<div class="row">
				<div class="col-md-12 mt-2">
					<label class="col-sm-12 col-form-label" for="instructions">INSTRUCTIONS:</label>
					<div class="col-sm-12">
						
						<textarea name='instructions' id="instructions" class="form-control" rows="2"><?php echo (isset($aRecords['instructions']) ? $aRecords['instructions'] : '');?></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<center><div id="resultdatao"></div></center>
				
				<div class="text-center mt-3 mb-4">
					<a class="btn btn-info btn-sm mr-4" href="javascript:void(0);" <?php echo (empty($aRecords) ? 'style="display:none;"' : '');?> onclick="deleteTransferAlert(<?php echo $shipInfo['shipment_id']; ?>);">Delete</a>
					<a class="btn btn-info btn-sm mr-4" href="javascript:void(0);" <?php echo (empty($aRecords) ? 'style="display:none;"' : '');?>>Fax</a>
					<a class="btn btn-info btn-sm mr-4" href="javascript:void(0);" <?php echo (empty($aRecords) ? 'style="display:none;"' : '');?>>Email</a>
					<a class="btn btn-info btn-sm mr-4" <?php echo (empty($aRecords) ? 'style="display:none;"' : '');?> target="_blank" href="<?php echo base_url().'transferAlertPdf/'.$shipInfo['shipment_id']; ?>">View</a>
					<a class="btn btn-danger btn-sm mr-4" href="javascript:void(0);" onclick="$('#myModaloverlap').modal('toggle');" >Return</a>
					<button type="submit" class="btn btn-success btn-sm">Submit</button>
				</div>
			</div>
			
			
			
			</form>
      </div>
    </div>
  </div>

