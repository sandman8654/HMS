<?php
    $id = $param2;
    $row = $this->db->get_where("inpatient_nursing_cardex", array("id"=>$id))->result_array()[0];
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_nursing_cardex_for_inpatient'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/inpatients/update/<?php echo $id ?>/cardex" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('date'); ?></label>
                        <div class="col-sm-5">
                            <input required type="date"  name="date" class="form-control" value="<?php echo $row["date"]; ?>"></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('time'); ?></label>
                        <div class="col-sm-5">
                            <input type="time" name="time" class="form-control" id="field-1" value="<?php echo $row["time"]; ?>"></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('note'); ?></label>
                        <div class="col-sm-5">
                            <textarea name="note" class="form-control"><?php echo $row["note"]; ?></textarea>
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