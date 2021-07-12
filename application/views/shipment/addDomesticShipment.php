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
                        <h3 class="box-title">Enter Domestic Shipment Details</h3>
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
									<input class="form-check-input" type="checkbox" value="1" name="freight[haz][]" id="haz">
								</td>
								
								<td>
									<input type="text" class="form-control " id="description" value="<?php echo set_value('description'); ?>" name="freight[description][]" maxlength="75">
								</td>
								
								<td>
									<input type="text" class="form-control digits weightinput" id="weight" value="<?php echo set_value('weight'); ?>" name="freight[weight][]" maxlength="6" onchange="addTotalWeight();" autocomplete="off">
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
									<input type="hidden" class="t_dim_weight" id="t_dim_weight" value="" name="freight[t_dim_weight][]"  autocomplete="off">
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
					</div>

                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addDomesticShipment" action="<?php echo base_url() ?>saveNewDomesticShipment" method="post" role="form">
                        <div class="box-body">
							<div><input type="hidden" id="opentab" value=""/></div> 
                            <div class="row m-0 border_bottom_2x">
								<div class="col-md-4 border_right_2x">
										<div class="text-center bg-info p-2 font-weight-bold f16">Shipper</div>
									
										<div class="form-group row mt-4">
											<label class="col-sm-3 col-form-label" for="s_shipper_id">ID</label>
											<div class="col-sm-6">
												<input type="text" class="form-control ui-autocomplete-input" id="s_shipper_id" value="<?php echo set_value('s_shipper_id'); ?>" name="shipper_data[s_shipper_id]" maxlength="10">
											</div>
											<div class="col-sm-3" style="margin-top: 5px;">
												<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" onclick="loadShipper();"><i class="fa fa-user-circle"></i></a> 
												
												<a href="javascript:void(0);" class="ml-4 "><i class="fa fa-question"></i></a>
											</div>
										</div>
										
									<div class="form-group row shipper_trader_div hide">
										<label class="col-sm-3 col-form-label" for="show_name">Show Name</label>
										<div class="col-sm-9">
											<input type="text" class="form-control shipper_trade" value="<?php echo set_value('show_name'); ?>" id="show_name" name="shipper_data[show_name]" maxlength="128">
										</div>
									</div>	
									<div class="form-group row shipper_trader_div hide">
										<label class="col-sm-3 col-form-label" for="exhibitor_name">Exhibitor Name</label>
										<div class="col-sm-9">
											<input type="text" class="form-control shipper_trade" value="<?php echo set_value('exhibitor_name'); ?>" id="exhibitor_name" name="shipper_data[exhibitor_name]" maxlength="128">
										</div>
										
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label requiredcus" for="shipper_name">Name</label>
										<div class="col-sm-9">
											<input type="text" class="form-control required" value="<?php echo set_value('shipper_name'); ?>" id="shipper_name" name="shipper_data[shipper_name]" maxlength="128">
											<input type="hidden" class="form-control" value="<?php echo set_value('org_s_shipper_id'); ?>" id="org_s_shipper_id" name="shipper_data[org_s_shipper_id]" >
											<input type="hidden" class="form-control" value="<?php echo set_value('shipper_trade_show'); ?>" id="shipper_trade_show" name="shipper_data[shipper_trade_show]" >
										</div>
									</div>
									
									<div class="form-group row shipper_trader_div hide">
										<label class="col-sm-3 col-form-label" for="booth_name">Booth</label>
										<div class="col-sm-9">
											<input type="text" class="form-control shipper_trade" value="<?php echo set_value('booth_name'); ?>" id="booth_name" name="shipper_data[booth_name]" maxlength="128">
										</div>
									</div>
									
									<div class="form-group row shipper_trader_div hide">
										<label class="col-sm-3 col-form-label" for="decorator_name">Decorator</label>
										<div class="col-sm-9">
											<input type="text" class="form-control shipper_trade" value="<?php echo set_value('decorator_name'); ?>" id="decorator_name" name="shipper_data[decorator_name]" maxlength="128">
										</div>
										
									</div>
									
															
									<div class="form-group row">
										<label class="col-sm-3 col-form-label requiredcus" for="s_address_1">Address 1</label>
										<div class="col-sm-9">
											
											<textarea name='shipper_data[s_address_1]' id="s_address_1" class="form-control required" rows="1"><?php echo set_value('s_address_1')?></textarea>
										</div>
									</div>
							
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="s_address_2">Address 2</label>
										<div class="col-sm-9">
											<textarea name='shipper_data[s_address_2]' id="s_address_2" class="form-control" rows="1"><?php echo set_value('s_address_2')?></textarea>
										</div>
									</div>
							
									<div class="form-group row">
										<label class="col-sm-3 col-form-label requiredcus" for="s_city">City</label>
										<div class="col-sm-7">
											<input type="text" class="form-control required" value="<?php echo set_value('s_city'); ?>" id="s_city" name="shipper_data[s_city]" maxlength="128">
										</div>
										<div class="col-sm-2" style="margin-top: 5px;">
											<a href="javascript:void(0);" id="shipper_address_url"><i class="fa fa-search"></i></a>
										</div>
									</div>
										
									<div class="form-group row">
										<label class="col-sm-3 col-form-label requiredcus" for="st_zip_country">St/Zip/Cn</label>
										<div class="col-sm-3 pr-0">
											<select class="form-control required" id="s_state" name="shipper_data[s_state]">
												<option value="0">State</option>
												<?php
												if(!empty($states))
												{
													foreach ($states as $st)
													{
														?>
														<option value="<?php echo $st['state_id'] ?>" <?php if($st['state_id'] == set_value('s_state')) {echo "selected=selected";} ?>><?php echo $st['state_name'] ?></option>
														<?php
													}
												}
												?>
											</select>
										</div>
										<div class="col-sm-3 pr-0">
											<input type="text" class="form-control zip_en_data" value="<?php echo set_value('s_zip'); ?>" id="s_zip" name="shipper_data[s_zip]" placeholder="Zip" maxlength="8">
										</div>
										<div class="col-sm-3 pr-0">
											<select class="form-control required" id="s_country" name="shipper_data[s_country]">
												<option value="0">Country</option>
												<?php
												if(!empty($countries))
												{
													foreach ($countries as $rl)
													{
														?>
														<option value="<?php echo $rl['country_id'] ?>" <?php if($rl['country_id'] == set_value('s_country')) {echo "selected=selected";} ?>><?php echo $rl['country_name'] ?></option>
														<?php
													}
												}
												?>
											</select>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="st_zip_country">Phone/Fax</label>
										<div class="col-sm-4 pr-0">
											<input type="text" class="form-control us_phone_num_design" id="s_phone" value="<?php echo set_value('s_phone'); ?>" name="shipper_data[s_phone]" maxlength="14" placeholder="Phone">
										</div>
										<div class="col-sm-4 pr-0">
											<input type="text" class="form-control us_phone_num_design" id="s_fax" value="<?php echo set_value('s_fax'); ?>" name="shipper_data[s_fax]" maxlength="14" placeholder="Fax">
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="st_zip_country">Contact/Email</label>
										<div class="col-sm-4 pr-0">
											<input type="text" class="form-control" id="s_contact" value="<?php echo set_value('s_contact'); ?>" name="shipper_data[s_contact]" maxlength="128" placeholder="Contact">
										</div>
										<div class="col-sm-4 pr-0">
											<input type="text" class="form-control email" id="s_email" value="<?php echo set_value('s_email'); ?>" name="shipper_data[s_email]" maxlength="128" placeholder="Email">
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="s_default_ref">Reference#</label>
										<div class="col-sm-4 pr-0">
											<input type="text" class="form-control" id="s_default_ref" value="<?php echo set_value('s_default_ref'); ?>" name="shipper_data[s_default_ref]" maxlength="128" placeholder="Reference #">
										</div>
										<div class="col-sm-4 pr-0">
											<select class="form-control" id="s_def_ref_type" name="shipper_data[s_def_ref_type]">
												<option value="0">Select One</option>
												<?php
												if(!empty($reftypes))
												{
													foreach ($reftypes as $rt)
													{
														?>
														<option value="<?php echo $rt['ref_id'] ?>" <?php if($rt['ref_id'] == set_value('s_def_ref_type')) {echo "selected=selected";} ?>><?php echo $rt['ref_name'] ?></option>
														<?php
													}
												}
												?>
											</select>
										</div>
									</div>
									
									<div class="form-group row shipper_trader_div hide">
										<label class="col-sm-3 col-form-label" for="s_store_number">Store No.</label>
										<div class="col-sm-9">
											<input type="text" class="form-control shipper_trade" value="<?php echo set_value('s_store_number'); ?>" id="s_store_number" name="shipper_data[s_store_number]" maxlength="128">
										</div>
										
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for=""></label>
										<div class="col-sm-4">
											<a href="javascript:void(0);" class="btn btn-info">Add More</a>
										</div>
										<div class="col-sm-4">
											<a href="javascript:void(0);" onclick="toggleshippingTrader();" class="btn btn-info">Trade Show</a>
										</div>
									</div>
									
								</div>
								
								<div class="col-md-4 border_right_2x">
									<div class="text-center bg-info p-2 font-weight-bold f16">Consignee</div>
									<div class="form-group row mt-4">
											<label class="col-sm-1 col-form-label" for="c_shipper_id"></label>
											<div class="col-sm-6">
												<input type="text" class="form-control ui-autocomplete-input" id="c_shipper_id" value="<?php echo set_value('c_shipper_id'); ?>" name="consignee_data[c_shipper_id]" maxlength="10">
											</div>
											<div class="col-sm-3" style="margin-top: 5px;">
												<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" onclick="loadConsignee();"><i class="fa fa-user-circle"></i></a> 
												<a href="javascript:void(0);" class="ml-4 "><i class="fa fa-question"></i></a>
											</div>
										</div>
									
									<div class="form-group row consignee_trader_div hide">
										<label class="col-sm-3 col-form-label" for="show_name">Show Name</label>
										<div class="col-sm-9">
											<input type="text" class="form-control consignee_trade" value="<?php echo set_value('show_name'); ?>" id="show_name" name="consignee_data[show_name]" maxlength="128">
										</div>
									</div>	
									<div class="form-group row consignee_trader_div hide">
										<label class="col-sm-3 col-form-label" for="exhibitor_name">Exhibitor Name</label>
										<div class="col-sm-9">
											<input type="text" class="form-control consignee_trade" value="<?php echo set_value('exhibitor_name'); ?>" id="exhibitor_name" name="consignee_data[exhibitor_name]" maxlength="128">
										</div>
										
									</div>
									
									<div class="form-group row">
										<label class="col-sm-1 col-form-label requiredcus" for="c_shipper_name"></label>
										<div class="col-sm-9">
											<input type="text" class="form-control required" value="<?php echo set_value('c_shipper_name'); ?>" id="c_shipper_name" name="consignee_data[c_shipper_name]" maxlength="128">
											<input type="hidden" class="form-control" value="<?php echo set_value('org_c_shipper_id'); ?>" id="org_c_shipper_id" name="consignee_data[org_c_shipper_id]" >
											<input type="hidden" class="form-control" value="<?php echo set_value('consignee_trade_show'); ?>" id="consignee_trade_show" name="consignee_data[consignee_trade_show]" >
										</div>
									</div>
											
									<div class="form-group row consignee_trader_div hide">
										<label class="col-sm-3 col-form-label" for="booth_name">Booth</label>
										<div class="col-sm-9">
											<input type="text" class="form-control consignee_trade" value="<?php echo set_value('booth_name'); ?>" id="booth_name" name="consignee_data[booth_name]" maxlength="128">
										</div>
									</div>
									
									<div class="form-group row consignee_trader_div hide">
										<label class="col-sm-3 col-form-label" for="decorator_name">Decorator</label>
										<div class="col-sm-9">
											<input type="text" class="form-control consignee_trade" value="<?php echo set_value('decorator_name'); ?>" id="decorator_name" name="consignee_data[decorator_name]" maxlength="128">
										</div>
										
									</div>
									
									<div class="form-group row">
										<label class="col-sm-1 col-form-label requiredcus" for="c_address_1"></label>
										<div class="col-sm-9">
											
											<textarea name='consignee_data[c_address_1]' id="c_address_1" class="form-control required" rows="1"><?php echo set_value('c_address_1')?></textarea>
										</div>
									</div>
							
									<div class="form-group row">
										<label class="col-sm-1 col-form-label" for="c_address_2"></label>
										<div class="col-sm-9">
											<textarea name='consignee_data[c_address_2]' id="c_address_2" class="form-control" rows="1"><?php echo set_value('c_address_2')?></textarea>
										</div>
									</div>
							
									<div class="form-group row">
										<label class="col-sm-1 col-form-label requiredcus" for="c_city"></label>
										<div class="col-sm-7">
											<input type="text" class="form-control required" value="<?php echo set_value('c_city'); ?>" id="c_city" name="consignee_data[c_city]" maxlength="128">
										</div>
										<div class="col-sm-2" style="margin-top: 5px;">
											<a href="javascript:void(0);" id="consignee_address_url"><i class="fa fa-search"></i></a>
										</div>
									</div>
										
									<div class="form-group row">
										<label class="col-sm-1 col-form-label requiredcus" for="c_state"></label>
										<div class="col-sm-3 pr-0">
											<select class="form-control required" id="c_state" name="consignee_data[c_state]">
												<option value="0">State</option>
												<?php
												if(!empty($states))
												{
													foreach ($states as $st)
													{
														?>
														<option value="<?php echo $st['state_id'] ?>" <?php if($st['state_id'] == set_value('c_state')) {echo "selected=selected";} ?>><?php echo $st['state_name'] ?></option>
														<?php
													}
												}
												?>
											</select>
										</div>
										<div class="col-sm-3 pr-0">
											<input type="text" class="form-control zip_en_data" value="<?php echo set_value('c_zip'); ?>" id="c_zip" name="consignee_data[c_zip]" placeholder="Zip" maxlength="8">
										</div>
										<div class="col-sm-3 pr-0">
											<select class="form-control required" id="c_country" name="consignee_data[c_country]">
												<option value="0">Country</option>
												<?php
												if(!empty($countries))
												{
													foreach ($countries as $rl)
													{
														?>
														<option value="<?php echo $rl['country_id'] ?>" <?php if($rl['country_id'] == set_value('c_country')) {echo "selected=selected";} ?>><?php echo $rl['country_name'] ?></option>
														<?php
													}
												}
												?>
											</select>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-1 col-form-label" for="st_zip_country"></label>
										<div class="col-sm-4 pr-0">
											<input type="text" class="form-control us_phone_num_design" id="c_phone" value="<?php echo set_value('c_phone'); ?>" name="consignee_data[c_phone]" maxlength="14" placeholder="Phone">
										</div>
										<div class="col-sm-4 pr-0">
											<input type="text" class="form-control us_phone_num_design" id="c_fax" value="<?php echo set_value('c_fax'); ?>" name="consignee_data[c_fax]" maxlength="14" placeholder="Fax">
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-1 col-form-label" for="st_zip_country"></label>
										<div class="col-sm-4 pr-0">
											<input type="text" class="form-control" id="c_contact" value="<?php echo set_value('c_contact'); ?>" name="consignee_data[c_contact]" maxlength="128" placeholder="Contact">
										</div>
										<div class="col-sm-4 pr-0">
											<input type="text" class="form-control email" id="c_email" value="<?php echo set_value('c_email'); ?>" name="consignee_data[c_email]" maxlength="128" placeholder="Email">
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-1 col-form-label" for="c_default_ref"></label>
										<div class="col-sm-4 pr-0">
											<input type="text" class="form-control" id="c_default_ref" value="<?php echo set_value('c_default_ref'); ?>" name="consignee_data[c_default_ref]" maxlength="128" placeholder="Reference #">
										</div>
										<div class="col-sm-4 pr-0">
											<select class="form-control" id="c_def_ref_type" name="consignee_data[c_def_ref_type]">
												<option value="0">Select One</option>
												<?php
												if(!empty($reftypes))
												{
													foreach ($reftypes as $rt)
													{
														?>
														<option value="<?php echo $rt['ref_id'] ?>" <?php if($rt['ref_id'] == set_value('c_def_ref_type')) {echo "selected=selected";} ?>><?php echo $rt['ref_name'] ?></option>
														<?php
													}
												}
												?>
											</select>
										</div>
									</div>
									
									
									<div class="form-group row consignee_trader_div hide">
										<label class="col-sm-3 col-form-label" for="c_store_number">Store No.</label>
										<div class="col-sm-9">
											<input type="text" class="form-control consignee_trade" value="<?php echo set_value('c_store_number'); ?>" id="c_store_number" name="consignee_data[c_store_number]" maxlength="128">
										</div>
										
									</div>
									
									<div class="form-group row">
										<label class="col-sm-1 col-form-label" for=""></label>
										<div class="col-sm-4">
											<a href="javascript:void(0);" class="btn btn-info">Add More</a>
										</div>
										<div class="col-sm-4">
											<a href="javascript:void(0);" onclick="toggleConsigneeTrader();"  class="btn btn-info">Trade Show</a>
										</div>
									</div>
									
								</div>
								
								<div class="col-md-4">
									
									<div class="text-center bg-info p-2 ">
										<span class="font-weight-bold f16">Bill-To</span>
										<label class="col-form-label font-weight-normal">
											<input class="form-check-input" type="radio" name="bill_to" id="bill_to" value="1" onclick="changeBilltoData(1);">
											Prepaid
										</label>&nbsp;&nbsp;
										<label class="col-form-label font-weight-normal">
											<input class="form-check-input" type="radio" name="bill_to" id="bill_to" value="2" onclick="changeBilltoData(2);">
											Collect
										</label>&nbsp;&nbsp;
										<label class="col-form-label font-weight-normal">
											<input class="form-check-input" type="radio" name="bill_to" id="bill_to" value="3" onclick="changeBilltoData(3);">
											3rd Party
										</label> 
									</div>
									
									
									<div class="form-group row mt-4">
											<label class="col-sm-1 col-form-label requiredcus" for="b_shipper_id"></label>
											<div class="col-sm-6">
												<input type="text" class="form-control ui-autocomplete-input" id="b_shipper_id" value="<?php echo set_value('b_shipper_id'); ?>" name="bill_to_data[b_shipper_id]" maxlength="10">
											</div>
											<div class="col-sm-3" style="margin-top: 5px;">
												<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" onclick="loadBillto();"><i class="fa fa-user-circle"></i></a> 
												<a href="javascript:void(0);" class="ml-4 "><i class="fa fa-question"></i></a>
											</div>
										</div>
										
										<div class="form-group row">
										<label class="col-sm-1 col-form-label" for="b_shipper_name"></label>
										<div class="col-sm-9">
											<input type="text" class="form-control required" value="<?php echo set_value('b_shipper_name'); ?>" id="b_shipper_name" name="bill_to_data[b_shipper_name]" maxlength="128">
											<input type="hidden" class="form-control" value="<?php echo set_value('org_b_shipper_id'); ?>" id="org_b_shipper_id" name="bill_to_data[org_b_shipper_id]" >
										</div>
									</div>
															
									<div class="form-group row">
										<label class="col-sm-1 col-form-label" for="b_address_1"></label>
										<div class="col-sm-9">
											
											<textarea name='bill_to_data[b_address_1]' id="b_address_1" class="form-control required" rows="1"><?php echo set_value('b_address_1')?></textarea>
										</div>
									</div>
							
									<div class="form-group row">
										<label class="col-sm-1 col-form-label" for="b_address_2"></label>
										<div class="col-sm-9">
											<textarea name='bill_to_data[b_address_2]' id="b_address_2" class="form-control" rows="1"><?php echo set_value('b_address_2')?></textarea>
										</div>
									</div>
							
									<div class="form-group row">
										<label class="col-sm-1 col-form-label" for="b_city"></label>
										<div class="col-sm-7">
											<input type="text" class="form-control required" value="<?php echo set_value('b_city'); ?>" id="b_city" name="bill_to_data[b_city]" maxlength="128">
										</div>
										<div class="col-sm-2" style="margin-top: 5px;">
											<a href="javascript:void(0);" id="billto_address_url"><i class="fa fa-search"></i></a>
										</div>
									</div>
										
									<div class="form-group row">
										<label class="col-sm-1 col-form-label" for="b_state"></label>
										<div class="col-sm-3 pr-0">
											<select class="form-control required" id="b_state" name="bill_to_data[b_state]">
												<option value="0">State</option>
												<?php
												if(!empty($states))
												{
													foreach ($states as $st)
													{
														?>
														<option value="<?php echo $st['state_id'] ?>" <?php if($st['state_id'] == set_value('b_state')) {echo "selected=selected";} ?>><?php echo $st['state_name'] ?></option>
														<?php
													}
												}
												?>
											</select>
										</div>
										<div class="col-sm-3 pr-0">
											<input type="text" class="form-control zip_en_data" value="<?php echo set_value('b_zip'); ?>" id="b_zip" name="bill_to_data[b_zip]" placeholder="Zip" maxlength="8">
										</div>
										<div class="col-sm-3 pr-0">
											<select class="form-control required" id="b_country" name="bill_to_data[b_country]">
												<option value="0">Country</option>
												<?php
												if(!empty($countries))
												{
													foreach ($countries as $rl)
													{
														?>
														<option value="<?php echo $rl['country_id'] ?>" <?php if($rl['country_id'] == set_value('b_country')) {echo "selected=selected";} ?>><?php echo $rl['country_name'] ?></option>
														<?php
													}
												}
												?>
											</select>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-1 col-form-label" for="st_zip_country"></label>
										<div class="col-sm-4 pr-0">
											<input type="text" class="form-control us_phone_num_design" id="b_phone" value="<?php echo set_value('b_phone'); ?>" name="bill_to_data[b_phone]" maxlength="14" placeholder="Phone">
										</div>
										<div class="col-sm-4 pr-0">
											<input type="text" class="form-control us_phone_num_design" id="b_fax" value="<?php echo set_value('b_fax'); ?>" name="bill_to_data[b_fax]" maxlength="14" placeholder="Fax">
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-1 col-form-label" for="st_zip_country"></label>
										<div class="col-sm-4 pr-0">
											<input type="text" class="form-control" id="b_contact" value="<?php echo set_value('b_contact'); ?>" name="bill_to_data[b_contact]" maxlength="128" placeholder="Contact">
										</div>
										<div class="col-sm-4 pr-0">
											<input type="text" class="form-control email" id="b_email" value="<?php echo set_value('b_email'); ?>" name="bill_to_data[b_email]" maxlength="128" placeholder="Email">
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-1 col-form-label" for="b_default_ref"></label>
										<div class="col-sm-4 pr-0">
											<input type="text" class="form-control" id="b_default_ref" value="<?php echo set_value('b_default_ref'); ?>" name="bill_to_data[b_default_ref]" maxlength="128" placeholder="Reference#">
										</div>
										<div class="col-sm-4 pr-0">
											<select class="form-control" id="b_def_ref_type" name="bill_to_data[b_def_ref_type]">
												<option value="0">Select One</option>
												<?php
												if(!empty($reftypes))
												{
													foreach ($reftypes as $rt)
													{
														?>
														<option value="<?php echo $rt['ref_id'] ?>" <?php if($rt['ref_id'] == set_value('b_def_ref_type')) {echo "selected=selected";} ?>><?php echo $rt['ref_name'] ?></option>
														<?php
													}
												}
												?>
											</select> 
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-1 col-form-label" for=""></label>
										<div class="col-sm-4">
											<a href="javascript:void(0);" class="btn btn-info">Add More</a>
										</div>
									</div>
									
									
								</div>

                            </div>
							
							<div class="row m-0 border_bottom_2x">
								<div class="col-md-6 ml-2 pt-4 border_right_2x">
									<div class="form-group row">
										<label class="col-sm-3 col-form-label requiredcus" for="st_zip_country">Ready Date/Time</label>
										<div class="col-sm-3">
											<input type="text" class="form-control required" id="ready_date_time" value="<?php echo set_value('ready_date_time'); ?>" name="ready_date_time" placeholder="mm/dd/yyyy hh:mm" onchange="changeScheduleTime();">
										</div>
										<label class="col-sm-3 col-form-label requiredcus" for="st_zip_country">Close Time</label>
										<div class="col-sm-3">
											<input type="text" class="form-control required" id="close_date_time" value="<?php echo set_value('close_date_time'); ?>" name="close_date_time" placeholder="mm/dd/yyyy hh:mm">
										</div>

									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label requiredcus" for="qb_list_id">Service Level</label>
										<div class="col-sm-5">
											<select class="form-control required" id="service_level" name="service_level" onchange="changeScheduleTime();">
												<option value="0">Select</option>
												<?php
												if(!empty($servicelevels))
												{
													foreach ($servicelevels as $st)
													{
														?>
														<option value="<?php echo $st['service_id'] ?>" <?php if($st['service_id'] == set_value('service_level')) {echo "selected=selected";} ?>><?php echo $st['service_name'] ?></option>
														<?php
													}
												}
												?>
											</select>
										</div>
									</div>
								
									<div class="form-group row">
										<label class="col-sm-3 col-form-label requiredcus" for="st_zip_country">Schedule Date/Time</label> 
										<div class="col-sm-3">
											<input type="text" class="form-control datetimepicker required" id="schedule_date_time" value="<?php echo set_value('schedule_date_time'); ?>" name="schedule_date_time" placeholder="mm/dd/yyyy hh:mm">
										</div>
										<div class="col-sm-2 betweendiv hide">
											<input type="text" class="form-control timepicker" id="schedule_between_time" value="<?php echo set_value('schedule_between_time'); ?>" name="schedule_between_time" placeholder="hh:mm">
										</div> 
										<div class="col-sm-4">
											<label class="col-form-label font-weight-normal">
												<input class="form-check-input" type="radio" name="schedule_by" id="schedule_by" value="1" checked onchange="checkBetweenTime();">
												By
											</label>&nbsp;&nbsp;
											<label class="col-form-label font-weight-normal">
												<input class="form-check-input" type="radio" name="schedule_by" id="schedule_by" value="2" onchange="checkBetweenTime();">
												Only
											</label>&nbsp;&nbsp;
											<label class="col-form-label font-weight-normal">
												<input class="form-check-input" type="radio" name="schedule_by" id="schedule_by" value="3" onchange="checkBetweenTime();">
												Betw
											</label>
										</div>

									</div>
									
									<div class="form-group row">
										<div class="col-sm-12">
											<label class="col-form-label font-weight-normal">
												<input class="form-check-input" type="radio" name="special_delivery" id="special_delivery" value="1" >
												Sat Delivery
											</label>&nbsp;&nbsp;
											<label class="col-form-label font-weight-normal">
												<input class="form-check-input" type="radio" name="special_delivery" id="special_delivery" value="2">
												Sun Delivery
											</label>&nbsp;&nbsp;
											<label class="col-form-label font-weight-normal">
												<input class="form-check-input" type="radio" name="special_delivery" id="special_delivery" value="3">
												Holiday Delivery
											</label>
											
											<label class="col-form-label font-weight-normal">
												<input class="form-check-input" type="radio" name="special_delivery" id="special_delivery" value="4" checked>
												None
											</label>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="order_status">Status</label>
										<div class="col-sm-5">
											<select class="form-control" id="order_status" name="order_status">
												<option value="0">Select</option>
												<?php
												if(!empty($orderstatus))
												{
													foreach ($orderstatus as $os)
													{
														?>
														<option value="<?php echo $os['status_id'] ?>" <?php if($os['status_id'] == set_value('order_status')) {echo "selected=selected";} ?>><?php echo $os['status_name'] ?></option>
														<?php
													}
												}
												?>
											</select>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for=""></label>
										<div class="col-sm-5">
											<input type="text" class="form-control datetimepicker" id="status_time" value="<?php echo set_value('status_time'); ?>" name="status_time" placeholder="mm/dd/yyyy hh:mm">
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label requiredcus" for="">Station</label>
										<div class="col-sm-5">
											<input type="text" class="form-control required" id="station" value="FST" name="station" placeholder="FST" >
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="">Waybill</label>
										<div class="col-sm-5">
											<input type="text" class="form-control" id="waybill" value="<?php echo set_value('waybill'); ?>" name="waybill">
										</div>
										<label class="col-form-label">
											<input class="form-check-input" type="checkbox" value="1" name="auto_assign" id="auto_assign">
											Auto Assign
										</label> 
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="sales_person">Sales Person</label>
										<div class="col-sm-5">
											<input type="text" class="form-control" id="sales_person_name" value="<?php echo set_value('sales_person_name'); ?>" name="sales_person_name" maxlength="30" onclick="$('#sales_popup').click();">
											<input type="hidden" id="sales_person" value="<?php echo set_value('sales_person'); ?>" name="sales_person">
										</div>
										<div class="col-sm-3" style="margin-top: 5px;">
											<a id="sales_popup" href="javascript:void(0);" data-toggle="modal" data-target="#myModal" onclick="loadSalesPerson();"><i class="fa fa-user-circle"></i></a> 
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="emergency_contact">Emergency Contact#</label>
										<div class="col-sm-5">
											<input type="text" class="form-control us_phone_num_design" id="emergency_contact" value="<?php echo set_value('emergency_contact'); ?>" name="emergency_contact" maxlength="14">
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="account_manager">Account Manager</label>
										<div class="col-sm-5">
											<input type="text" class="form-control" id="account_manager" value="<?php echo set_value('account_manager'); ?>" name="account_manager" maxlength="30">
										</div>
										<div class="col-sm-3" style="margin-top: 5px;">
											<a href="javascript:void(0);"><i class="fa fa-user-circle"></i></a>
										</div>
									</div>
									
								</div>
								
								<div class="col-md-5 pt-4" id="shipmtab">
									<div class="form-group row">
										<label class="col-sm-4 col-form-label" for="origin_airport">Origin Airport</label>
										<div class="col-sm-5">
											<input type="text" class="form-control ui-autocomplete-input" id="origin_airport" value="<?php echo set_value('origin_airport'); ?>" name="origin_airport" maxlength="10">
											
											<input type="hidden" class="form-control" value="<?php echo set_value('origin_airport_id'); ?>" id="origin_airport_id" name="origin_airport_id" >
										</div>
										<div class="col-sm-3" style="margin-top: 5px;">
											<a href="javascript:void(0);" class="ship_origin_url"  data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('origin_airport', 'origin_airport_id', 'all','shipmtab' );"><i class="fa fa-search"></i></a>
										</div> 
									</div>
								
									<div class="form-group row">
										<label class="col-sm-4 col-form-label" for="dest_airport">Dest Airport</label>
										<div class="col-sm-5">
											<input type="text" class="form-control" id="dest_airport" value="<?php echo set_value('dest_airport'); ?>" name="dest_airport" maxlength="15">
											<input type="hidden" class="form-control" value="<?php echo set_value('dest_airport_id'); ?>" id="dest_airport_id" name="dest_airport_id" >
										</div>
										<div class="col-sm-3" style="margin-top: 5px;">
											<a href="javascript:void(0);" class="ship_dest_url"  data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('dest_airport', 'dest_airport_id', 'all','shipmtab' );"><i class="fa fa-search"></i></a>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-4 col-form-label" for="cod_value">COD Value</label>
										<div class="col-sm-3">
											<input type="text" class="form-control" id="cod_value" value="<?php echo set_value('cod_value'); ?>" name="cod_value" maxlength="15">
										</div>
										<div class="col-sm-5">
											FCCOD &nbsp;&nbsp; <input class="form-check-input" type="checkbox" value="1" name="fccod" id="fccod">
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-4 col-form-label" for="insured_value">Insured Value</label>
										<div class="col-sm-5">
											<input type="text" class="form-control digit" id="insured_value" value="<?php echo set_value('insured_value'); ?>" name="insured_value" maxlength="10">
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="call_in_company">Call in Company</label>
										<div class="col-sm-3">
											<input type="text" class="form-control" id="call_in_company" value="<?php echo set_value('call_in_company'); ?>" name="call_in_company" maxlength="75">
										</div>
										<label class="col-sm-3 col-form-label" for="call_in_name">Call in Name</label>
										<div class="col-sm-3">
											<input type="text" class="form-control" id="call_in_name" value="<?php echo set_value('call_in_name'); ?>" name="call_in_name" maxlength="75">
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="call_in_phone">Call in Phone</label>
										<div class="col-sm-3">
											<input type="text" class="form-control" id="call_in_phone" value="<?php echo set_value('call_in_phone'); ?>" name="call_in_phone" maxlength="10">
										</div>
										<label class="col-sm-3 col-form-label" for="ext">Ext</label>
										<div class="col-sm-3">
											<input type="text" class="form-control" id="ext" value="<?php echo set_value('ext'); ?>" name="ext" maxlength="20">
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-4 col-form-label" for="call_in_email">Call in Email</label>
										<div class="col-sm-5">
											<input type="text" class="form-control email" id="call_in_email" value="<?php echo set_value('call_in_email'); ?>" name="call_in_email" maxlength="125">
										</div>
										
									</div>
									
									<div class="form-group row">
										<label class="col-sm-4 col-form-label" for="dangerous_goods">Dangerous Goods</label>
										<div class="col-sm-5">
											<input class="form-check-input" type="checkbox" value="1" name="dangerous_goods" id="dangerous_goods">
										</div>
									</div>
									
								</div>
							</div>
							
							<div class="row m-0 mt-4 border_bottom_2x">
								<div class="col-md-12 org_freight_div" >
									<div class="text-center bg-info p-2 font-weight-bold f16">Freight Information</div>
									
									<div class="text-left bg-info mt-2 p-2 font-weight-bold f16">
										Add Freight Information
										<a href="javascript:void(0);" onclick="cloneFreight();" style="float:right;">Add More</a>
									</div>
									
									<div class="form-group row mt-4">
										<div class="box-body table-responsive no-padding freight_demo_tr">
											  <table class="table table-hover table_freight">
												<tr>
													<th>Pieces</th>
													<th>Type</th>
													<th>Haz</th>
													<th>Description</th>
													<th>Weight</th>
													<th>Length</th>
													<th>Width</th>
													<th>Height</th>
													<th>Dim Factor</th>
													<th>Class</th>
													<th></th>
												</tr>

												<tr id="freight_div_name_0" class="freight_demo_name_div">
													<td>
														<input type="text" class="form-control digits piecesinput" id="pieces" value="<?php echo set_value('pieces'); ?>" name="freight[pieces][]" maxlength="6" onchange="addTotalPiece();addDimFactor(this);" autocomplete="off">
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
														<input class="form-check-input freight_haz_div" type="checkbox" value="1" name="freight[haz][]" id="haz">
													</td>
													
													<td>
														<input type="text" class="form-control" id="description" value="<?php echo set_value('description'); ?>" name="freight[description][]" maxlength="75">
													</td>
													
													<td>
														<input type="text" class="form-control digits weightinput" id="weight" value="<?php echo set_value('weight'); ?>" name="freight[weight][]" maxlength="6" onchange="addTotalWeight();"  autocomplete="off">
													</td>
													
													<td>
														<input type="text" class="form-control digits" id="length" value="<?php echo set_value('length'); ?>" name="freight[length][]" maxlength="6" onchange="addDimFactor(this);"  autocomplete="off">
													</td>
													
													<td>
														<input type="text" class="form-control digits" id="width" value="<?php echo set_value('width'); ?>" name="freight[width][]" maxlength="6" onchange="addDimFactor(this);" autocomplete="off">
													</td>
													
													<td>
														<input type="text" class="form-control digits" id="height" value="<?php echo set_value('height'); ?>" name="freight[height][]" maxlength="6" onchange="addDimFactor(this);" autocomplete="off">
													</td>
													
													<td> 
														<input type="text" class="form-control digits" id="dim_factor" value="194" name="freight[dim_factor][]" maxlength="10" onchange="addDimFactor(this);">
														<input type="hidden" class="t_dim_weight"  id="t_dim_weight" value="" name="freight[t_dim_weight][]"  autocomplete="off">
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
											<div id="freight_total_div"></div>
									</div>
									
																			
								</div>
							</div>
							
							<div class="row mt-4 m-0 border_bottom_2x">
								
								
								<div class="form-group row">
									<label class="col-sm-2 col-form-label text-left">
										Total Pieces:<span id="total_pieces"></span>
									</label>
									
									<label class="col-sm-2 col-form-label text-left">
										Total Actual Weight:<span id="total_actual_weight"></span>
									</label>
									
									<label class="col-sm-2 col-form-label text-left">
										Total Dim Weight:<span id="total_dim_weight"></span>
									</label>
									
									<label class="col-sm-3 col-form-label text-left">
										Total Chargeable Weight:<span id="total_chargeable_weight"></span>
									</label>
									
									<label class="col-sm-2 col-form-label text-left">
										<input class="form-check-input" type="checkbox" value="1" name="dim_factor_override" id="dim_factor_override">
										Dim Factor Override
									</label>
									
								</div>
								
							</div>

	
                        </div><!-- /.box-body -->
    
						
						<div class="special_instructions_content_div" style="display:none;">
							
						</div>
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
							
							<div class="text-center" style="display: inline-block;width: 75%;">
								<input type="hidden" class="special_instructions_content_div_changed" value="0"/>
								<a href="javascript:void(0);" class="btn btn-info" data-toggle="modal" data-target="#myModal" onclick="loadSpecialInstructions(0);">Special Instructions</a>
							
								<label class="col-form-label">
									<input class="form-check-input" type="checkbox" value="1" name="spchk[sp_p]" id="sp_p" title="Pickup Instructions">
									P
								</label> &nbsp;&nbsp;
								<label class="col-form-label">
									<input class="form-check-input" type="checkbox" value="1" name="spchk[sp_d]" id="sp_d" title="Delivery Instructions">
									D
								</label> &nbsp;&nbsp;
								<label class="col-form-label">
									<input class="form-check-input" type="checkbox" value="1" name="spchk[sp_s]" id="sp_s" title="Special Instructions">
									S
								</label>&nbsp;&nbsp;
								<label class="col-form-label">
									<input class="form-check-input" type="checkbox" value="1" name="spchk[sp_i]" id="sp_i" title="Invoice Notes">
									I
								</label>&nbsp;&nbsp;
								<label class="col-form-label">
									<input class="form-check-input" type="checkbox" value="1" name="spchk[sp_q]" id="sp_q" title="Quote Notes">
									Q
								</label>&nbsp;&nbsp;
								<label class="col-form-label">
									<input class="form-check-input" type="checkbox" value="1" name="spchk[sp_t]" id="sp_t" title="Transfer Instructions">
									T
								</label>
										
							</div>
							
                        </div>
                    </form>
                </div>
            </div>
            
        </div>    
    </section>
    
</div>
<script src="<?php echo base_url(); ?>assets/js/addDomesticShipment.js" type="text/javascript"></script>