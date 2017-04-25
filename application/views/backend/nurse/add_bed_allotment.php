<?php 
$bed_info = $this->db->get('bed')->result_array();
$patient_info = $this->db->get('patient')->result_array(); 
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_bed_allotment'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?nurse/bed_allotment/create" method="post" enctype="multipart/form-data">
                    
                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('bed_number'); ?></label>

                        <div class="col-sm-5">
                            <select name="bed_id" class="form-control">
                                <option value=""><?php echo get_phrase('select_bed_number'); ?></option>
                                <?php foreach ($bed_info as $row) { ?>
                                    <option value="<?php echo $row['bed_id']; ?>"><?php echo $row['bed_number'] .' - '.$row['type'] ; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('patient'); ?></label>

                        <div class="col-sm-5">
                            <select name="patient_id" class="form-control">
                                <option value=""><?php echo get_phrase('select_patient'); ?></option>
                                <?php foreach ($patient_info as $row) { ?>
                                    <option value="<?php echo $row['patient_id']; ?>"><?php echo $row['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('allotment_time'); ?></label>

                        <div class="col-sm-5">
                            <input type="text" name="allotment_timestamp" class="form-control datepicker" id="field-1" >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('discharge_time'); ?></label>

                        <div class="col-sm-5">
                            <input type="text" name="discharge_timestamp" class="form-control datepicker" id="field-1" >
                        </div>
                    </div>

                    <div class="col-sm-3 control-label col-sm-offset-2">
                        <input type="submit" class="btn btn-success" value="Submit">
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>