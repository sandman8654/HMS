<?php
    $id = $param2;
    $row = $this->db->get_where("inpatient_fluid_balance", array("id"=>$id))->result_array()[0];
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('edit_blood_press_for_inpatient'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/inpatients/update/<?php echo $id ?>/fluidbalchart" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('date'); ?></label>
                        <div class="col-sm-9">
                            <input required type="date"  name="date" class="form-control" value="<?php echo $row['date']; ?>"></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('time'); ?></label>
                        <div class="col-sm-9">
                            <input required type="time" name="time" class="form-control" value="<?php echo $row['time']; ?>"></input>
                        </div>
                    </div>
                    <h4><?php echo get_phrase('input'); ?></h4>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('fluid_type'); ?></label>
                        <div class="col-sm-9">
                            <input type="text" name="inftype" class="form-control" value="<?php echo $row['input_fluid_type']; ?>"></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('amount'); ?></label>
                        <div class="col-sm-9">
                            <input type="text" name="inamount" class="form-control" value="<?php echo $row['input_fluid_amount']; ?>"></input>
                        </div>
                    </div>
                    <h4><?php echo get_phrase('output'); ?></h4>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('fluid_type'); ?></label>
                        <div class="col-sm-9">
                            <input type="text" name="outftype" class="form-control" value="<?php echo $row['output_fluid_type']; ?>"></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('amount'); ?></label>
                        <div class="col-sm-9">
                            <input type="text" name="outamount" class="form-control" value="<?php echo $row['output_fluid_amount']; ?>"></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('comment'); ?></label>
                        <div class="col-sm-9">
                            <textarea name="comment" class="form-control" ><?php echo $row['comment']; ?>"</textarea>
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