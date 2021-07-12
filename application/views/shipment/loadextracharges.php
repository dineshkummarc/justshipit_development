


  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

             <span aria-hidden="true">&times;</span>

        </button>
        <h4 class="modal-title"><?php echo $popup_title; ?></h4>
      </div>
      <div class="modal-body">
	  
			<div id="extracharge_freight_div_holder" style="display: none;">
									
				<div class="box-body table-responsive no-padding extrachargecode_demo_tr">
					<table class="table table-hover">

						<tr class="extracharge_demo_name_div">
							<td style="width:150px;" class="charge_code_name_div">
								<input type="text" class="form-control " value="" id="charge_code_name" name="extracharge_code[charge_code_name][]" maxlength="20" style="width:80%;float:left;" autocomplete="off" onclick="$(this).next('#extrachargecode_search_url').click();">
								<a href="javascript:void(0);" id="extrachargecode_search_url" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModaloverlap2" onclick="loadExtraChargeCode(this);"><i class="fa fa-search"></i></a>
								<input type="hidden" value="" id="charge_code_id" name="extracharge_code[charge_code_id][]">
							</td> 
							
							<td>
								<input type="text" class="form-control" value="" id="charge_code_description" name="extracharge_code[charge_code_description][]" maxlength="75">
							</td>
							
							<td>
								<select class="form-control" id="charge_code_rate_basis" name="extracharge_code[charge_code_rate_basis][]">
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
								<input type="text" class="form-control digits" value="" id="charge_code_qty" name="extracharge_code[charge_code_qty][]" maxlength="10" onchange="changeExtrachargePrices(this);">
							</td>
							
							<td>
								<input type="text" class="form-control digits" value="" id="charge_code_rate" name="extracharge_code[charge_code_rate][]" maxlength="10" onchange="changeExtrachargePrices(this);">
							</td>
							
							<td>
								<input type="text" class="form-control digits" value="" id="charge_code_charge" name="extracharge_code[charge_code_charge][]" maxlength="10" onchange="changeExtrachargePrices(this);">
							</td>
			
							<td>
								<input type="text" class="form-control digits extracharge_code_total_cost" value="" id="charge_code_total_cost" name="extracharge_code[charge_code_total_cost][]" maxlength="10">
							</td>
							<td>
								<a class="" role="button" onclick="removeNewExtraChargeCode(this);">
									<i class="fa fa-remove"></i>
								</a>
							</td>
						</tr>
				  </table>
				</div>
			</div>
					
			<a class="btn btn-info btn-sm" href="javascript:void(0);" onclick="cloneExtraChargeCode();" style="float:right;">Add</a>
			
			<div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body table-responsive no-padding extrachargecode_div">
					<?php $this->load->view('shipment/selectedextrachargecodes'); ?>                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
      </div>
    </div>
  </div>

