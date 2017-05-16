<?php
$single_ledger_info = $this->db->get_where('ledgers', array('ledgerid' => $param2))->result_array();
foreach ($single_ledger_info as $row) {
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_ledger'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/ledgerspanel/update/<?php echo $row['ledgerid']; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('ledger_no'); ?></label>

                        <div class="col-sm-5">
                            <input type="text" disabled name="ledgerid" class="form-control" id="field-1" value="<?php echo $row['ledgerid']; ?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('ledger_name'); ?></label>

                        <div class="col-sm-5">
                            <input type="text" name="name" class="form-control" id="field-1" required value="<?php echo $row['name']; ?>" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('type'); ?></label>

                        <div class="col-sm-5">
                            <select name="type" class="form-control">
                                <option value="Asset" <?php if ($row['type']=="Asset") echo "selected"; ?> ><?php echo get_phrase('asset');?></option>
                                <option value="Expense" <?php if ($row['type']=="Expense") echo "selected"; ?> ><?php echo get_phrase('expense');?></option>
                                <option value="Liability" <?php if ($row['type']=="Liability") echo "selected"; ?> ><?php echo get_phrase('liability');?></option>
                                <option value="Revenue" <?php if ($row['type']=="Revenue") echo "selected"; ?> ><?php echo get_phrase('revenue');?></option>
                                <option value="Equity" <?php if ($row['type']=="Equity") echo "selected"; ?> ><?php echo get_phrase('equity');?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Category'); ?></label>

                        <div class="col-sm-5">
                            <select name="category" class="form-control">
                                <option value="Other" <?php if ($row['category']=="Other") echo "selected"; ?> ><?php echo get_phrase('other');?></option>
                                <option value="Cashier" <?php if ($row['category']=="Cashier") echo "selected"; ?> ><?php echo get_phrase('Cashier');?></option>
                                <option value="Bank" <?php if ($row['category']=="Bank") echo "selected"; ?> ><?php echo get_phrase('bank');?></option>
                                <option value="Extmedics" <?php if ($row['category']=="Extmedics") echo "selected"; ?> ><?php echo get_phrase('extmedic');?></option>
                                <option value="Insurance" <?php if ($row['category']=="Insurance") echo "selected"; ?> ><?php echo get_phrase('insurance');?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('balance'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="balance" class="form-control" id="field-1" required value="<?php echo $row['bal']; ?>" >
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
<?php } ?>
<script type="text/javascript">
    jQuery(window).load(function (){   
        
            $=jQuery;
            $("input[type='smartcomp']").click(function(){
                var v = $(this).val();
                alert(v);
                $(this).val((v=="0")?"1":"0");
            })
    })
</script>