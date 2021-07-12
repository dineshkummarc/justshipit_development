<table class="table table-hover">
	<tr class="bg-info">
		<th></th>
		<th>Type</th>
		<th>Ref No</th>
		<th>Vendor</th>
		<th>Quantity</th>
		<th>Cost</th>
		<th>Extra</th>
		<th>Tax</th>
		<th>Total Cost</th>
		<th>Finalized</th>
		
	</tr>
	
	<?php 
		$totalcost = 0;
		if(!empty($aVenRecords)){
		foreach($aVenRecords as $aVenRecord){
	?>
		<tr id="vendor_div_<?php echo $aVenRecord->dom_id;?>">
			<td><a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" onclick="editVendorType(<?php echo $aVenRecord->dom_id;?>);">Select</a></td>
			<td><?php echo $aVenRecord->vendor_short_code ?></td>
			<td>
			<?php 
				
				if($aVenRecord->p_v_type_id == 6 ||$aVenRecord->p_v_type_id == 7 ){
					if(!empty($aVenRecord->v_mawb)){
						echo $aVenRecord->v_mawb;
					}else{
						echo $aVenRecord->p_ref_name;
					}
				}else{
					echo $aVenRecord->p_ref_name;
				}
			?>
			</td>
			<td><?php echo $aVenRecord->customer_number ?></td>
			<td><?php echo $aVenRecord->p_qty ?></td>
			<td><?php echo $aVenRecord->p_cost ?></td>
			<td><?php echo $aVenRecord->p_extra ?></td>
			<td><?php echo $aVenRecord->p_tax ?></td>
			<td><?php echo $aVenRecord->p_total_cost ?></td>
			<td><?php echo (($aVenRecord->p_finalize == 1) ? 'Yes' : 'No')?></td>
			<!--<td >
				<a href="javascript:void(0);" title="Remove" style="color:red;font-weight:600;" onclick="removeVendorType(<?php //echo $aVenRecord->dom_id ?>);">X</a>
			</td> -->
		</tr>
	<?php 
		$totalcost = $totalcost + $aVenRecord->p_total_cost;
		}
	}?>
</table>
<div class="col-sm-12 text-right f16">
	Total :$<?php echo number_format($totalcost, 2); ?>
</div>