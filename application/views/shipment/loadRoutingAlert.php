<style>
.modal-dialog{width:900px;}
#addRoutingAlert .form-group{margin-bottom: 5px;}
.modal.fade.displaycontentpopup.in {
    overflow-x: hidden;
    overflow-y: auto;
}
.ui-widget{z-index:9999;}
</style>

<script type="text/javascript">
$(document).ready(function(){
	
	$( ".datetimepicker" ).datetimepicker({
		format: 'm/d/Y H:i',
		formatTime: 'H:i',
		formatDate: 'm/d/Y',
		step: 30,
		timepicker: true,
		datepicker: true,
		yearStart: <?php echo date('Y');?>,
	});
	
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
	
	$("#addRoutingAlert").validate({
		
		submitHandler: function(form) {
			
			dataString = $("#addRoutingAlert").serialize();

			$.ajax({
				type: "POST",
				url: baseURL+"addRoutingAlert",
				data: dataString,
				success: function(data){
					
					$("#addRoutingAlert #resultdatao").html(data.message); 
					
					if(data.status == 'error'){
						$("#addRoutingAlert #resultdatao").addClass("alert alert-danger");
					}else{
						$("#addRoutingAlert #resultdatao").addClass("alert alert-success");
					}
					if(data.status == 'success'){
						setTimeout(function(){  
							$('#myModal').modal('toggle');
							$(".displaycontentpopup").html('');
						}, 1000);
					}
				}
			});
			return false; 
		}
	});
	
		
	$('.mawb_num_format').usPhoneFormat({
		format: 'xxx-xxxxxxxx',
	});
	
	$('input.autocompleteflight').each(function() {
			var $el = $(this);
			
			$el.autocomplete({
				source: function( request, response ) {
				  // Fetch data
				  $.ajax({
					url: baseURL+'checkairportCode',
					type: 'post',
					dataType: "json",
					data: {
					  search: request.term,
					},
					success: function( datas ) {
					  response( datas );
					}
				  });
				},
				select: function (event, ui) {
				  $('#'+$el.data('parentid')+' #'+$el.data('mainid')).val(ui.item.airport_code);
				  $('#'+$el.data('parentid')+' #'+$el.data('subid')).val(ui.item.airport_id);
				  return false;
				}
			});
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
			
			
			<form role="form" id="addRoutingAlert" method="post" >
						
			<div class="row m-0 border_bottom_2x">
				<div class="col-md-6 border_right_2x">
					

					<div class="form-group row" >
						<label class="col-sm-3 col-form-label" for="ro_state">House Bill</label>
						<div class="col-sm-3 pr-0">
							<input type="text" class="form-control" value="<?php echo (isset($aRecords['airbill_station']) ? $aRecords['airbill_station'] : $shipInfo['station']); ?>" id="airbill_station" name="val[airbill_station]" maxlength="5">
						</div>
						
						<div class="col-sm-4 pr-0">
							<input type="text" class="form-control" value="<?php echo (isset($aRecords['airbill_number']) ? $aRecords['airbill_number'] : $shipInfo['waybill']); ?>" id="airbill_number" name="val[airbill_number]" maxlength="12">
						</div>
						
					</div>
					
					<div class="form-group row">
						<span class="font-weight-bold f16 col-sm-3">Shipper</span>
						<label class="col-sm-3 col-form-label font-weight-normal">
							<input class="form-check-input" type="radio" name="r_f_data[route_from]" id="route_from" value="1" onclick="changeTransferData('pickup', 1, <?php echo $shipInfo['shipment_id']; ?>,'addRoutingAlert');" <?php echo ((isset($aRecords['route_from']) && $aRecords['route_from'] == 1) ? 'checked' : ''); ?>>
							Shipper
						</label>
						<label class="col-sm-3 col-form-label font-weight-normal">
							<input class="form-check-input" type="radio" name="r_f_data[route_from]" id="route_from" value="2" onclick="changeTransferData('pickup', 2, <?php echo $shipInfo['shipment_id']; ?>,'addRoutingAlert');"  <?php echo ((isset($aRecords['route_from']) && $aRecords['route_from'] == 2) ? 'checked' : ''); ?>>
							Consignee
						</label>
						<label class="col-sm-3 col-form-label font-weight-normal">
							<input class="form-check-input" type="radio" name="r_f_data[route_from]" id="route_from" value="3" onclick="changeTransferData('pickup', 3, <?php echo $shipInfo['shipment_id']; ?>,'addRoutingAlert');" <?php echo ((isset($aRecords['route_from']) && $aRecords['route_from'] == 3) ? 'checked' : ''); ?>>
							Vendor
						</label> 
					</div>
			
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="shipper_name">Name</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" value="<?php echo (isset($aRecords['r_f_data']['r_name']) ? $aRecords['r_f_data']['r_name'] : 'Fastline Logistics LLC'); ?>" id="r_name" name="r_f_data[r_name]" maxlength="128">
							<input type="hidden" class="form-control" value="<?php echo (isset($aRecords['r_f_data']['r_id']) ? $aRecords['r_f_data']['r_id'] : ''); ?>" id="r_id" name="r_f_data[r_id]" >
							<input type="hidden" class="form-control" value="<?php echo $shipInfo['shipment_id']; ?>" id="shipment_id" name="shipment_id" >
						</div>
					</div>
																					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="r_address_1">Address 1</label>
						<div class="col-sm-9">
							
							<textarea name='r_f_data[r_address_1]' id="r_address_1" class="form-control" rows="1"><?php echo (isset($aRecords['r_f_data']['r_address_1']) ? $aRecords['r_f_data']['r_address_1'] : 'P.O Box 266'); ?></textarea>
						</div>
					</div>
			
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="r_address_2">Address 2</label>
						<div class="col-sm-9">
							<textarea name='r_f_data[r_address_2]' id="r_address_2" class="form-control" rows="1"><?php echo (isset($aRecords['r_f_data']['r_address_2']) ? $aRecords['r_f_data']['r_address_2'] : ''); ?></textarea>
						</div>
					</div>
			
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="r_city">City</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" value="<?php echo (isset($aRecords['r_f_data']['r_city']) ? $aRecords['r_f_data']['r_city'] : 'Centerton'); ?>" id="r_city" name="r_f_data[r_city]" maxlength="128">
						</div>
					</div>
						
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="st_zip_country">St/Zip</label>
						<div class="col-sm-4 pr-0">
							<select class="form-control" id="r_state" name="r_f_data[r_state]">
								<option value="0">State</option>
								<?php
								if(!empty($r_states))
								{
									foreach ($r_states as $st)
									{
										?>
										<option value="<?php echo $st['state_id'] ?>" <?php if($st['state_id'] == (isset($aRecords['r_f_data']['r_state']) ? $aRecords['r_f_data']['r_state'] : 3)) {echo "selected=selected";} ?>><?php echo $st['state_name'] ?></option>
										<?php
									}
								}
								?>
							</select>
						</div>
						<div class="col-sm-4 pr-0">
							<input type="text" class="form-control zip_en_data" value="<?php echo (isset($aRecords['r_f_data']['r_zip']) ? $aRecords['r_f_data']['r_zip'] : '72719'); ?>" id="r_zip" name="r_f_data[r_zip]" placeholder="Zip" maxlength="8">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="s_city">Country</label>
						<div class="col-sm-7">
							<select class="form-control required" id="r_country" name="r_f_data[r_country]">
								<option value="0">Country</option>
								<?php
								if(!empty($countries))
								{
									foreach ($countries as $rl)
									{
										?>
										<option value="<?php echo $rl['country_id'] ?>" <?php if($rl['country_id'] ==  (isset($aRecords['r_f_data']['r_country']) ? $aRecords['r_f_data']['r_country'] : 2)) {echo "selected=selected";} ?>><?php echo $rl['country_name'] ?></option>
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
							<input type="text" class="form-control us_phone_num_design" id="r_phone" value="<?php echo (isset($aRecords['r_f_data']['r_phone']) ? $aRecords['r_f_data']['r_phone'] : '1-800-540-6100'); ?>" name="r_f_data[r_phone]" maxlength="14" placeholder="Phone">
						</div>
					</div>
					
					<div class="form-group row border_bottom_2x pb-4 mb-2">
						<label class="col-sm-3 col-form-label" for="st_zip_country">Contact</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="r_contact" value="<?php echo (isset($aRecords['r_f_data']['r_contact']) ? $aRecords['r_f_data']['r_contact'] : 'Chris Ringhausen'); ?>" name="r_f_data[r_contact]" maxlength="128" placeholder="Contact">
						</div>
					</div>
					
					<div class="form-group row mt-2">
						<span class="font-weight-bold f16 col-sm-12">Consignee</span>
					</div>
					
					<div class="form-group row mt-2">
						
						<label class="col-sm-4 col-form-label font-weight-normal  pr-0">
							<input class="form-check-input" type="radio" name="t_f_data[route_to]" id="route_to" value="1" onclick="changeTransferData('delivery', 1, <?php echo $shipInfo['shipment_id']; ?>,'addRoutingAlert');"  <?php echo ((isset($aRecords['route_to']) && $aRecords['route_to'] == 4) ? 'checked' : ''); ?>>
							Delivery Agent 
						</label>
						<label class="col-sm-2 col-form-label font-weight-normal pl-0 pr-0">
							<input class="form-check-input" type="radio" name="t_f_data[route_to]" id="route_to" value="1" onclick="changeTransferData('delivery', 1, <?php echo $shipInfo['shipment_id']; ?>,'addRoutingAlert');"  <?php echo ((isset($aRecords['route_to']) && $aRecords['route_to'] == 1) ? 'checked' : ''); ?>>
							Shipper 
						</label>
						<label class="col-sm-3 col-form-label font-weight-normal pl-0 pr-0">
							<input class="form-check-input" type="radio" name="t_f_data[route_to]" id="route_to" value="2" onclick="changeTransferData('delivery', 2, <?php echo $shipInfo['shipment_id']; ?>,'addRoutingAlert');"  <?php echo ((isset($aRecords['route_to']) && $aRecords['route_to'] == 2) ? 'checked' : ''); ?>>
							Consignee
						</label>
						<label class="col-sm-3 col-form-label font-weight-normal pl-0 pr-0">
							<input class="form-check-input" type="radio" name="t_f_data[route_to]" id="route_to" value="3" onclick="changeTransferData('delivery', 3, <?php echo $shipInfo['shipment_id']; ?>,'addRoutingAlert');"  <?php echo ((isset($aRecords['route_to']) && $aRecords['route_to'] == 3) ? 'checked' : ''); ?> <?php echo ((isset($aRecords['route_to']) && empty($aRecords['route_to'])) ? 'checked' : ''); ?>>
							Vendor 
						</label> 
					</div> 
					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="shipper_name">Name</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" value="<?php echo (isset($aRecords['t_f_data']['t_name']) ? $aRecords['t_f_data']['t_name'] : $deliveryVenData['name']); ?>" id="t_name" name="t_f_data[t_name]" maxlength="128">
							<input type="hidden" class="form-control" value="<?php echo (isset($aRecords['t_f_data']['t_id']) ? $aRecords['t_f_data']['t_id'] : $deliveryVenData['vendor_id']); ?>" id="t_id" name="t_f_data[t_id]" >
							<input type="hidden" class="form-control" value="<?php echo $shipInfo['shipment_id']; ?>" id="shipment_id" name="val[shipment_id]" >
						</div>
					</div>
																					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="t_address_1">Address 1</label>
						<div class="col-sm-9">
							
							<textarea name='t_f_data[t_address_1]' id="t_address_1" class="form-control" rows="1"><?php echo (isset($aRecords['t_f_data']['t_address_1']) ? $aRecords['t_f_data']['t_address_1'] : $deliveryVenData['address_1']); ?></textarea>
						</div>
					</div>
			
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="t_address_2">Address 2</label>
						<div class="col-sm-9">
							<textarea name='t_f_data[t_address_2]' id="t_address_2" class="form-control" rows="1"><?php echo (isset($aRecords['t_f_data']['t_address_2']) ? $aRecords['t_f_data']['t_address_2'] : $deliveryVenData['address_2']); ?></textarea>
						</div>
					</div>
			
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="t_city">City</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" value="<?php echo (isset($aRecords['t_f_data']['t_city']) ? $aRecords['t_f_data']['t_city'] : $deliveryVenData['city']); ?>" id="t_city" name="t_f_data[t_city]" maxlength="128">
						</div>
					</div>
						
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="st_zip_country">St/Zip</label>
						<div class="col-sm-4 pr-0">
							<select class="form-control" id="t_state" name="t_f_data[t_state]">
								<option value="0">State</option>
								<?php
								if(!empty($t_states))
								{
									foreach ($t_states as $st)
									{
										?>
										<option value="<?php echo $st['state_id'] ?>" <?php if($st['state_id'] == (isset($aRecords['t_f_data']['t_state']) ? $aRecords['t_f_data']['t_state'] : $deliveryVenData['t_state'])) {echo "selected=selected";} ?>><?php echo $st['state_name'] ?></option>
										<?php
									}
								}
								?>
							</select>
						</div>
						<div class="col-sm-4 pr-0">
							<input type="text" class="form-control zip_en_data" value="<?php echo (isset($aRecords['t_f_data']['t_zip']) ? $aRecords['t_f_data']['t_zip'] : $deliveryVenData['zip']); ?>" id="t_zip" name="t_f_data[t_zip]" placeholder="Zip" maxlength="8">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="s_city">Country</label>
						<div class="col-sm-7">
							<select class="form-control required" id="t_country" name="t_f_data[t_country]">
								<option value="0">Country</option>
								<?php
								if(!empty($countries))
								{
									foreach ($countries as $rl)
									{
										?>
										<option value="<?php echo $rl['country_id'] ?>" <?php if($rl['country_id'] ==  (isset($aRecords['t_f_data']['t_country']) ? $aRecords['t_f_data']['t_country'] : $deliveryVenData['c_country'])) {echo "selected=selected";} ?>><?php echo $rl['country_name'] ?></option>
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
							<input type="text" class="form-control us_phone_num_design" id="t_phone" value="<?php echo (isset($aRecords['t_f_data']['t_phone']) ? $aRecords['t_f_data']['t_phone'] : $deliveryVenData['phone']); ?>" name="t_f_data[t_phone]" maxlength="14" placeholder="Phone">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 col-form-label" for="st_zip_country">Contact</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="t_contact" value="<?php echo (isset($aRecords['t_f_data']['t_contact']) ? $aRecords['t_f_data']['t_contact'] : $deliveryVenData['contact']); ?>" name="t_f_data[t_contact]" maxlength="128" placeholder="Contact">
						</div>
					</div> 
					
					
				</div>
				
				<div class="col-md-6">
					
					<div class="form-group row" >
						<label class="col-sm-2 col-form-label" for="ro_state">Station</label>
						<div class="col-sm-2 pr-0">
							<input type="text" class="form-control" value="<?php echo (isset($aRecords['ro_station']) ? $aRecords['ro_station'] : $shipInfo['station']); ?>" id="ro_station" name="val[ro_station]" maxlength="5">
						</div>
						<label class="col-sm-2 col-form-label" for="ro_origin">Origin</label>
						<div class="col-sm-2 pr-0">
							<!--data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('ro_origin_code', 'ro_origin_id', 'all','addRoutingAlert' );"-->
							
							<input type="text" class="form-control autocompleteflight" value="<?php echo (isset($aRecords['ro_origin_code']) ? $aRecords['ro_origin_code'] : $neededVendorData['origin_airport_code']); ?>" id="ro_origin_code" name="val[ro_origin_code]" maxlength="5" data-mainid="ro_origin_code" data-subid="ro_origin_id" data-parentid="addRoutingAlert">
							<input type="hidden" class="form-control" value="<?php echo (isset($aRecords['ro_origin_id']) ? $aRecords['ro_origin_id'] : $neededVendorData['v_origin_id']); ?>" id="ro_origin_id" name="val[ro_origin_id]" >
						</div>
						<label class="col-sm-2 col-form-label" for="ro_dest">Dest</label>
						<div class="col-sm-2 pr-0">
							<input type="text" class="form-control autocompleteflight" value="<?php echo (isset($aRecords['ro_dest_code']) ? $aRecords['ro_dest_code'] : $neededVendorData['dest_airport_code']); ?>" id="ro_dest_code" name="val[ro_dest_code]" maxlength="5" data-mainid="ro_dest_code" data-subid="ro_dest_id" data-parentid="addRoutingAlert">
							<input type="hidden" class="form-control" value="<?php echo (isset($aRecords['ro_dest_id']) ? $aRecords['ro_dest_id'] : $neededVendorData['v_destination_id']); ?>" id="ro_dest_id" name="val[ro_dest_id]" >
						</div>
					</div>
					
					<div class="flight_info_div" <?php echo ($showAirline ? '' : 'style="display:none;"');?>>
						<div class="form-group row pb-4" >
							<label class="col-sm-12 col-form-label" for="ro_state">Fligh Info</label>
						</div>
						
						<div class="form-group row pt-4">
							<label class="col-sm-3 col-form-label" for="ro_airline">Airline</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" value="<?php echo (isset($aRecords['ro_airline']) ? $aRecords['ro_airline'] : $neededVendorData['v_airline']); ?>" id="ro_airline" name="val[ro_airline]" maxlength="128">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-sm-3 col-form-label" for="ro_mawb">MAWB</label>
							<div class="col-sm-6">
								<input type="text" class="form-control mawb_num_format" id="ro_mawb" value="<?php echo (isset($aRecords['ro_mawb']) ? $aRecords['ro_mawb'] : $neededVendorData['v_mawb']); ?>" name="val[ro_mawb]" minlength="12" maxlength="15">
							</div>
						</div>
						
						<div class="form-group row pb-4">
							<label class="col-sm-3 col-form-label" for="ro_lockout_time">Lockout Time</label>
							<div class="col-sm-6">
								<input type="text" class="form-control timepicker" id="ro_lockout_time" value="<?php echo (isset($aRecords['ro_lockout_time']) ? $aRecords['ro_lockout_time'] : date('H:i',strtotime($neededVendorData['v_cut_off_time']))); ?>" name="val[ro_lockout_time]" >
							</div>
						</div>
						
						<div class="form-group row pt-4">
							<label class="col-sm-3 col-form-label" for="ro_account">Account #</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" value="<?php echo (isset($aRecords['ro_account']) ? $aRecords['ro_account'] : $neededVendorData['v_account']); ?>" id="ro_airline" name="val[ro_account]" maxlength="25">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-sm-3 col-form-label" for="ro_tariff">Tariff</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="ro_tariff" value="<?php echo (isset($aRecords['ro_tariff']) ? $aRecords['ro_tariff'] : $neededVendorData['p_total_cost']); ?>" name="val[ro_tariff]" maxlength="10">
								
							</div>
						</div>
						
						<div class="form-group row m-0 mt-3 mb-3">
							<input type="hidden" class="form-control" id="p_v_type_id" value="6" name="val[p_v_type_id]">
							<table class="table table-hover table-responsive"> 
								<?php 
								$lastkey = 0;
								$rbalCnt = 3;
								?>
								<tr>
									<th>Carrier</th>
									<th>Flight</th>
									<th>Org</th>
									<th>Dest</th>
									<th>ETD</th>
									<th>ETA</th>
								</tr>
								
								<?php 
								if(empty($aRecords) || empty($aRecords['airline_datas'])){
									if(isset($neededVendorData['vendor_airline_datas']) && !empty($neededVendorData['vendor_airline_datas'])){
										$atotCnt = count($neededVendorData['vendor_airline_datas']);
										$rbalCnt = 3 - $atotCnt;
										foreach($neededVendorData['vendor_airline_datas'] as $key => $airdata){
												$airdata = (array) $airdata;
												
											?>
												<tr> 
										<td  class="route_code_div">
											<input type="text" class="form-control " value="<?php echo (isset($airdata['carrier_name']) ? $airdata['carrier_name'] : ''); ?>" id="carrier_name_<?php echo $key;?>" name="airline_datas[carrier_name][]" maxlength="20" autocomplete="off" data-toggle="modal" data-target="#myModaloverlap" onclick="loadVendors('carrier_name_<?php echo $key;?>', 'carrier_id_<?php echo $key;?>', 'all', 'addRoutingAlert');">
											
											<input type="hidden" value="<?php echo (isset($airdata['carrier_id']) ? $airdata['carrier_id'] : ''); ?>" id="carrier_id_<?php echo $key;?>" name="airline_datas[carrier_id][]">
										</td> 
										
										<td>
											<input type="text" class="form-control" value="<?php echo (isset($airdata['flight_name']) ? $airdata['flight_name'] : ''); ?>" id="flight_name" name="airline_datas[flight_name][]" maxlength="75">
										</td>
										
										<td>
											<input type="text" class="form-control" value="<?php echo (isset($airdata['flight_origin']) ? $airdata['flight_origin'] : ''); ?>" id="flight_origin_<?php echo $key;?>" name="airline_datas[flight_origin][]" maxlength="10" autocomplete="off"  data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('flight_origin_<?php echo $key;?>', 'flight_origin_id_<?php echo $key;?>', 'all', 'addRoutingAlert');">
											
											<input type="hidden" value="<?php echo (isset($airdata['flight_origin_id']) ? $airdata['flight_origin_id'] : ''); ?>" id="flight_origin_id_<?php echo $key;?>" name="airline_datas[flight_origin_id][]">
										</td>
										
										<td>
											<input type="text" class="form-control" value="<?php echo (isset($airdata['flight_dest']) ? $airdata['flight_dest'] : ''); ?>" id="flight_dest_<?php echo $key;?>" name="airline_datas[flight_dest][]" maxlength="10"  autocomplete="off" data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('flight_dest_<?php echo $key;?>', 'flight_dest_id_<?php echo $key;?>', 'all', 'addRoutingAlert');">
											
											<input type="hidden" value="<?php echo (isset($airdata['flight_dest_id']) ? $airdata['flight_dest_id'] : ''); ?>" id="flight_dest_id_<?php echo $key;?>" name="airline_datas[flight_dest_id][]">
										</td>
										
										<td>
											<input type="text" class="form-control datetimepicker" value="<?php echo (isset($airdata['flight_dept']) ? $airdata['flight_dept'] : ''); ?>" id="flight_dept" name="airline_datas[flight_dept][]" placeholder="mm/dd/yyyy hh:mm">
										</td>
						
										<td>
											<input type="text" class="form-control datetimepicker" value="<?php echo (isset($airdata['flight_arrival']) ? $airdata['flight_arrival'] : ''); ?>" id="flight_arrival" name="airline_datas[flight_arrival][]" placeholder="mm/dd/yyyy hh:mm">
										</td>
										
									</tr>
								<?php 
										$lastkey = $key;
										}
									}
								}
								if(!empty($aRecords['airline_datas'])){
									$atotCnt = count($aRecords['airline_datas']);
									$rbalCnt = 3 - $atotCnt;
									foreach($aRecords['airline_datas'] as $key => $airdata){
									$airdata = (array) $airdata;
								?>
									<tr> 
										<td  class="route_code_div">
											<input type="text" class="form-control " value="<?php echo (isset($airdata['carrier_name']) ? $airdata['carrier_name'] : ''); ?>" id="carrier_name_<?php echo $key;?>" name="airline_datas[carrier_name][]" maxlength="20" autocomplete="off" data-toggle="modal" data-target="#myModaloverlap" onclick="loadVendors('carrier_name_<?php echo $key;?>', 'carrier_id_<?php echo $key;?>', 'all', 'addRoutingAlert');">
											
											<input type="hidden" value="<?php echo (isset($airdata['carrier_id']) ? $airdata['carrier_id'] : ''); ?>" id="carrier_id_<?php echo $key;?>" name="airline_datas[carrier_id][]">
										</td> 
										
										<td>
											<input type="text" class="form-control" value="<?php echo (isset($airdata['flight_name']) ? $airdata['flight_name'] : ''); ?>" id="flight_name" name="airline_datas[flight_name][]" maxlength="75">
										</td>
										
										<td>
											<input type="text" class="form-control" value="<?php echo (isset($airdata['flight_origin']) ? $airdata['flight_origin'] : ''); ?>" id="flight_origin_<?php echo $key;?>" name="airline_datas[flight_origin][]" maxlength="10" autocomplete="off"  data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('flight_origin_<?php echo $key;?>', 'flight_origin_id_<?php echo $key;?>', 'all', 'addRoutingAlert');">
											
											<input type="hidden" value="<?php echo (isset($airdata['flight_origin_id']) ? $airdata['flight_origin_id'] : ''); ?>" id="flight_origin_id_<?php echo $key;?>" name="airline_datas[flight_origin_id][]">
										</td>
										
										<td>
											<input type="text" class="form-control" value="<?php echo (isset($airdata['flight_dest']) ? $airdata['flight_dest'] : ''); ?>" id="flight_dest_<?php echo $key;?>" name="airline_datas[flight_dest][]" maxlength="10"  autocomplete="off" data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('flight_dest_<?php echo $key;?>', 'flight_dest_id_<?php echo $key;?>', 'all', 'addRoutingAlert');">
											
											<input type="hidden" value="<?php echo (isset($airdata['flight_dest_id']) ? $airdata['flight_dest_id'] : ''); ?>" id="flight_dest_id_<?php echo $key;?>" name="airline_datas[flight_dest_id][]">
										</td>
										
										<td>
											<input type="text" class="form-control datetimepicker" value="<?php echo (isset($airdata['flight_dept']) ? $airdata['flight_dept'] : ''); ?>" id="flight_dept" name="airline_datas[flight_dept][]" placeholder="mm/dd/yyyy hh:mm">
										</td>
						
										<td>
											<input type="text" class="form-control datetimepicker" value="<?php echo (isset($airdata['flight_arrival']) ? $airdata['flight_arrival'] : ''); ?>" id="flight_arrival" name="airline_datas[flight_arrival][]" placeholder="mm/dd/yyyy hh:mm">
										</td>
										
									</tr>
								<?php 
										$lastkey = $key;
									}
								
								}
								if($rbalCnt >= 1){
									for($i=1;$i<=$rbalCnt;$i++){ 
									$lastkey = $lastkey+1;
								?>
										
									<tr>
									
									<td class="route_code_div">
										<input type="text" class="form-control " value="" id="carrier_name_<?php echo $lastkey;?>" name="airline_datas[carrier_name][]" maxlength="20" autocomplete="off" data-toggle="modal" data-target="#myModaloverlap" onclick="loadVendors('carrier_name_<?php echo $lastkey;?>', 'carrier_id_<?php echo $lastkey;?>', 'all', 'addRoutingAlert');">
										
										<input type="hidden" value="" id="carrier_id_<?php echo $lastkey;?>" name="airline_datas[carrier_id][]">
									</td> 
									
									<td>
										<input type="text" class="form-control" value="" id="flight_name" name="airline_datas[flight_name][]" maxlength="75">
									</td>
									
									<td>
										<input type="text" class="form-control" value="" id="flight_origin_<?php echo $lastkey;?>" name="airline_datas[flight_origin][]" maxlength="10" autocomplete="off"  data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('flight_origin_<?php echo $lastkey;?>', 'flight_origin_id_<?php echo $lastkey;?>', 'all', 'addRoutingAlert');">
										
										<input type="hidden" value="" id="flight_origin_id_<?php echo $lastkey;?>" name="airline_datas[flight_origin_id][]">
									</td>
									
									<td>
										<input type="text" class="form-control" value="" id="flight_dest_<?php echo $lastkey;?>" name="airline_datas[flight_dest][]" maxlength="10" autocomplete="off"  data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('flight_dest_<?php echo $lastkey;?>', 'flight_dest_id_<?php echo $lastkey;?>', 'all', 'addRoutingAlert');">
										
										<input type="hidden" value="" id="flight_dest_id_<?php echo $lastkey;?>" name="airline_datas[flight_dest_id][]">
									</td>
									
									<td>
										<input type="text" class="form-control datetimepicker" value="" id="flight_dept" name="airline_datas[flight_dept][]" placeholder="mm/dd/yyyy hh:mm">
									</td>
					
									<td>
										<input type="text" class="form-control datetimepicker" value="" id="flight_arrival" name="airline_datas[flight_arrival][]" placeholder="mm/dd/yyyy hh:mm">
									</td>
									
								</tr>
									
								<?php }
								
								}
								?>
								
								
							  </table>
						</div>
					</div>
					
				</div>

			</div>
			
			
			<div class="row">
				<center><div id="resultdatao"></div></center>
				
				<div class="text-center mt-3 mb-4">
					<a class="btn btn-info btn-sm mr-4" href="javascript:void(0);" <?php echo (empty($aRecords) ? 'style="display:none;"' : '');?> onclick="deleteRoutingAlert(<?php echo $shipInfo['shipment_id']; ?>);">Delete</a>
					<a class="btn btn-info btn-sm mr-4" <?php echo (empty($aRecords) ? 'style="display:none;"' : '');?> target="_blank" href="<?php echo base_url().'routingAlertPdf/'.$shipInfo['shipment_id']; ?>">View</a>
					<a class="btn btn-danger btn-sm mr-4" href="javascript:void(0);" onclick="$('#myModal').modal('toggle');" >Return</a>
					<button type="submit" class="btn btn-success btn-sm">Submit</button>
				</div>
			</div>
			
			
			
			</form>
      </div>
    </div>
  </div>

