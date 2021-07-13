
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" id="movableDialog">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

             <span aria-hidden="true">&times;</span>

        </button>
        <h4 class="modal-title"><?php echo $popup_title; ?></h4>
      </div>
      <div class="modal-body">
			<div class="row">
            <div class="col-xs-12">
              <div class="box">

                <div class="box-body table-responsive p-4">
					<table class="table table-hover">
						<tr>
							<th></th>
							<th>Instruction Type</th>
						</tr>
						<tr>
							<td><a href="javascript:void(0);" onclick="$('.special_instructions_div_org #aapickupbox').show();$('.submitbox').show();">Add</a></td>
							<td>Pick Instructions</td>
							
						</tr>
						<tr>
							<td><a href="javascript:void(0);" onclick="$('.special_instructions_div_org #aadeliveryinstructions').show();$('.submitbox').show();">Add</a></td>
							<td>Delivery Instructions</td>
							
						</tr>
						<tr>
							<td><a href="javascript:void(0);" onclick="$('.special_instructions_div_org #aaspecialinstructions').show();$('.submitbox').show();">Add</a></td>
							<td>Special Instructions</td>
							
						</tr>
						<tr>
							<td><a href="javascript:void(0);" onclick="$('.special_instructions_div_org #aaquotenotes').show();$('.submitbox').show();">Add</a></td>
							<td>Quote Notes</td>
							
						</tr>
						<tr>
							<td><a href="javascript:void(0);" onclick="$('.special_instructions_div_org #aainvoicenotes').show();$('.submitbox').show();">Add</a></td>
							<td>Invoice Notes</td>
							
						</tr>
						<tr>
							<td><a href="javascript:void(0);" onclick="$('.special_instructions_div_org #aatransferinstructions').show();$('.submitbox').show();">Add</a></td>
							<td>Transfer Instructions</td>
						</tr>
                  </table>	
				  <form role="form" id="savespecialInstructions" method="post" >
				  <div class="col-md-12 mt-2" id="">
						<div class="special_instructions_div_org">
							<div class="form-group row divbox" id="aapickupbox" style="display:none;">
								<label class="col-sm-3 col-form-label" for="">Pickup Instructions</label>
								<div class="col-sm-9">
									<textarea name="spdatas[sp_pickup_instructions]" id="sp_pickup_instructions" class="form-control" rows="2"></textarea>
								</div>
							</div>
							
							<div class="form-group row divbox" id="aadeliveryinstructions" style="display:none;">
								<label class="col-sm-3 col-form-label" for="">Delivery Instructions</label>
								<div class="col-sm-9">
									<textarea name="spdatas[sp_delivery_instructions]" id="sp_delivery_instructions" class="form-control" rows="2"></textarea>
								</div>
							</div>
							
							<div class="form-group row divbox" id="aaspecialinstructions" style="display:none;">
								<label class="col-sm-3 col-form-label" for="">Special Instructions</label>
								<div class="col-sm-9">
									<textarea name="spdatas[sp_special_instructions]" id="sp_special_instructions" class="form-control" rows="2"></textarea>
								</div>
							</div>
							
							<div class="form-group row divbox" id="aaquotenotes" style="display:none;">
								<label class="col-sm-3 col-form-label" for="">Quote Notes</label>
								<div class="col-sm-9">
									<textarea name="spdatas[sp_quote_notes]" id="sp_quote_notes" class="form-control" rows="2"></textarea>
								</div>
							</div>
							
							<div class="form-group row divbox" id="aainvoicenotes" style="display:none;">
								<label class="col-sm-3 col-form-label" for="">Invoice Notes</label>
								<div class="col-sm-9">
									<textarea name="spdatas[sp_invoice_notes]" id="sp_invoice_notes" class="form-control" rows="2"></textarea>
								</div>
							</div>
							
							<div class="form-group row divbox" id="aatransferinstructions" style="display:none;">
								<label class="col-sm-3 col-form-label" for="">Transfer Instructions</label>
								<div class="col-sm-9">
									<textarea name="spdatas[sp_transfer_instructions]" id="sp_transfer_instructions" class="form-control" rows="2"></textarea>
								</div>
							</div>
						</div>
							
						<div class="text-center mb-4 submitbox" style="display:none;">
							<center><div id="result_spl"></div></center>
							<div><input type="hidden" name="org_ship_id" id="org_ship_id" value="<?php echo $postData['sid'];?>"/></div>
							<a class="btn btn-info btn-sm mr-4" href="javascript:void(0);" onclick="copyspecialinstructions();">Submit</button>
							<a class="btn btn-danger btn-sm mr-4" href="javascript:void(0);" onclick="$('#myModal').modal('toggle');">Close</a>
						 </div>
					</div>
					</form>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
      </div>
    </div>
  </div>

  <script>
	$(document).ready(function(){
		var ichange = $('.special_instructions_content_div_changed').val();
		var bbhtml = $('.special_instructions_content_div').html();
		if(ichange == 1){
			$('.special_instructions_div_org').html(bbhtml);
			$('.submitbox').show();
		}
		$('.modal-content').draggable({
        	handle: ".modal-header"
        });
	});
	function copyspecialinstructions(){
		$('.special_instructions_div_org #sp_pickup_instructions').html($('.special_instructions_div_org #sp_pickup_instructions').val());
		
		$('.special_instructions_div_org #sp_delivery_instructions').html($('.special_instructions_div_org #sp_delivery_instructions').val());
		
		$('.special_instructions_div_org #sp_special_instructions').html($('.special_instructions_div_org #sp_special_instructions').val());
		
		$('.special_instructions_div_org #sp_quote_notes').html($('.special_instructions_div_org #sp_quote_notes').val());
		
		$('.special_instructions_div_org #sp_invoice_notes').html($('.special_instructions_div_org #sp_invoice_notes').val());
		
		$('.special_instructions_div_org #sp_transfer_instructions').html($('.special_instructions_div_org #sp_transfer_instructions').val());
		
		var ahtml = $('.special_instructions_div_org').html();
		
		var pins = $('.special_instructions_div_org #sp_pickup_instructions').val();
		var dins = $('.special_instructions_div_org #sp_delivery_instructions').val();
		var sins = $('.special_instructions_div_org #sp_special_instructions').val();
		var quins = $('.special_instructions_div_org #sp_quote_notes').val();
		var invins = $('.special_instructions_div_org #sp_invoice_notes').val();
		var tranins = $('.special_instructions_div_org #sp_transfer_instructions').val(); 
		
		if(pins != ''){$('#sp_p').prop('checked', true);}else{$('#sp_p').prop('checked', false);}
		if(dins != ''){$('#sp_d').prop('checked', true);}else{$('#sp_d').prop('checked', false);}
		if(sins != ''){$('#sp_s').prop('checked', true);}else{$('#sp_s').prop('checked', false);}
		if(quins != ''){$('#sp_q').prop('checked', true);}else{$('#sp_q').prop('checked', false);}
		if(invins != ''){$('#sp_i').prop('checked', true);}else{$('#sp_i').prop('checked', false);}
		if(tranins != ''){$('#sp_t').prop('checked', true);}else{$('#sp_t').prop('checked', false);} 
		
		$('.special_instructions_content_div').html(ahtml);
		$('.special_instructions_content_div_changed').val(1);
		
		
		var org_ship_id = $('#org_ship_id').val();
		if(org_ship_id != 0){
			dataString = $("#savespecialInstructions").serialize();
			$.ajax({
				type: "POST",
				url: baseURL+"savespecialInstructions",
				data: dataString,
				success: function(data){
					
					$("#result_spl").html(data.message); 
					
					if(data.status == 'error'){
						$("#result_spl").addClass("alert alert-danger");
					}else{
						$("#result_spl").addClass("alert alert-success");
					}
					if(data.status == 'success'){
						$('#myModal').modal('toggle');
					}
				}

			});
		}else{
			$('#myModal').modal('toggle');
		}
		
		
	}
  </script>
	<style>
	.modal-title {
		cursor: move;
	}
	</style>	