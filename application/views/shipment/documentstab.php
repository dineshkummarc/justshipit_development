<div class="row m-0">
	<div class="col-md-12">
		<div class="center_box">
			<div class="doc_box">
				<a class="color_333" target="_blank" href="<?php echo base_url().'dominvoicepdf/'.$shipInfo['shipment_id']; ?>">Invoice</a>
			</div>
			
			<div class="doc_box">
				<a class="color_333" target="_blank" href="<?php echo base_url().'billLadingPdf/'.$shipInfo['shipment_id']; ?>">Bill of Lading</a>
			</div>
			
			<div class="doc_box">
				<a class="color_333" target="_blank" href="<?php echo base_url().'pickupAlertPdf/'.$shipInfo['shipment_id']; ?>">Pickup Alert</a>
			</div>	
			
			<div class="doc_box">
				<a class="color_333" target="_blank" href="<?php echo base_url().'deliveryAlertPdf/'.$shipInfo['shipment_id']; ?>">Delivery Alert</a>
			</div>
			
			<div class="doc_box">
				<a href="<?php echo base_url().'dommawb/'.$shipInfo['shipment_id']; ?>">MAWB</a>
			</div>	
			
			
			
			<div class="doc_box">
				<a class="color_333" target="_blank" href="<?php echo base_url().'assets/pdf/CargoAcceptAR.pdf'; ?>">Certification</a>
			</div>
			
			<div class="doc_box">
				<a class="color_333" target="_blank" href="<?php echo base_url().'bolLabel/'.$shipInfo['shipment_id']; ?>">BOL Label</a>
			</div>	
			
			<div class="doc_box">
				<a class="color_333" href="javascript:void(0);" data-toggle="modal" data-target="#myModal" onclick="loadRoutingAlert(<?php echo $shipInfo['shipment_id']; ?>);">Routing Alert</a>  
			</div>
			
			<div class="doc_box">
				<a class="color_333" href="javascript:void(0);" data-toggle="modal" data-target="#myModaloverlap" onclick="loadTransferAlert(<?php echo $shipInfo['shipment_id']; ?>);">Add transfer Alert</a>
			</div>	
		</div>
	</div>
</div>

<style type="text/css">
.doc_box{
	padding: 10px;
	box-shadow:0px 2px 3px #3c8dbc;
	width: 20%;
	text-align: center;
	display: inline-block;
	margin: 10px;
}
</style>