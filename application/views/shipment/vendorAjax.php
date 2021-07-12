<table class="table table-hover">
	<tr>
		<th class="text-center">
			Actions
			<input type='hidden' id='v_sort' value='desc'> 
		</th>
		<th style="width:120px;"><span onclick='sortVendorTable("customer_id");' style="cursor:pointer;">Customer Id <i class="fa fa-arrows-v"></i></span></th>
		<th><span onclick='sortVendorTable("customer_name");' style="cursor:pointer;">Name <i class="fa fa-arrows-v"></i></span></th>
		<th><span onclick='sortVendorTable("c_address_1");' style="cursor:pointer;">Address <i class="fa fa-arrows-v"></i></span></th>
		<th><span onclick='sortVendorTable("c_city");' style="cursor:pointer;">City <i class="fa fa-arrows-v"></i></span></th>
		
		<th><span onclick='sortVendorTable("c_phone");' style="cursor:pointer;">Phone <i class="fa fa-arrows-v"></i></span></th>
		
	</tr>
	<?php
	if(!empty($aRecords))
	{
		foreach($aRecords as $record)
		{
		
		$aAddrss = $record->customer_name .', '.$record->c_address_1 .', '.(!empty($record->c_address_2) ? $record->c_address_2 .', ' : '').$record->c_city . (isset($record->state_name) ? ', '.$record->state_name . ' '.$record->c_zip : ''). (isset($record->country_code) ? ', '.$record->country_code : ''). (isset($record->c_phone) ? ', Phone:'.$record->c_phone : '');
	?> 
	<tr>
		<td class="text-center">
			<a href="javascript:void(0);" title="Select" onclick="chooseVendor('<?php echo $postData['mainid'];?>', '<?php echo $postData['subid']; ?>', '<?php echo $postData['parentid']; ?>', <?php echo $record->customer_id;?>,'<?php echo $record->customer_number; ?>', '<?php echo $record->customer_name; ?>', '<?php echo $record->account_no; ?>', this);" data-title="<?php echo $aAddrss; ?>">Select</a>
		</td> 
		<td><?php echo $record->customer_number ?></td>
		<td><?php echo $record->customer_name ?></td>
		<td><?php echo $record->c_address_1 ?></td>
		<td><?php echo $record->c_city ?></td>
		<td><?php echo (!empty($record->c_phone) ? $record->c_phone : '-'); ?></td>
		
	</tr> 
	<?php
		}
	}else{
		echo '<tr ><td colspan="5">No Data Found</td><tr>';
	}
	?>
  </table>

<div id="pagination"><?php echo $this->ajax_pagination->create_links(); ?></div> 