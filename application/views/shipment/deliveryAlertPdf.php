<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo 'delivery_alert_'.$shipInfo['waybill'];?></title>
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
      <div class="col-sm-5 text-left">
		<img id="logo" src="<?php echo base_url().'assets/images/logo_new.png';?>" title="Fastline Logistics" alt="Fastline Logistics" style="width:350px;"/> <br/> 
		P.O Box 266<br/>
        Centerton, AR 72719, US<br/>
		Phone:800-540-6100
	  </div>
	  
	  <div class="col-sm-4 text-center text-6">
		DELIVERY ALERT
	  </div>
	  
	  <!--<div class="col-sm-4 text-center text-sm-right">
			<strong>Date : <?php //echo (isset($shipInfo['pod_date']) ? date("m/d/Y", strtotime($shipInfo['pod_date'])) : date("m/d/Y", strtotime($shipInfo['createdDtm'])));?></strong><br/>
      </div>-->
    </div>
    <hr>
  </header>
  
  <!-- Main Content -->
  <main>
    
	<?php 
		$agentname = $agentphone = $agentfax = $carriername = $masterairwaybill = $flightno = $eta = '-';
		$islinehaul = $isairway = false;
		if(!empty($aVenRecords)){
			foreach($aVenRecords as $key => $aVenRecord){
				/*Local Delivery data*/
				if($aVenRecord->p_v_type_id == 8){
					$agentname = $aVenRecord->agent_name;
					$agentphone = $aVenRecord->agent_phone;
					$agentfax = $aVenRecord->agent_fax;
				}
				
				/*airline or line haul*/
				if($aVenRecord->p_v_type_id == 7){
					if(!empty($aVenRecord->v_arrival_time)){
						$eta = $aVenRecord->v_arrival_time;
					}
					$masterairwaybill = $aVenRecord->v_mawb;
					if(!empty($aVenRecord->agent_name)){
						$carriername = $aVenRecord->agent_name;
					}
				}
				if($aVenRecord->p_v_type_id == 6){
					if(!empty($aVenRecord->vendor_airline_datas)){
						$airrecs = (array) json_decode($aVenRecord->vendor_airline_datas);
						
						foreach($airrecs as $airdata){
							/* loading last flight name*/
							if(!empty($airdata->flight_name)){
								$flightno = $airdata->flight_name;
							}
							/* loading last flight_arrival*/
							if(!empty($airdata->flight_arrival)){
								$eta = $airdata->flight_arrival;
							}
						}
					}
					$isairway = true;
				}
				if($aVenRecord->p_v_type_id == 6 && !empty($aVenRecord->v_airline)){
					$carriername = $aVenRecord->v_airline;
				}
				if($aVenRecord->p_v_type_id == 6 && !empty($aVenRecord->v_mawb)){
					$masterairwaybill = $aVenRecord->v_mawb;
				}
				if($aVenRecord->p_v_type_id == 7){
					$islinehaul = true;
				}
				
			}
		}
		if($isairway){
			$islinehaul = false;
		}
	?>
	<div class="row">
      <div class="col-sm-3 mb-3 mb-sm-0"> 
		<span class="text-black text-uppercase">Master Air waybill:</span><br>
        <span class="font-weight-500 text-3"><?php echo $masterairwaybill;?></span> 
	  </div>
      <div class="col-sm-3 mb-3 mb-sm-0"> 
		<span class="text-black text-uppercase">Carrier:</span><br>
        <span class="font-weight-500 text-3"><?php echo $carriername;?></span> 
	  </div>
      <div class="col-sm-2"> 
		<span class="text-black text-uppercase">Org:</span><br>
        <span class="font-weight-500 text-3"><?php echo (isset($shipInfo['origin_airport_code']) ? $shipInfo['origin_airport_code'] : '-');?></span> 
	  </div>
	  
      <div class="col-sm-2 mb-3 mb-sm-0"> 
		<span class="text-black text-uppercase">Dest:</span><br>
        <span class="font-weight-500 text-3"><?php echo (isset($shipInfo['dest_airport_code']) ? $shipInfo['dest_airport_code'] : '-');?></span> 
	  </div>
	  <?php if(!$islinehaul){ ?>
	  <div class="col-sm-2 mb-3 mb-sm-0"> 
		<span class="text-black text-uppercase">Flight:</span><br>
        <span class="font-weight-500 text-3"><?php echo $flightno;?></span> 
	  </div>
	  <?php } ?>
    </div>

    <div class="row">
      
      <div class="col-sm-4 mb-3 mb-sm-0"> 
		<span class="text-black text-uppercase">ETA:</span><br>
        <span class="font-weight-500 text-3"><?php echo ((isset($eta) && $eta != '-') ? date("D, F j,Y g:ia", strtotime($eta)) : '-'); ?></span> 
	  </div>
      <div class="col-sm-3 mb-3 mb-sm-0"> 
		<span class="text-black text-uppercase">House Bill #:</span><br>
        <span class="font-weight-500 text-3"> <?php echo $shipInfo['station'].' '.$shipInfo['waybill'];?></span> 
	  </div>
      <div class="col-sm-2"> 
		<span class="text-black text-uppercase">PCS:</span><br>
        <span class="font-weight-500 text-3"><?php echo $shipInfo['total_pieces'];?></span> 
	  </div>
	  <div class="col-sm-3"> 
		<span class="text-black text-uppercase">Weight:</span><br>
        <span class="font-weight-500 text-3"><?php echo $shipInfo['total_chargeable_weight'];?></span> 
	  </div>
	   
    </div>
	
	<hr class="my-3">

	<div class="row">
     
      <div class="col-sm-6 order-sm-0"> 
		<strong>Shipper</strong>
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
		
        </address>
      </div>
	  
	  <div class="col-sm-6 text-sm-right order-sm-1"> 
		<strong>Consignee</strong>
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
        </address>
      </div>
    </div>
	
	<hr class="my-3">
		
    <div class="row">
        <div class="table-responsive">
          <table class="table mb-0 text-black">
            <thead>
              <tr>
                <td class="text-center text-uppercase"><strong>Pieces</strong></td>
                <td class="text-center text-uppercase"><strong>PKG Type</strong></td>
                <td class="text-center text-uppercase"><strong>Weight</strong></td>
                <td class="text-center text-uppercase"><strong>Dimensions</strong></td>
                <td class="text-center text-uppercase"><strong>Descriptions</strong></td>
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
	
	<?php if(isset($shipInfo['schedule_date_time']) && !empty($shipInfo['schedule_date_time'])){ ?>
	<hr class="my-3">
	<div class="row">
		<div class="col-sm-12">
			Must Deliver on <?php
				if($shipInfo['schedule_by'] == 3){
					
					echo (isset($shipInfo['schedule_date_time']) ? date("m/d/Y", strtotime($shipInfo['schedule_date_time'])) : '') . ' Between '.(isset($shipInfo['schedule_date_time']) ? date("g:ia", strtotime($shipInfo['schedule_date_time'])) : '') .' to '.(isset($shipInfo['schedule_between_time']) ? date("g:ia", strtotime($shipInfo['schedule_between_time'])) : '') ;
				}elseif($shipInfo['schedule_by'] == 2){
					
					echo (isset($shipInfo['schedule_date_time']) ? date("m/d/Y", strtotime($shipInfo['schedule_date_time'])) : '') . ' at '.(isset($shipInfo['schedule_date_time']) ? date("g:ia", strtotime($shipInfo['schedule_date_time'])) : '') ; 
				}else{
					echo (isset($shipInfo['schedule_date_time']) ? date("m/d/Y", strtotime($shipInfo['schedule_date_time'])) : '') . ' by '.(isset($shipInfo['schedule_date_time']) ? date("g:ia", strtotime($shipInfo['schedule_date_time'])) : '') ; 
				}
				
				?> 
		</div>
     </div>
	 <hr class="my-3">
    <?php } ?>
	
	
	<div class="row">
     
      <div class="col-sm-5 order-sm-0"> 
		<strong>POD:</strong>
        <div style="border-bottom:1px solid #333;display:inline-block;width:80%;">	</div>
      </div>
	  
	  <div class="col-sm-4 text-sm-right order-sm-1"> 
		<strong>DATE:</strong>
		 <div style="border-bottom:1px solid #333;display:inline-block;width:60%;">	</div>
      </div>
	  <div class="col-sm-3 text-sm-right order-sm-1"> 
		<strong>TIME:</strong>
		 <div style="border-bottom:1px solid #333;display:inline-block;width:50%;">	</div>
      </div>
    </div>
	
	<p class="mt-4 text-center text-black">Delivery Information</p>
	
	<div class="row">
      <div class="col-sm-4 mb-3 mb-sm-0"> 
		<span class="font-weight-600 ">Agent:
			<?php 
			echo $agentname;
			?>
		</span><br>
	  </div>
      <div class="col-sm-4 mb-3 mb-sm-0 text-right "> 
        <span class="font-weight-500  textt-2">Phone:<?php echo preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $agentphone);?></span> 
	  </div>
      <div class="col-sm-4 text-right "> 
        <span class="font-weight-500 textt-2">Fax:<?php echo $agentfax;?></span> 
	  </div>
    </div>
	
	<hr class="my-3">
	
	<div class="row">
      <div class="col-sm-12 mb-3 mb-sm-0"> 
		<span class="font-weight-500 ">Instructions:</span><br>
	  </div>
      <div class="col-sm-12 mb-3 mb-sm-0" style="min-height:150px;"> 
			<?php echo isset($shipInfo['sp_ins_datas']['sp_delivery_instructions']) ? $shipInfo['sp_ins_datas']['sp_delivery_instructions'] : ''; ?>
	  </div>
    </div>
	
  </main>

  <footer class="text-center mt-4">
	<hr>
	<p>IF THERE IS ANY PROBLEM WITH ON-TIME DELIVERY PLEASE CALL 800-540-6100</p>
	<hr>
  </footer>
  
  <div class="btn-group-sm d-print-none text-center avoid-normal-print"> 
		<a href="javascript:void(0);" class="btn btn-light border text-black shadow-none print_button"><i class="fa fa-print"></i> Print</a> 
  </div>
  
</div>

</body>
</html>