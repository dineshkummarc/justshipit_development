<link href="<?php echo base_url(); ?>assets/bower_components/datepicker/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/bower_components/datepicker/jquery.datetimepicker.full.js"></script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Company Management
        <small>Add / Edit <?php echo (($userInfo->category_id == 2) ? 'Vendor' : 'Customer');?></small>
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
                
                <div id="vendor_airport_div" style="display: none;">
					
					<div class="airport_demo_tr" style="clear:both;">
						<div class="col-sm-3"></div>
						<div class="col-sm-6">														
							<input type="text" class="form-control ui-autocomplete-input airport_name_container" id="default_airport_name_00" value="" name="extra_ap_codes[default_airport_name][]" maxlength="10">
							<input type="hidden" class="form-control airport_id_container" value="" id="default_airport_code_00" name="extra_ap_codes[default_airport_code][]" >
						</div>
						<div class="col-sm-3" style="margin-top: 5px;">
							<a href="javascript:void(0);" class="ship_origin_url airport_click_container"  data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('default_airport_name_00', 'default_airport_code_00', 'all','airportab' );"><i class="fa fa-search"></i></a>
							&nbsp;&nbsp;
							<a href="javascript:void(0);" class="add_airport_code" onclick="removeNewAirport(this);"><i class="fa fa-remove" style="color:red;"></i></a>
							
						</div>
					</div>
				</div>
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo (($userInfo->category_id == 2) ? 'Enter Vendor Details' : 'Enter Customer Details');?> &nbsp; <?php echo 'File #'.$userInfo->file_number; ?></h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="editCustomer" action="<?php echo base_url() ?>saveOldCustomer" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
								<div class="col-md-6" style="border-right:2px solid #333;">
									                                
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="customer_id">Customer ID</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" value="<?php echo $userInfo->customer_number; ?>" id="customer_number" name="customer_number" disabled>
											<input type="hidden" value="<?php echo $userInfo->customer_id; ?>" name="customer_id" id="customer_id" />   
										</div>
									</div>
															
									<div class="form-group row">
										<label class="col-sm-3 col-form-label requiredcus" for="customer_name">Name</label>
										<div class="col-sm-9">
											<input type="text" class="form-control required" value="<?php echo $userInfo->customer_name; ?>" id="customer_name" name="customer_name" maxlength="128">
										</div>
									</div>
															
									<div class="form-group row">
										<label class="col-sm-3 col-form-label requiredcus" for="c_address_1">Address 1</label>
										<div class="col-sm-9">
											
											<textarea name='c_address_1' id="c_address_1" class="form-control required" rows="1"><?php echo $userInfo->c_address_1;?></textarea>
										</div>
									</div>
							
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="c_address_2">Address 2</label>
										<div class="col-sm-9">
											<textarea name='c_address_2' id="c_address_2" class="form-control" rows="1"><?php echo $userInfo->c_address_2;?></textarea>
										</div>
									</div>
							
									<div class="form-group row">
										<label class="col-sm-3 col-form-label requiredcus" for="c_city">City</label>
										<div class="col-sm-9">
											<input type="text" class="form-control required" value="<?php echo $userInfo->c_city; ?>" id="c_city" name="c_city" maxlength="128">
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label requiredcus" for="c_country">Country</label>
										<div class="col-sm-9">
											<select class="form-control required" id="c_country" name="c_country">
												<option value="0">Select Country</option>
												<?php
												if(!empty($countries))
												{
													foreach ($countries as $rl)
													{
														?>
														<option value="<?php echo $rl['country_id'] ?>" <?php if($rl['country_id'] == $userInfo->c_country) {echo "selected=selected";} ?>><?php echo $rl['country_name'] ?></option>
														<?php
													}
												}
												?>
											</select>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="c_state">State</label>
										<div class="col-sm-9">
										   <select class="form-control required" id="c_state" name="c_state">
												<option value="0">Select State</option>
												<?php
												if(!empty($states))
												{
													foreach ($states as $st)
													{
														?>
														<option value="<?php echo $st['state_id'] ?>" <?php if($st['state_id'] == $userInfo->c_state) {echo "selected=selected";} ?>><?php echo $st['state_name'] ?></option>
														<?php
													}
												}
												?>
											</select>
										</div>
									</div>
																		
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="c_zip">Zip</label>
										<div class="col-sm-9">
											<input type="text" class="form-control zip_en_data" value="<?php echo $userInfo->c_zip; ?>" id="c_zip" name="c_zip" maxlength="8">
										</div>
									</div>
								
									
									

									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="c_phone">Phone</label>
										<div class="col-sm-9">
											<input type="text" class="form-control us_phone_num_design" id="c_phone" value="<?php echo $userInfo->c_phone; ?>" name="c_phone" maxlength="14">
										</div>
									</div>

									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="c_toll_free_phone">Toll Free Phone</label>
										<div class="col-sm-9">
											<input type="text" class="form-control digits" id="c_toll_free_phone" value="<?php echo $userInfo->c_toll_free_phone; ?>" name="c_toll_free_phone" maxlength="14">
										</div>
									</div>
																
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="c_fax">Fax</label>
										<div class="col-sm-9">
											<input type="text" class="form-control us_phone_num_design" id="c_fax" value="<?php echo $userInfo->c_fax; ?>" name="c_fax" maxlength="14">
										</div>
									</div>

									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="c_email">Email</label>
										<div class="col-sm-9">
											<input type="text" class="form-control email" id="c_email" value="<?php echo $userInfo->c_email; ?>" name="c_email" maxlength="128">
										</div>
									</div>
								
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="email">AP Email</label>
										<div class="col-sm-9">
											<input type="text" class="form-control email" id="c_ap_email" value="<?php echo $userInfo->c_ap_email; ?>" name="c_ap_email" maxlength="128">
										</div>
									</div>
								
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="c_contact">Contact</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="c_contact" value="<?php echo $userInfo->c_contact; ?>" name="c_contact" maxlength="128">
										</div>
									</div>

									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="c_default_ref">Default Reference #</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="c_default_ref" value="<?php echo $userInfo->c_default_ref; ?>" name="c_default_ref" maxlength="128">
										</div>
									</div>
															
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="c_def_ref_type">Default Ref Type</label>
										<div class="col-sm-9">
											<select class="form-control" id="c_def_ref_type" name="c_def_ref_type">
												<option value="0">Select One</option>
												<?php
												if(!empty($reftypes))
												{
													foreach ($reftypes as $rt)
													{
														?>
														<option value="<?php echo $rt['ref_id'] ?>" <?php if($rt['ref_id'] == $userInfo->c_def_ref_type) {echo "selected=selected";} ?>><?php echo $rt['ref_name'] ?></option>
														<?php
													}
												}
												?>
											</select>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="fist_ship_date">First Ship Date</label>
										<div class="col-sm-9">
											<input type="text" class="form-control dateonlypicker" id="fist_ship_date" value="<?php echo ($userInfo->fist_ship_date ? date("m/d/Y", strtotime($userInfo->fist_ship_date)) : null); ?>" name="fist_ship_date">
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="most_recent_ship_date">Most Recent Ship Date</label>
										<div class="col-sm-9">
											<input type="text" class="form-control dateonlypicker" id="most_recent_ship_date" value="<?php echo ($userInfo->most_recent_ship_date ? date("m/d/Y", strtotime($userInfo->most_recent_ship_date)) : null); ?>" name="most_recent_ship_date">
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="account_no">Account No</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="account_no" value="<?php echo $userInfo->account_no; ?>" name="account_no" maxlength="50">
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="account_ein">EIN</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="account_ein" value="<?php echo $userInfo->account_ein; ?>" name="account_ein" maxlength="20">
										</div>
									</div>
									
									<div class="form-group row" id="airportab">
										<label class="col-sm-3 col-form-label" for="default_airport_code">Default Airport Code</label>
										
										<?php
										$selairport = '';
										if(!empty($airports))
										{
											foreach ($airports as $ap)
											{
												if($ap['airport_id'] ==$userInfo->default_airport_code) {
													$selairport = $ap['airport_code'];
												}
												
											}
										}
										?>
										
										<div class="col-sm-6">
																						
											<input type="text" class="form-control ui-autocomplete-input" id="default_airport_name" value="<?php echo $selairport; ?>" name="default_airport_name" maxlength="10">
											
											<input type="hidden" class="form-control" value="<?php echo $userInfo->default_airport_code; ?>" id="default_airport_code" name="default_airport_code" >
											
										</div>
										<div class="col-sm-3" style="margin-top: 5px;">
											<a href="javascript:void(0);" class="ship_origin_url"  data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('default_airport_name', 'default_airport_code', 'all','airportab' );"><i class="fa fa-search"></i></a>
											&nbsp;&nbsp;<a href="javascript:void(0);" class="add_airport_code add_airport_code_icon" onclick="cloneAirportCode();" <?php if($userInfo->category_id == 1) {echo 'style="display:none;"';} ?> ><i class="fa fa-plus-circle"></i></a>
										</div>
										
										<div class="extra_airport_code">
										
											<?php 
												
												if(!empty($extra_ap_codes)){
												foreach($extra_ap_codes as $key => $extra_ap_code){
											?>
											<div class="airport_demo_tr" style="clear:both;">
												<div class="col-sm-3"></div>
												<div class="col-sm-6">														
													<input type="text" class="form-control ui-autocomplete-input airport_name_container" id="default_airport_name_<?php echo $extra_ap_code->airport_code;?>" value="<?php echo $extra_ap_code->airport_name;?>" name="extra_ap_codes[default_airport_name][]" maxlength="10">
													<input type="hidden" class="form-control airport_id_container" value="<?php echo $extra_ap_code->airport_code;?>" id="default_airport_code_<?php echo $extra_ap_code->airport_code;?>" name="extra_ap_codes[default_airport_code][]" >
												</div>
												<div class="col-sm-3" style="margin-top: 5px;">
													<a href="javascript:void(0);" class="ship_origin_url airport_click_container"  data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('default_airport_name_<?php echo $extra_ap_code->airport_code;?>', 'default_airport_code_<?php echo $extra_ap_code->airport_code;?>', 'all','airportab' );"><i class="fa fa-search"></i></a>
													&nbsp;&nbsp;
													<a href="javascript:void(0);" class="add_airport_code" onclick="removeNewAirport(this);"><i class="fa fa-remove" style="color:red;"></i></a>
													
												</div>
											</div>
											<?php 
												}
											}
											?>
										</div>
										
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="default_area">Default Area</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="default_area" value="<?php echo $userInfo->default_area; ?>" name="default_area" maxlength="20">
										</div>
									</div>
									
								</div>
								
								<div class="col-md-6">
								
									<div class="form-group row" style="background: #eee;margin-left: 5px;margin-right: 5px;padding: 5px;">
										<label class="col-sm-3 col-form-label" for="is_active" style="display: block;margin-top: 6px;">
											Active &nbsp;
											<input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active" <?php if($userInfo->is_active == 1) {echo "checked";} ?>>
										</label>
										
										<label class="col-sm-3 col-form-label" for="inactivate_date" style="display: block;margin-top: 6px;">
											<span class="" >Inactivate Date</span>
										</label>
										
										<div class="col-sm-5">
											<input type="text" class="form-control dateonlypicker" id="inactivate_date" value="<?php echo ($userInfo->inactivate_date ? date("m/d/Y", strtotime($userInfo->inactivate_date)) : null); ?>" name="inactivate_date">
											
										</div>

									</div>

									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="default_area">Company Type</label>
										
										<label class="col-form-label col-sm-3 font-weight-normal">
											<input class="form-check-input" type="radio" name="category_id" id="category_id" value="1" onclick="changeCategoryData(1);"  <?php if($userInfo->category_id == 1) {echo "checked";} ?>>
											Customer
										</label>
										<label class="col-form-label col-sm-3 font-weight-normal">
											<input class="form-check-input" type="radio" name="category_id" id="category_id" value="2" onclick="changeCategoryData(2);"  <?php if($userInfo->category_id == 2) {echo "checked";} ?>> 
											Vendor
										</label>
										
										<label class="col-form-label col-sm-3 font-weight-normal">
											<input class="form-check-input" type="radio" name="category_id" id="category_id" value="3" onclick="changeCategoryData(3);"  <?php if($userInfo->category_id == 3) {echo "checked";} ?>> 
											Both
										</label>
										
										<div class="customer_option" <?php echo (($userInfo->category_id == '' || $userInfo->category_id == 1 || $userInfo->category_id == 3) ? '' : 'style="display:none;"');?>>
											<label class="col-sm-3 col-form-label" for="is_shipper">Customers</label>
											<div>
												<label class="col-form-label">
													<input class="form-check-input" type="checkbox" value="1" name="is_shipper" id="is_shipper"  <?php if($userInfo->is_shipper == 1) {echo "checked";} ?>>
													Shipper
												</label>&nbsp;&nbsp;
												<label class="col-form-label">
													<input class="form-check-input" type="checkbox" value="1" name="is_consignee" id="is_consignee"  <?php if($userInfo->is_consignee == 1) {echo "checked";} ?>>
													Consignee
												</label>&nbsp;&nbsp;
												<label class="col-form-label">
													<input class="form-check-input" type="checkbox" value="1" name="is_bill_to" id="is_bill_to"  <?php if($userInfo->is_bill_to == 1) {echo "checked";} ?>>
													Bill To
												</label>
											</div>	
										</div>	
									</div>
									
									<div class="form-group row vendor_option" <?php echo (($userInfo->category_id == 2 || $userInfo->category_id == 3) ? '' : 'style="display:none;"');?>>

										<label class="col-sm-3 col-form-label" for="is_pickup_delivery">Vendors</label>
										<div>
											<label class="col-form-label">
												<input class="form-check-input" type="checkbox" value="1" name="is_pickup_delivery" id="is_pickup_delivery" <?php if($userInfo->is_pickup_delivery == 1) {echo "checked";} ?>>
												Pickup/Delivery
											</label>&nbsp;&nbsp;
											<label class="col-form-label">
												<input class="form-check-input" type="checkbox" value="1" name="is_line_haul" id="is_line_haul" <?php if($userInfo->is_line_haul == 1) {echo "checked";} ?>>
												Line Haul
											</label>&nbsp;&nbsp;
											<label class="col-form-label">
												<input class="form-check-input" type="checkbox" value="1" name="is_airline" id="is_airline" <?php if($userInfo->is_airline == 1) {echo "checked";} ?>>
												Airline
											</label><br/>
											
											<label class="col-sm-3 col-form-label" for="is_pickup_delivery"></label>
											
											<label class="col-form-label">
												<input class="form-check-input" type="checkbox" value="1" name="is_truckload" id="is_truckload" <?php if($userInfo->is_truckload == 1) {echo "checked";} ?>>
												TruckLoad
											</label>&nbsp;&nbsp;
											<label class="col-form-label">
												<input class="form-check-input" type="checkbox" value="1" name="is_ltl" id="is_ltl" <?php if($userInfo->is_ltl == 1) {echo "checked";} ?>>
												LtL
											</label>&nbsp;&nbsp;
											<label class="col-form-label">
												<input class="form-check-input" type="checkbox" value="1" name="is_customs_broker" id="is_customs_broker" <?php if($userInfo->is_customs_broker == 1) {echo "checked";} ?>>
												Customs Broker
											</label>
											
										</div>	
									</div>
									
									<div class="form-group row">
										<label class="col-sm-2 col-form-label" for="sales">
											Sales &nbsp;
											<input class="form-check-input" type="checkbox" value="1" name="is_sales" id="is_sales" <?php if($userInfo->is_sales == 1) {echo "checked";} ?>>
										</label>
										
										<label class="col-sm-5 col-form-label" for="sales_commission_percent">
											<span class="">Sales Commission Percentage</span>
										</label>
										
										<div class="col-sm-3">
											<input type="number" class="form-control" id="sales_commission_percent" value="<?php echo $userInfo->sales_commission_percent; ?>" name="sales_commission_percent" max="99" min="0" step=".5">
										</div>

									</div>
									
									<div class="form-group row">
										<label class="col-sm-12 col-form-label" for="is_miscellaneous">
											Miscellaneous &nbsp;
											<input class="form-check-input" type="checkbox" value="1" name="is_miscellaneous" id="is_miscellaneous" <?php if($userInfo->is_miscellaneous == 1) {echo "checked";} ?>>
										</label>
									</div>
									
									<div class="form-group row" style="background:#eee;padding:5px;margin:15px 5px 15px 5px;">
										<label class="col-sm-12 col-form-label" for="same_address">
											Remit Address &nbsp;&nbsp;&nbsp;&nbsp;
											<input class="form-check-input" type="checkbox" value="1" name="same_address" id="same_address" <?php if($userInfo->same_address == 1) {echo "checked";} ?>> Same as Physical Address
										</label>
									</div>
									
									<div class="secondary_address"  style="border-bottom: 1px solid #ccc;margin-bottom: 15px;"> 
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="r_name">Name</label>
										<div class="col-sm-9">
											<input type="text" class="form-control remit_data" value="<?php echo $userInfo->r_name; ?>" id="r_name" name="r_name" maxlength="128">
										</div>
									</div>
															
									<div class="form-group row">
										<label class="col-sm-3 col-form-label " for="r_address_1">Address 1</label>
										<div class="col-sm-9">
											<textarea name='r_address_1' id="r_address_1" class="form-control remit_data" rows="1"><?php echo $userInfo->r_address_1;?></textarea>
										</div>
									</div>
							
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="r_address_2">Address 2</label>
										<div class="col-sm-9">
											<textarea name='r_address_2' id="r_address_2" class="form-control  remit_data" rows="1"><?php echo $userInfo->r_address_2;?></textarea>
										</div>
									</div>
							
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="r_city">City</label>
										<div class="col-sm-9">
											<input type="text" class="form-control remit_data" value="<?php echo $userInfo->r_city; ?>" id="r_city" name="r_city" maxlength="128">
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="r_country">Country</label>
										<div class="col-sm-9">
											<select class="form-control remit_data" id="r_country" name="r_country">
												<option value="0">Select Country</option>
												<?php
												if(!empty($countries))
												{
													foreach ($countries as $rl)
													{
														?>
														<option value="<?php echo $rl['country_id'] ?>" <?php if($rl['country_id'] == $userInfo->r_country) {echo "selected=selected";} ?>><?php echo $rl['country_name'] ?></option>
														<?php
													}
												}
												?>
											</select>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="r_state">State</label>
										<div class="col-sm-9">
										   <select class="form-control  remit_data" id="r_state" name="r_state">
												<option value="0">Select State</option>
												<?php
												if(!empty($rstates))
												{
													foreach ($rstates as $st)
													{
														?>
														<option value="<?php echo $st['state_id'] ?>" <?php if($st['state_id'] == $userInfo->r_state) {echo "selected=selected";} ?>><?php echo $st['state_name'] ?></option>
														<?php
													}
												}
												?>
											</select>
										</div>
									</div>
																		
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="r_zip">Zip</label>
										<div class="col-sm-9">
											<input type="text" class="form-control zip_en_data remit_data" value="<?php echo $userInfo->r_zip; ?>" id="r_zip" name="r_zip" maxlength="8">
										</div>
									</div>
								
									
									

									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="r_phone">Phone</label>
										<div class="col-sm-9">
											<input type="text" class="form-control us_phone_num_design remit_data" id="r_phone" value="<?php echo $userInfo->r_phone; ?>" name="r_phone" maxlength="14">
										</div>
									</div>

																
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" for="r_fax">Fax</label>
										<div class="col-sm-9">
											<input type="text" class="form-control us_phone_num_design remit_data" id="r_fax" value="<?php echo $userInfo->r_fax; ?>" name="r_fax" maxlength="14">
										</div>
									</div>

									<div class="form-group row">
										<label class="col-sm-3 col-form-label " for="r_email">Email</label>
										<div class="col-sm-9">
											<input type="text" class="form-control email remit_data" id="r_email" value="<?php echo $userInfo->r_email; ?>" name="r_email" maxlength="128">
										</div>
									</div>
									
								</div>
								
								<div class="form-group row">
									<label class="col-sm-4 col-form-label" for="sales_person">Sales Person</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="sales_person_name" value="<?php echo $userInfo->sales_person_name; ?>" name="sales_person_name" maxlength="30" onclick="$('#sales_popup').click();">
										<input type="hidden" id="sales_person" value="<?php echo $userInfo->sales_person; ?>" name="sales_person">
									</div>
									<div class="col-sm-3" style="margin-top: 5px;">
										<a id="sales_popup" href="javascript:void(0);" data-toggle="modal" data-target="#myModal" onclick="loadSalesPerson();"><i class="fa fa-user-circle"></i></a> 
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-sm-4 col-form-label" for="bill_customer_number">Bill-To Customer No</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="bill_customer_name" value="<?php echo $userInfo->bill_customer_name; ?>" name="bill_customer_name" maxlength="30" onclick="$('#bullto_popup').click();">
										<input type="hidden" id="bill_customer_number" value="<?php echo $userInfo->bill_customer_number; ?>" name="bill_customer_number">
									</div>
									<div class="col-sm-3" style="margin-top: 5px;">
										<a id="bullto_popup" href="javascript:void(0);" data-toggle="modal" data-target="#myModal" onclick="loadBilltoPerson();"><i class="fa fa-user-circle"></i></a> 
									</div> 
								</div>
								
								<div class="form-group row">
									<label class="col-sm-4 col-form-label" for="station">Station</label>
									<div class="col-sm-5">
									   <select class="form-control required" id="station" name="station">
											<option value="0">Select</option>
											<?php
											if(!empty($stations))
											{
												foreach ($stations as $stt)
												{
													?>
													<option value="<?php echo $stt['station_id'] ?>" <?php if($stt['station_id'] == $userInfo->station) {echo "selected=selected";} ?>><?php echo $stt['station_name'] ?></option>
													<?php
												}
											}
											?>
										</select>
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-sm-4 col-form-label" for="qb_list_id">QB List ID</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="qb_list_id" value="<?php echo $userInfo->qb_list_id; ?>" name="qb_list_id" maxlength="30">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-sm-4 col-form-label" for="credit_limit">Credit Limit</label>
									<div class="col-sm-5">
										<input type="text" class="form-control digit" id="credit_limit" value="<?php echo $userInfo->credit_limit; ?>" name="credit_limit" maxlength="10">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-sm-4 col-form-label" for="requested_credit_limit">Requested Credit Limit</label>
									<div class="col-sm-5">
										<input type="text" class="form-control digit" id="requested_credit_limit" value="<?php echo $userInfo->requested_credit_limit; ?>" name="requested_credit_limit" maxlength="10">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-sm-4 col-form-label" for="credit_score">Credit Score</label>
									<div class="col-sm-5">
										<input type="text" class="form-control digit" id="credit_score" value="<?php echo $userInfo->credit_score; ?>" name="credit_score" maxlength="6">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-sm-4 col-form-label" for="qb_list_id">Payment Term</label>
									<div class="col-sm-5">
										<select class="form-control required" id="payment_term" name="payment_term">
											<option value="0">Select</option>
											<?php
											if(!empty($pay_terms))
											{
												foreach ($pay_terms as $pt)
												{
													?>
													<option value="<?php echo $pt['term_id'] ?>" <?php if($pt['term_id'] == $userInfo->payment_term) {echo "selected=selected";} ?>><?php echo $pt['name'] ?></option>
													<?php
												}
											}
											?>
										</select>
									</div>
								</div>
									
								<div class="form-group row">
									<label class="col-sm-4 col-form-label" for="invoicing">Invoicing</label>
								
									<div class="col-sm-6">
										<label class="col-form-label">
											<input class="form-check-input" type="radio" name="invoicing" id="invoicing" value="1" <?php if($userInfo->invoicing == 1) {echo "checked";} ?>>
											Print
										</label>&nbsp;&nbsp;
										<label class="col-form-label">
											<input class="form-check-input" type="radio" name="invoicing" id="invoicing" value="2" <?php if($userInfo->invoicing == 2) {echo "checked";} ?>>
											Email
										</label>&nbsp;&nbsp;
									</div>	
								</div>
								
								<div class="form-group row">
									<label class="col-sm-12 col-form-label" for="itemized_charges">
										<input class="form-check-input" type="checkbox" value="1" name="itemized_charges" id="itemized_charges" <?php if($userInfo->itemized_charges == 1) {echo "checked";} ?>>
										Show itemized charges on Invoice?
									</label>
								</div>
									
								</div>
                            </div>

							
							<div class="col-md-12">
								<label class="col-form-label" for="account_ein">Notifications & Notes</label>
							</div>
							<div class="col-md-6">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label" for="account_ein">Requirements</label>
									<div class="col-sm-9">
										<textarea name='requirements' id="requirements" class="form-control" rows="1"><?php echo $userInfo->requirements;?></textarea>

										
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-sm-3 col-form-label" for="after_hours">After Hours</label>
									<div class="col-sm-9">
										<textarea name='after_hours' id="after_hours" class="form-control" rows="1"><?php echo $userInfo->after_hours;?></textarea>
										
									</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-3 col-form-label" for="pickup_instructions">PickUp Instructions</label>
									<div class="col-sm-9">
										<textarea name='pickup_instructions' id="pickup_instructions" class="form-control" rows="1"><?php echo $userInfo->pickup_instructions;?></textarea>
										
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-sm-3 col-form-label" for="delivery_instructions">Delivery Instructions</label>
									<div class="col-sm-9">
										<textarea name='delivery_instructions' id="delivery_instructions" class="form-control" rows="1"><?php echo $userInfo->delivery_instructions;?></textarea>
										
									</div>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label" for="special_instructions">Special Instructions</label>
									<div class="col-sm-9">
										<textarea name='special_instructions' id="special_instructions" class="form-control" rows="1"><?php echo $userInfo->special_instructions;?></textarea>
										
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-sm-3 col-form-label" for="handling_instructions">Handling Instructions</label>
									<div class="col-sm-9">
										<textarea name='handling_instructions' id="handling_instructions" class="form-control" rows="1"><?php echo $userInfo->handling_instructions;?></textarea>
										
									</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-3 col-form-label" for="invoice_notes">Invoice Notes</label>
									<div class="col-sm-9">
										<textarea name='invoice_notes' id="invoice_notes" class="form-control" rows="1"><?php echo $userInfo->invoice_notes;?></textarea>
										
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-sm-3 col-form-label" for="notes_of_interest">Notes of Interest</label>
									<div class="col-sm-9">
										<textarea name='notes_of_interest' id="notes_of_interest" class="form-control" rows="1"><?php echo $userInfo->notes_of_interest;?></textarea>
										
									</div>
								</div>
							</div>
							
							<div style="border:1px solid #333;display: inline-block;padding: 10px 0px 10px 0px;">
								<div class="col-md-12">
								
									<label class="col-sm-2 col-form-label" for="tsa_known_shipper">
										TSK Known Shipper &nbsp;
										<input class="form-check-input" type="checkbox" value="1" name="tsa_known_shipper" id="tsa_known_shipper" <?php if($userInfo->tsa_known_shipper == 1) {echo "checked";} ?>>
									</label>
									
									<label class="col-sm-3 col-form-label" for="ksms_verification_date">
										<span class="" >KSMS Verification Date</span>
									</label>
									
									<div class="col-sm-2">
										<input type="text" class="form-control datepicker" id="ksms_verification_date" value="<?php echo ($userInfo->ksms_verification_date ? date("m/d/Y", strtotime($userInfo->ksms_verification_date)) : null); ?>" name="ksms_verification_date" readonly>
									</div>
									
									<label class="col-sm-5 col-form-label" for="blanket_screening_letter">
										Blanket Screening Authorization Letter on File? &nbsp;
										<input class="form-check-input" type="checkbox" value="1" name="blanket_screening_letter" id="blanket_screening_letter" <?php if($userInfo->blanket_screening_letter == 1) {echo "checked";} ?>>
									</label>
									
								</div>
								
								<div class="col-md-12" style="margin-top:5px;">	
								
									<label class="col-sm-2 col-form-label" for="ksms_id">
										<span class="" >KSMS ID# &nbsp;</span>
									</label>
									
									<div class="col-sm-4">
										<input type="text" class="form-control" id="ksms_id" value="<?php echo $userInfo->ksms_id; ?>" name="ksms_id">
									</div>
									
									<label class="col-sm-2 col-form-label" for="reverified_by">
										<span class="" >Reverified By</span>
									</label>
									
									<div class="col-sm-4">
										<input type="text" class="form-control" id="reverified_by" value="<?php echo $userInfo->reverified_by; ?>" name="reverified_by">
									</div>
																	
								</div>
								
								<div class="col-md-12" style="margin-top:5px;">
									<label class="col-sm-12 col-form-label" for="cannot_known_shipper">
										Cannot be a Known Shipper &nbsp;
										<input class="form-check-input" type="checkbox" value="1" name="cannot_known_shipper" id="cannot_known_shipper" <?php if($userInfo->cannot_known_shipper == 1) {echo "checked";} ?>>
									</label>
								</div>
								
							</div>
							
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            
        </div>    
    </section>
    
</div>
<script src="<?php echo base_url(); ?>assets/js/editCustomer.js" type="text/javascript"></script> 