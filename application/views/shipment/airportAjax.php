 <table class="table table-hover">
		<tr>
			<th class="text-center">Actions</th>
			<th>Airport Code</th>
			<th>Airport Name</th>
			<th>City</th>
			<th>State</th>
			
		</tr>
		<?php
		if(!empty($aRecords))
		{
			foreach($aRecords as $record)
			{
		?> 
		<tr>
			<td class="text-center">
				<a href="javascript:void(0);" title="Select" onclick="chooseAirport(<?php echo $record->airport_id;?>,'<?php echo $record->airport_code; ?>', '<?php echo $postData['mainid'];?>', '<?php echo $postData['subid']; ?>', '<?php echo $postData['parentid']; ?>');">Select</a>
			</td> 
			<td><?php echo $record->airport_code ?></td>
			<td><?php echo $record->airport_name ?></td>
			<td><?php echo $record->city ?></td>
			<td><?php echo $record->state ?></td>
			
		</tr>
		<?php
			}
		}
		?>
</table>

<div id="pagination"><?php echo $this->ajax_pagination->create_links(); ?></div>  