<?php
    $id = $param2;
    $row = $this->db->get_where("inpatient_nursing_care_plan", array("id"=>$id))->result_array()[0];
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('edit_nursing_care_plan_for_inpatient'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/inpatients/update/<?php echo $id ?>/careplan" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('date'); ?></label>
                        <div class="col-sm-9">
                            <input required type="date"  name="date" class="form-control" value="<?php echo $row["date"];?>"></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('assessment'); ?></label>
                        <div class="col-sm-9">
                            <textarea name="assessment" class="form-control" ><?php echo $row["assessment"];?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('nursing_diagnosis'); ?></label>
                        <div class="col-sm-9">
                            <textarea name="diagnosis" class="form-control" ><?php echo $row["diagnosis"];?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('goal_expected'); ?></label>
                        <div class="col-sm-9">
                            <textarea name="goal" class="form-control" ><?php echo $row["goal"];?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('nursing_intervention'); ?></label>
                        <div class="col-sm-9">
                            <textarea name="intervention" class="form-control" ><?php echo $row["intervention"];?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('evaluation'); ?></label>
                        <div class="col-sm-9">
                            <textarea name="evaluation" class="form-control" ><?php echo $row["evaluation"];?></textarea>
                        </div>
                    </div>
                    <div class="col-sm-3 control-label col-sm-offset-2">
                        <input type="submit" class="btn btn-success" value="Submit"></input>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>