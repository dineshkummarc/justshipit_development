
	<div class="modal fade displaycontentpopup" id="myModal"></div> 
	
	<div class="modal fade displaycontentpopup_overlap" id="myModaloverlap"></div>
	
	<div class="modal fade displaycontentpopup_overlap2" id="myModaloverlap2"></div> 
	
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>JustShipIt</b> Admin System | Version 1.5
        </div>
        <strong>Copyright &copy; <?php echo date('Y');?> <a href="<?php echo base_url(); ?>">JustShipIt</a>.</strong> All rights reserved.
    </footer>
    
    <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/jquery-input-mask-phone-number.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/popper.min.js" type="text/javascript"></script>
    <!-- <script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard.js" type="text/javascript"></script> -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/validation.js" type="text/javascript"></script>
    <script type="text/javascript">
        var windowURL = window.location.href;
        pageURL = windowURL.substring(0, windowURL.lastIndexOf('/'));
        var x= $('a[href="'+pageURL+'"]');
            x.addClass('active');
            x.parent().addClass('active');
        var y= $('a[href="'+windowURL+'"]');
            y.addClass('active');
            y.parent().addClass('active');
		$(document).ready(function(){	
			$('.us_phone_num_design').usPhoneFormat({
				format: 'x-xxx-xxx-xxxx',
			});
 			
			$('[data-toggle="tooltip"]').tooltip(); 
			
			$(document).on("focusout",".zip_en_data",function(ev, key){
				var zipcode  = $(this).val();
				var regex = new RegExp(/(^\d{5}(-\d{4})?$)|(^[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} *\d{1}[A-Z]{1}\d{1}$)/);
				if(!regex.test(zipcode)) {
					alert('	please enter valid zip code');
					$(this).val('');
				}
			});
			
		});
    </script>
  </body>
</html>