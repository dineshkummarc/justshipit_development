<div class="row m-0">
	<div class="col-md-12">
		<div class="text-right bg-info p-2 font-weight-bold f16">Gross Profit: $0 &nbsp;&nbsp; Percent: 0%</div>

		<div>
			<h3 class="m-0 mt-3">Vendors/Cost</h3>
		</div>
		
		<div class="text-right">
			<label class="col-form-label font-weight-normal">
				<input class="form-check-input" type="radio" name="vendor_estimation" id="vendor_estimation" value="1" <?php echo ((isset($shipInfo['vendor_estimation']) && $shipInfo['vendor_estimation'] == 1) ? 'checked' : ''); ?>> 
				Estimated
			</label>&nbsp;&nbsp;
			<label class="col-form-label font-weight-normal">
				<input class="form-check-input" type="radio" name="vendor_estimation" id="vendor_estimation" value="2"  <?php echo ((isset($shipInfo['vendor_estimation']) && $shipInfo['vendor_estimation'] == 2) ? 'checked' : ''); ?>>
				Finalized
			</label>&nbsp;&nbsp;
			<label class="col-form-label font-weight-normal">
				<input class="form-check-input" type="radio" name="vendor_estimation" id="vendor_estimation" value="3" <?php echo ((isset($shipInfo['vendor_estimation']) && $shipInfo['vendor_estimation'] == 3) ? 'checked' : ''); ?>>
				Both
			</label> 
		</div>
		
		<div class="form-group row">
			
			<div class="col-sm-4"  style="cursor:pointer;" >
				<a class="btn btn-info btn-sm" href="javascript:void(0);" data-toggle="modal" data-target="#myModal" onclick="loadVendorType();">Select a Vendor</a>
			</div> 
			<div class="col-sm-5">
				
			</div>
			<div class="col-sm-3 text-right">
				<select class="form-control" id="add_cost" name="add_cost">
					<option value="0">Add Cost</option>
				</select>
			</div>
		</div>
		
		<div class="form-group row perm_vendor_table">
			<?php
				$this->load->view('shipment/selectedvendors');
			?>
		</div>
				
		<div class="form-group row">
			
			<div class="col-sm-4">
				<h4 class="m-0 mt-3">Custom Charges</h4>
			</div>
			<div class="col-sm-8 text-right f14">
				<input class="form-check-input" type="checkbox" value="1" name="is_ready_invoicing" id="is_ready_invoicing" <?php echo ($shipInfo['is_ready_invoicing'] == 1) ? 'checked' : ''; ?>> Ready for Invoicing &nbsp;&nbsp;&nbsp;&nbsp;
				<input class="form-check-input" type="checkbox" value="1" name="is_invoice_printed" id="is_invoice_printed" <?php echo ($shipInfo['is_invoice_printed'] == 1) ? 'checked' : ''; ?>> Invoice Printed &nbsp;&nbsp;&nbsp;&nbsp;
				<input class="form-check-input" type="checkbox" value="1" name="is_finalize" id="is_finalize" <?php echo ($shipInfo['is_finalize'] == 1) ? 'checked' : ''; ?>> Finalize
				<input class="form-check-input" type="checkbox" value="<?php echo ($shipInfo['is_qp_upload'] == 2) ? 2 : 1; ?>" name="is_qp_upload" id="is_qp_upload" <?php echo ($shipInfo['is_qp_upload'] == 1 || $shipInfo['is_qp_upload'] == 2) ? 'checked' : ''; ?>> Move to QB
				<br/>
				<!--<a class="btn btn-info btn-sm" href="javascript:void(0);" data-toggle="modal" data-target="#myModal" onclick="loadChargeCode();">Add</a>  -->
				
				<a class="btn btn-info btn-sm" href="javascript:void(0);" onclick="cloneChargeCode();" style="float:right;">Add</a>
			</div>
			
		</div> 
			
		
		
		<div class="form-group row chargecode_div">
			<?php
				$this->load->view('shipment/selectedchargecodes');
			?>			
		</div>
	</div>
</div>