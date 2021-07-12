<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo 'bol_label_'.$shipInfo['waybill'];?></title>
<meta name="author" content="">   

<!-- Web Fonts
======================= -->
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900' type='text/css'>

<!-- Stylesheet
======================= -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/dist/css/pdf/bootstrap.min.css'; ?>"/>

<link href="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery-ui.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
 
<!--<link rel="stylesheet" type="text/css" href="<?php //echo base_url().'assets/dist/css/pdf/all.min.css'; ?>"/>-->

<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/dist/css/pdf/stylesheet.css';?>"/>

<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery-ui.js"></script>
	
<script src='<?php echo base_url().'assets/dist/js/pdf/jQuery.print.js';?>'></script>
<script type="text/javascript">
  $(document).ready(function(){
		jQuery(function($) { 'use strict';
            
            $("#puchase_holder").find('.print_button').on('click', function() {
                //Print ele4 with custom options
                $("#puchase_holder").print({
                    //Use Global styles
                    globalStyles : true,
                    //Add link with attrbute media=print
                    mediaPrint : true,
                    //Custom stylesheet
                    stylesheet : "<?php echo base_url().'assets/dist/css/pdf/stylesheet.css';?>",
                    //Print in a hidden iframe
                    iframe : false,
                    //Don't print this
                    noPrintSelector : ".avoid-normal-print",
                    //Add this at top
                    prepend : "",
                    //Add this on bottom
                    append : "",
                    //Log to console when printing is done via a deffered callback
                    deferred: $.Deferred().done(function() { 
						console.log('Printing done', arguments); 
						
					})
                });
            });
            // Fork https://github.com/sathvikp/jQuery.print for the full list of options
			
        });
				
	});
</script>
<style>
.invoice-container {
	max-width: 11cm !important;
}
@media print {
	.invoice-container {
		width: 11cm !important;
	}
} 
@media print {
    @page {
        margin-top: 0;
        margin-bottom: 0;
    }
    body {
        padding-top: 72px;
        padding-bottom: 72px ;
    }
}
</style>
</head>
<!--style="width:10cm;height:15cm;margin:0 auto;"-->
<body>
<!-- Container -->

<div class="container-fluid invoice-container pt-4" id="puchase_holder" style="color:#000;font-size:14pt"> 
 
