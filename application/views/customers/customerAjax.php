<table class="table table-hover">
	<tr>
		<th class="text-center">
			Actions
			<input type='hidden' id='c_sort' value='desc'>
		</th>
		<th style="width:120px;"><span onclick='sortCustomerTable("customer_id");' style="cursor:pointer;">Customer Id <i class="fa fa-arrows-v"></i></span></th>
		<th><span onclick='sortCustomerTable("customer_name");' style="cursor:pointer;">Name <i class="fa fa-arrows-v"></i></span></th>
		<th><span onclick='sortCustomerTable("c_address_1");' style="cursor:pointer;">Address <i class="fa fa-arrows-v"></i></span></th>
		<th><span onclick='sortCustomerTable("c_city");' style="cursor:pointer;">City <i class="fa fa-arrows-v"></i></span></th>
	</tr>
	<?php
	if(!empty($customerRecords))
	{
		foreach($customerRecords as $record)
		{
	?> 
	<tr>
		<td class="text-center">
			<a href="javascript:void(0);" title="Select" onclick="chooseCustomerType(<?php echo $record->customer_id;?>,'<?php echo $record->customer_number; ?>','<?php echo $record->customer_name; ?>');">Select</a>
		</td> 
		<td><?php echo $record->customer_number ?></td>
		<td><?php echo $record->customer_name ?></td>
		<td><?php echo $record->c_address_1 ?></td>
		<td><?php echo $record->c_city ?></td>
		
	</tr>
	<?php
		}
	}
	?>
  </table>

<div id="pagination"><?php echo $this->ajax_pagination->create_links(); ?></div>