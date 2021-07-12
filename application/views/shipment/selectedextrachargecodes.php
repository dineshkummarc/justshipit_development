<center><div id="resultextraChargedata"></div></center>
					
					<table class="table table-hover">
						<tr class="bg-info">
							<th style="width:150px;">Charge Code</th>
							<th>Description</th>
							<th>Rate Basis</th>
							<th>Quantity</th>
							<th>Rate</th>
							<th class="text-right">Charge</th>
							<th class="text-right">Total Charge</th>
							<th class="text-right"></th>
						</tr>
				  </table>
				  
				  
				<?php 
					$totalchargecost = 0;
					if(!empty($aRecords)){
					foreach($aRecords as $key => $aRecord){
				?>
						  <div class="box-body table-responsive no-padding extrachargecode_demo_tr" id="extracharge_code_<?php echo $aRecord->c_id;?>">
							<table class="table table-hover">

								<tr class="extracharge_demo_name_div" id="extracharge_div_name_<?php echo $key;?>">
									<td style="width:150px;" class="charge_code_name_div" id="charge_code_name_<?php echo $key;?>">
										<input type="text" class="form-control " value="<?php echo $aRecord->charge_code_name;?>" id="charge_code_name" name="extracharge_code[charge_code_name][]" maxlength="20" style="width:80%;float:left;" autocomplete="off" onclick="$(this).next('#extrachargecode_search_url').click();">
										<a href="javascript:void(0);" id="extrachargecode_search_url" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModaloverlap2" onclick="loadExtraChargeCode(this);"><i class="fa fa-search"></i></a>
										<input type="hidden" value="<?php echo $aRecord->charge_code_id;?>" id="charge_code_id" name="extracharge_code[charge_code_id][]">
									</td>
									
									<td>
										<input type="text" class="form-control" value="<?php echo $aRecord->charge_code_description;?>" id="charge_code_description" name="extracharge_code[charge_code_description][]" maxlength="75">
									</td>
									
									<td>
										<select class="form-control" id="charge_code_rate_basis" name="extracharge_code[charge_code_rate_basis][]">
											<option value="0">Select</option>
											<?php
											if(!empty($rate_basis))
											{
												foreach ($rate_basis as $rate)
												{
													?>
													<option value="<?php echo $rate['rate_basis_id']; ?>" <?php if($rate['rate_basis_id'] == $aRecord->charge_code_rate_basis) {echo "selected=selected";} ?>><?php echo $rate['rate_basis_name']; ?></option>
													<?php
												}
											}
											?>
										</select>
									</td>
									
									<td>
										<input type="text" class="form-control digits" value="<?php echo $aRecord->charge_code_qty;?>" id="charge_code_qty" name="extracharge_code[charge_code_qty][]" maxlength="10" onchange="changeExtrachargePrices(this);">
									</td>
									
									<td>
										<input type="text" class="form-control digits" value="<?php echo $aRecord->charge_code_rate;?>" id="charge_code_rate" name="extracharge_code[charge_code_rate][]" maxlength="10" onchange="changeExtrachargePrices(this);">
									</td>
									
									<td>
										<input type="text" class="form-control digits" value="<?php echo $aRecord->charge_code_charge;?>" id="charge_code_charge" name="extracharge_code[charge_code_charge][]" maxlength="10" onchange="changeExtrachargePrices(this);">
									</td>
					
									<td>
										<input type="text" class="form-control digits extracharge_code_total_cost" value="<?php echo $aRecord->charge_code_total_cost;?>" id="charge_code_total_cost" name="extracharge_code[charge_code_total_cost][]" maxlength="10">
									</td>
									<td>
										<a class="" role="button" onclick="removeExtraChargeCode(<?php echo $aRecord->c_id ?>);">
											<i class="fa fa-remove"></i>
										</a>
									</td>
								</tr>
						  </table>
						</div>
				<?php 
						$totalchargecost = $totalchargecost + $aRecord->charge_code_total_cost;
					}
				}?>		
				
				  <div id="extrachargecode_total_div"  class="text-center" <?php if(!empty($aRecords)){ }else{ ?> style="display:none;"<?php }?>>
						<input type="button" class="btn btn-default btn-sm" value="Calculate" onclick="calculateextraChargeCode();"/>
						<input type="button" class="btn btn-default btn-sm" value="Submit" onclick="addExtraChargeCode();"/>
				  </div> 
				  
				  <div class="col-sm-12 text-right f16">
					Total :$<span id="total_extracharge_code_cost"><?php echo number_format($totalchargecost, 2); ?></span>
				  </div>