


  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

             <span aria-hidden="true">&times;</span>

        </button>
        <h4 class="modal-title"><?php echo $popup_title; ?></h4>
      </div>
      <div class="modal-body">
			<div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr class="bg-info">
                        <th></th>
                        <th>Charge/Cost Code</th>
                        <th>Description</th>
                        <th>Rate</th>
                        <th>Min</th>
                        <th class="text-center">Max</th>
                    </tr>
                    <?php
                    if(!empty($aRecords))
                    {
                        foreach($aRecords as $record)
                        {
                    ?> 
                    <tr>
                        <td><a href="javascript:void(0);" onclick="chooseChargeCode(<?php echo $record->charge_id;?>,'<?php echo $record->charge_code; ?>', '<?php echo $postData['idname'];?>', '<?php echo $record->description;?>');">Select</a></td>
                        <td><?php echo $record->charge_code ?></td>
                        <td><?php echo $record->description ?></td>
                        <td><?php echo $record->rate ?></td>
                        <td><?php echo $record->min_price ?></td>
                        <td><?php echo $record->max_price ?></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
      </div>
    </div>
  </div>

