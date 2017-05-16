<?php
$single_bed_info = $this->db->get_where('bed', array('bed_id' => $param2))->result_array();
foreach ($single_bed_info as $row) {
?>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo get_phrase('edit_bed'); ?></h3>
                    </div>
                </div>

                <div class="panel-body">

                    <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/bed/update/<?php echo $row['bed_id']; ?>" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('bed_number'); ?></label>

                            <div class="col-sm-5">
                                <input type="number" name="bed_number" class="form-control" id="field-1" value="<?php echo $row['bed_number']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('room_number'); ?></label>

                            <div class="col-sm-5">
                                <input type="text" name="room_number" class="form-control" id="field-1" value="<?php echo $row['room_no']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('type'); ?></label>

                            <div class="col-sm-5">
                                <select name="type" class="form-control">
                                    <option value="Male Ward" <?php if ($row['type'] == 'Male Ward')echo 'selected';?>>
                                        <?php echo get_phrase('male_ward'); ?>
                                    </option>
                                    <option value="Female Ward" <?php if ($row['type'] == 'Female Ward')echo 'selected';?>>
                                        <?php echo get_phrase('female_ward'); ?>
                                    </option>
                                    <option value="Paediatrics" <?php if ($row['type'] == 'Paediatrics')echo 'selected';?>>
                                        <?php echo get_phrase('paediatrics'); ?>
                                    </option>
                                    <option value="Maternity" <?php if ($row['type'] == 'Maternity')echo 'selected';?>>
                                        <?php echo get_phrase('maternity'); ?>
                                    </option>
                                    <option value="Cabin" <?php if ($row['type'] == 'Cabin')echo 'selected';?>>
                                        <?php echo get_phrase('cabin'); ?>
                                    </option>
                                    <option value="ICU" <?php if ($row['type'] == 'ICU')echo 'selected';?>>
                                        <?php echo get_phrase('icu'); ?>
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('description'); ?></label>

                            <div class="col-sm-9">
                                <textarea name="description" class="form-control"
                                          id="field-ta"><?php echo $row['description']; ?></textarea>
                            </div>
                        </div>

                        <div class="col-sm-3 control-label col-sm-offset-1">
                            <input type="submit" class="btn btn-success" value="Update">
                        </div>
                    </form>

                </div>

            </div>

        </div>
    </div>
<?php } ?>