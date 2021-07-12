
<style>
.modal-dialog{width:900px;}
.ui-widget{z-index:9999;}
@media screen and (-webkit-min-device-pixel-ratio:0) {
.datenoyeartimepicker{text-indent:-33px}
}
@-moz-document url-prefix() {
	.datenoyeartimepicker{text-indent:-33px}
} 

</style>
<script type="text/javascript">
$(document).ready(function(){
	
	$("#addVendorShipment").validate({
		
		submitHandler: function(form) {
			var shipment_id = $('#shipment_id').val();
		
			dataString = $("#addVendorShipment").serialize() + "&vendor_data[shipment_id]=" + shipment_id;

			$.ajax({
				type: "POST",
				url: baseURL+"addVendorShipment",
				data: dataString,
				success: function(data){
					
					$("#resultdata").html(data.message); 
					
					if(data.status == 'error'){
						$("#resultdata").addClass("alert alert-danger");
					}else{
						$("#resultdata").addClass("alert alert-success");
					}
					if(data.status == 'success'){
						setTimeout(function(){  
							$('#myModal').modal('toggle');
							$(".displaycontentpopup").html('');
							
							loadSelectedVendors(shipment_id);
							
						}, 1000);
						
					}
				}

			});

			return false;
	    }
	});
	
	$( ".datetimepicker" ).datetimepicker({
		format: 'm/d/Y H:i',
		formatTime: 'H:i',
		formatDate: 'm/d/Y',
		step: 30,
		timepicker: true,
		datepicker: true,
		yearStart: <?php echo date('Y');?>,
	});
	
	$( ".datenoyeartimepicker" ).datetimepicker({
		format: 'Y/m/d H:i',
		formatTime: 'H:i',
		formatDate: 'Y/m/d',
		step: 30,
		timepicker: true,
		datepicker: true,
		minDate:0,
		startDate:new Date(),
		yearStart: <?php echo date('Y');?>,
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
		
		$('[data-toggle="tooltip"]').tooltip();
	
});


function changeVendorPrices(){
	var p_qty = $('#addVendorShipment #p_qty').val();
	var p_rate = $('#addVendorShipment #p_rate').val();
	var p_cost = $('#addVendorShipment #p_cost').val();
	var p_extra = $('#addVendorShipment #p_extra').val();
	var p_tax = $('#addVendorShipment #p_tax').val();
	
	if(p_qty == ''){p_qty =0;}
	if(p_rate == ''){p_rate =0;}
	if(p_cost == ''){p_cost =0;}
	if(p_extra == ''){p_extra =0;}
	if(p_tax == ''){p_tax =0;}
	
	var totalprice = 0;
	if(p_rate != '' && p_rate != 0 && p_rate != '0.00'){
		totalprice = parseFloat(p_qty * p_rate);
	}
	
	if(p_cost != '' && p_cost != 0 && p_cost != '0.00'){
		totalprice = parseFloat(p_cost);
	}
	
	totalprice = totalprice+parseFloat(p_extra) + parseFloat(p_tax);
	$('#addVendorShipment #p_total_cost').val(totalprice);
	
}


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
			<div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body table-responsive no-padding">
                                    
				  <div id="vendor_info_div">
						
						<center><div id="resultdata"></div></center>
						
						<form role="form" id="addVendorShipment" method="post" >
						
							
							<table class="table table-hover">
								<tr class="bg-info">
									<th>Vendor</th>
									<th class="line_haul_div airline_div" <?php echo (($aVendorData['p_v_type_id'] == 6 || $aVendorData['p_v_type_id'] == 7) ? '' : ' style="display:none;"')?>>Origin</th>
									<th class="line_haul_div airline_div" <?php echo (($aVendorData['p_v_type_id'] == 6 || $aVendorData['p_v_type_id'] == 7) ? '' : ' style="display:none;"')?>>Dest</th>
									<th>Ref No</th>
									<th>Rate Basis</th>
									<th>Quantity</th>
									<th>Rate</th>
									<th>Cost</th>
									<th>Extra</th>
									<th>Tax</th>
									<th>Total Cost</th>
								</tr>
								<tr> 
									<td style="width:150px;" class="vendor_info_div_sub" id="vendor_info_data_sub">
										<?php 
										$aAddrss = $aVendorData['customer_name'] .', '.$aVendorData['c_address_1'] .', '.(!empty($aVendorData['c_address_2']) ? $aVendorData['c_address_2'] .', ' : '').$aVendorData['c_city'] . (isset($aVendorData['state_name']) ? ', '.$aVendorData['state_name'] . ' '.$aVendorData['c_zip'] : ''). (isset($aVendorData['country_code']) ? ', '.$aVendorData['country_code'] : ''). (isset($aVendorData['c_phone']) ? ', Phone:'.$aVendorData['c_phone'] : '');
										
										?>
										<input type="text" class="form-control" value="<?php echo (isset($aVendorData['customer_number']) ? $aVendorData['customer_number'] : ''); ?>" id="p_vendor_name" name="vendor_data[p_vendor_name]" maxlength="75" style="width:80%;float:left;" autocomplete="off"  onclick="$('#vendor_search_url').click();" data-toggle="tooltip" data-placement="bottom" title="<?php echo $aAddrss;?>">
										<a href="javascript:void(0);" id="vendor_search_url" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModaloverlap" onclick="loadVendors('p_vendor_name', 'p_vendor_id', 'all', 'addVendorShipment');"><i class="fa fa-search"></i></a>
										<input type="hidden" value="<?php echo (isset($aVendorData['p_v_type_id']) ? $aVendorData['p_v_type_id'] : ''); ?>" id="p_v_type_id" name="vendor_data[p_v_type_id]">
										<input type="hidden" value="<?php echo (isset($aVendorData['p_vendor_id']) ? $aVendorData['p_vendor_id'] : ''); ?>" id="p_vendor_id" name="vendor_data[p_vendor_id]">
									</td>
									
									<td class="line_haul_div airline_div vendor_info_div_sub"  <?php echo (($aVendorData['p_v_type_id'] == 6 || $aVendorData['p_v_type_id'] == 7) ? '' : ' style="display:none;"')?>>
										<!--data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('v_origin', 'v_origin_id', 'all', 'addVendorShipment');"-->
										<input type="text" class="form-control autocompleteflight" value="<?php echo (isset($aVendorData['origin_airport_code']) ? $aVendorData['origin_airport_code'] : ''); ?>" id="v_origin" name="vendor_data[v_origin]" maxlength="5" data-mainid="v_origin" data-subid="v_origin_id" data-parentid="addVendorShipment">
										
										<input type="hidden" value="<?php echo (isset($aVendorData['v_origin_id']) ? $aVendorData['v_origin_id'] : ''); ?>" id="v_origin_id" name="vendor_data[v_origin_id]">
									</td>
									
									<td class="line_haul_div airline_div vendor_info_div_sub" <?php echo (($aVendorData['p_v_type_id'] == 6 || $aVendorData['p_v_type_id'] == 7) ? '' : ' style="display:none;"')?>>
										<!--data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('v_destination', 'v_destination_id', 'all', 'addVendorShipment');"-->
										<input type="text" class="form-control autocompleteflight" value="<?php echo (isset($aVendorData['dest_airport_code']) ? $aVendorData['dest_airport_code'] : ''); ?>" id="v_destination" name="vendor_data[v_destination]" maxlength="5" data-mainid="v_destination" data-subid="v_destination_id" data-parentid="addVendorShipment">
										
										<input type="hidden" value="<?php echo (isset($aVendorData['v_destination_id']) ? $aVendorData['v_destination_id'] : ''); ?>" id="v_destination_id" name="vendor_data[v_destination_id]">
									</td>
									
									<td >
										<input type="text" class="form-control" value="<?php echo (isset($aVendorData['p_ref_name']) ? $aVendorData['p_ref_name'] : ''); ?>" id="p_ref_name" name="vendor_data[p_ref_name]" maxlength="25" style="padding:6px 2px;">
									</td>
									
									<td class="vendor_info_div_sub">
										<select class="form-control" id="rate_basis" name="vendor_data[rate_basis]">
											<option value="0">Select</option>
											<?php
											if(!empty($rate_basis))
											{
												foreach ($rate_basis as $rate)
												{
													?>
													<option value="<?php echo $rate['rate_basis_id']; ?>" <?php if($rate['rate_basis_id'] == $aVendorData['rate_basis']) {echo "selected=selected";} ?>><?php echo $rate['rate_basis_name']; ?></option>
													<?php
												}
											}
											?>
										</select>
									</td>
									
									<td>
										<input type="text" class="form-control number" value="<?php echo (isset($aVendorData['p_qty']) ? $aVendorData['p_qty'] : ''); ?>" id="p_qty" name="vendor_data[p_qty]" maxlength="10" onchange="changeVendorPrices();">
									</td>
									
									<td class="vendor_info_div_sub">
										<input type="text" class="form-control number" value="<?php echo (isset($aVendorData['p_rate']) ? $aVendorData['p_rate'] : ''); ?>" id="p_rate" name="vendor_data[p_rate]" maxlength="10" onchange="changeVendorPrices();">
									</td>
									
									<td class="vendor_info_div_sub">
										<input type="text" class="form-control number" value="<?php echo (isset($aVendorData['p_cost']) ? $aVendorData['p_cost'] : ''); ?>" id="p_cost" name="vendor_data[p_cost]" maxlength="10" onchange="changeVendorPrices();">
									</td>
									
									<td>
										<input type="text" class="form-control" value="<?php echo (isset($aVendorData['p_extra']) ? $aVendorData['p_extra'] : ''); ?>" id="p_extra_front" name="vendor_data[p_extra_front]" maxlength="10" data-toggle="modal" data-target="#myModaloverlap" onclick="loadExtraCharges();" onchange="changeVendorPrices();">
										<input type="hidden" class="form-control" value="<?php echo (isset($aVendorData['p_extra']) ? $aVendorData['p_extra'] : ''); ?>" id="p_extra" name="vendor_data[p_extra]" onchange="changeVendorPrices();">
									</td>
									
									<td class="vendor_info_div_sub">
										<input type="text" class="form-control number" value="<?php echo (isset($aVendorData['p_tax']) ? $aVendorData['p_tax'] : ''); ?>" id="p_tax" name="vendor_data[p_tax]" maxlength="10" onchange="changeVendorPrices();">
									</td>
									
									<td class="vendor_info_div_sub">
										<input type="text" class="form-control number" value="<?php echo (isset($aVendorData['p_total_cost']) ? $aVendorData['p_total_cost'] : ''); ?>" id="p_total_cost" name="vendor_data[p_total_cost]" maxlength="10">
									</td>
								</tr>
								
								
						  </table>
						  
						  <div class="line_haul_div_holder airline_div_holder" >

							<?php if($aVendorData['p_v_type_id'] == 6){ ?>
							
								<div class="form-group row m-0 mt-3 mb-3">	
									<label class="col-sm-2 col-form-label" for="v_airline">Airline</label>
									<div class="col-sm-2">
										<input type="text" class="form-control" id="v_airline" value="<?php echo (isset($aVendorData['v_airline']) ? $aVendorData['v_airline'] : ''); ?>" name="vendor_data[v_airline]">
									</div> 
									
									<label class="col-sm-2 col-form-label text-right" for="v_mawb">MAWB#</label>
									<div class="col-sm-2">
										<input type="text" class="form-control mawb_num_format" id="v_mawb" value="<?php echo (isset($aVendorData['v_mawb']) ? $aVendorData['v_mawb'] : ''); ?>" name="vendor_data[v_mawb]" minlength="12" maxlength="15">
									</div>
									<label class="col-sm-2 col-form-label text-right" for="v_account">Account#</label>
									<div class="col-sm-2">
										<input type="text" class="form-control" id="v_account" value="<?php echo (isset($aVendorData['v_account']) ? $aVendorData['v_account'] : ''); ?>" name="vendor_data[v_account]" maxlength="30">
									</div>
								</div>	
								
								<div class="form-group row m-0 mt-3 mb-3">
									<label class="col-sm-3 col-form-label" for="v_cut_off_time">CutOff</label>
									<div class="col-sm-3">
										<input type="text" class="form-control datenoyeartimepicker" id="v_cut_off_time" value="<?php echo (!empty($aVendorData['v_cut_off_time']) ? date('Y/m/d H:i',strtotime($aVendorData['v_cut_off_time'])) : ''); ?>" name="vendor_data[v_cut_off_time]" placeholder="yyyy/ mm/dd hh:mm">
									</div> 
									
									<label class="col-sm-3 col-form-label" for="v_service_level">Service Level</label>
									<div class="col-sm-3">
										<select class="form-control" id="v_service_level" name="vendor_data[v_service_level]">
											<option value="0">Select</option>
											<?php
											if(!empty($servicelevels))
											{
												foreach ($servicelevels as $st)
												{
													?>
													<option value="<?php echo $st['service_id'] ?>" <?php if($st['service_id'] == $aVendorData['v_service_level']) {echo "selected=selected";}?>><?php echo $st['service_name'] ?></option>
													<?php
												}
											}
											?>
										</select>
									</div>
								</div>
								
								<div class="form-group row m-0 mt-3 mb-3">
									<table class="table table-hover"> 
										<?php 
										$lastkey = 0;
										$rbalCnt = 3;
										if(!empty($aVendorData['vendor_airline_datas'])){
											$atotCnt = count($aVendorData['vendor_airline_datas']);
											$rbalCnt = 3 - $atotCnt;
										}
										if($rbalCnt == 3){
										?>
										
										<thead>
											<tr>
												<th colspan="6" class="text-right"><a href="javascript:void(0);" onclick="$('.extra_airport_code').toggle();if ($(this).text() == 'Add'){$(this).text('Remove');}else{$(this).text('Add');}">Add</th>
											</tr>
										</thead>
										<?php } ?>
										<tr>
											<th>Carrier</th>
											<th>Flight</th>
											<th>Org</th>
											<th>Dest</th>
											<th>Departure</th>
											<th>Arrival</th>
										</tr>
										
										<?php 
										if(!empty($aVendorData['vendor_airline_datas'])){
											
											foreach($aVendorData['vendor_airline_datas'] as $key => $airdata){
											$airdata = (array) $airdata;
										?>
											<tr> 
												<td style="width:150px;" class="charge_code_name_div">
													<input type="text" class="form-control " value="<?php echo (isset($airdata['carrier_name']) ? $airdata['carrier_name'] : ''); ?>" id="carrier_name_<?php echo $key;?>" name="vendor_airline[carrier_name][]" maxlength="20" style="width:80%;float:left;" autocomplete="off" onclick="$(this).next('#carriername_url').click();">
													<a href="javascript:void(0);" id="carriername_url" class="pt-2 pl-1" style="display: inline-block;"data-toggle="modal" data-target="#myModaloverlap" onclick="loadVendors('carrier_name_<?php echo $key;?>', 'carrier_id_<?php echo $key;?>', 'all', 'addVendorShipment');"><i class="fa fa-search"></i></a>
													<input type="hidden" value="<?php echo (isset($airdata['carrier_id']) ? $airdata['carrier_id'] : ''); ?>" id="carrier_id_<?php echo $key;?>" name="vendor_airline[carrier_id][]">
												</td> 
												
												<td>
													<input type="text" class="form-control" value="<?php echo (isset($airdata['flight_name']) ? $airdata['flight_name'] : ''); ?>" id="flight_name" name="vendor_airline[flight_name][]" maxlength="75">
												</td>
												
												<td> 
													<input type="text" class="form-control autocompleteflight" value="<?php echo (isset($airdata['flight_origin']) ? $airdata['flight_origin'] : ''); ?>" id="flight_origin_<?php echo $key;?>" name="vendor_airline[flight_origin][]" maxlength="5" style="width:80%;float:left;" autocomplete="off"  data-mainid="flight_origin_<?php echo $key;?>" data-subid="flight_origin_id_<?php echo $key;?>" data-parentid="addVendorShipment"> 
													
													<a href="javascript:void(0);" id="flight_origin_url" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('flight_origin_<?php echo $key;?>', 'flight_origin_id_<?php echo $key;?>', 'all', 'addVendorShipment');"><i class="fa fa-search"></i></a>
													<input type="hidden" value="<?php echo (isset($airdata['flight_origin_id']) ? $airdata['flight_origin_id'] : ''); ?>" id="flight_origin_id_<?php echo $key;?>" name="vendor_airline[flight_origin_id][]">
												</td>
												
												<td>
													<input type="text" class="form-control autocompleteflight" value="<?php echo (isset($airdata['flight_dest']) ? $airdata['flight_dest'] : ''); ?>" id="flight_dest_<?php echo $key;?>" name="vendor_airline[flight_dest][]" maxlength="5" style="width:80%;float:left;" autocomplete="off"  data-mainid="flight_dest_<?php echo $key;?>" data-subid="flight_dest_id_<?php echo $key;?>" data-parentid="addVendorShipment">
													
													<a href="javascript:void(0);" id="flight_dest_url" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('flight_dest_<?php echo $key;?>', 'flight_dest_id_<?php echo $key;?>', 'all', 'addVendorShipment');"><i class="fa fa-search"></i></a>
													<input type="hidden" value="<?php echo (isset($airdata['flight_dest_id']) ? $airdata['flight_dest_id'] : ''); ?>" id="flight_dest_id_<?php echo $key;?>" name="vendor_airline[flight_dest_id][]">
												</td>
												
												<td>
													<input type="text" class="form-control datetimepicker" value="<?php echo (isset($airdata['flight_dept']) ? $airdata['flight_dept'] : ''); ?>" id="flight_dept" name="vendor_airline[flight_dept][]" placeholder="mm/dd/yyyy hh:mm">
												</td>
								
												<td>
													<input type="text" class="form-control datetimepicker" value="<?php echo (isset($airdata['flight_arrival']) ? $airdata['flight_arrival'] : ''); ?>" id="flight_arrival" name="vendor_airline[flight_arrival][]" placeholder="mm/dd/yyyy hh:mm">
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
												
											<tr <?php echo (($rbalCnt == 3 && $i != 1) ? 'class="extra_airport_code" style="display:none;"' : '');?> >
											
											<td style="width:150px;" class="charge_code_name_div">
												<input type="text" class="form-control " value="" id="carrier_name_<?php echo $lastkey;?>" name="vendor_airline[carrier_name][]" maxlength="20" style="width:80%;float:left;" autocomplete="off" onclick="$(this).next('#carriername_url').click();">
												<a href="javascript:void(0);" id="carriername_url" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModaloverlap" onclick="loadVendors('carrier_name_<?php echo $lastkey;?>', 'carrier_id_<?php echo $lastkey;?>', 'all', 'addVendorShipment');"><i class="fa fa-search"></i></a>
												<input type="hidden" value="" id="carrier_id_<?php echo $lastkey;?>" name="vendor_airline[carrier_id][]">
											</td> 
											
											<td>
												<input type="text" class="form-control" value="" id="flight_name" name="vendor_airline[flight_name][]" maxlength="75">
											</td>
											
											<td>
												<input type="text" class="form-control autocompleteflight" value="" id="flight_origin_<?php echo $lastkey;?>" name="vendor_airline[flight_origin][]" maxlength="5" style="width:80%;float:left;" autocomplete="off"  data-mainid="flight_origin_<?php echo $lastkey;?>" data-subid="flight_origin_id_<?php echo $lastkey;?>" data-parentid="addVendorShipment">
												
												<a href="javascript:void(0);" id="flight_origin_url" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('flight_origin_<?php echo $lastkey;?>', 'flight_origin_id_<?php echo $lastkey;?>', 'all', 'addVendorShipment');"><i class="fa fa-search"></i></a>
												<input type="hidden" value="" id="flight_origin_id_<?php echo $lastkey;?>" name="vendor_airline[flight_origin_id][]">
											</td>
											
											<td>
												<input type="text" class="form-control autocompleteflight" value="" id="flight_dest_<?php echo $lastkey;?>" name="vendor_airline[flight_dest][]" maxlength="5" style="width:80%;float:left;" autocomplete="off"  data-mainid="flight_dest_<?php echo $lastkey;?>" data-subid="flight_dest_id_<?php echo $lastkey;?>" data-parentid="addVendorShipment">
												
												<a href="javascript:void(0);" id="flight_dest_url" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('flight_dest_<?php echo $lastkey;?>', 'flight_dest_id_<?php echo $lastkey;?>', 'all', 'addVendorShipment');"><i class="fa fa-search"></i></a>
												<input type="hidden" value="" id="flight_dest_id_<?php echo $lastkey;?>" name="vendor_airline[flight_dest_id][]">
											</td>
											
											<td>
												<input type="text" class="form-control datetimepicker" value="" id="flight_dept" name="vendor_airline[flight_dept][]" placeholder="mm/dd/yyyy hh:mm">
											</td>
							
											<td>
												<input type="text" class="form-control datetimepicker" value="" id="flight_arrival" name="vendor_airline[flight_arrival][]" placeholder="mm/dd/yyyy hh:mm">
											</td>
											
										</tr>
											
										<?php }
										
										}
										?>
										
										
									  </table>
								</div>
						
							<?php } if($aVendorData['p_v_type_id'] == 7){?>
							
								<div class="form-group row m-0 mt-3 mb-3">						
									<label class="col-sm-3 col-form-label" for="v_mawb">MAWB#</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="v_mawb" value="<?php echo (isset($aVendorData['v_mawb']) ? $aVendorData['v_mawb'] : ''); ?>" name="vendor_data[v_mawb]" maxlength="20">
									</div>
									<div class="hide">
										<input class="form-check-input text-right" type="checkbox" value="1" name="vendor_data[v_auto_assign]" id="v_auto_assign" <?php echo (isset($aVendorData['v_auto_assign']) && $aVendorData['v_auto_assign'] == 1) ? 'checked' : ''; ?>>
										Auto Assign
									</div>
									<label class="col-sm-3 col-form-label text-right" for="v_account">Account#</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="v_account" value="<?php echo (isset($aVendorData['v_account']) ? $aVendorData['v_account'] : ''); ?>" name="vendor_data[v_account]" maxlength="30">
									</div>
									
								</div>	

								<div class="form-group row m-0 mt-3 mb-3">
									<label class="col-sm-3 col-form-label" for="v_cut_off_time">CutOff</label>
									<div class="col-sm-3">
										<input type="text" class="form-control datenoyeartimepicker" id="v_cut_off_time" value="<?php echo (!empty($aVendorData['v_cut_off_time']) ? date('Y/m/d H:i',strtotime($aVendorData['v_cut_off_time'])) : ''); ?>" name="vendor_data[v_cut_off_time]" placeholder="yyyy/ mm/dd hh:mm">
									</div> 
									<label class="col-sm-2 col-form-label hide" for="v_departure_time">Departure</label>
									<div class="col-sm-2 hide">
										<input type="text" class="form-control datenoyeartimepicker" id="v_departure_time" value="<?php echo (!empty($aVendorData['v_departure_time']) ? date('Y/m/d H:i',strtotime($aVendorData['v_departure_time'])) : ''); ?>" name="vendor_data[v_departure_time]" placeholder="yyyy/ mm/dd hh:mm">
									</div>

									<label class="col-sm-3 col-form-label text-right" for="v_arrival_time">Arrival</label>
									<div class="col-sm-3">
										<input type="text" class="form-control datenoyeartimepicker" id="v_arrival_time" value="<?php echo (!empty($aVendorData['v_arrival_time']) ? date('Y/m/d H:i',strtotime($aVendorData['v_arrival_time'])) : ''); ?>" name="vendor_data[v_arrival_time]" placeholder="yyyy/ mm/dd hh:mm">
									</div>
								</div>
						
							<?php } ?>
						  </div>
						  
						  <div class="text-center mb-4">
						  
							<a class="btn btn-info btn-sm mr-4 localpickupbtn" target="_blank" href="<?php echo base_url().'pickupAlertPdf/'.$shipData['shipment_id']; ?>" <?php if($aVendorData['p_v_type_id'] != 5) {echo 'style="display:none;"';}?>>Pickup Alert</a>
							
							<a class="btn btn-info btn-sm mr-4 localpickupbtn" href="javasceipt:void(0);" data-toggle="modal" data-target="#myModalOverlap" onclick="loadRoutingAlert(<?php echo $shipData['shipment_id']; ?>);" <?php if($aVendorData['p_v_type_id'] != 5) {echo 'style="display:none;"';}?>>Routing Alert</a>
							
							<a class="btn btn-info btn-sm mr-4 localpickupbtn" target="_blank" href="<?php echo base_url().'transferAlertPdf/'.$shipData['shipment_id']; ?>" <?php if($aVendorData['p_v_type_id'] != 5) {echo 'style="display:none;"';}?>data-toggle="modal" data-target="#myModaloverlap" onclick="loadTransferAlert(<?php echo $shipData['shipment_id']; ?>);">Transfer Alert</a>
							
							<a class="btn btn-info btn-sm mr-4 localdeliverybtn" target="_blank" href="<?php echo base_url().'deliveryAlertPdf/'.$shipData['shipment_id']; ?>" <?php if($aVendorData['p_v_type_id'] != 8) {echo 'style="display:none;"';}?>>Delivery Alert</a>
							
							<a class="btn btn-info btn-sm mr-4 localdeliverybtn" target="_blank" href="<?php echo base_url().'transferAlertPdf/'.$shipData['shipment_id']; ?>" <?php if($aVendorData['p_v_type_id'] != 8) {echo 'style="display:none;"';}?>data-toggle="modal" data-target="#myModaloverlap" onclick="loadTransferAlert(<?php echo $shipData['shipment_id']; ?>);">Transfer Alert</a>
							
							<a class="btn btn-info btn-sm mr-4 localpickupbtn" href="<?php echo base_url().'dommawb/'.$shipData['shipment_id']; ?>" target="_blank" <?php if($aVendorData['p_v_type_id'] != 6 && $aVendorData['p_v_type_id'] != 7) {echo 'style="display:none;"';}?>>MAWB</a>
							
							<label class="col-form-label mr-4">
								<input class="form-check-input" type="checkbox" value="1" name="vendor_data[p_finalize]" id="p_finalize" <?php if($aVendorData['p_finalize'] == 1) {echo "checked";} ?>>
								Finalize
							</label>
							<a class="btn btn-danger btn-sm mr-4" href="javascript:void(0);" onclick="$('#myModal').modal('toggle');">Cancel</a>
							<button type="submit" class="btn btn-info btn-sm">Update</button>
						  </div>
					  
					  </form> 
				  </div>
				  
				 
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
      </div>
    </div>
  </div>

