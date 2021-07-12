<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Airport Management
        <small>Add / Edit Airport</small>
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
                        <h3 class="box-title">Enter Airport Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addAirport" action="<?php echo base_url() ?>updateAirport" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
								<div class="col-md-6" >
									                                
									
															
									<div class="form-group row">
										<label class="col-sm-3 col-form-label requiredcus" for="airport_name">Airport Name</label>
										<div class="col-sm-9">
											<input type="text" class="form-control required" value="<?php echo $aInfo->airport_name; ?>" id="airport_name" name="airport_name" maxlength="128" autocomplete="off">
											<input type="hidden" value="<?php echo $aInfo->airport_id; ?>" name="airport_id" id="airport_id" /> 
										</div>
									</div>
															
									<div class="form-group row">
										<label class="col-sm-3 col-form-label requiredcus" for="airport_code">Airport Code</label>
										<div class="col-sm-9">
											<input type="text" class="form-control required" value="<?php echo $aInfo->airport_code; ?>" id="airport_code" name="airport_code" maxlength="4" autocomplete="off">
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label requiredcus" for="city">Airport City</label>
										<div class="col-sm-9">
											<input type="text" class="form-control required" value="<?php echo $aInfo->city; ?>" id="city" name="city" maxlength="128" autocomplete="off">
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label requiredcus" for="com_country">Country</label>
										<div class="col-sm-9">
											<select class="form-control required com_country" id="com_country" name="com_country" data-parentid="#airport_state">
												<option value="0">Select Country</option>
												<?php
												if(!empty($countries))
												{
													foreach ($countries as $rl)
													{
														?>
														<option value="<?php echo $rl['country_id'] ?>" <?php if($rl['country_id'] == $aInfo->country_id) {echo "selected=selected";} ?>><?php echo $rl['country_name'] ?></option>
														<?php
													}
												}
												?>
											</select>
										</div>
									</div>
									
									<div class="form-group row" id="airport_state">
										<label class="col-sm-3 col-form-label requiredcus" for="com_state">State</label>
										<div class="col-sm-9">
										   <select class="form-control required com_state" id="com_state" name="com_state">
												<option value="">Select State</option>
												<?php
												if(!empty($states))
												{
													foreach ($states as $st)
													{
														?>
														<option value="<?php echo $st['state_id'] ?>" <?php if($st['state_id'] == $aInfo->state_id) {echo "selected=selected";} ?>><?php echo $st['state_name'] ?></option>
														<?php
													}
												}
												?>
											</select>
										</div>
									</div>

								</div>
								
								
                            </div>

                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Update" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            
        </div>    
    </section>
    
</div>
<script src="<?php echo base_url(); ?>assets/js/common.js" type="text/javascript"></script>

<script>
$(document).ready(function(){
	
	var addAirportForm = $("#addAirport");
	
	var validator = addAirportForm.validate({
		
		rules:{
			airport_name :{ required : true },
			airport_code :{ required : true },
			city :{ required : true },
			com_state :{ required : true },
			com_country : { required : true, selected : true}
		},
		messages:{
			airport_name :{ required : "This field is required" },
			airport_code :{ required : "This field is required" },
			city :{ required : "This field is required" },
			com_state :{ required : "This field is required" },
			com_country : { required : "This field is required", selected : "Please select country option" }			
		}
	});
	
});
</script>