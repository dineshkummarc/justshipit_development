<link href="<?php echo base_url(); ?>assets/bower_components/datepicker/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/bower_components/datepicker/jquery.datetimepicker.full.js"></script>

<style>
.form-group{margin-bottom: 5px;}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-plane"></i> MAWB Details
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
                        <h3 class="box-title">Domestic Shipment MAWB Details</h3>
						<div class="p-2 bg-info f_right">
						 <?php
							echo (isset($shipInfo['waybill']) ? '#'.$shipInfo['waybill'] : '').'&nbsp; &nbsp; &nbsp;'.(isset($shipInfo['origin_airport_code']) ? $shipInfo['origin_airport_code'] : '').'&nbsp; &nbsp; &nbsp;'.(isset($shipInfo['dest_airport_code']) ? $shipInfo['dest_airport_code'] : '').'&nbsp; &nbsp; &nbsp;'.(isset($shipInfo['shippes_data']['shipper_name']) ? $shipInfo['shippes_data']['shipper_name'] : '').'&nbsp; &nbsp; &nbsp;'.(isset($shipInfo['consignee_data']['c_shipper_name']) ? $shipInfo['consignee_data']['c_shipper_name'] : ''); 
						 ?>
						</div>
                    </div><!-- /.box-header -->
					
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="updateMAWBdatas" action="<?php echo base_url() ?>updateMAWBdatas" method="post" role="form">
						
						<div class="tab-content">
							<div class="box-body">
								<div class="row m-0 border_bottom_2x">
								
									<div class="col-md-6 border_right_2x">
											
										<div class="form-group row">
											<span class="font-weight-bold f16 col-sm-2 pr-0">Shipper</span>
											
											<label class="col-sm-2 col-form-label font-weight-normal pl-0 pr-0">
												<input class="form-check-input" type="radio" name="s_data[recover_from]" id="recover_from" value="0" onclick="changemawbData('pickup', 0, <?php echo $shipInfo['shipment_id']; ?>);"  <?php echo ((isset($aRecords['s_data']['recover_from']) && $aRecords['s_data']['recover_from'] == 0) ? 'checked' : 'checked'); ?>>
												Company
											</label> 
											
											<label class="col-sm-2 col-form-label font-weight-normal pl-0 pr-0">
												<input class="form-check-input" type="radio" name="s_data[recover_from]" id="recover_from" value="1" onclick="changemawbData('pickup', 1, <?php echo $shipInfo['shipment_id']; ?>);" <?php echo ((isset($aRecords['s_data']['recover_from']) && $aRecords['s_data']['recover_from'] == 1) ? 'checked' : ''); ?>>
												Shipper
											</label>
											
											
											
											<label class="col-sm-2 col-form-label font-weight-normal pl-0 pr-0">
												<input class="form-check-input" type="radio" name="s_data[recover_from]" id="recover_from" value="2" onclick="changemawbData('pickup', 2, <?php echo $shipInfo['shipment_id']; ?>);"  <?php echo ((isset($aRecords['s_data']['recover_from']) && $aRecords['s_data']['recover_from'] == 2) ? 'checked' : ''); ?>>
												Consignee
											</label>
											<label class="col-sm-2 col-form-label font-weight-normal pl-0 pr-0">
												<input class="form-check-input" type="radio" name="s_data[recover_from]" id="recover_from" value="3" onclick="changemawbData('pickup', 3, <?php echo $shipInfo['shipment_id']; ?>);" <?php echo ((isset($aRecords['s_data']['recover_from']) && $aRecords['s_data']['recover_from'] == 3) ? 'checked' : ''); ?>>
												Vendor
											</label> 
										</div>
								
										<div class="form-group row">
											<label class="col-sm-3 col-form-label" for="shipper_name">Name</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" value="<?php echo (isset($aRecords['s_data']['s_name']) ? $aRecords['s_data']['s_name'] : 'Fastline Logistics LLC'); ?>" id="s_name" name="s_data[s_name]" maxlength="128">
												<input type="hidden" class="form-control" value="<?php echo ((isset($aRecords['s_data']['s_id']) && !empty($aRecords['s_data']['s_id'])) ? $aRecords['s_data']['s_id'] : 0); ?>" id="s_id" name="s_data[s_id]" >
												<input type="hidden" class="form-control" value="<?php echo $shipInfo['shipment_id']; ?>" id="shipment_id" name="val[shipment_id]" >
											</div>
										</div>
																										
										<div class="form-group row">
											<label class="col-sm-3 col-form-label" for="s_address_1">Address 1</label>
											<div class="col-sm-9">
												
												<textarea name='s_data[s_address_1]' id="s_address_1" class="form-control" rows="1"><?php echo (isset($aRecords['s_data']['s_address_1']) ? $aRecords['s_data']['s_address_1'] : 'P.O Box 266'); ?></textarea>
											</div>
										</div>
								
										<div class="form-group row">
											<label class="col-sm-3 col-form-label" for="s_address_2">Address 2</label>
											<div class="col-sm-9">
												<textarea name='s_data[s_address_2]' id="s_address_2" class="form-control" rows="1"><?php echo (isset($aRecords['s_data']['s_address_2']) ? $aRecords['s_data']['s_address_2'] : ''); ?></textarea>
											</div>
										</div>
								
										<div class="form-group row">
											<label class="col-sm-3 col-form-label" for="s_city">City</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" value="<?php echo (isset($aRecords['s_data']['s_city']) ? $aRecords['s_data']['s_city'] : 'Centerton'); ?>" id="s_city" name="s_data[s_city]" maxlength="128">
											</div>
										</div>
											
										<div class="form-group row" id="consignee_state">
											<label class="col-sm-3 col-form-label" for="st_zip_country">St/Zip</label>
											<div class="col-sm-4 pr-0">
												<select class="form-control com_state" id="s_state" name="s_data[s_state]">
													<option value="0">State</option>
													<?php
													if(!empty($s_states))
													{
														foreach ($s_states as $st)
														{
															?>
															<option value="<?php echo $st['state_id'] ?>" <?php if($st['state_id'] == (isset($aRecords['s_data']['s_state']) ? $aRecords['s_data']['s_state'] : 3)) {echo "selected=selected";} ?>><?php echo $st['state_name'] ?></option>
															<?php
														}
													}
													?>
												</select>
											</div>
											<div class="col-sm-4 pr-0">
												<input type="text" class="form-control zip_en_data" value="<?php echo (isset($aRecords['s_data']['s_zip']) ? $aRecords['s_data']['s_zip'] : '72719'); ?>" id="s_zip" name="s_data[s_zip]" placeholder="Zip" maxlength="8">
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-sm-3 col-form-label" for="s_city">Country</label>
											<div class="col-sm-7">
												<select class="form-control required com_country" id="s_country" name="s_data[s_country]" data-parentid="#consignee_state">
													<option value="0">Country</option>
													<?php
													if(!empty($countries))
													{
														foreach ($countries as $rl)
														{
															?>
															<option value="<?php echo $rl['country_id'] ?>" <?php if($rl['country_id'] ==  (isset($aRecords['s_data']['s_country']) ? $aRecords['s_data']['s_country'] : 2)) {echo "selected=selected";} ?>><?php echo $rl['country_name'] ?></option>
															<?php
														}
													}
													?>
												</select>
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-sm-3 col-form-label" for="st_zip_country">Contact</label>
											<div class="col-sm-5">
												<input type="text" class="form-control" id="s_contact" value="<?php echo (isset($aRecords['s_data']['s_contact']) ? $aRecords['s_data']['s_contact'] : 'Chris Ringhausen'); ?>" name="s_data[s_contact]" maxlength="128" placeholder="Contact">
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-sm-3 col-form-label" for="st_zip_country">Phone</label>
											<div class="col-sm-5">
												<input type="text" class="form-control us_phone_num_design" id="s_phone" value="<?php echo (isset($aRecords['s_data']['s_phone']) ? $aRecords['s_data']['s_phone'] : '1-800-540-6100'); ?>" name="s_data[s_phone]" maxlength="14" placeholder="Phone">
											</div>
										</div>

									</div>
									
									<div class="col-md-6">
										<div class="form-group row">
											<span class="font-weight-bold f16 col-sm-3">Consignee</span>
											<label class="col-sm-3 col-form-label font-weight-normal">
												<input class="form-check-input" type="radio" name="c_data[transfer_to]" id="transfer_to" value="1" onclick="changemawbData('delivery', 1, <?php echo $shipInfo['shipment_id']; ?>);"  <?php echo ((isset($aRecords['c_data']['transfer_to']) && $aRecords['c_data']['transfer_to'] == 1) ? 'checked' : ''); ?>>
												Shipper 
											</label>
											<label class="col-sm-3 col-form-label font-weight-normal">
												<input class="form-check-input" type="radio" name="c_data[transfer_to]" id="transfer_to" value="2" onclick="changemawbData('delivery', 2, <?php echo $shipInfo['shipment_id']; ?>);"  <?php echo ((isset($aRecords['c_data']['transfer_to']) && $aRecords['c_data']['transfer_to'] == 2) ? 'checked' : ''); ?>>
												Consignee
											</label>
											<label class="col-sm-3 col-form-label font-weight-normal">
												<input class="form-check-input" type="radio" name="c_data[transfer_to]" id="transfer_to" value="3" onclick="changemawbData('delivery', 3, <?php echo $shipInfo['shipment_id']; ?>);"  <?php echo ((isset($aRecords['c_data']['transfer_to']) && $aRecords['c_data']['transfer_to'] == 3) ? 'checked' : ''); ?> <?php echo (empty($aRecords['c_data']['transfer_to']) ? 'checked' : ''); ?>>
												Vendor
											</label> 
										</div>
										
										<div class="form-group row">
											<label class="col-sm-3 col-form-label" for="shipper_name">Name</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" value="<?php echo (isset($aRecords['c_data']['c_name']) ? $aRecords['c_data']['c_name'] : $deliveryVenData['name']); ?>" id="c_name" name="c_data[c_name]" maxlength="128">
												<input type="hidden" class="form-control" value="<?php echo (isset($aRecords['c_data']['c_id']) ? $aRecords['c_data']['c_id'] : $deliveryVenData['vendor_id']); ?>" id="c_id" name="c_data[c_id]" >
												<input type="hidden" class="form-control" value="<?php echo $shipInfo['shipment_id']; ?>" id="shipment_id" name="c_data[shipment_id]" >
											</div>
										</div>
																										
										<div class="form-group row">
											<label class="col-sm-3 col-form-label" for="c_address_1">Address 1</label>
											<div class="col-sm-9">
												
												<textarea name='c_data[c_address_1]' id="c_address_1" class="form-control" rows="1"><?php echo (isset($aRecords['c_data']['c_address_1']) ? $aRecords['c_data']['c_address_1'] : $deliveryVenData['address_1']); ?></textarea>
											</div>
										</div>
								
										<div class="form-group row">
											<label class="col-sm-3 col-form-label" for="c_address_2">Address 2</label>
											<div class="col-sm-9">
												<textarea name='c_data[c_address_2]' id="c_address_2" class="form-control" rows="1"><?php echo (isset($aRecords['c_data']['c_address_2']) ? $aRecords['c_data']['c_address_2'] : $deliveryVenData['address_2']); ?></textarea>
											</div>
										</div>
								
										<div class="form-group row">
											<label class="col-sm-3 col-form-label" for="c_city">City</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" value="<?php echo (isset($aRecords['c_data']['c_city']) ? $aRecords['c_data']['c_city'] : $deliveryVenData['city']); ?>" id="c_city" name="c_data[c_city]" maxlength="128">
											</div>
										</div>
											
										<div class="form-group row"  id="shipper_state">
											<label class="col-sm-3 col-form-label" for="st_zip_country">St/Zip</label>
											<div class="col-sm-4 pr-0">
												<select class="form-control com_state" id="c_state" name="c_data[c_state]">
													<option value="0">State</option>
													<?php
													if(!empty($c_states))
													{
														foreach ($c_states as $st)
														{
															?>
															<option value="<?php echo $st['state_id'] ?>" <?php if($st['state_id'] == (isset($aRecords['c_data']['c_state']) ? $aRecords['c_data']['c_state'] : $deliveryVenData['c_state'])) {echo "selected=selected";} ?>><?php echo $st['state_name'] ?></option>
															<?php
														}
													}
													?>
												</select>
											</div>
											<div class="col-sm-4 pr-0">
												<input type="text" class="form-control zip_en_data" value="<?php echo (isset($aRecords['c_data']['c_zip']) ? $aRecords['c_data']['c_zip'] : $deliveryVenData['zip']); ?>" id="c_zip" name="c_data[c_zip]" placeholder="Zip" maxlength="8">
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-sm-3 col-form-label" for="s_city">Country</label>
											<div class="col-sm-7">
												<select class="form-control required com_country" id="c_country" name="c_data[c_country]" data-parentid="#shipper_state">
													<option value="0">Country</option>
													<?php
													if(!empty($countries))
													{
														foreach ($countries as $rl)
														{
															?>
															<option value="<?php echo $rl['country_id'] ?>" <?php if($rl['country_id'] ==  (isset($aRecords['c_data']['c_country']) ? $aRecords['c_data']['c_country'] : $deliveryVenData['c_country'])) {echo "selected=selected";} ?>><?php echo $rl['country_name'] ?></option>
															<?php
														}
													}
													?>
												</select>
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-sm-3 col-form-label" for="st_zip_country">Contact</label>
											<div class="col-sm-5">
												<input type="text" class="form-control" id="c_contact" value="<?php echo (isset($aRecords['c_data']['c_contact']) ? $aRecords['c_data']['c_contact'] : $deliveryVenData['contact']); ?>" name="c_data[c_contact]" maxlength="128" placeholder="Contact">
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-sm-3 col-form-label" for="st_zip_country">Phone</label>
											<div class="col-sm-5">
												<input type="text" class="form-control us_phone_num_design" id="c_phone" value="<?php echo (isset($aRecords['c_data']['c_phone']) ? $aRecords['c_data']['c_phone'] : $deliveryVenData['phone']); ?>" name="c_data[c_phone]" maxlength="14" placeholder="Phone">
											</div>
										</div>
										
										
									</div>
								</div>
								
								<div class="row m-0 border_bottom_2x">
								
									<div class="col-md-6 border_right_2x">
											
										<div class="form-group row">
											<span class="font-weight-bold f16 col-sm-12">Issuing Carrier's Agent</span>
										</div>
								
										<div class="form-group row">
											<label class="col-sm-3 col-form-label" for="shipper_name">Name</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" value="<?php echo (isset($aRecords['a_data']['a_name']) ? $aRecords['a_data']['a_name'] : 'Fastline Logistics'); ?>" id="a_name" name="a_data[a_name]" maxlength="128">
											</div>
										</div>
																										
										<div class="form-group row">
											<label class="col-sm-3 col-form-label" for="a_address_1">Address 1</label>
											<div class="col-sm-9">
												
												<textarea name='a_data[a_address_1]' id="a_address_1" class="form-control" rows="1"><?php echo (isset($aRecords['a_data']['a_address_1']) ? $aRecords['a_data']['a_address_1'] : 'P.O. Box 266'); ?></textarea>
											</div>
										</div>
								
										<div class="form-group row">
											<label class="col-sm-3 col-form-label" for="a_address_2">Address 2</label>
											<div class="col-sm-9">
												<textarea name='a_data[a_address_2]' id="a_address_2" class="form-control" rows="1"><?php echo (isset($aRecords['a_data']['a_address_2']) ? $aRecords['a_data']['a_address_2'] : ''); ?></textarea>
											</div>
										</div>
								
										<div class="form-group row">
											<label class="col-sm-3 col-form-label" for="a_city">City</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" value="<?php echo (isset($aRecords['a_data']['a_city']) ? $aRecords['a_data']['a_city'] : 'Centerton'); ?>" id="a_city" name="a_data[a_city]" maxlength="128">
											</div>
										</div>
											
										<div class="form-group row" id="agent_state">
											<label class="col-sm-3 col-form-label" for="st_zip_country">St/Zip</label>
											<div class="col-sm-4 pr-0">
												<select class="form-control com_state" id="a_state" name="a_data[a_state]">
													<option value="0">State</option>
													<?php
													if(!empty($s_states))
													{
														foreach ($s_states as $st)
														{
															?>
															<option value="<?php echo $st['state_id'] ?>" <?php if($st['state_id'] == (isset($aRecords['a_data']['a_state']) ? $aRecords['a_data']['a_state'] : '3')) {echo "selected=selected";} ?>><?php echo $st['state_name'] ?></option>
															<?php
														}
													}
													?>
												</select>
											</div>
											<div class="col-sm-4 pr-0">
												<input type="text" class="form-control zip_en_data" value="<?php echo (isset($aRecords['a_data']['a_zip']) ? $aRecords['a_data']['a_zip'] : '72719'); ?>" id="a_zip" name="a_data[a_zip]" placeholder="Zip" maxlength="8">
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-sm-3 col-form-label" for="a_city">Country</label>
											<div class="col-sm-7">
												<select class="form-control required com_country" id="a_country" name="a_data[a_country]" data-parentid="#agent_state">
													<option value="0">Country</option>
													<?php
													if(!empty($countries))
													{
														foreach ($countries as $rl)
														{
															?>
															<option value="<?php echo $rl['country_id'] ?>" <?php if($rl['country_id'] ==  (isset($aRecords['a_data']['a_country']) ? $aRecords['a_data']['a_country'] : '2')) {echo "selected=selected";} ?>><?php echo $rl['country_name'] ?></option>
															<?php
														}
													}
													?>
												</select>
											</div>
										</div>	

										<div class="form-group row border_top_2x pt-2">
											<span class="font-weight-bold col-sm-3 ">Agent's IATA Code</span>
											<div class="col-sm-3 pr-0">
												<input type="text" class="form-control" value="<?php echo (isset($aRecords['a_data']['iata_code']) ? $aRecords['a_data']['iata_code'] : ''); ?>" id="iata_code" name="a_data[iata_code]"  maxlength="20">
											</div>
											<span class="font-weight-bold col-sm-3">Account No.</span>
											<div class="col-sm-3 pr-0">
												<input type="text" class="form-control" value="<?php echo ((isset($aRecords['a_data']['account_no']) && !empty($aRecords['a_data']['account_no']))  ? $aRecords['a_data']['account_no'] : $agent_account_no); ?>" id="account_no" name="a_data[account_no]"  maxlength="20">
											</div>
										</div>
										
										<div class="form-group row" id="agent_airport_data">
											<label class="col-sm-4 col-form-label" for="airpot_departure">Airport of Departure</label>
											<div class="col-sm-5">
												<input type="text" class="form-control ui-autocomplete-input" id="agent_airport" value="<?php echo (isset($aRecords['a_data']['agent_airport']) ? $aRecords['a_data']['agent_airport'] : $shipInfo['origin_airport_code']); ?>" name="a_data[agent_airport]" maxlength="10" autocomplete="off" onclick="$('#agent_airport_url').click();">
												
												<input type="hidden" class="form-control" value="<?php echo (isset($aRecords['a_data']['agent_airport_id']) ? $aRecords['a_data']['agent_airport_id'] : $shipInfo['origin_airport_id']); ?>" id="agent_airport_id" name="a_data[agent_airport_id]" >
											</div>
											<div class="col-sm-3" style="margin-top: 5px;">
												<a href="javascript:void(0);" id="agent_airport_url" data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('agent_airport', 'agent_airport_id', 'all','agent_airport_data' );"><i class="fa fa-search"></i></a>
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-sm-12 col-form-label" for="acc_info">Address of First Carrier and Requested Routing</label>
											<div class="col-sm-12">
												<textarea name='a_data[agent_address_carrier]' id="account_information" class="form-control" rows="2"><?php echo ((isset($aRecords['a_data']['agent_address_carrier']) && !empty($aRecords['a_data']['agent_address_carrier'])) ? $aRecords['a_data']['agent_address_carrier'] : $agent_address_carrier); ?></textarea>
											</div>
										</div>
										
										
									</div>
									
									
									<div class="col-md-6">
								
										<div class="form-group row" id="issuer_info_data">
											<label class="col-sm-12 col-form-label" for="shipper_name">Issued by</label>
											<div class="col-sm-12">
												<input type="text" class="form-control" value="<?php echo (isset($aRecords['issued_by_name']) ? $aRecords['issued_by_name'] : $issuedbyname); ?>" id="issued_by_name" name="val[issued_by_name]" maxlength="75" style="width:200px;float:left;" autocomplete="off"  onclick="$(this).next('#issued_search_url').click();">
												
												<a href="javascript:void(0);" id="issued_search_url" class="pt-2 pl-4" style="display: inline-block;" data-toggle="modal" data-target="#myModaloverlap" onclick="loadVendors('issued_by_name', 'issued_by_id', 'all', 'issuer_info_data');"><i class="fa fa-search"></i></a> 
												
												<input type="hidden" value="<?php echo (isset($aVendorData['issued_by_id']) ? $aVendorData['issued_by_id'] : $issued_by_id); ?>" id="issued_by_id" name="val[issued_by_id]">
												<input type="hidden" value="000" id="p_v_type_id" name="val[p_v_type_id]">
												
											</div>
										</div>
																										
										<div class="form-group row">
											<label class="col-sm-12 col-form-label" for="acc_info">Accounting Information</label>
											<div class="col-sm-12">
												
												<textarea name='val[account_information]' id="account_information" class="form-control" rows="2"><?php echo (isset($aRecords['account_information']) ? $aRecords['account_information'] : $v_account); ?></textarea>
											</div>
										</div>
																
										<div class="form-group row">
											<label class="col-sm-12 col-form-label" for="ref_numb">Reference Number</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" value="<?php echo (isset($aRecords['reference_number']) ? $aRecords['reference_number'] : $issued_ref_no); ?>" id="reference_number" name="val[reference_number]" maxlength="25">
											</div>
										</div>
											
										<div class="form-group row">
											<label class="col-sm-12 col-form-label" for="opt_shipp_info">Optional Shipping Information</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" value="<?php echo (isset($aRecords['opt_shipp_info']) ? $aRecords['opt_shipp_info'] : ''); ?>" id="opt_shipp_info" name="val[opt_shipp_info]" maxlength="25">
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-sm-12 col-form-label" for="sci">SCI</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" value="<?php echo (isset($aRecords['opt_sci_info']) ? $aRecords['opt_sci_info'] : ''); ?>" id="opt_sci_info" name="val[opt_sci_info]" maxlength="25">
											</div>
										</div>
										
																			
									</div>
									
								</div>
								
								<div class="row m-0 border_bottom_2x" id="mawb_multiairport_div">
								
									<div class="col-md-12">
										<table class="table">
											<tr class="">
												<th class="text-center">To</th>
												<th class="text-center">By</th>
												<th class="text-center">To</th>
												<th class="text-center">By</th>
												<th class="text-center">To</th>
												<th class="text-center">By</th>
												<th class="text-center">Currency</th>
												<th class="text-center">CGHS Code</th>
												<th class="text-center">WT/VAL</th>
												<th class="text-center">Other</th>
												<th class="text-center">Declared value for Carriage</th>
												<th class="text-center">Declared value for Customs</th>
											</tr>
											<tr>
												
												<td>
													<input type="text" class="form-control" value="<?php echo (isset($aRecords['ap_data']['to_airport_1']) ? $aRecords['ap_data']['to_airport_1'] : ''); ?>" id="to_airport_1" name="ap_data[to_airport_1]" maxlength="20" data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('to_airport_1', 'to_airport_1_id', 'all', 'mawb_multiairport_div');">
													<input type="hidden" value="<?php echo (isset($aRecords['ap_data']['to_airport_1_id']) ? $aRecords['ap_data']['to_airport_1_id'] : ''); ?>" id="to_airport_1_id" name="ap_data[to_airport_1_id]">
												</td>
												
												<td id="to_by_id_1" style="width:100px;">
													<input type="text" class="form-control" value="<?php echo (isset($aRecords['ap_data']['by_name_1']) ? $aRecords['ap_data']['by_name_1'] : ''); ?>" id="by_name_1" name="ap_data[by_name_1]" maxlength="75" style="width:60px;float:left;" autocomplete="off"  onclick="$(this).next('#by_url_1').click();">
													
													<a href="javascript:void(0);" id="by_url_1" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModaloverlap" onclick="loadVendors('by_name_1', 'by_id_1', 'all', 'to_by_id_1');"><i class="fa fa-search"></i></a> 
												
													<input type="hidden" value="<?php echo (isset($aRecords['ap_data']['by_id_1']) ? $aRecords['ap_data']['by_id_1'] : ''); ?>" id="by_id_1" name="ap_data[by_id_1]">

												</td>
												
												<td>
													<input type="text" class="form-control" value="<?php echo (isset($aRecords['ap_data']['to_airport_2']) ? $aRecords['ap_data']['to_airport_2'] : ''); ?>" id="to_airport_2" name="ap_data[to_airport_2]" maxlength="20" data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('to_airport_2', 'to_airport_2_id', 'all', 'mawb_multiairport_div');">
													<input type="hidden" value="<?php echo (isset($aRecords['ap_data']['to_airport_2_id']) ? $aRecords['ap_data']['to_airport_2_id'] : ''); ?>" id="to_airport_2_id" name="ap_data[to_airport_2_id]">
												</td>
												
												<td id="to_by_id_2" style="width:100px;">
													<input type="text" class="form-control" value="<?php echo (isset($aRecords['ap_data']['by_name_2']) ? $aRecords['ap_data']['by_name_2'] : ''); ?>" id="by_name_2" name="ap_data[by_name_2]" maxlength="75"  style="width:60px;float:left;" autocomplete="off"  onclick="$(this).next('#by_url_2').click();">
													
													<a href="javascript:void(0);" id="by_url_2" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModaloverlap" onclick="loadVendors('by_name_2', 'by_id_2', 'all', 'to_by_id_2');"><i class="fa fa-search"></i></a> 
												
													<input type="hidden" value="<?php echo (isset($aRecords['ap_data']['by_id_2']) ? $aRecords['ap_data']['by_id_2'] : ''); ?>" id="by_id_2" name="ap_data[by_id_2]">
												</td>
												
												<td>
													<input type="text" class="form-control" value="<?php echo (isset($aRecords['ap_data']['to_airport_3']) ? $aRecords['ap_data']['to_airport_3'] : ''); ?>" id="to_airport_3" name="ap_data[to_airport_3]" maxlength="20" data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('to_airport_3', 'to_airport_3_id', 'all', 'mawb_multiairport_div');">
													<input type="hidden" value="<?php echo (isset($aRecords['ap_data']['to_airport_3_id']) ? $aRecords['ap_data']['to_airport_3_id'] : ''); ?>" id="to_airport_3_id" name="ap_data[to_airport_3_id]">
												</td>
												
												<td id="to_by_id_3" style="width:100px;">
													<input type="text" class="form-control" value="<?php echo (isset($aRecords['ap_data']['by_name_3']) ? $aRecords['ap_data']['by_name_3'] : ''); ?>" id="by_name_3" name="ap_data[by_name_3]" maxlength="75" style="width:60px;float:left;" autocomplete="off"  onclick="$(this).next('#by_url_3').click();">
													
													<a href="javascript:void(0);" id="by_url_3" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModaloverlap" onclick="loadVendors('by_name_3', 'by_id_3', 'all', 'to_by_id_3');"><i class="fa fa-search"></i></a> 
												
													<input type="hidden" value="<?php echo (isset($aRecords['ap_data']['by_id_3']) ? $aRecords['ap_data']['by_id_3'] : ''); ?>" id="by_id_3" name="ap_data[by_id_3]">
												</td>
												
												<td>
													<select class="form-control" id="ap_currency" name="ap_data[ap_currency]">
														<?php
														if(!empty($currencies))
														{
															foreach ($currencies as $cur)
															{
																?>
																<option value="<?php echo $cur['currency_id']; ?>" <?php if($cur['currency_id'] == (isset($aRecords['ap_data']['ap_currency']) ? $aRecords['ap_data']['ap_currency'] : '1')) {echo "selected=selected";} ?>><?php echo $cur['currency_code']; ?></option>
																<?php
															}
														}
														?>
													</select>
												</td>
												
												<td>
													<input type="text" class="form-control" value="<?php echo (isset($aRecords['ap_data']['cghs_code']) ? $aRecords['ap_data']['cghs_code'] : ''); ?>" id="cghs_code" name="ap_data[cghs_code]" maxlength="20">
												</td>
												
												<td>
													<label class="col-form-label font-weight-normal">
														<input class="form-check-input" type="radio" name="ap_data[wt_vall]" id="wt_vall" value="1" <?php echo ((isset($aRecords['ap_data']['wt_vall']) && $aRecords['ap_data']['wt_vall'] == 1) ? 'checked' : 'checked'); ?>>
														PPD
													</label>
													<label class="col-form-label font-weight-normal">
														<input class="form-check-input" type="radio" name="ap_data[wt_vall]" id="wt_vall" value="2" <?php echo ((isset($aRecords['ap_data']['wt_vall']) && $aRecords['ap_data']['wt_vall'] == 2) ? 'checked' : ''); ?>>
														COLL
													</label>
												</td>
												
												<td>
													<label class="col-form-label font-weight-normal">
														<input class="form-check-input" type="radio" name="ap_data[other_vall]" id="other_vall" value="1" <?php echo ((isset($aRecords['ap_data']['other_vall']) && $aRecords['ap_data']['other_vall'] == 1) ? 'checked' : 'checked'); ?>>
														PPD
													</label>
													<label class="col-form-label font-weight-normal">
														<input class="form-check-input" type="radio" name="ap_data[other_vall]" id="other_vall" value="2" <?php echo ((isset($aRecords['ap_data']['other_vall']) && $aRecords['ap_data']['other_vall'] == 2) ? 'checked' : ''); ?>>
														COLL
													</label>
												</td>
												
												<td>
													<input type="text" class="form-control currency" value="<?php echo (isset($aRecords['ap_data']['d_v_carriage']) ? $aRecords['ap_data']['d_v_carriage'] : $shipInfo['insured_value']); ?>" id="d_v_carriage" name="ap_data[d_v_carriage]" maxlength="20">
												</td>
												
												<td>
													<input type="text" class="form-control currency" value="<?php echo (isset($aRecords['ap_data']['d_v_customs']) ? $aRecords['ap_data']['d_v_customs'] : $shipInfo['insured_value']); ?>" id="d_v_customs" name="ap_data[d_v_customs]" maxlength="20">
												</td>
												
											</tr>
											
											
									  </table>

									  <table class="table">
											<tr class="">
												<th class="text-left">Airport of Destination</th>
												<th class="text-center">Flight 1</th>
												<th class="text-center">Date 1</th>
												<th class="text-center">Flight 2</th>
												<th class="text-center">Date 2</th>
												<th class="text-center">Flight 3</th>
												<th class="text-center">Date 3</th>
												<th class="text-center">Amount of Insurance</th>
											</tr>
											<tr>
												
												<td>
													<input type="text" class="form-control" value="<?php echo (isset($aRecords['ap_data']['ap_dest']) ? $aRecords['ap_data']['ap_dest'] : $shipInfo['dest_airport_code']); ?>" id="ap_dest" name="ap_data[ap_dest]" maxlength="20" data-toggle="modal" data-target="#myModaloverlap" onclick="loadFlightOrigin('ap_dest', 'ap_dest_id', 'all', 'mawb_multiairport_div');">
													<input type="hidden" value="<?php echo (isset($aRecords['ap_data']['ap_dest_id']) ? $aRecords['ap_data']['ap_dest_id'] : $shipInfo['dest_airport_id']); ?>" id="ap_dest_id" name="ap_data[ap_dest_id]">
												</td>
												
												<td>
													<input type="text" class="form-control digits" value="<?php echo (isset($aRecords['ap_data']['flight_1']) ? $aRecords['ap_data']['flight_1'] : ''); ?>" id="flight_1" name="ap_data[flight_1]" maxlength="30">
												</td>
												
												<td>
													<input type="text" class="form-control dateonlypicker" id="date_1" value="<?php echo ((isset($aRecords['ap_data']['date_1'])  && !empty($aRecords['ap_data']['date_1'])) ? date('m/d/Y',strtotime($aRecords['ap_data']['date_1'])) : ''); ?>" name="ap_data[date_1]">
												</td>
												
												<td>
													<input type="text" class="form-control digits" value="<?php echo (isset($aRecords['ap_data']['flight_2']) ? $aRecords['ap_data']['flight_2'] : ''); ?>" id="flight_2" name="ap_data[flight_2]" maxlength="30">
												</td>
												
												<td>
													<input type="text" class="form-control dateonlypicker" id="date_2" value="<?php echo ((isset($aRecords['ap_data']['date_2'])  && !empty($aRecords['ap_data']['date_2'])) ? date('m/d/Y',strtotime($aRecords['ap_data']['date_2'])) : ''); ?>" name="ap_data[date_2]">
												</td>
												
												<td>
													<input type="text" class="form-control digits" value="<?php echo (isset($aRecords['ap_data']['flight_3']) ? $aRecords['ap_data']['flight_3'] : ''); ?>" id="flight_3" name="ap_data[flight_3]" maxlength="30">
												</td>
												
												<td>
													<input type="text" class="form-control dateonlypicker" id="date_3" value="<?php echo ((isset($aRecords['ap_data']['date_3'])  && !empty($aRecords['ap_data']['date_3'])) ? date('m/d/Y',strtotime($aRecords['ap_data']['date_3'])) : ''); ?>" name="ap_data[date_3]">
												</td>
												
												
												<td>
													<input type="text" class="form-control currency" value="<?php echo (isset($aRecords['ap_data']['insurance_amount']) ? $aRecords['ap_data']['insurance_amount'] : ''); ?>" id="insurance_amount" name="ap_data[insurance_amount]" maxlength="20">
												</td>
												
											</tr>
										
									  </table>	
									  
									  <div class="form-group row">
										<label class="col-sm-12 col-form-label" for="handling_info">Handling Information</label>
										<div class="col-sm-12">
											<textarea name='val[handling_info]' id="handling_info" class="form-control" rows="2"><?php echo (isset($aRecords['handling_info']) ? $aRecords['handling_info'] : ''); ?></textarea>
										</div>
									 </div>
									  
									  <table class="table">
											<tr class="">
												<th class="text-center">Pieces</th>
												<th class="text-center">Gross Weight</th>
												<th class="text-center">LB/KG</th>
												<th class="text-center">Rate Class</th>
												<th class="text-center">Item No.</th>
												<th class="text-center">Chargeable Weight</th>
												<th class="text-center">Rate/Charge</th>
												<th class="text-center">Total</th>
												<th class="text-center">Nature and Quantity of Goods (include Dimensions or Volume)</th>
											</tr>
											<?php 
												
												$totalpieces = $totalweight = 0;
												if(empty($aRecords) || empty($aRecords['fr_data'])){
												if(isset($shipInfo['freight_datas']) && !empty($shipInfo['freight_datas'])){
													
													foreach($shipInfo['freight_datas'] as $key => $frdata){
													$frdata = (array) $frdata;
													$totalpieces = $totalpieces + ((isset($frdata['pieces']) && !empty($frdata['pieces'])) ? (int)$frdata['pieces'] : 0);
													$totalweight = $totalweight + ((isset($frdata['weight']) && !empty($frdata['weight'])) ? (float)$frdata['weight'] : 0);
											?>
												<tr>
													<td>
														<input type="text" class="form-control digits" value="<?php echo (isset($frdata['pieces']) ? $frdata['pieces'] : ''); ?>" id="fr_pieces" name="fr_data[fr_pieces][]" maxlength="6">
													</td>
													
													<td>
														<input type="text" class="form-control number" value="<?php echo (isset($frdata['weight']) ? $frdata['weight'] : ''); ?>" id="fr_weight" name="fr_data[fr_weight][]" maxlength="6">
													</td>
													
													<td>
														<select class="form-control" id="lb_kg" name="fr_data[lb_kg][]">

															<option value="lb" selected>LB</option>
															<option value="kg">KG</option>

														</select>
													</td>
													
													<td class="text-center">
														<input class="form-check-input" type="checkbox" value="1" name="fr_data[rate_class][]" id="rate_class">
													</td>
													
													<td>
														<input type="text" class="form-control" value="" id="item_no" name="fr_data[item_no][]" maxlength="10">
													</td>
												
													<td>
														<input type="text" class="form-control number" value="<?php echo (($frdata['t_dim_weight'] > $frdata['weight']) ? $frdata['t_dim_weight'] : $frdata['weight']); ?>" id="chargeable_wt" name="fr_data[chargeable_wt][]" maxlength="10">
													</td>
													
													<td>
														<input type="text" class="form-control digits" value="" id="r_charge" name="fr_data[r_charge][]" maxlength="8">
													</td>
													
													<td>
														<input type="text" class="form-control digits" value="" id="fr_total" name="fr_data[fr_total][]" maxlength="8">
													</td>
											
													<td>
														
														<textarea name='fr_data[n_q_goods][]' id="n_q_goods" class="form-control" rows="1"><?php echo (isset($frdata['description']) ? $frdata['description'] ."\n" : '').(isset($frdata['length']) ? $frdata['length'] : '') . (isset($frdata['width']) ? 'x'.$frdata['width'] : 'x') . (isset($frdata['height']) ? 'x'.$frdata['height'] : 'x').(isset($frdata['pieces']) ? '/'.$frdata['pieces'] : ''); ?></textarea>
														
													</td>
													
												</tr>
											<?php
													}
												}
												}
												
												if(isset($aRecords['fr_data']) && !empty($aRecords['fr_data'])){
												
												foreach($aRecords['fr_data'] as $key => $frdata){
												
												$totalpieces = $totalpieces + ((isset($frdata['fr_pieces']) && !empty($frdata['fr_pieces'])) ? (int)$frdata['fr_pieces'] : 0);
												$totalweight = $totalweight + ((isset($frdata['fr_weight']) && !empty($frdata['fr_weight'])) ? (float)$frdata['fr_weight'] : 0);
											?>
												<tr>
													<td>
														<input type="text" class="form-control digits" value="<?php echo (isset($frdata['fr_pieces']) ? $frdata['fr_pieces'] : ''); ?>" id="fr_pieces" name="fr_data[fr_pieces][]" maxlength="6">
													</td>
													
													<td>
														<input type="text" class="form-control number" value="<?php echo (isset($frdata['fr_weight']) ? $frdata['fr_weight'] : ''); ?>" id="fr_weight" name="fr_data[fr_weight][]" maxlength="6">
													</td>
													
													<td>
														<select class="form-control" id="lb_kg" name="fr_data[lb_kg][]">

															<option value="lb" <?php echo ((isset($frdata['lb_kg']) && $frdata['lb_kg'] == 'lb') ?  "selected=selected" : 'selected');?>>LB</option>
															<option value="kg" <?php echo ((isset($frdata['lb_kg']) && $frdata['lb_kg'] == 'kg') ?  "selected=selected" : '');?>>KG</option>

														</select>
													</td>
													
													<td class="text-center">
														<input class="form-check-input" type="checkbox" value="1" name="fr_data[rate_class][]" id="rate_class" <?php echo ((isset($frdata['rate_class']) && $frdata['rate_class'] == 1) ?  "checked" : '');?>>
													</td>
													
													<td>
														<input type="text" class="form-control" value="<?php echo (isset($frdata['item_no']) ? $frdata['item_no'] : ''); ?>" id="item_no" name="fr_data[item_no][]" maxlength="10">
													</td>
													
													<td>
														<input type="text" class="form-control" value="<?php echo (isset($frdata['chargeable_wt']) ? $frdata['chargeable_wt'] : ''); ?>" id="chargeable_wt" name="fr_data[chargeable_wt][]" maxlength="10">
													</td>
													
													<td>
														<input type="text" class="form-control" value="<?php echo (isset($frdata['r_charge']) ? $frdata['r_charge'] : ''); ?>" id="r_charge" name="fr_data[r_charge][]" maxlength="8">
													</td>
													
													<td>
														<input type="text" class="form-control" value="<?php echo (isset($frdata['fr_total']) ? $frdata['fr_total'] : ''); ?>" id="fr_total" name="fr_data[fr_total][]" maxlength="8">
													</td>
													
													<td>
															
														<textarea name='fr_data[n_q_goods][]' id="n_q_goods" class="form-control" rows="1"><?php echo (isset($frdata['n_q_goods']) ? $frdata['n_q_goods'] : ''); ?></textarea>
														
													</td>
													
												</tr>
											<?php }	
												}
											?>	
											<tfoot>
											  <tr>
												<td><strong id="fr_total_pieces"><?php echo $totalpieces;?></strong></td>
												<td><strong id="fr_total_gross_weight"><?php echo $totalweight;?></strong></td>
												<td></td>
												<td></td>
												<td></td>
												<td><strong id="fr_total_charge_weight"></strong></td>
												<td></td>
												<td><a href="javascrip:void(0);" class="btn btn-default btn-sm">Calculation</a></td>
												<td><a href="javascrip:void(0);" class="btn btn-default btn-sm">Letter of credit</a></td>
											  </tr>
											</tfoot>
									  </table>
									  
									  <div class="form-group row pt-2">
											<span class="font-weight-bold col-sm-1">ITN</span>
											<div class="col-sm-3 pr-0">
												<input type="text" class="form-control" value="<?php echo (isset($aRecords['itn']) ? $aRecords['itn'] : ''); ?>" id="itn" name="val[itn]"  maxlength="20">
											</div>
											<span class="font-weight-bold col-sm-1">XTN</span>
											<div class="col-sm-3 pr-0">
												<input type="text" class="form-control" value="<?php echo (isset($aRecords['xtn']) ? $aRecords['xtn'] : ''); ?>" id="xtn" name="val[xtn]"  maxlength="20">
											</div>
									  </div>
									  
									  <div class="form-group row">
										<label class="col-sm-12 col-form-label" for="hawb_note">Info</label>
										<div class="col-sm-12">
											<textarea name='val[hawb_note]' id="hawb_note" class="form-control" rows="2"><?php echo (isset($aRecords['hawb_note']) ? $aRecords['hawb_note'] : $shipInfo['station']. ' '.$shipInfo['waybill']); ?></textarea>
										</div>
									 </div>
										
									</div>

								</div>
									
							</div>
							
							<div class="row m-0">
								
									<div class="col-md-6 border_right_2x">

										<div class="form-group row  text-center pt-2">
											<span class="font-weight-bold col-sm-4"></span>
											<span class="font-weight-bold col-sm-4">Prepaid</span>
											<span class="font-weight-bold col-sm-4">Collect</span>
										</div>
										
										<div class="form-group row">
											<label class="col-sm-4 col-form-label" for="weight_charge">Weight Charge</label>
											<div class="col-sm-4">
												<input type="text" class="form-control currency" id="w_charge_p" value="<?php echo (isset($aRecords['charge_data']['w_charge_p']) ? $aRecords['charge_data']['w_charge_p'] : ''); ?>" name="charge_data[w_charge_p]" maxlength="10">
											</div>
											<div class="col-sm-4">
												<input type="text" class="form-control currency" id="w_charge_c" value="<?php echo (isset($aRecords['charge_data']['w_charge_c']) ? $aRecords['charge_data']['w_charge_c'] : ''); ?>" name="charge_data[w_charge_c]" maxlength="10">
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-sm-4 col-form-label" for="valuation_charge">Valuation Charge</label>
											<div class="col-sm-4">
												<input type="text" class="form-control currency" id="v_charge_p" value="<?php echo (isset($aRecords['charge_data']['v_charge_p']) ? $aRecords['charge_data']['v_charge_p'] : ''); ?>" name="charge_data[v_charge_p]" maxlength="10">
											</div>
											<div class="col-sm-4">
												<input type="text" class="form-control currency" id="v_charge_c" value="<?php echo (isset($aRecords['charge_data']['v_charge_c']) ? $aRecords['charge_data']['v_charge_c'] : ''); ?>" name="charge_data[v_charge_c]" maxlength="10">
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-sm-4 col-form-label" for="valuation_charge">Tax</label>
											<div class="col-sm-4">
												<input type="text" class="form-control currency" id="tax_p" value="<?php echo (isset($aRecords['charge_data']['tax_p']) ? $aRecords['charge_data']['tax_p'] : ''); ?>" name="charge_data[tax_p]" maxlength="20">
											</div>
											<div class="col-sm-4">
												<input type="text" class="form-control currency" id="tax_c" value="<?php echo (isset($aRecords['charge_data']['tax_c']) ? $aRecords['charge_data']['tax_c'] : ''); ?>" name="charge_data[tax_c]" maxlength="20">
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-sm-4 col-form-label" for="valuation_charge">Total Other Charges Due Agent</label>
											<div class="col-sm-4">
												<input type="text" class="form-control currency" id="t_o_c_agent_p" value="<?php echo (isset($aRecords['charge_data']['t_o_c_agent_p']) ? $aRecords['charge_data']['t_o_c_agent_p'] : ''); ?>" name="charge_data[t_o_c_agent_p]" maxlength="10">
											</div>
											<div class="col-sm-4">
												<input type="text" class="form-control currency" id="t_o_c_agent_c" value="<?php echo (isset($aRecords['charge_data']['t_o_c_agent_c']) ? $aRecords['charge_data']['t_o_c_agent_c'] : ''); ?>" name="charge_data[t_o_c_agent_c]" maxlength="10">
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-sm-4 col-form-label" for="valuation_charge">Total Other Charges Due Carrier</label>
											<div class="col-sm-4">
												<input type="text" class="form-control currency" id="t_o_c_car_p" value="<?php echo (isset($aRecords['charge_data']['t_o_c_car_p']) ? $aRecords['charge_data']['t_o_c_car_p'] : ''); ?>" name="charge_data[t_o_c_car_p]" maxlength="10">
											</div>
											<div class="col-sm-4">
												<input type="text" class="form-control currency" id="t_o_c_car_c" value="<?php echo (isset($aRecords['charge_data']['t_o_c_car_c']) ? $aRecords['charge_data']['t_o_c_car_c'] : ''); ?>" name="charge_data[t_o_c_car_c]" maxlength="10">
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-sm-4 col-form-label" for="valuation_charge">Total</label>
											<div class="col-sm-4">
												<input type="text" class="form-control currency" id="t_total_p" value="<?php echo (isset($aRecords['charge_data']['t_total_p']) ? $aRecords['charge_data']['t_total_p'] : ''); ?>" name="charge_data[t_total_p]" maxlength="10">
											</div>
											<div class="col-sm-4">
												<input type="text" class="form-control currency" id="t_total_c" value="<?php echo (isset($aRecords['charge_data']['t_total_c']) ? $aRecords['charge_data']['t_total_c'] : ''); ?>" name="charge_data[t_total_c]" maxlength="10">
											</div>
										</div>
										
										
										<div class="form-group row border_top_2x pt-2">
											<span class="font-weight-bold col-sm-6">Currency Conversion Rates</span>
											<span class="font-weight-bold col-sm-6">CC Charges in Detination Currency</span>
										</div>
										
										<div class="form-group row">
											<div class="col-sm-6">
												<input type="text" class="form-control currency" id="c_conversion_rate" value="<?php echo (isset($aRecords['charge_data']['c_conversion_rate']) ? $aRecords['charge_data']['c_conversion_rate'] : ''); ?>" name="charge_data[c_conversion_rate]" maxlength="10">
											</div>
											<div class="col-sm-6">
												<input type="text" class="form-control currency" id="cc_charge_dest_currency" value="<?php echo (isset($aRecords['charge_data']['cc_charge_dest_currency']) ? $aRecords['charge_data']['cc_charge_dest_currency'] : ''); ?>" name="charge_data[cc_charge_dest_currency]" maxlength="10">
											</div>
										</div>
										
										<div class="form-group row">
											<span class="font-weight-bold col-sm-6">Charges at Destination</span>
											<span class="font-weight-bold col-sm-6">Total Collect Charges</span>
										</div>
										
										<div class="form-group row">
											<div class="col-sm-6">
												<input type="text" class="form-control currency" id="charges_dest" value="<?php echo (isset($aRecords['charge_data']['charges_dest']) ? $aRecords['charge_data']['charges_dest'] : ''); ?>" name="charge_data[charges_dest]" maxlength="10">
											</div>
											<div class="col-sm-6">
												<input type="text" class="form-control currency" id="t_collect_charge" value="<?php echo (isset($aRecords['charge_data']['t_collect_charge']) ? $aRecords['charge_data']['t_collect_charge'] : ''); ?>" name="charge_data[t_collect_charge]" maxlength="10">
											</div>
										</div>
																				
										
									</div>
									
									
									<div class="col-md-6">
								
										<div class="form-group row">
											<label class="col-sm-12 col-form-label" for="shipper_name">Other Charges <a href="javascirpt:voide(0);" class="btn btn-sm btn-default">Calculate</a></label>
											<div class="col-sm-12">
												<textarea name='charge_data[sign_of_shipper]' id="sign_of_shipper" class="form-control" rows="3"><?php echo (isset($aRecords['charge_data']['sign_of_shipper']) ? $aRecords['charge_data']['sign_of_shipper'] : ''); ?></textarea>
											</div>
										</div> 
										<div class="form-group row">
											<label class="col-sm-12 col-form-label" for="ref_numb">Signature of Shipper or his Agent</label>
											<div class="col-sm-12">
												<input type="text" class="form-control" id="sign_of_shipper_2" value="<?php echo $sysname; ?>" name="charge_data[sign_of_shipper_2]" > 
											</div>
										</div>
										
										<div class="form-group row border_top_2x pt-2">
											<span class="font-weight-bold col-sm-6">Excuted On</span>
											<span class="font-weight-bold col-sm-6">at</span>
										</div>
										
										<div class="form-group row">
											<div class="col-sm-6">
												<input type="text" class="form-control dateonlypicker" id="executed_date" value="<?php echo ((isset($aRecords['charge_data']['executed_date'])  && !empty($aRecords['charge_data']['executed_date'])) ? date('m/d/Y',strtotime($aRecords['charge_data']['executed_date'])) : ''); ?>" name="charge_data[executed_date]">
											</div>
											<div class="col-sm-6">
												<input type="text" class="form-control" id="executed_at" value="<?php echo (isset($aRecords['charge_data']['executed_at']) ? $aRecords['charge_data']['executed_at'] : ''); ?>" name="charge_data[executed_at]" maxlength="15">
											</div>
										</div>
										
										<div class="form-group row">
											<span class="font-weight-bold col-sm-6">Signature of issuing Carrier or Its Agent</span>
											<div class="col-sm-12">
												<input type="text" class="form-control" id="sign_carrier" value="<?php echo (isset($aRecords['charge_data']['sign_carrier']) ? $aRecords['charge_data']['sign_carrier'] : 'Fastline Logistics LLC'); ?>" name="charge_data[sign_carrier]" >
											</div>
										</div>
																		
									</div>
									
								</div>
						</div><!-- /.box-body -->
    
						<div class="box-footer">
							<a  href="<?php echo base_url().'editDomesticShipment/'.$shipInfo['shipment_id'].'?showtab=documents-tab'; ?>" class="btn btn-sm btn-default" value=>Back<a/>
							
							<a class="btn btn-sm btn-info btn-sm" <?php echo (empty($aRecords) ? 'style="display:none;"' : '');?> target="_blank" href="<?php echo base_url().'mawbPdf/'.$shipInfo['shipment_id']; ?>">View</a>
							
							<input type="submit" class="btn btn-sm btn-primary" value="Submit" />
							
						</div>
                    </form>
                </div>
            </div>
            
        </div>    
    </section>
    
</div>
<script src="<?php echo base_url(); ?>assets/js/dommawb.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/common.js" type="text/javascript"></script>