<link href="<?php echo base_url(); ?>assets/bower_components/datepicker/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/bower_components/datepicker/jquery.datetimepicker.full.js"></script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-plane"></i> Domestic Shipment Management
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
			
            <!-- left column -->
			<div class="col-md-12">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
			
            <div class="col-md-12">
              <!-- general form elements -->
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Domestic Shipment Details</h3>
						<div class="p-2 bg-info f_right">
						 <?php
							echo (isset($shipInfo['waybill']) ? '#'.$shipInfo['waybill'] : '').'&nbsp; &nbsp; &nbsp;'.(isset($shipInfo['origin_airport_code']) ? $shipInfo['origin_airport_code'] : '').'&nbsp; &nbsp; &nbsp;'.(isset($shipInfo['dest_airport_code']) ? $shipInfo['dest_airport_code'] : '').'&nbsp; &nbsp; &nbsp;'.(isset($shipInfo['shipper_data']['shipper_name']) ? $shipInfo['shipper_data']['shipper_name'] : '').'&nbsp; &nbsp; &nbsp;'.(isset($shipInfo['consignee_data']['c_shipper_name']) ? $shipInfo['consignee_data']['c_shipper_name'] : ''); 
						 ?>
						</div>
                    </div><!-- /.box-header -->
					
					<div id="freight_div_holder" style="display: none;">
							<div class="box-body table-responsive no-padding freight_demo_tr">
							<table class="table table-hover table_freight">
							<tr class="freight_demo_name_div">
								<td>
									<input type="text" class="form-control digits piecesinput" id="pieces" value="<?php echo set_value('pieces'); ?>" name="freight[pieces][]" maxlength="6" onchange="addTotalPiece();addDimFactor(this);" autocomplete="off" >
								</td>
								<td>
									<select class="form-control" id="types" name="freight[types][]">
										<option value="0">Select</option>
										<?php
										if(!empty($types))
										{
											foreach ($types as $type)
											{
												?>
												<option value="<?php echo $type['type_id'] ?>" <?php if($type['type_id'] == set_value('type_id')) {echo "selected=selected";} ?>><?php echo $type['type_name'] ?></option>
												<?php
											}
										}
										?>
									</select>
								</td>
								
								<td>
									<input class="form-check-input freight_haz_div" type="checkbox" value="0" name="freight[haz][]" id="haz">
								</td>
								
								<td>
									<input type="text" class="form-control " id="description" value="<?php echo set_value('description'); ?>" name="freight[description][]" maxlength="75">
								</td>
								
								<td> 
									<input type="text" class="form-control digits weightinput" id="weight" value="<?php echo set_value('weight'); ?>" name="freight[weight][]" maxlength="6" onchange="addTotalWeight();">
								</td>
								
								<td>
									<input type="text" class="form-control digits" id="length" value="<?php echo set_value('length'); ?>" name="freight[length][]" maxlength="6" onchange="addDimFactor(this);" autocomplete="off">
								</td>
								
								<td>
									<input type="text" class="form-control digits" id="width" value="<?php echo set_value('width'); ?>" name="freight[width][]" maxlength="6" onchange="addDimFactor(this);" autocomplete="off">
								</td>
								
								<td>
									<input type="text" class="form-control digits" id="height" value="<?php echo set_value('height'); ?>" name="freight[height][]" maxlength="6" onchange="addDimFactor(this);" autocomplete="off">
								</td>
								
								<td>
									<input type="text" class="form-control digits" id="dim_factor" value="194" name="freight[dim_factor][]" maxlength="10" onchange="addDimFactor(this);">
									<input type="hidden" class="t_dim_weight" id="t_dim_weight" value="" name="freight[t_dim_weight][]" autocomplete="off">
								</td>
								
								<td>
									<select class="form-control" id="types" name="freight[class_id][]">
										<option value="0">Select</option>
										<?php
										if(!empty($classes))
										{
											foreach ($classes as $class)
											{
												?>
												<option value="<?php echo $class['class_id'] ?>" <?php if($class['class_id'] == set_value('class_id')) {echo "selected=selected";} ?>><?php echo $class['class_name'] ?></option>
												<?php
											}
										} 
										?>
									</select>
								</td>
								<td>
									<a class="" role="button" onclick="removeNewFreight(this);">
										<i class="fa fa-remove" style="color:red;"></i>
									</a>
								</td>
								
							</tr>
							</table>
						</div>
						
						<div class="box-body table-responsive no-padding chargecode_demo_tr">
							<table class="table table-hover">

								<tr class="charge_demo_name_div">
									<td style="width:150px;" class="charge_code_name_div">
										<input type="text" class="form-control " value="" id="charge_code_name" name="charge_code[charge_code_name][]" maxlength="20" style="width:80%;float:left;" autocomplete="off" onclick="$(this).next('#chargecode_search_url').click();">
										<a href="javascript:void(0);" id="chargecode_search_url" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModal" onclick="loadChargeCode(this);"><i class="fa fa-search"></i></a>
										<input type="hidden" value="" id="charge_code_id" name="charge_code[charge_code_id][]">
									</td> 
									
									<td>
										<input type="text" class="form-control" value="" id="charge_code_description" name="charge_code[charge_code_description][]" maxlength="75">
									</td>
									
									<td>
										<select class="form-control" id="charge_code_rate_basis" name="charge_code[charge_code_rate_basis][]">
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
										<input type="text" class="form-control digits" value="" id="charge_code_qty" name="charge_code[charge_code_qty][]" maxlength="10" onchange="changechargePrices(this);">
									</td>
									
									<td>
										<input type="text" class="form-control number" value="" id="charge_code_rate" name="charge_code[charge_code_rate][]" maxlength="10" onchange="changechargePrices(this);">
									</td>
									
									<td>
										<input type="text" class="form-control number" value="" id="charge_code_charge" name="charge_code[charge_code_charge][]" maxlength="10" onchange="changechargePrices(this);">
									</td>
					
									<td>
										<input type="text" class="form-control number charge_code_total_cost" value="" id="charge_code_total_cost" name="charge_code[charge_code_total_cost][]" maxlength="10">
									</td>
									<td>
										<a class="" role="button" onclick="removeNewChargeCode(this);">
											<i class="fa fa-remove" style="color:red;"></i>
										</a>
									</td>
								</tr>
						  </table>
						</div>
					</div>

					<div class="line_haul_div_content" style="display:none;">
						<div class="form-group row m-0 mt-3 mb-3">						
							<label class="col-sm-3 col-form-label" for="v_mawb">MAWB#</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="v_mawb" value="<?php echo (isset($shipInfo['v_mawb']) ? $shipInfo['v_mawb'] : ''); ?>" name="vendor_data[v_mawb]" maxlength="20">
							</div>
							<div class="hide">
								<input class="form-check-input text-right" type="checkbox" value="1" name="vendor_data[v_auto_assign]" id="v_auto_assign" <?php echo (isset($shipInfo['v_auto_assign']) && $shipInfo['v_auto_assign'] == 1) ? 'checked' : ''; ?>>
								Auto Assign
							</div>
							<label class="col-sm-3 col-form-label text-right" for="v_account">Account#</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="v_account" value="<?php echo (isset($shipInfo['v_account']) ? $shipInfo['v_account'] : ''); ?>" name="vendor_data[v_account]" maxlength="30">
							</div>
							
						</div>	

						<div class="form-group row m-0 mt-3 mb-3">
							<label class="col-sm-3 col-form-label" for="v_cut_off_time">CutOff</label>
							<div class="col-sm-3">
								<input type="text" class="form-control datenoyeartimepicker" id="v_cut_off_time" value="" name="vendor_data[v_cut_off_time]" placeholder="yyyy/ mm/dd hh:mm">
							</div> 
							<label class="col-sm-2 col-form-label hide" for="v_departure_time">Departure</label>
							<div class="col-sm-2 hide">
								<input type="text" class="form-control datenoyeartimepicker" id="v_departure_time" value="" name="vendor_data[v_departure_time]" placeholder="yyyy/ mm/dd hh:mm">
							</div>

							<label class="col-sm-3 col-form-label text-right" for="v_arrival_time">Arrival</label>
							<div class="col-sm-3">
								<input type="text" class="form-control datenoyeartimepicker" id="v_arrival_time" value="" name="vendor_data[v_arrival_time]" placeholder="yyyy/ mm/dd hh:mm">
							</div>
						</div>
						
					</div>
					
					<div class="airline_div_content" style="display:none;">
						<div class="form-group row m-0 mt-3 mb-3">	
							<label class="col-sm-2 col-form-label" for="v_airline">Airline</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" id="v_airline" value="<?php echo (isset($shipInfo['v_airline']) ? $shipInfo['v_airline'] : ''); ?>" name="vendor_data[v_airline]">
							</div> 
							
							<label class="col-sm-2 col-form-label text-right" for="v_mawb">MAWB#</label>
							<div class="col-sm-2">
								<input type="text" class="form-control mawb_num_format" id="v_mawb" value="<?php echo (isset($shipInfo['v_mawb']) ? $shipInfo['v_mawb'] : ''); ?>" name="vendor_data[v_mawb]" minlength="12" maxlength="30">
							</div>
							<label class="col-sm-2 col-form-label text-right" for="v_account">Account#</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" id="v_account" value="<?php echo (isset($shipInfo['v_account']) ? $shipInfo['v_account'] : ''); ?>" name="vendor_data[v_account]" maxlength="30">
							</div>
						</div>	
						
						<div class="form-group row m-0 mt-3 mb-3">
							<label class="col-sm-3 col-form-label" for="v_cut_off_time">CutOff</label>
							<div class="col-sm-3">
								<input type="text" class="form-control datenoyeartimepicker" id="v_cut_off_time" value="" name="vendor_data[v_cut_off_time]" placeholder="yyyy/ mm/dd hh:mm"> 
							</div> 
							
							<label class="col-sm-3 col-form-label" for="v_service_level">Service Level</label>
							<div class="col-sm-3">
								<select class="form-control" id="v_service_level" name="vendor_data[v_service_level]">
									<option value="0">Select</option> 
									<?php
									if(!empty($airservicelevels))
									{
										foreach ($airservicelevels as $st)
										{
											?>
											<option value="<?php echo $st['service_id'] ?>" <?php if($st['service_id'] == $shipInfo['service_level']) {echo "selected=selected";}?>><?php echo $st['service_name'] ?></option>
											<?php
										}
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="form-group row m-0 mt-3 mb-3">
							<table class="table table-hover"> 
								<thead>
									<tr>
										<th colspan="6" class="text-right"><a href="javascript:void(0);" onclick="$('.extra_airport_code').toggle();if ($(this).text() == 'Add'){$(this).text('Remove');}else{$(this).text('Add');}">Add</th>
									</tr>
								</thead>
								<tr>
									<th>Carrier</th>
									<th>Flight</th>
									<th>Org</th>
									<th>Dest</th>
									<th>Departure</th>
									<th>Arrival</th>
								</tr>
								
								<tr> 
									<td style="width:150px;" class="charge_code_name_div">
										<input type="text" class="form-control " value="" id="carrier_name_1" name="vendor_airline[carrier_name][]" maxlength="20" style="width:80%;float:left;" autocomplete="off" onclick="$(this).next('#carriername_url').click();">
										<a href="javascript:void(0);" id="carriername_url" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModaloverlap" onclick="loadVendors('carrier_name_1', 'carrier_id_1', 'all', 'addVendorShipment');"><i class="fa fa-search"></i></a>
										<input type="hidden" value="" id="carrier_id_1" name="vendor_airline[carrier_id][]">
									</td> 
									
									<td>
										<input type="text" class="form-control" value="" id="flight_name" name="vendor_airline[flight_name][]" maxlength="75">
									</td>
									
									<td>
										<input type="text" class="form-control autocompleteflight" value="<?php echo $shipInfo['origin_airport_code'];?>" id="flight_origin_1" name="vendor_airline[flight_origin][]" maxlength="5" style="width:80%;float:left;" autocomplete="off" data-mainid="flight_origin_1" data-subid="flight_origin_id_1" data-parentid="addVendorShipment">
										
										<a href="javascript:void(0);" id="flight_origin_url" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('flight_origin_1', 'flight_origin_id_1', 'all', 'addVendorShipment');"><i class="fa fa-search"></i></a>
										<input type="hidden" value="" id="flight_origin_id_1" name="vendor_airline[flight_origin_id][]">
									</td>
									
									<td>
										<input type="text" class="form-control autocompleteflight" value="" id="flight_dest_1" name="vendor_airline[flight_dest][]" maxlength="5" style="width:80%;float:left;" autocomplete="off" data-mainid="flight_dest_1" data-subid="flight_dest_id_1" data-parentid="addVendorShipment">
										
										<a href="javascript:void(0);" id="flight_dest_url" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('flight_dest_1', 'flight_dest_id_1', 'all', 'addVendorShipment');"><i class="fa fa-search"></i></a>
										<input type="hidden" value="" id="flight_dest_id_1" name="vendor_airline[flight_dest_id][]">
									</td>
									
									<td>
										<input type="text" class="form-control datetimepicker" value="" id="flight_dept" name="vendor_airline[flight_dept][]" placeholder="mm/dd/yyyy hh:mm">
									</td>
					
									<td>
										<input type="text" class="form-control datetimepicker" value="" id="flight_arrival" name="vendor_airline[flight_arrival][]" placeholder="mm/dd/yyyy hh:mm">
									</td>
									
								</tr>
								
								
								<tr class="extra_airport_code"  style="display:none;">
									<td style="width:150px;" class="charge_code_name_div">
										<input type="text" class="form-control " value="" id="carrier_name_2" name="vendor_airline[carrier_name][]" maxlength="20" style="width:80%;float:left;" autocomplete="off" onclick="$(this).next('#carriername_url').click();">
										
										<a href="javascript:void(0);" id="carriername_url" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModaloverlap" onclick="loadVendors('carrier_name_2', 'carrier_id_2', 'all', 'addVendorShipment');"><i class="fa fa-search"></i></a>
										<input type="hidden" value="" id="carrier_id_2" name="vendor_airline[carrier_id][]">
									</td> 
									
									<td>
										<input type="text" class="form-control" value="" id="flight_name" name="vendor_airline[flight_name][]" maxlength="75">
									</td>
									
									<td>
										<input type="text" class="form-control autocompleteflight" value="" id="flight_origin_2" name="vendor_airline[flight_origin][]" maxlength="5" style="width:80%;float:left;" autocomplete="off"  data-mainid="flight_origin_2" data-subid="flight_origin_id_2" data-parentid="addVendorShipment">
										
										<a href="javascript:void(0);" id="flight_origin_url" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('flight_origin_2', 'flight_origin_id_2', 'all', 'addVendorShipment');"><i class="fa fa-search"></i></a>
										<input type="hidden" value="" id="flight_origin_id_2" name="vendor_airline[flight_origin_id][]">
									</td>
									
									<td>
										<input type="text" class="form-control autocompleteflight" value="" id="flight_dest_2" name="vendor_airline[flight_dest][]" maxlength="5" style="width:80%;float:left;" autocomplete="off"  data-mainid="flight_dest_2" data-subid="flight_dest_id_2" data-parentid="addVendorShipment">
										
										<a href="javascript:void(0);" id="flight_dest_url" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('flight_dest_2', 'flight_dest_id_2', 'all', 'addVendorShipment');"><i class="fa fa-search"></i></a>
										<input type="hidden" value="" id="flight_dest_id_2" name="vendor_airline[flight_dest_id][]">
									</td>
									
									<td>
										<input type="text" class="form-control datetimepicker" value="" id="flight_dept" name="vendor_airline[flight_dept][]" placeholder="mm/dd/yyyy hh:mm">
									</td>
					
									<td>
										<input type="text" class="form-control datetimepicker" value="" id="flight_arrival" name="vendor_airline[flight_arrival][]" placeholder="mm/dd/yyyy hh:mm">
									</td>
									
								</tr>
								
								<tr class="extra_airport_code" style="display:none;">
									<td style="width:150px;" class="charge_code_name_div">
										<input type="text" class="form-control " value="" id="carrier_name_3" name="vendor_airline[carrier_name][]" maxlength="20" style="width:80%;float:left;" autocomplete="off" onclick="$(this).next('#carriername_url').click();">
										<a href="javascript:void(0);" id="carriername_url" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModaloverlap" onclick="loadVendors('carrier_name_3', 'carrier_id_3', 'all', 'addVendorShipment');"><i class="fa fa-search"></i></a>
										<input type="hidden" value="" id="carrier_id_3" name="vendor_airline[carrier_id][]">
									</td> 
									
									<td>
										<input type="text" class="form-control" value="" id="flight_name" name="vendor_airline[flight_name][]" maxlength="75">
									</td>
									
									<td>
										<input type="text" class="form-control autocompleteflight" value="" id="flight_origin_3" name="vendor_airline[flight_origin][]" maxlength="5" style="width:80%;float:left;" autocomplete="off"  data-mainid="flight_origin_3" data-subid="flight_origin_id_3" data-parentid="addVendorShipment">
										
										<a href="javascript:void(0);" id="flight_origin_url" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('flight_origin_3', 'flight_origin_id_3', 'all', 'addVendorShipment');"><i class="fa fa-search"></i></a>
										<input type="hidden" value="" id="flight_origin_id_3" name="vendor_airline[flight_origin_id][]">
									</td>
									
									<td>
										<input type="text" class="form-control autocompleteflight" value="" id="flight_dest_3" name="vendor_airline[flight_dest][]" maxlength="5" style="width:80%;float:left;" autocomplete="off" data-mainid="flight_dest_3" data-subid="flight_dest_id_3" data-parentid="addVendorShipment">
										
										<a href="javascript:void(0);" id="flight_dest_url" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('flight_dest_3', 'flight_dest_id_3', 'all', 'addVendorShipment');"><i class="fa fa-search"></i></a>
										<input type="hidden" value="" id="flight_dest_id_3" name="vendor_airline[flight_dest_id][]">
									</td>
									
									<td>
										<input type="text" class="form-control datetimepicker" value="" id="flight_dept" name="vendor_airline[flight_dept][]" placeholder="mm/dd/yyyy hh:mm">
									</td>
					
									<td>
										<input type="text" class="form-control datetimepicker" value="" id="flight_arrival" name="vendor_airline[flight_arrival][]" placeholder="mm/dd/yyyy hh:mm">
									</td>
									
								</tr>
								
							  </table>
						</div>
					</div>
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addDomesticShipment" action="<?php echo base_url() ?>updateDomesticShipment" method="post" role="form"> 
						<div><input type="hidden" id="opentab" value="<?php echo $opentab;?>"/></div>
						<ul class="nav nav-tabs" id="myTab" role="tablist">
						  <li class="nav-item active">
							<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" aria-expanded="true">Update Shipment</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" id="cost-tab" data-toggle="tab" href="#costbilling" role="tab" aria-controls="costbilling" aria-selected="false">Vendors/Invoicing</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" id="tracking-tab" data-toggle="tab" href="#tracking" role="tab" aria-controls="tracking" aria-selected="false">Tracking</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" id="documents-tab" data-toggle="tab" href="#documents" role="tab" aria-controls="documents" aria-selected="false">Documents</a>
						  </li>
						</ul>

						<div class="tab-content" id="myTabContent">
						  
						<div class="box-body tab-pane fade active in" id="home" role="tabpanel" aria-labelledby="home-tab">
							<?php
							$this->load->view('shipment/shipmenttab');
							?>

                        </div>

						<div class="box-body tab-pane fade" id="costbilling" role="tabpanel" aria-labelledby="cost-tab">
							<?php
							$this->load->view('shipment/vendorstab');
							?>
						</div>
						
						<div class="box-body tab-pane fade" id="tracking" role="tabpanel" aria-labelledby="tracking-tab">
							<?php
							$this->load->view('shipment/trackingstab');
							?>
						</div>
						
						<div class="box-body tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
							<?php
							$this->load->view('shipment/documentstab'); 
							?>
						</div>	
						
					</div><!-- /.box-body -->
    
                       <div class="special_instructions_content_div" style="display:none;">
							<div class="form-group row divbox" id="aapickupbox" <?php echo (isset($shipInfo['sp_ins_datas']['sp_pickup_instructions']) && !empty($shipInfo['sp_ins_datas']['sp_pickup_instructions'])) ? '' : 'style="display:none;"'?> >
								<label class="col-sm-3 col-form-label" for="">Pickup Instructions</label>
								<div class="col-sm-9">
									<textarea name="spdatas[sp_pickup_instructions]" id="sp_pickup_instructions" class="form-control" rows="2"><?php echo isset($shipInfo['sp_ins_datas']['sp_pickup_instructions']) ? $shipInfo['sp_ins_datas']['sp_pickup_instructions'] : ''; ?></textarea>
								</div>
							</div>
							
							<div class="form-group row divbox" id="aadeliveryinstructions" <?php echo (isset($shipInfo['sp_ins_datas']['sp_delivery_instructions']) && !empty($shipInfo['sp_ins_datas']['sp_delivery_instructions']))? '' : 'style="display:none;"'?>>
								<label class="col-sm-3 col-form-label" for="">Delivery Instructions</label>
								<div class="col-sm-9">
									<textarea name="spdatas[sp_delivery_instructions]" id="sp_delivery_instructions" class="form-control" rows="2"><?php echo isset($shipInfo['sp_ins_datas']['sp_delivery_instructions']) ? $shipInfo['sp_ins_datas']['sp_delivery_instructions'] : ''; ?></textarea>
								</div>
							</div>
							
							<div class="form-group row divbox" id="aaspecialinstructions" <?php echo (isset($shipInfo['sp_ins_datas']['sp_special_instructions']) && !empty($shipInfo['sp_ins_datas']['sp_special_instructions'])) ? '' : 'style="display:none;"'?>>
								<label class="col-sm-3 col-form-label" for="">Special Instructions</label>
								<div class="col-sm-9">
									<textarea name="spdatas[sp_special_instructions]" id="sp_special_instructions" class="form-control" rows="2"><?php echo isset($shipInfo['sp_ins_datas']['sp_special_instructions']) ? $shipInfo['sp_ins_datas']['sp_special_instructions'] : ''; ?></textarea>
								</div>
							</div>
							
							<div class="form-group row divbox" id="aaquotenotes" <?php echo (isset($shipInfo['sp_ins_datas']['sp_quote_notes']) && !empty($shipInfo['sp_ins_datas']['sp_quote_notes']))? '' : 'style="display:none;"'?>>
								<label class="col-sm-3 col-form-label" for="">Quote Notes</label>
								<div class="col-sm-9">
									<textarea name="spdatas[sp_quote_notes]" id="sp_quote_notes" class="form-control" rows="2"><?php echo isset($shipInfo['sp_ins_datas']['sp_quote_notes']) ? $shipInfo['sp_ins_datas']['sp_quote_notes'] : ''; ?></textarea>
								</div>
							</div>
							
							<div class="form-group row divbox" id="aainvoicenotes" <?php echo (isset($shipInfo['sp_ins_datas']['sp_invoice_notes']) && !empty($shipInfo['sp_ins_datas']['sp_invoice_notes']))? '' : 'style="display:none;"'?>>
								<label class="col-sm-3 col-form-label" for="">Invoice Notes</label>
								<div class="col-sm-9">
									<textarea name="spdatas[sp_invoice_notes]" id="sp_invoice_notes" class="form-control" rows="2"><?php echo isset($shipInfo['sp_ins_datas']['sp_invoice_notes']) ? $shipInfo['sp_ins_datas']['sp_invoice_notes'] : ''; ?></textarea>
								</div>
							</div>
							
							<div class="form-group row divbox" id="aatransferinstructions" <?php echo (isset($shipInfo['sp_ins_datas']['sp_transfer_instructions']) && !empty($shipInfo['sp_ins_datas']['sp_transfer_instructions']))? '' : 'style="display:none;"'?>>
								<label class="col-sm-3 col-form-label" for="">Transfer Instructions</label>
								<div class="col-sm-9">
									<textarea name="spdatas[sp_transfer_instructions]" id="sp_transfer_instructions" class="form-control" rows="2"><?php echo isset($shipInfo['sp_ins_datas']['sp_transfer_instructions']) ? $shipInfo['sp_ins_datas']['sp_transfer_instructions'] : ''; ?></textarea>
								</div>
							</div>
						</div>
                        <div class="box-footer">
                           <input type="submit" class="btn btn-primary" value="Submit" />
                           <input type="reset" class="btn btn-default" value="Reset" />
                           <a class="btn btn-info" href="<?php echo base_url().'domesticShipment';?>">Domestic Shipment</a>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>    
    </section>
    
</div>
<script src="<?php echo base_url(); ?>assets/js/addDomesticShipment.js" type="text/javascript"></script>