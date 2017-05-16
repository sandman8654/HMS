<?php
    $id = $param2;
    $row = $this->db->get_where("inpatient_measure_4hourly_temp", array("id"=>$id))->result_array()[0];
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('edit_four_hourly_temperature_for_inpatient'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/inpatients/update/<?php echo $id ?>/hourlytemp" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('date'); ?></label>
                        <div class="col-sm-9">
                            <input required type="date"  name="date" class="form-control" value="<?php echo $row["date"];?>"></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('time'); ?></label>
                        <div class="col-sm-9">
                            <select required name="time" class="form-control">
                                <option value=""><?php echo get_phrase('select_time'); ?></option>
                                <option value="3" <?php if($row["time"]==3) echo 'selected'?> ><?php echo get_phrase('3_:_AM'); ?></option>
                                <option value="7" <?php if($row["time"]==3) echo 'selected'?>><?php echo get_phrase('7_:_AM'); ?></option>
                                <option value="11" <?php if($row["time"]==3) echo 'selected'?>><?php echo get_phrase('11_:_AM'); ?></option>
                                <option value="15" <?php if($row["time"]==3) echo 'selected'?>><?php echo get_phrase('3_:_PM'); ?></option>
                                <option value="19" <?php if($row["time"]==3) echo 'selected'?>><?php echo get_phrase('7_:_PM'); ?></option>
                                <option value="23" <?php if($row["time"]==3) echo 'selected'?>><?php echo get_phrase('11_:_PM'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Temperature'); ?></label>
                        <div class="col-sm-9">
                            <input type="text" name="temp" class="form-control" value="<?php echo $row["temp"];?>"></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('pulse'); ?></label>
                        <div class="col-sm-9">
                            <input type="text" name="pulse" class="form-control" value="<?php echo $row["pulse"];?>"></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('RESP.'); ?></label>
                        <div class="col-sm-9">
                            <input type="text" name="resp" class="form-control" value="<?php echo $row["resp"];?>"></input>                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Bowels'); ?></label>
                        <div class="col-sm-9">
                            <input type="text" name="bowels" class="form-control" value="<?php echo $row["bowels"];?>"></input>                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('urine'); ?></label>
                        <div class="col-sm-9">
                            <input type="text" name="urine" class="form-control" value="<?php echo $row["urine"];?>"></input>                                                        
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