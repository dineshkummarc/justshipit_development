
<center><div id="resultChargedata"></div></center>

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
				if(!empty($aChargeRecords)){
				foreach($aChargeRecords as $key => $aChargeRecord){
			?>
					  <div class="box-body table-responsive no-padding chargecode_demo_tr" id="charge_code_<?php echo $aChargeRecord->p_id;?>">
						<table class="table table-hover"> 

							<tr class="charge_demo_name_div" id="charge_div_name_<?php echo $key;?>">
								<td style="width:150px;" class="charge_code_name_div" id="extracharge_code_name_<?php echo $key;?>">
									<input type="text" class="form-control " value="<?php echo $aChargeRecord->charge_code_name;?>" id="charge_code_name" name="charge_code[charge_code_name][]" maxlength="20" style="width:80%;float:left;" autocomplete="off" onclick="$(this).next('#chargecode_search_url').click();">
									<a href="javascript:void(0);" id="chargecode_search_url" class="pt-2 pl-1" style="display: inline-block;" data-toggle="modal" data-target="#myModal" onclick="loadChargeCode(this);"><i class="fa fa-search"></i></a>
									<input type="hidden" value="<?php echo $aChargeRecord->charge_code_id;?>" id="charge_code_id" name="charge_code[charge_code_id][]">
								</td>
								
								<td>
									<input type="text" class="form-control" value="<?php echo $aChargeRecord->charge_code_description;?>" id="charge_code_description" name="charge_code[charge_code_description][]" maxlength="75">
								</td>
								
								<td>
									<select class="form-control" id="charge_code_rate_basis" name="charge_code[charge_code_rate_basis][]">
										<option value="0">Select</option>
										<?php
										if(!empty($rate_basis))
										{
											foreach ($rate_basis as $rate)
											{
												?>
												<option value="<?php echo $rate['rate_basis_id']; ?>" <?php if($rate['rate_basis_id'] == $aChargeRecord->charge_code_rate_basis) {echo "selected=selected";} ?>><?php echo $rate['rate_basis_name']; ?></option>
												<?php
											}
										}
										?>
									</select>
								</td>
								
								<td>
									<input type="text" class="form-control digits" value="<?php echo $aChargeRecord->charge_code_qty;?>" id="charge_code_qty" name="charge_code[charge_code_qty][]" maxlength="10" onchange="changechargePrices(this);">
								</td>
								
								<td>
									<input type="text" class="form-control number" value="<?php echo $aChargeRecord->charge_code_rate;?>" id="charge_code_rate" name="charge_code[charge_code_rate][]" maxlength="10" onchange="changechargePrices(this);">
								</td>
								
								<td>
									<input type="text" class="form-control number" value="<?php echo $aChargeRecord->charge_code_charge;?>" id="charge_code_charge" name="charge_code[charge_code_charge][]" maxlength="10" onchange="changechargePrices(this);">
								</td>
				
								<td>
									<input type="text" class="form-control number charge_code_total_cost" value="<?php echo $aChargeRecord->charge_code_total_cost;?>" id="charge_code_total_cost" name="charge_code[charge_code_total_cost][]" maxlength="10">
								</td>
								<td>
									<a class="" role="button" onclick="removeChargeCode(<?php echo $aChargeRecord->p_id ?>);">
										<i class="fa fa-remove"></i>
									</a>
								</td>
							</tr>
					  </table>
					</div>
			<?php 
					$totalchargecost = $totalchargecost + $aChargeRecord->charge_code_total_cost;
				}
			}?>		
			
			  <div id="chargecode_total_div"  class="text-center" <?php if(!empty($aChargeRecords)){ }else{ ?> style="display:none;"<?php }?>>
					<input type="button" class="btn btn-default btn-sm" value="Calculate" onclick="calculateChargeCode();"/>
                    <input type="button" class="btn btn-default btn-sm" value="Submit" onclick="addChargeCode();"/>
                    <input type="button" class="btn btn-default btn-sm" value="Reset" />
                    <input type="button" class="btn btn-default btn-sm" value="Cancel" /> 
			  </div> 
			  
			  <div class="col-sm-12 text-right f16">
				Total :$<span id="total_charge_code_cost"><?php echo number_format($totalchargecost, 2); ?></span>
			  </div>