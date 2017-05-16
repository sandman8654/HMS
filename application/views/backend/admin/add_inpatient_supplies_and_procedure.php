<?php
    $patient_id = $param2;
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_supplies_and_procedure_for_inpatient'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/inpatients/create/<?php echo $patient_id ?>/supandproc" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('date'); ?></label>

                        <div class="col-sm-5">
                            <input required type="date"  name="date" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Sterile_gloves'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="sg" class="form-control" id="field-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Catheter'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="cath" class="form-control" id="field-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Urine_bag'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="ub" class="form-control" id="field-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Branula'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="bra" class="form-control" id="field-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Fluid_I.V._giving_set'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="fivgs" class="form-control" id="field-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Blood_giving_set'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="bgs" class="form-control" id="field-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Blood_bag'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="bb" class="form-control" id="field-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('N.G._Tube'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="ngt" class="form-control" id="field-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Sulfratule'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="sulf" class="form-control" id="field-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('I.V._fluids'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="ivf" class="form-control" id="field-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Dressing'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="dres" class="form-control" id="field-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('R.O.S'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="ros" class="form-control" id="field-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Catheterization'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="cathz" class="form-control" id="field-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('HB'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="hb" class="form-control" id="field-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Blood_sugar'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="bs" class="form-control" id="field-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Physiotherapy'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="phys" class="form-control" id="field-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Occupational_Therapy'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="ot" class="form-control" id="field-1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Others'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="other" class="form-control" id="field-1">
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