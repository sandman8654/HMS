    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo get_phrase('add_creditor'); ?></h3>
                    </div>
                </div>

                <div class="panel-body">

                    <form role="form" class="form-horizontal form-groups-bordered" action="<?php echo base_url(); ?>index.php?admin/mngcreditor/create" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('customer_id'); ?></label>

                            <div class="col-sm-5">
                                <input disabled type="text" name="id" class="form-control" id="field-1" value="auto">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('creditor_name'); ?></label>

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
                        <div class="col-sm-3 control-label col-sm-offset-2">
                            <input type="submit" class="btn btn-success" value="Update">
                        </div>
                    </form>

                </div>

            </div>

        </div>
    </div>
