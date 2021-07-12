<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo 'bill_of_lading_'.$shipInfo['waybill'];?></title>
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

<style>
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
</head>
<body>
<!-- Container -->
<div class="container-fluid invoice-container" id="puchase_holder" style="color:#000;font-size:14pt"> 
  <!-- Header -->
  <header>
    <div class="row align-items-center">
      <div class="col-sm-7 text-left text-sm-left mb-3 mb-sm-0">
		<img id="logo" src="<?php echo base_url().'assets/images/logo_new.png';?>" title="Fastline Logistics" alt="Fastline Logistics" style="width:350px;"/>  
	  </div>
      <!--<div class="col-sm-5 text-center text-sm-right">
			<img id="logo" src="<?php //echo base_url().'assets/images/barcode_sample.jpg';?>" title="Fastline Logistics" alt="Fastline Logistics" style="width:150px;"/> 
      </div>-->
    </div>
    <hr>
  </header>
  
  <!-- Main Content -->
  <main>
    <div class="row">
     
      <div class="col-sm-6 order-sm-0"> 
        <address>
        P.O Box 266<br />
        Centerton, AR 72719, US<br />
        Phone:800-540-6100<br />
        Fax:479-888-5500<br />
        Email: ap@fastlinelogistics.com
        </address>
      </div>
	  <div class="col-sm-6 text-sm-right order-sm-1"> 
        <address>
		House Waybill<br />
        Shipper's Copy<br />
        <?php echo $shipInfo['waybill'];?><br />
        Date : 	<?php echo (isset($shipInfo['ready_date_time']) ? date("m/d/Y", strtotime($shipInfo['ready_date_time'])) : date("m/d/Y", strtotime($shipInfo['createdDtm']))); ?><br />
        <b>Org</b>: <?php echo (isset($shipInfo['origin_airport_code']) ? $shipInfo['origin_airport_code'] : '-');?> &nbsp; <b>Dest</b> : <?php echo (isset($shipInfo['dest_airport_code']) ? $shipInfo['dest_airport_code'] : '-');?>
        </address>
      </div>
	  
	  <div class="clear" style="clear:both;"></div>
    </div>
	
	<div class="row">
     
      <div class="col-sm-6 order-sm-0"> 
		<strong>Shipper</strong>
        <address>
        <?php echo $shipInfo['shipper_data']['shipper_name'];?><br />
        <?php echo $shipInfo['shipper_data']['s_address_1'];?><br />
		
		<?php echo (!empty($shipInfo['shipper_data']['s_address_2']) ? $shipInfo['shipper_data']['s_address_2'].'<br/>' : '');?>
		
		<?php echo $shipInfo['shipper_data']['s_city']. (isset($shipInfo['shipper_data']['state_name']) ? ', '.$shipInfo['shipper_data']['state_name']. ' '.$shipInfo['shipper_data']['s_zip'] : ''). (isset($shipInfo['shipper_data']['country_name']) ? ', '.$shipInfo['shipper_data']['country_name'] : '');?><br />
        </address>
      </div>
	  
	  <div class="col-sm-6 text-sm-right order-sm-1"> 
		<strong>Consignee</strong>
       <address>
        <?php echo $shipInfo['consignee_data']['c_shipper_name'];?><br />
        <?php echo $shipInfo['consignee_data']['c_address_1'];?><br />
		
		<?php echo (!empty($shipInfo['consignee_data']['c_address_2']) ? $shipInfo['consignee_data']['c_address_2'].'<br/>' : '');?>
		
		<?php echo $shipInfo['consignee_data']['c_city']. (isset($shipInfo['consignee_data']['state_name']) ? ', '.$shipInfo['consignee_data']['state_name']. ' '.$shipInfo['consignee_data']['c_zip'] : ''). (isset($shipInfo['consignee_data']['country_name']) ? ', '.$shipInfo['consignee_data']['country_name'] : '');?><br />
        </address>
      </div>
    </div>
	
	<div class="row">
     
      <div class="col-sm-5"> 
		<strong>Bill To</strong>
        <address>
        <?php echo $shipInfo['bill_to_data']['b_shipper_name'];?><br />
        <?php echo $shipInfo['bill_to_data']['b_address_1']. (isset($shipInfo['bill_to_data']['b_address_2']) ? ', '.$shipInfo['bill_to_data']['b_address_2'] : '');?><br />
		
		<?php echo $shipInfo['bill_to_data']['b_city']. (isset($shipInfo['bill_to_data']['state_name']) ? ', '.$shipInfo['bill_to_data']['state_name']. ' '.$shipInfo['bill_to_data']['b_zip'] : ''). (isset($shipInfo['bill_to_data']['country_name']) ? ', '.$shipInfo['bill_to_data']['country_name'] : '');?><br />
        </address>
      </div>
	  
		<?php if($shipInfo['bill_to_data']['b_default_ref']){ ?>
			<div class="col-sm-7">
				<div class="row">
				  <div class="col-sm-12"> 
					<strong>Bill To Ref:</strong>
					<?php 
						echo $shipInfo['bill_to_data']['b_default_ref']. (isset($shipInfo['bill_to_data']['ref_name']) ? ' - '.$shipInfo['bill_to_data']['ref_name'] : '');
					?>
					<br/>
				  </div>
				</div>
		    </div>
		<?php }	?>
    </div>
	
	<div class="row">
	
     <div class="col-sm-4 mb-3 mb-sm-0"> 
		<span class="text-black text-uppercase">Payment Terms:</span><br>
        <span class="font-weight-500 textt-2"><?php 
		if($shipInfo['bill_to'] == 1){
			echo "Prepaid";
		}elseif($shipInfo['bill_to'] == 2){
			echo "Collect";
		}elseif($shipInfo['bill_to'] == 3){
			echo "3rd Party";
		}
		echo (isset($shipInfo['bill_to_data']['customer_data']['payment_term_name']) ? ' ('.$shipInfo['bill_to_data']['customer_data']['payment_term_name'].')' : '');?></span> 
	 </div>
	 
     <div class="col-sm-4 mb-3 mb-sm-0"> 
		<span class="text-black text-uppercase">Service Level:</span><br>
        <span class="font-weight-500 textt-2"><?php echo (isset($shipInfo['service_name']) ? $shipInfo['service_name'].' ('.$shipInfo['service_short_code'].')' : '-');?></span> 
	 </div>
	 
	 <!--str_replace(':00', '',date("D, F j,Y g:ia", strtotime($shipInfo['ready_date_time'])))-->
     <div class="col-sm-4 mb-3 mb-sm-0"> 
		<span class="text-black text-uppercase">Pickup By</span><br>
        <span class="font-weight-500 textt-2"><?php echo (isset($shipInfo['ready_date_time']) ? date("D, F j,Y g:ia", strtotime($shipInfo['ready_date_time'])) : ''); ?><?php echo (isset($shipInfo['close_date_time']) ? date(" - g:ia", strtotime($shipInfo['close_date_time'])) : ''); ?></span> 
	  </div>
	  
	  <div class="col-sm-4 mb-3 mb-sm-0"> 
		<span class="text-black text-uppercase">Declared Value</span><br>
        <span class="font-weight-500 textt-2"><?php echo (isset($shipInfo['insured_value']) ? $shipInfo['insured_value'] : '-'); ?></span> 
	  </div>
	  
	  <div class="col-sm-4 mb-3 mb-sm-0"> 
		<span class="text-black text-uppercase">Delivery On</span><br>
        <span class="font-weight-500 textt-2"><?php echo (isset($shipInfo['schedule_date_time']) ? date("D, F j,Y g:ia", strtotime($shipInfo['schedule_date_time'])) : ''); ?></span> 
	  </div>
	  
	  <div class="col-sm-12 mb-3 mb-sm-0"> 
		<span class="text-black text-uppercase">Shipper's Instruction</span><br>
        <span class="font-weight-500 textt-2"><?php echo (isset($shipInfo['bill_to_data']['customer_data']['pickup_instructions']) ? $shipInfo['bill_to_data']['customer_data']['pickup_instructions'] : '-');?></span> 
	  </div>
	  
    </div>
	

    <div class="card">
      <div class="card-header px-3"> <span class="font-weight-600 text-2">Freight Information</span> </div>
	  
	  <div class="clear" style="clear:both;"></div>
	  
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table mb-0 text-black">
            <thead>
              <tr>
                <td class="text-center"><strong>Pieces</strong></td>
                <td class="text-center "><strong>PKG Type</strong></td>
                <td class="text-center "><strong>H/M</strong></td>
                <td class="text-center "><strong>Description</strong></td>
                <td class="text-center "><strong>Length</strong></td>
                <td class="text-center "><strong>Width</strong></td>
                <td class="text-center "><strong>Height</strong></td>
                <td class="text-center "><strong>Weight(Lb)</strong></td>
              </tr>
            </thead>
            <tbody>
			  <?php 
					if(!empty($shipInfo['freight_datas'])){
					foreach($shipInfo['freight_datas'] as $freightdata){
				?>
				<tr>
					<td class="text-center">
						<?php echo isset($freightdata->pieces) ? $freightdata->pieces : ''; ?>
					</td>
					<td class="text-center">
						<?php
						if(!empty($types))
						{
							foreach ($types as $type)
							{
								if($type['type_id'] == (isset($freightdata->types) ? $freightdata->types : '')){
									echo $type['type_name'];
								} 
							}
						}
						?>
					</td>
					
					<td class="text-center">
						<input class="form-check-input" type="checkbox" value="1" id="haz" <?php echo (isset($freightdata->haz) && $freightdata->haz == 1) ? 'checked' : ''; ?>>
					</td> 
					
					<td class="text-center">
						<?php echo isset($freightdata->description) ?$freightdata->description : ''; ?>
					</td>

					<td class="text-center">
						<?php echo isset($freightdata->length) ? $freightdata->length : ''; ?>
					</td>
					
					<td class="text-center">
						<?php echo isset($freightdata->width) ?$freightdata->width : ''; ?>
					</td>
					
					<td class="text-center">
						<?php echo isset($freightdata->height) ? $freightdata->height : ''; ?>
					</td>
					
					<td class="text-center">
						<?php echo isset($freightdata->weight) ? $freightdata->weight : ''; ?>
					</td>
										
				</tr>
				<?php 
					}
					}
				?>
              
            </tbody>
			<tfoot class="card-footer">
			  <tr>
                <td colspan="7" class="text-right"><strong>Total Pieces</strong></td>
                <td colspan="7" class="text-right"><?php echo $shipInfo['total_pieces'];?></td>
              </tr>
              <tr>
                <td colspan="7" class="text-right"><strong>Total Actual Weight</strong></td>
                <td colspan="7" class="text-right"><?php echo $shipInfo['total_actual_weight'];?></td>
              </tr>
			</tfoot>
          </table>
        </div>
      </div>
    </div>
    
  </main>

  <footer class="text-right">
    <hr>
		<p>
			<strong>Fastline Logistics - Voice: 800-540-6100. &nbsp;&nbsp;&nbsp; Fax: 479-888-5500</strong><br>
			P.O. Box 266 Centerton, AR 72719, US &nbsp;&nbsp;&nbsp; <br>
		</p>
    <hr>
  </footer>
  
  <div class="btn-group-sm d-print-none text-center avoid-normal-print"> 
		<a href="javascript:void(0);" class="btn btn-light border text-black shadow-none print_button"><i class="fa fa-print"></i> Print</a> 
  </div>
</div>

</body>
</html>