
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
                    <h3 class="box-title">Vendor List</h3>
                    <div class="box-tools">
						<div class="input-group">
						  <input type="text" id="searchTextPop" name="searchTextPop" value="<?php echo (isset($postData['search']) ? $postData['search'] : ''); ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
						  <div class="input-group-btn">
							<button class="btn btn-sm btn-default searchListPopup" onclick="loadVendors('<?php echo $postData['mainid'];?>', '<?php echo $postData['subid']; ?>', 'search', '<?php echo $postData['parentid'];?>')"><i class="fa fa-search"></i></button> 
						  </div>
						</div>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding vendor_div_ref">
					<?php
					$this->load->view('shipment/vendorAjax'); 
					?>
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
		
		<script type="text/javascript">
			function sortVendorTable(columnName){
				
				var sort = $("#v_sort").val();
				
				var arrayFromPHP = <?php echo json_encode($postData); ?>;
				arrayFromPHP.columnName=columnName;
				arrayFromPHP.sort=sort;
			
				
				 $.ajax({
				  url:'<?php echo base_url() .'ajaxVendorData'; ?>',
				  type:'post',
				  data:arrayFromPHP,
				  success: function(response){
				 
				   $('.vendor_div_ref').html(response);
				   if(sort == "asc"){
					 $("#v_sort").val("desc");
				   }else{
					 $("#v_sort").val("asc");
				   }
				 
				  }
				 });
			}
		</script>
		
      </div>
    </div>
  </div>

