<!DOCTYPE html>
<html lang="en"> 
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo 'invoice_'.$shipInfo['waybill'];?></title>
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
        padding-top: 18px;
        padding-bottom: 18px ;
    }
}
address{
	margin-bottom:0.5rem;
}
.table td, .table th{
	padding:.25rem;
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
<div class="container-fluid invoice-container" id="puchase_holder" style="color:#000;font-size:12pt"> 
  <!-- Header -->
  <header>
    <div class="row align-items-center">
	  <div class="col-sm-3 text-left text-sm-left mb-3 mb-sm-0">
		<i class="text-8">INVOICE</i>
	  </div>
      <div class="col-sm-4 text-right mb-3 mb-sm-0">
		Invoice#:  <?php echo $shipInfo['station'].' '.$shipInfo['waybill'];?>
	  </div>
      <div class="col-sm-5 text-center text-sm-right">
		<img id="logo" src="<?php echo base_url().'assets/images/logo_new.png';?>" title="Fastline Logistics" alt="Fastline Logistics" style="width:350px;"/> 
      </div>
    </div>
  </header>
  
  <!-- Main Content -->
  <main>
    <div class="row">
     
      <div class="col-sm-12 order-sm-0"> 
        <address>
		<b>Fastline Logistics</b><br />
        P.O Box 266<br />
        Centerton, AR 72719, US<br />
        Phone:800-540-6100 &nbsp;&nbsp;  Fax:479-888-5500<br />
        </address>
      </div>

	  <div class="clear" style="clear:both;"></div>
    </div>
	
	<div class="dom_border" style="border:1px solid #000;padding:5px;">
		<div class="row border_bottom_2x m-0">
		  <div class="col-sm-2 mb-3 mb-sm-0"> 
			<span class="text-black"><b>Shipped</b></span><br>
			<span class="font-weight-500 text-3"><?php echo (isset($shipInfo['schedule_date_time']) ? date("m/d/Y", strtotime($shipInfo['schedule_date_time'])) : ''); ?></span> 
		  </div>
		  <div class="col-sm-3 mb-3 mb-sm-0"> 
			<span class="text-black"><b>Type of Service</b></span><br>
			<span class="font-weight-500 text-3"><?php echo (isset($shipInfo['service_name']) ? $shipInfo['service_name'].' Service' : '-');?></span> 
		  </div>
		  <div class="col-sm-3"> 
			<span class="text-black"><b>Payment Term</b></span><br>
			<span class="font-weight-500 text-3"><?php 
			if($shipInfo['bill_to'] == 1){
				echo "Prepaid";
			}elseif($shipInfo['bill_to'] == 2){
				echo "Collect";
			}elseif($shipInfo['bill_to'] == 3){
				echo "3rd Party";
			}
			echo (isset($shipInfo['bill_to_data']['customer_data']['payment_term_name']) ? ' ('.$shipInfo['bill_to_data']['customer_data']['payment_term_name'].')' : '(15 Days)');?></span> 
		  </div>
		  
		  <div class="col-sm-2 mb-3 mb-sm-0"> 
			<span class="text-black"><b>Invoice Date</b></span><br>
			<span class="font-weight-500 text-3">
			<?php 
				$invdate = date("m/d/Y", strtotime($shipInfo['createdDtm']));
				if(isset($shipInfo['ready_date_time']) && !empty($shipInfo['ready_date_time'])){
					$invdate = date("m/d/Y", strtotime($shipInfo['ready_date_time']));
				}
				echo $invdate; 
			?></span> 
		  </div>
		  <div class="col-sm-2 mb-3 mb-sm-0"> 
			<span class="text-black"><b>Due Date</b></span><br>
			<span class="font-weight-500 text-3">
			<?php 
				$payday = 15;
				if(isset($shipInfo['payment_term_days']) && !empty($shipInfo['payment_term_days'])){
					$payday = $shipInfo['payment_term_days'];
				}
				echo date('m/d/Y', strtotime($invdate. ' + '.$payday.' days'));; 
			?></span> 
		  </div>
		</div>
	
		<div class="row border_bottom_2x m-0 pt-2 pb-0">
		 
		  <div class="col-sm-6"> 
				<strong>Bill To</strong>
				<address>
					<?php echo $shipInfo['bill_to_data']['b_shipper_name'];?><br />
					<?php echo $shipInfo['bill_to_data']['b_address_1']. (isset($shipInfo['bill_to_data']['b_address_2']) ? ', '.$shipInfo['bill_to_data']['b_address_2'] : '');?><br />
					
					<?php echo $shipInfo['bill_to_data']['b_city']. (isset($shipInfo['bill_to_data']['state_name']) ? ', '.$shipInfo['bill_to_data']['state_name']. ' '.$shipInfo['bill_to_data']['b_zip'] : ''). (isset($shipInfo['bill_to_data']['country_name']) ? ', '.$shipInfo['bill_to_data']['country_name'] : '');?>
				</address>
				
				<?php
				if($shipInfo['bill_to_data']['b_default_ref']){
					echo '<br />Reference:' . $shipInfo['bill_to_data']['b_default_ref']. (!empty($shipInfo['bill_to_data']['ref_name']) ? ' - '.$shipInfo['bill_to_data']['ref_name'] : '');
				}?>
		  </div>
		  
		  <div class="col-sm-6">
			
		  </div>
		  
		</div>
		
		<div class="row m-0 border_bottom_2x">
     
			  <div class="col-sm-6 order-sm-0 border_right_2x"> 
				<strong>Shipped From</strong>
				<address>
				
				<?php echo $shipInfo['shipper_data']['shipper_name'];?><br />
				<?php echo $shipInfo['shipper_data']['s_address_1'];?><br />
				
				<?php echo (!empty($shipInfo['shipper_data']['s_address_2']) ? $shipInfo['shipper_data']['s_address_2'].'<br/>' : '');?>
				
				<?php echo $shipInfo['shipper_data']['s_city']. (isset($shipInfo['shipper_data']['state_name']) ? ', '.$shipInfo['shipper_data']['state_name']. ' '.$shipInfo['shipper_data']['s_zip'] : ''). (isset($shipInfo['shipper_data']['country_name']) ? ', '.$shipInfo['shipper_data']['country_name'] : '');?><br />
				
				<?php echo (!empty($shipInfo['shipper_data']['show_name']) ? $shipInfo['shipper_data']['show_name'].'<br/>' : ''); ?>
				<?php echo (!empty($shipInfo['shipper_data']['exhibitor_name']) ? $shipInfo['shipper_data']['exhibitor_name'].'<br/>' : ''); ?>
				<?php echo (!empty($shipInfo['shipper_data']['booth_name']) ? 'Booth #'.$shipInfo['shipper_data']['booth_name'].'<br/>' : ''); ?>
				<?php echo (!empty($shipInfo['shipper_data']['decorator_name']) ? $shipInfo['shipper_data']['decorator_name'].'<br/>' : ''); ?>
				
				
				Contact: <?php echo (!empty($shipInfo['shipper_data']['s_contact']) ? $shipInfo['shipper_data']['s_contact'] : '-');?></br>
				<?php echo (!empty($shipInfo['shipper_data']['s_phone']) ? 'Phone #: '.$shipInfo['shipper_data']['s_phone'].'<br/>' : '');?>
				
				<?php
				if($shipInfo['shipper_data']['s_default_ref']){
					echo '<br/>Reference:' . $shipInfo['shipper_data']['s_default_ref']. (!empty($shipInfo['shipper_data']['ref_name']) ? ' - '.$shipInfo['shipper_data']['ref_name'] : '');
				}?>
				
				</address>
			  </div>
			  
			  <div class="col-sm-6 order-sm-1"> 
				<strong>Shipped To:</strong>
			   <address>
				
				<?php echo $shipInfo['consignee_data']['c_shipper_name'];?><br/>
				<?php echo $shipInfo['consignee_data']['c_address_1'];?><br/>
				
				<?php echo (!empty($shipInfo['consignee_data']['c_address_2']) ? $shipInfo['consignee_data']['c_address_2'].'<br/>' : '');?>
				
				<?php echo $shipInfo['consignee_data']['c_city']. (isset($shipInfo['consignee_data']['state_name']) ? ', '.$shipInfo['consignee_data']['state_name']. ' '.$shipInfo['consignee_data']['c_zip'] : ''). (isset($shipInfo['consignee_data']['country_name']) ? ', '.$shipInfo['consignee_data']['country_name'] : '');?><br />
				
				<?php echo (!empty($shipInfo['consignee_data']['show_name']) ? $shipInfo['consignee_data']['show_name'].'<br/>' : ''); ?>
				<?php echo (!empty($shipInfo['consignee_data']['exhibitor_name']) ? $shipInfo['consignee_data']['exhibitor_name'].'<br/>' : ''); ?>
				<?php echo (!empty($shipInfo['consignee_data']['booth_name']) ? 'Booth #'.$shipInfo['consignee_data']['booth_name'].'<br/>' : ''); ?>
				<?php echo (!empty($shipInfo['consignee_data']['decorator_name']) ? $shipInfo['consignee_data']['decorator_name'].'<br/>' : ''); ?>
				
				Contact: <?php echo (!empty($shipInfo['consignee_data']['c_contact']) ? $shipInfo['consignee_data']['c_contact'] : '-');?></br>
				
				<?php echo (!empty($shipInfo['consignee_data']['c_phone']) ? 'Phone #: '.$shipInfo['consignee_data']['c_phone'].'<br/>' : '');?>
				
				
				<?php
				if($shipInfo['consignee_data']['c_default_ref']){
					echo '<br/>Reference:' . $shipInfo['consignee_data']['c_default_ref']. (!empty($shipInfo['consignee_data']['ref_name']) ? ' - '.$shipInfo['consignee_data']['ref_name'] : '');
				}?>
				
				</address>
			  </div>
			</div>		
		
		
		<div class="row border_bottom_2x m-0">
				  
		  <div class="col-sm-12 mb-3 mb-sm-0"> 
			<span class="text-black">Proof of Delivery -</span><br>
			<?php echo isset($shipInfo['pod_name']) ? $shipInfo['pod_name'] : '';?>
			<?php echo (isset($shipInfo['pod_date']) ? ' '.date("m/d/Y", strtotime($shipInfo['pod_date'])) : '');?>
			<?php echo (isset($shipInfo['pod_time']) ? ' '.date("g:ia", strtotime($shipInfo['pod_time'])) : '');?>
			
		  </div>
		  
		  <div class="table-responsive">
			  <table class="table mb-0 text-black">
				<thead>
				  <tr>
					<!--<td class="text-center"><strong>Pieces</strong></td>
					<td class="text-center "><strong>Type</strong></td>-->
					<td class="text-left "><strong>Description</strong></td>
					<td class="text-right "><strong>Chargeable Wgt.</strong></td>
					<td class="text-center "><strong>Lbs or Kgs</strong></td>
					<td class="text-right "><strong>Rate</strong></td>
					<td class="text-right "><strong>Amount</strong></td>
				  </tr>
				</thead>
				<tbody>
				  <?php 
						$totalchargecost = $totalchargeqty = 0;
						if(!empty($aChargeRecords)){
						/* foreach($aChargeRecords as $aChargeRecord){
							$totalchargeqty = $totalchargeqty + $aChargeRecord->charge_code_qty;
						} */
						foreach($aChargeRecords as $okey => $aChargeRecord){
					?>
					<tr>
						
												
						<td class="text-left">
							<?php echo $aChargeRecord->charge_code_description;?>
						</td>
						
						<td class="text-right">
							<?php echo $aChargeRecord->charge_code_charge;?>
						</td>
						
						<td class="text-center">
							<?php
							if(!empty($rate_basis))
							{
								foreach ($rate_basis as $rate)
								{
									if($rate['rate_basis_id'] == (isset($aChargeRecord->charge_code_rate_basis) ? $aChargeRecord->charge_code_rate_basis : '')){
										echo $rate['rate_short_code'];
									} 
								}
							}
							?>
						</td>

						<td class="text-right">
							<?php echo $aChargeRecord->charge_code_rate;?>
						</td>
						
						<td class="text-right">
							<?php echo $aChargeRecord->charge_code_total_cost;?>
						</td>					
					</tr>
					<?php 
							$totalchargecost = $totalchargecost + $aChargeRecord->charge_code_total_cost;
						}
						}else{
							echo '<tr ><td colspan="7">No Data Found</td><tr>';
						}
					?>
					
				</tbody>
				
			  </table>
						  
			</div>
		  
			<div class="col-sm-12 pt-2 border_top_2x"> 
				<span class="text-black">Invoice Notes</span><br>
					
				<?php 
					if(isset($shipInfo['sp_ins_datas']['sp_invoice_notes']) && !empty($shipInfo['sp_ins_datas']['sp_invoice_notes'])){
						echo $shipInfo['sp_ins_datas']['sp_invoice_notes'];
					}
				?>
			 </div>
		</div>
		

		<div class="card">
		  		  
		  <div class="card-body p-0">
			<div class="table-responsive">
			  <table class="table mb-0 text-black">
				<thead>
				  <tr>
					<td class="text-left" colspan="3"><strong>Total Dim. Weight : <?php echo $shipInfo['total_chargeable_weight'];?></strong></td>
					
					<td class="text-left " colspan="4" style="vertical-align:bottom;"><strong>Total Actual Weight:<?php echo $shipInfo['total_actual_weight'];?></strong></td>
	
					<td class="text-right" colspan="2" style="vertical-align:bottom;"><strong>Payable in USD</strong></td>
				  </tr>
				</thead>
				<thead>
				  <tr>
					<td class="text-left"><strong>Pieces</strong></td>
					<td class="text-left "><strong>Length</strong></td>
					<td class="text-left "><strong>Width</strong></td>
					<td class="text-left "style="border-right:1px solid #000;"><strong>Height</strong></td>
					<td class="text-left"><strong>Pieces</strong></td>
					<td class="text-left "><strong>Length</strong></td>
					<td class="text-left "><strong>Width</strong></td>
					<td class="text-left "style="border-right:1px solid #000;"><strong>Height</strong></td>
					<td class="text-left "><strong>Total Charges</strong></td> 
				  </tr>
				</thead>
				<tbody>
				  <?php 
						if(!empty($shipInfo['freight_datas'])){
						
							foreach (array_chunk($shipInfo['freight_datas'], 2) as $key  => $row) {
								
								echo '<tr>';
								foreach($row as $freightdata){

									  echo '<td class="text-left">'.(isset($freightdata->pieces) ? $freightdata->pieces : '').'</td>';
									  echo '<td class="text-left">'.(isset($freightdata->length) ? $freightdata->length : '').'</td>';
									  echo '<td class="text-left">'.(isset($freightdata->width) ?$freightdata->width : '').'</td>';
									  echo '<td class="text-left" style="border-right:1px solid #000;">'.(isset($freightdata->height) ? $freightdata->height : '').'</td>';
									  if(count($row) == 1){
										echo '<td colspan="4" style="border-right:1px solid #000;"></td>';
										if($key != 0){
											echo '<td></td>';
										}
									  }

								}
								if($key == 0){
									echo '<td class="text-left">$'.number_format($totalchargecost, 2).'</td>';
								}
								echo '</tr>';
							}
							
						}else{
							echo '<tr ><td colspan="9">No Data Found</td><tr>';
						}
					?>
				  
				</tbody>
				
			  </table>

			</div>
		  </div>
		</div>
		
		<div class="row m-0 pt-3 pb-0">
		 
		  <div class="col-sm-6"> 
				<address>
					<?php echo $shipInfo['bill_to_data']['b_shipper_name'];?><br />
					<?php echo $shipInfo['bill_to_data']['b_address_1']. (isset($shipInfo['bill_to_data']['b_address_2']) ? ', '.$shipInfo['bill_to_data']['b_address_2'] : '');?><br />
					
					<?php echo $shipInfo['bill_to_data']['b_city']. (isset($shipInfo['bill_to_data']['state_name']) ? ', '.$shipInfo['bill_to_data']['state_name']. ' '.$shipInfo['bill_to_data']['b_zip'] : ''). (isset($shipInfo['bill_to_data']['country_name']) ? ', '.$shipInfo['bill_to_data']['country_name'] : '');?><br />
				</address>
				
				<br/><br/>
				
		  </div>
		  
		  <div class="col-sm-6">
				Please Remit to:
				<address>
					<strong>
						Fastline Logistics<br/>
						P.O. Box 266<br/>
						Centerton, AR 72719, US<br/>
					</strong>
				</address>
		  </div>
		  
		</div>
		
    </div>
  </main>

  
  
  <div class="btn-group-sm d-print-none text-center avoid-normal-print mt-2"> 
		<a href="javascript:void(0);" class="btn btn-light border text-black shadow-none print_button"><i class="fa fa-print"></i> Print</a> 
  </div>
</div>

</body>
</html>