


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
                <div class="box-header">
                    <h3 class="box-title">Customer List</h3>
                    <div class="box-tools">
						<div class="input-group">
						  <input type="text" id="searchTextPop" name="searchTextPop" value="<?php echo (isset($postData['search']) ? $postData['search'] : ''); ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
						  <input type="hidden" value="<?php echo (isset($postData['is_shipper']) ? $postData['is_shipper'] : ''); ?>" id="is_shipper" name="is_shipper" >
						  <input type="hidden" value="<?php echo (isset($postData['is_bill_to']) ? $postData['is_bill_to'] : ''); ?>" id="is_bill_to" name="is_bill_to" >
						  <input type="hidden" value="<?php echo (isset($postData['is_consignee']) ? $postData['is_consignee'] : ''); ?>" id="is_consignee" name="is_consignee" >
						  <input type="hidden" value="<?php echo (isset($postData['is_sales']) ? $postData['is_sales'] : ''); ?>" id="is_sales" name="is_sales" >
						  <div class="input-group-btn">
							<button class="btn btn-sm btn-default searchListPopup" onclick="searchpopup()"><i class="fa fa-search"></i></button>
						  </div>
						</div>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding customer_div_ref">
					<?php
					$this->load->view('customers/customerAjax'); 
					?>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
		
		<script type="text/javascript">
			function sortCustomerTable(columnName){
				
				var sort = $("#c_sort").val();
				
				var arrayFromPHP = <?php echo json_encode($postData); ?>;
				arrayFromPHP.columnName=columnName;
				arrayFromPHP.sort=sort;
			
				
				 $.ajax({
				  url:'<?php echo base_url() .'ajaxCustomerData'; ?>',
				  type:'post',
				  data:arrayFromPHP,
				  success: function(response){
				 
				   $('.customer_div_ref').html(response);
				   if(sort == "asc"){
					 $("#c_sort").val("desc");
				   }else{
					 $("#c_sort").val("asc");
				   }
				 
				  }
				 });
			}
		</script>
      </div>
    </div>
  </div>

