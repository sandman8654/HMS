<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_ledger'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/ledgerspanel/create" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('ledger_no'); ?></label>

                        <div class="col-sm-5">
                            <input type="text" disabled name="name" class="form-control" id="field-1" value="auto number" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('ledger_name'); ?></label>

                        <div class="col-sm-5">
                            <input type="text" name="name" class="form-control" id="field-1" required >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('type'); ?></label>

                        <div class="col-sm-5">
                            <select name="type" class="form-control">
                                <option value="Asset"><?php echo get_phrase('asset');?></option>
                                <option value="Expense"><?php echo get_phrase('expense');?></option>
                                <option value="Liability"><?php echo get_phrase('liability');?></option>
                                <option value="Revenue"><?php echo get_phrase('revenue');?></option>
                                <option value="Equity"><?php echo get_phrase('equity');?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Category'); ?></label>

                        <div class="col-sm-5">
                            <select name="category" class="form-control">
                                <option value="Other"><?php echo get_phrase('other');?></option>
                                <option value="Cashier"><?php echo get_phrase('Cashier');?></option>
                                <option value="Bank"><?php echo get_phrase('bank');?></option>
                                <option value="Extmedics"><?php echo get_phrase('extmedic');?></option>
                                <option value="Insurance"><?php echo get_phrase('insurance');?></option>
                            </select>
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