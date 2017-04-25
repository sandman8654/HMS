<?php
$single_notice_info = $this->db->get_where('notice', array('notice_id' => $param2))->result_array();
foreach ($single_notice_info as $row) {
?>

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo get_phrase('edit_notice'); ?></h3>
                    </div>
                </div>

                <div class="panel-body">

                    <form class="form-horizontal form-groups-bordered" role="form" method="post"
                        action="<?php echo base_url(); ?>index.php?admin/notice/update/<?php echo $row['notice_id']; ?>" 
                        enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('title'); ?></label>

                            <div class="col-sm-5">
                                <input type="text" name="title" class="form-control" id="field-1" value="<?php echo $row['title']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('description'); ?></label>

                            <div class="col-sm-9">
                                <textarea name="description" class="form-control" 
                                    id="field-ta"><?php echo $row['description']; ?></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('start_date'); ?></label>

                            <div class="col-sm-7">
                                <div class="date-and-time">
                                    <input type="text" name="start_timestamp" class="form-control datepicker" data-format="D, dd MM yyyy" 
                                        placeholder="date here" value="<?php echo date("D, d M Y", $row['start_timestamp']); ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('end_date'); ?></label>

                            <div class="col-sm-7">
                                <div class="date-and-time">
                                    <input type="text" name="end_timestamp" class="form-control datepicker" data-format="D, dd MM yyyy" 
                                        placeholder="date here" value="<?php echo date("D, d M Y", $row['end_timestamp']); ?>">
                                </div>
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