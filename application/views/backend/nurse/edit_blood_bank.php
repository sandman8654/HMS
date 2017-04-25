<?php
$single_blood_bank_info = $this->db->get_where('blood_bank', array('blood_group_id' => $param2))->result_array();
foreach ($single_blood_bank_info as $row) {
?>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo get_phrase('edit_blood_bank'); ?></h3>
                    </div>
                </div>

                <div class="panel-body">

                    <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?nurse/blood_bank/update/<?php echo $row['blood_group_id']; ?>" method="post" enctype="multipart/form-data">
                    
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('blood_group'); ?></label>

                            <div class="col-sm-5">
                                <input type="text" name="blood_group" class="form-control" id="field-1" value="<?php echo $row['blood_group']; ?>" disabled="disabled">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('status'); ?></label>

                            <div class="col-sm-5">
                                <input type="text" name="status" class="form-control" id="field-1" value="<?php echo $row['status']; ?>">
                            </div>
                        </div>

                        <div class="col-sm-3 control-label col-sm-offset-2">
                            <input type="submit" class="btn btn-success" value="Update">
                        </div>
                    </form>

                </div>

            </div>

        </div>
    </div>
<?php } ?>