


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
				<div class="box-header text-center bg-info">
                    <h3 class="box-title ">Clone Shipment Options</h3>
                </div>
                <div class="box-body table-responsive p-4">
					<div class="form-group">
						<label class="col-form-label" for="show_name">Please select all option you want to clone</label>
						<div class="">
							<input class="form-check-input" type="checkbox" value="1" name="val[check_all]" id="check_all"> Check All
						</div>
					</div>	
					
					<div class="form-group">
						<input class="form-check-input" type="checkbox" value="1" name="val[vendor_only]" id="vendor_only"> Vendor Only <br/>
						
						<input class="form-check-input" type="checkbox" value="1" name="val[vendor_and_cost]" id="vendor_and_cost"> Vendor and Cost <br/>
						
						<input class="form-check-input" type="checkbox" value="1" name="val[revenue]" id="revenue"> Revenue<br/>
						
						<input class="form-check-input" type="checkbox" value="1" name="val[spl_intructions]" id="spl_intructions"> Special Instructions<br/>
						
						<input class="form-check-input" type="checkbox" value="1" name="val[quotes_notes]" id="quotes_notes"> Quotes Notes<br/>
						
						<input class="form-check-input" type="checkbox" value="1" name="val[trace_notes]" id="trace_notes"> Trace Notes<br/>
						
						<input class="form-check-input" type="checkbox" value="1" name="val[reference_no]" id="reference_no"> Reference No<br/>
						
						<input class="form-check-input" type="checkbox" value="1" name="val[ready_data_time]" id="ready_data_time"> Ready Date/Time<br/>
						
						<input class="form-check-input" type="checkbox" value="1" name="val[schedule_delivery_date]" id="schedule_delivery_date"> Scheduled Delivery Date/Time<br/>
						
						<input class="form-check-input" type="checkbox" value="1" name="val[uploaded_documents]" id="uploaded_documents"> Uploaded Documents<br/>
					</div>
					
					<div class="form-group">
						<input class="form-check-input" type="checkbox" value="1" name="val[call_in]" id="call_in"> Call In
					</div>	
					
					<div class="form-group">
						<input class="form-check-input" type="checkbox" value="1" name="val[return_shipment]" id="return_shipment"> Create as Return Shipment
					</div>	
					
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
      </div>
    </div>
  </div>

