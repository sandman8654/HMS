
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo get_phrase('edit_debtor'); ?></h3>
                    </div>
                </div>

                <div class="panel-body">

                    <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/mngscheme/create" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('company_name'); ?></label>
                            <div class="col-sm-9">
                                <select  name="cpid" class="form-control" placeholder="<?php echo get_phrase('type_search_company');?>" required>
                                    <option value=""><?php echo get_phrase('type_search_company'); ?></option>
                                    <?php 
                                        $all_items_info= $this->db->get('creditcustomers')->result_array();
                                        foreach ($all_items_info as $item){ ?>
                                        <option value=<?php echo $item['CustomerId']; ?>><?php echo $item['CustomerName']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('scheme_name'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" name="schname" class="form-control" id="field-1" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('telephone'); ?></label>

                            <div class="col-sm-9">
                                <input type="text" name="tel" class="form-control" id="field-1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('co-pay_status'); ?></label>

                            <div class="col-sm-5">
                                <input  id="cpstatus" name="cpstatus" type="checkbox"  value="0"></input>
                            </div>
                        </div>
                      
                        <div class="col-sm-3 control-label col-sm-offset-2">
                            <input type="submit" class="btn btn-success" value="Add">
                        </div>
                        <input type="hidden" name="cptype" value=" ">
                        <input type="hidden" name="cpam" value="0">
                    </form>

                </div>

            </div>

        </div>
    </div>

<script type="text/javascript">
    $("#cpstatus").on("change",function(){
        var v = $(this).val();
        $(this).val((v=="0")?"1":"0");
    });
</script>