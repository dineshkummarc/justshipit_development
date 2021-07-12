<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-plane"></i> Domestic Shipments
      </h1>
    </section>
    <section class="content"> 
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addDomesticShipment"><i class="fa fa-plus"></i> Add New Domestic Shipments</a> 
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Domestic Shipments </h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>domesticShipment" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search by File No, House Bill"/>
                              <input type="text" name="searchCode" value="<?php echo $searchCode; ?>" class="form-control input-sm pull-right mr-2" style="width: 150px;" placeholder="Airport Code"/>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        <th></th>
                        <th>File No</th>
                        <th>HD</th>
                        <th>House Bill</th>
                        <th>Org</th>
                        <th>Dest</th>
                        <th>Shipper</th>
                        <th>Consignee</th>
                        <th>Ship Date</th>
                        <th>Ship Time</th>
                        <th>Close Time</th>
                        <th>Sv</th>
                        <th>Sch Date</th>
                        <th>Sch Time</th>
                        <th>Sts</th>
                        <th class="text-center">Print HAWB/Label</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php
                    if(!empty($domesticRecords))
                    {
                        foreach($domesticRecords as $record)
                        {
                    ?> 
                    <tr>
                        <td class="w150">
							<a href="<?php echo base_url().'editDomesticShipment/'.$record['shipment_id']; ?>" title="Edit Shipment">Select</a> &nbsp;
							
							<a href="<?php echo base_url().'editDomesticShipment/'.$record['shipment_id'].'?showtab=cost-tab'; ?>"><i class="fa fa-dollar" style="color:#d73925;"></i></a> &nbsp; 
							
							<a href="<?php echo base_url().'editDomesticShipment/'.$record['shipment_id'].'?showtab=documents-tab'; ?>"><i class="fa fa-file-text" style="color:#008d4c;"></i></a> &nbsp; 
							
							<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" onclick="loadCloneOption(<?php echo $record['shipment_id']; ?>);">Clone</a> 
						</td>
                        <td> <a href="<?php echo base_url().'editDomesticShipment/'.$record['shipment_id']; ?>" title="Edit"><?php echo $record['file_number'] ?></a></td>
                        <td><?php echo $record['station'] ?></td>
                        <td><?php echo $record['waybill'] ?></td>
                        <td><?php echo $record['origin_airport_code'] ?></td>
                        <td><?php echo $record['dest_airport_code'] ?></td>
                        <td><?php echo $record['shipper_data']['shipper_name'] ?></td>
                        <td><?php echo $record['consignee_data']['c_shipper_name'] ?></td>
                        <td><?php echo date("m-d-Y", strtotime($record['ready_date_time'])) ?></td>
                        <td><?php echo date("H:i", strtotime($record['ready_date_time'])) ?></td>
						<td><?php echo date("H:i", strtotime($record['close_date_time'])) ?></td>
						<td><?php echo $record['service_name'] ?></td>
                        <td><?php echo date("m-d-Y", strtotime($record['schedule_date_time'])) ?></td>
                        <td><?php echo date("H:i", strtotime($record['schedule_date_time'])) ?></td>
                        <td><?php echo $record['status_name'] ?></td>
                        <td class="text-center">
							<input class="form-check-input" type="checkbox" value="<?php echo $record['shipment_id'] ?>" name="hawb[]" id="hawb"> &nbsp;
							
							<input class="form-check-input" type="checkbox" value="<?php echo $record['shipment_id'] ?>" name="plabel[]" id="plabel"> &nbsp;
						</td>
                        <td>
							<a class="deleteDomesticShipment" href="#" data-shipment_id="<?php echo $record['shipment_id']; ?>" title="Delete"><i class="fa fa-times"></i></a>
						</td>
                        <td>
							<a class="" href="<?php echo base_url().'dominvoicepdf/'.$record['shipment_id']; ?>" target="_blank"><i class="fa fa-file"></i></a>
						</td>
                        <td></td> 
                       
                    </tr>
                    <?php
                        }
                    }else{
						echo '<tr ><td colspan="19">No Data Found</td><tr>';
					}
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "domesticShipment/" + value);
            jQuery("#searchList").submit();
        });
    });
	function loadCloneOption(did){
		$.ajax({
			type: "POST",
			url: baseURL+'loadCloneOption',
			data: "shipment_id="+did,
			success: function (response) {
				$(".displaycontentpopup").html(response);
			}
		});
	}
</script> 
