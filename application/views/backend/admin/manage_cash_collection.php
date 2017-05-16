<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3 id="test-date"><?php echo get_phrase('cash_collection'); ?></h3>
                </div>
            </div>
            
            <div class="panel-body">
                <div class="col-md-12 col-sm-12">
                    <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/cashcollection/create" method="post" enctype="multipart/form-data" >
                        <div class="col-md-5 col-sm-12 has-right-border" style="height:500px;">
                            <h4 class="add-patient-sub-title"><?php echo get_phrase('cashier'); ?></h4>
                            <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('bank_account:'); ?></label>

                                <div class="col-sm-9">
                                    <select required id="ac_select" name="acid" class="form-control select2" placeholder="<?php echo get_phrase('type_search_term');?>">
                                        <option value=""><?php echo get_phrase('type_search_term'); ?></option>
                                        <optgroup label="<?php echo get_phrase('account'); ?>">
                                            <?php 
                                                $this->db->where("category","Cashier");
                                                $this->db->order_by("name");
                                                $all_items_info= $this->db->get('ledgers')->result_array();
                                                foreach ($all_items_info as $item){ 
                                                    if ($item['ledgerid'] != 705){ ?>
                                                <option value=<?php echo $item['ledgerid']; ?>><?php echo $item['name']; ?></option>
                                            <?php }} ?>
                                        </optgroup>    
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="amount" class="col-sm-3 control-label"><?php echo get_phrase('amount:'); ?></label>

                                <div class="col-sm-9">
                                    <input type="text" name="amount" class="form-control" required placeholder="0" />
                                </div>
                            </div>    
                            <div class="form-group">
                                <label for="note" class="col-sm-3 control-label"><?php echo get_phrase('note:'); ?></label>

                                <div class="col-sm-9">
                                    <textarea name="note" class="form-control" style="height:150px;" ></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 control-label col-sm-offset-2">
                                    <input type="submit" class="btn btn-success btn-md" ></input>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12 " style="height:500px;overflow:auto">
                            <h4 class="add-patient-sub-title"><?php echo get_phrase('CURRENT_ACCOUNT_BALANCE'); ?></h4>
                            <?php 
                                $this->db->where("category","Cashier");
                                $this->db->order_by("bal","desc");
                                $all_items_info= $this->db->get('ledgers')->result_array();
                                foreach ($all_items_info as $item){ ?>
                                <p><?php echo $item['name']." - ".$item['bal']; ?></option>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(window).on("load",function(){
        $=jQuery;
        $("input[name='amount']").ForceNumericOnly();
        $("form").submit(function(){
            var val = eval($("input[name='amount']").val())||0;
            if (val<=0){
                $.alert("Amount posted cannot be negative or zero!","error");
                return false;
            }
        });
    })
</script>