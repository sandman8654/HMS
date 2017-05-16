<?php
    $patient_id = $param2;
    $row = $this->db->get_where("inpatient_other_details",array("patient_id"=>$patient_id))->row();
?>
<div class="row">
    <div class="col-sm-12 col-md-8 col-md-offset-2">
       
        <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/inpatients/update/<?php echo $patient_id; ?>/details" method="post" enctype="multipart/form-data">
            <h4 class="add-patient-sub-title pull-left"><?php echo get_phrase('other_details');?></h4>
            <div class="pull-right" style="margin-bottom:5px;margin-right:30px;">
                <input type="submit" class="btn btn-success" value="Update">
                <a href="<?php echo base_url().'index.php?admin/inpatients';?>" class="btn btn-danger btn-md">Exit</a>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <textarea   name="note" class="form-control" id="field-ta" style="height:300px"><?php echo $row->note; ?></textarea>
                </div>
            </div>
        </form>
    </div>
</div>
