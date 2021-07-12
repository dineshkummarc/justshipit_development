<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo 'Routing_alert_'.$shipInfo['waybill'];?></title>
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
	<?php 
		$agentname = $agentphone = $agentfax = $carriername = '-';
		if(!empty($aVenRecords)){
			foreach($aVenRecords as $key => $aVenRecord){
				/*Local Delivery data*/
				if($aVenRecord->p_v_type_id == 5){
					$agentname = $aVenRecord->agent_name;
					$agentphone = $aVenRecord->agent_phone;
					$agentfax = $aVenRecord->agent_fax;
				}
				
				/*airline or line haul*/
				if($aVenRecord->p_v_type_id == 6 && !empty($aVenRecord->v_airline)){
					$carriername = $aVenRecord->v_airline;
				}
				
			}
		}
	?>
  <!-- Header -->
  <header>
    <div class="row align-items-center">
		
      <div class="col-sm-7 text-left textt-3">
		<div class="col-sm-12 text-right text-6">
			ROUTING ALERT
		</div>
		<strong class="text-4">TO:<?php echo $agentname;?></strong><br/>
		Phone #: <?php echo preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $agentphone);?> &nbsp;&nbsp;
		Fax #: <?php echo $agentfax;?><br/><br/>
		Requested By: <?php echo $sysname;?> - Fastline Logistics
	  </div>
	  
	  
	  
      <div class="col-sm-5 text-right textt-3">
			<img id="logo" src="<?php echo base_url().'assets/images/logo_new.png';?>" title="Fastline Logistics" alt="Fastline Logistics" style="width:350px;text-align:right;"/> <br/>
			P.O Box 266<br/>
			Centerton, AR 72719, US<br/>
      </div>
    </div>
    <hr>
  </header>
  
  <!-- Main Content -->
  <main>
    
	<div class="row">
      <div class="col-sm-4 mb-3 mb-sm-0"> 
		<span class="text-black">Phone #: 800-540-6100</span>
	  </div>
      <div class="col-sm-4 mb-3 mb-sm-0"> 
		<span class="text-black">Fax #: 479-888-5500</span><br>
	  </div>
      <div class="col-sm-4"> 
		<span class="text-black">HAWB # : <?php echo $shipInfo['waybill'];?></span><br>
	  </div>
    </div>
	
	<hr class="my-3">

	<div class="row">
     
      <div class="col-sm-6 order-sm-0"> 
		<strong>Pick-up at:</strong>
        <address>
			 <?php echo $shipInfo['shipper_data']['shipper_name'];?><br />
			<?php echo $shipInfo['shipper_data']['s_address_1'];?><br />
			
			<?php echo (!empty($shipInfo['shipper_data']['s_address_2']) ? $shipInfo['shipper_data']['s_address_2'].'<br/>' : '');?>
			
			<?php echo $shipInfo['shipper_data']['s_city']. (isset($shipInfo['shipper_data']['state_name']) ? ', '.$shipInfo['shipper_data']['state_name']. ' '.$shipInfo['shipper_data']['s_zip'] : ''). (isset($shipInfo['shipper_data']['country_name']) ? ', '.$shipInfo['shipper_data']['country_name'] : '');?><br />
			
			<?php echo (!empty($shipInfo['shipper_data']['show_name']) ? $shipInfo['shipper_data']['show_name'].'<br/>' : ''); ?>
			<?php echo (!empty($shipInfo['shipper_data']['exhibitor_name']) ? $shipInfo['shipper_data']['exhibitor_name'].'<br/>' : ''); ?>
			<?php echo (!empty($shipInfo['shipper_data']['booth_name']) ? 'Booth #'.$shipInfo['shipper_data']['booth_name'].'<br/>' : ''); ?>
			<?php echo (!empty($shipInfo['shipper_data']['decorator_name']) ? $shipInfo['shipper_data']['decorator_name'].'<br/>' : ''); ?>

			<?php 
				if($shipInfo['shipper_data']['customer_data']['tsa_known_shipper'] == 1){
					echo '(Shipper is known)';
				}else{
					echo '(Shipper is not known)';
				}
			?>
        </address>
      </div>
	  
	  <div class="col-sm-6 text-sm-right order-sm-1"> 
		<strong>Contact Name: <?php echo (isset($shipInfo['shipper_data']['s_contact']) ? $shipInfo['shipper_data']['s_contact'] : '-');?></strong>
       <address>
			<b>Phone # :</b><?php echo (isset($shipInfo['shipper_data']['s_phone']) ? preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $shipInfo['shipper_data']['s_phone']) : '-');?><br/>
			<b>Service Level :</b> <?php echo (isset($shipInfo['service_name']) ? $shipInfo['service_name'] : '-');?> <br/>
			<?php if($shipInfo['shipper_data']['s_default_ref']){ ?>
				<b>Shipper Reference #</b> :  <?php echo $shipInfo['shipper_data']['s_default_ref']. (isset($shipInfo['shipper_data']['ref_name']) ? ' - '.$shipInfo['shipper_data']['ref_name'] : '');?><br/>
			<?php } ?>
			<b>Ultimate Dest:</b> <?php echo $shipInfo['consignee_data']['c_city']. (isset($shipInfo['consignee_data']['state_name']) ? ', '.$shipInfo['consignee_data']['state_name'] : '');?>
	   </address>
      </div>
    </div>
	
	<hr class="my-3">
	
	<div class="row  mb-3">
      <div class="col-sm-5 mb-3 mb-sm-0"> 
		<span class="text-black">Shipment Date: <?php echo (isset($shipInfo['ready_date_time']) ? date("m/d/Y", strtotime($shipInfo['ready_date_time'])) : ''); ?></span>
	  </div>
      <div class="col-sm-3 mb-3 mb-sm-0"> 
		<span class="text-black">Ready: <?php echo (isset($shipInfo['ready_date_time']) ? date("g:ia", strtotime($shipInfo['ready_date_time'])) : ''); ?></span><br>
	  </div>
      <div class="col-sm-4"> 
		<span class="text-black">Close: <?php echo (isset($shipInfo['close_date_time']) ? date("g:ia", strtotime($shipInfo['close_date_time'])) : ''); ?></span><br>
	  </div>
    </div>
	
	
		
    <div class="row">
        <div class="table-responsive">
          <table class="table mb-0 text-black">
            <thead>
              <tr>
                <td class="col-2 text-center text-uppercase"><strong>Pieces</strong></td>
                <td class="col-2 text-center text-uppercase"><strong>Weight</strong></td>
                <td class="col-3 text-center text-uppercase"><strong>Dimensions</strong></td>
                <td class="col-2 text-center text-uppercase"><strong>Descriptions</strong></td>
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
						<?php echo isset($freightdata->weight) ? $freightdata->weight : ''; ?>
					</td>
					
					<td class="text-center">
						<?php echo (isset($freightdata->length) ? $freightdata->length : '') . (isset($freightdata->width) ? ' x '.$freightdata->width : ' x ') . (isset($freightdata->height) ? ' x '.$freightdata->height : ' x '); ?>
					</td>
										
					<td class="text-center">
						<?php echo isset($freightdata->description) ?$freightdata->description : ''; ?>
					</td>
					
				</tr>
				<?php 
					}
					}
				?>
              
            </tbody>
          </table>
        </div>
    </div>
	
	
	<hr class="my-3">
	
	<div class="row">
	  <div class="col-sm-12 text-center text-6"> MAWB Routing  </div>
	  
	  <div class="col-sm-6 order-sm-0"> 
        <address>
		<strong>Shipper :</strong>
        <?php echo (isset($aRecords['r_f_data']['r_name']) ? $aRecords['r_f_data']['r_name'] : 'Fastline Logistics LLC'); ?><br />
        <?php echo (isset($aRecords['r_f_data']['r_address_1']) ? $aRecords['r_f_data']['r_address_1'] : 'P.O Box 266'); ?><br />
        <?php echo (isset($aRecords['r_f_data']['r_address_2']) ? $aRecords['r_f_data']['r_address_2'].'<br />' : ''); ?>
		
		
		<?php 
		if(isset($aRecords['r_f_data']['country_name'])){
			echo $aRecords['r_f_data']['r_city']. (isset($aRecords['r_f_data']['state_name']) ? ', '.$aRecords['r_f_data']['state_name']. ' '.$aRecords['r_f_data']['r_zip'] : ''). (isset($aRecords['r_f_data']['country_name']) ? ', '.$aRecords['r_f_data']['country_name'] : '');
		}else{
			echo 'Centerton, AR 72719, US';
		}
		?><br/>
        </address>
      </div>
	  
	  <div class="col-sm-6 text-sm-right order-sm-1"> 
		
       <address>
        <strong>Consignee :</strong> <?php echo (isset($aRecords['t_f_data']['t_name']) ? $aRecords['t_f_data']['t_name'] : $deliveryVenData['name']); ?><br />
        <?php echo (isset($aRecords['t_f_data']['t_address_1']) ? $aRecords['t_f_data']['t_address_1'] : ''); ?><br />
		<?php echo (isset($aRecords['t_f_data']['t_address_2']) ? $aRecords['t_f_data']['t_address_2'].'<br />' : ''); ?>
		
		<?php 
		if(isset($aRecords['t_f_data']['country_name'])){
			echo $aRecords['t_f_data']['t_city']. (isset($aRecords['t_f_data']['state_name']) ? ', '.$aRecords['t_f_data']['state_name']. ' '.$aRecords['t_f_data']['t_zip'] : ''). (isset($aRecords['t_f_data']['country_name']) ? ', '.$aRecords['t_f_data']['country_name'] : '');
		}else{
			echo $deliveryVenData['city']. (isset($deliveryVenData['state_name']) ? ', '.$deliveryVenData['state_name']. ' '.$deliveryVenData['zip'] : ''). (isset($deliveryVenData['country_name']) ? ', '.$deliveryVenData['country_name'] : '');
		}
		?><br/>
		Phone:<?php echo (isset($aRecords['t_f_data']['t_phone']) ? $aRecords['t_f_data']['t_phone'] : $deliveryVenData['phone']); ?>
        </address>
      </div>
	 </div>
	 
	<div class="row pt-4" style="font-size:13pt;">
      
		<div class="col-sm-5 mb-3 mb-sm-0 p-0"> 
			<span class="text-black"><b>LineHaul/Airline:<?php echo (isset($aRecords['ro_airline']) ? $aRecords['ro_airline'] : $neededVendorData['v_airline']); ?></b> </span>
		</div>
		
		
		<div class="col-sm-3 mb-3 mb-sm-0 p-0"> 
			<span class="text-black"><b>A/L Svs Level:<?php echo (isset($shipInfo['service_name']) ? $shipInfo['service_name'] : '-');?></b> </span>
		</div>
		
		
		<div class="col-sm-4 mb-3 mb-sm-0 p-0 text-right"> 
			<span class="text-black"><b>A/L Acct #:<?php echo (isset($aRecords['ro_account']) ? $aRecords['ro_account'] : $neededVendorData['v_account']); ?></b> </span>
		</div>
	 
    </div>
	
	<div class="row pt-4 ">
      <div class="col-sm-4 mb-3 mb-sm-0"> 
		<span class="font-weight-600 text-black text-uppercase">HAWB:</span>
        <span class="text-3"><?php echo (isset($aRecords['airbill_station']) ? $aRecords['airbill_station'] : $shipInfo['station']); ?> <?php echo ' '.(isset($aRecords['airbill_number']) ? $aRecords['airbill_number'] : $shipInfo['waybill']); ?></span> 
	  </div>
      
      <div class="col-sm-2"> 
		<span class="text-black text-uppercase">Org:</span> 
        <span class="text-3"><?php echo (isset($shipInfo['origin_airport_code']) ? $shipInfo['origin_airport_code'] : '-');?></span> 
	  </div>
	  
      <div class="col-sm-2 mb-3 mb-sm-0"> 
		<span class="text-black text-uppercase">Dest:</span>
        <span class=" text-3"><?php echo (isset($shipInfo['dest_airport_code']) ? $shipInfo['dest_airport_code'] : '-');?></span> 
	  </div>
	  <div class="col-sm-4 mb-3 mb-sm-0"> 
		<span class="text-black text-uppercase">Declare Value $:</span>
        <span class="text-3"></span> 
	  </div>
    </div>
	
	 
	 <div class="row pb-2">
        <div class="table-responsive">
          <table class="table table-bordered mb-0 text-black">
            <thead>
              <tr>
				<?php if($showAirline){	?>
                <td class="text-center text-uppercase"><strong>Carrier</strong></td>
                <td class="text-center text-uppercase"><strong>Flight #</strong></td>
                <td class="text-center text-uppercase"><strong>Origin</strong></td>
                <td class="text-center text-uppercase"><strong>Dest</strong></td>
                <td class="text-center text-uppercase"><strong>ETD</strong></td>
                <td class="text-center text-uppercase"><strong>ETA</strong></td>
				<?php }else{
					echo ' <td colspan="6"></td>';
				}?>
              </tr>
            </thead>
            <tbody>
			 <?php 
				$lasttime = $lastdate = '';
				if(!empty($neededVendorData['v_cut_off_time'])){
					$lastdate = date("m/d/Y", strtotime($neededVendorData['v_cut_off_time']));
					$lasttime = date("g:ia", strtotime($neededVendorData['v_cut_off_time']));
				}
				
				if(empty($aRecords) || empty($aRecords['airline_datas'])){
					if(isset($neededVendorData['vendor_airline_datas']) && !empty($neededVendorData['vendor_airline_datas'])){
						foreach($neededVendorData['vendor_airline_datas'] as $key => $airdata){
							$airdata = (array) $airdata;
							
						?>
						<tr  class="text-center"> 
						<td>
							<?php echo (isset($airdata['carrier_name']) ? $airdata['carrier_name'] : ''); ?>
						</td> 
						
						<td>
							<?php echo (isset($airdata['flight_name']) ? $airdata['flight_name'] : ''); ?>
						</td>
						
						<td>
							<?php echo (isset($airdata['flight_origin']) ? $airdata['flight_origin'] : ''); ?>
						</td>
						
						<td>
							<?php echo (isset($airdata['flight_dest']) ? $airdata['flight_dest'] : ''); ?>
						</td>
						
						<td>
							<?php echo (isset($airdata['flight_dept']) ? $airdata['flight_dept'] : ''); ?>
						</td>
		
						<td>
							<?php echo (isset($airdata['flight_arrival']) ? $airdata['flight_arrival'] : ''); ?>
						</td>
						
					</tr>
				<?php 
							if(isset($airdata['flight_arrival']) && !empty($airdata['flight_arrival']) && empty($lastdate) && empty($lasttime)){
								$lastdate = date("m/d/Y", strtotime($airdata['flight_arrival']));
								$lasttime = date("g:ia", strtotime($airdata['flight_arrival']));
							}
						}
					}
				}
				if(!empty($aRecords['airline_datas'])){
					foreach($aRecords['airline_datas'] as $key => $airdata){
					$airdata = (array) $airdata;
				?>
					<tr class="text-center"> 
						<td>
							<?php echo (isset($airdata['carrier_name']) ? $airdata['carrier_name'] : ''); ?>
						</td> 
						
						<td>
							<?php echo (isset($airdata['flight_name']) ? $airdata['flight_name'] : ''); ?>
						</td>
						
						<td>
							<?php echo (isset($airdata['flight_origin']) ? $airdata['flight_origin'] : ''); ?>
						</td>
						
						<td>
							<?php echo (isset($airdata['flight_dest']) ? $airdata['flight_dest'] : ''); ?>
						</td>
						
						<td>
							<?php echo (isset($airdata['flight_dept']) ? $airdata['flight_dept'] : ''); ?>
						</td>
		
						<td>
							<?php echo (isset($airdata['flight_arrival']) ? $airdata['flight_arrival'] : ''); ?>
						</td>
						
					</tr>
				<?php 
							if(isset($airdata['flight_arrival']) && !empty($airdata['flight_arrival']) && empty($lastdate) && empty($lasttime)){
								$lastdate = date("m/d/Y", strtotime($airdata['flight_arrival']));
								$lasttime = date("g:ia", strtotime($airdata['flight_arrival']));
							}
					}
				
				}

				?>
              
				<tr>
					<td colspan="6">
						<b>Must drop at linehaul/airline by:</b> <?php echo $lasttime.' ON '.$lastdate; ?>
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<b>MAWB#:</b> <?php echo ((isset($aRecords['ro_mawb']) && !empty($aRecords['ro_mawb'])) ? $aRecords['ro_mawb'] : $neededVendorData['v_mawb']); ?>
					</td>
					<td colspan="4">
						<b>P/U Agent HAWB/PRO #:</b>
					</td>
				</tr>
				
				<tr>
					<td colspan="6">
						<b>Exceptions (OS&D):</b> 
					</td>
				</tr>
				<tr>
					<td colspan="6">
						<b>Pickup Charges Expected:</b> $ 0.00
					</td>
				</tr>				
            </tbody>
          </table>
		  
		   <table class="table table-bordered mb-0 text-black">
				<thead>
				  <tr>
					<td class="text-left"><strong>Instructions</strong></td>
				  </tr>
				</thead>
				<tbody>
				<tr>
					<tr>
						<td>
							<?php echo isset($shipInfo['sp_ins_datas']['sp_pickup_instructions']) ? $shipInfo['sp_ins_datas']['sp_pickup_instructions'] : ''; ?>
						</td>
					</td>
				</tbody>
			</table>
        </div>
    </div>
			
	
  </main>
  
  <div class="btn-group-sm d-print-none text-center avoid-normal-print"> 
		<a href="javascript:void(0);" class="btn btn-light border text-black-50 shadow-none print_button"><i class="fa fa-print"></i> Print</a> 
  </div>
  
</div>

</body>
</html>