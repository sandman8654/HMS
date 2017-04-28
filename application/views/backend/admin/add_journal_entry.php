<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_journal_entry'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/journalentry/create" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Debit_SubLedger:'); ?></label>

                        <div class="col-sm-5">
                            <?php 
                                $ledger_list = $this->db->query("select * from ledgers where ledgerid!=601 order by name");
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Credit_SubLedger'); ?></label>
                        <div class="col-sm-5">
                            <select name="credit" class="form-control">
                                <option value=""><?php echo get_phrase('select_sex'); ?></option>
                                <option value="male" <?php if ($row['sex'] == 'male')echo 'selected';?>>
                                    <?php echo get_phrase('male'); ?>
                                </option>
                                <option value="female" <?php if ($row['sex'] == 'female')echo 'selected';?>>
                                    <?php echo get_phrase('female'); ?>
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('amount:'); ?></label>

                        <div class="col-sm-5">
                            <input type="text" name="amount" class="form-control" id="amount" >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('note:'); ?></label>

                        <div class="col-sm-9">
                            <textarea name="address" class="form-control" id="field-ta"></textarea>
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