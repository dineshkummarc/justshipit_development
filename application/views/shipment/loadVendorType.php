
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
                  <table class="table table-hover" id="vendor_table" style="max-width: 500px;margin: 0 auto;">
                    <tr class="bg-info">
                        <th></th>
                        <th>Vendor Type</th>
                        <th>Short Code</th>
                    </tr>
                    <?php
                    if(!empty($aRecords))
                    {
                        foreach($aRecords as $record)
                        {
                    ?> 
                    <tr>
                        <td><a href="javascript:void(0);" onclick="setVendorType(<?php echo $record->v_type_id ?>);">Select</a></td>
                        <td><?php echo $record->vendor_type ?></td>
                        <td><?php echo $record->vendor_short_code ?></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>
                  
				  <div id="vendor_info_div" style="display:none;">
						
						<center><div id="resultdata"></div></center>
						
						<form role="form" id="addVendorShipment" method="post" >
						
							
						
							<table class="table table-hover">
								<tr class="bg-info">
									<th>Vendor</th>
									<th class="line_haul_div airline_div" style="display:none;">Origin</th>
									<th class="line_haul_div airline_div" style="display:none;">Dest</th>
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
									<td style="width:150px;" class="vendor_info_div_sub" id="vendor_info_data_sub_1">
										<input type="text" class="form-control" value="" id="p_vendor_name" name="vendor_data[p_vendor_name]" maxlength="75" style="width:80%;float:left;" autocomplete="off"  onclick="$('#vendor_search_url').click();" data-toggle="tooltip" data-placement="bottom" title="">
										<a href="javascript:void(0);" id="vendor_search_url" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModaloverlap" onclick="loadVendors('p_vendor_name', 'p_vendor_id', 'all', 'addVendorShipment');"><i class="fa fa-search"></i></a>
										<input type="hidden" value="" id="p_v_type_id" name="vendor_data[p_v_type_id]">
										<input type="hidden" value="" id="p_vendor_id" name="vendor_data[p_vendor_id]"> 
									</td>
									
									<td class="line_haul_div airline_div vendor_info_div_sub"  style="display:none;">
										<!--data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('v_origin', 'v_origin_id', 'all', 'addVendorShipment');"-->
										<input type="text" class="form-control autocompleteflight" value="<?php echo $shipData['origin_airport_code'];?>" id="v_origin" name="vendor_data[v_origin]" maxlength="5" data-mainid="v_origin" data-subid="v_origin_id" data-parentid="addVendorShipment">
										<input type="hidden" value="<?php echo $shipData['origin_airport_id'];?>" id="v_origin_id" name="vendor_data[v_origin_id]">
									</td>
									
									<td class="line_haul_div airline_div vendor_info_div_sub"  style="display:none;">
										<!-- data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('v_destination', 'v_destination_id', 'all', 'addVendorShipment');"-->
										<input type="text" class="form-control autocompleteflight" value="<?php echo $shipData['dest_airport_code'];?>" id="v_destination" name="vendor_data[v_destination]" maxlength="5" data-mainid="v_destination" data-subid="v_destination_id" data-parentid="addVendorShipment">
										
										<input type="hidden" value="<?php echo $shipData['dest_airport_id'];?>" id="v_destination_id" name="vendor_data[v_destination_id]">
									</td>
									
									<td >
										<input type="text" class="form-control" value="<?php echo $shipData['waybill'];?>" id="p_ref_name" name="vendor_data[p_ref_name]" maxlength="25" style="padding:6px 2px;">
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
													<option value="<?php echo $rate['rate_basis_id']; ?>"><?php echo $rate['rate_basis_name']; ?></option>
													<?php
												}
											}
											?>
										</select>
									</td>
									
									<td>
										<input type="text" class="form-control number" value="<?php echo $shipData['total_actual_weight'];?>" id="p_qty" name="vendor_data[p_qty]" maxlength="10" onchange="changeVendorPrices();">
									</td>
									
									<td class="vendor_info_div_sub">
										<input type="text" class="form-control number" value="" id="p_rate" name="vendor_data[p_rate]" maxlength="10" onchange="changeVendorPrices();">
									</td>
									
									<td class="vendor_info_div_sub">
										<input type="text" class="form-control number" value="" id="p_cost" name="vendor_data[p_cost]" maxlength="10" onchange="changeVendorPrices();">
									</td>
									
									<td>
										<input type="text" class="form-control" value="<?php echo $shipData['tot_extra_charge'];?>" id="p_extra_front" name="vendor_data[p_extra_front]" maxlength="10" data-toggle="modal" data-target="#myModaloverlap" onclick="loadExtraCharges();" onchange="changeVendorPrices();">
										<input type="hidden" class="form-control" value="<?php echo $shipData['tot_extra_charge'];?>" id="p_extra" name="vendor_data[p_extra]" onchange="changeVendorPrices();">
									</td>
									
									<td class="vendor_info_div_sub">
										<input type="text" class="form-control number" value="" id="p_tax" name="vendor_data[p_tax]" maxlength="10" onchange="changeVendorPrices();">
									</td>
									
									<td class="vendor_info_div_sub">
										<input type="text" class="form-control number" value="<?php echo $shipData['tot_extra_charge'];?>" id="p_total_cost" name="vendor_data[p_total_cost]" maxlength="10">
									</td>
								</tr>
								
								
						  </table>
						  
						  <div class="line_haul_div_holder airline_div_holder"  style="display:none;">

						  </div>
						  
						  <div class="text-center mb-4">
						  
							<a class="btn btn-info btn-sm mr-4 localpickupbtn" target="_blank" href="<?php echo base_url().'pickupAlertPdf/'.$shipData['shipment_id']; ?>" style="display:none;">Pickup Alert</a>
							
							<a class="btn btn-info btn-sm mr-4 localpickupbtn" href="javasceipt:void(0);" data-toggle="modal" data-target="#myModalOverlap" onclick="loadRoutingAlert(<?php echo $shipData['shipment_id']; ?>);" style="display:none;">Routing Alert</a>
							
							<a class="btn btn-info btn-sm mr-4 localpickupbtn" href="javascript:void(0);" style="display:none;" data-toggle="modal" data-target="#myModaloverlap" onclick="loadTransferAlert(<?php echo $shipData['shipment_id']; ?>);">Transfer Alert</a>
							
							<a class="btn btn-info btn-sm mr-4 localdeliverybtn" target="_blank" href="<?php echo base_url().'deliveryAlertPdf/'.$shipData['shipment_id']; ?>" style="display:none;">Delivery Alert</a>
							
							<a class="btn btn-info btn-sm mr-4 localdeliverybtn" href="javascript:void(0);" style="display:none;" data-toggle="modal" data-target="#myModaloverlap" onclick="loadTransferAlert(<?php echo $shipData['shipment_id']; ?>);">Transfer Alert</a>
							
							
							<label class="col-form-label mr-4">
								<input class="form-check-input" type="checkbox" value="1" name="vendor_data[p_finalize]" id="p_finalize">
								Finalize
							</label>
							<a class="btn btn-danger btn-sm mr-4" href="javascript:void(0);" onclick="resetVendorType();">Return</a>
							
							 <input type="submit" class="btn btn-info btn-sm" value="Submit" />
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