<?php 
	$totalpieces = $shipInfo['total_pieces'];
	if($totalpieces > 100){$totalpieces = 100;}
	for($inc=1;$inc<=$totalpieces;$inc++){
?>
  <!-- Header -->
  <div class="bollabeldiv" <?php echo (($totalpieces > 1 && $totalpieces != $inc) ? 'style="page-break-after: always;padding-top: 72px;"' : 'style="padding-top: 72px;"');?>>
  <header>
    <div class="row align-items-center">
     
	  <div class="col-sm-12 text-center text-6">
		Fastline Logistics
	  </div>
    </div>
	<div class="row">
		  <div class="col-sm-6 mb-sm-0"> 
			<span class="text-black">Phone #: 800-540-6100</span>
		  </div>
		  <div class="col-sm-6 mb-sm-0 text-right"> 
			<span class="text-black">Fax #: 479-888-5500</span><br>
		  </div>
      </div>
  </header>
  
  <!-- Main Content -->
  <main>
    
	<div class="row">
		<table class="table mb-0  text-black">
            <thead>
              <tr>
                <td class="col-2 text-left text-uppercase"><strong>HAWB</strong></td>
                <td class="col-2 text-center text-uppercase"><strong>Weight</strong></td>
                <td class="col-3 text-right text-uppercase"><strong>Pieces</strong></td>
              </tr>
            </thead>
            <tbody>
				<tr>
					<td class="text-left">
						<?php echo $shipInfo['station'].' '.$shipInfo['waybill'];?>
					</td>
					<td class="text-center">
						<?php echo $shipInfo['total_actual_weight'];?>
					</td>

					
					<td class="text-right">
						<?php 
							echo $shipInfo['total_pieces'];
							if($totalpieces > 1){
								echo '<br/><small>'.$inc.' of '.$shipInfo['total_pieces'].'</small>';
							}
						?>
					</td>
				</tr>
				<tr>
					<td class="text-left">
						Destination
					</td>
					<td colspan="2" class="text-left text-8">
						<?php echo (isset($shipInfo['dest_airport_code']) ? $shipInfo['dest_airport_code'] : '-');?>
					</td>
				</tr>
            </tbody>
          </table>
    </div>
	
	

	<div class="row">
     
      <div class="col-sm-12 order-sm-0"> 
		<strong>Ship From</strong>
		<hr class="my-3">
        <address>
			<?php echo $shipInfo['shipper_data']['shipper_name'];?><br />
			<?php echo $shipInfo['shipper_data']['s_address_1'];?><br />
			
			<?php echo (!empty($shipInfo['shipper_data']['s_address_2']) ? $shipInfo['shipper_data']['s_address_2'].'<br/>' : '');?>
			
			<?php echo $shipInfo['shipper_data']['s_city']. (isset($shipInfo['shipper_data']['state_name']) ? ', '.$shipInfo['shipper_data']['state_name']. ' '.$shipInfo['shipper_data']['s_zip'] : ''). (isset($shipInfo['shipper_data']['country_name']) ? ', '.$shipInfo['shipper_data']['country_name'] : '');?><br />
			<?php echo (!empty($shipInfo['shipper_data']['show_name']) ? 'Show: '.$shipInfo['shipper_data']['show_name'].'<br/>' : '');?>
			<?php echo (!empty($shipInfo['shipper_data']['exhibitor_name']) ? 'Exhibitor: '.$shipInfo['shipper_data']['exhibitor_name'].'<br/>' : '');?>
			<?php echo (!empty($shipInfo['shipper_data']['booth_name']) ? 'Booth: '.$shipInfo['shipper_data']['booth_name'].'<br/>' : '');?><br/>
			<?php echo (!empty($shipInfo['shipper_data']['decorator_name']) ? $shipInfo['shipper_data']['decorator_name'].'<br/>' : '');?>
			<br/></br>
			<?php if($shipInfo['shipper_data']['s_default_ref']){ ?>
				Ref #: <?php echo $shipInfo['shipper_data']['s_default_ref']. (isset($shipInfo['shipper_data']['ref_name']) ? ' - '.$shipInfo['shipper_data']['ref_name'] : '');?>
			<?php } ?>
        </address>
      </div>
	  
    </div>
	
	<div class="row">
     
      <div class="col-sm-12 order-sm-0"> 
		<strong>Ship To</strong>
		<hr class="my-3">
        <address>
			<?php echo $shipInfo['consignee_data']['c_shipper_name'];?><br />
			<?php echo $shipInfo['consignee_data']['c_address_1'];?><br />
			
			<?php echo (!empty($shipInfo['consignee_data']['c_address_2']) ? $shipInfo['consignee_data']['c_address_2'].'<br/>' : '');?>
			
			<?php echo $shipInfo['consignee_data']['c_city']. (isset($shipInfo['consignee_data']['state_name']) ? ', '.$shipInfo['consignee_data']['state_name']. ' '.$shipInfo['consignee_data']['c_zip'] : ''). (isset($shipInfo['consignee_data']['country_name']) ? ', '.$shipInfo['consignee_data']['country_name'] : '');?><br />
			
			<?php echo (!empty($shipInfo['consignee_data']['show_name']) ? 'Show: '.$shipInfo['consignee_data']['show_name'].'<br/>' : '');?>
			<?php echo (!empty($shipInfo['consignee_data']['exhibitor_name']) ? 'Exhibitor: '.$shipInfo['consignee_data']['exhibitor_name'].'<br/>' : '');?>
			<?php echo (!empty($shipInfo['consignee_data']['booth_name']) ? 'Booth: '.$shipInfo['consignee_data']['booth_name'].'<br/>' : '');?><br/>
			<?php echo (!empty($shipInfo['consignee_data']['decorator_name']) ? $shipInfo['consignee_data']['decorator_name'].'<br/>' : '');?>
			<br/></br> 
			<?php if($shipInfo['consignee_data']['c_default_ref']){ ?>
				Ref #: <?php echo $shipInfo['consignee_data']['c_default_ref']. (isset($shipInfo['consignee_data']['ref_name']) ? ' - '.$shipInfo['consignee_data']['ref_name'] : '');?>
			<?php } ?>
        </address>
      </div>
	  
    </div>

	<div class="row pb-2">
      <div class="col-sm-12 text-center text-6"> 
		<?php echo $shipInfo['station'].' '.$shipInfo['waybill'];?>
	  </div>
    </div>
	
  </main>
  </div>
  <?php } ?>
  <div class="btn-group-sm d-print-none text-center avoid-normal-print mt-4"> 
		<a href="javascript:void(0);" class="btn btn-light border text-black-50 shadow-none print_button"><i class="fa fa-print"></i> Print</a> 
  </div>
  
</div>


</body>
</html>