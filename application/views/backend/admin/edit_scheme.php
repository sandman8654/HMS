<?php 
$single_scheme_info = $this->crud_model->get_scheme_info($param2);
foreach ($single_scheme_info as $row) {
?>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo get_phrase('edit_debtor'); ?></h3>
                    </div>
                </div>

                <div class="panel-body">

                    <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/mngscheme/update/<?php echo $row['id']; ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('company_name'); ?></label>
                            <div class="col-sm-9">
                                <input disabled type="text" name="cpname" class="form-control" id="field-1" value="<?php echo $row['cpname']; ?>">
                                <input type="hidden" name="cpid" value="<?php echo $row['cpid']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('scheme_name'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" name="schname" class="form-control" id="field-1" value="<?php echo $row['schname']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('telephone'); ?></label>

                            <div class="col-sm-9">
                                <input type="text" name="tel" class="form-control" id="field-1" value="<?php echo $row['tel']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('smart_compatible'); ?></label>

                            <div class="col-sm-5">
                                <input disabled id="smartcomp" name="smartcomp" type="checkbox" <?php if ($row["smartstatus"]==1) echo 'checked'?> ></input>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('co-pay_status'); ?></label>

                            <div class="col-sm-5">
                                <input  id="cpstatus" name="cpstatus" type="checkbox" <?php if ($row["cpstatus"]==1) echo 'checked'?> value="<?php if ($row["SmartComp"]==1) echo "1"; else echo "0";?>"></input>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('co-pay_status'); ?></label>
                            <div class="col-sm-5">
                                <select name="cptype" class="form-control">
                                    <option value="" <?php if ($row['cptype']=="") echo "selected"; ?> ><?php echo get_phrase('');?></option>
                                    <option value="%" <?php if ($row['cptype']=="%") echo "selected"; ?> ><?php echo get_phrase('%');?></option>
                                    <option value="kshs" <?php if ($row['cptype']=="kshs") echo "selected"; ?> ><?php echo get_phrase('kshs');?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('Co-Pay_amount'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" name="cpam" class="form-control" id="field-1" value="<?php echo $row['cpam']; ?>">
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

<script type="text/javascript">
    $("#cpstatus").on("change",function(){
        var v = $(this).val();
        $(this).val((v=="0")?"1":"0");
    });
</script>