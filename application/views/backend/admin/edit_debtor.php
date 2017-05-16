<?php 
$single_debtor_info = $this->db->get_where('creditcustomers', array('CustomerId' => $param2))->result_array();
foreach ($single_debtor_info as $row) {
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

                    <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/mngdebtor/update/<?php echo $row['CustomerId']; ?>" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('customer_id'); ?></label>

                            <div class="col-sm-5">
                                <input disabled type="text" name="id" class="form-control" id="field-1" value="<?php echo $row['CustomerId']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('customer_name'); ?></label>

                            <div class="col-sm-9">
                                <input type="text" name="name" class="form-control" id="field-1" value="<?php echo $row['CustomerName']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('telephone'); ?></label>

                            <div class="col-sm-9">
                                <input type="text" name="phone" class="form-control" id="field-1" value="<?php echo $row['Tel']; ?>">
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('smart_compatible'); ?></label>

                            <div class="col-sm-5">
                                <input id="smartcomp" name="smartcomp" type="checkbox" <?php if ($row["SmartComp"]==1) echo 'checked'?> value="<?php if ($row["SmartComp"]==1) echo "1"; else echo "0";?>"></input>
                            </div>
                            
                        </div>
                        <div class="col-sm-3 control-label col-sm-offset-2">
                            <input type="submit" class="btn btn-success" value="Update">
                        </div>
                        <input name="cpid" type="hidden" value="<?php echo $row['cpid']; ?>"></input>
                    </form>

                </div>

            </div>

        </div>
    </div>
   
<?php } ?>

<script type="text/javascript">
    $("#smartcomp").on("change",function(){
        var v = $(this).val();
        $(this).val((v=="0")?"1":"0");
    });
</script>