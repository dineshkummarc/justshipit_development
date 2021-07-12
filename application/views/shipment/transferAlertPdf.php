<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo 'transfer_alert_'.$shipInfo['waybill'];?></title>
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
<div class="container-fluid invoice-container" id="puchase_holder" style="color:#000;font-size:14pt;"> 

  <!-- Header -->
  <header>
    <div class="row align-items-center">
      <div class="col-sm-4 text-left textt-2">
		<img id="logo" src="<?php echo base_url().'assets/images/logo_new.png';?>" title="Fastline Logistics" alt="Fastline Logistics" style="width:350px;text-align:right;"/>
	  </div>
	  
	  <div class="col-sm-4 text-center ">
		<span class="text-6">Transfer Alert</span><br/>
		<b>HAWB:</b> <?php echo $shipInfo['waybill'];?><br/>
		<b>TO:</b> <?php echo (isset($aRecords['t_data']['t_name']) ? $aRecords['t_data']['t_name'] : ''); ?><br/>
		
	  </div>
	  
      <div class="col-sm-4 text-left textt-2">
			Fastline Logistics <br/>
			P.O Box 266<br/>
			Centerton, AR 72719, US<br/>
			Phone: 800-540-6100 <br/>
			Fax: 479-888-5500<br/>
			Email: ap@fastlinelogistics.com
      </div>
    </div>
    <hr>
  </header>
  
  <!-- Main Content -->
  <main>
    
	<div class="table-responsive text-black">
      <table class="table textt-2 table-sm text-black" style="border:2px solid #000;">
        <thead>
          <tr>
            <td colspan="2" class="text-center"><span class="font-weight-600 ">RECOVER FROM</span></td>
            <td colspan="2" class="text-center" style="border-left:2px solid #000;"><span class="font-weight-600">TRANSFER TO</span></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="font-weight-600 coll-2">Name</td>
            <td class="coll-4"><?php echo (isset($aRecords['r_data']['r_name']) ? $aRecords['r_data']['r_name'] : ''); ?></td>
            <td class="font-weight-600 coll-2" style="border-left:2px solid #000;">Name</td>
            <td class="coll-4" ><?php echo (isset($aRecords['t_data']['t_name']) ? $aRecords['t_data']['t_name'] : ''); ?></td>
          </tr>
          <tr>
            <td class="font-weight-600">ADDR 1</td>
            <td><?php echo (isset($aRecords['r_data']['r_address_1']) ? $aRecords['r_data']['r_address_1'] : ''); ?></td>
            <td class="font-weight-600" style="border-left:2px solid #000;">ADDR 1</td>
            <td><?php echo (isset($aRecords['t_data']['t_address_1']) ? $aRecords['t_data']['t_address_1'] : ''); ?></td>
          </tr>
          <tr>
            <td class="font-weight-600">ADDR 2</td>
            <td><?php echo (isset($aRecords['r_data']['r_address_2']) ? $aRecords['r_data']['r_address_2'] : ''); ?></td>
            <td class="font-weight-600" style="border-left:2px solid #000;">ADDR 2</td>
            <td><?php echo (isset($aRecords['t_data']['t_address_2']) ? $aRecords['t_data']['t_address_2'] : ''); ?></td>
          </tr>
		  
		  <tr>
            <td class="font-weight-600">CITY</td>
            <td><?php echo (isset($aRecords['r_data']['r_city']) ? $aRecords['r_data']['r_city'] : ''); ?></td>
            <td class="font-weight-600" style="border-left:2px solid #000;">CITY</td>
            <td><?php echo (isset($aRecords['t_data']['t_city']) ? $aRecords['t_data']['t_city'] : ''); ?></td>
          </tr>
		  
          <tr>
            <td class="font-weight-600">STATE/ZIP</td>
            <td>
				<?php
					if(!empty($r_states))
					{
						foreach ($r_states as $st)
						{
							if($st['state_id'] == (isset($aRecords['r_data']['r_state']) ? $aRecords['r_data']['r_state'] : '')) {
								echo $st['state_name'];
							}
						}
					}
				?>
				<?php echo '    '.(isset($aRecords['r_data']['r_zip']) ? $aRecords['r_data']['r_zip'] : ''); ?>
			</td>
            <td class="font-weight-600" style="border-left:2px solid #000;">STATE/ZIP</td>
            <td>
				<?php
				if(!empty($t_states))
				{
					foreach ($t_states as $st)
					{
						if($st['state_id'] == (isset($aRecords['t_data']['t_state']) ? $aRecords['t_data']['t_state'] : '')) {
							echo $st['state_name'];
						}
					}
				}
				?>
				
				<?php echo '    '.(isset($aRecords['t_data']['t_zip']) ? $aRecords['t_data']['t_zip'] : ''); ?>
			</td>
          </tr>
          <tr>
            <td class="font-weight-600">COUNTRY</td>
            <td>
				<?php
				if(!empty($countries))
				{
					foreach ($countries as $rl)
					{
						if($rl['country_id'] ==  (isset($aRecords['r_data']['r_country']) ? $aRecords['r_data']['r_country'] : '')) {
							echo $rl['country_name'];
						}
					}
				}
				?>
			</td>
            <td class="font-weight-600" style="border-left:2px solid #000;">COUNTRY</td>
            <td>
				<?php
					if(!empty($countries))
					{
						foreach ($countries as $rl)
						{
							if($rl['country_id'] ==  (isset($aRecords['t_data']['t_country']) ? $aRecords['t_data']['t_country'] : '')) {
								echo $rl['country_name'];
							}
						}
					}
					?>
			</td>
          </tr>
          <tr>
            <td class="font-weight-600">PHONE</td>
            <td><?php echo (isset($aRecords['r_data']['r_phone']) ? $aRecords['r_data']['r_phone'] : ''); ?></td>
            <td class="font-weight-600" style="border-left:2px solid #000;">PHONE</td>
            <td><?php echo (isset($aRecords['t_data']['t_phone']) ? $aRecords['t_data']['t_phone'] : ''); ?></td>
          </tr>
		  
          <tr>
            <td class="font-weight-600">CONTACT</td>
            <td><?php echo (isset($aRecords['r_data']['r_contact']) ? $aRecords['r_data']['r_contact'] : ''); ?></td>
            <td class="font-weight-600" style="border-left:2px solid #000;">CONTACT</td>
            <td><?php echo (isset($aRecords['t_data']['t_contact']) ? $aRecords['t_data']['t_contact'] : ''); ?></td>
          </tr>
		  
		  
		  <?php if(!empty($aRecords['r_data']['r_default_ref']) || !empty($aRecords['t_data']['t_default_ref'])){ ?>
		  <tr>
			<?php if(!empty($aRecords['r_data']['r_default_ref'])){ ?>
				<td class="font-weight-600">MAWB/REF</td>
				<td><?php echo (isset($aRecords['r_data']['r_default_ref']) ? $aRecords['r_data']['r_default_ref'] : ''); ?></td>
			<?php 
			}else{
				echo '<td colspan="2"></td>';
			}
			?>
			<?php if(!empty($aRecords['t_data']['t_default_ref'])){?>
				<td class="font-weight-600" style="border-left:2px solid #000;">MAWB/REF</td>
				<td><?php echo (isset($aRecords['t_data']['t_default_ref']) ? $aRecords['t_data']['t_default_ref'] : ''); ?></td>
			<?php 
			}else{
				echo '<td colspan="2"></td>';
			}
			?>
          </tr>
		  <?php } ?>
		  <tr>
            <td class="font-weight-600">FLIGHT</td>
            <td><?php echo (isset($aRecords['r_data']['r_flight']) ? $aRecords['r_data']['r_flight'] : ''); ?></td>
            <td class="font-weight-600" style="border-left:2px solid #000;">FLIGHT</td>
            <td><?php echo (isset($aRecords['t_data']['t_flight']) ? $aRecords['t_data']['t_flight'] : ''); ?></td>
          </tr>
		  
		  <tr>
            <td class="font-weight-600">ARRIVAL DATE/TIME</td>
            <td><?php echo ((isset($aRecords['r_data']['r_arrival_date'])  && !empty($aRecords['t_data']['t_cutoff_date'])) ? date('m/d/Y',strtotime($aRecords['r_data']['r_arrival_date'])) : '').' '.(isset($aRecords['r_data']['r_arrival_time']) ? $aRecords['r_data']['r_arrival_time'] : ''); ?></td>
            <td class="font-weight-600" style="border-left:2px solid #000;">DEPARTURE DATE/TIME</td>
            <td><?php echo ((isset($aRecords['t_data']['t_departure_date']) && !empty($aRecords['t_data']['t_departure_date'])) ? date('m/d/Y',strtotime($aRecords['t_data']['t_departure_date'])) : '') .' '.(isset($aRecords['t_data']['t_departure_time']) ? $aRecords['t_data']['t_departure_time'] : ''); ?></td>
          </tr>
		  
		  <tr>
            <td class="font-weight-600" style="border-bottom:2px solid #000;">MAWB CONSIGNED TO</td>
            <td style="border-bottom:2px solid #000;"><?php echo (isset($aRecords['r_data']['r_mawb_consign_to']) ? $aRecords['r_data']['r_mawb_consign_to'] : ''); ?></td>
			
            <td class="font-weight-600" style="border-left:2px solid #000;border-bottom:2px solid #000;">CUTOFF DATE/TIME</td>
            <td style="border-bottom:2px solid #000;"><?php echo ((isset($aRecords['t_data']['t_cutoff_date']) && !empty($aRecords['t_data']['t_cutoff_date'])) ? date('m/d/Y',strtotime($aRecords['t_data']['t_cutoff_date'])) : '') .' '.(isset($aRecords['t_data']['t_cutoff_time']) ? $aRecords['t_data']['t_cutoff_time'] : ''); ?></td>
          </tr>
		  
		  <tr>
            <td colspan="4" class="font-weight-600">INSTRUCTIONS</td>
          </tr>
		  
		  <tr>
            <td colspan="4">
			<?php echo (!empty($aRecords['instructions']) ? $aRecords['instructions'] : 'No Instruction Found');?>
			</td>
          </tr>
		  
        </tbody>
      </table>
	
  </main>
  
  <div class="btn-group-sm d-print-none text-center avoid-normal-print mt-2"> 
		<a href="javascript:void(0);" class="btn btn-light border text-black-50 shadow-none print_button"><i class="fa fa-print"></i> Print</a> 
  </div>
  
</div>

</body>
</html>